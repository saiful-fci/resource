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

-- Dumping structure for table ems.goods_accessories
CREATE TABLE IF NOT EXISTS `goods_accessories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fk_goods_cat` int(4) unsigned NOT NULL,
  `fk_goods_subcat` int(4) unsigned DEFAULT NULL,
  `quantity` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `FK_goods_accessories_goods_cat` (`fk_goods_cat`),
  KEY `FK_goods_accessories_goods_subcat` (`fk_goods_subcat`),
  CONSTRAINT `FK_goods_accessories_goods_cat` FOREIGN KEY (`fk_goods_cat`) REFERENCES `goods_cat` (`id`),
  CONSTRAINT `FK_goods_accessories_goods_subcat` FOREIGN KEY (`fk_goods_subcat`) REFERENCES `goods_subcat` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table ems.goods_accessories: ~0 rows (approximately)
/*!40000 ALTER TABLE `goods_accessories` DISABLE KEYS */;
INSERT INTO `goods_accessories` (`id`, `fk_goods_cat`, `fk_goods_subcat`, `quantity`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, '3', '2020-03-17 17:29:46', NULL);
/*!40000 ALTER TABLE `goods_accessories` ENABLE KEYS */;

-- Dumping structure for table ems.goods_cat
CREATE TABLE IF NOT EXISTS `goods_cat` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `view_order` int(4) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_name` (`category_name`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table ems.goods_cat: ~1 rows (approximately)
/*!40000 ALTER TABLE `goods_cat` DISABLE KEYS */;
INSERT INTO `goods_cat` (`id`, `category_name`, `view_order`, `created_at`, `updated_at`) VALUES
	(1, 'Electronics', 1, '2020-03-17 17:28:48', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `goods_cat` ENABLE KEYS */;

-- Dumping structure for table ems.goods_subcat
CREATE TABLE IF NOT EXISTS `goods_subcat` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `fk_goods_cat_id` int(4) unsigned NOT NULL,
  `goods_SubCat_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `view_order` int(4) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `goods _SubCat_name` (`goods_SubCat_name`),
  KEY `FK_goods_subcat_goods_cat` (`fk_goods_cat_id`),
  CONSTRAINT `FK_goods_subcat_goods_cat` FOREIGN KEY (`fk_goods_cat_id`) REFERENCES `goods_cat` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table ems.goods_subcat: ~0 rows (approximately)
/*!40000 ALTER TABLE `goods_subcat` DISABLE KEYS */;
INSERT INTO `goods_subcat` (`id`, `fk_goods_cat_id`, `goods_SubCat_name`, `view_order`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Tv', 1, '2020-03-17 17:29:00', NULL);
/*!40000 ALTER TABLE `goods_subcat` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
