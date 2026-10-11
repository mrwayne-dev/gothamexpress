<?php
/**
 * Project: truepathexpress
 * Created by: mrwayne
 *
 * Image upload handler with security validation
 * Handles secure file uploads for package images
 */

require_once __DIR__ . '/../../config/constants.php';

/**
 * Handle secure image upload with validation
 *
 * @param array $fileArray The $_FILES array element for the uploaded file
 * @param string $uploadDir Subdirectory within uploads/ (default: 'packages')
 * @return string Relative path to uploaded file (e.g., /uploads/packages/filename.jpg)
 * @throws Exception on validation failure or upload error
 */
function handleImageUpload($fileArray, $uploadDir = 'packages') {
    // Validate file exists and no upload error
    if (!isset($fileArray) || !is_array($fileArray)) {
        throw new Exception('No file uploaded');
    }

    if ($fileArray['error'] !== UPLOAD_ERR_OK) {
        $errorMessages = [
            UPLOAD_ERR_INI_SIZE => 'File exceeds upload_max_filesize',
            UPLOAD_ERR_FORM_SIZE => 'File exceeds MAX_FILE_SIZE',
            UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
            UPLOAD_ERR_NO_FILE => 'No file was uploaded',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
            UPLOAD_ERR_EXTENSION => 'File upload stopped by extension'
        ];

        $errorMessage = $errorMessages[$fileArray['error']] ?? 'Unknown upload error';
        throw new Exception($errorMessage);
    }

    // Validate file size (max 5MB)
    $maxSize = 5 * 1024 * 1024; // 5MB in bytes
    if ($fileArray['size'] > $maxSize) {
        throw new Exception('File too large. Maximum 5MB allowed');
    }

    // Validate MIME type (not just extension - security critical)
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $fileArray['tmp_name']);
    finfo_close($finfo);

    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
    if (!in_array($mimeType, $allowedTypes)) {
        throw new Exception('Invalid file type. Only JPG, PNG, and WEBP allowed');
    }

    // Generate unique filename to prevent overwrites
    $extension = strtolower(pathinfo($fileArray['name'], PATHINFO_EXTENSION));

    // Additional extension validation (belt and suspenders approach)
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
    if (!in_array($extension, $allowedExtensions)) {
        throw new Exception('Invalid file extension');
    }

    $filename = date('Y-m-d') . '_' . bin2hex(random_bytes(8)) . '.' . $extension;

    // Ensure upload directory exists with proper permissions
    $uploadPath = APP_ROOT . '/uploads/' . $uploadDir;
    if (!is_dir($uploadPath)) {
        if (!mkdir($uploadPath, 0755, true)) {
            throw new Exception('Failed to create upload directory');
        }
    }

    // Check if directory is writable
    if (!is_writable($uploadPath)) {
        throw new Exception('Upload directory is not writable');
    }

    // Move uploaded file
    $targetPath = $uploadPath . '/' . $filename;
    if (!move_uploaded_file($fileArray['tmp_name'], $targetPath)) {
        throw new Exception('Failed to save uploaded file');
    }

    // Return relative path for database storage
    return '/uploads/' . $uploadDir . '/' . $filename;
}

/**
 * Delete an uploaded image file
 *
 * @param string $imagePath Relative path to image (e.g., /uploads/packages/file.jpg)
 * @return bool True if deleted or file doesn't exist, false on failure
 */
function deleteImage($imagePath) {
    if (empty($imagePath)) {
        return true;
    }

    $fullPath = APP_ROOT . $imagePath;

    if (file_exists($fullPath)) {
        return unlink($fullPath);
    }

    return true; // File doesn't exist, consider it deleted
}
