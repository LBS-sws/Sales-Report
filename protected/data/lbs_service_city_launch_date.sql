/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : service

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2022-03-03 10:23:39
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `lbs_service_city_launch_date`
-- ----------------------------
DROP TABLE IF EXISTS `lbs_service_city_launch_date`;
CREATE TABLE `lbs_service_city_launch_date` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(50) DEFAULT NULL COMMENT '城市编号',
  `launch_date` date DEFAULT NULL COMMENT '上限日期',
  `creat_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lbs_service_city_launch_date
-- ----------------------------
