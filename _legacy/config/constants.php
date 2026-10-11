<?php
/**
 * Project: truepathexpress
 * Created by: mrwayne
 *
 * System path constants and environment setup
 */

require_once __DIR__ . '/env.php';

// Base paths
define('APP_ROOT', dirname(__DIR__));
define('CONFIG_PATH', APP_ROOT . '/config');
define('INCLUDES_PATH', APP_ROOT . '/includes');
define('UPLOADS_PATH', APP_ROOT . '/uploads');
define('ASSETS_PATH', APP_ROOT . '/assets');
define('API_PATH', APP_ROOT . '/api');
define('PAGES_PATH', APP_ROOT . '/pages');

// Application settings from .env
define('APP_NAME', getenv('APP_NAME') ?: 'truepathexpress');
define('APP_URL', getenv('APP_URL') ?: 'http://localhost');
define('APP_ENV', getenv('APP_ENV') ?: 'production');

// Session
define('SESSION_LIFETIME', (int)(getenv('SESSION_LIFETIME') ?: 3600));

// Error reporting based on environment
if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

date_default_timezone_set('UTC');
