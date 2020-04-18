-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.19-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table campus.authors
CREATE TABLE IF NOT EXISTS `authors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `author_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `author_description` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table campus.authors: ~2 rows (approximately)
/*!40000 ALTER TABLE `authors` DISABLE KEYS */;
INSERT INTO `authors` (`id`, `author_name`, `author_description`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'Humayon Ahammed', 'fgds', 1, '2020-03-29 11:55:05', '2020-03-29 12:12:38'),
	(2, 'Jafor Iqbal', 'ghg', 0, '2020-03-29 11:55:11', '2020-03-29 12:12:45');
/*!40000 ALTER TABLE `authors` ENABLE KEYS */;

-- Dumping structure for table campus.books
CREATE TABLE IF NOT EXISTS `books` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fk_book_name_id` int(10) unsigned NOT NULL,
  `available_qty` int(5) unsigned NOT NULL,
  `price` double(10,2) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fk_book_id` (`fk_book_name_id`),
  KEY `FK_books_entry_book_names` (`fk_book_name_id`),
  CONSTRAINT `FK_books_entry_book_names` FOREIGN KEY (`fk_book_name_id`) REFERENCES `books_name` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table campus.books: ~2 rows (approximately)
/*!40000 ALTER TABLE `books` DISABLE KEYS */;
INSERT INTO `books` (`id`, `fk_book_name_id`, `available_qty`, `price`, `status`, `created_at`, `updated_at`) VALUES
	(19, 7, 992, 1000.00, 1, '2020-03-29 10:18:54', NULL),
	(20, 8, 600, 600.00, 1, '2020-03-29 10:18:54', NULL);
/*!40000 ALTER TABLE `books` ENABLE KEYS */;

-- Dumping structure for table campus.books_name
CREATE TABLE IF NOT EXISTS `books_name` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `book_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `book_title` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_publisher_id` int(10) unsigned NOT NULL,
  `fk_author_id` int(10) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table campus.books_name: ~2 rows (approximately)
/*!40000 ALTER TABLE `books_name` DISABLE KEYS */;
INSERT INTO `books_name` (`id`, `book_name`, `book_title`, `fk_publisher_id`, `fk_author_id`, `status`, `created_at`, `updated_at`) VALUES
	(7, 'Programming', 'Programming', 4, 1, 1, '2020-03-29 10:17:37', '2020-03-29 12:28:34'),
	(8, 'Object Oriented', 'Object Oriented', 5, 1, 0, '2020-03-29 10:17:57', '2020-03-29 12:28:39');
/*!40000 ALTER TABLE `books_name` ENABLE KEYS */;

-- Dumping structure for table campus.book_borrow
CREATE TABLE IF NOT EXISTS `book_borrow` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fk_member_id` int(11) unsigned NOT NULL,
  `custom_student_id` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `fk_books_id` text COLLATE utf8_unicode_ci NOT NULL,
  `provide_date` date NOT NULL,
  `return_date` date NOT NULL,
  `fine` double(10,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(4) unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` tinyint(4) NOT NULL,
  `update_by` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table campus.book_borrow: ~2 rows (approximately)
/*!40000 ALTER TABLE `book_borrow` DISABLE KEYS */;
INSERT INTO `book_borrow` (`id`, `fk_member_id`, `custom_student_id`, `fk_books_id`, `provide_date`, `return_date`, `fine`, `status`, `created_at`, `updated_at`, `created_by`, `update_by`) VALUES
	(43, 6, '19019012', '["19"]', '2020-03-29', '2020-03-29', 0.00, 1, '2020-03-29 09:37:36', '2020-03-29 21:37:36', 1, 0),
	(44, 7, '19019014', '["19"]', '2020-03-29', '2020-03-29', 0.00, 1, '2020-03-29 09:39:27', '2020-03-29 21:39:27', 1, 0);
/*!40000 ALTER TABLE `book_borrow` ENABLE KEYS */;

-- Dumping structure for table campus.members
CREATE TABLE IF NOT EXISTS `members` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fk_custom_student_id` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `expiry_date` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `custom_student_id` (`fk_custom_student_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table campus.members: ~4 rows (approximately)
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
INSERT INTO `members` (`id`, `fk_custom_student_id`, `expiry_date`, `status`, `created_at`, `updated_at`) VALUES
	(6, '19019012', NULL, 0, '2020-03-29 10:16:19', '2020-03-29 10:16:19'),
	(7, '19019014', NULL, 0, '2020-03-29 10:16:34', '2020-03-29 10:16:34'),
	(8, '19019015', NULL, 0, '2020-03-29 10:16:43', '2020-03-29 10:16:43');
/*!40000 ALTER TABLE `members` ENABLE KEYS */;

-- Dumping structure for table campus.publishers
CREATE TABLE IF NOT EXISTS `publishers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `publisher_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `publisher_mobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `publisher_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `publisher_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table campus.publishers: ~2 rows (approximately)
/*!40000 ALTER TABLE `publishers` DISABLE KEYS */;
INSERT INTO `publishers` (`id`, `publisher_name`, `publisher_mobile`, `publisher_email`, `publisher_address`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'Al Fatah Publication', '01674855871', 'saiful.affb@gmail.com', 'Feni Sadar, Feni', 0, '2020-03-24 16:00:31', '2020-03-24 16:00:31'),
	(4, 'Al Imtehan', '01674855871', 'saiful.affb@gmail.com', 'Feni Sadar, Feni', 1, '2020-03-29 10:15:25', '2020-03-29 10:15:25'),
	(5, 'Lectur', '01767000234', 'saiful.affb@gmail.com', 'Feni Sadar, Feni', 0, '2020-03-29 10:15:55', '2020-03-29 10:15:55');
/*!40000 ALTER TABLE `publishers` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
