/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : lbs_xcx

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2022-04-21 10:27:07
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `lbs_service_servicematerials`
-- ----------------------------
DROP TABLE IF EXISTS `lbs_service_servicematerials`;
CREATE TABLE `lbs_service_servicematerials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(11) DEFAULT NULL COMMENT '城市代码（CD）',
  `service_type` varchar(50) DEFAULT NULL COMMENT '服务类型',
  `material_ids` varchar(50) DEFAULT NULL COMMENT '可选物料id',
  `creat_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lbs_service_servicematerials
-- ----------------------------
