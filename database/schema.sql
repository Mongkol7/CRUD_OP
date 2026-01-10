-- Create database
CREATE DATABASE IF NOT EXISTS crud_db;
USE crud_db;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    rate DECIMAL(10,2) DEFAULT 0.00,
    balance DECIMAL(10,2) DEFAULT 0.00,
    deposite DECIMAL(10,2) DEFAULT 0.00,
    status ENUM('ACTIVE', 'INACTIVE') DEFAULT 'ACTIVE',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample data
INSERT INTO users (name, description, rate, balance, deposite, status) VALUES
('Reuben Rojas', 'It is a long established fact that a reader will be', 120.00, 300.00, 500.00, 'ACTIVE'),
('Jonathan Jarrell', 'It is a long established fact that a reader will be', 120.00, -140.00, 500.00, 'INACTIVE'),
('Marcos Mcleroy', 'It is a long established fact that a reader will be', 120.00, 100.00, 500.00, 'INACTIVE'),
('Tanner Talbott', 'It is a long established fact that a reader will be', 120.00, 300.00, 500.00, 'ACTIVE'),
('Bernardo Bair', 'It is a long established fact that a reader will be', 120.00, -170.00, 500.00, 'ACTIVE');
