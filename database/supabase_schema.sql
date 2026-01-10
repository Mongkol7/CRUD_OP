-- Drop existing table
DROP TABLE IF EXISTS public.users CASCADE;

-- Create users table with email and password
CREATE TABLE public.users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample data
INSERT INTO public.users (name, email, password) VALUES
('Reuben Rojas', 'reuben.rojas@example.com', 'password123'),
('Jonathan Jarrell', 'jonathan.jarrell@example.com', 'password456'),
('Marcos Mcleroy', 'marcos.mcleroy@example.com', 'password789'),
('Tanner Talbott', 'tanner.talbott@example.com', 'password123'),
('Bernardo Bair', 'bernardo.bair@example.com', 'password456');