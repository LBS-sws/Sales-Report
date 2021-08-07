CREATE DATABASE swoper CHARACTER SET utf8 COLLATE utf8_general_ci;

GRANT SELECT, INSERT, UPDATE, DELETE, EXECUTE ON swoper.* TO 'swuser'@'localhost' IDENTIFIED BY 'swisher168';

use swoper;

DROP TABLE IF EXISTS `swo_notification`;
CREATE TABLE `swo_notification` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `system_id` varchar(15) NOT NULL,
  `note_type` varchar(5) DEFAULT NULL,
  `subject` varchar(1000) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `message` longtext,
  `lcu` varchar(30) DEFAULT NULL,
  `luu` varchar(30) DEFAULT NULL,
  `lcd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lud` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `swo_notification_action`;
CREATE TABLE `swo_notification_action` (
  `note_id` int(10) unsigned NOT NULL,
  `username` varchar(30) NOT NULL,
  `form_id` varchar(100) NOT NULL,
  `rec_id` int(10) unsigned NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'N',
  `lcu` varchar(30) DEFAULT NULL,
  `luu` varchar(30) DEFAULT NULL,
  `lcd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lud` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `idx_notification_action_01` (`note_id`,`username`),
  KEY `idx_notification_action_02` (`form_id`,`rec_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `swo_notification_user`;
CREATE TABLE `swo_notification_user` (
  `note_id` int(10) unsigned NOT NULL,
  `username` varchar(30) NOT NULL,
  `status` char(1) DEFAULT 'N',
  `lcu` varchar(30) DEFAULT NULL,
  `luu` varchar(30) DEFAULT NULL,
  `lcd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lud` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `notification_user` (`note_id`,`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
