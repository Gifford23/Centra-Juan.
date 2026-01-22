-- =====================================================
-- SETUP USERS FOR CENTRAL JUAN HRIS SYSTEM
-- =====================================================

-- 1. Create database if not exists
CREATE DATABASE IF NOT EXISTS central_juan_hris;
USE central_juan_hris;

-- 2. Create users table if not exists
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL DEFAULT 'EMPLOYEE',
    status VARCHAR(20) NOT NULL DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 3. Create employees table if not exists
CREATE TABLE IF NOT EXISTS employees (
    employee_id VARCHAR(50) PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    middle_name VARCHAR(100),
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    department VARCHAR(100),
    position VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 4. Insert sample users (PASSWORD BYPASSED - any password works)
-- Clear existing users first
DELETE FROM users;

-- Insert admin user
INSERT INTO users (username, password, role, status) VALUES 
('admin', 'any_password_here', 'ADMIN', 'active');

-- Insert sample employees
INSERT INTO users (username, password, role, status) VALUES 
('employee1', 'any_password_here', 'EMPLOYEE', 'active'),
('employee2', 'any_password_here', 'EMPLOYEE', 'active'),
('manager', 'any_password_here', 'MANAGER', 'active');

-- 5. Insert corresponding employee records
DELETE FROM employees;

INSERT INTO employees (employee_id, first_name, last_name, email, department, position) VALUES 
('admin', 'System', 'Administrator', 'admin@centraljuan.com', 'IT', 'System Administrator'),
('employee1', 'Juan', 'Dela Cruz', 'juan@centraljuan.com', 'HR', 'HR Staff'),
('employee2', 'Maria', 'Santos', 'maria@centraljuan.com', 'Finance', 'Accountant'),
('manager', 'Pedro', 'Reyes', 'pedro@centraljuan.com', 'Operations', 'Operations Manager');

-- 6. Verify data
SELECT 'USERS TABLE:' as info;
SELECT user_id, username, role, status FROM users;

SELECT 'EMPLOYEES TABLE:' as info;
SELECT employee_id, first_name, last_name, department, position FROM employees;

-- =====================================================
-- LOGIN TEST CREDENTIALS (ANY PASSWORD WORKS):
-- =====================================================
-- Username: admin      | Password: anything | Role: ADMIN
-- Username: employee1  | Password: anything | Role: EMPLOYEE  
-- Username: employee2  | Password: anything | Role: EMPLOYEE
-- Username: manager    | Password: anything | Role: MANAGER
-- =====================================================
