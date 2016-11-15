/*
Navicat MySQL Data Transfer

Source Server         : PC Local
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : anywhere

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-11-15 16:11:27
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for pdf
-- ----------------------------
DROP TABLE IF EXISTS `pdf`;
CREATE TABLE `pdf` (
  `PDFID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `reportname` varchar(255) NOT NULL,
  `html` text NOT NULL,
  `css` text NOT NULL,
  `outputmode` varchar(255) NOT NULL,
  `paper` varchar(255) NOT NULL,
  `requesttype` varchar(255) NOT NULL,
  `requesturl` varchar(255) NOT NULL,
  `requestsample` text NOT NULL,
  PRIMARY KEY (`PDFID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pdf
-- ----------------------------
INSERT INTO `pdf` VALUES ('1', '2', 'Laporan Kuning', '<div>\r\n	Welcome to Anywhere!\r\n    <br/>\r\n    {!Wonderfull}\r\n    <br/>\r\n    {!PDFID}\r\n</div>', 'body {\r\n	color: #000fff;\r\n}', 'Inline', 'B5', 'POST', '', '{\r\n\"Wonderfull\": \"Today is Wonderfull!!!\"\r\n}');
INSERT INTO `pdf` VALUES ('2', '2', 'Laporan Keuangan', '<div>Welcome to Anywhere!</div>', 'body {}', 'Inline', 'A4', 'POST', '', '');

-- ----------------------------
-- Table structure for status
-- ----------------------------
DROP TABLE IF EXISTS `status`;
CREATE TABLE `status` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of status
-- ----------------------------
INSERT INTO `status` VALUES ('1', 'Free Plan');
INSERT INTO `status` VALUES ('2', 'Personal Plan');
INSERT INTO `status` VALUES ('3', 'Bussiness Plan');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `apikey` varchar(255) NOT NULL,
  `statusID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'Nurcholid Achmad', 'dummyAdmin', '827ccb0eea8a706c4c34a16891f84e7b', 'admin@yahoo.co.id', 'b793b0baad9ed2a2db4b5774fc63de8a', '1');
INSERT INTO `users` VALUES ('2', 'Microcapital Client', 'velliz', '686bda3fd91988ca80c4cc798ebe3130', 'vernicariuz@yahoo.co.id', 'a6d063843a03639a9899945a3a9f0165', '1');
