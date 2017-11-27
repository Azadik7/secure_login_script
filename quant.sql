/*
Navicat MySQL Data Transfer

Source Server         : My_DB
Source Server Version : 50713
Source Host           : localhost:3306
Source Database       : quant

Target Server Type    : MYSQL
Target Server Version : 50713
File Encoding         : 65001

Date: 2017-11-18 19:08:02
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `block_users`
-- ----------------------------
DROP TABLE IF EXISTS `block_users`;
CREATE TABLE `block_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(100) DEFAULT NULL,
  `time` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of block_users
-- ----------------------------

-- ----------------------------
-- Table structure for `clients`
-- ----------------------------
DROP TABLE IF EXISTS `clients`;
CREATE TABLE `clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_usa` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_azn` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of clients
-- ----------------------------
INSERT INTO `clients` VALUES ('4', 'Elsever', 'Kemerbendi', '11/20/2017', '5', '5', '<a href=\"https://www.facebook.com/\">Hello</a>');
INSERT INTO `clients` VALUES ('5', 'Tural', 'Kemerbendi', '11/20/2017', '5', '5', '<a href=\"https://www.facebook.com/\">Hello</a>  SELECT * from members');
INSERT INTO `clients` VALUES ('9', 'Azad', 'Kemerbendi', '11/24/2017', '55', '55', 's');
INSERT INTO `clients` VALUES ('11', 'Azad', 'Kemerbendi', '11/17/2017', '55', '55', '');
INSERT INTO `clients` VALUES ('12', 'Azad', 'Kemerbendi', '11/17/2017', '55', '55', 's');
INSERT INTO `clients` VALUES ('16', 'Azad', 'Kemerbendi', '11/17/2017', '60', '60', 'Hello azad');
INSERT INTO `clients` VALUES ('18', 'sdf', 'sdf', '11/23/2017', '55', '55', 'sdf');
INSERT INTO `clients` VALUES ('19', 'Seldar', 'Kemerbendi', '11/23/2017', '450', '450', 'Helli i am Seldar from village Yeni-Heyat');
INSERT INTO `clients` VALUES ('22', 'Mamed', 'Memmedov', '11/17/2017', '456', '456', 'ffdgdfg');
INSERT INTO `clients` VALUES ('23', 'Cavanshir', 'Elekberov', '11/18/2017', '100', '170', 'Tets test test');

-- ----------------------------
-- Table structure for `login_attempts`
-- ----------------------------
DROP TABLE IF EXISTS `login_attempts`;
CREATE TABLE `login_attempts` (
  `user_id` int(11) NOT NULL,
  `time` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of login_attempts
-- ----------------------------
INSERT INTO `login_attempts` VALUES ('1', '1510951701');
INSERT INTO `login_attempts` VALUES ('1', '1511017286');

-- ----------------------------
-- Table structure for `members`
-- ----------------------------
DROP TABLE IF EXISTS `members`;
CREATE TABLE `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` char(128) NOT NULL,
  `salt` char(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of members
-- ----------------------------
INSERT INTO `members` VALUES ('1', 'Azad', 'test@rabite.com', 'e75c410bb4a9b12f8ec696435f518ede4afd639f2f8278978ef9f11e763564260f535b9d31fb9334b0b5261753abc323233ee8e7b2ff22048739067569b49360', 'e33a4b0114a60b9ee71283ed084f7f8db878628a79a557d4dedd5494af0861423518848cdd700cca7e6a4bcaa9f455297b7cac23e9aef2e1105625ee7ec1f373');
