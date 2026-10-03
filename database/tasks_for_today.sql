-- Tasks for Today Management System
-- MySQL database export for IT0049 TSA1

CREATE DATABASE IF NOT EXISTS `tahanan_tasks`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;

USE `tahanan_tasks`;

DROP TABLE IF EXISTS `tasks`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `tasks` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(150) NOT NULL,
    `status` VARCHAR(20) NOT NULL DEFAULT 'pending',
    `task_date` DATE NOT NULL,
    `created_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    KEY `tasks_task_date_index` (`task_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `users` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(50) NOT NULL,
    `full_name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `created_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tasks` (`title`, `status`, `task_date`, `created_at`) VALUES
('Confirm completed requirements from yesterday', 'completed', DATE_SUB(CURDATE(), INTERVAL 2 DAY), TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL 4 DAY), '09:00:00')),
('Organize project reference files', 'completed', DATE_SUB(CURDATE(), INTERVAL 1 DAY), TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL 3 DAY), '10:15:00')),
('Review daily priorities', 'completed', CURDATE(), TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL 1 DAY), '16:30:00')),
('Prepare project stand-up notes', 'in_progress', CURDATE(), TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL 1 DAY), '16:45:00')),
('Validate the task dashboard', 'pending', CURDATE(), TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL 1 DAY), '17:00:00')),
('Submit the progress update', 'pending', CURDATE(), TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL 1 DAY), '17:15:00')),
('Plan tomorrow''s development session', 'pending', DATE_ADD(CURDATE(), INTERVAL 1 DAY), TIMESTAMP(CURDATE(), '08:00:00')),
('Check open review comments', 'pending', DATE_ADD(CURDATE(), INTERVAL 1 DAY), TIMESTAMP(CURDATE(), '08:15:00')),
('Update the weekly task summary', 'pending', DATE_ADD(CURDATE(), INTERVAL 3 DAY), TIMESTAMP(CURDATE(), '08:30:00')),
('Archive finished project notes', 'pending', DATE_ADD(CURDATE(), INTERVAL 7 DAY), TIMESTAMP(CURDATE(), '08:45:00'));

INSERT INTO `users` (`username`, `full_name`, `email`, `created_at`) VALUES
('gerard.doroja', 'Gerard Doroja', 'gerard.doroja@example.com', NOW());
