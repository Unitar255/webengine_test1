/*SCHEMA SQL*/

-- Create database (optional if you already created it)
-- CREATE DATABASE workshop_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE workshop_db;

-- Users
CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin','customer') NOT NULL DEFAULT 'customer',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Services (what the workshop offers)
CREATE TABLE IF NOT EXISTS services (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  duration_minutes SMALLINT UNSIGNED NOT NULL DEFAULT 60,
  active TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Appointments
CREATE TABLE IF NOT EXISTS appointments (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  service_id INT UNSIGNED NOT NULL,
  vehicle_make VARCHAR(80) NOT NULL,
  vehicle_model VARCHAR(80) NOT NULL,
  plate_no VARCHAR(20) NOT NULL,
  appointment_date DATE NOT NULL,
  appointment_time TIME NOT NULL,
  status ENUM('pending','approved','completed','cancelled') NOT NULL DEFAULT 'pending',
  notes TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_appt_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_appt_service FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE RESTRICT,
  INDEX idx_appt_date_time (appointment_date, appointment_time),
  INDEX idx_appt_user (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Simple contact messages (optional page)
CREATE TABLE IF NOT EXISTS contacts (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL,
  subject VARCHAR(150) NOT NULL,
  message TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;