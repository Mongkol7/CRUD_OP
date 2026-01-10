<?php

// Application configuration
define('APP_NAME', 'CRUD Application');
define('APP_URL', 'http://localhost/grud_php');
define('BASE_PATH', __DIR__ . '/..');



// Paths
define('CONTROLLERS_PATH', BASE_PATH . '/app/Controllers/');
define('MODELS_PATH', BASE_PATH . '/app/Models/');
define('VIEWS_PATH', BASE_PATH . '/app/Views/');

// Timezone
date_default_timezone_set('UTC');

// Error reporting (set to 0 in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);
