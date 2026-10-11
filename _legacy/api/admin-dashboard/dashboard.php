<?php
/**
 * Project: truepathexpress
 * Created by: mrwayne
 * Generated: 2026-02-16
 *
 * Admin Dashboard API - Overview Stats and Recent Transactions
 * GET endpoint that returns package statistics and recent transactions
 */

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../utilities/auth-check.php';

header('Content-Type: application/json');

// Require authentication
requireAuth();

// Only allow GET requests
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

try {
    $db = Database::getInstance()->getConnection();

    // Get package statistics
    $statsQuery = "
        SELECT
            COUNT(*) as total,
            SUM(CASE WHEN status = 'delivered' THEN 1 ELSE 0 END) as delivered,
            SUM(CASE WHEN status = 'in_transit' THEN 1 ELSE 0 END) as in_transit,
            SUM(CASE WHEN status = 'processing' THEN 1 ELSE 0 END) as processing
        FROM packages
    ";

    $statsStmt = $db->query($statsQuery);
    $stats = $statsStmt->fetch();

    // Convert string counts to integers for proper JSON formatting
    $stats = [
        'total' => (int)$stats['total'],
        'delivered' => (int)$stats['delivered'],
        'in_transit' => (int)$stats['in_transit'],
        'processing' => (int)$stats['processing']
    ];

    // Get recent transactions (last 10)
    $transactionsQuery = "
        SELECT
            payment_id,
            payer_email,
            amount,
            payment_status,
            created_at
        FROM transactions
        ORDER BY created_at DESC
        LIMIT 10
    ";

    $transactionsStmt = $db->query($transactionsQuery);
    $transactions = $transactionsStmt->fetchAll();

    // Return successful response
    echo json_encode([
        'success' => true,
        'stats' => $stats,
        'transactions' => $transactions
    ]);

} catch (PDOException $e) {
    error_log("Dashboard API error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Server error']);
}
