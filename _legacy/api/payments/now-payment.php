<?php
/**
 * Project: truepathexpress
 * Created by: mrwayne
 * Generated: 2026-02-16
 *
 * NowPayments Integration API
 * Creates payment invoices and handles payment initiation
 */

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/constants.php';

header('Content-Type: application/json');

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$packageId = $input['package_id'] ?? null;

// Validate package ID
if (empty($packageId)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Package ID is required']);
    exit;
}

try {
    $db = Database::getInstance()->getConnection();

    // Get package details
    $stmt = $db->prepare("
        SELECT id, tracking_id, package_name, amount, email, payment_status
        FROM packages
        WHERE id = :id
        LIMIT 1
    ");
    $stmt->execute(['id' => $packageId]);
    $package = $stmt->fetch();

    if (!$package) {
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'message' => 'Package not found or already paid.',
            'error_code' => 'INVALID_PACKAGE'
        ]);
        exit;
    }

    // Check if already paid
    if ($package['payment_status'] === 'paid') {
        echo json_encode([
            'success' => false,
            'message' => 'This package has already been paid.',
            'error_code' => 'ALREADY_PAID'
        ]);
        exit;
    }

    // NowPayments API credentials from environment
    $apiKey = getenv('NOWPAYMENTS_API_KEY');
    $ipnSecret = getenv('NOWPAYMENTS_IPN_SECRET');

    // Validate credentials are configured
    if (!$apiKey || !$ipnSecret) {
        error_log("NowPayments credentials not configured in .env file");
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Payment system configuration error. Please contact support.',
            'error_code' => 'CONFIG_ERROR'
        ]);
        exit;
    }

    // Create payment invoice with NowPayments
    $invoiceData = [
        'price_amount' => (float)$package['amount'],
        'price_currency' => 'usd',
        'order_id' => $package['tracking_id'],
        'order_description' => 'Payment for package: ' . $package['package_name'],
        'ipn_callback_url' => APP_URL . '/api/webhooks/webhook.php',
        'success_url' => APP_URL . '/tracking?success=1&tracking_id=' . $package['tracking_id'],
        'cancel_url' => APP_URL . '/tracking?cancel=1&tracking_id=' . $package['tracking_id']
    ];

    // Make API request to NowPayments
    $ch = curl_init('https://api.nowpayments.io/v1/invoice');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($invoiceData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'x-api-key: ' . $apiKey,
        'Content-Type: application/json'
    ]);

    // SSL configuration for Windows/XAMPP/WAMP
    if (APP_ENV === 'development') {
        // In development, disable SSL verification (NOT for production!)
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    } else {
        // In production, ensure SSL verification is enabled
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    }

    $response = curl_exec($ch);

    // Check for cURL errors BEFORE checking HTTP code
    if (curl_errno($ch)) {
        $error = curl_error($ch);
        curl_close($ch);
        error_log("NowPayments cURL error: " . $error);
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Unable to connect to payment gateway. Please check your internet connection.',
            'error_code' => 'NETWORK_ERROR'
        ]);
        exit;
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Accept any 2xx status code as success
    if ($httpCode < 200 || $httpCode >= 300) {
        error_log("NowPayments API error (HTTP $httpCode): " . $response);
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Payment gateway returned an error. Please try again or contact support.',
            'error_code' => 'PAYMENT_GATEWAY_ERROR',
            'debug_info' => getenv('APP_ENV') === 'development' ? $response : null
        ]);
        exit;
    }

    $paymentResponse = json_decode($response, true);

    // Validate response structure
    if (!isset($paymentResponse['id']) || !isset($paymentResponse['invoice_url'])) {
        error_log("Invalid NowPayments response structure: " . $response);
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Received invalid response from payment gateway.',
            'error_code' => 'INVALID_RESPONSE'
        ]);
        exit;
    }

    // Validate invoice URL format
    if (!filter_var($paymentResponse['invoice_url'], FILTER_VALIDATE_URL)) {
        error_log("Invalid invoice URL format: " . $paymentResponse['invoice_url']);
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Received invalid payment URL.',
            'error_code' => 'INVALID_URL'
        ]);
        exit;
    }

    // Validate payment ID is not empty
    if (empty($paymentResponse['id'])) {
        error_log("Empty payment ID received");
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Invalid payment identifier.',
            'error_code' => 'INVALID_ID'
        ]);
        exit;
    }

    // Store transaction in database
    $transactionQuery = "
        INSERT INTO transactions (
            package_id,
            payment_id,
            payment_status,
            amount,
            currency,
            payer_email,
            payment_url
        ) VALUES (
            :package_id,
            :payment_id,
            'pending',
            :amount,
            'USD',
            :payer_email,
            :payment_url
        )
    ";

    $stmt = $db->prepare($transactionQuery);
    $stmt->execute([
        'package_id' => $package['id'],
        'payment_id' => $paymentResponse['id'],
        'amount' => $package['amount'],
        'payer_email' => $package['email'],
        'payment_url' => $paymentResponse['invoice_url']
    ]);

    // Send payment initiation email
    try {
        require_once __DIR__ . '/../utilities/email_templates.php';
        require_once __DIR__ . '/../../config/email.php';

        $emailBody = getPaymentInitiatedEmail(
            $package['email'],
            $package['tracking_id'],
            $package['package_name'],
            $package['amount'],
            $paymentResponse['invoice_url']
        );

        $mailer = new Mailer();
        $mailer->send(
            $package['email'],
            'Payment Required - TruePath Express Package #' . $package['tracking_id'],
            $emailBody
        );
    } catch (Exception $e) {
        error_log("Payment email notification failed: " . $e->getMessage());
        // Don't fail the payment process if email fails
    }

    // Send payment initiated admin notification
    try {
        $adminEmailBody = getPaymentInitiatedAdminEmail(
            $package['email'],
            $package['tracking_id'],
            $package['package_name'],
            $package['amount'],
            $paymentResponse['invoice_url']
        );

        $mailer = new Mailer();
        $adminEmail = getenv('SMTP_FROM') ?: 'support@truepathexpress.com';
        $mailer->send(
            $adminEmail,
            'New Payment Initiated - Package #' . $package['tracking_id'],
            $adminEmailBody
        );

        error_log("Payment initiated admin notification sent to: " . $adminEmail);
    } catch (Exception $e) {
        error_log("Failed to send payment initiated admin notification: " . $e->getMessage());
        // Don't fail the payment process if admin email fails
    }

    // Return payment URL for redirect
    echo json_encode([
        'success' => true,
        'payment_url' => $paymentResponse['invoice_url'],
        'payment_id' => $paymentResponse['id'],
        'message' => 'Payment initiated successfully'
    ]);

} catch (PDOException $e) {
    error_log("Payment API database error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Server error. Please try again.']);
} catch (Exception $e) {
    error_log("Payment API error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'An error occurred. Please try again.']);
}
