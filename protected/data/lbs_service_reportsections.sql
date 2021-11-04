/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : service

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2021-11-04 10:30:12
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `lbs_service_reportsections`
-- ----------------------------
DROP TABLE IF EXISTS `lbs_service_reportsections`;
CREATE TABLE `lbs_service_reportsections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(11) DEFAULT NULL COMMENT '城市代码（CD）',
  `service_type` varchar(50) DEFAULT NULL COMMENT '服务类型',
  `section_ids` varchar(50) DEFAULT NULL COMMENT '报告板块（1-服务简报,2-物料使用,3-设备情况,4-风险更进,5-现场工作照）',
  `creat_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lbs_service_reportsections
-- ----------------------------
