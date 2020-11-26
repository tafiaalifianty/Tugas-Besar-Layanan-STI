-- DROP DATABASE IF EXISTS `foodordering`;

-- CREATE DATABASE IF NOT EXISTS `foodordering` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- USE `foodordering`;

/*Table structure for table `admin` */

CREATE TABLE `admin` (
  `username` VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` CHAR(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` VARCHAR(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `food` */

CREATE TABLE `food` (
  `name` VARCHAR(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `price` INT(10) UNSIGNED NOT NULL,
  `image` VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `paket` */

CREATE TABLE `paket` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `konten_paket` */

CREATE TABLE `konten_paket` (
  `id_food` INT(10) UNSIGNED NOT NULL,
  `id_paket` INT(10) UNSIGNED NOT NULL,
  `food_qty` TINYINT(3) UNSIGNED NOT NULL,
  KEY `pd_f` (`id_food`),
  KEY `pd_p` (`id_paket`),
  CONSTRAINT `pd_f` FOREIGN KEY (`id_food`) REFERENCES `food` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pd_p` FOREIGN KEY (`id_paket`) REFERENCES `paket` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `order` */

CREATE TABLE `order` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `total_price` INT(10) UNSIGNED NOT NULL,
  `total_items` TINYINT(3) UNSIGNED NOT NULL,
  `status` TINYINT(1) NOT NULL DEFAULT '0',
  `cust_name` VARCHAR(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cust_phone` VARCHAR(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `order_detail_food` */

CREATE TABLE `order_detail_food` (
  `id_food` INT(10) UNSIGNED NOT NULL,
  `subtotal` INT(10) UNSIGNED NOT NULL,
  `quantity` TINYINT(3) UNSIGNED NOT NULL,
  `id_order` INT(10) UNSIGNED NOT NULL,
  KEY `odf_f` (`id_food`),
  KEY `odf_o` (`id_order`),
  CONSTRAINT `odf_f` FOREIGN KEY (`id_food`) REFERENCES `food` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `odf_o` FOREIGN KEY (`id_order`) REFERENCES `order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `order_detail_paket` */

CREATE TABLE `order_detail_paket` (
  `id_paket` INT(10) UNSIGNED NOT NULL,
  `subtotal` INT(10) UNSIGNED NOT NULL,
  `quantity` TINYINT(3) UNSIGNED NOT NULL,
  `id_order` INT(10) UNSIGNED NOT NULL,
  KEY `odp_p` (`id_paket`),
  KEY `odp_o` (`id_order`),
  CONSTRAINT `odp_o` FOREIGN KEY (`id_order`) REFERENCES `order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `odp_p` FOREIGN KEY (`id_paket`) REFERENCES `paket` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
