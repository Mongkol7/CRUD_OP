<?php
// api.php - Place in /public folder

// Temporary debugging: Check environment variables
header('Content-Type: application/json');
$env_vars = [
    'DB_HOST' => getenv('DB_HOST'),
    'DB_PORT' => getenv('DB_PORT'),
    'DB_NAME' => getenv('DB_NAME'),
    'DB_USER' => getenv('DB_USER'),
    'DB_PASS_IS_SET' => !empty(getenv('DB_PASS')),
    'MESSAGE' => 'This is a debug response. If you see your DB host, etc., then the env variables are loaded.'
];
echo json_encode(['debug_env_variables' => $env_vars]);
exit;


// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 0); // Don't display errors directly
ini_set('log_errors', 1);

// Set headers first
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

try {
    // Load dependencies
    require_once __DIR__ . '/../config/bootstrap.php';
    require_once __DIR__ . '/../config/config.php';
    require_once __DIR__ . '/../config/database.php';
    require_once MODELS_PATH . 'User.php';
    
    // Check database connection
    $database = new Database();
    $db = $database->connect();
    
    if ($db === null) {
        throw new Exception('Database connection failed');
    }
    
    // Create user model
    $user = new User($db);
    
    // Get request method
    $method = $_SERVER['REQUEST_METHOD'];
    
    // Route requests
    if ($method === 'GET') {
        if (isset($_GET['id'])) {
            // Get single user
            $id = $_GET['id'];
            $userData = $user->show($id);
            
            if ($userData) {
                echo json_encode([
                    'success' => true,
                    'data' => $userData
                ]);
            } else {
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'message' => 'User not found'
                ]);
            }
        } else {
            // Get all users
            $result = $user->index();
            $users = $result->fetchAll(PDO::FETCH_ASSOC);
            
            echo json_encode([
                'success' => true,
                'data' => $users
            ]);
        }
        
    } elseif ($method === 'POST') {
        // Create user
        $data = json_decode(file_get_contents("php://input"), true);
        
        if (!isset($data['name']) || !isset($data['email']) || !isset($data['password'])) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Name, email, and password are required'
            ]);
            exit;
        }
        
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = $data['password'];
        
        if ($user->store()) {
            http_response_code(201);
            echo json_encode([
                'success' => true,
                'message' => 'User created successfully'
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Failed to create user'
            ]);
        }
        
    } elseif ($method === 'PUT' || $method === 'PATCH') {
        // Update user
        $data = json_decode(file_get_contents("php://input"), true);
        
        if (!isset($data['id'])) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'ID is required'
            ]);
            exit;
        }
        
        $user->id = $data['id'];
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = $data['password'];
        
        if ($user->update()) {
            echo json_encode([
                'success' => true,
                'message' => 'User updated successfully'
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Failed to update user'
            ]);
        }
        
    } elseif ($method === 'DELETE') {
        // Delete user
        $data = json_decode(file_get_contents("php://input"), true);
        
        if (!isset($data['id'])) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'ID is required'
            ]);
            exit;
        }
        
        if ($user->destroy($data['id'])) {
            echo json_encode([
                'success' => true,
                'message' => 'User deleted successfully'
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Failed to delete user'
            ]);
        }
        
    } else {
        http_response_code(405);
        echo json_encode([
            'success' => false,
            'message' => 'Method not allowed'
        ]);
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ]);
}