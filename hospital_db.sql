-- Database creation
CREATE DATABASE IF NOT EXISTS hospital_db;
USE hospital_db;

-- Users table for authentication
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'doctor', 'staff') NOT NULL
);

-- Patients table
CREATE TABLE patients (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    age INT,
    gender ENUM('M', 'F', 'Other'),
    phone VARCHAR(15),
    address TEXT
);

-- Doctors table
CREATE TABLE doctors (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    specialization VARCHAR(100),
    phone VARCHAR(15)
);

-- Appointments table
CREATE TABLE appointments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    patient_id INT,
    doctor_id INT,
    appointment_date DATE,
    appointment_time TIME,
    status ENUM('scheduled', 'completed', 'cancelled') DEFAULT 'scheduled',
    FOREIGN KEY (patient_id) REFERENCES patients(id),
    FOREIGN KEY (doctor_id) REFERENCES doctors(id)
);

-- Insert default admin user (password: admin123)
INSERT INTO users (username, password, role) VALUES ('admin', '$2y$10$8K1p/hLrS5HLd1g.zH9kB.OmxAZy6vRHsR9w8G8N2F5yFEVcgWAPa', 'admin');