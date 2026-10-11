<?php
/**
 * Project: truepathexpress
 * Created by: mrwayne
 * Generated: 2026-02-16
 *
 * Admin Dashboard API - Transactions Listing
 * GET endpoint that returns all transactions with summary and tracking IDs
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

    // Get transaction summary (total count and amount of confirmed transactions)
    $summaryQuery = "
        SELECT
            COUNT(*) as total_count,
            COALESCE(SUM(amount), 0) as total_amount
        FROM transactions
        WHERE payment_status = 'confirmed'
    ";

    $summaryStmt = $db->query($summaryQuery);
    $summary = $summaryStmt->fetch();

    // Convert to proper types
    $summary = [
        'total_count' => (int)$summary['total_count'],
        'total_amount' => number_format((float)$summary['total_amount'], 2, '.', '')
    ];

    // Get all transactions with tracking IDs from packages table
    $transactionsQuery = "
        SELECT
            t.id,
            t.payment_id,
            t.payer_email,
            t.amount,
            t.currency,
            t.payment_method,
            t.payment_status,
            t.created_at,
            p.tracking_id
        FROM transactions t
        LEFT JOIN packages p ON t.package_id = p.id
        ORDER BY t.created_at DESC
    ";

    $transactionsStmt = $db->query($transactionsQuery);
    $transactions = $transactionsStmt->fetchAll();

    // Return successful response
    echo json_encode([
        'success' => true,
        'summary' => $summary,
        'transactions' => $transactions
    ]);

} catch (PDOException $e) {
    error_log("Transactions API error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Server error']);
}
