<?php
/**
 * Project: truepathexpress
 * Created by: mrwayne
 *
 * Session authentication helper for admin APIs
 * Centralizes authentication checks across all admin dashboard endpoints
 */

/**
 * Require authenticated admin session
 * Returns user ID if authenticated, otherwise sends 401 and exits
 *
 * @return int User ID from session
 */
function requireAuth() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit;
    }

    return $_SESSION['user_id'];
}
