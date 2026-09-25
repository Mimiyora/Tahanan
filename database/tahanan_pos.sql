-- Tahanan Coffee House POS
-- MySQL database export for IT0049 TFA2

CREATE DATABASE IF NOT EXISTS `tahanan_pos`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;

USE `tahanan_pos`;

DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `customers`;

CREATE TABLE `customers` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `full_name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `phone` VARCHAR(20) NULL,
    `created_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `users` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(50) NOT NULL,
    `full_name` VARCHAR(100) NOT NULL,
    `created_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `customers` (`full_name`, `email`, `phone`, `created_at`) VALUES
('Isabella Santos', 'isabella.santos@example.com', '+63 917 234 0182', '2026-09-01 09:15:00'),
('Miguel Reyes', 'miguel.reyes@example.com', '+63 905 682 4491', '2026-09-02 10:20:00'),
('Amara Villanueva', 'amara.v@example.com', '+63 998 410 7635', '2026-09-03 11:05:00'),
('Rafael de Leon', 'rafael.deleon@example.com', '+63 921 553 9076', '2026-09-04 14:30:00'),
('Sofia Mendoza', 'sofia.mendoza@example.com', '+63 945 319 2280', '2026-09-05 16:10:00'),
('Gabriel Navarro', 'gabriel.n@example.com', '+63 977 804 1159', '2026-09-06 08:45:00');

INSERT INTO `users` (`username`, `full_name`, `created_at`) VALUES
('ana.cruz', 'Ana Cruz', '2026-09-01 08:00:00'),
('paolo.lim', 'Paolo Lim', '2026-09-01 08:05:00'),
('mika.tan', 'Mika Tan', '2026-09-01 08:10:00'),
('nico.garcia', 'Nico Garcia', '2026-09-01 08:15:00'),
('bea.ramos', 'Bea Ramos', '2026-09-01 08:20:00'),
('luis.dizon', 'Luis Dizon', '2026-09-01 08:25:00');
