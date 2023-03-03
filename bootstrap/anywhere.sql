/*
 Navicat Premium Data Transfer

 Source Server         : maria
 Source Server Type    : MySQL
 Source Server Version : 100206
 Source Host           : localhost:3306
 Source Schema         : anywhere

 Target Server Type    : MySQL
 Target Server Version : 100206
 File Encoding         : 65001

 Date: 23/02/2023 23:46:26
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for constanta
-- ----------------------------
DROP TABLE IF EXISTS `constanta`;
CREATE TABLE `constanta`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `cuid` int NOT NULL,
  `muid` int NOT NULL,
  `dflag` tinyint(1) NOT NULL,
  `user_id` int NOT NULL,
  `unique_key` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `constanta_val` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for digital_sign_users
-- ----------------------------
DROP TABLE IF EXISTS `digital_sign_users`;
CREATE TABLE `digital_sign_users`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `cuid` int NOT NULL,
  `muid` int NOT NULL,
  `dflag` tinyint(1) NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(180) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `phone` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(180) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `type` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ktp` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `npwp` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `address` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `city` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `province` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `gender` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `place_of_birth` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `date_of_birth` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `org_unit` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `work_unit` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `position` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `callback_url` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `is_speciment` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for digital_signs
-- ----------------------------
DROP TABLE IF EXISTS `digital_signs`;
CREATE TABLE `digital_signs`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `modified` timestamp NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `cuid` int NOT NULL,
  `muid` int NOT NULL,
  `dflag` tinyint(1) NOT NULL,
  `user_id` int NOT NULL,
  `document_name` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `digital_sign_hash` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `digital_sign_secure` varchar(8) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `location` varchar(180) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `reason` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for excel
-- ----------------------------
DROP TABLE IF EXISTS `excel`;
CREATE TABLE `excel`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `cuid` int NOT NULL,
  `muid` int NOT NULL,
  `dflag` tinyint(1) NOT NULL,
  `user_id` int NOT NULL,
  `excel_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `column_specs` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `data_specs` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `request_type` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 82 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for feedback
-- ----------------------------
DROP TABLE IF EXISTS `feedback`;
CREATE TABLE `feedback`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `cuid` int NOT NULL,
  `muid` int NOT NULL,
  `dflag` tinyint(1) NOT NULL,
  `user_id` int NOT NULL,
  `signature` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `subject` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `feedback` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `is_approved` tinyint(1) NULL DEFAULT NULL,
  `approved_date` datetime NULL DEFAULT NULL,
  `feedback_responds` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for images
-- ----------------------------
DROP TABLE IF EXISTS `images`;
CREATE TABLE `images`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `cuid` int NOT NULL,
  `muid` int NOT NULL,
  `dflag` tinyint(1) NOT NULL,
  `user_id` int NOT NULL,
  `image_name` varchar(180) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `placeholder_name` varchar(180) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `placeholder_file` longblob NULL,
  `x` double NULL DEFAULT NULL,
  `y` double NULL DEFAULT NULL,
  `x2` double NULL DEFAULT NULL,
  `y2` double NULL DEFAULT NULL,
  `w` double NULL DEFAULT NULL,
  `h` double NULL DEFAULT NULL,
  `request_type` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `request_url` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `request_sample` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `request_sample_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `request_sample_file` longblob NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for language_indices
-- ----------------------------
DROP TABLE IF EXISTS `language_indices`;
CREATE TABLE `language_indices`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `cuid` int NOT NULL,
  `muid` int NOT NULL,
  `dflag` tinyint(1) NOT NULL,
  `user_id` int NOT NULL,
  `app_name` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `identifier` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `variables` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `texts` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for log_mail
-- ----------------------------
DROP TABLE IF EXISTS `log_mail`;
CREATE TABLE `log_mail`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `cuid` int NOT NULL,
  `muid` int NOT NULL,
  `dflag` tinyint(1) NOT NULL,
  `mail_id` int NOT NULL,
  `user_id` int NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `json_data` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `result_data` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `debug_info` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `processing_time` double NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 46 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for log_pdf
-- ----------------------------
DROP TABLE IF EXISTS `log_pdf`;
CREATE TABLE `log_pdf`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `cuid` int NOT NULL,
  `muid` int NOT NULL,
  `dflag` tinyint(1) NOT NULL,
  `pdf_id` int NOT NULL,
  `user_id` int NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `json_data` longblob NOT NULL,
  `creator_info` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `processing_time` double NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4094 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for mail
-- ----------------------------
DROP TABLE IF EXISTS `mail`;
CREATE TABLE `mail`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `cuid` int NOT NULL,
  `muid` int NOT NULL,
  `dflag` tinyint(1) NOT NULL,
  `user_id` int NOT NULL,
  `html` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `css` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `mail_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `mail_address` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `mail_password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `cc` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `bcc` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `reply_to` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `host` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `port` int NOT NULL,
  `smtp_auth` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `smtp_secure` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `request_type` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `request_url` varchar(155) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `request_sample` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `css_external` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for pdf
-- ----------------------------
DROP TABLE IF EXISTS `pdf`;
CREATE TABLE `pdf`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `cuid` int NOT NULL,
  `muid` int NOT NULL,
  `dflag` tinyint(1) NOT NULL,
  `user_id` int NOT NULL,
  `report_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `html` longblob NULL,
  `css` longblob NULL,
  `php_script` longblob NULL,
  `output_mode` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `paper` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `orientation` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `request_type` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `request_url` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `request_sample` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `css_external` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 120 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for status
-- ----------------------------
DROP TABLE IF EXISTS `status`;
CREATE TABLE `status`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `cuid` int NOT NULL,
  `muid` int NOT NULL,
  `dflag` tinyint(1) NOT NULL,
  `status` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `description` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `limitations` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for testimonial
-- ----------------------------
DROP TABLE IF EXISTS `testimonial`;
CREATE TABLE `testimonial`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `cuid` int NOT NULL,
  `muid` int NOT NULL,
  `dflag` tinyint(1) NOT NULL,
  `user_id` int NOT NULL,
  `signature` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `subject` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `testimonial` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `is_valid` tinyint NULL DEFAULT NULL,
  `validation_date` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `cuid` int NOT NULL,
  `muid` int NOT NULL,
  `dflag` tinyint(1) NOT NULL,
  `status_id` int NOT NULL,
  `name` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `username` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `api_key` varchar(80) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

SET FOREIGN_KEY_CHECKS = 1;
