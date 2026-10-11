<?php
/**
 * Project: truepathexpress
 * Created by: mrwayne
 * Generated: 2026-02-16
 *
 * Admin Dashboard API - Packages CRUD
 * GET: List all packages
 * POST: Create or update package (unified endpoint, checks for 'id' parameter)
 * DELETE: Delete package and associated image
 */

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../utilities/auth-check.php';
require_once __DIR__ . '/../utilities/tracking-id.php';
require_once __DIR__ . '/../utilities/image-upload.php';

header('Content-Type: application/json');

// Require authentication
$userId = requireAuth();

$method = $_SERVER['REQUEST_METHOD'];

try {
    $db = Database::getInstance()->getConnection();

    switch ($method) {
        case 'GET':
            handleGetPackages($db);
            break;

        case 'POST':
            handleCreateOrUpdatePackage($db, $userId);
            break;

        case 'DELETE':
            handleDeletePackage($db);
            break;

        default:
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            break;
    }

} catch (Exception $e) {
    error_log("Packages API error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Server error']);
}

/**
 * GET - List all packages
 */
function handleGetPackages($db) {
    $query = "SELECT * FROM packages ORDER BY created_at DESC";
    $stmt = $db->query($query);
    $packages = $stmt->fetchAll();

    echo json_encode([
        'success' => true,
        'packages' => $packages
    ]);
}

/**
 * POST - Create or Update package
 * Unified endpoint: checks for 'id' parameter to determine mode
 */
function handleCreateOrUpdatePackage($db, $userId) {
    // Check if this is an update (id present) or create (no id)
    $isUpdate = !empty($_POST['id']);
    $packageId = $isUpdate ? (int)$_POST['id'] : null;

    // Validate input
    $data = [
        'package_name' => trim($_POST['package_name'] ?? ''),
        'amount' => trim($_POST['amount'] ?? ''),
        'description' => trim($_POST['description'] ?? ''),
        'invoice_message' => trim($_POST['invoice_message'] ?? ''),
        'sender' => trim($_POST['sender'] ?? ''),
        'phone' => trim($_POST['phone'] ?? ''),
        'firstname' => trim($_POST['firstname'] ?? ''),
        'lastname' => trim($_POST['lastname'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'address' => trim($_POST['address'] ?? ''),
        'location' => trim($_POST['location'] ?? ''),
        'address_type' => trim($_POST['address_type'] ?? ''),
        'status' => trim($_POST['status'] ?? ''),
        'payment_status' => trim($_POST['payment_status'] ?? '')
    ];

    validatePackageInput($data);

    // Handle image upload
    $imagePath = null;
    $oldImagePath = null;

    if ($isUpdate) {
        // Get existing package data including current status
        $stmt = $db->prepare("SELECT image, status FROM packages WHERE id = :id");
        $stmt->execute(['id' => $packageId]);
        $existingPackage = $stmt->fetch();

        if (!$existingPackage) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Package not found']);
            exit;
        }

        $oldImagePath = $existingPackage['image'];
        $oldStatus = $existingPackage['status'];
    }

    // Check if new image uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        try {
            $imagePath = handleImageUpload($_FILES['image'], 'packages');

            // Delete old image if updating
            if ($isUpdate && $oldImagePath) {
                deleteImage($oldImagePath);
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            exit;
        }
    } else {
        // Keep old image if updating and no new image uploaded
        if ($isUpdate) {
            $imagePath = $oldImagePath;
        }
    }

    if ($isUpdate) {
        // UPDATE existing package
        $query = "
            UPDATE packages SET
                package_name = :package_name,
                amount = :amount,
                description = :description,
                invoice_message = :invoice_message,
                sender = :sender,
                phone = :phone,
                firstname = :firstname,
                lastname = :lastname,
                email = :email,
                address = :address,
                location = :location,
                address_type = :address_type,
                image = :image,
                status = :status,
                payment_status = :payment_status,
                updated_at = CURRENT_TIMESTAMP
            WHERE id = :id
        ";

        $stmt = $db->prepare($query);
        $stmt->execute([
            'package_name' => $data['package_name'],
            'amount' => $data['amount'],
            'description' => $data['description'],
            'invoice_message' => $data['invoice_message'],
            'sender' => $data['sender'],
            'phone' => $data['phone'],
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'address' => $data['address'],
            'location' => $data['location'],
            'address_type' => $data['address_type'],
            'image' => $imagePath,
            'status' => $data['status'],
            'payment_status' => $data['payment_status'],
            'id' => $packageId
        ]);

        // Send status update email if status changed to 'in_transit' or 'delivered'
        $newStatus = $data['status'];
        if ($oldStatus !== $newStatus && ($newStatus === 'in_transit' || $newStatus === 'delivered')) {
            try {
                require_once __DIR__ . '/../utilities/email_templates.php';
                require_once __DIR__ . '/../../config/email.php';

                // Get package details including tracking_id
                $packageQuery = "SELECT tracking_id, package_name, location FROM packages WHERE id = :id LIMIT 1";
                $packageStmt = $db->prepare($packageQuery);
                $packageStmt->execute(['id' => $packageId]);
                $packageDetails = $packageStmt->fetch();

                if ($packageDetails) {
                    $emailBody = getPackageStatusUpdateEmail(
                        $data['email'],
                        $packageDetails['tracking_id'],
                        $data['package_name'],
                        $newStatus,
                        $data['location']
                    );

                    $mailer = new Mailer();
                    $statusLabel = $newStatus === 'in_transit' ? 'In Transit' : 'Delivered';
                    $mailer->send(
                        $data['email'],
                        'Package Status Update: ' . $statusLabel . ' - TruePath Express #' . $packageDetails['tracking_id'],
                        $emailBody
                    );

                    error_log("Status update email sent to {$data['email']} for package {$packageDetails['tracking_id']} - Status: {$newStatus}");
                }
            } catch (Exception $e) {
                error_log("Failed to send status update email: " . $e->getMessage());
                // Don't fail the update process if email fails
            }
        }

        echo json_encode(['success' => true, 'message' => 'Package updated successfully']);

    } else {
        // CREATE new package
        $trackingId = generateTrackingId($db);

        $query = "
            INSERT INTO packages (
                tracking_id, package_name, amount, description, invoice_message,
                sender, phone, firstname, lastname, email, address, location,
                address_type, image, status, payment_status, created_by
            ) VALUES (
                :tracking_id, :package_name, :amount, :description, :invoice_message,
                :sender, :phone, :firstname, :lastname, :email, :address, :location,
                :address_type, :image, :status, :payment_status, :created_by
            )
        ";

        $stmt = $db->prepare($query);
        $stmt->execute([
            'tracking_id' => $trackingId,
            'package_name' => $data['package_name'],
            'amount' => $data['amount'],
            'description' => $data['description'],
            'invoice_message' => $data['invoice_message'],
            'sender' => $data['sender'],
            'phone' => $data['phone'],
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'address' => $data['address'],
            'location' => $data['location'],
            'address_type' => $data['address_type'],
            'image' => $imagePath,
            'status' => $data['status'],
            'payment_status' => $data['payment_status'],
            'created_by' => $userId
        ]);

        echo json_encode(['success' => true, 'message' => 'Package created successfully']);
    }
}

/**
 * DELETE - Delete package and associated image
 */
function handleDeletePackage($db) {
    $input = json_decode(file_get_contents('php://input'), true);
    $packageId = $input['id'] ?? null;

    if (empty($packageId)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Package ID required']);
        exit;
    }

    // Get package to retrieve image path
    $stmt = $db->prepare("SELECT image FROM packages WHERE id = :id");
    $stmt->execute(['id' => $packageId]);
    $package = $stmt->fetch();

    if (!$package) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Package not found']);
        exit;
    }

    // Delete image file if exists
    if (!empty($package['image'])) {
        deleteImage($package['image']);
    }

    // Delete package from database (CASCADE will delete related transactions)
    $stmt = $db->prepare("DELETE FROM packages WHERE id = :id");
    $stmt->execute(['id' => $packageId]);

    echo json_encode(['success' => true, 'message' => 'Package deleted successfully']);
}

/**
 * Validate package input data
 */
function validatePackageInput($data) {
    $errors = [];

    // Required fields validation
    if (empty($data['package_name'])) {
        $errors[] = 'Package name required';
    }

    if (empty($data['amount']) || !is_numeric($data['amount']) || $data['amount'] <= 0) {
        $errors[] = 'Valid amount required';
    }

    if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Valid email required';
    }

    // Status validation
    $validStatuses = ['processing', 'in_transit', 'delivered'];
    if (!in_array($data['status'], $validStatuses)) {
        $errors[] = 'Invalid status value. Must be: processing, in_transit, or delivered';
    }

    // Payment status validation
    $validPaymentStatuses = ['unpaid', 'paid'];
    if (!in_array($data['payment_status'], $validPaymentStatuses)) {
        $errors[] = 'Invalid payment status. Must be: unpaid or paid';
    }

    // Check other required fields
    $requiredFields = ['sender', 'phone', 'firstname', 'lastname', 'address', 'location', 'address_type'];
    foreach ($requiredFields as $field) {
        if (empty($data[$field])) {
            $errors[] = ucfirst(str_replace('_', ' ', $field)) . ' required';
        }
    }

    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => implode(', ', $errors)]);
        exit;
    }
}
