# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 172.17.0.6 (MySQL 5.6.24)
# Database: szepulhu_db
# Generation Time: 2015-07-15 04:52:02 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


DROP TABLE IF EXISTS `Country`;

CREATE TABLE `Country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_9CCEF0FA5E237E06` (`name`),
  UNIQUE KEY `UNIQ_9CCEF0FA989D9B62` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `Country` WRITE;
/*!40000 ALTER TABLE `Country` DISABLE KEYS */;

INSERT INTO `Country` (`id`, `name`, `slug`)
VALUES
	(1,'Magyarország','magyarorszag');

/*!40000 ALTER TABLE `Country` ENABLE KEYS */;
UNLOCK TABLES;



# Dump of table County
# ------------------------------------------------------------

LOCK TABLES `County` WRITE;
/*!40000 ALTER TABLE `County` DISABLE KEYS */;

INSERT INTO `County` (`id`, `country_id`, `name`, `slug`)
VALUES
	(1,1,'Bács-Kiskun','bacs-kiskun'),
	(2,1,'Baranya','baranya'),
	(3,1,'Békés','bekes'),
	(4,1,'Borsod-Abaúj-Zemplén','borsod-abauj-zemplen'),
	(5,1,'Csongrád','csongrad'),
	(6,1,'Fejér','fejer'),
	(7,1,'Győr-Moson-Sopron','gyor-moson-sopron'),
	(8,1,'Hajdú-Bihar','hajdu-bihar'),
	(9,1,'Heves','heves'),
	(10,1,'Jász-Nagykun-Szolnok','jasz-nagykun-szolnok'),
	(11,1,'Komárom-Esztergom','komarom-esztergom'),
	(12,1,'Nógrád','nograd'),
	(13,1,'Pest','pest'),
	(14,1,'Somogy','somogy'),
	(15,1,'Szabolcs-Szatmár-Bereg','szabolcs-szatmar-bereg'),
	(16,1,'Tolna','tolna'),
	(17,1,'Vas','vas'),
	(18,1,'Veszprém','veszprem'),
	(19,1,'Zala','zala');

/*!40000 ALTER TABLE `County` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
