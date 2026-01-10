<?php

require_once BASE_PATH . '/config/database.php';
require_once MODELS_PATH . 'User.php';

class UserController {
    private $db;
    private $user;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        
        // Check if database connection was successful
        if ($this->db === null) {
            $this->sendError('Database connection failed. Please check your configuration.');
            exit;
        }
        
        $this->user = new User($this->db);
    }

    private function sendError($message, $statusCode = 500) {
        http_response_code($statusCode);
        header("Content-Type: application/json");
        header("Access-Control-Allow-Origin: *");
        echo json_encode([
            'success' => false,
            'message' => $message
        ]);
    }

    // Get all users (API endpoint)
    public function index() {
        header("Content-Type: application/json");
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET");

        try {
            $result = $this->user->index();
            $users = $result->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode([
                'success' => true,
                'data' => $users
            ]);
        } catch (Exception $e) {
            $this->sendError('Failed to fetch users: ' . $e->getMessage());
        }
    }

    // Get single user (API endpoint)
    public function show() {
        header("Content-Type: application/json");
        header("Access-Control-Allow-Origin: *");

        $id = isset($_GET['id']) ? $_GET['id'] : null;

        if (!$id) {
            $this->sendError('ID is required', 400);
            return;
        }

        try {
            $user = $this->user->show($id);

            if ($user) {
                echo json_encode([
                    'success' => true,
                    'data' => $user
                ]);
            } else {
                $this->sendError('User not found', 404);
            }
        } catch (Exception $e) {
            $this->sendError('Failed to fetch user: ' . $e->getMessage());
        }
    }

    // Create user (API endpoint)
    public function store() {
        header("Content-Type: application/json");
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST");

        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['name']) || empty($data['name'])) {
            $this->sendError('Name is required', 400);
            return;
        }

        if (!isset($data['email']) || empty($data['email'])) {
            $this->sendError('Email is required', 400);
            return;
        }

        if (!isset($data['password']) || empty($data['password'])) {
            $this->sendError('Password is required', 400);
            return;
        }

        try {
            $this->user->name = $data['name'];
            $this->user->email = $data['email'];
            $this->user->password = $data['password'];

            if ($this->user->store()) {
                echo json_encode([
                    'success' => true,
                    'message' => 'User created successfully'
                ]);
            } else {
                $this->sendError('Failed to create user');
            }
        } catch (Exception $e) {
            $this->sendError('Failed to create user: ' . $e->getMessage());
        }
    }

    // Update user (API endpoint)
    public function update() {
        header("Content-Type: application/json");
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: PUT, PATCH");

        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['id']) || empty($data['id'])) {
            $this->sendError('ID is required', 400);
            return;
        }

        try {
            $this->user->id = $data['id'];
            $this->user->name = $data['name'];
            $this->user->email = $data['email'];
            $this->user->password = $data['password'];

            if ($this->user->update()) {
                echo json_encode([
                    'success' => true,
                    'message' => 'User updated successfully'
                ]);
            } else {
                $this->sendError('Failed to update user');
            }
        } catch (Exception $e) {
            $this->sendError('Failed to update user: ' . $e->getMessage());
        }
    }

    // Delete user (API endpoint)
    public function destroy() {
        header("Content-Type: application/json");
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: DELETE");

        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data['id'] ?? null;

        if (!$id) {
            $this->sendError('ID is required', 400);
            return;
        }

        try {
            if ($this->user->destroy($id)) {
                echo json_encode([
                    'success' => true,
                    'message' => 'User deleted successfully'
                ]);
            } else {
                $this->sendError('Failed to delete user');
            }
        } catch (Exception $e) {
            $this->sendError('Failed to delete user: ' . $e->getMessage());
        }
    }
}