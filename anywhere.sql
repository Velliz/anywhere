/*
Navicat MySQL Data Transfer

Source Server         : PC Local
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : anywhere

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-12-02 09:30:53
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for feedback
-- ----------------------------
DROP TABLE IF EXISTS `feedback`;
CREATE TABLE `feedback` (
  `feedbackID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `signature` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `feedback` text NOT NULL,
  `isapproved` tinyint(1) DEFAULT NULL,
  `approveddate` datetime DEFAULT NULL,
  `feedbackresponds` text,
  PRIMARY KEY (`feedbackID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for images
-- ----------------------------
DROP TABLE IF EXISTS `images`;
CREATE TABLE `images` (
  `IMAGEID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `imagename` varchar(255) DEFAULT NULL,
  `placeholdername` varchar(255) DEFAULT NULL,
  `placeholderfile` longblob,
  `x` double(255,0) DEFAULT NULL,
  `y` double(255,0) DEFAULT NULL,
  `x2` double DEFAULT NULL,
  `y2` double DEFAULT NULL,
  `w` double(255,0) DEFAULT NULL,
  `h` double(255,0) DEFAULT NULL,
  `requestsamplename` varchar(255) DEFAULT NULL,
  `requestsamplefile` longblob,
  PRIMARY KEY (`IMAGEID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for mail
-- ----------------------------
DROP TABLE IF EXISTS `mail`;
CREATE TABLE `mail` (
  `MAILID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `html` text,
  `css` text,
  `mailname` varchar(255) NOT NULL,
  `mailaddress` varchar(255) DEFAULT NULL,
  `mailpassword` varchar(255) DEFAULT NULL,
  `cc` varchar(255) DEFAULT NULL,
  `bcc` varchar(255) DEFAULT NULL,
  `replyto` varchar(255) DEFAULT NULL,
  `host` varchar(255) NOT NULL,
  `port` int(8) NOT NULL,
  `smtpauth` varchar(20) NOT NULL,
  `smtpsecure` varchar(20) NOT NULL,
  `requesttype` varchar(20) NOT NULL,
  `requesturl` varchar(155) NOT NULL,
  `requestsample` text,
  PRIMARY KEY (`MAILID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for pdf
-- ----------------------------
DROP TABLE IF EXISTS `pdf`;
CREATE TABLE `pdf` (
  `PDFID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `reportname` varchar(255) NOT NULL,
  `html` text,
  `css` text,
  `outputmode` varchar(255) NOT NULL,
  `paper` varchar(255) NOT NULL,
  `requesttype` varchar(255) NOT NULL,
  `requesturl` varchar(255) NOT NULL,
  `requestsample` text,
  PRIMARY KEY (`PDFID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

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
-- Table structure for testimonial
-- ----------------------------
DROP TABLE IF EXISTS `testimonial`;
CREATE TABLE `testimonial` (
  `testimonialID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `signature` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `testimonial` text NOT NULL,
  `isvalid` tinyint(4) DEFAULT NULL,
  `validationdate` datetime DEFAULT NULL,
  PRIMARY KEY (`testimonialID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
