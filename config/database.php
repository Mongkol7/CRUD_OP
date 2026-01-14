<?php

class Database {
    private $host;
    private $port;
    private $db_name;
    private $username;
    private $password;
    private $conn;

    public function __construct() {
        $this->host = getenv('DB_HOST');
        $this->port = getenv('DB_PORT');
        $this->db_name = getenv('DB_NAME');
        $this->username = getenv('DB_USER');
        $this->password = getenv('DB_PASS');
    }

    public function connect() {
        $this->conn = null;

        try {
            // Build connection string for Supabase PostgreSQL
            // Add options to optimize connection speed
            $dsn = sprintf(
                'pgsql:host=%s;port=%s;dbname=%s;sslmode=require;connect_timeout=5;application_name=railway_app',
                $this->host,
                $this->port,
                $this->db_name
            );

            $this->conn = new PDO(
                $dsn,
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_PERSISTENT => true,  // Use persistent connections
                    PDO::ATTR_TIMEOUT => 5  // Connection timeout 5 seconds
                ]
            );

        } catch(PDOException $e) {
            // Log error to PHP error log instead of echoing
            error_log('Database Connection Error: ' . $e->getMessage());
            
            // Return null to indicate connection failure
            // The calling code should check for this
            return null;
        }

        return $this->conn;
    }
}