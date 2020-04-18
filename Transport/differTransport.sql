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

-- Dumping structure for table campus.transport
CREATE TABLE IF NOT EXISTS `transport` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `route_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `amount` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table campus.transport: ~3 rows (approximately)
/*!40000 ALTER TABLE `transport` DISABLE KEYS */;
INSERT INTO `transport` (`id`, `route_name`, `amount`, `created_at`, `updated_at`) VALUES
	(1, 'Academy-Bazar', '300', '2020-03-21 21:27:09', '0000-00-00 00:00:00'),
	(2, 'Academy-Feni', '500', '2020-03-21 21:27:47', '0000-00-00 00:00:00'),
	(3, 'Academy-Chadgazi', '150', '2020-03-21 21:28:03', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `transport` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
