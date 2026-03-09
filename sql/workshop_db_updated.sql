-- phpMyAdmin SQL Dump (updated)
-- Use this file to import into phpMyAdmin instead of the original

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
SET NAMES utf8mb4;

-- Database: `workshop_db`

CREATE TABLE IF NOT EXISTS `appointments` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `service_id` int(10) UNSIGNED NOT NULL,
  `vehicle_make` varchar(80) NOT NULL,
  `vehicle_model` varchar(80) NOT NULL,
  `plate_no` varchar(20) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `status` enum('pending','approved','completed','cancelled') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_appt_service` (`service_id`),
  KEY `idx_appt_date_time` (`appointment_date`,`appointment_time`),
  KEY `idx_appt_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `appointments` (`id`, `user_id`, `service_id`, `vehicle_make`, `vehicle_model`, `plate_no`, `appointment_date`, `appointment_time`, `status`, `notes`, `created_at`) VALUES
(1, 2, 1, 'Proton', 'WAJA', 'BHG1325', '2026-04-06', '15:30:00', 'pending', '', '2026-02-28 08:05:08'),
(2, 3, 5, 'Toyota', 'Camry', 'JTE2311', '2026-03-09', '15:05:00', 'pending', '', '2026-02-28 14:31:23'),
(3, 4, 3, 'Honda', 'City', 'JTE3231', '2026-03-11', '15:45:00', 'pending', '', '2026-02-28 14:45:59');

CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `email` varchar(190) NOT NULL,
  `subject` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `services` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `duration_minutes` smallint(5) UNSIGNED NOT NULL DEFAULT 60,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `services` (`id`, `name`, `price`, `duration_minutes`, `active`) VALUES
(1, 'Basic Service', 120.00, 60, 1),
(2, 'Engine Diagnostics', 150.00, 60, 1),
(3, 'Brake Inspection', 80.00, 45, 1),
(4, 'Aircond Service', 180.00, 90, 1),
(5, 'Tyre Replacement (per tyre)', 90.00, 30, 1);

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `full_name` varchar(120) NOT NULL,
  `email` varchar(190) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','customer','mechanic') NOT NULL DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ⚠️  Admin account: email=admin@workshop.my  password=admin1234  (change after first login!)
-- Hash below is bcrypt for "admin1234"
INSERT INTO `users` (`id`, `full_name`, `email`, `password_hash`, `role`, `created_at`) VALUES
(1, 'Admin', 'admin@workshop.my', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '2026-01-01 00:00:00'),
(2, 'Aaron Hanson', 'hansonarron@email.com', '$2y$10$RB/Y8pRli/Go9lTuJXo.WeLaRlrEGpq9EKS8.FbzANCFN0iJrwmrm', 'customer', '2026-02-28 08:01:34'),
(3, 'Hanson Teng', 'hangteng45@hotmail.com', '$2y$10$RNLYvJ72qUE7dOH3LwzQE.d3NlbN3GLu/RyXk0KzYElsLfqiPJVsW', 'customer', '2026-02-28 14:30:03'),
(4, 'Aaron Pham', 'phamaaron23@yahoo.com', '$2y$10$7RdXusVftoa4Hs4hZ/wide2oUoTZp9RPc3KZWdsjcQTZHjqN7d/z6', 'customer', '2026-02-28 14:44:31');

ALTER TABLE `appointments`
  ADD CONSTRAINT `fk_appt_service` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`),
  ADD CONSTRAINT `fk_appt_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

COMMIT;
