CREATE DATABASE announcement CHARACTER SET utf8 COLLATE utf8_general_ci;

GRANT SELECT, INSERT, UPDATE, DELETE, EXECUTE ON announcement.* TO 'swuser'@'localhost' IDENTIFIED BY 'swisher168';

use announcement;

DROP TABLE IF EXISTS `ann_announce`;
CREATE TABLE `ann_announce` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `start_dt` datetime NOT NULL,
  `end_dt` datetime NOT NULL,
  `priority` tinyint(4) NOT NULL DEFAULT '0',
  `content` text COLLATE utf8_unicode_ci,
  `image_caption` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_type` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` longblob,
  `lcu` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `luu` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lcd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lud` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
