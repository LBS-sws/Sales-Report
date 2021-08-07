CREATE DATABASE security CHARACTER SET utf8 COLLATE utf8_general_ci;

GRANT SELECT, INSERT, UPDATE, DELETE, EXECUTE ON security.* TO 'swpuser'@'localhost' IDENTIFIED BY 'swisher168';

use security;

DROP TABLE IF EXISTS `sec_city`;
CREATE TABLE `sec_city` (
  `code` char(5) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `region` char(5) DEFAULT NULL,
  `incharge` varchar(30) DEFAULT NULL,
  `lcu` varchar(30) DEFAULT NULL,
  `luu` varchar(30) DEFAULT NULL,
  `lcd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lud` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `sec_city_info`;
CREATE TABLE `sec_city_info` (
  `code` char(5) NOT NULL,
  `field_id` varchar(30) NOT NULL,
  `field_value` varchar(2000) DEFAULT NULL,
  `lcu` varchar(30) DEFAULT NULL,
  `luu` varchar(30) DEFAULT NULL,
  `lcd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lud` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`code`),
  UNIQUE KEY `idx_sec_city_info_1` (`code`,`field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `sec_extsys_queue`;
CREATE TABLE `sec_extsys_queue` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sys_id` varchar(30) NOT NULL,
  `action` varchar(10) NOT NULL,
  `req_dt` datetime DEFAULT NULL,
  `fin_dt` datetime DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  `old_param` varchar(2000) DEFAULT NULL,
  `new_param` varchar(2000) DEFAULT NULL,
  `status` char(1) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=357 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `sec_login_log`;
CREATE TABLE `sec_login_log` (
  `station_id` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `client_ip` varchar(20) DEFAULT NULL,
  `login_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `sec_station`;
CREATE TABLE `sec_station` (
  `station_id` varchar(30) NOT NULL,
  `station_name` varchar(30) NOT NULL,
  `city` char(5) NOT NULL,
  `status` char(1) DEFAULT 'Y',
  `lcu` varchar(30) DEFAULT NULL,
  `luu` varchar(30) DEFAULT NULL,
  `lcd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lud` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`station_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `sec_station_request`;
CREATE TABLE `sec_station_request` (
  `req_key` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `station_name` varchar(30) NOT NULL,
  `city` char(5) NOT NULL,
  `station_id` varchar(30) DEFAULT NULL,
  `lcu` varchar(30) DEFAULT NULL,
  `luu` varchar(30) DEFAULT NULL,
  `lcd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lud` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`req_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `sec_template`;
CREATE TABLE `sec_template` (
  `temp_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `system_id` varchar(15) NOT NULL,
  `temp_name` varchar(255) NOT NULL,
  `a_read_only` varchar(255) DEFAULT '',
  `a_read_write` varchar(255) DEFAULT '',
  `a_control` varchar(255) DEFAULT '',
  `lcu` varchar(30) DEFAULT NULL,
  `luu` varchar(30) DEFAULT NULL,
  `lcd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lud` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`temp_id`),
  KEY `idx_sec_template_01` (`system_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `sec_template_info`;
CREATE TABLE `sec_template_info` (
  `temp_id` int(10) unsigned NOT NULL,
  `field_id` varchar(30) NOT NULL,
  `field_value` varchar(2000) DEFAULT NULL,
  `lcu` varchar(30) DEFAULT NULL,
  `luu` varchar(30) DEFAULT NULL,
  `lcd` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `lud` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `template_info` (`temp_id`,`field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `sec_user`;
CREATE TABLE `sec_user` (
  `username` varchar(30) NOT NULL,
  `password` varchar(128) DEFAULT NULL,
  `disp_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `logon_time` datetime DEFAULT NULL,
  `logoff_time` datetime DEFAULT NULL,
  `status` char(1) DEFAULT NULL,
  `fail_count` tinyint(3) unsigned DEFAULT '0',
  `locked` char(1) DEFAULT 'N',
  `session_key` varchar(500) DEFAULT NULL,
  `city` char(5) NOT NULL DEFAULT '',
  `lcu` varchar(30) DEFAULT NULL,
  `luu` varchar(30) DEFAULT NULL,
  `lcd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lud` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `sec_user_access`;
CREATE TABLE `sec_user_access` (
  `username` varchar(30) NOT NULL,
  `system_id` varchar(15) NOT NULL,
  `a_read_only` varchar(1000) DEFAULT NULL,
  `a_read_write` varchar(1000) DEFAULT NULL,
  `a_control` varchar(1000) DEFAULT NULL,
  `lcu` varchar(30) DEFAULT NULL,
  `luu` varchar(30) DEFAULT NULL,
  `lcd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lud` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `idx_sec_user_access_01` (`username`,`system_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `sec_user_info`;
CREATE TABLE `sec_user_info` (
  `username` varchar(30) NOT NULL,
  `field_id` varchar(30) NOT NULL,
  `field_value` varchar(2000) DEFAULT NULL,
  `field_blob` longblob,
  `lcu` varchar(30) DEFAULT NULL,
  `luu` varchar(30) DEFAULT NULL,
  `lcd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lud` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `user_info` (`username`,`field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `sec_user_option`;
CREATE TABLE `sec_user_option` (
  `username` varchar(30) NOT NULL,
  `option_key` varchar(30) NOT NULL,
  `option_value` varchar(255) DEFAULT NULL,
  UNIQUE KEY `idx_sec_user_option_1` (`username`,`option_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `sec_user_token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sec_user_token` (
  `username` varchar(30) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expiry` datetime DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `sec_wservice`;
CREATE TABLE `sec_wservice` (
  `wsvc_key` varchar(50) NOT NULL,
  `wsvc_desc` varchar(100) NOT NULL,
  `city` char(5) NOT NULL,
  `session_key` varchar(50) DEFAULT NULL,
  `session_time` datetime DEFAULT NULL,
  PRIMARY KEY (`wsvc_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
