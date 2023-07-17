-- --------------------------------------------------------

-- Host:                         127.0.0.1

-- Server version:               8.0.33 - MySQL Community Server - GPL

-- Server OS:                    Win64

-- HeidiSQL Version:             11.2.0.6213

-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */

;

/*!40101 SET NAMES utf8 */

;

/*!50503 SET NAMES utf8mb4 */

;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */

;

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */

;

/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */

;

-- Dumping database structure for graceful_glam

CREATE DATABASE
    IF NOT EXISTS `graceful_glam`
    /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */
    /*!80016 DEFAULT ENCRYPTION='N' */
;

USE `graceful_glam`;

-- Dumping structure for table graceful_glam.categories

CREATE TABLE
    IF NOT EXISTS `categories` (
        `id` int NOT NULL AUTO_INCREMENT,
        `name` varchar(255) DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE = InnoDB AUTO_INCREMENT = 11 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table graceful_glam.orders

CREATE TABLE
    IF NOT EXISTS `orders` (
        `id` int NOT NULL AUTO_INCREMENT,
        `user_id` int DEFAULT NULL,
        `order_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
        `total_amount` decimal(10, 2) DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`) USING BTREE,
        KEY `user_id` (`user_id`),
        CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
    ) ENGINE = InnoDB AUTO_INCREMENT = 2 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table graceful_glam.order_items

CREATE TABLE
    IF NOT EXISTS `order_items` (
        `id` int NOT NULL AUTO_INCREMENT,
        `order_id` int DEFAULT NULL,
        `product_id` int DEFAULT NULL,
        `quantity` int DEFAULT NULL,
        `price` decimal(10, 2) DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `order_id` (`order_id`),
        KEY `product_id` (`product_id`),
        CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
        CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
    ) ENGINE = InnoDB AUTO_INCREMENT = 2 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table graceful_glam.products

CREATE TABLE
    IF NOT EXISTS `products` (
        `id` int NOT NULL AUTO_INCREMENT,
        `name` varchar(255) DEFAULT NULL,
        `description` text,
        `price` decimal(10, 2) DEFAULT NULL,
        `category_id` int DEFAULT NULL,
        `subcategory_id` int DEFAULT NULL,
        `stock` int DEFAULT '0',
        `sold` int DEFAULT '0',
        `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `category_id` (`category_id`),
        KEY `subcategory_id` (`subcategory_id`),
        CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
        CONSTRAINT `products_ibfk_2` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`)
    ) ENGINE = InnoDB AUTO_INCREMENT = 15 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table graceful_glam.product_images

CREATE TABLE
    IF NOT EXISTS `product_images` (
        `id` int NOT NULL AUTO_INCREMENT,
        `product_id` int DEFAULT NULL,
        `image_path` varchar(255) DEFAULT NULL,
        `is_primary` tinyint(1) DEFAULT '0',
        `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `product_id` (`product_id`),
        CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
    ) ENGINE = InnoDB AUTO_INCREMENT = 30 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table graceful_glam.subcategories

CREATE TABLE
    IF NOT EXISTS `subcategories` (
        `id` int NOT NULL AUTO_INCREMENT,
        `name` varchar(255) NOT NULL,
        `category_id` int DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `category_id` (`category_id`),
        CONSTRAINT `subcategories_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
    ) ENGINE = InnoDB AUTO_INCREMENT = 19 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table graceful_glam.users

CREATE TABLE
    IF NOT EXISTS `users` (
        `id` int NOT NULL AUTO_INCREMENT,
        `name` varchar(255) DEFAULT NULL,
        `email` varchar(255) DEFAULT NULL,
        `phone_number` varchar(255) NOT NULL,
        `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'user',
        `password` varchar(255) DEFAULT NULL,
        `address` varchar(255) DEFAULT NULL,
        `city` varchar(255) DEFAULT NULL,
        `state` varchar(255) DEFAULT NULL,
        `zip_code` varchar(10) DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `email` (`email`)
    ) ENGINE = InnoDB AUTO_INCREMENT = 6 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */

;

/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */

;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */

;

/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */

;