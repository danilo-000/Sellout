/*
 Navicat Premium Data Transfer

 Source Server         : MySQL
 Source Server Type    : MySQL
 Source Server Version : 100137
 Source Host           : localhost:3306
 Source Schema         : ads

 Target Server Type    : MySQL
 Target Server Version : 100137
 File Encoding         : 65001

 Date: 29/06/2020 20:45:30
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for ad
-- ----------------------------
DROP TABLE IF EXISTS `ad`;
CREATE TABLE `ad`  (
  `ad_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0),
  `phone` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `image_path` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10, 2) UNSIGNED NOT NULL,
  `ends_at` datetime(0) NOT NULL,
  PRIMARY KEY (`ad_id`) USING BTREE,
  UNIQUE INDEX `uq_ad_image_path`(`image_path`) USING BTREE,
  INDEX `fk_user_category_id`(`category_id`) USING BTREE,
  INDEX `fk_user_user_id`(`user_id`) USING BTREE,
  INDEX `uq_ad_title`(`title`) USING BTREE,
  CONSTRAINT `fk_user_category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_user_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of ad
-- ----------------------------
INSERT INTO `ad` VALUES (1, 1, 1, 'Pro evolution soccer 2020', 'eFootball Pro Evolution Soccer 2020 је фудбалска симулација видео игре коју је развио PES Productions .', '2020-06-29 19:27:13', '0629764213', 'danilo.j99@gmail.com', '1.jpg', 4000.00, '2020-07-27 19:26:00');

-- ----------------------------
-- Table structure for ad_view
-- ----------------------------
DROP TABLE IF EXISTS `ad_view`;
CREATE TABLE `ad_view`  (
  `ad_view_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0),
  `ip_address` varchar(24) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_agent` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ad_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`ad_view_id`) USING BTREE,
  UNIQUE INDEX `uq_ad_view_ip_address`(`ip_address`) USING BTREE,
  INDEX `uq_ad_view_ad_id`(`ad_id`) USING BTREE,
  CONSTRAINT `uq_ad_view_ad_id` FOREIGN KEY (`ad_id`) REFERENCES `ad` (`ad_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of ad_view
-- ----------------------------
INSERT INTO `ad_view` VALUES (1, '2020-06-29 19:27:29', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36', 1);

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category`  (
  `category_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`category_id`) USING BTREE,
  UNIQUE INDEX `uq_category_name`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of category
-- ----------------------------
INSERT INTO `category` VALUES (7, 'Casopisi i stripovi');
INSERT INTO `category` VALUES (2, 'Knjige');
INSERT INTO `category` VALUES (1, 'Konzole i igrice');
INSERT INTO `category` VALUES (3, 'Mobilni telefoni');
INSERT INTO `category` VALUES (6, 'Motocikli');
INSERT INTO `category` VALUES (5, 'Namestaj');
INSERT INTO `category` VALUES (4, 'TV i Video');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `forename` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0),
  `phone` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`user_id`) USING BTREE,
  UNIQUE INDEX `uq_user_username`(`username`) USING BTREE,
  UNIQUE INDEX `uq_user_email`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, 'Danilo', 'Jocic', 'danilo', '$2y$10$PEoTrgnrSnB0U3RDI.Ru5epxy8gnkwZgMp5skJRiO7n4x3TU8EyEe', '2020-06-29 19:23:50', '06298231231', 'danilo.jocic95@gmail.com');

SET FOREIGN_KEY_CHECKS = 1;
