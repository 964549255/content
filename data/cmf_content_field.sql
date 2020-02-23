/*
Navicat MySQL Data Transfer

Source Server         : MYSQL57
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : demo

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2020-02-23 21:06:51
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cmf_content_field
-- ----------------------------
DROP TABLE IF EXISTS `cmf_content_field`;
CREATE TABLE `cmf_content_field` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '字段编号',
  `name` varchar(255) DEFAULT NULL COMMENT '字段名称',
  `field` varchar(255) DEFAULT NULL COMMENT '字段键名',
  `type` int(11) DEFAULT NULL COMMENT '字段类型',
  `default` varchar(255) DEFAULT NULL COMMENT '字段默认',
  `length` int(11) DEFAULT NULL COMMENT '字段长度',
  `vital` int(11) DEFAULT '-1' COMMENT '是否关键',
  `status` int(11) DEFAULT '1' COMMENT '字段状态',
  `sort` int(11) DEFAULT '1000' COMMENT '字段排序',
  `model_id` int(11) DEFAULT NULL COMMENT '所属模型',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
