<?php
/**
 * Project: truepathexpress
 * Created by: mrwayne
 * Generated: 2026-02-16
 *
 * NowPayments IPN Webhook Handler
 * Receives payment status notifications from NowPayments
 * Verifies authenticity and updates database accordingly
 */

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../utilities/email_templates.php';
require_once __DIR__ . '/../../config/email.php';

// Log all webhook requests for debugging
$rawPayload = file_get_contents('php://input');
error_log("NowPayments Webhook received: " . $rawPayload);

// Get IPN signature from headers
$ipnSignature = $_SERVER['HTTP_X_NOWPAYMENTS_SIG'] ?? '';

// NowPayments IPN secret key from environment
$ipnSecret = getenv('NOWPAYMENTS_IPN_SECRET');

// Validate IPN secret is configured
if (!$ipnSecret) {
    error_log("NowPayments IPN secret not configured in .env file");
    http_response_code(500);
    exit;
}

// Verify IPN signature
$expectedSignature = hash_hmac('sha512', $rawPayload, $ipnSecret);

if ($ipnSignature !== $expectedSignature) {
    error_log("Invalid IPN signature. Expected: {$expectedSignature}, Got: {$ipnSignature}");
    http_response_code(401);
    echo json_encode(['error' => 'Invalid signature']);
    exit;
}

// Parse webhook payload
$webhookData = json_decode($rawPayload, true);

if (!$webhookData) {
    error_log("Invalid webhook JSON payload");
    http_response_code(400);
    echo json_encode(['error' => 'Invalid payload']);
    exit;
}

try {
    $db = Database::getInstance()->getConnection();

    // Extract payment data
    $paymentId = $webhookData['payment_id'] ?? null;
    $paymentStatus = $webhookData['payment_status'] ?? null;
    $orderId = $webhookData['order_id'] ?? null; // This is our tracking_id
    $actuallyPaid = $webhookData['actually_paid'] ?? null;
    $payCurrency = $webhookData['pay_currency'] ?? null;

    if (!$paymentId || !$paymentStatus) {
        error_log("Missing required webhook fields");
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields']);
        exit;
    }

    // Map NowPayments status to our status
    $statusMapping = [
        'finished' => 'confirmed',
        'confirmed' => 'confirmed',
        'sending' => 'pending',
        'partially_paid' => 'pending',
        'waiting' => 'pending',
        'failed' => 'failed',
        'refunded' => 'failed',
        'expired' => 'expired'
    ];

    $ourStatus = $statusMapping[$paymentStatus] ?? 'pending';

    // Check if this payment has already been confirmed (idempotency check)
    $checkQuery = "
        SELECT payment_status
        FROM transactions
        WHERE payment_id = :payment_id
        LIMIT 1
    ";
    $checkStmt = $db->prepare($checkQuery);
    $checkStmt->execute(['payment_id' => $paymentId]);
    $existingStatus = $checkStmt->fetchColumn();

    // If already confirmed and webhook says confirmed, just return success (idempotent)
    if ($existingStatus === 'confirmed' && $ourStatus === 'confirmed') {
        error_log("Duplicate webhook for already confirmed payment: $paymentId");
        http_response_code(200);
        echo json_encode(['success' => true, 'message' => 'Already processed']);
        exit;
    }

    // Update transaction status
    $updateTransaction = "
        UPDATE transactions
        SET payment_status = :payment_status,
            payment_method = :payment_method,
            updated_at = CURRENT_TIMESTAMP
        WHERE payment_id = :payment_id
    ";

    $stmt = $db->prepare($updateTransaction);
    $stmt->execute([
        'payment_status' => $ourStatus,
        'payment_method' => $payCurrency,
        'payment_id' => $paymentId
    ]);

    // If payment is confirmed, update package payment status
    if ($ourStatus === 'confirmed') {
        // Get transaction details
        $getTransaction = "
            SELECT t.package_id, t.amount, t.payer_email, p.tracking_id, p.package_name
            FROM transactions t
            JOIN packages p ON t.package_id = p.id
            WHERE t.payment_id = :payment_id
            LIMIT 1
        ";

        $stmt = $db->prepare($getTransaction);
        $stmt->execute(['payment_id' => $paymentId]);
        $transaction = $stmt->fetch();

        if ($transaction) {
            // Update package payment status to 'paid'
            $updatePackage = "
                UPDATE packages
                SET payment_status = 'paid',
                    updated_at = CURRENT_TIMESTAMP
                WHERE id = :package_id
            ";

            $stmt = $db->prepare($updatePackage);
            $stmt->execute(['package_id' => $transaction['package_id']]);

            // Send payment confirmation email
            try {
                $emailBody = getPaymentConfirmedEmail(
                    $transaction['payer_email'],
                    $transaction['tracking_id'],
                    $transaction['package_name'],
                    $transaction['amount'],
                    $paymentId
                );

                $mailer = new Mailer();
                $mailer->send(
                    $transaction['payer_email'],
                    'Payment Confirmed - TruePath Express #' . $transaction['tracking_id'],
                    $emailBody
                );

                error_log("Payment confirmation email sent to: " . $transaction['payer_email']);
            } catch (Exception $e) {
                error_log("Failed to send payment confirmation email: " . $e->getMessage());
                // Don't fail webhook processing if email fails
            }

            // Send payment confirmed admin notification
            try {
                $adminEmailBody = getPaymentConfirmedAdminEmail(
                    $transaction['payer_email'],
                    $transaction['tracking_id'],
                    $transaction['package_name'],
                    $transaction['amount'],
                    $paymentId,
                    $payCurrency
                );

                $mailer = new Mailer();
                $adminEmail = getenv('SMTP_FROM') ?: 'support@truepathexpress.com';
                $mailer->send(
                    $adminEmail,
                    'Payment Confirmed - Package #' . $transaction['tracking_id'],
                    $adminEmailBody
                );

                error_log("Payment confirmed admin notification sent to: " . $adminEmail);
            } catch (Exception $e) {
                error_log("Failed to send payment confirmed admin notification: " . $e->getMessage());
                // Don't fail webhook processing if admin email fails
            }

            error_log("Payment confirmed for package ID: " . $transaction['package_id']);
        }
    }

    // Respond with success
    http_response_code(200);
    echo json_encode(['success' => true]);

} catch (PDOException $e) {
    error_log("Webhook database error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
} catch (Exception $e) {
    error_log("Webhook processing error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Processing error']);
}
