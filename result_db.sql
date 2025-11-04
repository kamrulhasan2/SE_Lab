-- SQL for simple result processing system
CREATE DATABASE IF NOT EXISTS result_db;
USE result_db;

CREATE TABLE IF NOT EXISTS results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_name VARCHAR(100) NOT NULL,
    subject VARCHAR(100) NOT NULL,
    marks INT NOT NULL
);