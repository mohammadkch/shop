/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100432 (10.4.32-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : shop

 Target Server Type    : MySQL
 Target Server Version : 100432 (10.4.32-MariaDB)
 File Encoding         : 65001

 Date: 29/06/2026 03:52:06
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for cart
-- ----------------------------
DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED NULL DEFAULT NULL,
  `session_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_user_id`(`user_id` ASC) USING BTREE,
  INDEX `idx_session_id`(`session_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 33 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cart
-- ----------------------------
INSERT INTO `cart` VALUES (1, NULL, '91e5efc7f394f534840b0e0640d4494f', 1782009601, 1782009601);
INSERT INTO `cart` VALUES (2, NULL, '4cbbf6761f0c50322fcffee88cb33464', 1782063601, 1782063601);
INSERT INTO `cart` VALUES (3, NULL, '6326a2719499ffa53a3f374c891a0a82', 1782063601, 1782063601);
INSERT INTO `cart` VALUES (4, NULL, '8a9157badb26960979e0b5627c47ff44', 1782087886, 1782087886);
INSERT INTO `cart` VALUES (5, NULL, '30cbe99a5d2168a3a846f6056193120d', 1782087886, 1782087886);
INSERT INTO `cart` VALUES (6, NULL, '0d798842e12f724b1587db7ba258b8fe', 1782092707, 1782092707);
INSERT INTO `cart` VALUES (7, NULL, '59cb702693a14762436d0fd907bb8538', 1782092707, 1782092707);
INSERT INTO `cart` VALUES (8, NULL, 'cc5c18edfe4f2a8b3d9cd51b152a58f8', 1782259521, 1782259521);
INSERT INTO `cart` VALUES (9, NULL, '9a98319f48f95f8c3106fe7e20449d42', 1782259521, 1782259521);
INSERT INTO `cart` VALUES (10, NULL, 'd473db1cb82f7206f15ff1395965a962', 1782331867, 1782331867);
INSERT INTO `cart` VALUES (11, NULL, '1a13754b2b5a13c50389920730e3b580', 1782331867, 1782331867);
INSERT INTO `cart` VALUES (12, NULL, '9ae7dc80f2bb562c31d6a2246381feb8', 1782349395, 1782349395);
INSERT INTO `cart` VALUES (13, NULL, '8c5ff6899ee8fcac9a41c27f70a5d6c2', 1782349395, 1782349395);
INSERT INTO `cart` VALUES (14, NULL, '401add34a96d246a8fd5c8ab3e8c4f79', 1782391389, 1782391389);
INSERT INTO `cart` VALUES (15, NULL, '5e4c9ef634b3f6092111c579cae8fa0d', 1782391389, 1782391389);
INSERT INTO `cart` VALUES (16, NULL, '0a6a7d13aa413111573ee5ab8e7b3d7e', 1782426731, 1782426731);
INSERT INTO `cart` VALUES (17, NULL, '46bbcff5f196cf9eb6b707b50cbd3cde', 1782426731, 1782426731);
INSERT INTO `cart` VALUES (18, NULL, '2deee1c5b738605efd7a9d4eea585ce6', 1782489411, 1782489411);
INSERT INTO `cart` VALUES (19, NULL, 'bae38fb88118a10e8d8da9762ab90eea', 1782489411, 1782489411);
INSERT INTO `cart` VALUES (20, NULL, 'cbca7a2dc0762e8b2b0207f5e5531b28', 1782514007, 1782514007);
INSERT INTO `cart` VALUES (21, NULL, '9888d7bc965228dff49a75fea5f6d7be', 1782514007, 1782514007);
INSERT INTO `cart` VALUES (22, NULL, '1642902df7f6e043a4d3c73faee09e9d', 1782526544, 1782526544);
INSERT INTO `cart` VALUES (23, NULL, '1141ff41579f9244e1b2456a7dac5558', 1782581377, 1782581377);
INSERT INTO `cart` VALUES (24, NULL, '98af33ee1fede263896f80b7b9c903a0', 1782581377, 1782581377);
INSERT INTO `cart` VALUES (25, NULL, 'de867e0ddf4220e4cd7801822f35778f', 1782596903, 1782596903);
INSERT INTO `cart` VALUES (26, NULL, 'e439a2460c351fd40ce48280fff18677', 1782596903, 1782596903);
INSERT INTO `cart` VALUES (27, NULL, '836f2f20e102b59919238c5576e6bf7b', 1782644059, 1782644059);
INSERT INTO `cart` VALUES (28, NULL, '51a0951581da3d7552bb0bee9e26cce6', 1782644059, 1782644059);
INSERT INTO `cart` VALUES (29, NULL, '6d40411d561b9c4b3fb3e25586e22158', 1782660502, 1782660502);
INSERT INTO `cart` VALUES (30, NULL, 'a19cfe3f5ecc89e7e35d7c0ba5a9626d', 1782660502, 1782660502);
INSERT INTO `cart` VALUES (31, NULL, '43bcd76965d2e56c13c762c1944f5c5f', 1782691537, 1782691537);
INSERT INTO `cart` VALUES (32, NULL, '7d9a70dc1e93a4c7232cbb37e2ad55d3', 1782691537, 1782691537);

-- ----------------------------
-- Table structure for cart_item
-- ----------------------------
DROP TABLE IF EXISTS `cart_item`;
CREATE TABLE `cart_item`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `cart_id` int UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL,
  `quantity` int NOT NULL DEFAULT 1,
  `price` decimal(15, 2) NOT NULL,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  `color_option_id` int UNSIGNED NULL DEFAULT NULL,
  `size_option_id` int UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_cart_id`(`cart_id` ASC) USING BTREE,
  INDEX `fk_cart_item_product_id`(`product_id` ASC) USING BTREE,
  INDEX `fk_cart_item_color_option`(`color_option_id` ASC) USING BTREE,
  INDEX `fk_cart_item_size_option`(`size_option_id` ASC) USING BTREE,
  CONSTRAINT `fk_cart_item_cart_id` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_cart_item_color_option` FOREIGN KEY (`color_option_id`) REFERENCES `option` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `fk_cart_item_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_cart_item_size_option` FOREIGN KEY (`size_option_id`) REFERENCES `option` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 35 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cart_item
-- ----------------------------
INSERT INTO `cart_item` VALUES (1, 1, 1, 1, 2850000.00, 1782009744, 1782009744, NULL, NULL);
INSERT INTO `cart_item` VALUES (3, 2, 1, 1, 2850000.00, 1782064520, 1782064550, NULL, NULL);
INSERT INTO `cart_item` VALUES (4, 4, 1, 3, 2250000.00, 1782089102, 1782090970, 1, 5);
INSERT INTO `cart_item` VALUES (5, 4, 1, 1, 2250000.00, 1782090960, 1782090960, 2, 5);
INSERT INTO `cart_item` VALUES (7, 6, 1, 1, 2250000.00, 1782096041, 1782096041, 2, 7);
INSERT INTO `cart_item` VALUES (8, 6, 1, 1, 2250000.00, 1782096298, 1782096298, 3, 6);
INSERT INTO `cart_item` VALUES (9, 6, 1, 1, 2250000.00, 1782096301, 1782096301, 3, 7);
INSERT INTO `cart_item` VALUES (10, 6, 1, 1, 2250000.00, 1782096302, 1782096302, 1, 8);
INSERT INTO `cart_item` VALUES (12, 10, 11, 1, 820000.00, 1782336817, 1782336817, 1, 5);
INSERT INTO `cart_item` VALUES (23, 12, 2, 1, 980000.00, 1782354090, 1782354798, 3, 7);
INSERT INTO `cart_item` VALUES (24, 12, 2, 3, 980000.00, 1782354093, 1782354136, 1, 7);
INSERT INTO `cart_item` VALUES (25, 12, 2, 1, 980000.00, 1782354095, 1782354150, 1, 6);
INSERT INTO `cart_item` VALUES (26, 16, 16, 1, 380000.00, 1782437658, 1782437658, 3, 5);
INSERT INTO `cart_item` VALUES (28, 18, 14, 2, 750000.00, 1782494400, 1782494522, 1, 5);
INSERT INTO `cart_item` VALUES (30, 18, 15, 1, 780000.00, 1782495369, 1782495369, 1, 7);
INSERT INTO `cart_item` VALUES (31, 21, 4, 1, 620000.00, 1782514462, 1782515474, 1, 5);
INSERT INTO `cart_item` VALUES (32, 21, 4, 1, 620000.00, 1782514820, 1782514820, 2, 6);
INSERT INTO `cart_item` VALUES (34, 22, 15, 1, 780000.00, 1782526588, 1782526588, 1, 5);

-- ----------------------------
-- Table structure for home_selected_category
-- ----------------------------
DROP TABLE IF EXISTS `home_selected_category`;
CREATE TABLE `home_selected_category`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `menu_1_id` int NOT NULL,
  `menu_2_id` int NULL DEFAULT NULL,
  `menu_3_id` int NULL DEFAULT NULL,
  `sort_order` int NULL DEFAULT 0,
  `is_active` tinyint(1) NULL DEFAULT 1,
  `created_at` int NULL DEFAULT NULL,
  `updated_at` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of home_selected_category
-- ----------------------------
INSERT INTO `home_selected_category` VALUES (1, 1, NULL, NULL, 1, 1, 1782665317, 1782665317);
INSERT INTO `home_selected_category` VALUES (2, 2, NULL, NULL, 2, 1, 1782665317, 1782665317);
INSERT INTO `home_selected_category` VALUES (3, 3, NULL, NULL, 3, 1, 1782665317, 1782665317);
INSERT INTO `home_selected_category` VALUES (4, 1, NULL, NULL, 1, 1, 1782665317, 1782665317);
INSERT INTO `home_selected_category` VALUES (5, 1, 2, NULL, 2, 1, 1782665317, 1782665317);
INSERT INTO `home_selected_category` VALUES (6, 1, 2, 3, 3, 1, 1782665317, 1782665317);

-- ----------------------------
-- Table structure for home_slider
-- ----------------------------
DROP TABLE IF EXISTS `home_slider`;
CREATE TABLE `home_slider`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sort_order` int NULL DEFAULT 0,
  `is_active` tinyint(1) NULL DEFAULT 1,
  `created_at` int NULL DEFAULT NULL,
  `updated_at` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of home_slider
-- ----------------------------
INSERT INTO `home_slider` VALUES (1, 'اسلایدر ۱', 'home/sliders/slider-1.webp', '#', 1, 1, 1782665289, 1782665289);
INSERT INTO `home_slider` VALUES (2, 'اسلایدر ۲', 'home/sliders/slider-2.webp', '#', 2, 1, 1782665289, 1782665289);
INSERT INTO `home_slider` VALUES (3, 'اسلایدر ۳', 'home/sliders/slider-3.webp', '#', 3, 1, 1782665289, 1782665289);
INSERT INTO `home_slider` VALUES (4, 'اسلایدر 4', 'home/sliders/slider-4.webp', NULL, 4, 1, NULL, NULL);

-- ----------------------------
-- Table structure for home_story
-- ----------------------------
DROP TABLE IF EXISTS `home_story`;
CREATE TABLE `home_story`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'image',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `avatar` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `url` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `duration` int NULL DEFAULT NULL,
  `link` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of home_story
-- ----------------------------
INSERT INTO `home_story` VALUES (1, 'image', 'استوری 1', 'home/story/1.jpg', 'home/story/1.jpg', 5000, 'https://www.rtl-theme.com/author/amir_rezaii/products/', 1, 1, 1782660903, 1782660903);
INSERT INTO `home_story` VALUES (2, 'image', 'استوری 2', 'home/story/2.jpg', 'home/story/2.jpg', 5000, 'https://www.rtl-theme.com/author/amir_rezaii/products/', 2, 1, 1782660903, 1782660903);
INSERT INTO `home_story` VALUES (3, 'image', 'استوری 3', 'home/story/3.jpg', 'home/story/3.jpg', 5000, 'https://www.rtl-theme.com/author/amir_rezaii/products/', 3, 1, 1782660903, 1782660903);
INSERT INTO `home_story` VALUES (4, 'image', 'استوری 4', 'home/story/5.jpg', 'home/story/5.jpg', 5000, 'https://www.rtl-theme.com/author/amir_rezaii/products/', 4, 1, 1782660903, 1782660903);
INSERT INTO `home_story` VALUES (5, 'image', 'استوری 5', 'home/story/6.jpg', 'home/story/6.jpg', 5000, 'https://www.rtl-theme.com/author/amir_rezaii/products/', 5, 1, 1782660903, 1782660903);
INSERT INTO `home_story` VALUES (6, 'image', 'استوری 6', 'home/story/7.jpg', 'home/story/7.jpg', 5000, 'https://www.rtl-theme.com/author/amir_rezaii/products/', 6, 1, 1782660903, 1782660903);
INSERT INTO `home_story` VALUES (7, 'image', 'استوری 7', 'home/story/8.jpg', 'home/story/8.jpg', 5000, 'https://www.rtl-theme.com/author/amir_rezaii/products/', 7, 1, 1782660903, 1782660903);
INSERT INTO `home_story` VALUES (8, 'video', 'نمونه فیلم ', 'home/story/8.jpg', 'home/story/video/1.mp4', NULL, 'https://www.rtl-theme.com/author/amir_rezaii/products/', 8, 1, 1782660903, 1782660903);

-- ----------------------------
-- Table structure for label
-- ----------------------------
DROP TABLE IF EXISTS `label`;
CREATE TABLE `label`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint NOT NULL DEFAULT 1,
  `sort_order` int NOT NULL DEFAULT 0,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  `type` enum('color','size','feature') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'feature',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of label
-- ----------------------------
INSERT INTO `label` VALUES (1, 'رنگ', 1, 1, 1781736273, 1781736273, 'color');
INSERT INTO `label` VALUES (2, 'سایز', 1, 2, 1781736273, 1781736273, 'size');
INSERT INTO `label` VALUES (3, 'جنس', 1, 3, 1781736273, 1781736273, 'feature');

-- ----------------------------
-- Table structure for menu_1
-- ----------------------------
DROP TABLE IF EXISTS `menu_1`;
CREATE TABLE `menu_1`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint NOT NULL DEFAULT 1,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `sort_order` int NOT NULL DEFAULT 0,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `slug`(`slug` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 29 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of menu_1
-- ----------------------------
INSERT INTO `menu_1` VALUES (1, 'زنانه', 'women', 1, 'مجموعه‌ای کامل از بهترین و باکیفیت‌ترین لباس‌های مردانه با طراحی‌های مدرن و کلاسیک. در این دسته‌بندی می‌توانید انواع کت، شلوار، پیراهن، لباس مجلسی و اسپرت را با بهترین کیفیت و مناسب‌ترین قیمت تهیه کنید. تمامی محصولات این مجموعه از پارچه‌های درجه یک و با دوخت حرفه‌ای تولید شده‌اند تا راحتی و زیبایی را برای شما به ارمغان بیاورند. ما در انتخاب محصولات خود به جزئیات کوچک مانند نوع یقه، جنس دکمه‌ها، کیفیت زیپ و دوخت نهایی توجه ویژه‌ای داریم تا محصولی بی‌نقص را به شما عزیزان ارائه دهیم. با خرید از این مجموعه، از اصالت کالا و گارانتی کیفیت اطمینان داشته باشید. تنوع رنگ‌ها و سایزهای موجود، امکان انتخاب کامل را برای سلیقه‌های مختلف فراهم کرده است. فروشگاه ما با سال‌ها تجربه در زمینه پوشاک مردانه، همواره به‌روزترین مدل‌های روز دنیا را با قیمت‌های رقابتی در اختیار شما قرار می‌دهد. مشاوره رایگان برای انتخاب سایز و سبک مناسب نیز از خدمات ویژه ما به شما عزیزان است.', 1, 1779657219, 1780450012);
INSERT INTO `menu_1` VALUES (2, 'مردانه', 'men', 1, NULL, 2, 1779657219, 1780524560);
INSERT INTO `menu_1` VALUES (3, 'بچگانه', 'kids', 1, NULL, 3, 1779657219, 1780452496);
INSERT INTO `menu_1` VALUES (4, 'سایر محصولات', 'others', 1, NULL, 4, 1779657219, 1780452714);
INSERT INTO `menu_1` VALUES (5, 'شلوار جین', 'jeans', 1, NULL, 5, 1779657219, 1780531493);
INSERT INTO `menu_1` VALUES (6, 'کیف', 'bag', 1, NULL, 6, 1779657219, 1779657219);
INSERT INTO `menu_1` VALUES (7, 'حراجی', 'sale', 1, NULL, 7, 1779657219, 1779657219);
INSERT INTO `menu_1` VALUES (9, 'حراجی دوم', 'sale-2', 0, NULL, 9, 1779657219, 1780186792);
INSERT INTO `menu_1` VALUES (28, 'منوی جدید', 'newmenu', 1, NULL, 28, 1780172326, 1780707195);

-- ----------------------------
-- Table structure for menu_1_image
-- ----------------------------
DROP TABLE IF EXISTS `menu_1_image`;
CREATE TABLE `menu_1_image`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `menu_1_image_type_id` int UNSIGNED NOT NULL,
  `menu_1_id` int UNSIGNED NOT NULL,
  `image_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_menu_1_image_type_id`(`menu_1_image_type_id` ASC) USING BTREE,
  INDEX `fk_menu_1_image_menu_1_id`(`menu_1_id` ASC) USING BTREE,
  CONSTRAINT `fk_menu_1_image_menu_1_id` FOREIGN KEY (`menu_1_id`) REFERENCES `menu_1` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_menu_1_image_type_id` FOREIGN KEY (`menu_1_image_type_id`) REFERENCES `menu_1_image_type` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 26 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of menu_1_image
-- ----------------------------
INSERT INTO `menu_1_image` VALUES (7, 1, 3, 'banner-3.webp', 'banner-3.webp', 'banner-3.webp', 0, 0, 1780172326, 1780452479);
INSERT INTO `menu_1_image` VALUES (8, 1, 4, 'banner-4.webp', 'banner-4.webp', 'banner-4.webp', 0, 0, 1780172326, 1780452714);
INSERT INTO `menu_1_image` VALUES (12, 1, 1, '1780450013_1780172326_banner-33.webp', '1780450013_1780172326_banner-33.webp', 's', 0, 0, 1780172326, 1780450013);
INSERT INTO `menu_1_image` VALUES (13, 1, 1, '1780450013_1780172326_banner-33.webp', '1780450013_1780172326_banner-33.webp', 's', 0, 1, 1780450013, 1780450013);
INSERT INTO `menu_1_image` VALUES (14, 1, 3, '1780452479_banner-3.webp', 'banner-3.webp', 'banner-3.webp', 0, 1, 1780452479, 1780452479);
INSERT INTO `menu_1_image` VALUES (16, 1, 4, '1780452714_1780452614_banner-4.webp', '1780452614_banner-4.webp', 'سایر محصولات', 0, 1, 1780452714, 1780452714);
INSERT INTO `menu_1_image` VALUES (17, 1, 2, '1780524560_banner-4 - Copy.webp', 'banner-4 - Copy.webp', '', 0, 1, 1780524560, 1780524560);
INSERT INTO `menu_1_image` VALUES (18, 1, 5, '1780528683_1780450013_1780172326_banner-33.webp', '1780450013_1780172326_banner-33.webp', '', 0, 0, 1780528683, 1781523943);
INSERT INTO `menu_1_image` VALUES (20, 1, 5, '1780530254_1780452714_1780452614_banner-4.webp', '1780452714_1780452614_banner-4.webp', '', 0, 1, 1780530254, 1781523943);
INSERT INTO `menu_1_image` VALUES (21, 1, 5, '1780530434_1780529503_1780528683_1780450013_1780172326_banner-33.webp', '1780529503_1780528683_1780450013_1780172326_banner-33.webp', 'شلوارجین آلت', 0, 0, 1780530434, 1781523943);
INSERT INTO `menu_1_image` VALUES (22, 1, 28, '1780703621_1780528693_banner-4 - Copy.webp', '1780528693_banner-4 - Copy.webp', 'تست 28 سوم ', 0, 0, 1780703621, 1780704357);
INSERT INTO `menu_1_image` VALUES (23, 1, 28, '1780704357_1780528683_1780450013_1780172326_banner-33.webp', '1780528683_1780450013_1780172326_banner-33.webp', 'سشیب شسی', 0, 1, 1780704357, 1780706887);
INSERT INTO `menu_1_image` VALUES (24, 2, 28, '1780705364_1780528881_1780452479_banner-3.webp', '1780528881_1780452479_banner-3.webp', 'آلت جدید', 0, 1, 1780705364, 1780707195);
INSERT INTO `menu_1_image` VALUES (25, 2, 28, '1780705840_1780528693_banner-4 - Copy.webp', '1780528693_banner-4 - Copy.webp', 'سشبسیب شسیب', 0, 0, 1780705840, 1780707180);

-- ----------------------------
-- Table structure for menu_1_image_type
-- ----------------------------
DROP TABLE IF EXISTS `menu_1_image_type`;
CREATE TABLE `menu_1_image_type`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `width` int UNSIGNED NULL DEFAULT NULL,
  `height` int UNSIGNED NULL DEFAULT NULL,
  `extension` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `file_size_limit` int UNSIGNED NULL DEFAULT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint NOT NULL DEFAULT 1,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of menu_1_image_type
-- ----------------------------
INSERT INTO `menu_1_image_type` VALUES (1, 'menu1_type', 400, 300, 'webp', 200, 'images/menus', 1, 0, 0);
INSERT INTO `menu_1_image_type` VALUES (2, 'menu1_type_2', 400, 300, 'webp', 200, 'images/menus', 1, 0, 0);

-- ----------------------------
-- Table structure for menu_2
-- ----------------------------
DROP TABLE IF EXISTS `menu_2`;
CREATE TABLE `menu_2`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `menu_1_id` int UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint NOT NULL DEFAULT 1,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `sort_order` int NOT NULL DEFAULT 0,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `slug`(`slug` ASC) USING BTREE,
  INDEX `fk_menu_2_menu_1_id`(`menu_1_id` ASC) USING BTREE,
  CONSTRAINT `fk_menu_2_menu_1_id` FOREIGN KEY (`menu_1_id`) REFERENCES `menu_1` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 40 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of menu_2
-- ----------------------------
INSERT INTO `menu_2` VALUES (1, 1, 'بالاپوش', 'women-outerwear', 1, 'انواع کت و کاپشن مردانه با طراحی‌های شیک و مدرن مناسب برای فصول سرد سال. محصولات این مجموعه از بهترین برندهای داخلی و خارجی با بالاترین کیفیت دوخت و پارچه انتخاب شده‌اند. کت‌های اسپرت، رسمی و مجلسی با طرح‌ها و رنگ‌های متنوع، پاسخگوی تمامی سلیقه‌ها و نیازهای شما در موقعیت‌های مختلف هستند. کاپشن‌های گرم و سبک با الیاف طبیعی و پرکردگی استاندارد، شما را در سردترین روزهای سال گرم و دلپذیر نگه می‌دارند. تمامی محصولات این مجموعه دارای گارانتی اصالت و سلامت کالا بوده و با بسته‌بندی زیبا و شیک به دست شما می‌رسند. ما در فروشگاه خود، به کیفیت دوخت، استحکام درزها و جنس آسترها بسیار حساس هستیم تا محصولی بادوام و با عمر طولانی به شما ارائه دهیم. خرید از این مجموعه را به تمامی آقایان شیک‌پوش توصیه می‌کنیم.', 1, 1779657238, 1780523888);
INSERT INTO `menu_2` VALUES (2, 1, 'شلوار', 'women-pants', 1, NULL, 2, 1779657238, 1779657238);
INSERT INTO `menu_2` VALUES (3, 1, 'کلاه/روسری/شال', 'women-accessories', 1, NULL, 3, 1779657238, 1779657238);
INSERT INTO `menu_2` VALUES (4, 1, 'لباس راحتی و اسپرت', 'women-casual', 1, NULL, 4, 1779657238, 1779657238);
INSERT INTO `menu_2` VALUES (5, 1, 'جوراب', 'women-socks', 1, NULL, 5, 1779657238, 1779657238);
INSERT INTO `menu_2` VALUES (6, 1, 'دامن', 'women-skirt', 1, NULL, 6, 1779657238, 1780528642);
INSERT INTO `menu_2` VALUES (7, 2, 'بالاپوش', 'men-outerwear', 1, NULL, 7, 1779657273, 1779657273);
INSERT INTO `menu_2` VALUES (8, 2, 'شلوار', 'men-pants', 0, NULL, 8, 1779657273, 1780521273);
INSERT INTO `menu_2` VALUES (9, 2, 'لباس اسپرت', 'men-sportswear', 1, NULL, 9, 1779657273, 1779657273);
INSERT INTO `menu_2` VALUES (10, 2, 'سایر', 'men-others', 1, NULL, 10, 1779657273, 1779657273);
INSERT INTO `menu_2` VALUES (11, 3, 'دخترانه', 'girls', 1, NULL, 11, 1779657303, 1779657303);
INSERT INTO `menu_2` VALUES (12, 3, 'پسرانه', 'boys', 1, NULL, 12, 1779657303, 1779657303);
INSERT INTO `menu_2` VALUES (13, 3, 'نوزاد', 'baby', 1, NULL, 13, 1779657303, 1779657303);
INSERT INTO `menu_2` VALUES (14, 4, 'عطر', 'perfume', 1, NULL, 14, 1779657310, 1779657310);
INSERT INTO `menu_2` VALUES (15, 4, 'جا کلیدی', 'keyholder', 1, NULL, 15, 1779657310, 1779657310);
INSERT INTO `menu_2` VALUES (16, 4, 'لوازم جانبی', 'electronic-accessories', 1, NULL, 16, 1779657310, 1779657310);
INSERT INTO `menu_2` VALUES (17, 4, 'تینت', 'tint', 1, NULL, 17, 1779657310, 1779657310);
INSERT INTO `menu_2` VALUES (18, 4, 'کش/گیره مو', 'hair-accessories', 1, NULL, 18, 1779657310, 1779657310);
INSERT INTO `menu_2` VALUES (19, 4, 'لباس زیر', 'underwear', 1, NULL, 19, 1779657310, 1779657310);
INSERT INTO `menu_2` VALUES (20, 4, 'دستکش', 'gloves', 1, NULL, 20, 1779657310, 1779657310);
INSERT INTO `menu_2` VALUES (21, 4, 'یقه حجاب', 'hijab-collar', 1, NULL, 21, 1779657310, 1779657310);
INSERT INTO `menu_2` VALUES (22, 4, 'دامنک/اکستندر', 'skirt-extender', 1, NULL, 22, 1779657310, 1779657310);
INSERT INTO `menu_2` VALUES (23, 4, 'ارگانایزر', 'organizer', 1, NULL, 23, 1779657310, 1779657310);
INSERT INTO `menu_2` VALUES (24, 4, 'کمربند', 'other-belt', 1, NULL, 24, 1779657310, 1779657310);
INSERT INTO `menu_2` VALUES (25, 4, 'هدبند/چشم بند', 'blindfold', 1, NULL, 25, 1779657310, 1779657310);
INSERT INTO `menu_2` VALUES (26, 4, 'کیف آرایشی', 'makeup-bag', 1, NULL, 26, 1779657310, 1779657310);
INSERT INTO `menu_2` VALUES (27, 4, 'حوله', 'towel', 1, NULL, 27, 1779657310, 1779657310);
INSERT INTO `menu_2` VALUES (28, 5, 'شلوار بگ/نیم بگ/واید', 'baggy-jeans', 1, NULL, 28, 1779657317, 1780530226);
INSERT INTO `menu_2` VALUES (29, 5, 'شلوار راسته/فلر', 'straight-jeans', 1, NULL, 29, 1779657317, 1779657317);
INSERT INTO `menu_2` VALUES (30, 5, 'شلوار مام فیت/مام استایل', 'mom-jeans', 1, NULL, 30, 1779657317, 1779657317);
INSERT INTO `menu_2` VALUES (31, 5, 'شلوار جذب/اسکینی', 'skinny-jeans', 1, NULL, 31, 1779657317, 1779657317);
INSERT INTO `menu_2` VALUES (32, 5, 'شلوار دمپا/بوت کات', 'bootcut-jeans', 1, NULL, 32, 1779657317, 1779657317);
INSERT INTO `menu_2` VALUES (33, 6, 'کیف زنانه', 'women-bag', 1, NULL, 33, 1779657326, 1779657326);
INSERT INTO `menu_2` VALUES (34, 6, 'کیف مردانه', 'men-bag', 1, NULL, 34, 1779657326, 1779657326);
INSERT INTO `menu_2` VALUES (35, 7, 'تخفیف ویژه', 'special-offer', 1, NULL, 35, 1779657330, 1780451389);
INSERT INTO `menu_2` VALUES (36, 7, 'شگفت‌انگیز', 'amazing-offer', 1, NULL, 36, 1779657330, 1779657330);
INSERT INTO `menu_2` VALUES (37, 7, 'تست ساخت', 'test-create', 1, NULL, 37, 1780452140, 1780705066);
INSERT INTO `menu_2` VALUES (38, 28, 'منوی سطح 2 جدید', 'new-second-layer', 1, NULL, 38, 1780707424, 1780708836);
INSERT INTO `menu_2` VALUES (39, 28, 'منوی دوم جدید', 'new-second-layer-menu', 1, NULL, 39, 1780718627, 1780718627);

-- ----------------------------
-- Table structure for menu_2_image
-- ----------------------------
DROP TABLE IF EXISTS `menu_2_image`;
CREATE TABLE `menu_2_image`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `menu_2_image_type_id` int UNSIGNED NOT NULL,
  `menu_2_id` int UNSIGNED NOT NULL,
  `image_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_menu_2_image_type_id`(`menu_2_image_type_id` ASC) USING BTREE,
  INDEX `fk_menu_2_image_menu_2_id`(`menu_2_id` ASC) USING BTREE,
  CONSTRAINT `fk_menu_2_image_menu_2_id` FOREIGN KEY (`menu_2_id`) REFERENCES `menu_2` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_menu_2_image_type_id` FOREIGN KEY (`menu_2_image_type_id`) REFERENCES `menu_2_image_type` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of menu_2_image
-- ----------------------------
INSERT INTO `menu_2_image` VALUES (1, 1, 1, '1780452714_1780452614_banner-4.webp', '1780452714_1780452614_banner-4.webp', 'زنانه 2', 0, 1, 0, 1780523946);
INSERT INTO `menu_2_image` VALUES (2, 1, 2, '1780452714_1780452614_banner-4.webp', '1780452714_1780452614_banner-4.webp', 'زنانه 2', 0, 1, 0, 0);
INSERT INTO `menu_2_image` VALUES (3, 1, 3, '1780452714_1780452614_banner-4.webp', '1780452714_1780452614_banner-4.webp', 'زنانه 2', 0, 1, 0, 0);
INSERT INTO `menu_2_image` VALUES (6, 1, 4, '1780452714_1780452614_banner-4.webp', '1780452714_1780452614_banner-4.webp', 'زنانه 2', 0, 1, 0, 0);
INSERT INTO `menu_2_image` VALUES (7, 1, 5, '1780452714_1780452614_banner-4.webp', '1780452714_1780452614_banner-4.webp', 'زنانه 2', 0, 1, 0, 0);
INSERT INTO `menu_2_image` VALUES (8, 1, 6, '1780452714_1780452614_banner-4.webp', '1780452714_1780452614_banner-4.webp', 'زنانه 2', 0, 0, 0, 1780528642);
INSERT INTO `menu_2_image` VALUES (10, 1, 6, '1780528642_1780450013_1780172326_banner-33.webp', '1780450013_1780172326_banner-33.webp', 'زنانه 2', 0, 1, 1780528642, 1780528642);
INSERT INTO `menu_2_image` VALUES (11, 1, 28, '1780528881_1780452479_banner-3.webp', '1780452479_banner-3.webp', '', 0, 0, 1780528881, 1780530234);
INSERT INTO `menu_2_image` VALUES (12, 1, 28, '1780529503_1780528683_1780450013_1780172326_banner-33.webp', '1780528683_1780450013_1780172326_banner-33.webp', '', 0, 1, 1780529503, 1780530234);
INSERT INTO `menu_2_image` VALUES (13, 1, 28, '1780530226_1780528693_banner-4 - Copy.webp', '1780528693_banner-4 - Copy.webp', '', 0, 0, 1780530226, 1780530234);
INSERT INTO `menu_2_image` VALUES (14, 1, 37, '1780700782_1780528683_1780450013_1780172326_banner-33.webp', '1780528683_1780450013_1780172326_banner-33.webp', 'تست ساخت', 0, 0, 1780700782, 1780704474);
INSERT INTO `menu_2_image` VALUES (15, 1, 37, '1780700925_1780528683_1780450013_1780172326_banner-33.webp', '1780528683_1780450013_1780172326_banner-33.webp', 'تست ساخت2', 0, 0, 1780700925, 1780704474);
INSERT INTO `menu_2_image` VALUES (16, 1, 37, '1780704474_1780528693_banner-4 - Copy.webp', '1780528693_banner-4 - Copy.webp', 'تست ', 0, 1, 1780704474, 1780705066);
INSERT INTO `menu_2_image` VALUES (17, 1, 38, '1780708581_1780528693_banner-4 - Copy.webp', '1780528693_banner-4 - Copy.webp', 'آلت سطح 222', 0, 1, 1780708581, 1780708826);
INSERT INTO `menu_2_image` VALUES (18, 2, 38, '1780708826_banner-4 - Copy.webp', 'banner-4 - Copy.webp', 'آلت جدید 23', 0, 1, 1780708826, 1780708836);

-- ----------------------------
-- Table structure for menu_2_image_type
-- ----------------------------
DROP TABLE IF EXISTS `menu_2_image_type`;
CREATE TABLE `menu_2_image_type`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `width` int UNSIGNED NULL DEFAULT NULL,
  `height` int UNSIGNED NULL DEFAULT NULL,
  `extension` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `file_size_limit` int UNSIGNED NULL DEFAULT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint NOT NULL DEFAULT 1,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of menu_2_image_type
-- ----------------------------
INSERT INTO `menu_2_image_type` VALUES (1, 'menu2_type', 400, 300, 'webp', 200, 'images/menus', 1, 1780452479, 1780452479);
INSERT INTO `menu_2_image_type` VALUES (2, 'menu2_type_2', 400, 300, 'webp', 200, 'images/menus', 1, 1780452479, 1780452479);

-- ----------------------------
-- Table structure for menu_3
-- ----------------------------
DROP TABLE IF EXISTS `menu_3`;
CREATE TABLE `menu_3`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `menu_2_id` int UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint NOT NULL DEFAULT 1,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `sort_order` int NOT NULL DEFAULT 0,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `slug`(`slug` ASC) USING BTREE,
  INDEX `fk_menu_3_menu_2_id`(`menu_2_id` ASC) USING BTREE,
  CONSTRAINT `fk_menu_3_menu_2_id` FOREIGN KEY (`menu_2_id`) REFERENCES `menu_2` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 55 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of menu_3
-- ----------------------------
INSERT INTO `menu_3` VALUES (1, 1, 'بافت', 'women-knit-sweaters', 1, 'کت‌های اسپرت مردانه با طراحی‌های جوان‌پسند و مدرن، مناسب برای استفاده روزمره و فعالیت‌های ورزشی. این کت‌ها با پارچه‌های نرم و تنفس‌پذیر تولید شده‌اند تا راحتی و آزادی حرکت را برای شما فراهم کنند. مدل‌های متنوع شامل کت هودی، کت زیپ‌دار، کت دکمه‌دار و کت ورزشی با رنگ‌بندی جذاب و شاد، انتخابی ایده‌آل برای آقایانی است که به استایل اسپرت و در عین حال شیک علاقه دارند. جنس پارچه‌ها از ترکیب پنبه و پلی استر با بالاترین کیفیت است که نه تنها ظاهر زیبایی دارد، بلکه بسیار مقاوم و ضدچروک نیز می‌باشد. این محصولات در سایزهای مختلف از S تا XXL در انبار موجود هستند و با قیمت‌های مناسب و تخفیف‌های ویژه، خرید را برای شما آسان‌تر کرده‌ایم.', 1, 1779657246, 1779657246);
INSERT INTO `menu_3` VALUES (2, 1, 'بلوز/شومیز', 'blouse', 1, NULL, 2, 1779657246, 1779657246);
INSERT INTO `menu_3` VALUES (3, 1, 'تونیک', 'tunic', 1, NULL, 3, 1779657246, 1779657246);
INSERT INTO `menu_3` VALUES (4, 1, 'پیراهن', 'women-shirt', 1, NULL, 4, 1779657246, 1779657246);
INSERT INTO `menu_3` VALUES (5, 1, 'سرهمی/اورال', 'overall', 1, NULL, 5, 1779657246, 1779657246);
INSERT INTO `menu_3` VALUES (6, 1, 'کت', 'women-coat', 1, NULL, 6, 1779657246, 1779657246);
INSERT INTO `menu_3` VALUES (7, 1, 'کاپشن', 'women-raincoat', 1, NULL, 7, 1779657246, 1779657246);
INSERT INTO `menu_3` VALUES (8, 1, 'پالتو', 'women-overcoat', 1, NULL, 8, 1779657246, 1779657246);
INSERT INTO `menu_3` VALUES (9, 1, 'ترنچ کت', 'trench-coat', 1, NULL, 9, 1779657246, 1779657246);
INSERT INTO `menu_3` VALUES (10, 1, 'هودی و سویشرت', 'women-hoodies', 1, NULL, 10, 1779657246, 1779657246);
INSERT INTO `menu_3` VALUES (11, 1, 'پلیور، دورس، بافت', 'women-sweater', 1, NULL, 11, 1779657246, 1779657246);
INSERT INTO `menu_3` VALUES (12, 1, 'وست', 'women-waistcoat', 1, NULL, 12, 1779657246, 1779657246);
INSERT INTO `menu_3` VALUES (13, 2, 'شلوار راسته/کلاسیک', 'trousers', 1, NULL, 13, 1779657253, 1779657253);
INSERT INTO `menu_3` VALUES (14, 2, 'شلوار پارچه ای', 'cotton-fabric', 1, NULL, 14, 1779657253, 1779657253);
INSERT INTO `menu_3` VALUES (15, 2, 'شلوار اسلش/جاگر', 'jogger-pants', 1, NULL, 15, 1779657253, 1779657253);
INSERT INTO `menu_3` VALUES (16, 2, 'لگ/ساپورت/جوراب شلواری', 'leggings', 1, NULL, 16, 1779657253, 1779657253);
INSERT INTO `menu_3` VALUES (17, 2, 'شلوارک/شورتک', 'women-shorts', 1, NULL, 17, 1779657253, 1779657253);
INSERT INTO `menu_3` VALUES (18, 2, 'شلوار راحتی', 'casual-pants', 1, NULL, 18, 1779657253, 1779657253);
INSERT INTO `menu_3` VALUES (19, 3, 'کلاه زنانه', 'women-hat', 1, NULL, 19, 1779657259, 1779657259);
INSERT INTO `menu_3` VALUES (20, 3, 'شال', 'shawl', 1, NULL, 20, 1779657259, 1779657259);
INSERT INTO `menu_3` VALUES (21, 3, 'روسری', 'scarf', 1, NULL, 21, 1779657259, 1779657259);
INSERT INTO `menu_3` VALUES (22, 4, 'ورزشی و اسپرت', 'sportswear', 1, NULL, 22, 1779657266, 1779657266);
INSERT INTO `menu_3` VALUES (23, 4, 'تیشرت/پولوشرت زنانه', 'women-tshirt', 1, NULL, 23, 1779657266, 1779657266);
INSERT INTO `menu_3` VALUES (24, 4, 'بلوز آستین بلند زنانه', 'long-sleeve-shirt', 1, NULL, 24, 1779657266, 1779657266);
INSERT INTO `menu_3` VALUES (25, 4, 'تاپ زنانه/نیم تنه', 'women-top', 1, NULL, 25, 1779657266, 1779657266);
INSERT INTO `menu_3` VALUES (26, 4, 'لباس خواب', 'sleepwear', 1, NULL, 26, 1779657266, 1779657266);
INSERT INTO `menu_3` VALUES (27, 4, 'ست راحتی/ست اسپرت زنانه', 'women-set', 1, NULL, 27, 1779657266, 1779657266);
INSERT INTO `menu_3` VALUES (28, 4, 'بادی', 'bodysuit', 1, NULL, 28, 1779657266, 1779657266);
INSERT INTO `menu_3` VALUES (29, 7, 'بافت', 'men-knit-sweaters', 1, NULL, 29, 1779657280, 1779657280);
INSERT INTO `menu_3` VALUES (30, 7, 'پلیور و دورس', 'men-sweater', 1, NULL, 30, 1779657280, 1779657280);
INSERT INTO `menu_3` VALUES (31, 7, 'کاپشن', 'men-raincoat', 1, NULL, 31, 1779657280, 1779657280);
INSERT INTO `menu_3` VALUES (32, 7, 'پیراهن مردانه', 'men-shirt', 1, NULL, 32, 1779657280, 1779657280);
INSERT INTO `menu_3` VALUES (33, 7, 'هودی و سویشرت', 'men-hoodies', 1, NULL, 33, 1779657280, 1779657280);
INSERT INTO `menu_3` VALUES (34, 8, 'جین', 'men-jeans', 1, NULL, 34, 1779657286, 1779657286);
INSERT INTO `menu_3` VALUES (35, 8, 'پارچه‌ای', 'men-fabric-pants', 1, NULL, 35, 1779657286, 1779657286);
INSERT INTO `menu_3` VALUES (36, 8, 'شلوار اسپرت/راحتی/اسلش', 'men-jogger', 1, NULL, 36, 1779657286, 1779657286);
INSERT INTO `menu_3` VALUES (37, 8, 'شلوارک', 'men-shorts', 1, NULL, 37, 1779657286, 1779657286);
INSERT INTO `menu_3` VALUES (38, 9, 'تیشرت/پولوشرت مردانه', 'men-tshirt', 1, NULL, 38, 1779657291, 1779657291);
INSERT INTO `menu_3` VALUES (39, 9, 'ست اسپرت/ست راحتی مردانه', 'men-set', 1, NULL, 39, 1779657291, 1779657291);
INSERT INTO `menu_3` VALUES (40, 9, 'بلوز آستین بلند مردانه', 'men-long-sleeve', 1, NULL, 40, 1779657291, 1779657291);
INSERT INTO `menu_3` VALUES (41, 10, 'کلاه مردانه', 'men-hat', 1, NULL, 41, 1779657297, 1779657297);
INSERT INTO `menu_3` VALUES (42, 10, 'جوراب', 'men-socks', 1, NULL, 42, 1779657297, 1779657297);
INSERT INTO `menu_3` VALUES (43, 10, 'رکابی/لباس زیر', 'men-underwear', 1, NULL, 43, 1779657297, 1779657297);
INSERT INTO `menu_3` VALUES (44, 10, 'کمربند', 'belt', 1, NULL, 44, 1779657297, 1779657297);
INSERT INTO `menu_3` VALUES (45, 38, 'تست منوی 3', 'slugify', 1, NULL, 45, 1780686305, 1780709343);
INSERT INTO `menu_3` VALUES (46, 5, 'همه محصولات جوراب', 'all-women-socks-5', 0, NULL, 46, 1782266894, 1782266894);
INSERT INTO `menu_3` VALUES (47, 6, 'همه محصولات دامن', 'all-women-skirt-6', 0, NULL, 47, 1782266894, 1782266894);
INSERT INTO `menu_3` VALUES (48, 39, 'همه محصولات منوی دوم جدید', 'all-new-second-layer-menu-39', 0, NULL, 48, 1782331988, 1782331988);
INSERT INTO `menu_3` VALUES (49, 35, 'همه محصولات تخفیف ویژه', 'all-special-offer-35', 0, NULL, 49, 1782355927, 1782355927);
INSERT INTO `menu_3` VALUES (50, 36, 'همه محصولات شگفت‌انگیز', 'all-amazing-offer-36', 0, NULL, 50, 1782355927, 1782355927);
INSERT INTO `menu_3` VALUES (51, 37, 'همه محصولات تست ساخت', 'all-test-create-37', 0, NULL, 51, 1782355927, 1782355927);
INSERT INTO `menu_3` VALUES (52, 11, 'همه محصولات دخترانه', 'all-girls-11', 0, NULL, 52, 1782355931, 1782355931);
INSERT INTO `menu_3` VALUES (53, 12, 'همه محصولات پسرانه', 'all-boys-12', 0, NULL, 53, 1782355931, 1782355931);
INSERT INTO `menu_3` VALUES (54, 13, 'همه محصولات نوزاد', 'all-baby-13', 0, NULL, 54, 1782355931, 1782355931);

-- ----------------------------
-- Table structure for menu_3_image
-- ----------------------------
DROP TABLE IF EXISTS `menu_3_image`;
CREATE TABLE `menu_3_image`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `menu_3_image_type_id` int UNSIGNED NOT NULL,
  `menu_3_id` int UNSIGNED NOT NULL,
  `image_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_menu_3_image_type_id`(`menu_3_image_type_id` ASC) USING BTREE,
  INDEX `fk_menu_3_image_menu_3_id`(`menu_3_id` ASC) USING BTREE,
  CONSTRAINT `fk_menu_3_image_menu_3_id` FOREIGN KEY (`menu_3_id`) REFERENCES `menu_3` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_menu_3_image_type_id` FOREIGN KEY (`menu_3_image_type_id`) REFERENCES `menu_3_image_type` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of menu_3_image
-- ----------------------------
INSERT INTO `menu_3_image` VALUES (1, 1, 1, '1780452714_1780452614_banner-4.webp', '1780452714_1780452614_banner-4.webp', 'منوی سطح 3', 0, 1, 0, 0);
INSERT INTO `menu_3_image` VALUES (2, 1, 2, '1780452714_1780452614_banner-4.webp', '1780452714_1780452614_banner-4.webp', 'بلوز/شومیز', 0, 1, 0, 0);
INSERT INTO `menu_3_image` VALUES (3, 1, 3, '1780452714_1780452614_banner-4.webp', '1780452714_1780452614_banner-4.webp', 'تونیک', 0, 1, 0, 0);
INSERT INTO `menu_3_image` VALUES (4, 1, 4, '1780452714_1780452614_banner-4.webp', '1780452714_1780452614_banner-4.webp', 'پیراهن', 0, 1, 0, 0);
INSERT INTO `menu_3_image` VALUES (5, 1, 5, '1780452714_1780452614_banner-4.webp', '1780452714_1780452614_banner-4.webp', 'سرهمی/اورال', 0, 1, 0, 0);
INSERT INTO `menu_3_image` VALUES (6, 1, 5, '1780452714_1780452614_banner-4.webp', '1780452714_1780452614_banner-4.webp', 'سرهمی/اورال', 0, 1, 0, 0);
INSERT INTO `menu_3_image` VALUES (7, 1, 6, '1780452714_1780452614_banner-4.webp', '1780452714_1780452614_banner-4.webp', 'کت', 0, 1, 0, 0);
INSERT INTO `menu_3_image` VALUES (8, 1, 7, '1780452714_1780452614_banner-4.webp', '1780452714_1780452614_banner-4.webp', 'کاپشن', 0, 1, 0, 0);
INSERT INTO `menu_3_image` VALUES (9, 1, 8, '1780452714_1780452614_banner-4.webp', '1780452714_1780452614_banner-4.webp', 'پالتو', 0, 1, 0, 0);
INSERT INTO `menu_3_image` VALUES (10, 1, 9, '1780452714_1780452614_banner-4.webp', '1780452714_1780452614_banner-4.webp', 'ترنچ کت', 0, 1, 0, 0);
INSERT INTO `menu_3_image` VALUES (11, 1, 10, '1780452714_1780452614_banner-4.webp', '1780452714_1780452614_banner-4.webp', 'هودی و سویشرت', 0, 1, 0, 0);
INSERT INTO `menu_3_image` VALUES (12, 1, 11, '1780452714_1780452614_banner-4.webp', '1780452714_1780452614_banner-4.webp', 'پلیور، دورس، بافت', 0, 1, 0, 0);
INSERT INTO `menu_3_image` VALUES (13, 1, 12, '1780452714_1780452614_banner-4.webp', '1780452714_1780452614_banner-4.webp', 'وست', 0, 1, 0, 0);
INSERT INTO `menu_3_image` VALUES (14, 1, 13, '1780452714_1780452614_banner-4.webp', '1780452714_1780452614_banner-4.webp', 'شلوار راسته/کلاسیک', 0, 1, 0, 0);
INSERT INTO `menu_3_image` VALUES (15, 1, 14, '1780452714_1780452614_banner-4.webp', '1780452714_1780452614_banner-4.webp', 'شلوار پارچه ای', 0, 1, 0, 0);
INSERT INTO `menu_3_image` VALUES (16, 1, 15, '1780452714_1780452614_banner-4.webp', '1780452714_1780452614_banner-4.webp', 'شلوار اسلش/جاگر', 0, 1, 0, 0);
INSERT INTO `menu_3_image` VALUES (17, 1, 16, '1780452714_1780452614_banner-4.webp', '1780452714_1780452614_banner-4.webp', 'لگ/ساپورت/جوراب شلواری', 0, 1, 0, 0);
INSERT INTO `menu_3_image` VALUES (18, 1, 17, '1780452714_1780452614_banner-4.webp', '1780452714_1780452614_banner-4.webp', 'شلوارک/شورتک', 0, 1, 0, 0);
INSERT INTO `menu_3_image` VALUES (19, 1, 18, '1780452714_1780452614_banner-4.webp', '1780452714_1780452614_banner-4.webp', 'شلوار راحتی', 0, 1, 0, 0);
INSERT INTO `menu_3_image` VALUES (20, 1, 19, '1780452714_1780452614_banner-4.webp', '1780452714_1780452614_banner-4.webp', 'کلاه زنانه', 0, 1, 0, 0);
INSERT INTO `menu_3_image` VALUES (21, 1, 45, '1780700574_6a23559e49b82_1780528683_1780450013_1780172326_banner-33.webp', '1780528683_1780450013_1780172326_banner-33.webp', 'عکس منوی 33', 0, 1, 1780700574, 1780709276);
INSERT INTO `menu_3_image` VALUES (22, 2, 45, '1780709315_1780708826_banner-4 - Copy.webp', '1780708826_banner-4 - Copy.webp', 'آلت منوی 3 جدید ', 0, 1, 1780709315, 1780709315);

-- ----------------------------
-- Table structure for menu_3_image_type
-- ----------------------------
DROP TABLE IF EXISTS `menu_3_image_type`;
CREATE TABLE `menu_3_image_type`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `width` int UNSIGNED NULL DEFAULT NULL,
  `height` int UNSIGNED NULL DEFAULT NULL,
  `extension` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `file_size_limit` int UNSIGNED NULL DEFAULT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint NOT NULL DEFAULT 1,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of menu_3_image_type
-- ----------------------------
INSERT INTO `menu_3_image_type` VALUES (1, 'menu3_type', 400, 300, 'webp', 200, 'images/menus', 1, 1780452479, 1780452479);
INSERT INTO `menu_3_image_type` VALUES (2, 'menu3_type_2', 400, 300, 'webp', 200, 'images/menus', 1, 1780452479, 1780452479);

-- ----------------------------
-- Table structure for option
-- ----------------------------
DROP TABLE IF EXISTS `option`;
CREATE TABLE `option`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `label_id` int UNSIGNED NOT NULL,
  `value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int NOT NULL DEFAULT 0,
  `is_active` tinyint NOT NULL DEFAULT 1,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  `color_code` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_option_label_id`(`label_id` ASC) USING BTREE,
  CONSTRAINT `fk_option_label_id` FOREIGN KEY (`label_id`) REFERENCES `label` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of option
-- ----------------------------
INSERT INTO `option` VALUES (1, 1, 'مشکی', 1, 1, 1781736278, 1781736278, '#000000');
INSERT INTO `option` VALUES (2, 1, 'سفید', 2, 1, 1781736278, 1781736278, '#FFFFFF');
INSERT INTO `option` VALUES (3, 1, 'طوسی', 3, 1, 1781736278, 1781736278, '#808080');
INSERT INTO `option` VALUES (4, 1, 'بژ', 4, 1, 1781736278, 1781736278, '#F5F5DC');
INSERT INTO `option` VALUES (5, 2, 'S', 1, 1, 1781736278, 1781736278, NULL);
INSERT INTO `option` VALUES (6, 2, 'M', 2, 1, 1781736278, 1781736278, NULL);
INSERT INTO `option` VALUES (7, 2, 'L', 3, 1, 1781736278, 1781736278, NULL);
INSERT INTO `option` VALUES (8, 2, 'XL', 4, 1, 1781736278, 1781736278, NULL);
INSERT INTO `option` VALUES (9, 3, 'پنبه', 1, 1, 1781736278, 1781736278, NULL);
INSERT INTO `option` VALUES (10, 3, 'کتان', 2, 1, 1781736278, 1781736278, NULL);
INSERT INTO `option` VALUES (11, 3, 'پلی استر', 3, 1, 1781736278, 1781736278, NULL);

-- ----------------------------
-- Table structure for product
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `is_active` tinyint NOT NULL DEFAULT 1,
  `published_at` int NULL DEFAULT NULL,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  `price` decimal(15, 2) NULL DEFAULT 0.00,
  `sale_price` decimal(15, 2) NULL DEFAULT NULL,
  `sale_start_date` int NULL DEFAULT NULL,
  `sale_end_date` int NULL DEFAULT NULL,
  `meta_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `meta_keywords` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sku` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `weight` decimal(10, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `slug`(`slug` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 32 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of product
-- ----------------------------
INSERT INTO `product` VALUES (1, 'مانتو مجلسی زنانه مدل الیزابت', 'women-formal-coat-elizabeth', '<p>مانتو مجلسی الیزابت با طراحی خاص و منحصر‌به‌فرد، انتخابی عالی برای مهمانی‌ها و مراسم خاص شماست.</p>\r\n    <ul>\r\n        <li>جنس: پارچه کتان با کیفیت بالا</li>\r\n        <li>آستین: بلند با سرآستین مروارید دوزی شده</li>\r\n        <li>یقه: هفت با تزئینات خاص</li>\r\n        <li>قد: تا زانو</li>\r\n        <li>دارای جیب‌های تزیینی</li>\r\n    </ul>', 1, NULL, 1781736311, 1781736311, 2850000.00, 2250000.00, 1781736311, 1784328311, 'مانتو مجلسی زنانه الیزابت | خرید بهترین مانتوهای مجلسی', 'خرید مانتو مجلسی زنانه مدل الیزابت با طراحی خاص و کیفیت عالی. مناسب برای مهمانی‌ها و مراسم خاص. قیمت مناسب و ارسال سریع.', 'مانتو مجلسی, لباس مجلسی زنانه, مانتو زنانه, خرید مانتو', 'WOMAN-COAT-001', 850.00);
INSERT INTO `product` VALUES (2, 'بافت زنانه مدل آریا', 'women-knit-sweater-aria', '<p>بافت زنانه آریا با طراحی کلاسیک و جنس پشم ایرانی</p>', 1, NULL, 1782300000, 1782300000, 1200000.00, 980000.00, 1782300000, 1784900000, 'بافت زنانه آریا', 'خرید بافت زنانه مدل آریا با کیفیت عالی', 'بافت زنانه, پلیور زنانه', 'WOMAN-KNIT-001', 400.00);
INSERT INTO `product` VALUES (3, 'بلوز شومیز زنانه مدل نگار', 'women-blouse-negar', '<p>بلوز شومیز نگار با یقه ساده و کیفیت پارچه عالی</p>', 1, NULL, 1782300100, 1782300100, 890000.00, NULL, NULL, NULL, 'بلوز شومیز نگار', 'خرید بلوز شومیز زنانه نگار', 'بلوز زنانه, شومیز زنانه', 'WOMAN-BLOUSE-001', 300.00);
INSERT INTO `product` VALUES (4, 'تونیک زنانه مدل دانا', 'women-tunic-dana', '<p>تونیک دانا با طراحی راحت و چاپ گل</p>', 1, NULL, 1782300200, 1782300200, 750000.00, 620000.00, 1782300200, 1784900000, 'تونیک زنانه دانا', 'خرید تونیک زنانه مدل دانا', 'تونیک زنانه, لباس راحتی', 'WOMAN-TUNIC-001', 350.00);
INSERT INTO `product` VALUES (5, 'پیراهن زنانه مدل سونا', 'women-shirt-sona', '<p>پیراهن مجلسی سونا با پارچه ساتن</p>', 1, NULL, 1782300300, 1782300300, 1450000.00, 1200000.00, 1782300300, 1784900000, 'پیراهن زنانه سونا', 'خرید پیراهن زنانه مدل سونا', 'پیراهن زنانه, لباس مجلسی', 'WOMAN-SHIRT-001', 500.00);
INSERT INTO `product` VALUES (6, 'سرهمی زنانه مدل پانیا', 'women-overall-pania', '<p>سرهمی مدرن پانیا برای استایل روزمره</p>', 1, NULL, 1782300400, 1782300400, 1100000.00, NULL, NULL, NULL, 'سرهمی زنانه پانیا', 'خرید سرهمی زنانه مدل پانیا', 'سرهمی زنانه, اورال زنانه', 'WOMAN-OVRL-001', 450.00);
INSERT INTO `product` VALUES (7, 'کت زنانه مدل ستاره', 'women-coat-setareh', '<p>کت رسمی ستاره مناسب محیط کار</p>', 1, NULL, 1782300500, 1782300500, 2200000.00, 1900000.00, 1782300500, 1784900000, 'کت زنانه ستاره', 'خرید کت زنانه مدل ستاره', 'کت زنانه, کت رسمی', 'WOMAN-COAT-002', 700.00);
INSERT INTO `product` VALUES (8, 'کاپشن زنانه مدل آوا', 'women-raincoat-ava', '<p>کاپشن سبک آوا با پوشش مناسب فصل سرد</p>', 1, NULL, 1782300600, 1782300600, 1800000.00, 1500000.00, 1782300600, 1784900000, 'کاپشن زنانه آوا', 'خرید کاپشن زنانه مدل آوا', 'کاپشن زنانه, جاکت زنانه', 'WOMAN-JACK-001', 800.00);
INSERT INTO `product` VALUES (9, 'پالتو زنانه مدل لیلا', 'women-overcoat-leila', '<p>پالتو بلند لیلا با کیفیت پارچه گرم</p>', 1, NULL, 1782300700, 1782300700, 3200000.00, 2800000.00, 1782300700, 1784900000, 'پالتو زنانه لیلا', 'خرید پالتو زنانه مدل لیلا', 'پالتو زنانه, پالتو بلند', 'WOMAN-PALTO-001', 1200.00);
INSERT INTO `product` VALUES (10, 'ترنچ کت زنانه مدل رها', 'women-trench-raha', '<p>ترنچ کت رها با طراحی کلاسیک اروپایی</p>', 1, NULL, 1782300800, 1782300800, 2600000.00, NULL, NULL, NULL, 'ترنچ کت زنانه رها', 'خرید ترنچ کت زنانه مدل رها', 'ترنچ کت, بارانی زنانه', 'WOMAN-TRNCH-001', 900.00);
INSERT INTO `product` VALUES (11, 'هودی زنانه مدل مهسا', 'women-hoodie-mahsa', '<p>هودی راحت مهسا برای روزهای خانه</p>', 1, NULL, 1782300900, 1782300900, 980000.00, 820000.00, 1782300900, 1784900000, 'هودی زنانه مهسا', 'خرید هودی زنانه مدل مهسا', 'هودی زنانه, سویشرت زنانه', 'WOMAN-HOOD-001', 550.00);
INSERT INTO `product` VALUES (12, 'پلیور زنانه مدل نازنین', 'women-sweater-naznin', '<p>پلیور بافت نازنین با طرح چهارخانه</p>', 1, NULL, 1782301000, 1782301000, 1050000.00, 890000.00, 1782301000, 1784900000, 'پلیور زنانه نازنین', 'خرید پلیور زنانه مدل نازنین', 'پلیور زنانه, دورس زنانه', 'WOMAN-SWTR-001', 480.00);
INSERT INTO `product` VALUES (13, 'وست زنانه مدل شیوا', 'women-waistcoat-shiva', '<p>وست زنانه شیوا برای لایه‌بندی استایل</p>', 1, NULL, 1782301100, 1782301100, 650000.00, NULL, NULL, NULL, 'وست زنانه شیوا', 'خرید وست زنانه مدل شیوا', 'وست زنانه, جلیقه زنانه', 'WOMAN-VEST-001', 320.00);
INSERT INTO `product` VALUES (14, 'شلوار راسته زنانه مدل ملیکا', 'women-trousers-melika', '<p>شلوار راسته کلاسیک ملیکا مناسب اداری</p>', 1, NULL, 1782301200, 1782301200, 920000.00, 750000.00, 1782301200, 1784900000, 'شلوار راسته ملیکا', 'خرید شلوار راسته زنانه مدل ملیکا', 'شلوار زنانه, شلوار رسمی', 'WOMAN-TRSR-001', 600.00);
INSERT INTO `product` VALUES (15, 'شلوار پارچه‌ای زنانه مدل یاس', 'women-fabric-pants-yas', '<p>شلوار پارچه‌ای یاس با کمرکش راحت</p>', 1, NULL, 1782301300, 1782301300, 780000.00, NULL, NULL, NULL, 'شلوار پارچه‌ای یاس', 'خرید شلوار پارچه‌ای زنانه یاس', 'شلوار پارچه‌ای, شلوار زنانه', 'WOMAN-FBRC-001', 550.00);
INSERT INTO `product` VALUES (16, 'لگینگ زنانه مدل روشا', 'women-leggings-rousha', '<p>لگینگ اسپرت روشا برای ورزش و پیاده‌روی</p>', 1, NULL, 1782301400, 1782301400, 450000.00, 380000.00, 1782301400, 1784900000, 'لگینگ زنانه روشا', 'خرید لگینگ زنانه مدل روشا', 'لگینگ زنانه, ساپورت زنانه', 'WOMAN-LEG-001', 280.00);
INSERT INTO `product` VALUES (17, 'بافت مردانه مدل کامیار', 'men-knit-sweater-kamyar', '<p>بافت مردانه کامیار با پارچه پشم ایرانی</p>', 1, NULL, 1782301500, 1782301500, 1350000.00, 1100000.00, 1782301500, 1784900000, 'بافت مردانه کامیار', 'خرید بافت مردانه مدل کامیار', 'بافت مردانه, پلیور مردانه', 'MAN-KNIT-001', 500.00);
INSERT INTO `product` VALUES (18, 'پلیور مردانه مدل سینا', 'men-sweater-sina', '<p>پلیور مردانه سینا با طرح یقه گرد</p>', 1, NULL, 1782301600, 1782301600, 1150000.00, 950000.00, 1782301600, 1784900000, 'پلیور مردانه سینا', 'خرید پلیور مردانه مدل سینا', 'پلیور مردانه, دورس مردانه', 'MAN-SWTR-001', 520.00);
INSERT INTO `product` VALUES (19, 'کاپشن مردانه مدل آرش', 'men-raincoat-arash', '<p>کاپشن سبک آرش مناسب فصل بهار و پاییز</p>', 1, NULL, 1782301700, 1782301700, 2100000.00, 1750000.00, 1782301700, 1784900000, 'کاپشن مردانه آرش', 'خرید کاپشن مردانه مدل آرش', 'کاپشن مردانه, جاکت مردانه', 'MAN-JACK-001', 900.00);
INSERT INTO `product` VALUES (20, 'پیراهن مردانه مدل بهراد', 'men-shirt-behrad', '<p>پیراهن رسمی بهراد برای محیط کار</p>', 1, NULL, 1782301800, 1782301800, 980000.00, NULL, NULL, NULL, 'پیراهن مردانه بهراد', 'خرید پیراهن مردانه مدل بهراد', 'پیراهن مردانه, پیراهن رسمی', 'MAN-SHIRT-001', 400.00);
INSERT INTO `product` VALUES (21, 'هودی مردانه مدل داریوش', 'men-hoodie-daryush', '<p>هودی راحت داریوش با کاپشن جدا شدنی</p>', 1, NULL, 1782301900, 1782301900, 1200000.00, 1000000.00, 1782301900, 1784900000, 'هودی مردانه داریوش', 'خرید هودی مردانه مدل داریوش', 'هودی مردانه, سویشرت مردانه', 'MAN-HOOD-001', 650.00);
INSERT INTO `product` VALUES (22, 'شلوار جین مردانه مدل پارسا', 'men-jeans-parsa', '<p>شلوار جین راسته پارسا با جنس دنیم ترکی</p>', 1, NULL, 1782302000, 1782302000, 1100000.00, 920000.00, 1782302000, 1784900000, 'شلوار جین پارسا', 'خرید شلوار جین مردانه مدل پارسا', 'شلوار جین مردانه, جین مردانه', 'MAN-JEAN-001', 700.00);
INSERT INTO `product` VALUES (23, 'شلوار پارچه‌ای مردانه مدل رضا', 'men-fabric-pants-reza', '<p>شلوار پارچه‌ای رسمی رضا مناسب مجالس</p>', 1, NULL, 1782302100, 1782302100, 1050000.00, NULL, NULL, NULL, 'شلوار پارچه‌ای رضا', 'خرید شلوار پارچه‌ای مردانه رضا', 'شلوار پارچه‌ای مردانه, شلوار کتی', 'MAN-FBRC-001', 650.00);
INSERT INTO `product` VALUES (24, 'شلوار اسپرت مردانه مدل نوید', 'men-jogger-navid', '<p>شلوار جاگر نوید برای ورزش و خانه</p>', 1, NULL, 1782302200, 1782302200, 680000.00, 560000.00, 1782302200, 1784900000, 'شلوار اسپرت نوید', 'خرید شلوار اسپرت مردانه نوید', 'شلوار اسپرت مردانه, جاگر مردانه', 'MAN-JGR-001', 480.00);
INSERT INTO `product` VALUES (25, 'شلوارک مردانه مدل سعید', 'men-shorts-saeed', '<p>شلوارک تابستانی سعید با جنس کتان</p>', 1, NULL, 1782302300, 1782302300, 520000.00, 440000.00, 1782302300, 1784900000, 'شلوارک مردانه سعید', 'خرید شلوارک مردانه مدل سعید', 'شلوارک مردانه, شورتک مردانه', 'MAN-SHORT-001', 350.00);
INSERT INTO `product` VALUES (26, 'تیشرت مردانه مدل امیر', 'men-tshirt-amir', '<p>تیشرت ساده امیر با پارچه پنبه‌ای</p>', 1, NULL, 1782302400, 1782302400, 380000.00, NULL, NULL, NULL, 'تیشرت مردانه امیر', 'خرید تیشرت مردانه مدل امیر', 'تیشرت مردانه, پولوشرت مردانه', 'MAN-TSHRT-001', 250.00);
INSERT INTO `product` VALUES (27, 'ست اسپرت مردانه مدل علی', 'men-set-ali', '<p>ست اسپرت علی شامل شلوار و بالاپوش</p>', 1, NULL, 1782302500, 1782302500, 1500000.00, 1250000.00, 1782302500, 1784900000, 'ست اسپرت مردانه علی', 'خرید ست اسپرت مردانه مدل علی', 'ست اسپرت مردانه, ست ورزشی', 'MAN-SET-001', 800.00);
INSERT INTO `product` VALUES (28, 'بلوز آستین بلند مردانه مدل حسن', 'men-long-sleeve-hasan', '<p>بلوز آستین بلند یقه دار حسن برای فصل خنک</p>', 1, NULL, 1782302600, 1782302600, 720000.00, 600000.00, 1782302600, 1784900000, 'بلوز آستین بلند حسن', 'خرید بلوز آستین بلند مردانه حسن', 'بلوز مردانه, آستین بلند مردانه', 'MAN-LS-001', 420.00);
INSERT INTO `product` VALUES (29, 'کلاه مردانه مدل مجید', 'men-hat-majid', '<p>کلاه بافتنی زمستانی مجید</p>', 1, NULL, 1782302700, 1782302700, 280000.00, NULL, NULL, NULL, 'کلاه مردانه مجید', 'خرید کلاه مردانه مدل مجید', 'کلاه مردانه, کلاه زمستانی', 'MAN-HAT-001', 150.00);
INSERT INTO `product` VALUES (30, 'جوراب مردانه مدل کریم', 'men-socks-karim', '<p>جوراب ساق بلند کریم برای فصل سرد</p>', 1, NULL, 1782302800, 1782302800, 180000.00, 150000.00, 1782302800, 1784900000, 'جوراب مردانه کریم', 'خرید جوراب مردانه مدل کریم', 'جوراب مردانه, جوراب ساق بلند', 'MAN-SOCK-001', 80.00);
INSERT INTO `product` VALUES (31, 'کمربند مردانه مدل فرهاد', 'men-belt-farhad', '<p>کمربند چرم فرهاد مناسب کت و شلوار</p>', 1, NULL, 1782302900, 1782302900, 450000.00, 380000.00, 1782302900, 1784900000, 'کمربند مردانه فرهاد', 'خرید کمربند مردانه مدل فرهاد', 'کمربند مردانه, کمربند چرم', 'MAN-BELT-001', 200.00);

-- ----------------------------
-- Table structure for product_image
-- ----------------------------
DROP TABLE IF EXISTS `product_image`;
CREATE TABLE `product_image`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_image_type_id` int UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL,
  `image_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT 0,
  `is_main` tinyint NOT NULL DEFAULT 0,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_product_image_type_id`(`product_image_type_id` ASC) USING BTREE,
  INDEX `fk_product_image_product_id`(`product_id` ASC) USING BTREE,
  CONSTRAINT `fk_product_image_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_product_image_type_id` FOREIGN KEY (`product_image_type_id`) REFERENCES `product_image_type` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 156 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of product_image
-- ----------------------------
INSERT INTO `product_image` VALUES (1, 1, 1, 'formal-coat-thumb.webp', 'formal-coat-main.jpg', 'مانتو مجلسی زنانه الیزابت', 0, 1, 1781736481, 1781736481);
INSERT INTO `product_image` VALUES (2, 2, 1, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'نمایش پشت مانتو مجلسی', 0, 0, 1781736481, 1781736481);
INSERT INTO `product_image` VALUES (3, 2, 1, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'جزئیات یقه مانتو مجلسی', 1, 0, 1781736481, 1781736481);
INSERT INTO `product_image` VALUES (4, 2, 1, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'جزئیات سرآستین مانتو مجلسی', 2, 0, 1781736481, 1781736481);
INSERT INTO `product_image` VALUES (5, 2, 1, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-3.jpg', 'جزئیات سرآستین مانتو مجلسی', 3, 0, 1781736481, 1781736481);
INSERT INTO `product_image` VALUES (6, 1, 2, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'بافت زنانه آریا - تصویر اصلی', 0, 1, 1782300000, 1782300000);
INSERT INTO `product_image` VALUES (7, 2, 2, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'بافت زنانه آریا - نمای جلو', 0, 0, 1782300000, 1782300000);
INSERT INTO `product_image` VALUES (8, 2, 2, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'بافت زنانه آریا - نمای پشت', 1, 0, 1782300000, 1782300000);
INSERT INTO `product_image` VALUES (9, 2, 2, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'بافت زنانه آریا - جزئیات بافت', 2, 0, 1782300000, 1782300000);
INSERT INTO `product_image` VALUES (10, 2, 2, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'بافت زنانه آریا - جزئیات آستین', 3, 0, 1782300000, 1782300000);
INSERT INTO `product_image` VALUES (11, 1, 3, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'بلوز شومیز نگار - تصویر اصلی', 0, 1, 1782300100, 1782300100);
INSERT INTO `product_image` VALUES (12, 2, 3, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'بلوز شومیز نگار - نمای جلو', 0, 0, 1782300100, 1782300100);
INSERT INTO `product_image` VALUES (13, 2, 3, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'بلوز شومیز نگار - نمای پشت', 1, 0, 1782300100, 1782300100);
INSERT INTO `product_image` VALUES (14, 2, 3, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'بلوز شومیز نگار - جزئیات یقه', 2, 0, 1782300100, 1782300100);
INSERT INTO `product_image` VALUES (15, 2, 3, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'بلوز شومیز نگار - جزئیات سرآستین', 3, 0, 1782300100, 1782300100);
INSERT INTO `product_image` VALUES (16, 1, 4, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'تونیک دانا - تصویر اصلی', 0, 1, 1782300200, 1782300200);
INSERT INTO `product_image` VALUES (17, 2, 4, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'تونیک دانا - نمای جلو', 0, 0, 1782300200, 1782300200);
INSERT INTO `product_image` VALUES (18, 2, 4, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'تونیک دانا - نمای پشت', 1, 0, 1782300200, 1782300200);
INSERT INTO `product_image` VALUES (19, 2, 4, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'تونیک دانا - جزئیات چاپ', 2, 0, 1782300200, 1782300200);
INSERT INTO `product_image` VALUES (20, 2, 4, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'تونیک دانا - جزئیات کمر', 3, 0, 1782300200, 1782300200);
INSERT INTO `product_image` VALUES (21, 1, 5, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'پیراهن سونا - تصویر اصلی', 0, 1, 1782300300, 1782300300);
INSERT INTO `product_image` VALUES (22, 2, 5, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'پیراهن سونا - نمای جلو', 0, 0, 1782300300, 1782300300);
INSERT INTO `product_image` VALUES (23, 2, 5, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'پیراهن سونا - نمای پشت', 1, 0, 1782300300, 1782300300);
INSERT INTO `product_image` VALUES (24, 2, 5, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'پیراهن سونا - جزئیات تزئینات', 2, 0, 1782300300, 1782300300);
INSERT INTO `product_image` VALUES (25, 2, 5, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'پیراهن سونا - جزئیات دامن', 3, 0, 1782300300, 1782300300);
INSERT INTO `product_image` VALUES (26, 1, 6, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'سرهمی پانیا - تصویر اصلی', 0, 1, 1782300400, 1782300400);
INSERT INTO `product_image` VALUES (27, 2, 6, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'سرهمی پانیا - نمای جلو', 0, 0, 1782300400, 1782300400);
INSERT INTO `product_image` VALUES (28, 2, 6, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'سرهمی پانیا - نمای پشت', 1, 0, 1782300400, 1782300400);
INSERT INTO `product_image` VALUES (29, 2, 6, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'سرهمی پانیا - جزئیات جیب', 2, 0, 1782300400, 1782300400);
INSERT INTO `product_image` VALUES (30, 2, 6, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'سرهمی پانیا - جزئیات بند', 3, 0, 1782300400, 1782300400);
INSERT INTO `product_image` VALUES (31, 1, 7, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'کت ستاره - تصویر اصلی', 0, 1, 1782300500, 1782300500);
INSERT INTO `product_image` VALUES (32, 2, 7, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'کت ستاره - نمای جلو', 0, 0, 1782300500, 1782300500);
INSERT INTO `product_image` VALUES (33, 2, 7, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'کت ستاره - نمای پشت', 1, 0, 1782300500, 1782300500);
INSERT INTO `product_image` VALUES (34, 2, 7, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'کت ستاره - جزئیات دکمه', 2, 0, 1782300500, 1782300500);
INSERT INTO `product_image` VALUES (35, 2, 7, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'کت ستاره - جزئیات یقه', 3, 0, 1782300500, 1782300500);
INSERT INTO `product_image` VALUES (36, 1, 8, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'کاپشن آوا - تصویر اصلی', 0, 1, 1782300600, 1782300600);
INSERT INTO `product_image` VALUES (37, 2, 8, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'کاپشن آوا - نمای جلو', 0, 0, 1782300600, 1782300600);
INSERT INTO `product_image` VALUES (38, 2, 8, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'کاپشن آوا - نمای پشت', 1, 0, 1782300600, 1782300600);
INSERT INTO `product_image` VALUES (39, 2, 8, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'کاپشن آوا - جزئیات زیپ', 2, 0, 1782300600, 1782300600);
INSERT INTO `product_image` VALUES (40, 2, 8, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'کاپشن آوا - جزئیات جیب', 3, 0, 1782300600, 1782300600);
INSERT INTO `product_image` VALUES (41, 1, 9, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'پالتو لیلا - تصویر اصلی', 0, 1, 1782300700, 1782300700);
INSERT INTO `product_image` VALUES (42, 2, 9, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'پالتو لیلا - نمای جلو', 0, 0, 1782300700, 1782300700);
INSERT INTO `product_image` VALUES (43, 2, 9, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'پالتو لیلا - نمای پشت', 1, 0, 1782300700, 1782300700);
INSERT INTO `product_image` VALUES (44, 2, 9, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'پالتو لیلا - جزئیات کمربند', 2, 0, 1782300700, 1782300700);
INSERT INTO `product_image` VALUES (45, 2, 9, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'پالتو لیلا - جزئیات یقه', 3, 0, 1782300700, 1782300700);
INSERT INTO `product_image` VALUES (46, 1, 10, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'ترنچ کت رها - تصویر اصلی', 0, 1, 1782300800, 1782300800);
INSERT INTO `product_image` VALUES (47, 2, 10, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'ترنچ کت رها - نمای جلو', 0, 0, 1782300800, 1782300800);
INSERT INTO `product_image` VALUES (48, 2, 10, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'ترنچ کت رها - نمای پشت', 1, 0, 1782300800, 1782300800);
INSERT INTO `product_image` VALUES (49, 2, 10, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'ترنچ کت رها - جزئیات کمربند', 2, 0, 1782300800, 1782300800);
INSERT INTO `product_image` VALUES (50, 2, 10, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'ترنچ کت رها - جزئیات دکمه', 3, 0, 1782300800, 1782300800);
INSERT INTO `product_image` VALUES (51, 1, 11, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'هودی مهسا - تصویر اصلی', 0, 1, 1782300900, 1782300900);
INSERT INTO `product_image` VALUES (52, 2, 11, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'هودی مهسا - نمای جلو', 0, 0, 1782300900, 1782300900);
INSERT INTO `product_image` VALUES (53, 2, 11, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'هودی مهسا - نمای پشت', 1, 0, 1782300900, 1782300900);
INSERT INTO `product_image` VALUES (54, 2, 11, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'هودی مهسا - جزئیات کاپوت', 2, 0, 1782300900, 1782300900);
INSERT INTO `product_image` VALUES (55, 2, 11, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'هودی مهسا - جزئیات جیب کانگرو', 3, 0, 1782300900, 1782300900);
INSERT INTO `product_image` VALUES (56, 1, 12, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'پلیور نازنین - تصویر اصلی', 0, 1, 1782301000, 1782301000);
INSERT INTO `product_image` VALUES (57, 2, 12, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'پلیور نازنین - نمای جلو', 0, 0, 1782301000, 1782301000);
INSERT INTO `product_image` VALUES (58, 2, 12, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'پلیور نازنین - نمای پشت', 1, 0, 1782301000, 1782301000);
INSERT INTO `product_image` VALUES (59, 2, 12, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'پلیور نازنین - جزئیات طرح چهارخانه', 2, 0, 1782301000, 1782301000);
INSERT INTO `product_image` VALUES (60, 2, 12, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'پلیور نازنین - جزئیات یقه', 3, 0, 1782301000, 1782301000);
INSERT INTO `product_image` VALUES (61, 1, 13, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'وست شیوا - تصویر اصلی', 0, 1, 1782301100, 1782301100);
INSERT INTO `product_image` VALUES (62, 2, 13, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'وست شیوا - نمای جلو', 0, 0, 1782301100, 1782301100);
INSERT INTO `product_image` VALUES (63, 2, 13, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'وست شیوا - نمای پشت', 1, 0, 1782301100, 1782301100);
INSERT INTO `product_image` VALUES (64, 2, 13, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'وست شیوا - جزئیات دکمه', 2, 0, 1782301100, 1782301100);
INSERT INTO `product_image` VALUES (65, 2, 13, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'وست شیوا - جزئیات جیب', 3, 0, 1782301100, 1782301100);
INSERT INTO `product_image` VALUES (66, 1, 14, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'شلوار راسته ملیکا - تصویر اصلی', 0, 1, 1782301200, 1782301200);
INSERT INTO `product_image` VALUES (67, 2, 14, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'شلوار راسته ملیکا - نمای جلو', 0, 0, 1782301200, 1782301200);
INSERT INTO `product_image` VALUES (68, 2, 14, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'شلوار راسته ملیکا - نمای پشت', 1, 0, 1782301200, 1782301200);
INSERT INTO `product_image` VALUES (69, 2, 14, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'شلوار راسته ملیکا - جزئیات کمر', 2, 0, 1782301200, 1782301200);
INSERT INTO `product_image` VALUES (70, 2, 14, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'شلوار راسته ملیکا - جزئیات دمپا', 3, 0, 1782301200, 1782301200);
INSERT INTO `product_image` VALUES (71, 1, 15, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'شلوار پارچه‌ای یاس - تصویر اصلی', 0, 1, 1782301300, 1782301300);
INSERT INTO `product_image` VALUES (72, 2, 15, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'شلوار پارچه‌ای یاس - نمای جلو', 0, 0, 1782301300, 1782301300);
INSERT INTO `product_image` VALUES (73, 2, 15, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'شلوار پارچه‌ای یاس - نمای پشت', 1, 0, 1782301300, 1782301300);
INSERT INTO `product_image` VALUES (74, 2, 15, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'شلوار پارچه‌ای یاس - جزئیات جیب', 2, 0, 1782301300, 1782301300);
INSERT INTO `product_image` VALUES (75, 2, 15, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'شلوار پارچه‌ای یاس - جزئیات کمرکش', 3, 0, 1782301300, 1782301300);
INSERT INTO `product_image` VALUES (76, 1, 16, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'لگینگ روشا - تصویر اصلی', 0, 1, 1782301400, 1782301400);
INSERT INTO `product_image` VALUES (77, 2, 16, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'لگینگ روشا - نمای جلو', 0, 0, 1782301400, 1782301400);
INSERT INTO `product_image` VALUES (78, 2, 16, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'لگینگ روشا - نمای پشت', 1, 0, 1782301400, 1782301400);
INSERT INTO `product_image` VALUES (79, 2, 16, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'لگینگ روشا - جزئیات کمر پهن', 2, 0, 1782301400, 1782301400);
INSERT INTO `product_image` VALUES (80, 2, 16, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'لگینگ روشا - جزئیات پارچه', 3, 0, 1782301400, 1782301400);
INSERT INTO `product_image` VALUES (81, 1, 17, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'بافت مردانه کامیار - تصویر اصلی', 0, 1, 1782301500, 1782301500);
INSERT INTO `product_image` VALUES (82, 2, 17, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'بافت مردانه کامیار - نمای جلو', 0, 0, 1782301500, 1782301500);
INSERT INTO `product_image` VALUES (83, 2, 17, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'بافت مردانه کامیار - نمای پشت', 1, 0, 1782301500, 1782301500);
INSERT INTO `product_image` VALUES (84, 2, 17, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'بافت مردانه کامیار - جزئیات بافت', 2, 0, 1782301500, 1782301500);
INSERT INTO `product_image` VALUES (85, 2, 17, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'بافت مردانه کامیار - جزئیات یقه', 3, 0, 1782301500, 1782301500);
INSERT INTO `product_image` VALUES (86, 1, 18, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'پلیور سینا - تصویر اصلی', 0, 1, 1782301600, 1782301600);
INSERT INTO `product_image` VALUES (87, 2, 18, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'پلیور سینا - نمای جلو', 0, 0, 1782301600, 1782301600);
INSERT INTO `product_image` VALUES (88, 2, 18, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'پلیور سینا - نمای پشت', 1, 0, 1782301600, 1782301600);
INSERT INTO `product_image` VALUES (89, 2, 18, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'پلیور سینا - جزئیات یقه گرد', 2, 0, 1782301600, 1782301600);
INSERT INTO `product_image` VALUES (90, 2, 18, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'پلیور سینا - جزئیات آستین', 3, 0, 1782301600, 1782301600);
INSERT INTO `product_image` VALUES (91, 1, 19, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'کاپشن آرش - تصویر اصلی', 0, 1, 1782301700, 1782301700);
INSERT INTO `product_image` VALUES (92, 2, 19, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'کاپشن آرش - نمای جلو', 0, 0, 1782301700, 1782301700);
INSERT INTO `product_image` VALUES (93, 2, 19, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'کاپشن آرش - نمای پشت', 1, 0, 1782301700, 1782301700);
INSERT INTO `product_image` VALUES (94, 2, 19, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'کاپشن آرش - جزئیات زیپ', 2, 0, 1782301700, 1782301700);
INSERT INTO `product_image` VALUES (95, 2, 19, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'کاپشن آرش - جزئیات جیب', 3, 0, 1782301700, 1782301700);
INSERT INTO `product_image` VALUES (96, 1, 20, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'پیراهن بهراد - تصویر اصلی', 0, 1, 1782301800, 1782301800);
INSERT INTO `product_image` VALUES (97, 2, 20, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'پیراهن بهراد - نمای جلو', 0, 0, 1782301800, 1782301800);
INSERT INTO `product_image` VALUES (98, 2, 20, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'پیراهن بهراد - نمای پشت', 1, 0, 1782301800, 1782301800);
INSERT INTO `product_image` VALUES (99, 2, 20, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'پیراهن بهراد - جزئیات یقه', 2, 0, 1782301800, 1782301800);
INSERT INTO `product_image` VALUES (100, 2, 20, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'پیراهن بهراد - جزئیات دکمه‌های صدفی', 3, 0, 1782301800, 1782301800);
INSERT INTO `product_image` VALUES (101, 1, 21, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'هودی داریوش - تصویر اصلی', 0, 1, 1782301900, 1782301900);
INSERT INTO `product_image` VALUES (102, 2, 21, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'هودی داریوش - نمای جلو', 0, 0, 1782301900, 1782301900);
INSERT INTO `product_image` VALUES (103, 2, 21, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'هودی داریوش - نمای پشت', 1, 0, 1782301900, 1782301900);
INSERT INTO `product_image` VALUES (104, 2, 21, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'هودی داریوش - جزئیات کاپوت', 2, 0, 1782301900, 1782301900);
INSERT INTO `product_image` VALUES (105, 2, 21, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'هودی داریوش - جزئیات جیب', 3, 0, 1782301900, 1782301900);
INSERT INTO `product_image` VALUES (106, 1, 22, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'شلوار جین پارسا - تصویر اصلی', 0, 1, 1782302000, 1782302000);
INSERT INTO `product_image` VALUES (107, 2, 22, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'شلوار جین پارسا - نمای جلو', 0, 0, 1782302000, 1782302000);
INSERT INTO `product_image` VALUES (108, 2, 22, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'شلوار جین پارسا - نمای پشت', 1, 0, 1782302000, 1782302000);
INSERT INTO `product_image` VALUES (109, 2, 22, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'شلوار جین پارسا - جزئیات دمپا', 2, 0, 1782302000, 1782302000);
INSERT INTO `product_image` VALUES (110, 2, 22, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'شلوار جین پارسا - جزئیات جیب', 3, 0, 1782302000, 1782302000);
INSERT INTO `product_image` VALUES (111, 1, 23, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'شلوار پارچه‌ای رضا - تصویر اصلی', 0, 1, 1782302100, 1782302100);
INSERT INTO `product_image` VALUES (112, 2, 23, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'شلوار پارچه‌ای رضا - نمای جلو', 0, 0, 1782302100, 1782302100);
INSERT INTO `product_image` VALUES (113, 2, 23, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'شلوار پارچه‌ای رضا - نمای پشت', 1, 0, 1782302100, 1782302100);
INSERT INTO `product_image` VALUES (114, 2, 23, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'شلوار پارچه‌ای رضا - جزئیات کمر', 2, 0, 1782302100, 1782302100);
INSERT INTO `product_image` VALUES (115, 2, 23, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'شلوار پارچه‌ای رضا - جزئیات دمپا', 3, 0, 1782302100, 1782302100);
INSERT INTO `product_image` VALUES (116, 1, 24, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'شلوار اسپرت نوید - تصویر اصلی', 0, 1, 1782302200, 1782302200);
INSERT INTO `product_image` VALUES (117, 2, 24, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'شلوار اسپرت نوید - نمای جلو', 0, 0, 1782302200, 1782302200);
INSERT INTO `product_image` VALUES (118, 2, 24, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'شلوار اسپرت نوید - نمای پشت', 1, 0, 1782302200, 1782302200);
INSERT INTO `product_image` VALUES (119, 2, 24, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'شلوار اسپرت نوید - جزئیات کش کمر', 2, 0, 1782302200, 1782302200);
INSERT INTO `product_image` VALUES (120, 2, 24, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'شلوار اسپرت نوید - جزئیات دمپا', 3, 0, 1782302200, 1782302200);
INSERT INTO `product_image` VALUES (121, 1, 25, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'شلوارک سعید - تصویر اصلی', 0, 1, 1782302300, 1782302300);
INSERT INTO `product_image` VALUES (122, 2, 25, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'شلوارک سعید - نمای جلو', 0, 0, 1782302300, 1782302300);
INSERT INTO `product_image` VALUES (123, 2, 25, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'شلوارک سعید - نمای پشت', 1, 0, 1782302300, 1782302300);
INSERT INTO `product_image` VALUES (124, 2, 25, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'شلوارک سعید - جزئیات جیب', 2, 0, 1782302300, 1782302300);
INSERT INTO `product_image` VALUES (125, 2, 25, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'شلوارک سعید - جزئیات کش', 3, 0, 1782302300, 1782302300);
INSERT INTO `product_image` VALUES (126, 1, 26, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'تیشرت امیر - تصویر اصلی', 0, 1, 1782302400, 1782302400);
INSERT INTO `product_image` VALUES (127, 2, 26, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'تیشرت امیر - نمای جلو', 0, 0, 1782302400, 1782302400);
INSERT INTO `product_image` VALUES (128, 2, 26, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'تیشرت امیر - نمای پشت', 1, 0, 1782302400, 1782302400);
INSERT INTO `product_image` VALUES (129, 2, 26, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'تیشرت امیر - جزئیات یقه', 2, 0, 1782302400, 1782302400);
INSERT INTO `product_image` VALUES (130, 2, 26, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'تیشرت امیر - جزئیات پارچه', 3, 0, 1782302400, 1782302400);
INSERT INTO `product_image` VALUES (131, 1, 27, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'ست اسپرت علی - تصویر اصلی', 0, 1, 1782302500, 1782302500);
INSERT INTO `product_image` VALUES (132, 2, 27, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'ست اسپرت علی - نمای جلو', 0, 0, 1782302500, 1782302500);
INSERT INTO `product_image` VALUES (133, 2, 27, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'ست اسپرت علی - نمای پشت', 1, 0, 1782302500, 1782302500);
INSERT INTO `product_image` VALUES (134, 2, 27, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'ست اسپرت علی - شلوار', 2, 0, 1782302500, 1782302500);
INSERT INTO `product_image` VALUES (135, 2, 27, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'ست اسپرت علی - بالاپوش', 3, 0, 1782302500, 1782302500);
INSERT INTO `product_image` VALUES (136, 1, 28, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'بلوز آستین بلند حسن - تصویر اصلی', 0, 1, 1782302600, 1782302600);
INSERT INTO `product_image` VALUES (137, 2, 28, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'بلوز آستین بلند حسن - نمای جلو', 0, 0, 1782302600, 1782302600);
INSERT INTO `product_image` VALUES (138, 2, 28, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'بلوز آستین بلند حسن - نمای پشت', 1, 0, 1782302600, 1782302600);
INSERT INTO `product_image` VALUES (139, 2, 28, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'بلوز آستین بلند حسن - جزئیات یقه', 2, 0, 1782302600, 1782302600);
INSERT INTO `product_image` VALUES (140, 2, 28, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'بلوز آستین بلند حسن - جزئیات آستین', 3, 0, 1782302600, 1782302600);
INSERT INTO `product_image` VALUES (141, 1, 29, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'کلاه مجید - تصویر اصلی', 0, 1, 1782302700, 1782302700);
INSERT INTO `product_image` VALUES (142, 2, 29, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'کلاه مجید - نمای جلو', 0, 0, 1782302700, 1782302700);
INSERT INTO `product_image` VALUES (143, 2, 29, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'کلاه مجید - نمای کنار', 1, 0, 1782302700, 1782302700);
INSERT INTO `product_image` VALUES (144, 2, 29, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'کلاه مجید - جزئیات بافت', 2, 0, 1782302700, 1782302700);
INSERT INTO `product_image` VALUES (145, 2, 29, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'کلاه مجید - جزئیات حاشیه', 3, 0, 1782302700, 1782302700);
INSERT INTO `product_image` VALUES (146, 1, 30, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'جوراب کریم - تصویر اصلی', 0, 1, 1782302800, 1782302800);
INSERT INTO `product_image` VALUES (147, 2, 30, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'جوراب کریم - نمای جلو', 0, 0, 1782302800, 1782302800);
INSERT INTO `product_image` VALUES (148, 2, 30, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'جوراب کریم - نمای کنار', 1, 0, 1782302800, 1782302800);
INSERT INTO `product_image` VALUES (149, 2, 30, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'جوراب کریم - جزئیات پاشنه', 2, 0, 1782302800, 1782302800);
INSERT INTO `product_image` VALUES (150, 2, 30, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'جوراب کریم - جزئیات ساق', 3, 0, 1782302800, 1782302800);
INSERT INTO `product_image` VALUES (151, 1, 31, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'کمربند فرهاد - تصویر اصلی', 0, 1, 1782302900, 1782302900);
INSERT INTO `product_image` VALUES (152, 2, 31, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'کمربند فرهاد - نمای جلو', 0, 0, 1782302900, 1782302900);
INSERT INTO `product_image` VALUES (153, 2, 31, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'کمربند فرهاد - نمای پشت', 1, 0, 1782302900, 1782302900);
INSERT INTO `product_image` VALUES (154, 2, 31, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'کمربند فرهاد - جزئیات سگک', 2, 0, 1782302900, 1782302900);
INSERT INTO `product_image` VALUES (155, 2, 31, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'کمربند فرهاد - جزئیات چرم', 3, 0, 1782302900, 1782302900);

-- ----------------------------
-- Table structure for product_image_type
-- ----------------------------
DROP TABLE IF EXISTS `product_image_type`;
CREATE TABLE `product_image_type`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `width` int UNSIGNED NULL DEFAULT NULL,
  `height` int UNSIGNED NULL DEFAULT NULL,
  `extension` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `file_size_limit` int UNSIGNED NULL DEFAULT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint NOT NULL DEFAULT 1,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of product_image_type
-- ----------------------------
INSERT INTO `product_image_type` VALUES (1, 'تصویر اصلی', 800, 800, 'jpg|png|webp', 2048, 'images/products', 1, 1781736267, 1781736267);
INSERT INTO `product_image_type` VALUES (2, 'تصویر گالری', 400, 400, 'jpg|png|webp', 1024, 'images/products', 1, 1781736267, 1781736267);

-- ----------------------------
-- Table structure for product_menu
-- ----------------------------
DROP TABLE IF EXISTS `product_menu`;
CREATE TABLE `product_menu`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` int UNSIGNED NOT NULL,
  `menu_3_id` int UNSIGNED NOT NULL,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_product_menu_product_id`(`product_id` ASC) USING BTREE,
  INDEX `fk_product_menu_menu_3_id`(`menu_3_id` ASC) USING BTREE,
  CONSTRAINT `fk_product_menu_menu_3_id` FOREIGN KEY (`menu_3_id`) REFERENCES `menu_3` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_product_menu_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 32 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of product_menu
-- ----------------------------
INSERT INTO `product_menu` VALUES (1, 1, 8, 1781736435, 1781736435);
INSERT INTO `product_menu` VALUES (2, 2, 1, 1782300000, 1782300000);
INSERT INTO `product_menu` VALUES (3, 3, 2, 1782300100, 1782300100);
INSERT INTO `product_menu` VALUES (4, 4, 3, 1782300200, 1782300200);
INSERT INTO `product_menu` VALUES (5, 5, 4, 1782300300, 1782300300);
INSERT INTO `product_menu` VALUES (6, 6, 5, 1782300400, 1782300400);
INSERT INTO `product_menu` VALUES (7, 7, 6, 1782300500, 1782300500);
INSERT INTO `product_menu` VALUES (8, 8, 7, 1782300600, 1782300600);
INSERT INTO `product_menu` VALUES (9, 9, 8, 1782300700, 1782300700);
INSERT INTO `product_menu` VALUES (10, 10, 9, 1782300800, 1782300800);
INSERT INTO `product_menu` VALUES (11, 11, 10, 1782300900, 1782300900);
INSERT INTO `product_menu` VALUES (12, 12, 11, 1782301000, 1782301000);
INSERT INTO `product_menu` VALUES (13, 13, 12, 1782301100, 1782301100);
INSERT INTO `product_menu` VALUES (14, 14, 13, 1782301200, 1782301200);
INSERT INTO `product_menu` VALUES (15, 15, 14, 1782301300, 1782301300);
INSERT INTO `product_menu` VALUES (16, 16, 16, 1782301400, 1782301400);
INSERT INTO `product_menu` VALUES (17, 17, 29, 1782301500, 1782301500);
INSERT INTO `product_menu` VALUES (18, 18, 30, 1782301600, 1782301600);
INSERT INTO `product_menu` VALUES (19, 19, 31, 1782301700, 1782301700);
INSERT INTO `product_menu` VALUES (20, 20, 32, 1782301800, 1782301800);
INSERT INTO `product_menu` VALUES (21, 21, 33, 1782301900, 1782301900);
INSERT INTO `product_menu` VALUES (22, 22, 34, 1782302000, 1782302000);
INSERT INTO `product_menu` VALUES (23, 23, 35, 1782302100, 1782302100);
INSERT INTO `product_menu` VALUES (24, 24, 36, 1782302200, 1782302200);
INSERT INTO `product_menu` VALUES (25, 25, 37, 1782302300, 1782302300);
INSERT INTO `product_menu` VALUES (26, 26, 38, 1782302400, 1782302400);
INSERT INTO `product_menu` VALUES (27, 27, 39, 1782302500, 1782302500);
INSERT INTO `product_menu` VALUES (28, 28, 40, 1782302600, 1782302600);
INSERT INTO `product_menu` VALUES (29, 29, 41, 1782302700, 1782302700);
INSERT INTO `product_menu` VALUES (30, 30, 42, 1782302800, 1782302800);
INSERT INTO `product_menu` VALUES (31, 31, 44, 1782302900, 1782302900);

-- ----------------------------
-- Table structure for product_option
-- ----------------------------
DROP TABLE IF EXISTS `product_option`;
CREATE TABLE `product_option`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` int UNSIGNED NOT NULL,
  `option_id` int UNSIGNED NOT NULL,
  `price` decimal(15, 2) NULL DEFAULT NULL,
  `stock` int NOT NULL DEFAULT 0,
  `sku` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_product_option_product_id`(`product_id` ASC) USING BTREE,
  INDEX `fk_product_option_option_id`(`option_id` ASC) USING BTREE,
  CONSTRAINT `fk_product_option_option_id` FOREIGN KEY (`option_id`) REFERENCES `option` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_product_option_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 216 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of product_option
-- ----------------------------
INSERT INTO `product_option` VALUES (1, 1, 1, 2850000.00, 15, 'WOMAN-COAT-001-BLK-S', 1781736444, 1781736444);
INSERT INTO `product_option` VALUES (2, 1, 1, 2850000.00, 20, 'WOMAN-COAT-001-BLK-M', 1781736444, 1781736444);
INSERT INTO `product_option` VALUES (3, 1, 1, 2850000.00, 10, 'WOMAN-COAT-001-BLK-L', 1781736444, 1781736444);
INSERT INTO `product_option` VALUES (4, 1, 2, 2950000.00, 12, 'WOMAN-COAT-001-WHT-S', 1781736444, 1781736444);
INSERT INTO `product_option` VALUES (5, 1, 2, 2950000.00, 18, 'WOMAN-COAT-001-WHT-M', 1781736444, 1781736444);
INSERT INTO `product_option` VALUES (6, 1, 3, 2750000.00, 8, 'WOMAN-COAT-001-GRY-S', 1781736444, 1781736444);
INSERT INTO `product_option` VALUES (7, 1, 3, 2750000.00, 10, 'WOMAN-COAT-001-GRY-M', 1781736444, 1781736444);
INSERT INTO `product_option` VALUES (8, 1, 5, NULL, 5, 'WOMAN-COAT-001-SIZE-S', 1781920240, 1781920240);
INSERT INTO `product_option` VALUES (9, 1, 6, NULL, 5, 'WOMAN-COAT-001-SIZE-M', 1781920240, 1781920240);
INSERT INTO `product_option` VALUES (10, 1, 7, NULL, 5, 'WOMAN-COAT-001-SIZE-L', 1781920240, 1781920240);
INSERT INTO `product_option` VALUES (11, 1, 8, NULL, 5, 'WOMAN-COAT-001-SIZE-XL', 1781920240, 1781920240);
INSERT INTO `product_option` VALUES (12, 1, 9, NULL, 0, 'WOMAN-COAT-001-FABRIC-COTTON', 1781920247, 1781920247);
INSERT INTO `product_option` VALUES (13, 1, 10, NULL, 0, 'WOMAN-COAT-001-FABRIC-LINEN', 1781920247, 1781920247);
INSERT INTO `product_option` VALUES (14, 1, 11, NULL, 0, 'WOMAN-COAT-001-FABRIC-POLYESTER', 1781920247, 1781920247);
INSERT INTO `product_option` VALUES (15, 2, 1, 1200000.00, 10, 'KNIT-ARIA-BLK', 1782300000, 1782300000);
INSERT INTO `product_option` VALUES (16, 2, 3, 1100000.00, 12, 'KNIT-ARIA-GRY', 1782300000, 1782300000);
INSERT INTO `product_option` VALUES (17, 2, 5, NULL, 8, 'KNIT-ARIA-S', 1782300000, 1782300000);
INSERT INTO `product_option` VALUES (18, 2, 6, NULL, 10, 'KNIT-ARIA-M', 1782300000, 1782300000);
INSERT INTO `product_option` VALUES (19, 2, 7, NULL, 6, 'KNIT-ARIA-L', 1782300000, 1782300000);
INSERT INTO `product_option` VALUES (20, 2, 9, NULL, 0, 'KNIT-ARIA-CTTN', 1782300000, 1782300000);
INSERT INTO `product_option` VALUES (21, 3, 2, 890000.00, 15, 'BLOUSE-NGR-WHT', 1782300100, 1782300100);
INSERT INTO `product_option` VALUES (22, 3, 4, 870000.00, 10, 'BLOUSE-NGR-BEG', 1782300100, 1782300100);
INSERT INTO `product_option` VALUES (23, 3, 5, NULL, 8, 'BLOUSE-NGR-S', 1782300100, 1782300100);
INSERT INTO `product_option` VALUES (24, 3, 6, NULL, 10, 'BLOUSE-NGR-M', 1782300100, 1782300100);
INSERT INTO `product_option` VALUES (25, 3, 7, NULL, 5, 'BLOUSE-NGR-L', 1782300100, 1782300100);
INSERT INTO `product_option` VALUES (26, 3, 9, NULL, 0, 'BLOUSE-NGR-CTTN', 1782300100, 1782300100);
INSERT INTO `product_option` VALUES (27, 4, 1, 750000.00, 20, 'TUNIC-DNA-BLK', 1782300200, 1782300200);
INSERT INTO `product_option` VALUES (28, 4, 2, 730000.00, 15, 'TUNIC-DNA-WHT', 1782300200, 1782300200);
INSERT INTO `product_option` VALUES (29, 4, 5, NULL, 10, 'TUNIC-DNA-S', 1782300200, 1782300200);
INSERT INTO `product_option` VALUES (30, 4, 6, NULL, 12, 'TUNIC-DNA-M', 1782300200, 1782300200);
INSERT INTO `product_option` VALUES (31, 4, 7, NULL, 8, 'TUNIC-DNA-L', 1782300200, 1782300200);
INSERT INTO `product_option` VALUES (32, 4, 10, NULL, 0, 'TUNIC-DNA-LNN', 1782300200, 1782300200);
INSERT INTO `product_option` VALUES (33, 5, 1, 1450000.00, 8, 'SHRT-SNA-BLK', 1782300300, 1782300300);
INSERT INTO `product_option` VALUES (34, 5, 2, 1480000.00, 10, 'SHRT-SNA-WHT', 1782300300, 1782300300);
INSERT INTO `product_option` VALUES (35, 5, 4, 1420000.00, 6, 'SHRT-SNA-BEG', 1782300300, 1782300300);
INSERT INTO `product_option` VALUES (36, 5, 5, NULL, 5, 'SHRT-SNA-S', 1782300300, 1782300300);
INSERT INTO `product_option` VALUES (37, 5, 6, NULL, 8, 'SHRT-SNA-M', 1782300300, 1782300300);
INSERT INTO `product_option` VALUES (38, 5, 7, NULL, 4, 'SHRT-SNA-L', 1782300300, 1782300300);
INSERT INTO `product_option` VALUES (39, 5, 11, NULL, 0, 'SHRT-SNA-PLY', 1782300300, 1782300300);
INSERT INTO `product_option` VALUES (40, 6, 1, 1100000.00, 10, 'OVRL-PNA-BLK', 1782300400, 1782300400);
INSERT INTO `product_option` VALUES (41, 6, 3, 1050000.00, 8, 'OVRL-PNA-GRY', 1782300400, 1782300400);
INSERT INTO `product_option` VALUES (42, 6, 5, NULL, 5, 'OVRL-PNA-S', 1782300400, 1782300400);
INSERT INTO `product_option` VALUES (43, 6, 6, NULL, 8, 'OVRL-PNA-M', 1782300400, 1782300400);
INSERT INTO `product_option` VALUES (44, 6, 7, NULL, 4, 'OVRL-PNA-L', 1782300400, 1782300400);
INSERT INTO `product_option` VALUES (45, 6, 10, NULL, 0, 'OVRL-PNA-LNN', 1782300400, 1782300400);
INSERT INTO `product_option` VALUES (46, 7, 1, 2200000.00, 5, 'COAT-STR-BLK', 1782300500, 1782300500);
INSERT INTO `product_option` VALUES (47, 7, 3, 2150000.00, 4, 'COAT-STR-GRY', 1782300500, 1782300500);
INSERT INTO `product_option` VALUES (48, 7, 4, 2180000.00, 3, 'COAT-STR-BEG', 1782300500, 1782300500);
INSERT INTO `product_option` VALUES (49, 7, 5, NULL, 4, 'COAT-STR-S', 1782300500, 1782300500);
INSERT INTO `product_option` VALUES (50, 7, 6, NULL, 5, 'COAT-STR-M', 1782300500, 1782300500);
INSERT INTO `product_option` VALUES (51, 7, 7, NULL, 3, 'COAT-STR-L', 1782300500, 1782300500);
INSERT INTO `product_option` VALUES (52, 7, 8, NULL, 2, 'COAT-STR-XL', 1782300500, 1782300500);
INSERT INTO `product_option` VALUES (53, 7, 10, NULL, 0, 'COAT-STR-LNN', 1782300500, 1782300500);
INSERT INTO `product_option` VALUES (54, 8, 1, 1800000.00, 8, 'JACK-AVA-BLK', 1782300600, 1782300600);
INSERT INTO `product_option` VALUES (55, 8, 2, 1850000.00, 6, 'JACK-AVA-WHT', 1782300600, 1782300600);
INSERT INTO `product_option` VALUES (56, 8, 3, 1780000.00, 5, 'JACK-AVA-GRY', 1782300600, 1782300600);
INSERT INTO `product_option` VALUES (57, 8, 5, NULL, 5, 'JACK-AVA-S', 1782300600, 1782300600);
INSERT INTO `product_option` VALUES (58, 8, 6, NULL, 7, 'JACK-AVA-M', 1782300600, 1782300600);
INSERT INTO `product_option` VALUES (59, 8, 7, NULL, 4, 'JACK-AVA-L', 1782300600, 1782300600);
INSERT INTO `product_option` VALUES (60, 8, 11, NULL, 0, 'JACK-AVA-PLY', 1782300600, 1782300600);
INSERT INTO `product_option` VALUES (61, 9, 1, 3200000.00, 4, 'PALTO-LLA-BLK', 1782300700, 1782300700);
INSERT INTO `product_option` VALUES (62, 9, 3, 3100000.00, 3, 'PALTO-LLA-GRY', 1782300700, 1782300700);
INSERT INTO `product_option` VALUES (63, 9, 4, 3150000.00, 3, 'PALTO-LLA-BEG', 1782300700, 1782300700);
INSERT INTO `product_option` VALUES (64, 9, 5, NULL, 3, 'PALTO-LLA-S', 1782300700, 1782300700);
INSERT INTO `product_option` VALUES (65, 9, 6, NULL, 4, 'PALTO-LLA-M', 1782300700, 1782300700);
INSERT INTO `product_option` VALUES (66, 9, 7, NULL, 3, 'PALTO-LLA-L', 1782300700, 1782300700);
INSERT INTO `product_option` VALUES (67, 9, 10, NULL, 0, 'PALTO-LLA-LNN', 1782300700, 1782300700);
INSERT INTO `product_option` VALUES (68, 10, 1, 2600000.00, 5, 'TRNCH-RHA-BLK', 1782300800, 1782300800);
INSERT INTO `product_option` VALUES (69, 10, 4, 2550000.00, 4, 'TRNCH-RHA-BEG', 1782300800, 1782300800);
INSERT INTO `product_option` VALUES (70, 10, 5, NULL, 4, 'TRNCH-RHA-S', 1782300800, 1782300800);
INSERT INTO `product_option` VALUES (71, 10, 6, NULL, 5, 'TRNCH-RHA-M', 1782300800, 1782300800);
INSERT INTO `product_option` VALUES (72, 10, 7, NULL, 3, 'TRNCH-RHA-L', 1782300800, 1782300800);
INSERT INTO `product_option` VALUES (73, 10, 10, NULL, 0, 'TRNCH-RHA-LNN', 1782300800, 1782300800);
INSERT INTO `product_option` VALUES (74, 11, 1, 980000.00, 12, 'HOOD-MHS-BLK', 1782300900, 1782300900);
INSERT INTO `product_option` VALUES (75, 11, 2, 990000.00, 10, 'HOOD-MHS-WHT', 1782300900, 1782300900);
INSERT INTO `product_option` VALUES (76, 11, 3, 970000.00, 8, 'HOOD-MHS-GRY', 1782300900, 1782300900);
INSERT INTO `product_option` VALUES (77, 11, 5, NULL, 6, 'HOOD-MHS-S', 1782300900, 1782300900);
INSERT INTO `product_option` VALUES (78, 11, 6, NULL, 8, 'HOOD-MHS-M', 1782300900, 1782300900);
INSERT INTO `product_option` VALUES (79, 11, 7, NULL, 5, 'HOOD-MHS-L', 1782300900, 1782300900);
INSERT INTO `product_option` VALUES (80, 11, 8, NULL, 3, 'HOOD-MHS-XL', 1782300900, 1782300900);
INSERT INTO `product_option` VALUES (81, 11, 11, NULL, 0, 'HOOD-MHS-PLY', 1782300900, 1782300900);
INSERT INTO `product_option` VALUES (82, 12, 1, 1050000.00, 10, 'SWTR-NZN-BLK', 1782301000, 1782301000);
INSERT INTO `product_option` VALUES (83, 12, 2, 1070000.00, 8, 'SWTR-NZN-WHT', 1782301000, 1782301000);
INSERT INTO `product_option` VALUES (84, 12, 4, 1040000.00, 6, 'SWTR-NZN-BEG', 1782301000, 1782301000);
INSERT INTO `product_option` VALUES (85, 12, 5, NULL, 5, 'SWTR-NZN-S', 1782301000, 1782301000);
INSERT INTO `product_option` VALUES (86, 12, 6, NULL, 7, 'SWTR-NZN-M', 1782301000, 1782301000);
INSERT INTO `product_option` VALUES (87, 12, 7, NULL, 4, 'SWTR-NZN-L', 1782301000, 1782301000);
INSERT INTO `product_option` VALUES (88, 12, 9, NULL, 0, 'SWTR-NZN-CTTN', 1782301000, 1782301000);
INSERT INTO `product_option` VALUES (89, 13, 1, 650000.00, 15, 'VEST-SHV-BLK', 1782301100, 1782301100);
INSERT INTO `product_option` VALUES (90, 13, 3, 630000.00, 12, 'VEST-SHV-GRY', 1782301100, 1782301100);
INSERT INTO `product_option` VALUES (91, 13, 5, NULL, 6, 'VEST-SHV-S', 1782301100, 1782301100);
INSERT INTO `product_option` VALUES (92, 13, 6, NULL, 8, 'VEST-SHV-M', 1782301100, 1782301100);
INSERT INTO `product_option` VALUES (93, 13, 7, NULL, 5, 'VEST-SHV-L', 1782301100, 1782301100);
INSERT INTO `product_option` VALUES (94, 13, 11, NULL, 0, 'VEST-SHV-PLY', 1782301100, 1782301100);
INSERT INTO `product_option` VALUES (95, 14, 1, 920000.00, 10, 'TRSR-MLK-BLK', 1782301200, 1782301200);
INSERT INTO `product_option` VALUES (96, 14, 3, 890000.00, 8, 'TRSR-MLK-GRY', 1782301200, 1782301200);
INSERT INTO `product_option` VALUES (97, 14, 4, 880000.00, 6, 'TRSR-MLK-BEG', 1782301200, 1782301200);
INSERT INTO `product_option` VALUES (98, 14, 5, NULL, 5, 'TRSR-MLK-S', 1782301200, 1782301200);
INSERT INTO `product_option` VALUES (99, 14, 6, NULL, 7, 'TRSR-MLK-M', 1782301200, 1782301200);
INSERT INTO `product_option` VALUES (100, 14, 7, NULL, 4, 'TRSR-MLK-L', 1782301200, 1782301200);
INSERT INTO `product_option` VALUES (101, 14, 8, NULL, 3, 'TRSR-MLK-XL', 1782301200, 1782301200);
INSERT INTO `product_option` VALUES (102, 14, 10, NULL, 0, 'TRSR-MLK-LNN', 1782301200, 1782301200);
INSERT INTO `product_option` VALUES (103, 15, 1, 780000.00, 12, 'FBRC-YAS-BLK', 1782301300, 1782301300);
INSERT INTO `product_option` VALUES (104, 15, 4, 760000.00, 10, 'FBRC-YAS-BEG', 1782301300, 1782301300);
INSERT INTO `product_option` VALUES (105, 15, 5, NULL, 6, 'FBRC-YAS-S', 1782301300, 1782301300);
INSERT INTO `product_option` VALUES (106, 15, 6, NULL, 8, 'FBRC-YAS-M', 1782301300, 1782301300);
INSERT INTO `product_option` VALUES (107, 15, 7, NULL, 5, 'FBRC-YAS-L', 1782301300, 1782301300);
INSERT INTO `product_option` VALUES (108, 15, 10, NULL, 0, 'FBRC-YAS-LNN', 1782301300, 1782301300);
INSERT INTO `product_option` VALUES (109, 16, 1, 450000.00, 20, 'LEG-RSH-BLK', 1782301400, 1782301400);
INSERT INTO `product_option` VALUES (110, 16, 3, 440000.00, 15, 'LEG-RSH-GRY', 1782301400, 1782301400);
INSERT INTO `product_option` VALUES (111, 16, 5, NULL, 8, 'LEG-RSH-S', 1782301400, 1782301400);
INSERT INTO `product_option` VALUES (112, 16, 6, NULL, 10, 'LEG-RSH-M', 1782301400, 1782301400);
INSERT INTO `product_option` VALUES (113, 16, 7, NULL, 6, 'LEG-RSH-L', 1782301400, 1782301400);
INSERT INTO `product_option` VALUES (114, 16, 11, NULL, 0, 'LEG-RSH-PLY', 1782301400, 1782301400);
INSERT INTO `product_option` VALUES (115, 17, 1, 1350000.00, 8, 'KNIT-KMY-BLK', 1782301500, 1782301500);
INSERT INTO `product_option` VALUES (116, 17, 3, 1300000.00, 6, 'KNIT-KMY-GRY', 1782301500, 1782301500);
INSERT INTO `product_option` VALUES (117, 17, 4, 1280000.00, 5, 'KNIT-KMY-BEG', 1782301500, 1782301500);
INSERT INTO `product_option` VALUES (118, 17, 5, NULL, 5, 'KNIT-KMY-S', 1782301500, 1782301500);
INSERT INTO `product_option` VALUES (119, 17, 6, NULL, 6, 'KNIT-KMY-M', 1782301500, 1782301500);
INSERT INTO `product_option` VALUES (120, 17, 7, NULL, 4, 'KNIT-KMY-L', 1782301500, 1782301500);
INSERT INTO `product_option` VALUES (121, 17, 8, NULL, 3, 'KNIT-KMY-XL', 1782301500, 1782301500);
INSERT INTO `product_option` VALUES (122, 17, 9, NULL, 0, 'KNIT-KMY-CTTN', 1782301500, 1782301500);
INSERT INTO `product_option` VALUES (123, 18, 1, 1150000.00, 10, 'SWTR-SNA-BLK', 1782301600, 1782301600);
INSERT INTO `product_option` VALUES (124, 18, 2, 1170000.00, 8, 'SWTR-SNA-WHT', 1782301600, 1782301600);
INSERT INTO `product_option` VALUES (125, 18, 3, 1140000.00, 6, 'SWTR-SNA-GRY', 1782301600, 1782301600);
INSERT INTO `product_option` VALUES (126, 18, 5, NULL, 5, 'SWTR-SNA-S', 1782301600, 1782301600);
INSERT INTO `product_option` VALUES (127, 18, 6, NULL, 7, 'SWTR-SNA-M', 1782301600, 1782301600);
INSERT INTO `product_option` VALUES (128, 18, 7, NULL, 4, 'SWTR-SNA-L', 1782301600, 1782301600);
INSERT INTO `product_option` VALUES (129, 18, 8, NULL, 3, 'SWTR-SNA-XL', 1782301600, 1782301600);
INSERT INTO `product_option` VALUES (130, 18, 9, NULL, 0, 'SWTR-SNA-CTTN', 1782301600, 1782301600);
INSERT INTO `product_option` VALUES (131, 19, 1, 2100000.00, 6, 'JACK-ARH-BLK', 1782301700, 1782301700);
INSERT INTO `product_option` VALUES (132, 19, 3, 2050000.00, 5, 'JACK-ARH-GRY', 1782301700, 1782301700);
INSERT INTO `product_option` VALUES (133, 19, 5, NULL, 4, 'JACK-ARH-S', 1782301700, 1782301700);
INSERT INTO `product_option` VALUES (134, 19, 6, NULL, 5, 'JACK-ARH-M', 1782301700, 1782301700);
INSERT INTO `product_option` VALUES (135, 19, 7, NULL, 3, 'JACK-ARH-L', 1782301700, 1782301700);
INSERT INTO `product_option` VALUES (136, 19, 8, NULL, 2, 'JACK-ARH-XL', 1782301700, 1782301700);
INSERT INTO `product_option` VALUES (137, 19, 11, NULL, 0, 'JACK-ARH-PLY', 1782301700, 1782301700);
INSERT INTO `product_option` VALUES (138, 20, 1, 980000.00, 12, 'SHRT-BHD-BLK', 1782301800, 1782301800);
INSERT INTO `product_option` VALUES (139, 20, 2, 990000.00, 10, 'SHRT-BHD-WHT', 1782301800, 1782301800);
INSERT INTO `product_option` VALUES (140, 20, 4, 970000.00, 8, 'SHRT-BHD-BEG', 1782301800, 1782301800);
INSERT INTO `product_option` VALUES (141, 20, 5, NULL, 5, 'SHRT-BHD-S', 1782301800, 1782301800);
INSERT INTO `product_option` VALUES (142, 20, 6, NULL, 8, 'SHRT-BHD-M', 1782301800, 1782301800);
INSERT INTO `product_option` VALUES (143, 20, 7, NULL, 5, 'SHRT-BHD-L', 1782301800, 1782301800);
INSERT INTO `product_option` VALUES (144, 20, 8, NULL, 3, 'SHRT-BHD-XL', 1782301800, 1782301800);
INSERT INTO `product_option` VALUES (145, 20, 10, NULL, 0, 'SHRT-BHD-LNN', 1782301800, 1782301800);
INSERT INTO `product_option` VALUES (146, 21, 1, 1200000.00, 10, 'HOOD-DRY-BLK', 1782301900, 1782301900);
INSERT INTO `product_option` VALUES (147, 21, 3, 1180000.00, 8, 'HOOD-DRY-GRY', 1782301900, 1782301900);
INSERT INTO `product_option` VALUES (148, 21, 5, NULL, 5, 'HOOD-DRY-S', 1782301900, 1782301900);
INSERT INTO `product_option` VALUES (149, 21, 6, NULL, 7, 'HOOD-DRY-M', 1782301900, 1782301900);
INSERT INTO `product_option` VALUES (150, 21, 7, NULL, 4, 'HOOD-DRY-L', 1782301900, 1782301900);
INSERT INTO `product_option` VALUES (151, 21, 8, NULL, 3, 'HOOD-DRY-XL', 1782301900, 1782301900);
INSERT INTO `product_option` VALUES (152, 21, 11, NULL, 0, 'HOOD-DRY-PLY', 1782301900, 1782301900);
INSERT INTO `product_option` VALUES (153, 22, 1, 1100000.00, 10, 'JEAN-PRS-BLK', 1782302000, 1782302000);
INSERT INTO `product_option` VALUES (154, 22, 3, 1080000.00, 8, 'JEAN-PRS-GRY', 1782302000, 1782302000);
INSERT INTO `product_option` VALUES (155, 22, 5, NULL, 5, 'JEAN-PRS-S', 1782302000, 1782302000);
INSERT INTO `product_option` VALUES (156, 22, 6, NULL, 8, 'JEAN-PRS-M', 1782302000, 1782302000);
INSERT INTO `product_option` VALUES (157, 22, 7, NULL, 5, 'JEAN-PRS-L', 1782302000, 1782302000);
INSERT INTO `product_option` VALUES (158, 22, 8, NULL, 3, 'JEAN-PRS-XL', 1782302000, 1782302000);
INSERT INTO `product_option` VALUES (159, 22, 11, NULL, 0, 'JEAN-PRS-PLY', 1782302000, 1782302000);
INSERT INTO `product_option` VALUES (160, 23, 1, 1050000.00, 8, 'FBRC-RZA-BLK', 1782302100, 1782302100);
INSERT INTO `product_option` VALUES (161, 23, 4, 1020000.00, 6, 'FBRC-RZA-BEG', 1782302100, 1782302100);
INSERT INTO `product_option` VALUES (162, 23, 5, NULL, 4, 'FBRC-RZA-S', 1782302100, 1782302100);
INSERT INTO `product_option` VALUES (163, 23, 6, NULL, 6, 'FBRC-RZA-M', 1782302100, 1782302100);
INSERT INTO `product_option` VALUES (164, 23, 7, NULL, 4, 'FBRC-RZA-L', 1782302100, 1782302100);
INSERT INTO `product_option` VALUES (165, 23, 8, NULL, 2, 'FBRC-RZA-XL', 1782302100, 1782302100);
INSERT INTO `product_option` VALUES (166, 23, 10, NULL, 0, 'FBRC-RZA-LNN', 1782302100, 1782302100);
INSERT INTO `product_option` VALUES (167, 24, 1, 680000.00, 15, 'JGR-NVD-BLK', 1782302200, 1782302200);
INSERT INTO `product_option` VALUES (168, 24, 3, 660000.00, 12, 'JGR-NVD-GRY', 1782302200, 1782302200);
INSERT INTO `product_option` VALUES (169, 24, 5, NULL, 6, 'JGR-NVD-S', 1782302200, 1782302200);
INSERT INTO `product_option` VALUES (170, 24, 6, NULL, 8, 'JGR-NVD-M', 1782302200, 1782302200);
INSERT INTO `product_option` VALUES (171, 24, 7, NULL, 5, 'JGR-NVD-L', 1782302200, 1782302200);
INSERT INTO `product_option` VALUES (172, 24, 8, NULL, 4, 'JGR-NVD-XL', 1782302200, 1782302200);
INSERT INTO `product_option` VALUES (173, 24, 11, NULL, 0, 'JGR-NVD-PLY', 1782302200, 1782302200);
INSERT INTO `product_option` VALUES (174, 25, 1, 520000.00, 20, 'SHRT-SED-BLK', 1782302300, 1782302300);
INSERT INTO `product_option` VALUES (175, 25, 3, 510000.00, 15, 'SHRT-SED-GRY', 1782302300, 1782302300);
INSERT INTO `product_option` VALUES (176, 25, 4, 500000.00, 10, 'SHRT-SED-BEG', 1782302300, 1782302300);
INSERT INTO `product_option` VALUES (177, 25, 5, NULL, 8, 'SHRT-SED-S', 1782302300, 1782302300);
INSERT INTO `product_option` VALUES (178, 25, 6, NULL, 10, 'SHRT-SED-M', 1782302300, 1782302300);
INSERT INTO `product_option` VALUES (179, 25, 7, NULL, 6, 'SHRT-SED-L', 1782302300, 1782302300);
INSERT INTO `product_option` VALUES (180, 25, 10, NULL, 0, 'SHRT-SED-LNN', 1782302300, 1782302300);
INSERT INTO `product_option` VALUES (181, 26, 1, 380000.00, 25, 'TSHRT-AMR-BLK', 1782302400, 1782302400);
INSERT INTO `product_option` VALUES (182, 26, 2, 380000.00, 20, 'TSHRT-AMR-WHT', 1782302400, 1782302400);
INSERT INTO `product_option` VALUES (183, 26, 3, 370000.00, 18, 'TSHRT-AMR-GRY', 1782302400, 1782302400);
INSERT INTO `product_option` VALUES (184, 26, 4, 360000.00, 15, 'TSHRT-AMR-BEG', 1782302400, 1782302400);
INSERT INTO `product_option` VALUES (185, 26, 5, NULL, 10, 'TSHRT-AMR-S', 1782302400, 1782302400);
INSERT INTO `product_option` VALUES (186, 26, 6, NULL, 12, 'TSHRT-AMR-M', 1782302400, 1782302400);
INSERT INTO `product_option` VALUES (187, 26, 7, NULL, 8, 'TSHRT-AMR-L', 1782302400, 1782302400);
INSERT INTO `product_option` VALUES (188, 26, 8, NULL, 5, 'TSHRT-AMR-XL', 1782302400, 1782302400);
INSERT INTO `product_option` VALUES (189, 26, 9, NULL, 0, 'TSHRT-AMR-CTTN', 1782302400, 1782302400);
INSERT INTO `product_option` VALUES (190, 27, 1, 1500000.00, 8, 'SET-ALI-BLK', 1782302500, 1782302500);
INSERT INTO `product_option` VALUES (191, 27, 3, 1480000.00, 6, 'SET-ALI-GRY', 1782302500, 1782302500);
INSERT INTO `product_option` VALUES (192, 27, 5, NULL, 4, 'SET-ALI-S', 1782302500, 1782302500);
INSERT INTO `product_option` VALUES (193, 27, 6, NULL, 6, 'SET-ALI-M', 1782302500, 1782302500);
INSERT INTO `product_option` VALUES (194, 27, 7, NULL, 4, 'SET-ALI-L', 1782302500, 1782302500);
INSERT INTO `product_option` VALUES (195, 27, 8, NULL, 3, 'SET-ALI-XL', 1782302500, 1782302500);
INSERT INTO `product_option` VALUES (196, 27, 11, NULL, 0, 'SET-ALI-PLY', 1782302500, 1782302500);
INSERT INTO `product_option` VALUES (197, 28, 1, 720000.00, 12, 'LS-HSN-BLK', 1782302600, 1782302600);
INSERT INTO `product_option` VALUES (198, 28, 2, 730000.00, 10, 'LS-HSN-WHT', 1782302600, 1782302600);
INSERT INTO `product_option` VALUES (199, 28, 3, 710000.00, 8, 'LS-HSN-GRY', 1782302600, 1782302600);
INSERT INTO `product_option` VALUES (200, 28, 5, NULL, 5, 'LS-HSN-S', 1782302600, 1782302600);
INSERT INTO `product_option` VALUES (201, 28, 6, NULL, 7, 'LS-HSN-M', 1782302600, 1782302600);
INSERT INTO `product_option` VALUES (202, 28, 7, NULL, 4, 'LS-HSN-L', 1782302600, 1782302600);
INSERT INTO `product_option` VALUES (203, 28, 8, NULL, 3, 'LS-HSN-XL', 1782302600, 1782302600);
INSERT INTO `product_option` VALUES (204, 28, 9, NULL, 0, 'LS-HSN-CTTN', 1782302600, 1782302600);
INSERT INTO `product_option` VALUES (205, 29, 1, 280000.00, 20, 'HAT-MJD-BLK', 1782302700, 1782302700);
INSERT INTO `product_option` VALUES (206, 29, 2, 280000.00, 15, 'HAT-MJD-WHT', 1782302700, 1782302700);
INSERT INTO `product_option` VALUES (207, 29, 3, 270000.00, 15, 'HAT-MJD-GRY', 1782302700, 1782302700);
INSERT INTO `product_option` VALUES (208, 29, 9, NULL, 0, 'HAT-MJD-CTTN', 1782302700, 1782302700);
INSERT INTO `product_option` VALUES (209, 30, 1, 180000.00, 30, 'SOCK-KRM-BLK', 1782302800, 1782302800);
INSERT INTO `product_option` VALUES (210, 30, 2, 180000.00, 25, 'SOCK-KRM-WHT', 1782302800, 1782302800);
INSERT INTO `product_option` VALUES (211, 30, 3, 175000.00, 20, 'SOCK-KRM-GRY', 1782302800, 1782302800);
INSERT INTO `product_option` VALUES (212, 30, 9, NULL, 0, 'SOCK-KRM-CTTN', 1782302800, 1782302800);
INSERT INTO `product_option` VALUES (213, 31, 1, 450000.00, 15, 'BELT-FRH-BLK', 1782302900, 1782302900);
INSERT INTO `product_option` VALUES (214, 31, 3, 440000.00, 12, 'BELT-FRH-BRN', 1782302900, 1782302900);
INSERT INTO `product_option` VALUES (215, 31, 10, NULL, 0, 'BELT-FRH-LNN', 1782302900, 1782302900);

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','manager','viewer') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'viewer',
  `last_login` int NULL DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, 'admin', '123456', 'محمد ایران نژاد', 'admin', 1782692405, 'assets/images/user/profile-img-2.jpg', 1, 0, 1782692405);

SET FOREIGN_KEY_CHECKS = 1;
