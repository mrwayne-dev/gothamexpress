<?php
/**
 * Project: truepathexpress
 * Created by: mrwayne
 * Generated: 2026-02-16
 *
 * Reset password API - validates token and updates password
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
$token = trim($input['token'] ?? '');
$password = $input['password'] ?? '';

// Validate inputs
if (empty($token)) {
    echo json_encode(['status' => 'error', 'message' => 'Reset token is required', 'data' => []]);
    exit;
}

if (empty($password) || strlen($password) < 8) {
    echo json_encode(['status' => 'error', 'message' => 'Password must be at least 8 characters', 'data' => []]);
    exit;
}

// Validate token format (should be 64 hex characters)
if (!ctype_xdigit($token) || strlen($token) !== 64) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid reset token format', 'data' => []]);
    exit;
}

try {
    $db = Database::getInstance()->getConnection();

    // Hash the token to match database storage
    $hashedToken = hash('sha256', $token);

    // Query for token and verify not expired
    $stmt = $db->prepare("
        SELECT email
        FROM password_resets
        WHERE token = :token
        AND expires_at > NOW()
    ");
    $stmt->execute(['token' => $hashedToken]);
    $resetRecord = $stmt->fetch();

    if (!$resetRecord) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid or expired reset link. Please request a new password reset.',
            'data' => []
        ]);
        exit;
    }

    $email = $resetRecord['email'];

    // Get user details
    $stmt = $db->prepare("SELECT id, username FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if (!$user) {
        echo json_encode(['status' => 'error', 'message' => 'User account not found', 'data' => []]);
        exit;
    }

    // Hash new password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Update user password
    $stmt = $db->prepare("UPDATE users SET password = :password WHERE email = :email");
    $stmt->execute([
        'password' => $hashedPassword,
        'email' => $email
    ]);

    // Delete used token (single-use tokens)
    $stmt = $db->prepare("DELETE FROM password_resets WHERE email = :email");
    $stmt->execute(['email' => $email]);

    // Send confirmation email
    try {
        $emailBody = getResetPasswordConfirmationEmail($user['username']);
        $mailer = new Mailer();
        $mailer->send($email, 'Password Successfully Changed - TruePath Express', $emailBody);
    } catch (Exception $e) {
        // Log email failure but don't block the response
        error_log("Password reset confirmation email failed for: $email - " . $e->getMessage());
    }

    echo json_encode([
        'status' => 'success',
        'message' => 'Password successfully reset. You can now log in with your new password.',
        'data' => ['email' => $email]
    ]);

} catch (PDOException $e) {
    error_log("Reset password error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Server error. Please try again later.', 'data' => []]);
}
