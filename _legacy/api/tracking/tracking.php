<?php
/**
 * Project: truepathexpress
 * Created by: mrwayne
 * Generated: 2026-02-16
 *
 * Package Tracking API
 * Public endpoint to lookup package details by email and tracking ID
 */

require_once __DIR__ . '/../../config/database.php';
header('Content-Type: application/json');

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$email = trim($input['email'] ?? '');
$trackingId = trim($input['tracking_id'] ?? '');

// Validate inputs
if (empty($email) || empty($trackingId)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Email and tracking ID are required']);
    exit;
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid email format']);
    exit;
}

try {
    $db = Database::getInstance()->getConnection();

    // Query package by tracking ID and email (security: both must match)
    $query = "
        SELECT
            id,
            tracking_id,
            package_name,
            amount,
            description,
            invoice_message,
            sender,
            phone,
            firstname,
            lastname,
            email,
            address,
            location,
            address_type,
            image,
            status,
            payment_status,
            created_at
        FROM packages
        WHERE tracking_id = :tracking_id AND email = :email
        LIMIT 1
    ";

    $stmt = $db->prepare($query);
    $stmt->execute([
        'tracking_id' => $trackingId,
        'email' => $email
    ]);

    $package = $stmt->fetch();

    if (!$package) {
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'message' => 'Package not found. Please check your tracking ID and email.'
        ]);
        exit;
    }

    // Return package details
    echo json_encode([
        'success' => true,
        'package' => $package
    ]);

} catch (PDOException $e) {
    error_log("Tracking API error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Server error. Please try again later.']);
}
