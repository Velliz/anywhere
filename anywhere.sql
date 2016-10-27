/*
Navicat MySQL Data Transfer

Source Server         : Microcap Server
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : anywhere

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2016-10-11 16:00:00
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
  `html` varchar(255) NOT NULL,
  `css` varchar(255) NOT NULL,
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
INSERT INTO `pdf` VALUES ('1', '3', 'Test Tags', 'HTML-PDF-22-08-2016-160528.html', 'CSS-PDF-22-08-2016-160528.css', 'Inline', 'A4', 'POST', '', '{\r\n	\"data\": \"Didit Velliz\"\r\n}');
INSERT INTO `pdf` VALUES ('2', '3', 'PDF-24-08-2016-010708.pdf', 'HTML-PDF-24-08-2016-010708.html', 'CSS-PDF-24-08-2016-010708.css', 'Inline', 'A4', 'POST', '', '');

-- ----------------------------
-- Table structure for status
-- ----------------------------
DROP TABLE IF EXISTS `status`;
CREATE TABLE `status` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of status
-- ----------------------------
INSERT INTO `status` VALUES ('1', 'Free Plan');
INSERT INTO `status` VALUES ('2', 'Personal Plan');
INSERT INTO `status` VALUES ('3', 'Businnes Plan');
INSERT INTO `status` VALUES ('4', 'Unlimited Plan');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('3', 'Microcapital Client', 'microcapid', '686bda3fd91988ca80c4cc798ebe3130', 'microcapid@gmail.com', 'ff3d7d8be708cdf2a3d24a6f0010102a', '1');
