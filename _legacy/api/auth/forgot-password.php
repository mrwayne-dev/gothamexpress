<?php
/**
 * Project: truepathexpress
 * Created by: mrwayne
 * Generated: 2026-02-16
 *
 * Forgot password API - generates reset token and sends email
 */

require_once '../../config/database.php';
require_once '../../config/email.php';
require_once '../utilities/email_templates.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed', 'data' => []]);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$email = trim($input['email'] ?? '');

// Validate email format
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Valid email address is required', 'data' => []]);
    exit;
}

try {
    $db = Database::getInstance()->getConnection();

    // Check if email exists and get username
    $stmt = $db->prepare("SELECT id, username, email FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    // Always return success to prevent email enumeration
    // If email doesn't exist, we still pretend to send the email
    if ($user) {
        // Generate secure token (64 hex characters)
        $rawToken = bin2hex(random_bytes(32));
        $hashedToken = hash('sha256', $rawToken);

        // Delete any existing tokens for this email (cleanup)
        $stmt = $db->prepare("DELETE FROM password_resets WHERE email = :email");
        $stmt->execute(['email' => $email]);

        // Insert new token with 1-hour expiry
        $stmt = $db->prepare("
            INSERT INTO password_resets (email, token, expires_at, created_at)
            VALUES (:email, :token, DATE_ADD(NOW(), INTERVAL 1 HOUR), NOW())
        ");
        $stmt->execute([
            'email' => $email,
            'token' => $hashedToken
        ]);

        // Build reset link with raw token
        $resetLink = APP_URL . '/admin.auth.resetpassword?token=' . $rawToken;

        // Send reset email
        try {
            $emailBody = getForgotPasswordEmail($user['username'], $resetLink);
            $mailer = new Mailer();
            $mailer->send($email, 'Password Reset Request - TruePath Express', $emailBody);
        } catch (Exception $e) {
            // Log email failure but don't block the response
            error_log("Password reset email failed for: $email - " . $e->getMessage());
        }
    }

    // Always return success message (security measure)
    echo json_encode([
        'status' => 'success',
        'message' => 'If an account exists with this email, a password reset link has been sent. Please check your inbox.',
        'data' => []
    ]);

} catch (PDOException $e) {
    error_log("Forgot password error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Server error. Please try again later.', 'data' => []]);
}
