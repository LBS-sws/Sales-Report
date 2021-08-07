CREATE DATABASE docman CHARACTER SET utf8 COLLATE utf8_general_ci;

GRANT SELECT, INSERT, UPDATE, DELETE, EXECUTE ON docman.* TO 'swpuser'@'localhost' IDENTIFIED BY 'swisher168';

use docman;

DROP TABLE IF EXISTS `dm_doc_type`;
CREATE TABLE `dm_doc_type` (
  `doc_type_code` varchar(10) NOT NULL,
  `doc_type_desc` varchar(255) DEFAULT NULL,
  `lcd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lud` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`doc_type_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `dm_file`;
CREATE TABLE `dm_file` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mast_id` int(10) unsigned NOT NULL,
  `phy_file_name` varchar(300) NOT NULL,
  `phy_path_name` varchar(100) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `archive` char(1) DEFAULT 'N',
  `remove` char(1) DEFAULT 'N',
  `lcu` varchar(30) DEFAULT NULL,
  `luu` varchar(30) DEFAULT NULL,
  `lcd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lud` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_dm_file_01` (`mast_id`)
) ENGINE=InnoDB AUTO_INCREMENT=683561 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `dm_master`;
CREATE TABLE `dm_master` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `doc_type_code` varchar(10) NOT NULL,
  `doc_id` int(10) unsigned NOT NULL,
  `remove` char(1) DEFAULT 'N',
  `lcu` varchar(30) DEFAULT NULL,
  `luu` varchar(30) DEFAULT NULL,
  `lcd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lud` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_master_01` (`doc_type_code`,`doc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=347280 DEFAULT CHARSET=utf8;

DELIMITER ;;
CREATE FUNCTION `countdoc`(doctype varchar(10), docid int unsigned) RETURNS int(11)
BEGIN
DECLARE no_of_doc int;
SELECT count(b.id) INTO no_of_doc FROM dm_master a, dm_file b
WHERE a.id = b.mast_id AND a.doc_type_code = doctype AND a.doc_id = docid AND b.remove<>'Y';
RETURN no_of_doc;
END ;;
DELIMITER ;
