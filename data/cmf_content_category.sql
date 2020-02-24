/*
Navicat MySQL Data Transfer

Source Server         : MYSQL57
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : demo

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2020-02-24 16:12:26
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cmf_content_category
-- ----------------------------
DROP TABLE IF EXISTS `cmf_content_category`;
CREATE TABLE `cmf_content_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '栏目编号',
  `name` varchar(255) DEFAULT NULL COMMENT '栏目名称',
  `description` text COMMENT '栏目描述',
  `image` text COMMENT '栏目图片',
  `type` int(11) DEFAULT NULL COMMENT '栏目类型',
  `category_id` int(11) DEFAULT '0' COMMENT '所属栏目',
  `status` int(11) DEFAULT '1' COMMENT '栏目状态',
  `sort` int(11) DEFAULT '1000' COMMENT '栏目排序',
  `model_id` int(11) DEFAULT NULL COMMENT '所属模型',
  `seo_title` varchar(255) DEFAULT NULL COMMENT 'SEO标题',
  `seo_keyword` varchar(255) DEFAULT NULL COMMENT 'SEO关键词',
  `seo_description` text COMMENT 'SEO描述',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;
