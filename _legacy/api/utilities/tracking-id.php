<?php
/**
 * Project: truepathexpress
 * Created by: mrwayne
 *
 * Tracking ID generation utility
 * Generates unique tracking IDs in format: TPX-XXXXXXXX
 */

/**
 * Generate a unique tracking ID
 * Format: TPX- followed by 8 uppercase hexadecimal characters
 *
 * @param PDO $db Database connection
 * @return string Unique tracking ID
 * @throws Exception if unable to generate unique ID after max attempts
 */
function generateTrackingId($db) {
    $maxAttempts = 10;
    $attempt = 0;

    while ($attempt < $maxAttempts) {
        // Generate 8 uppercase hex characters
        $randomHex = strtoupper(bin2hex(random_bytes(4)));
        $trackingId = 'TPX-' . $randomHex;

        // Check uniqueness in database
        $stmt = $db->prepare("SELECT COUNT(*) FROM packages WHERE tracking_id = :tracking_id");
        $stmt->execute(['tracking_id' => $trackingId]);

        if ($stmt->fetchColumn() == 0) {
            return $trackingId;
        }

        $attempt++;
    }

    throw new Exception('Unable to generate unique tracking ID');
}
