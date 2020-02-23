/*
Navicat MySQL Data Transfer

Source Server         : MYSQL57
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : demo

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2020-02-23 21:03:15
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cmf_content_model
-- ----------------------------
DROP TABLE IF EXISTS `cmf_content_model`;
CREATE TABLE `cmf_content_model` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '模型编号',
  `name` varchar(255) DEFAULT NULL COMMENT '模型名称',
  `field` varchar(255) DEFAULT NULL COMMENT '模型键名',
  `status` int(11) DEFAULT '1' COMMENT '模型状态',
  `sort` int(11) DEFAULT '1000' COMMENT '模型排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
