-- Create the database
CREATE DATABASE IF NOT EXISTS attendance_db;
USE attendance_db;

-- Create teachers table
CREATE TABLE teachers (
    teacher_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create classes table
CREATE TABLE classes (
    class_id INT PRIMARY KEY AUTO_INCREMENT,
    class_name VARCHAR(50) NOT NULL,
    section VARCHAR(10),
    teacher_id INT,
    academic_year VARCHAR(20) NOT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (teacher_id) REFERENCES teachers(teacher_id)
);

-- Create students table
CREATE TABLE students (
    student_id INT PRIMARY KEY AUTO_INCREMENT,
    roll_number VARCHAR(20) UNIQUE NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    class_id INT,
    email VARCHAR(100) UNIQUE,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (class_id) REFERENCES classes(class_id)
);

-- Create attendance table
CREATE TABLE attendance (
    attendance_id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT,
    class_id INT,
    attendance_date DATE NOT NULL,
    status ENUM('present', 'absent', 'late') NOT NULL,
    marked_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(student_id),
    FOREIGN KEY (class_id) REFERENCES classes(class_id),
    FOREIGN KEY (marked_by) REFERENCES teachers(teacher_id)
);

-- Create indexes for better performance
CREATE INDEX idx_attendance_date ON attendance(attendance_date);
CREATE INDEX idx_student_class ON students(class_id);
CREATE INDEX idx_class_teacher ON classes(teacher_id);

-- --------------------------------------------------
-- Sample data for testing (teacher, classes, students)
-- Passwords are bcrypt hashes. The sample teacher password is: teacher123
-- --------------------------------------------------

-- Insert a sample teacher (teacher_id = 1)
INSERT INTO teachers (teacher_id, username, password, full_name, email, status)
VALUES (1, 'jdoe', '$2y$10$8mxGGnx3YqrqYxEt.L9RUek5b8pD4r8QI.OlKqwLBm2Ph3AEpj0EO', 'John Doe', 'jdoe@example.com', 'active');

-- Insert sample classes assigned to teacher_id = 1
INSERT INTO classes (class_id, class_name, section, teacher_id, academic_year, status)
VALUES
    (1, 'Mathematics 101', 'A', 1, '2025-2026', 'active'),
    (2, 'Science 101', 'B', 1, '2025-2026', 'active'),
    (3, 'History 101', 'A', 1, '2025-2026', 'active');

-- Insert sample students for each class
INSERT INTO students (student_id, roll_number, full_name, class_id, email, status)
VALUES
    (1, 'M101-001', 'Md. Ripon Hossain', 1, 'ripon.hossain@example.com', 'active'),
    (2, 'M101-002', 'Fatema Khatun', 1, 'fatema.khatun@example.com', 'active'),
    (3, 'M101-003', 'Arifur Rahman', 1, 'arifur.rahman@example.com', 'active'),
    (4, 'S101-001', 'Sadia Akter', 2, 'sadia.akter@example.com', 'active'),
    (5, 'S101-002', 'Tanvir Ahmed', 2, 'tanvir.ahmed@example.com', 'active'),
    (6, 'S101-003', 'Nusrat Jahan', 2, 'nusrat.jahan@example.com', 'active'),
    (7, 'H101-001', 'Rashed Khan', 3, 'rashed.khan@example.com', 'active'),
    (8, 'H101-002', 'Shakila Sultana', 3, 'shakila.sultana@example.com', 'active'),
    (9, 'H101-003', 'Imran Hossain', 3, 'imran.hossain@example.com', 'active');

-- Ensure AUTO_INCREMENT will continue correctly after explicit ids
ALTER TABLE teachers AUTO_INCREMENT = 2;
ALTER TABLE classes AUTO_INCREMENT = 4;
ALTER TABLE students AUTO_INCREMENT = 10;
