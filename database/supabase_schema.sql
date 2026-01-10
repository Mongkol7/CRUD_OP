-- Create a custom type for status, which is good practice in PostgreSQL
CREATE TYPE user_status AS ENUM ('ACTIVE', 'INACTIVE');

-- Create users table
CREATE TABLE public.users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    rate DECIMAL(10,2) DEFAULT 0.00,
    balance DECIMAL(10,2) DEFAULT 0.00,
    deposite DECIMAL(10,2) DEFAULT 0.00,
    status user_status DEFAULT 'ACTIVE',
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- Note: The original schema had an automatic 'ON UPDATE' for updated_at.
-- This requires a custom trigger in PostgreSQL. For simplicity, this has been omitted.
-- The application logic should handle updating this field.

-- Insert sample data
INSERT INTO public.users (name, description, rate, balance, deposite, status) VALUES
('Reuben Rojas', 'It is a long established fact that a reader will be', 120.00, 300.00, 500.00, 'ACTIVE'),
('Jonathan Jarrell', 'It is a long established fact that a reader will be', 120.00, -140.00, 500.00, 'INACTIVE'),
('Marcos Mcleroy', 'It is a long established fact that a reader will be', 120.00, 100.00, 500.00, 'INACTIVE'),
('Tanner Talbott', 'It is a long established fact that a reader will be', 120.00, 300.00, 500.00, 'ACTIVE'),
('Bernardo Bair', 'It is a long established fact that a reader will be', 120.00, -170.00, 500.00, 'ACTIVE');
