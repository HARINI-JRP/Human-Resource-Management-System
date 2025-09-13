-- Create and seed HRMS schema from ER diagram
CREATE DATABASE IF NOT EXISTS hrms;
USE hrms;

DROP TABLE IF EXISTS payroll;
DROP TABLE IF EXISTS attendance;
DROP TABLE IF EXISTS perf_review;
DROP TABLE IF EXISTS recruitment;
DROP TABLE IF EXISTS employee;
DROP TABLE IF EXISTS hr;

CREATE TABLE hr (
    hr_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100),
    phone VARCHAR(15),
    password VARCHAR(255) NOT NULL
);

CREATE TABLE employee (
    emp_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    join_date DATE NOT NULL,
    dept VARCHAR(50) NOT NULL,
    designation VARCHAR(50) NOT NULL
);

CREATE TABLE recruitment (
    job_id INT PRIMARY KEY AUTO_INCREMENT,
    dept VARCHAR(50) NOT NULL,
    job_role VARCHAR(50) NOT NULL,
    appl_date DATE NOT NULL,
    status VARCHAR(20) NOT NULL
);

CREATE TABLE perf_review (
    review_id INT PRIMARY KEY AUTO_INCREMENT,
    emp_id INT NOT NULL,
    rating INT NOT NULL,
    review_date DATE NOT NULL,
    FOREIGN KEY (emp_id) REFERENCES employee(emp_id) ON DELETE CASCADE
);

CREATE TABLE attendance (
    att_id INT PRIMARY KEY AUTO_INCREMENT,
    emp_id INT NOT NULL,
    date DATE NOT NULL,
    time_in TIME NOT NULL,
    time_out TIME NOT NULL,
    FOREIGN KEY (emp_id) REFERENCES employee(emp_id) ON DELETE CASCADE
);

CREATE TABLE payroll (
    payroll_id INT PRIMARY KEY AUTO_INCREMENT,
    emp_id INT NOT NULL,
    pay_month VARCHAR(20) NOT NULL,
    salary DECIMAL(10,2) NOT NULL,
    bonus DECIMAL(10,2) NOT NULL DEFAULT 0,
    FOREIGN KEY (emp_id) REFERENCES employee(emp_id) ON DELETE CASCADE
);

-- Seed demo HR user (plain for demo; change to hashed in production)
INSERT INTO hr(username,email,phone,password) VALUES ('admin','admin@example.com','9999999999','admin123');

-- Seed sample employees
INSERT INTO employee(name,email,join_date,dept,designation) VALUES
('Asha Rao','asha@company.com','2024-04-01','IT','Developer'),
('Vikram Patel','vikram@company.com','2024-05-15','HR','Recruiter');

-- Seed sample recruitment
INSERT INTO recruitment(dept,job_role,appl_date,status) VALUES
('IT','Backend Dev','2025-08-01','open'),
('Finance','Accountant','2025-08-10','closed');

-- Seed sample attendance
INSERT INTO attendance(emp_id,date,time_in,time_out) VALUES
(1,'2025-08-10','09:30:00','18:30:00'),
(2,'2025-08-10','10:00:00','19:00:00');

-- Seed sample performance
INSERT INTO perf_review(emp_id,rating,review_date) VALUES
(1,9,'2025-08-05'),
(2,8,'2025-08-06');

-- Seed sample payroll
INSERT INTO payroll(emp_id,pay_month,salary,bonus) VALUES
(1,'2025-08',85000,5000),
(2,'2025-08',60000,3000);
