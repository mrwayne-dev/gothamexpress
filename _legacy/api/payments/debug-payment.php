<?php
/**
 * Payment Integration Debug Script
 * Tests environment variables, database, and NowPayments API
 */

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/constants.php';

header('Content-Type: application/json');

$debug = [];

// Test 1: Environment Variables
$debug['env_check'] = [
    'APP_URL' => getenv('APP_URL') ?: 'NOT SET',
    'APP_ENV' => getenv('APP_ENV') ?: 'NOT SET',
    'DB_NAME' => getenv('DB_NAME') ?: 'NOT SET',
    'NOWPAYMENTS_API_KEY' => getenv('NOWPAYMENTS_API_KEY') ? 'SET ('. substr(getenv('NOWPAYMENTS_API_KEY'), 0, 8) . '...)' : 'NOT SET',
    'NOWPAYMENTS_IPN_SECRET' => getenv('NOWPAYMENTS_IPN_SECRET') ? 'SET ('. substr(getenv('NOWPAYMENTS_IPN_SECRET'), 0, 8) . '...)' : 'NOT SET',
];

// Test 2: Constants
$debug['constants'] = [
    'APP_URL' => defined('APP_URL') ? APP_URL : 'NOT DEFINED',
    'APP_ENV' => defined('APP_ENV') ? APP_ENV : 'NOT DEFINED',
    'APP_NAME' => defined('APP_NAME') ? APP_NAME : 'NOT DEFINED',
];

// Test 3: Database Connection
try {
    $db = Database::getInstance()->getConnection();
    $debug['database'] = 'Connected successfully';

    // Check if packages table exists
    $stmt = $db->query("SHOW TABLES LIKE 'packages'");
    $debug['packages_table'] = $stmt->rowCount() > 0 ? 'EXISTS' : 'NOT FOUND';

    // Check if transactions table exists
    $stmt = $db->query("SHOW TABLES LIKE 'transactions'");
    $debug['transactions_table'] = $stmt->rowCount() > 0 ? 'EXISTS' : 'NOT FOUND';

} catch (Exception $e) {
    $debug['database'] = 'ERROR: ' . $e->getMessage();
}

// Test 4: cURL Available
$debug['curl_available'] = function_exists('curl_init') ? 'YES' : 'NO';

// Test 5: NowPayments API Status
$apiKey = getenv('NOWPAYMENTS_API_KEY');
if ($apiKey) {
    try {
        $ch = curl_init('https://api.nowpayments.io/v1/status');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'x-api-key: ' . $apiKey
        ]);

        // SSL configuration for Windows/XAMPP/WAMP
        if (APP_ENV === 'development') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        $response = curl_exec($ch);
        $curlError = curl_error($ch);
        $curlErrno = curl_errno($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $debug['nowpayments_api'] = [
            'status_code' => $httpCode,
            'reachable' => $httpCode === 200 ? 'YES' : 'NO',
            'response' => $httpCode === 200 ? json_decode($response, true) : $response,
            'curl_error' => $curlError ?: 'None',
            'curl_errno' => $curlErrno
        ];
    } catch (Exception $e) {
        $debug['nowpayments_api'] = 'ERROR: ' . $e->getMessage();
    }
} else {
    $debug['nowpayments_api'] = 'API KEY NOT SET';
}

// Test 6: PHP Version and Extensions
$debug['php_info'] = [
    'version' => PHP_VERSION,
    'pdo_mysql' => extension_loaded('pdo_mysql') ? 'YES' : 'NO',
    'curl' => extension_loaded('curl') ? 'YES' : 'NO',
    'json' => extension_loaded('json') ? 'YES' : 'NO',
];

// Test 7: File Permissions
$debug['file_permissions'] = [
    '.env_readable' => is_readable(__DIR__ . '/../../.env') ? 'YES' : 'NO',
    '.env_exists' => file_exists(__DIR__ . '/../../.env') ? 'YES' : 'NO',
];

echo json_encode($debug, JSON_PRETTY_PRINT);
