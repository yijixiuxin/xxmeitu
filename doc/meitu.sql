/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50153
Source Host           : 127.0.0.1:3306
Source Database       : meitu

Target Server Type    : MYSQL
Target Server Version : 50153
File Encoding         : 65001

Date: 2013-08-10 07:35:54
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `leimu`
-- ----------------------------
DROP TABLE IF EXISTS `leimu`;
CREATE TABLE `leimu` (
  `lid` int(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '类目ID',
  `pid` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '类目父ID',
  `lname` varchar(20) NOT NULL DEFAULT '' COMMENT '类目名称',
  `status` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `ob` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`lid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of leimu
-- ----------------------------
INSERT INTO `leimu` VALUES ('1', '0', '清纯可爱', '1', '0');

-- ----------------------------
-- Table structure for `pic`
-- ----------------------------
DROP TABLE IF EXISTS `pic`;
CREATE TABLE `pic` (
  `pid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lid` int(5) unsigned NOT NULL,
  `yid` int(5) unsigned NOT NULL,
  `pname` varchar(100) NOT NULL,
  `ypicurl` varchar(100) NOT NULL,
  `hpicurl` varchar(100) NOT NULL,
  `mpicurl` varchar(100) NOT NULL,
  `lpicurl` varchar(100) NOT NULL,
  `status` int(1) unsigned NOT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pic
-- ----------------------------

-- ----------------------------
-- Table structure for `picyuan`
-- ----------------------------
DROP TABLE IF EXISTS `picyuan`;
CREATE TABLE `picyuan` (
  `yid` int(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '来源ID',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '来源名称',
  `url` varchar(100) NOT NULL DEFAULT '' COMMENT '来源URL',
  `class` varchar(20) NOT NULL DEFAULT '' COMMENT '处理来源的类',
  `status` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`yid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of picyuan
-- ----------------------------

-- ----------------------------
-- Table structure for `picyuanlei`
-- ----------------------------
DROP TABLE IF EXISTS `picyuanlei`;
CREATE TABLE `picyuanlei` (
  `ylid` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `yid` int(5) unsigned NOT NULL COMMENT '园id',
  `lurl` varchar(200) NOT NULL COMMENT '类目url',
  `lid` int(5) unsigned NOT NULL COMMENT '类目id',
  `func` varchar(20) NOT NULL COMMENT '处理图片的方法',
  `status` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`ylid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of picyuanlei
-- ----------------------------
