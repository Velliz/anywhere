/*
 Navicat Premium Data Transfer

 Source Server         : [LOCAL] LOCALHOST
 Source Server Type    : MySQL
 Source Server Version : 100206
 Source Host           : localhost:3306
 Source Schema         : anywhere

 Target Server Type    : MySQL
 Target Server Version : 100206
 File Encoding         : 65001

 Date: 08/03/2020 21:14:36
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for constanta
-- ----------------------------
DROP TABLE IF EXISTS `constanta`;
CREATE TABLE `constanta`  (
  `constID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `uniquekey` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `constantaval` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`constID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for excel
-- ----------------------------
DROP TABLE IF EXISTS `excel`;
CREATE TABLE `excel`  (
  `EXCELID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `excelname` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `columnspecs` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `dataspecs` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `requesttype` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`EXCELID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for feedback
-- ----------------------------
DROP TABLE IF EXISTS `feedback`;
CREATE TABLE `feedback`  (
  `feedbackID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `created` datetime(0) NOT NULL,
  `signature` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `subject` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `feedback` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `isapproved` tinyint(1) NULL DEFAULT NULL,
  `approveddate` datetime(0) NULL DEFAULT NULL,
  `feedbackresponds` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`feedbackID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for images
-- ----------------------------
DROP TABLE IF EXISTS `images`;
CREATE TABLE `images`  (
  `IMAGEID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `imagename` varchar(180) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `placeholdername` varchar(180) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `placeholderfile` longblob NULL,
  `x` double NULL DEFAULT NULL,
  `y` double NULL DEFAULT NULL,
  `x2` double NULL DEFAULT NULL,
  `y2` double NULL DEFAULT NULL,
  `w` double NULL DEFAULT NULL,
  `h` double NULL DEFAULT NULL,
  `requesttype` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `requesturl` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `requestsample` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `requestsamplename` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `requestsamplefile` longblob NULL,
  PRIMARY KEY (`IMAGEID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for languageindices
-- ----------------------------
DROP TABLE IF EXISTS `languageindices`;
CREATE TABLE `languageindices`  (
  `LANGID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `appname` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `identifier` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `variables` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `texts` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`LANGID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for logmail
-- ----------------------------
DROP TABLE IF EXISTS `logmail`;
CREATE TABLE `logmail`  (
  `logid` int(11) NOT NULL AUTO_INCREMENT,
  `MAILID` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `sentat` timestamp(0) NOT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `jsondata` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `resultdata` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `debuginfo` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `processingtime` double NULL DEFAULT NULL,
  PRIMARY KEY (`logid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 26 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for logpdf
-- ----------------------------
DROP TABLE IF EXISTS `logpdf`;
CREATE TABLE `logpdf`  (
  `logid` int(11) NOT NULL AUTO_INCREMENT,
  `PDFID` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `sentat` timestamp(0) NOT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `jsondata` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `creatorinfo` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `processingtime` double NULL DEFAULT NULL,
  PRIMARY KEY (`logid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 468 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for mail
-- ----------------------------
DROP TABLE IF EXISTS `mail`;
CREATE TABLE `mail`  (
  `MAILID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `html` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `css` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `mailname` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `mailaddress` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `mailpassword` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `cc` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `bcc` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `replyto` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `host` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `port` int(8) NOT NULL,
  `smtpauth` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `smtpsecure` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `requesttype` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `requesturl` varchar(155) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `requestsample` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `cssexternal` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`MAILID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for pdf
-- ----------------------------
DROP TABLE IF EXISTS `pdf`;
CREATE TABLE `pdf`  (
  `PDFID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `reportname` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `html` longblob NULL,
  `css` longblob NULL,
  `phpscript` longblob NULL,
  `outputmode` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `paper` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `orientation` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `requesttype` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `requesturl` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `requestsample` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `cssexternal` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`PDFID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 26 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for settings
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings`  (
  `Variable` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Value` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`Variable`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for status
-- ----------------------------
DROP TABLE IF EXISTS `status`;
CREATE TABLE `status`  (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `limitations` int(10) NOT NULL,
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for testimonial
-- ----------------------------
DROP TABLE IF EXISTS `testimonial`;
CREATE TABLE `testimonial`  (
  `testimonialID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `created` datetime(0) NOT NULL,
  `signature` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `subject` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `testimonial` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `isvalid` tinyint(4) NULL DEFAULT NULL,
  `validationdate` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`testimonialID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `username` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `apikey` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `statusID` int(11) NOT NULL,
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
