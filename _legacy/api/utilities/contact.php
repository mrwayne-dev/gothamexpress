<?php
/**
 * Project: truepathexpress
 * Created by: mrwayne
 * Generated: 2026-02-16
 *
 * Contact Form API
 * Handles contact form submissions and sends emails to user and admin
 */

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/constants.php';
require_once __DIR__ . '/email_templates.php';
require_once __DIR__ . '/../../config/email.php';

header('Content-Type: application/json');

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Get and decode JSON input
$input = json_decode(file_get_contents('php://input'), true);

// Validate required fields
$firstname = trim($input['firstname'] ?? '');
$lastname = trim($input['lastname'] ?? '');
$email = trim($input['email'] ?? '');
$inquiry = trim($input['inquiry'] ?? '');
$message = trim($input['message'] ?? '');

// Validation errors array
$errors = [];

// Validate firstname
if (empty($firstname)) {
    $errors[] = 'First name is required';
} elseif (strlen($firstname) < 2) {
    $errors[] = 'First name must be at least 2 characters';
} elseif (strlen($firstname) > 50) {
    $errors[] = 'First name must not exceed 50 characters';
}

// Validate lastname
if (empty($lastname)) {
    $errors[] = 'Last name is required';
} elseif (strlen($lastname) < 2) {
    $errors[] = 'Last name must be at least 2 characters';
} elseif (strlen($lastname) > 50) {
    $errors[] = 'Last name must not exceed 50 characters';
}

// Validate email
if (empty($email)) {
    $errors[] = 'Email is required';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please provide a valid email address';
} elseif (strlen($email) > 100) {
    $errors[] = 'Email address is too long';
}

// Validate inquiry type
$validInquiries = ['general', 'tracking', 'shipping', 'partnership', 'complaint'];
if (empty($inquiry)) {
    $errors[] = 'Inquiry type is required';
} elseif (!in_array($inquiry, $validInquiries)) {
    $errors[] = 'Invalid inquiry type selected';
}

// Validate message
if (empty($message)) {
    $errors[] = 'Message is required';
} elseif (strlen($message) < 10) {
    $errors[] = 'Message must be at least 10 characters';
} elseif (strlen($message) > 5000) {
    $errors[] = 'Message must not exceed 5000 characters';
}

// Return validation errors if any
if (!empty($errors)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => implode('. ', $errors),
        'errors' => $errors
    ]);
    exit;
}

try {
    $db = Database::getInstance()->getConnection();

    // Store contact submission in database
    $query = "
        INSERT INTO contact_messages (
            firstname, lastname, email, inquiry, message
        ) VALUES (
            :firstname, :lastname, :email, :inquiry, :message
        )
    ";

    $stmt = $db->prepare($query);
    $stmt->execute([
        'firstname' => $firstname,
        'lastname' => $lastname,
        'email' => $email,
        'inquiry' => $inquiry,
        'message' => $message
    ]);

    $submissionId = $db->lastInsertId();

    // Send confirmation email to user
    $userEmailSent = false;
    try {
        $userEmailBody = getContactUserEmail(
            $firstname,
            $lastname,
            $email,
            $inquiry,
            $message
        );

        $mailer = new Mailer();
        $mailer->send(
            $email,
            'Message Received - TruePath Express',
            $userEmailBody
        );

        $userEmailSent = true;
        error_log("Contact form confirmation email sent to: $email");
    } catch (Exception $e) {
        error_log("Failed to send contact confirmation email to user: " . $e->getMessage());
        // Don't fail the entire process if user email fails
    }

    // Send notification email to admin
    $adminEmailSent = false;
    try {
        $adminEmailBody = getContactAdminEmail(
            $firstname,
            $lastname,
            $email,
            $inquiry,
            $message
        );

        $mailer = new Mailer();
        $adminEmail = getenv('SMTP_FROM') ?: 'support@truepathexpress.com';
        $mailer->send(
            $adminEmail,
            'New Contact Form Inquiry - TruePath Express',
            $adminEmailBody
        );

        $adminEmailSent = true;
        error_log("Contact form notification email sent to admin: $adminEmail");
    } catch (Exception $e) {
        error_log("Failed to send contact notification email to admin: " . $e->getMessage());
        // Don't fail the entire process if admin email fails
    }

    // Return success response
    echo json_encode([
        'success' => true,
        'message' => 'Thank you for contacting us. We will respond within 24-48 hours.',
        'data' => [
            'submission_id' => $submissionId,
            'confirmation_email_sent' => $userEmailSent,
            'admin_notified' => $adminEmailSent
        ]
    ]);

} catch (PDOException $e) {
    error_log("Contact form database error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'We encountered an error processing your request. Please try again or contact us directly.',
        'error_code' => 'DATABASE_ERROR'
    ]);
} catch (Exception $e) {
    error_log("Contact form error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'An unexpected error occurred. Please try again later.',
        'error_code' => 'SYSTEM_ERROR'
    ]);
}
