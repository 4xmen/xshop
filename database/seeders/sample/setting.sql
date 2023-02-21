-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.5.15-MariaDB-0+deb11u1 - Debian 11
-- Server OS:                    debian-linux-gnu
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table xshop.settings
DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `section` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table xshop.settings: ~24 rows (approximately)
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
REPLACE INTO `settings` (`id`, `section`, `type`, `title`, `active`, `key`, `value`, `created_at`, `updated_at`) VALUES
	(1, '1menu', 'image', 'لوگو', 1, 'logo_png', NULL, '2022-08-02 04:44:57', '2022-08-02 04:44:57'),
	(2, '2top', 'text', 'عنوان قسمت اصلی', 1, 'top1text', 'محصولات پر فروش', '2022-08-02 04:53:04', '2022-08-02 05:23:03'),
	(3, '2top', 'cat', 'دسته قسمت اصلی', 1, 'top1cat', '1', '2022-08-02 04:53:35', '2022-08-02 05:23:57'),
	(4, '2top', 'text', 'عنوان قسمت بالا', 1, 'top2text', '33%', '2022-08-02 04:53:04', '2022-08-02 05:24:06'),
	(5, '2top', 'cat', 'دسته قسمت بالا', 1, 'top2cat', '1', '2022-08-02 04:53:35', '2022-08-02 05:24:06'),
	(6, '2top', 'text', 'عنوان قسمت پایین', 1, 'top3text', '15%', '2022-08-02 04:53:04', '2022-08-02 05:24:06'),
	(7, '2top', 'cat', 'دسته قسمت پایین', 1, 'top3cat', '1', '2022-08-02 04:53:35', '2022-08-02 05:24:06'),
	(8, '3top', 'text', 'عنوان قسمت دوم', 1, 'sectext', 'سایر محصولات', '2022-08-02 04:53:04', '2022-08-02 05:24:06'),
	(9, '3top', 'cat', 'دسته قسمت دوم', 1, 'seccat', '1', '2022-08-02 04:53:35', '2022-08-02 05:24:06'),
	(10, '4sec', 'text', 'عنوان قسمت سوم فیلتر دار', 1, '3text', 'لوازم جانبی', '2022-08-02 05:03:47', '2022-08-02 05:24:06'),
	(11, '4sec', 'cat', 'دسته قسمت سوم فیلتر دار', 1, '3cat', '1', '2022-08-02 05:04:35', '2022-08-02 05:24:06'),
	(12, '5sec', 'cat', 'دسته برند', 1, '4cat', '1', '2022-08-02 05:04:35', '2022-08-02 05:24:06'),
	(13, '6footer', 'category', 'دسته فوتر سمت راست', 1, 'footer1', '1', '2022-08-02 05:08:10', '2022-08-02 05:24:06'),
	(14, '6footer', 'category', 'فوتر وسط', 1, 'footer2', '4', '2022-08-02 05:08:42', '2022-09-12 05:57:55'),
	(15, '6footer', 'code', 'فوتر سمت راست', 1, 'footer3', '<img src="http://parsavps.com/enamad.png" width="145px" />', '2022-08-02 05:10:14', '2022-08-02 05:31:52'),
	(16, '6footer', 'text', 'شبکه اجتماعی ایستاگرام', 1, 'soc_in', NULL, '2022-08-02 05:11:20', '2022-08-02 05:11:20'),
	(17, '6footer', 'text', 'شبکه اجتماعی تلگرام', 1, 'soc_tg', NULL, '2022-08-02 05:11:20', '2022-08-02 05:11:20'),
	(18, '6footer', 'text', 'شبکه اجتماعی توییتر', 1, 'soc_tw', 'https://twitter.com/a1gard', '2022-08-02 05:11:20', '2022-08-02 05:24:06'),
	(19, '6footer', 'text', 'شبکه اجتماعی واستاپ (شماره با کد کشور)', 1, 'soc_wp', '+989121234567', '2022-08-02 05:11:20', '2022-08-02 05:27:02'),
	(20, '6footer', 'text', 'شبکه اجتماعی یوتویب', 1, 'soc_yt', NULL, '2022-08-02 05:11:20', '2022-08-02 05:11:20'),
	(21, '7seo', 'text', 'کد رنگ سایت', 1, 'color', '#3593D2', '2022-08-02 05:18:38', '2022-08-02 05:24:06'),
	(22, '7seo', 'text', 'سئو کلمات کلیدی', 1, 'keywords', 'فروشگاه، فروش آنلاین', '2022-08-02 05:19:10', '2022-08-02 05:24:06'),
	(23, '7seo', 'text', 'سئو جزئیات', 1, 'desc', 'توضیحات فروشگاه شما', '2022-08-02 05:20:08', '2022-08-02 05:24:06'),
	(24, '7seo', 'text', 'متن کپی رایت', 1, 'copyright', 'کلیه حقوق برای وبسایت فروشگاه محفوظ است', '2022-08-02 05:40:18', '2022-08-02 05:40:37');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
