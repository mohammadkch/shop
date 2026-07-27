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

 Date: 27/07/2026 03:32:38
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
) ENGINE = InnoDB AUTO_INCREMENT = 140 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cart
-- ----------------------------
INSERT INTO `cart` VALUES (134, NULL, '98dcd49f784b3fcf176fccf0cc0e1a29', 1784859037, 1784859037);
INSERT INTO `cart` VALUES (135, NULL, 'dd872623766526b3e5eb49f012bfe808', 1784980669, 1784980669);
INSERT INTO `cart` VALUES (136, NULL, 'd297094b8dcdb24f1a77a3cc0ff81f7e', 1784993661, 1784993661);
INSERT INTO `cart` VALUES (137, NULL, '10353b60de107f103270ede7ea6c567c', 1785012572, 1785012572);
INSERT INTO `cart` VALUES (138, NULL, '5883a15df5bb250d2d06e7e1d4e781a1', 1785103721, 1785103721);
INSERT INTO `cart` VALUES (139, NULL, 'd24d03516532f6d788d410c04e20d1f5', 1785107343, 1785107343);

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
  `sale_price` decimal(15, 2) NULL DEFAULT NULL,
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
) ENGINE = InnoDB AUTO_INCREMENT = 176 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cart_item
-- ----------------------------
INSERT INTO `cart_item` VALUES (174, 134, 1, 1, 560000.00, 370000.00, 1784859046, 1784859046, 2, 6);
INSERT INTO `cart_item` VALUES (175, 138, 31, 1, 150000.00, 150000.00, 1785108661, 1785108661, 1, 5);

-- ----------------------------
-- Table structure for city
-- ----------------------------
DROP TABLE IF EXISTS `city`;
CREATE TABLE `city`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `state_id` int UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int NOT NULL DEFAULT 0,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_state_id`(`state_id` ASC) USING BTREE,
  CONSTRAINT `fk_city_state` FOREIGN KEY (`state_id`) REFERENCES `state` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 483 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of city
-- ----------------------------
INSERT INTO `city` VALUES (1, 1, 'اراک', 0, 0, 0);
INSERT INTO `city` VALUES (2, 1, 'آشتیان', 0, 0, 0);
INSERT INTO `city` VALUES (3, 1, 'تفرش', 0, 0, 0);
INSERT INTO `city` VALUES (4, 1, 'خمین', 0, 0, 0);
INSERT INTO `city` VALUES (5, 1, 'دلیجان', 0, 0, 0);
INSERT INTO `city` VALUES (6, 1, 'ساوه', 0, 0, 0);
INSERT INTO `city` VALUES (7, 1, 'شازند', 0, 0, 0);
INSERT INTO `city` VALUES (8, 1, 'محلات', 0, 0, 0);
INSERT INTO `city` VALUES (9, 2, 'آستارا', 0, 0, 0);
INSERT INTO `city` VALUES (10, 2, 'آستانه اشرفیه', 0, 0, 0);
INSERT INTO `city` VALUES (11, 2, 'بندرانزلی', 0, 0, 0);
INSERT INTO `city` VALUES (12, 2, 'طوالش', 0, 0, 0);
INSERT INTO `city` VALUES (13, 2, 'رشت', 0, 0, 0);
INSERT INTO `city` VALUES (14, 2, 'رودبار', 0, 0, 0);
INSERT INTO `city` VALUES (15, 2, 'رودسر', 0, 0, 0);
INSERT INTO `city` VALUES (16, 2, 'صومعه سرا', 0, 0, 0);
INSERT INTO `city` VALUES (17, 2, 'فومن', 0, 0, 0);
INSERT INTO `city` VALUES (18, 3, 'آمل', 0, 0, 0);
INSERT INTO `city` VALUES (19, 3, 'بابل', 0, 0, 0);
INSERT INTO `city` VALUES (20, 3, 'بهشهر', 0, 0, 0);
INSERT INTO `city` VALUES (21, 3, 'تنکابن', 0, 0, 0);
INSERT INTO `city` VALUES (22, 3, 'رامسر', 0, 0, 0);
INSERT INTO `city` VALUES (23, 3, 'ساری', 0, 0, 0);
INSERT INTO `city` VALUES (24, 3, 'سوادکوه', 0, 0, 0);
INSERT INTO `city` VALUES (25, 4, 'اهر', 0, 0, 0);
INSERT INTO `city` VALUES (26, 4, 'تبریز', 0, 0, 0);
INSERT INTO `city` VALUES (27, 4, 'سراب', 0, 0, 0);
INSERT INTO `city` VALUES (28, 4, 'مراغه', 0, 0, 0);
INSERT INTO `city` VALUES (29, 4, 'مرند', 0, 0, 0);
INSERT INTO `city` VALUES (30, 5, 'ارومیه', 0, 0, 0);
INSERT INTO `city` VALUES (31, 5, 'پیرانشهر', 0, 0, 0);
INSERT INTO `city` VALUES (32, 5, 'خوی', 0, 0, 0);
INSERT INTO `city` VALUES (33, 5, 'سردشت', 0, 0, 0);
INSERT INTO `city` VALUES (34, 5, 'سلماس', 0, 0, 0);
INSERT INTO `city` VALUES (35, 5, 'ماکو', 0, 0, 0);
INSERT INTO `city` VALUES (36, 5, 'مهاباد', 0, 0, 0);
INSERT INTO `city` VALUES (37, 5, 'میاندوآب', 0, 0, 0);
INSERT INTO `city` VALUES (38, 5, 'نقده', 0, 0, 0);
INSERT INTO `city` VALUES (39, 6, 'اسلام آبادغرب', 0, 0, 0);
INSERT INTO `city` VALUES (40, 6, 'کرمانشاه', 0, 0, 0);
INSERT INTO `city` VALUES (41, 6, 'پاوه', 0, 0, 0);
INSERT INTO `city` VALUES (42, 6, 'سرپل ذهاب', 0, 0, 0);
INSERT INTO `city` VALUES (43, 6, 'سنقر', 0, 0, 0);
INSERT INTO `city` VALUES (44, 6, 'قصرشیرین', 0, 0, 0);
INSERT INTO `city` VALUES (45, 6, 'کنگاور', 0, 0, 0);
INSERT INTO `city` VALUES (46, 6, 'گیلانغرب', 0, 0, 0);
INSERT INTO `city` VALUES (47, 6, 'جوانرود', 0, 0, 0);
INSERT INTO `city` VALUES (48, 7, 'آبادان', 0, 0, 0);
INSERT INTO `city` VALUES (49, 7, 'اندیمشک', 0, 0, 0);
INSERT INTO `city` VALUES (50, 7, 'اهواز', 0, 0, 0);
INSERT INTO `city` VALUES (51, 7, 'ایذه', 0, 0, 0);
INSERT INTO `city` VALUES (52, 7, 'بندرماهشهر', 0, 0, 0);
INSERT INTO `city` VALUES (53, 7, 'بهبهان', 0, 0, 0);
INSERT INTO `city` VALUES (54, 7, 'خرمشهر', 0, 0, 0);
INSERT INTO `city` VALUES (55, 7, 'دزفول', 0, 0, 0);
INSERT INTO `city` VALUES (56, 7, 'دشت آزادگان', 0, 0, 0);
INSERT INTO `city` VALUES (57, 8, 'آباده', 0, 0, 0);
INSERT INTO `city` VALUES (58, 8, 'استهبان', 0, 0, 0);
INSERT INTO `city` VALUES (59, 8, 'اقلید', 0, 0, 0);
INSERT INTO `city` VALUES (60, 8, 'جهرم', 0, 0, 0);
INSERT INTO `city` VALUES (61, 8, 'داراب', 0, 0, 0);
INSERT INTO `city` VALUES (62, 8, 'سپیدان', 0, 0, 0);
INSERT INTO `city` VALUES (63, 8, 'شیراز', 0, 0, 0);
INSERT INTO `city` VALUES (64, 8, 'فسا', 0, 0, 0);
INSERT INTO `city` VALUES (65, 8, 'فیروزآباد', 0, 0, 0);
INSERT INTO `city` VALUES (66, 9, 'بافت', 0, 0, 0);
INSERT INTO `city` VALUES (67, 9, 'بم', 0, 0, 0);
INSERT INTO `city` VALUES (68, 9, 'جیرفت', 0, 0, 0);
INSERT INTO `city` VALUES (69, 9, 'رفسنجان', 0, 0, 0);
INSERT INTO `city` VALUES (70, 9, 'زرند', 0, 0, 0);
INSERT INTO `city` VALUES (71, 9, 'سیرجان', 0, 0, 0);
INSERT INTO `city` VALUES (72, 9, 'شهربابک', 0, 0, 0);
INSERT INTO `city` VALUES (73, 9, 'کرمان', 0, 0, 0);
INSERT INTO `city` VALUES (74, 9, 'کهنوج', 0, 0, 0);
INSERT INTO `city` VALUES (75, 10, 'تایباد', 0, 0, 0);
INSERT INTO `city` VALUES (76, 10, 'تربت حیدریه', 0, 0, 0);
INSERT INTO `city` VALUES (77, 10, 'تربت جام', 0, 0, 0);
INSERT INTO `city` VALUES (78, 10, 'درگز', 0, 0, 0);
INSERT INTO `city` VALUES (79, 10, 'سبزوار', 0, 0, 0);
INSERT INTO `city` VALUES (80, 11, 'اردستان', 0, 0, 0);
INSERT INTO `city` VALUES (81, 11, 'اصفهان', 0, 0, 0);
INSERT INTO `city` VALUES (82, 11, 'خمینی شهر', 0, 0, 0);
INSERT INTO `city` VALUES (83, 11, 'خوانسار', 0, 0, 0);
INSERT INTO `city` VALUES (84, 11, 'سمیرم', 0, 0, 0);
INSERT INTO `city` VALUES (85, 11, 'فریدن', 0, 0, 0);
INSERT INTO `city` VALUES (86, 11, 'فریدونشهر', 0, 0, 0);
INSERT INTO `city` VALUES (87, 11, 'فلاورجان', 0, 0, 0);
INSERT INTO `city` VALUES (88, 11, 'شهرضا', 0, 0, 0);
INSERT INTO `city` VALUES (89, 12, 'ایرانشهر', 0, 0, 0);
INSERT INTO `city` VALUES (90, 12, 'چاه بهار', 0, 0, 0);
INSERT INTO `city` VALUES (91, 12, 'خاش', 0, 0, 0);
INSERT INTO `city` VALUES (92, 12, 'زابل', 0, 0, 0);
INSERT INTO `city` VALUES (93, 12, 'زاهدان', 0, 0, 0);
INSERT INTO `city` VALUES (94, 12, 'سراوان', 0, 0, 0);
INSERT INTO `city` VALUES (95, 12, 'نیک شهر', 0, 0, 0);
INSERT INTO `city` VALUES (96, 12, 'راسک', 0, 0, 0);
INSERT INTO `city` VALUES (97, 12, 'کنارک', 0, 0, 0);
INSERT INTO `city` VALUES (98, 13, 'بانه', 0, 0, 0);
INSERT INTO `city` VALUES (99, 13, 'بیجار', 0, 0, 0);
INSERT INTO `city` VALUES (100, 13, 'سقز', 0, 0, 0);
INSERT INTO `city` VALUES (101, 13, 'سنندج', 0, 0, 0);
INSERT INTO `city` VALUES (102, 13, 'قروه', 0, 0, 0);
INSERT INTO `city` VALUES (103, 13, 'مریوان', 0, 0, 0);
INSERT INTO `city` VALUES (104, 13, 'دیواندره', 0, 0, 0);
INSERT INTO `city` VALUES (105, 13, 'کامیاران', 0, 0, 0);
INSERT INTO `city` VALUES (106, 13, 'سروآباد', 0, 0, 0);
INSERT INTO `city` VALUES (107, 14, 'تویسرکان', 0, 0, 0);
INSERT INTO `city` VALUES (108, 14, 'ملایر', 0, 0, 0);
INSERT INTO `city` VALUES (109, 14, 'نهاوند', 0, 0, 0);
INSERT INTO `city` VALUES (110, 14, 'همدان', 0, 0, 0);
INSERT INTO `city` VALUES (111, 14, 'کبودرآهنگ', 0, 0, 0);
INSERT INTO `city` VALUES (112, 14, 'اسدآباد', 0, 0, 0);
INSERT INTO `city` VALUES (113, 14, 'بهار', 0, 0, 0);
INSERT INTO `city` VALUES (114, 14, 'رزن', 0, 0, 0);
INSERT INTO `city` VALUES (115, 14, 'فامنین', 0, 0, 0);
INSERT INTO `city` VALUES (116, 15, 'بروجن', 0, 0, 0);
INSERT INTO `city` VALUES (117, 15, 'شهرکرد', 0, 0, 0);
INSERT INTO `city` VALUES (118, 15, 'فارسان', 0, 0, 0);
INSERT INTO `city` VALUES (119, 15, 'لردگان', 0, 0, 0);
INSERT INTO `city` VALUES (120, 15, 'اردل', 0, 0, 0);
INSERT INTO `city` VALUES (121, 15, 'کوهرنگ', 0, 0, 0);
INSERT INTO `city` VALUES (122, 15, 'کیار', 0, 0, 0);
INSERT INTO `city` VALUES (123, 15, 'سامان', 0, 0, 0);
INSERT INTO `city` VALUES (124, 15, 'بن', 0, 0, 0);
INSERT INTO `city` VALUES (125, 16, 'الیگودرز', 0, 0, 0);
INSERT INTO `city` VALUES (126, 16, 'بروجرد', 0, 0, 0);
INSERT INTO `city` VALUES (127, 16, 'خرم آباد', 0, 0, 0);
INSERT INTO `city` VALUES (128, 16, 'دلفان', 0, 0, 0);
INSERT INTO `city` VALUES (129, 16, 'دورود', 0, 0, 0);
INSERT INTO `city` VALUES (130, 16, 'کوهدشت', 0, 0, 0);
INSERT INTO `city` VALUES (131, 16, 'ازنا', 0, 0, 0);
INSERT INTO `city` VALUES (132, 16, 'پلدختر', 0, 0, 0);
INSERT INTO `city` VALUES (133, 16, 'سلسله', 0, 0, 0);
INSERT INTO `city` VALUES (134, 17, 'ایلام', 0, 0, 0);
INSERT INTO `city` VALUES (135, 17, 'دره شهر', 0, 0, 0);
INSERT INTO `city` VALUES (136, 17, 'دهلران', 0, 0, 0);
INSERT INTO `city` VALUES (137, 17, 'چرداول', 0, 0, 0);
INSERT INTO `city` VALUES (138, 17, 'مهران', 0, 0, 0);
INSERT INTO `city` VALUES (139, 17, 'آبدانان', 0, 0, 0);
INSERT INTO `city` VALUES (140, 17, 'ایوان', 0, 0, 0);
INSERT INTO `city` VALUES (141, 17, 'ملکشاهی', 0, 0, 0);
INSERT INTO `city` VALUES (142, 17, 'سیروان', 0, 0, 0);
INSERT INTO `city` VALUES (143, 18, 'بویراحمد', 0, 0, 0);
INSERT INTO `city` VALUES (144, 18, 'کهگیلویه', 0, 0, 0);
INSERT INTO `city` VALUES (145, 18, 'گچساران', 0, 0, 0);
INSERT INTO `city` VALUES (146, 18, 'دنا', 0, 0, 0);
INSERT INTO `city` VALUES (147, 18, 'بهمیی', 0, 0, 0);
INSERT INTO `city` VALUES (148, 18, 'چرام', 0, 0, 0);
INSERT INTO `city` VALUES (149, 18, 'باشت', 0, 0, 0);
INSERT INTO `city` VALUES (150, 18, 'لنده', 0, 0, 0);
INSERT INTO `city` VALUES (151, 18, 'مارگون', 0, 0, 0);
INSERT INTO `city` VALUES (152, 19, 'بوشهر', 0, 0, 0);
INSERT INTO `city` VALUES (153, 19, 'تنگستان', 0, 0, 0);
INSERT INTO `city` VALUES (154, 19, 'دشتستان', 0, 0, 0);
INSERT INTO `city` VALUES (155, 19, 'دشتی', 0, 0, 0);
INSERT INTO `city` VALUES (156, 19, 'دیر', 0, 0, 0);
INSERT INTO `city` VALUES (157, 19, 'کنگان', 0, 0, 0);
INSERT INTO `city` VALUES (158, 19, 'گناوه', 0, 0, 0);
INSERT INTO `city` VALUES (159, 19, 'دیلم', 0, 0, 0);
INSERT INTO `city` VALUES (160, 19, 'جم', 0, 0, 0);
INSERT INTO `city` VALUES (161, 20, 'ابهر', 0, 0, 0);
INSERT INTO `city` VALUES (162, 20, 'خدابنده', 0, 0, 0);
INSERT INTO `city` VALUES (163, 20, 'زنجان', 0, 0, 0);
INSERT INTO `city` VALUES (164, 20, 'ایجرود', 0, 0, 0);
INSERT INTO `city` VALUES (165, 20, 'خرمدره', 0, 0, 0);
INSERT INTO `city` VALUES (166, 20, 'طارم', 0, 0, 0);
INSERT INTO `city` VALUES (167, 20, 'ماهنشان', 0, 0, 0);
INSERT INTO `city` VALUES (168, 21, 'دامغان', 0, 0, 0);
INSERT INTO `city` VALUES (169, 21, 'سمنان', 0, 0, 0);
INSERT INTO `city` VALUES (170, 21, 'شاهرود', 0, 0, 0);
INSERT INTO `city` VALUES (171, 21, 'گرمسار', 0, 0, 0);
INSERT INTO `city` VALUES (172, 21, 'مهدی شهر', 0, 0, 0);
INSERT INTO `city` VALUES (173, 21, 'آرادان', 0, 0, 0);
INSERT INTO `city` VALUES (174, 21, 'میامی', 0, 0, 0);
INSERT INTO `city` VALUES (175, 21, 'سرخه', 0, 0, 0);
INSERT INTO `city` VALUES (176, 22, 'اردکان', 0, 0, 0);
INSERT INTO `city` VALUES (177, 22, 'بافق', 0, 0, 0);
INSERT INTO `city` VALUES (178, 22, 'تفت', 0, 0, 0);
INSERT INTO `city` VALUES (179, 22, 'مهریز', 0, 0, 0);
INSERT INTO `city` VALUES (180, 22, 'یزد', 0, 0, 0);
INSERT INTO `city` VALUES (181, 22, 'میبد', 0, 0, 0);
INSERT INTO `city` VALUES (182, 22, 'ابرکوه', 0, 0, 0);
INSERT INTO `city` VALUES (183, 22, 'اشکذر', 0, 0, 0);
INSERT INTO `city` VALUES (184, 22, 'خاتم', 0, 0, 0);
INSERT INTO `city` VALUES (185, 23, 'ابوموسی', 0, 0, 0);
INSERT INTO `city` VALUES (186, 23, 'بندر عباس', 0, 0, 0);
INSERT INTO `city` VALUES (187, 23, 'بندر لنگه', 0, 0, 0);
INSERT INTO `city` VALUES (188, 23, 'قشم', 0, 0, 0);
INSERT INTO `city` VALUES (189, 23, 'میناب', 0, 0, 0);
INSERT INTO `city` VALUES (190, 23, 'جاسک', 0, 0, 0);
INSERT INTO `city` VALUES (191, 23, 'رودان', 0, 0, 0);
INSERT INTO `city` VALUES (192, 23, 'حاجی آباد', 0, 0, 0);
INSERT INTO `city` VALUES (193, 23, 'بستک', 0, 0, 0);
INSERT INTO `city` VALUES (194, 24, 'تهران', 0, 0, 0);
INSERT INTO `city` VALUES (195, 24, 'دماوند', 0, 0, 0);
INSERT INTO `city` VALUES (196, 24, 'ری', 0, 0, 0);
INSERT INTO `city` VALUES (197, 24, 'شمیرانات', 0, 0, 0);
INSERT INTO `city` VALUES (198, 24, 'ورامین', 0, 0, 0);
INSERT INTO `city` VALUES (199, 24, 'شهریار', 0, 0, 0);
INSERT INTO `city` VALUES (200, 25, 'اردبیل', 0, 0, 0);
INSERT INTO `city` VALUES (201, 25, 'بیله سوار', 0, 0, 0);
INSERT INTO `city` VALUES (202, 25, 'خلخال', 0, 0, 0);
INSERT INTO `city` VALUES (203, 25, 'مشگین شهر', 0, 0, 0);
INSERT INTO `city` VALUES (204, 25, 'گرمی', 0, 0, 0);
INSERT INTO `city` VALUES (205, 25, 'پارس آباد', 0, 0, 0);
INSERT INTO `city` VALUES (206, 25, 'کوثر', 0, 0, 0);
INSERT INTO `city` VALUES (207, 25, 'نمین', 0, 0, 0);
INSERT INTO `city` VALUES (208, 25, 'نیر', 0, 0, 0);
INSERT INTO `city` VALUES (209, 26, 'قم', 0, 0, 0);
INSERT INTO `city` VALUES (210, 26, 'جعفرآباد', 0, 0, 0);
INSERT INTO `city` VALUES (211, 26, 'کهک', 0, 0, 0);
INSERT INTO `city` VALUES (212, 27, 'بویین زهرا', 0, 0, 0);
INSERT INTO `city` VALUES (213, 27, 'تاکستان', 0, 0, 0);
INSERT INTO `city` VALUES (214, 27, 'قزوین', 0, 0, 0);
INSERT INTO `city` VALUES (215, 27, 'آبیک', 0, 0, 0);
INSERT INTO `city` VALUES (216, 27, 'البرز', 0, 0, 0);
INSERT INTO `city` VALUES (217, 27, 'آوج', 0, 0, 0);
INSERT INTO `city` VALUES (218, 28, 'بندرگز', 0, 0, 0);
INSERT INTO `city` VALUES (219, 28, 'ترکمن', 0, 0, 0);
INSERT INTO `city` VALUES (220, 28, 'علی آباد کتول', 0, 0, 0);
INSERT INTO `city` VALUES (221, 28, 'کردکوی', 0, 0, 0);
INSERT INTO `city` VALUES (222, 28, 'گرگان', 0, 0, 0);
INSERT INTO `city` VALUES (223, 28, 'گنبدکاووس', 0, 0, 0);
INSERT INTO `city` VALUES (224, 28, 'مینودشت', 0, 0, 0);
INSERT INTO `city` VALUES (225, 28, 'آق قلا', 0, 0, 0);
INSERT INTO `city` VALUES (226, 28, 'کلاله', 0, 0, 0);
INSERT INTO `city` VALUES (227, 29, 'اسفراین', 0, 0, 0);
INSERT INTO `city` VALUES (228, 29, 'بجنورد', 0, 0, 0);
INSERT INTO `city` VALUES (229, 29, 'جاجرم', 0, 0, 0);
INSERT INTO `city` VALUES (230, 29, 'شیروان', 0, 0, 0);
INSERT INTO `city` VALUES (231, 29, 'فاروج', 0, 0, 0);
INSERT INTO `city` VALUES (232, 29, 'سملقان', 0, 0, 0);
INSERT INTO `city` VALUES (233, 29, 'گرمه', 0, 0, 0);
INSERT INTO `city` VALUES (234, 29, 'راز و جرگلان', 0, 0, 0);
INSERT INTO `city` VALUES (235, 29, 'بام و صفی آباد', 0, 0, 0);
INSERT INTO `city` VALUES (236, 30, 'بیرجند', 0, 0, 0);
INSERT INTO `city` VALUES (237, 30, 'درمیان', 0, 0, 0);
INSERT INTO `city` VALUES (238, 30, 'سربیشه', 0, 0, 0);
INSERT INTO `city` VALUES (239, 30, 'قاینات', 0, 0, 0);
INSERT INTO `city` VALUES (240, 30, 'نهبندان', 0, 0, 0);
INSERT INTO `city` VALUES (241, 30, 'سرایان', 0, 0, 0);
INSERT INTO `city` VALUES (242, 30, 'فردوس', 0, 0, 0);
INSERT INTO `city` VALUES (243, 30, 'بشرویه', 0, 0, 0);
INSERT INTO `city` VALUES (244, 30, 'زیرکوه', 0, 0, 0);
INSERT INTO `city` VALUES (245, 31, 'کرج', 0, 0, 0);
INSERT INTO `city` VALUES (246, 31, 'ساوجبلاغ', 0, 0, 0);
INSERT INTO `city` VALUES (247, 31, 'نظرآباد', 0, 0, 0);
INSERT INTO `city` VALUES (248, 31, 'طالقان', 0, 0, 0);
INSERT INTO `city` VALUES (249, 31, 'اشتهارد', 0, 0, 0);
INSERT INTO `city` VALUES (250, 31, 'فردیس', 0, 0, 0);
INSERT INTO `city` VALUES (251, 31, 'چهارباغ', 0, 0, 0);
INSERT INTO `city` VALUES (252, 1, 'زرندیه', 0, 0, 0);
INSERT INTO `city` VALUES (253, 1, 'کمیجان', 0, 0, 0);
INSERT INTO `city` VALUES (254, 1, 'خنداب', 0, 0, 0);
INSERT INTO `city` VALUES (255, 1, 'فراهان', 0, 0, 0);
INSERT INTO `city` VALUES (256, 2, 'لنگرود', 0, 0, 0);
INSERT INTO `city` VALUES (257, 2, 'لاهیجان', 0, 0, 0);
INSERT INTO `city` VALUES (258, 2, 'شفت', 0, 0, 0);
INSERT INTO `city` VALUES (259, 2, 'املش', 0, 0, 0);
INSERT INTO `city` VALUES (260, 2, 'رضوانشهر', 0, 0, 0);
INSERT INTO `city` VALUES (261, 2, 'سیاهکل', 0, 0, 0);
INSERT INTO `city` VALUES (262, 2, 'ماسال', 0, 0, 0);
INSERT INTO `city` VALUES (263, 2, 'خمام', 0, 0, 0);
INSERT INTO `city` VALUES (264, 3, 'قایم شهر', 0, 0, 0);
INSERT INTO `city` VALUES (265, 3, 'نور', 0, 0, 0);
INSERT INTO `city` VALUES (266, 3, 'نوشهر', 0, 0, 0);
INSERT INTO `city` VALUES (267, 3, 'بابلسر', 0, 0, 0);
INSERT INTO `city` VALUES (268, 3, 'محمودآباد', 0, 0, 0);
INSERT INTO `city` VALUES (269, 3, 'نکا', 0, 0, 0);
INSERT INTO `city` VALUES (270, 3, 'چالوس', 0, 0, 0);
INSERT INTO `city` VALUES (271, 3, 'جویبار', 0, 0, 0);
INSERT INTO `city` VALUES (272, 3, 'گلوگاه', 0, 0, 0);
INSERT INTO `city` VALUES (273, 3, 'فریدونکنار', 0, 0, 0);
INSERT INTO `city` VALUES (274, 3, 'عباس آباد', 0, 0, 0);
INSERT INTO `city` VALUES (275, 3, 'میاندورود', 0, 0, 0);
INSERT INTO `city` VALUES (276, 3, 'سیمرغ', 0, 0, 0);
INSERT INTO `city` VALUES (277, 3, 'سوادکوه شمالی', 0, 0, 0);
INSERT INTO `city` VALUES (278, 3, 'کلاردشت', 0, 0, 0);
INSERT INTO `city` VALUES (279, 4, 'میانه', 0, 0, 0);
INSERT INTO `city` VALUES (280, 4, 'هشترود', 0, 0, 0);
INSERT INTO `city` VALUES (281, 4, 'بناب', 0, 0, 0);
INSERT INTO `city` VALUES (282, 4, 'بستان آباد', 0, 0, 0);
INSERT INTO `city` VALUES (283, 4, 'شبستر', 0, 0, 0);
INSERT INTO `city` VALUES (284, 4, 'کلیبر', 0, 0, 0);
INSERT INTO `city` VALUES (285, 4, 'هریس', 0, 0, 0);
INSERT INTO `city` VALUES (286, 4, 'جلفا', 0, 0, 0);
INSERT INTO `city` VALUES (287, 4, 'ملکان', 0, 0, 0);
INSERT INTO `city` VALUES (288, 4, 'آذرشهر', 0, 0, 0);
INSERT INTO `city` VALUES (289, 4, 'اسکو', 0, 0, 0);
INSERT INTO `city` VALUES (290, 4, 'چاراویماق', 0, 0, 0);
INSERT INTO `city` VALUES (291, 4, 'ورزقان', 0, 0, 0);
INSERT INTO `city` VALUES (292, 4, 'عجب شیر', 0, 0, 0);
INSERT INTO `city` VALUES (293, 4, 'خداآفرین', 0, 0, 0);
INSERT INTO `city` VALUES (294, 4, 'هوراند', 0, 0, 0);
INSERT INTO `city` VALUES (295, 4, 'لیلان', 0, 0, 0);
INSERT INTO `city` VALUES (296, 5, 'بوکان', 0, 0, 0);
INSERT INTO `city` VALUES (297, 5, 'شاهین دژ', 0, 0, 0);
INSERT INTO `city` VALUES (298, 5, 'تکاب', 0, 0, 0);
INSERT INTO `city` VALUES (299, 5, 'اشنویه', 0, 0, 0);
INSERT INTO `city` VALUES (300, 5, 'چالدران', 0, 0, 0);
INSERT INTO `city` VALUES (301, 5, 'پلدشت', 0, 0, 0);
INSERT INTO `city` VALUES (302, 5, 'چایپاره', 0, 0, 0);
INSERT INTO `city` VALUES (303, 5, 'شوط', 0, 0, 0);
INSERT INTO `city` VALUES (304, 5, 'چهاربرج', 0, 0, 0);
INSERT INTO `city` VALUES (305, 5, 'باروق', 0, 0, 0);
INSERT INTO `city` VALUES (306, 5, 'میرآباد', 0, 0, 0);
INSERT INTO `city` VALUES (307, 6, 'صحنه', 0, 0, 0);
INSERT INTO `city` VALUES (308, 6, 'هرسین', 0, 0, 0);
INSERT INTO `city` VALUES (309, 6, 'ثلاث باباجانی', 0, 0, 0);
INSERT INTO `city` VALUES (310, 6, 'دالاهو', 0, 0, 0);
INSERT INTO `city` VALUES (311, 6, 'روانسر', 0, 0, 0);
INSERT INTO `city` VALUES (312, 7, 'رامهرمز', 0, 0, 0);
INSERT INTO `city` VALUES (313, 7, 'شادگان', 0, 0, 0);
INSERT INTO `city` VALUES (314, 7, 'شوشتر', 0, 0, 0);
INSERT INTO `city` VALUES (315, 7, 'مسجدسلیمان', 0, 0, 0);
INSERT INTO `city` VALUES (316, 7, 'شوش', 0, 0, 0);
INSERT INTO `city` VALUES (317, 7, 'باغ ملک', 0, 0, 0);
INSERT INTO `city` VALUES (318, 7, 'امیدیه', 0, 0, 0);
INSERT INTO `city` VALUES (319, 7, 'لالی', 0, 0, 0);
INSERT INTO `city` VALUES (320, 7, 'هندیجان', 0, 0, 0);
INSERT INTO `city` VALUES (321, 7, 'رامشیر', 0, 0, 0);
INSERT INTO `city` VALUES (322, 7, 'گتوند', 0, 0, 0);
INSERT INTO `city` VALUES (323, 7, 'اندیکا', 0, 0, 0);
INSERT INTO `city` VALUES (324, 7, 'هفتکل', 0, 0, 0);
INSERT INTO `city` VALUES (325, 7, 'هویزه', 0, 0, 0);
INSERT INTO `city` VALUES (326, 7, 'باوی', 0, 0, 0);
INSERT INTO `city` VALUES (327, 7, 'حمیدیه', 0, 0, 0);
INSERT INTO `city` VALUES (328, 7, 'آغاجاری', 0, 0, 0);
INSERT INTO `city` VALUES (329, 7, 'کارون', 0, 0, 0);
INSERT INTO `city` VALUES (330, 7, 'کرخه', 0, 0, 0);
INSERT INTO `city` VALUES (331, 7, 'دزپارت', 0, 0, 0);
INSERT INTO `city` VALUES (332, 7, 'صیدون', 0, 0, 0);
INSERT INTO `city` VALUES (333, 8, 'کازرون', 0, 0, 0);
INSERT INTO `city` VALUES (334, 8, 'لارستان', 0, 0, 0);
INSERT INTO `city` VALUES (335, 8, 'مرودشت', 0, 0, 0);
INSERT INTO `city` VALUES (336, 8, 'ممسنی', 0, 0, 0);
INSERT INTO `city` VALUES (337, 8, 'نی ریز', 0, 0, 0);
INSERT INTO `city` VALUES (338, 8, 'لامرد', 0, 0, 0);
INSERT INTO `city` VALUES (339, 8, 'بوانات', 0, 0, 0);
INSERT INTO `city` VALUES (340, 8, 'ارسنجان', 0, 0, 0);
INSERT INTO `city` VALUES (341, 8, 'خرم بید', 0, 0, 0);
INSERT INTO `city` VALUES (342, 8, 'زرین دشت', 0, 0, 0);
INSERT INTO `city` VALUES (343, 8, 'قیروکارزین', 0, 0, 0);
INSERT INTO `city` VALUES (344, 8, 'مهر', 0, 0, 0);
INSERT INTO `city` VALUES (345, 8, 'فراشبند', 0, 0, 0);
INSERT INTO `city` VALUES (346, 8, 'پاسارگاد', 0, 0, 0);
INSERT INTO `city` VALUES (347, 8, 'خنج', 0, 0, 0);
INSERT INTO `city` VALUES (348, 8, 'سروستان', 0, 0, 0);
INSERT INTO `city` VALUES (349, 8, 'رستم', 0, 0, 0);
INSERT INTO `city` VALUES (350, 8, 'گراش', 0, 0, 0);
INSERT INTO `city` VALUES (351, 8, 'کوار', 0, 0, 0);
INSERT INTO `city` VALUES (352, 8, 'خرامه', 0, 0, 0);
INSERT INTO `city` VALUES (353, 8, 'زرقان', 0, 0, 0);
INSERT INTO `city` VALUES (354, 8, 'بیضا', 0, 0, 0);
INSERT INTO `city` VALUES (355, 8, 'سرچهان', 0, 0, 0);
INSERT INTO `city` VALUES (356, 8, 'کوه چنار', 0, 0, 0);
INSERT INTO `city` VALUES (357, 8, 'خفر', 0, 0, 0);
INSERT INTO `city` VALUES (358, 8, 'بختگان', 0, 0, 0);
INSERT INTO `city` VALUES (359, 8, 'اوز', 0, 0, 0);
INSERT INTO `city` VALUES (360, 8, 'جویم', 0, 0, 0);
INSERT INTO `city` VALUES (361, 9, 'بردسیر', 0, 0, 0);
INSERT INTO `city` VALUES (362, 9, 'راور', 0, 0, 0);
INSERT INTO `city` VALUES (363, 9, 'عنبرآباد', 0, 0, 0);
INSERT INTO `city` VALUES (364, 9, 'منوجان', 0, 0, 0);
INSERT INTO `city` VALUES (365, 9, 'کوهبنان', 0, 0, 0);
INSERT INTO `city` VALUES (366, 9, 'رودبارجنوب', 0, 0, 0);
INSERT INTO `city` VALUES (367, 9, 'قلعه گنج', 0, 0, 0);
INSERT INTO `city` VALUES (368, 9, 'ریگان', 0, 0, 0);
INSERT INTO `city` VALUES (369, 9, 'رابر', 0, 0, 0);
INSERT INTO `city` VALUES (370, 9, 'فهرج', 0, 0, 0);
INSERT INTO `city` VALUES (371, 9, 'انار', 0, 0, 0);
INSERT INTO `city` VALUES (372, 9, 'نرماشیر', 0, 0, 0);
INSERT INTO `city` VALUES (373, 9, 'فاریاب', 0, 0, 0);
INSERT INTO `city` VALUES (374, 9, 'ارزوییه', 0, 0, 0);
INSERT INTO `city` VALUES (375, 9, 'گنبکی', 0, 0, 0);
INSERT INTO `city` VALUES (376, 9, 'جازموریان', 0, 0, 0);
INSERT INTO `city` VALUES (377, 10, 'قوچان', 0, 0, 0);
INSERT INTO `city` VALUES (378, 10, 'کاشمر', 0, 0, 0);
INSERT INTO `city` VALUES (379, 10, 'گناباد', 0, 0, 0);
INSERT INTO `city` VALUES (380, 10, 'مشهد', 0, 0, 0);
INSERT INTO `city` VALUES (381, 10, 'نیشابور', 0, 0, 0);
INSERT INTO `city` VALUES (382, 10, 'چناران', 0, 0, 0);
INSERT INTO `city` VALUES (383, 10, 'خواف', 0, 0, 0);
INSERT INTO `city` VALUES (384, 10, 'سرخس', 0, 0, 0);
INSERT INTO `city` VALUES (385, 10, 'فریمان', 0, 0, 0);
INSERT INTO `city` VALUES (386, 10, 'بردسکن', 0, 0, 0);
INSERT INTO `city` VALUES (387, 10, 'رشتخوار', 0, 0, 0);
INSERT INTO `city` VALUES (388, 10, 'کلات', 0, 0, 0);
INSERT INTO `city` VALUES (389, 10, 'خلیل آباد', 0, 0, 0);
INSERT INTO `city` VALUES (390, 10, 'مه ولات', 0, 0, 0);
INSERT INTO `city` VALUES (391, 10, 'بجستان', 0, 0, 0);
INSERT INTO `city` VALUES (392, 10, 'طرقبه شاندیز', 0, 0, 0);
INSERT INTO `city` VALUES (393, 10, 'فیروزه', 0, 0, 0);
INSERT INTO `city` VALUES (394, 10, 'جغتای', 0, 0, 0);
INSERT INTO `city` VALUES (395, 10, 'زاوه', 0, 0, 0);
INSERT INTO `city` VALUES (396, 10, 'جوین', 0, 0, 0);
INSERT INTO `city` VALUES (397, 10, 'باخرز', 0, 0, 0);
INSERT INTO `city` VALUES (398, 10, 'خوشاب', 0, 0, 0);
INSERT INTO `city` VALUES (399, 10, 'داورزن', 0, 0, 0);
INSERT INTO `city` VALUES (400, 10, 'صالح آباد', 0, 0, 0);
INSERT INTO `city` VALUES (401, 10, 'کوهسرخ', 0, 0, 0);
INSERT INTO `city` VALUES (402, 10, 'زبرخان', 0, 0, 0);
INSERT INTO `city` VALUES (403, 10, 'ششتمد', 0, 0, 0);
INSERT INTO `city` VALUES (404, 10, 'گلبهار', 0, 0, 0);
INSERT INTO `city` VALUES (405, 10, 'میان جلگه', 0, 0, 0);
INSERT INTO `city` VALUES (406, 11, 'کاشان', 0, 0, 0);
INSERT INTO `city` VALUES (407, 11, 'گلپایگان', 0, 0, 0);
INSERT INTO `city` VALUES (408, 11, 'لنجان', 0, 0, 0);
INSERT INTO `city` VALUES (409, 11, 'نایین', 0, 0, 0);
INSERT INTO `city` VALUES (410, 11, 'نجف آباد', 0, 0, 0);
INSERT INTO `city` VALUES (411, 11, 'نطنز', 0, 0, 0);
INSERT INTO `city` VALUES (412, 11, 'شاهین شهرو میمه', 0, 0, 0);
INSERT INTO `city` VALUES (413, 11, 'مبارکه', 0, 0, 0);
INSERT INTO `city` VALUES (414, 11, 'آران و بیدگل', 0, 0, 0);
INSERT INTO `city` VALUES (415, 11, 'تیران وکرون', 0, 0, 0);
INSERT INTO `city` VALUES (416, 11, 'چادگان', 0, 0, 0);
INSERT INTO `city` VALUES (417, 11, 'دهاقان', 0, 0, 0);
INSERT INTO `city` VALUES (418, 11, 'برخوار', 0, 0, 0);
INSERT INTO `city` VALUES (419, 11, 'خور و بیابانک', 0, 0, 0);
INSERT INTO `city` VALUES (420, 11, 'بویین و میاندشت', 0, 0, 0);
INSERT INTO `city` VALUES (421, 11, 'کوهپایه', 0, 0, 0);
INSERT INTO `city` VALUES (422, 11, 'جرقویه', 0, 0, 0);
INSERT INTO `city` VALUES (423, 11, 'ورزنه', 0, 0, 0);
INSERT INTO `city` VALUES (424, 11, 'هرند', 0, 0, 0);
INSERT INTO `city` VALUES (425, 12, 'زهک', 0, 0, 0);
INSERT INTO `city` VALUES (426, 12, 'هیرمند', 0, 0, 0);
INSERT INTO `city` VALUES (427, 12, 'دلگان', 0, 0, 0);
INSERT INTO `city` VALUES (428, 12, 'مهرستان', 0, 0, 0);
INSERT INTO `city` VALUES (429, 12, 'سیب و سوران', 0, 0, 0);
INSERT INTO `city` VALUES (430, 12, 'نیمروز', 0, 0, 0);
INSERT INTO `city` VALUES (431, 12, 'هامون', 0, 0, 0);
INSERT INTO `city` VALUES (432, 12, 'میرجاوه', 0, 0, 0);
INSERT INTO `city` VALUES (433, 12, 'قصرقند', 0, 0, 0);
INSERT INTO `city` VALUES (434, 12, 'فنوج', 0, 0, 0);
INSERT INTO `city` VALUES (435, 12, 'بمپور', 0, 0, 0);
INSERT INTO `city` VALUES (436, 12, 'تفتان', 0, 0, 0);
INSERT INTO `city` VALUES (437, 12, 'دشتیاری', 0, 0, 0);
INSERT INTO `city` VALUES (438, 12, 'سرباز', 0, 0, 0);
INSERT INTO `city` VALUES (439, 12, 'گلشن', 0, 0, 0);
INSERT INTO `city` VALUES (440, 12, 'لاشار', 0, 0, 0);
INSERT INTO `city` VALUES (441, 12, 'زرآباد', 0, 0, 0);
INSERT INTO `city` VALUES (442, 13, 'دهگلان', 0, 0, 0);
INSERT INTO `city` VALUES (443, 14, 'درگزین', 0, 0, 0);
INSERT INTO `city` VALUES (444, 15, 'خانمیرزا', 0, 0, 0);
INSERT INTO `city` VALUES (445, 15, 'فلارد', 0, 0, 0);
INSERT INTO `city` VALUES (446, 15, 'فرخ شهر', 0, 0, 0);
INSERT INTO `city` VALUES (447, 16, 'چگنی', 0, 0, 0);
INSERT INTO `city` VALUES (448, 16, 'رومشکان', 0, 0, 0);
INSERT INTO `city` VALUES (449, 16, 'معمولان', 0, 0, 0);
INSERT INTO `city` VALUES (450, 17, 'بدره', 0, 0, 0);
INSERT INTO `city` VALUES (451, 17, 'هلیلان', 0, 0, 0);
INSERT INTO `city` VALUES (452, 17, 'چوار', 0, 0, 0);
INSERT INTO `city` VALUES (453, 19, 'عسلویه', 0, 0, 0);
INSERT INTO `city` VALUES (454, 20, 'سلطانیه', 0, 0, 0);
INSERT INTO `city` VALUES (455, 22, 'بهاباد', 0, 0, 0);
INSERT INTO `city` VALUES (456, 22, 'مروست', 0, 0, 0);
INSERT INTO `city` VALUES (457, 22, 'زارچ', 0, 0, 0);
INSERT INTO `city` VALUES (458, 23, 'خمیر', 0, 0, 0);
INSERT INTO `city` VALUES (459, 23, 'پارسیان', 0, 0, 0);
INSERT INTO `city` VALUES (460, 23, 'سیریک', 0, 0, 0);
INSERT INTO `city` VALUES (461, 23, 'بشاگرد', 0, 0, 0);
INSERT INTO `city` VALUES (462, 24, 'اسلامشهر', 0, 0, 0);
INSERT INTO `city` VALUES (463, 24, 'رباط کریم', 0, 0, 0);
INSERT INTO `city` VALUES (464, 24, 'پاکدشت', 0, 0, 0);
INSERT INTO `city` VALUES (465, 24, 'فیروزکوه', 0, 0, 0);
INSERT INTO `city` VALUES (466, 24, 'قدس', 0, 0, 0);
INSERT INTO `city` VALUES (467, 24, 'ملارد', 0, 0, 0);
INSERT INTO `city` VALUES (468, 24, 'پیشوا', 0, 0, 0);
INSERT INTO `city` VALUES (469, 24, 'بهارستان', 0, 0, 0);
INSERT INTO `city` VALUES (470, 24, 'پردیس', 0, 0, 0);
INSERT INTO `city` VALUES (471, 24, 'قرچک', 0, 0, 0);
INSERT INTO `city` VALUES (472, 25, 'سرعین', 0, 0, 0);
INSERT INTO `city` VALUES (473, 25, 'اصلاندوز', 0, 0, 0);
INSERT INTO `city` VALUES (474, 25, 'انگوت', 0, 0, 0);
INSERT INTO `city` VALUES (475, 28, 'آزادشهر', 0, 0, 0);
INSERT INTO `city` VALUES (476, 28, 'رامیان', 0, 0, 0);
INSERT INTO `city` VALUES (477, 28, 'مراوه تپه', 0, 0, 0);
INSERT INTO `city` VALUES (478, 28, 'گمیشان', 0, 0, 0);
INSERT INTO `city` VALUES (479, 28, 'گالیکش', 0, 0, 0);
INSERT INTO `city` VALUES (480, 29, 'مانه', 0, 0, 0);
INSERT INTO `city` VALUES (481, 30, 'خوسف', 0, 0, 0);
INSERT INTO `city` VALUES (482, 30, 'طبس', 0, 0, 0);

-- ----------------------------
-- Table structure for customer
-- ----------------------------
DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `mobile` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `national_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `gender` tinyint(1) NULL DEFAULT NULL COMMENT '1=زن, 2=مرد',
  `birthdate` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_login` int NULL DEFAULT NULL,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `unique_mobile`(`mobile` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of customer
-- ----------------------------
INSERT INTO `customer` VALUES (2, '09129731668', 'محمد', 'کوچنانی', 'mammadkouchenani@gmail.com', '0016642856', 1, '1372/11/16', 'A123456a!!', 'customer_2_1783546166.webp', 1, 1785108919, 1783306941, 1785108919);
INSERT INTO `customer` VALUES (5, '09129731669', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1784859062, 1784314575, 1784859062);

-- ----------------------------
-- Table structure for customer_address
-- ----------------------------
DROP TABLE IF EXISTS `customer_address`;
CREATE TABLE `customer_address`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` int UNSIGNED NOT NULL,
  `city_id` int UNSIGNED NOT NULL,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'عنوان: خانه، محل کار، ...',
  `recipient_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `recipient_mobile` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_customer_id`(`customer_id` ASC) USING BTREE,
  INDEX `idx_city_id`(`city_id` ASC) USING BTREE,
  CONSTRAINT `fk_customer_address_city` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_customer_address_customer` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of customer_address
-- ----------------------------

-- ----------------------------
-- Table structure for customer_otp
-- ----------------------------
DROP TABLE IF EXISTS `customer_otp`;
CREATE TABLE `customer_otp`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `mobile` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp_code` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_at` int NOT NULL,
  `is_used` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_mobile`(`mobile` ASC) USING BTREE,
  INDEX `idx_expires`(`expires_at` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 81 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of customer_otp
-- ----------------------------
INSERT INTO `customer_otp` VALUES (80, '09129731668', '88257', 1785109024, 1, 0);

-- ----------------------------
-- Table structure for factor
-- ----------------------------
DROP TABLE IF EXISTS `factor`;
CREATE TABLE `factor`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` int UNSIGNED NOT NULL,
  `cart_id` int UNSIGNED NOT NULL,
  `address_id` int UNSIGNED NULL DEFAULT NULL,
  `shipping_type_id` int UNSIGNED NULL DEFAULT NULL,
  `shipping_price` decimal(15, 2) NULL DEFAULT NULL,
  `subtotal` decimal(15, 2) NOT NULL,
  `total` decimal(15, 2) NOT NULL,
  `status` enum('awaiting_payment','paid','expired','cancelled') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'awaiting_payment',
  `expires_at` int NOT NULL,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_customer_id`(`customer_id` ASC) USING BTREE,
  INDEX `idx_cart_id`(`cart_id` ASC) USING BTREE,
  INDEX `idx_address_id`(`address_id` ASC) USING BTREE,
  INDEX `idx_shipping_type_id`(`shipping_type_id` ASC) USING BTREE,
  INDEX `idx_expires_at`(`expires_at` ASC) USING BTREE,
  INDEX `idx_status`(`status` ASC) USING BTREE,
  CONSTRAINT `fk_factor_address` FOREIGN KEY (`address_id`) REFERENCES `customer_address` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_factor_cart` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_factor_customer` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_factor_shipping_type` FOREIGN KEY (`shipping_type_id`) REFERENCES `shipping_type` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 32 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of factor
-- ----------------------------

-- ----------------------------
-- Table structure for factor_item
-- ----------------------------
DROP TABLE IF EXISTS `factor_item`;
CREATE TABLE `factor_item`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `factor_id` int UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL,
  `cart_item_id` int UNSIGNED NOT NULL,
  `color_option_id` int UNSIGNED NULL DEFAULT NULL,
  `size_option_id` int UNSIGNED NULL DEFAULT NULL,
  `quantity` int NOT NULL,
  `price` decimal(15, 2) NOT NULL,
  `sale_price` decimal(15, 2) NULL DEFAULT NULL,
  `total` decimal(15, 2) NOT NULL,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_factor_id`(`factor_id` ASC) USING BTREE,
  INDEX `idx_cart_item_id`(`cart_item_id` ASC) USING BTREE,
  CONSTRAINT `fk_factor_item_factor` FOREIGN KEY (`factor_id`) REFERENCES `factor` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 92 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of factor_item
-- ----------------------------

-- ----------------------------
-- Table structure for home_selected_category
-- ----------------------------
DROP TABLE IF EXISTS `home_selected_category`;
CREATE TABLE `home_selected_category`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `menu_1_id` int NULL DEFAULT NULL,
  `menu_2_id` int NULL DEFAULT NULL,
  `menu_3_id` int NULL DEFAULT NULL,
  `sort_order` int NULL DEFAULT 0,
  `is_active` tinyint(1) NULL DEFAULT 1,
  `created_at` int NULL DEFAULT NULL,
  `updated_at` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of home_selected_category
-- ----------------------------
INSERT INTO `home_selected_category` VALUES (2, 2, NULL, NULL, 2, 1, 1782665317, 1782665317);
INSERT INTO `home_selected_category` VALUES (4, 1, NULL, NULL, 1, 1, 1782665317, 1782665317);
INSERT INTO `home_selected_category` VALUES (5, NULL, 2, NULL, 2, 1, 1782665317, 1782665317);
INSERT INTO `home_selected_category` VALUES (6, NULL, NULL, 3, 3, 1, 1782665317, 1782665317);
INSERT INTO `home_selected_category` VALUES (7, NULL, 33, NULL, 0, 1, 1782913480, 1782913480);
INSERT INTO `home_selected_category` VALUES (8, NULL, 15, NULL, 0, 1, 1783029079, 1783029079);

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
INSERT INTO `home_slider` VALUES (1, 'اسلایدر ۱', 'home/sliders/slider-1.webp', 'category/women', 1, 1, 1782665289, 1783029046);
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
INSERT INTO `home_story` VALUES (1, 'image', 'استوری 1', 'home/story/1.jpg', 'home/story/1.jpg', 5000, 'http://127.0.0.1/shop/public/category/women', 1, 1, 1782660903, 1783029000);
INSERT INTO `home_story` VALUES (2, 'image', 'استوری 2', 'home/story/2.jpg', 'home/story/2.jpg', 5000, 'https://www.rtl-theme.com/author/amir_rezaii/products/', 2, 1, 1782660903, 1782660903);
INSERT INTO `home_story` VALUES (3, 'image', 'استوری 3', 'home/story/3.jpg', 'home/story/3.jpg', 5000, 'https://www.rtl-theme.com/author/amir_rezaii/products/', 3, 1, 1782660903, 1782660903);
INSERT INTO `home_story` VALUES (4, 'image', 'استوری 4', 'home/story/5.jpg', 'home/story/5.jpg', 5000, 'https://www.rtl-theme.com/author/amir_rezaii/products/', 4, 1, 1782660903, 1782660903);
INSERT INTO `home_story` VALUES (5, 'image', 'استوری 5', 'home/story/6.jpg', 'home/story/6.jpg', 5000, 'https://www.rtl-theme.com/author/amir_rezaii/products/', 5, 1, 1782660903, 1782660903);
INSERT INTO `home_story` VALUES (6, 'image', 'استوری 6', 'home/story/7.jpg', 'home/story/7.jpg', 5000, 'https://www.rtl-theme.com/author/amir_rezaii/products/', 6, 1, 1782660903, 1782660903);
INSERT INTO `home_story` VALUES (7, 'image', 'استوری 7', 'home/story/8.jpg', 'home/story/8.jpg', 5000, 'https://www.rtl-theme.com/author/amir_rezaii/products/', 7, 1, 1782660903, 1782660903);
INSERT INTO `home_story` VALUES (8, 'video', 'نمونه فیلم ', 'home/story/8.jpg', 'home/story/video/1.mp4', NULL, 'https://www.rtl-theme.com/author/amir_rezaii/products/', 8, 1, 1782660903, 1782907189);

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
INSERT INTO `menu_1` VALUES (1, 'زنانه', 'women', 1, 'مجموعه‌ای کامل از بهترین و باکیفیت‌ترین لباس‌های مردانه با طراحی‌های مدرن و کلاسیک. در این دسته‌بندی می‌توانید انواع کت، شلوار، پیراهن، لباس مجلسی و اسپرت را با بهترین کیفیت و مناسب‌ترین قیمت تهیه کنید. تمامی محصولات این مجموعه از پارچه‌های درجه یک و با دوخت حرفه‌ای تولید شده‌اند تا راحتی و زیبایی را برای شما به ارمغان بیاورند. ما در انتخاب محصولات خود به جزئیات کوچک مانند نوع یقه، جنس دکمه‌ها، کیفیت زیپ و دوخت نهایی توجه ویژه‌ای داریم تا محصولی بی‌نقص را به شما عزیزان ارائه دهیم. با خرید از این مجموعه، از اصالت کالا و گارانتی کیفیت اطمینان داشته باشید. تنوع رنگ‌ها و سایزهای موجود، امکان انتخاب کامل را برای سلیقه‌های مختلف فراهم کرده است. فروشگاه ما با سال‌ها تجربه در زمینه پوشاک مردانه، همواره به‌روزترین مدل‌های روز دنیا را با قیمت‌های رقابتی در اختیار شما قرار می‌دهد. مشاوره رایگان برای انتخاب سایز و سبک مناسب نیز از خدمات ویژه ما به شما عزیزان است.', 1, 1779657219, 1782697937);
INSERT INTO `menu_1` VALUES (2, 'مردانه', 'men', 1, NULL, 2, 1779657219, 1780524560);
INSERT INTO `menu_1` VALUES (3, 'بچگانه', 'kids', 1, NULL, 3, 1779657219, 1780452496);
INSERT INTO `menu_1` VALUES (4, 'سایر محصولات', 'others', 1, NULL, 4, 1779657219, 1780452714);
INSERT INTO `menu_1` VALUES (5, 'شلوار جین', 'jeans', 1, NULL, 5, 1779657219, 1780531493);
INSERT INTO `menu_1` VALUES (6, 'کیف', 'bag', 1, NULL, 6, 1779657219, 1779657219);
INSERT INTO `menu_1` VALUES (7, 'حراجی', 'sale', 1, NULL, 7, 1779657219, 1779657219);
INSERT INTO `menu_1` VALUES (9, 'حراجی دوم', 'sale-2', 0, NULL, 9, 1779657219, 1780186792);
INSERT INTO `menu_1` VALUES (28, 'منوی جدید', 'newmenu', 1, 'توضیحات اختیاری تست منوی 1', 28, 1780172326, 1782697907);

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
INSERT INTO `menu_1_image_type` VALUES (2, 'menu1_type_2', 300, 300, 'webp', 200, 'images/menus', 1, 0, 0);

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
-- Table structure for payment
-- ----------------------------
DROP TABLE IF EXISTS `payment`;
CREATE TABLE `payment`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `factor_id` int UNSIGNED NOT NULL,
  `customer_id` int UNSIGNED NOT NULL,
  `payment_method_id` int UNSIGNED NOT NULL,
  `final_amount` decimal(15, 2) NOT NULL,
  `status` enum('awaiting_payment','paid','failed','expired') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'awaiting_payment',
  `payment_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `expires_at` int NOT NULL,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_factor_id`(`factor_id` ASC) USING BTREE,
  INDEX `idx_customer_id`(`customer_id` ASC) USING BTREE,
  INDEX `idx_payment_method_id`(`payment_method_id` ASC) USING BTREE,
  INDEX `idx_status`(`status` ASC) USING BTREE,
  INDEX `idx_expires_at`(`expires_at` ASC) USING BTREE,
  CONSTRAINT `fk_payment_customer` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_payment_factor` FOREIGN KEY (`factor_id`) REFERENCES `factor` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `fk_payment_method` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_method` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of payment
-- ----------------------------

-- ----------------------------
-- Table structure for payment_method
-- ----------------------------
DROP TABLE IF EXISTS `payment_method`;
CREATE TABLE `payment_method`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int NOT NULL DEFAULT 0,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of payment_method
-- ----------------------------
INSERT INTO `payment_method` VALUES (1, 'درگاه بانکی', 1, 1, 1783904556, 1783904556);

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
INSERT INTO `product` VALUES (1, 'مانتو مجلسی زنانه مدل الیزابت', 'women-formal-coat-elizabeth', '<p>مانتو مجلسی الیزابت با طراحی خاص و منحصر‌به‌فرد، انتخابی عالی برای مهمانی‌ها و مراسم خاص شماست.</p>\r\n    <ul>\r\n        <li>جنس: پارچه کتان با کیفیت بالا</li>\r\n        <li>آستین: بلند با سرآستین مروارید دوزی شده</li>\r\n        <li>یقه: هفت با تزئینات خاص</li>\r\n        <li>قد: تا زانو</li>\r\n        <li>دارای جیب‌های تزیینی</li>\r\n    </ul>', 1, NULL, 1781736311, 1781736311, 'مانتو مجلسی زنانه الیزابت | خرید بهترین مانتوهای مجلسی', 'خرید مانتو مجلسی زنانه مدل الیزابت با طراحی خاص و کیفیت عالی. مناسب برای مهمانی‌ها و مراسم خاص. قیمت مناسب و ارسال سریع.', 'مانتو مجلسی, لباس مجلسی زنانه, مانتو زنانه, خرید مانتو', 'WOMAN-COAT-001', 850.00);
INSERT INTO `product` VALUES (2, 'بافت زنانه مدل آریا', 'women-knit-sweater-aria', '<p>بافت زنانه آریا با طراحی کلاسیک و جنس پشم ایرانی</p>', 1, NULL, 1782300000, 1782300000, 'بافت زنانه آریا', 'خرید بافت زنانه مدل آریا با کیفیت عالی', 'بافت زنانه, پلیور زنانه', 'WOMAN-KNIT-001', 400.00);
INSERT INTO `product` VALUES (3, 'بلوز شومیز زنانه مدل نگار', 'women-blouse-negar', '<p>بلوز شومیز نگار با یقه ساده و کیفیت پارچه عالی</p>', 1, NULL, 1782300100, 1782300100, 'بلوز شومیز نگار', 'خرید بلوز شومیز زنانه نگار', 'بلوز زنانه, شومیز زنانه', 'WOMAN-BLOUSE-001', 300.00);
INSERT INTO `product` VALUES (4, 'تونیک زنانه مدل دانا', 'women-tunic-dana', '<p>تونیک دانا با طراحی راحت و چاپ گل</p>', 1, NULL, 1782300200, 1782300200, 'تونیک زنانه دانا', 'خرید تونیک زنانه مدل دانا', 'تونیک زنانه, لباس راحتی', 'WOMAN-TUNIC-001', 350.00);
INSERT INTO `product` VALUES (5, 'پیراهن زنانه مدل سونا', 'women-shirt-sona', '<p>پیراهن مجلسی سونا با پارچه ساتن</p>', 1, NULL, 1782300300, 1782300300, 'پیراهن زنانه سونا', 'خرید پیراهن زنانه مدل سونا', 'پیراهن زنانه, لباس مجلسی', 'WOMAN-SHIRT-001', 500.00);
INSERT INTO `product` VALUES (6, 'سرهمی زنانه مدل پانیا', 'women-overall-pania', '<p>سرهمی مدرن پانیا برای استایل روزمره</p>', 1, NULL, 1782300400, 1782300400, 'سرهمی زنانه پانیا', 'خرید سرهمی زنانه مدل پانیا', 'سرهمی زنانه, اورال زنانه', 'WOMAN-OVRL-001', 450.00);
INSERT INTO `product` VALUES (7, 'کت زنانه مدل ستاره', 'women-coat-setareh', '<p>کت رسمی ستاره مناسب محیط کار</p>', 1, NULL, 1782300500, 1782300500, 'کت زنانه ستاره', 'خرید کت زنانه مدل ستاره', 'کت زنانه, کت رسمی', 'WOMAN-COAT-002', 700.00);
INSERT INTO `product` VALUES (8, 'کاپشن زنانه مدل آوا', 'women-raincoat-ava', '<p>کاپشن سبک آوا با پوشش مناسب فصل سرد</p>', 1, NULL, 1782300600, 1782300600, 'کاپشن زنانه آوا', 'خرید کاپشن زنانه مدل آوا', 'کاپشن زنانه, جاکت زنانه', 'WOMAN-JACK-001', 800.00);
INSERT INTO `product` VALUES (9, 'پالتو زنانه مدل لیلا', 'women-overcoat-leila', '<p>پالتو بلند لیلا با کیفیت پارچه گرم</p>', 1, NULL, 1782300700, 1782300700, 'پالتو زنانه لیلا', 'خرید پالتو زنانه مدل لیلا', 'پالتو زنانه, پالتو بلند', 'WOMAN-PALTO-001', 1200.00);
INSERT INTO `product` VALUES (10, 'ترنچ کت زنانه مدل رها', 'women-trench-raha', '<p>ترنچ کت رها با طراحی کلاسیک اروپایی</p>', 1, NULL, 1782300800, 1782300800, 'ترنچ کت زنانه رها', 'خرید ترنچ کت زنانه مدل رها', 'ترنچ کت, بارانی زنانه', 'WOMAN-TRNCH-001', 900.00);
INSERT INTO `product` VALUES (11, 'هودی زنانه مدل مهسا', 'women-hoodie-mahsa', '<p>هودی راحت مهسا برای روزهای خانه</p>', 1, NULL, 1782300900, 1782300900, 'هودی زنانه مهسا', 'خرید هودی زنانه مدل مهسا', 'هودی زنانه, سویشرت زنانه', 'WOMAN-HOOD-001', 550.00);
INSERT INTO `product` VALUES (12, 'پلیور زنانه مدل نازنین', 'women-sweater-naznin', '<p>پلیور بافت نازنین با طرح چهارخانه</p>', 1, NULL, 1782301000, 1782301000, 'پلیور زنانه نازنین', 'خرید پلیور زنانه مدل نازنین', 'پلیور زنانه, دورس زنانه', 'WOMAN-SWTR-001', 480.00);
INSERT INTO `product` VALUES (13, 'وست زنانه مدل شیوا', 'women-waistcoat-shiva', '<p>وست زنانه شیوا برای لایه‌بندی استایل</p>', 1, NULL, 1782301100, 1782301100, 'وست زنانه شیوا', 'خرید وست زنانه مدل شیوا', 'وست زنانه, جلیقه زنانه', 'WOMAN-VEST-001', 320.00);
INSERT INTO `product` VALUES (14, 'شلوار راسته زنانه مدل ملیکا', 'women-trousers-melika', '<p>شلوار راسته کلاسیک ملیکا مناسب اداری</p>', 1, NULL, 1782301200, 1782301200, 'شلوار راسته ملیکا', 'خرید شلوار راسته زنانه مدل ملیکا', 'شلوار زنانه, شلوار رسمی', 'WOMAN-TRSR-001', 600.00);
INSERT INTO `product` VALUES (15, 'شلوار پارچه‌ای زنانه مدل یاس', 'women-fabric-pants-yas', '<p>شلوار پارچه‌ای یاس با کمرکش راحت</p>', 1, NULL, 1782301300, 1782301300, 'شلوار پارچه‌ای یاس', 'خرید شلوار پارچه‌ای زنانه یاس', 'شلوار پارچه‌ای, شلوار زنانه', 'WOMAN-FBRC-001', 550.00);
INSERT INTO `product` VALUES (16, 'لگینگ زنانه مدل روشا', 'women-leggings-rousha', '<p>لگینگ اسپرت روشا برای ورزش و پیاده‌روی</p>', 1, NULL, 1782301400, 1782301400, 'لگینگ زنانه روشا', 'خرید لگینگ زنانه مدل روشا', 'لگینگ زنانه, ساپورت زنانه', 'WOMAN-LEG-001', 280.00);
INSERT INTO `product` VALUES (17, 'بافت مردانه مدل کامیار', 'men-knit-sweater-kamyar', '<p>بافت مردانه کامیار با پارچه پشم ایرانی</p>', 1, NULL, 1782301500, 1782301500, 'بافت مردانه کامیار', 'خرید بافت مردانه مدل کامیار', 'بافت مردانه, پلیور مردانه', 'MAN-KNIT-001', 500.00);
INSERT INTO `product` VALUES (18, 'پلیور مردانه مدل سینا', 'men-sweater-sina', '<p>پلیور مردانه سینا با طرح یقه گرد</p>', 1, NULL, 1782301600, 1782301600, 'پلیور مردانه سینا', 'خرید پلیور مردانه مدل سینا', 'پلیور مردانه, دورس مردانه', 'MAN-SWTR-001', 520.00);
INSERT INTO `product` VALUES (19, 'کاپشن مردانه مدل آرش', 'men-raincoat-arash', '<p>کاپشن سبک آرش مناسب فصل بهار و پاییز</p>', 1, NULL, 1782301700, 1782301700, 'کاپشن مردانه آرش', 'خرید کاپشن مردانه مدل آرش', 'کاپشن مردانه, جاکت مردانه', 'MAN-JACK-001', 900.00);
INSERT INTO `product` VALUES (20, 'پیراهن مردانه مدل بهراد', 'men-shirt-behrad', '<p>پیراهن رسمی بهراد برای محیط کار</p>', 1, NULL, 1782301800, 1782301800, 'پیراهن مردانه بهراد', 'خرید پیراهن مردانه مدل بهراد', 'پیراهن مردانه, پیراهن رسمی', 'MAN-SHIRT-001', 400.00);
INSERT INTO `product` VALUES (21, 'هودی مردانه مدل داریوش', 'men-hoodie-daryush', '<p>هودی راحت داریوش با کاپشن جدا شدنی</p>', 1, NULL, 1782301900, 1782301900, 'هودی مردانه داریوش', 'خرید هودی مردانه مدل داریوش', 'هودی مردانه, سویشرت مردانه', 'MAN-HOOD-001', 650.00);
INSERT INTO `product` VALUES (22, 'شلوار جین مردانه مدل پارسا', 'men-jeans-parsa', '<p>شلوار جین راسته پارسا با جنس دنیم ترکی</p>', 1, NULL, 1782302000, 1782302000, 'شلوار جین پارسا', 'خرید شلوار جین مردانه مدل پارسا', 'شلوار جین مردانه, جین مردانه', 'MAN-JEAN-001', 700.00);
INSERT INTO `product` VALUES (23, 'شلوار پارچه‌ای مردانه مدل رضا', 'men-fabric-pants-reza', '<p>شلوار پارچه‌ای رسمی رضا مناسب مجالس</p>', 1, NULL, 1782302100, 1782302100, 'شلوار پارچه‌ای رضا', 'خرید شلوار پارچه‌ای مردانه رضا', 'شلوار پارچه‌ای مردانه, شلوار کتی', 'MAN-FBRC-001', 650.00);
INSERT INTO `product` VALUES (24, 'شلوار اسپرت مردانه مدل نوید', 'navid', '<p>شلوار جاگر نوید برای ورزش و خانه</p>', 1, NULL, 1782302200, 1782302200, 'شلوار اسپرت نوید', 'خرید شلوار اسپرت مردانه نوید', 'شلوار اسپرت مردانه, جاگر مردانه', 'MAN-JGR-001', 480.00);
INSERT INTO `product` VALUES (25, 'شلوارک مردانه مدل سعید', 'men-shorts-saeed', '<p>شلوارک تابستانی سعید با جنس کتان</p>', 1, NULL, 1782302300, 1782302300, 'شلوارک مردانه سعید', 'خرید شلوارک مردانه مدل سعید', 'شلوارک مردانه, شورتک مردانه', 'MAN-SHORT-001', 350.00);
INSERT INTO `product` VALUES (26, 'تیشرت مردانه مدل امیر', 'men-tshirt-amir', '<p>تیشرت ساده امیر با پارچه پنبه‌ای</p>', 1, NULL, 1782302400, 1782302400, 'تیشرت مردانه امیر', 'خرید تیشرت مردانه مدل امیر', 'تیشرت مردانه, پولوشرت مردانه', 'MAN-TSHRT-001', 250.00);
INSERT INTO `product` VALUES (27, 'ست اسپرت مردانه مدل علی', 'men-set-ali', '<p>ست اسپرت علی شامل شلوار و بالاپوش</p>', 1, NULL, 1782302500, 1782302500, 'ست اسپرت مردانه علی', 'خرید ست اسپرت مردانه مدل علی', 'ست اسپرت مردانه, ست ورزشی', 'MAN-SET-001', 800.00);
INSERT INTO `product` VALUES (28, 'بلوز آستین بلند مردانه مدل حسن', 'men-long-sleeve-hasan', '<p>بلوز آستین بلند یقه دار حسن برای فصل خنک</p>', 1, NULL, 1782302600, 1782302600, 'بلوز آستین بلند حسن', 'خرید بلوز آستین بلند مردانه حسن', 'بلوز مردانه, آستین بلند مردانه', 'MAN-LS-001', 420.00);
INSERT INTO `product` VALUES (29, 'کلاه مردانه مدل مجید', 'men-hat-majid', '<p>کلاه بافتنی زمستانی مجید</p>', 1, NULL, 1782302700, 1782302700, 'کلاه مردانه مجید', 'خرید کلاه مردانه مدل مجید', 'کلاه مردانه, کلاه زمستانی', 'MAN-HAT-001', 150.00);
INSERT INTO `product` VALUES (30, 'جوراب مردانه مدل کریم', 'men-socks-karim', '<p>جوراب ساق بلند کریم برای فصل سرد</p>', 1, NULL, 1782302800, 1782302800, 'جوراب مردانه کریم', 'خرید جوراب مردانه مدل کریم', 'جوراب مردانه, جوراب ساق بلند', 'MAN-SOCK-001', 80.00);
INSERT INTO `product` VALUES (31, 'کمربند مردانه مدل فرهاد', 'men-belt-farhad', 'کمربند چرم فرهاد مناسب کت و شلوار\r\nاینا چه کصشریه دیگه؟', 1, 1782701745, 1782302900, 1782783341, 'کمربند مردانه فرهاد', 'خرید کمربند مردانه مدل فرهاد', 'کمربند مردانه, کمربند چرم', 'MAN-BELT-001', 200.00);

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
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_product_image_type_id`(`product_image_type_id` ASC) USING BTREE,
  INDEX `fk_product_image_product_id`(`product_id` ASC) USING BTREE,
  CONSTRAINT `fk_product_image_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_product_image_type_id` FOREIGN KEY (`product_image_type_id`) REFERENCES `product_image_type` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 159 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of product_image
-- ----------------------------
INSERT INTO `product_image` VALUES (1, 1, 1, 'formal-coat-thumb.webp', 'formal-coat-main.jpg', 'مانتو مجلسی زنانه الیزابت', 0, 1, 1781736481, 1781736481);
INSERT INTO `product_image` VALUES (2, 2, 1, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'نمایش پشت مانتو مجلسی', 0, 1, 1781736481, 1781736481);
INSERT INTO `product_image` VALUES (3, 2, 1, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'جزئیات یقه مانتو مجلسی', 1, 1, 1781736481, 1781736481);
INSERT INTO `product_image` VALUES (4, 2, 1, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'جزئیات سرآستین مانتو مجلسی', 2, 1, 1781736481, 1781736481);
INSERT INTO `product_image` VALUES (5, 2, 1, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-3.jpg', 'جزئیات سرآستین مانتو مجلسی', 3, 1, 1781736481, 1781736481);
INSERT INTO `product_image` VALUES (6, 1, 2, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'بافت زنانه آریا - تصویر اصلی', 0, 1, 1782300000, 1782300000);
INSERT INTO `product_image` VALUES (7, 2, 2, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'بافت زنانه آریا - نمای جلو', 0, 1, 1782300000, 1782300000);
INSERT INTO `product_image` VALUES (8, 2, 2, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'بافت زنانه آریا - نمای پشت', 1, 1, 1782300000, 1782300000);
INSERT INTO `product_image` VALUES (9, 2, 2, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'بافت زنانه آریا - جزئیات بافت', 2, 1, 1782300000, 1782300000);
INSERT INTO `product_image` VALUES (10, 2, 2, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'بافت زنانه آریا - جزئیات آستین', 3, 1, 1782300000, 1782300000);
INSERT INTO `product_image` VALUES (11, 1, 3, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'بلوز شومیز نگار - تصویر اصلی', 0, 1, 1782300100, 1782300100);
INSERT INTO `product_image` VALUES (12, 2, 3, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'بلوز شومیز نگار - نمای جلو', 0, 1, 1782300100, 1782300100);
INSERT INTO `product_image` VALUES (13, 2, 3, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'بلوز شومیز نگار - نمای پشت', 1, 1, 1782300100, 1782300100);
INSERT INTO `product_image` VALUES (14, 2, 3, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'بلوز شومیز نگار - جزئیات یقه', 2, 1, 1782300100, 1782300100);
INSERT INTO `product_image` VALUES (15, 2, 3, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'بلوز شومیز نگار - جزئیات سرآستین', 3, 1, 1782300100, 1782300100);
INSERT INTO `product_image` VALUES (16, 1, 4, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'تونیک دانا - تصویر اصلی', 0, 1, 1782300200, 1782300200);
INSERT INTO `product_image` VALUES (17, 2, 4, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'تونیک دانا - نمای جلو', 0, 1, 1782300200, 1782300200);
INSERT INTO `product_image` VALUES (18, 2, 4, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'تونیک دانا - نمای پشت', 1, 1, 1782300200, 1782300200);
INSERT INTO `product_image` VALUES (19, 2, 4, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'تونیک دانا - جزئیات چاپ', 2, 1, 1782300200, 1782300200);
INSERT INTO `product_image` VALUES (20, 2, 4, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'تونیک دانا - جزئیات کمر', 3, 1, 1782300200, 1782300200);
INSERT INTO `product_image` VALUES (21, 1, 5, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'پیراهن سونا - تصویر اصلی', 0, 1, 1782300300, 1782300300);
INSERT INTO `product_image` VALUES (22, 2, 5, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'پیراهن سونا - نمای جلو', 0, 1, 1782300300, 1782300300);
INSERT INTO `product_image` VALUES (23, 2, 5, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'پیراهن سونا - نمای پشت', 1, 1, 1782300300, 1782300300);
INSERT INTO `product_image` VALUES (24, 2, 5, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'پیراهن سونا - جزئیات تزئینات', 2, 1, 1782300300, 1782300300);
INSERT INTO `product_image` VALUES (25, 2, 5, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'پیراهن سونا - جزئیات دامن', 3, 1, 1782300300, 1782300300);
INSERT INTO `product_image` VALUES (26, 1, 6, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'سرهمی پانیا - تصویر اصلی', 0, 1, 1782300400, 1782300400);
INSERT INTO `product_image` VALUES (27, 2, 6, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'سرهمی پانیا - نمای جلو', 0, 1, 1782300400, 1782300400);
INSERT INTO `product_image` VALUES (28, 2, 6, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'سرهمی پانیا - نمای پشت', 1, 1, 1782300400, 1782300400);
INSERT INTO `product_image` VALUES (29, 2, 6, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'سرهمی پانیا - جزئیات جیب', 2, 1, 1782300400, 1782300400);
INSERT INTO `product_image` VALUES (30, 2, 6, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'سرهمی پانیا - جزئیات بند', 3, 1, 1782300400, 1782300400);
INSERT INTO `product_image` VALUES (31, 1, 7, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'کت ستاره - تصویر اصلی', 0, 1, 1782300500, 1782300500);
INSERT INTO `product_image` VALUES (32, 2, 7, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'کت ستاره - نمای جلو', 0, 1, 1782300500, 1782300500);
INSERT INTO `product_image` VALUES (33, 2, 7, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'کت ستاره - نمای پشت', 1, 1, 1782300500, 1782300500);
INSERT INTO `product_image` VALUES (34, 2, 7, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'کت ستاره - جزئیات دکمه', 2, 1, 1782300500, 1782300500);
INSERT INTO `product_image` VALUES (35, 2, 7, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'کت ستاره - جزئیات یقه', 3, 1, 1782300500, 1782300500);
INSERT INTO `product_image` VALUES (36, 1, 8, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'کاپشن آوا - تصویر اصلی', 0, 1, 1782300600, 1782300600);
INSERT INTO `product_image` VALUES (37, 2, 8, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'کاپشن آوا - نمای جلو', 0, 1, 1782300600, 1782300600);
INSERT INTO `product_image` VALUES (38, 2, 8, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'کاپشن آوا - نمای پشت', 1, 1, 1782300600, 1782300600);
INSERT INTO `product_image` VALUES (39, 2, 8, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'کاپشن آوا - جزئیات زیپ', 2, 1, 1782300600, 1782300600);
INSERT INTO `product_image` VALUES (40, 2, 8, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'کاپشن آوا - جزئیات جیب', 3, 1, 1782300600, 1782300600);
INSERT INTO `product_image` VALUES (41, 1, 9, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'پالتو لیلا - تصویر اصلی', 0, 1, 1782300700, 1782300700);
INSERT INTO `product_image` VALUES (42, 2, 9, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'پالتو لیلا - نمای جلو', 0, 1, 1782300700, 1782300700);
INSERT INTO `product_image` VALUES (43, 2, 9, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'پالتو لیلا - نمای پشت', 1, 1, 1782300700, 1782300700);
INSERT INTO `product_image` VALUES (44, 2, 9, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'پالتو لیلا - جزئیات کمربند', 2, 1, 1782300700, 1782300700);
INSERT INTO `product_image` VALUES (45, 2, 9, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'پالتو لیلا - جزئیات یقه', 3, 1, 1782300700, 1782300700);
INSERT INTO `product_image` VALUES (46, 1, 10, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'ترنچ کت رها - تصویر اصلی', 0, 1, 1782300800, 1782300800);
INSERT INTO `product_image` VALUES (47, 2, 10, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'ترنچ کت رها - نمای جلو', 0, 1, 1782300800, 1782300800);
INSERT INTO `product_image` VALUES (48, 2, 10, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'ترنچ کت رها - نمای پشت', 1, 1, 1782300800, 1782300800);
INSERT INTO `product_image` VALUES (49, 2, 10, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'ترنچ کت رها - جزئیات کمربند', 2, 1, 1782300800, 1782300800);
INSERT INTO `product_image` VALUES (50, 2, 10, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'ترنچ کت رها - جزئیات دکمه', 3, 1, 1782300800, 1782300800);
INSERT INTO `product_image` VALUES (51, 1, 11, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'هودی مهسا - تصویر اصلی', 0, 1, 1782300900, 1782300900);
INSERT INTO `product_image` VALUES (52, 2, 11, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'هودی مهسا - نمای جلو', 0, 1, 1782300900, 1782300900);
INSERT INTO `product_image` VALUES (53, 2, 11, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'هودی مهسا - نمای پشت', 1, 1, 1782300900, 1782300900);
INSERT INTO `product_image` VALUES (54, 2, 11, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'هودی مهسا - جزئیات کاپوت', 2, 1, 1782300900, 1782300900);
INSERT INTO `product_image` VALUES (55, 2, 11, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'هودی مهسا - جزئیات جیب کانگرو', 3, 1, 1782300900, 1782300900);
INSERT INTO `product_image` VALUES (56, 1, 12, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'پلیور نازنین - تصویر اصلی', 0, 1, 1782301000, 1782301000);
INSERT INTO `product_image` VALUES (57, 2, 12, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'پلیور نازنین - نمای جلو', 0, 1, 1782301000, 1782301000);
INSERT INTO `product_image` VALUES (58, 2, 12, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'پلیور نازنین - نمای پشت', 1, 1, 1782301000, 1782301000);
INSERT INTO `product_image` VALUES (59, 2, 12, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'پلیور نازنین - جزئیات طرح چهارخانه', 2, 1, 1782301000, 1782301000);
INSERT INTO `product_image` VALUES (60, 2, 12, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'پلیور نازنین - جزئیات یقه', 3, 1, 1782301000, 1782301000);
INSERT INTO `product_image` VALUES (61, 1, 13, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'وست شیوا - تصویر اصلی', 0, 1, 1782301100, 1782301100);
INSERT INTO `product_image` VALUES (62, 2, 13, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'وست شیوا - نمای جلو', 0, 1, 1782301100, 1782301100);
INSERT INTO `product_image` VALUES (63, 2, 13, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'وست شیوا - نمای پشت', 1, 1, 1782301100, 1782301100);
INSERT INTO `product_image` VALUES (64, 2, 13, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'وست شیوا - جزئیات دکمه', 2, 1, 1782301100, 1782301100);
INSERT INTO `product_image` VALUES (65, 2, 13, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'وست شیوا - جزئیات جیب', 3, 1, 1782301100, 1782301100);
INSERT INTO `product_image` VALUES (66, 1, 14, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'شلوار راسته ملیکا - تصویر اصلی', 0, 1, 1782301200, 1782301200);
INSERT INTO `product_image` VALUES (67, 2, 14, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'شلوار راسته ملیکا - نمای جلو', 0, 1, 1782301200, 1782301200);
INSERT INTO `product_image` VALUES (68, 2, 14, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'شلوار راسته ملیکا - نمای پشت', 1, 1, 1782301200, 1782301200);
INSERT INTO `product_image` VALUES (69, 2, 14, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'شلوار راسته ملیکا - جزئیات کمر', 2, 1, 1782301200, 1782301200);
INSERT INTO `product_image` VALUES (70, 2, 14, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'شلوار راسته ملیکا - جزئیات دمپا', 3, 1, 1782301200, 1782301200);
INSERT INTO `product_image` VALUES (71, 1, 15, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'شلوار پارچه‌ای یاس - تصویر اصلی', 0, 1, 1782301300, 1782301300);
INSERT INTO `product_image` VALUES (72, 2, 15, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'شلوار پارچه‌ای یاس - نمای جلو', 0, 1, 1782301300, 1782301300);
INSERT INTO `product_image` VALUES (73, 2, 15, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'شلوار پارچه‌ای یاس - نمای پشت', 1, 1, 1782301300, 1782301300);
INSERT INTO `product_image` VALUES (74, 2, 15, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'شلوار پارچه‌ای یاس - جزئیات جیب', 2, 1, 1782301300, 1782301300);
INSERT INTO `product_image` VALUES (75, 2, 15, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'شلوار پارچه‌ای یاس - جزئیات کمرکش', 3, 1, 1782301300, 1782301300);
INSERT INTO `product_image` VALUES (76, 1, 16, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'لگینگ روشا - تصویر اصلی', 0, 1, 1782301400, 1782301400);
INSERT INTO `product_image` VALUES (77, 2, 16, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'لگینگ روشا - نمای جلو', 0, 1, 1782301400, 1782301400);
INSERT INTO `product_image` VALUES (78, 2, 16, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'لگینگ روشا - نمای پشت', 1, 1, 1782301400, 1782301400);
INSERT INTO `product_image` VALUES (79, 2, 16, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'لگینگ روشا - جزئیات کمر پهن', 2, 1, 1782301400, 1782301400);
INSERT INTO `product_image` VALUES (80, 2, 16, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'لگینگ روشا - جزئیات پارچه', 3, 1, 1782301400, 1782301400);
INSERT INTO `product_image` VALUES (81, 1, 17, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'بافت مردانه کامیار - تصویر اصلی', 0, 1, 1782301500, 1782301500);
INSERT INTO `product_image` VALUES (82, 2, 17, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'بافت مردانه کامیار - نمای جلو', 0, 1, 1782301500, 1782301500);
INSERT INTO `product_image` VALUES (83, 2, 17, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'بافت مردانه کامیار - نمای پشت', 1, 1, 1782301500, 1782301500);
INSERT INTO `product_image` VALUES (84, 2, 17, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'بافت مردانه کامیار - جزئیات بافت', 2, 1, 1782301500, 1782301500);
INSERT INTO `product_image` VALUES (85, 2, 17, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'بافت مردانه کامیار - جزئیات یقه', 3, 1, 1782301500, 1782301500);
INSERT INTO `product_image` VALUES (86, 1, 18, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'پلیور سینا - تصویر اصلی', 0, 1, 1782301600, 1782301600);
INSERT INTO `product_image` VALUES (87, 2, 18, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'پلیور سینا - نمای جلو', 0, 1, 1782301600, 1782301600);
INSERT INTO `product_image` VALUES (88, 2, 18, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'پلیور سینا - نمای پشت', 1, 1, 1782301600, 1782301600);
INSERT INTO `product_image` VALUES (89, 2, 18, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'پلیور سینا - جزئیات یقه گرد', 2, 1, 1782301600, 1782301600);
INSERT INTO `product_image` VALUES (90, 2, 18, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'پلیور سینا - جزئیات آستین', 3, 1, 1782301600, 1782301600);
INSERT INTO `product_image` VALUES (91, 1, 19, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'کاپشن آرش - تصویر اصلی', 0, 1, 1782301700, 1782301700);
INSERT INTO `product_image` VALUES (92, 2, 19, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'کاپشن آرش - نمای جلو', 0, 1, 1782301700, 1782301700);
INSERT INTO `product_image` VALUES (93, 2, 19, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'کاپشن آرش - نمای پشت', 1, 1, 1782301700, 1782301700);
INSERT INTO `product_image` VALUES (94, 2, 19, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'کاپشن آرش - جزئیات زیپ', 2, 1, 1782301700, 1782301700);
INSERT INTO `product_image` VALUES (95, 2, 19, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'کاپشن آرش - جزئیات جیب', 3, 1, 1782301700, 1782301700);
INSERT INTO `product_image` VALUES (96, 1, 20, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'پیراهن بهراد - تصویر اصلی', 0, 1, 1782301800, 1782301800);
INSERT INTO `product_image` VALUES (97, 2, 20, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'پیراهن بهراد - نمای جلو', 0, 1, 1782301800, 1782301800);
INSERT INTO `product_image` VALUES (98, 2, 20, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'پیراهن بهراد - نمای پشت', 1, 1, 1782301800, 1782301800);
INSERT INTO `product_image` VALUES (99, 2, 20, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'پیراهن بهراد - جزئیات یقه', 2, 1, 1782301800, 1782301800);
INSERT INTO `product_image` VALUES (100, 2, 20, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'پیراهن بهراد - جزئیات دکمه‌های صدفی', 3, 1, 1782301800, 1782301800);
INSERT INTO `product_image` VALUES (101, 1, 21, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'هودی داریوش - تصویر اصلی', 0, 1, 1782301900, 1782301900);
INSERT INTO `product_image` VALUES (102, 2, 21, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'هودی داریوش - نمای جلو', 0, 1, 1782301900, 1782301900);
INSERT INTO `product_image` VALUES (103, 2, 21, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'هودی داریوش - نمای پشت', 1, 1, 1782301900, 1782301900);
INSERT INTO `product_image` VALUES (104, 2, 21, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'هودی داریوش - جزئیات کاپوت', 2, 1, 1782301900, 1782301900);
INSERT INTO `product_image` VALUES (105, 2, 21, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'هودی داریوش - جزئیات جیب', 3, 1, 1782301900, 1782301900);
INSERT INTO `product_image` VALUES (106, 1, 22, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'شلوار جین پارسا - تصویر اصلی', 0, 1, 1782302000, 1782302000);
INSERT INTO `product_image` VALUES (107, 2, 22, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'شلوار جین پارسا - نمای جلو', 0, 1, 1782302000, 1782302000);
INSERT INTO `product_image` VALUES (108, 2, 22, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'شلوار جین پارسا - نمای پشت', 1, 1, 1782302000, 1782302000);
INSERT INTO `product_image` VALUES (109, 2, 22, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'شلوار جین پارسا - جزئیات دمپا', 2, 1, 1782302000, 1782302000);
INSERT INTO `product_image` VALUES (110, 2, 22, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'شلوار جین پارسا - جزئیات جیب', 3, 1, 1782302000, 1782302000);
INSERT INTO `product_image` VALUES (111, 1, 23, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'شلوار پارچه‌ای رضا - تصویر اصلی', 0, 1, 1782302100, 1782302100);
INSERT INTO `product_image` VALUES (112, 2, 23, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'شلوار پارچه‌ای رضا - نمای جلو', 0, 1, 1782302100, 1782302100);
INSERT INTO `product_image` VALUES (113, 2, 23, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'شلوار پارچه‌ای رضا - نمای پشت', 1, 1, 1782302100, 1782302100);
INSERT INTO `product_image` VALUES (114, 2, 23, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'شلوار پارچه‌ای رضا - جزئیات کمر', 2, 1, 1782302100, 1782302100);
INSERT INTO `product_image` VALUES (115, 2, 23, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'شلوار پارچه‌ای رضا - جزئیات دمپا', 3, 1, 1782302100, 1782302100);
INSERT INTO `product_image` VALUES (116, 1, 24, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'شلوار اسپرت نوید - تصویر اصلی', 0, 1, 1782302200, 1782302200);
INSERT INTO `product_image` VALUES (117, 2, 24, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'شلوار اسپرت نوید - نمای جلو', 0, 1, 1782302200, 1782302200);
INSERT INTO `product_image` VALUES (118, 2, 24, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'شلوار اسپرت نوید - نمای پشت', 1, 1, 1782302200, 1782302200);
INSERT INTO `product_image` VALUES (119, 2, 24, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'شلوار اسپرت نوید - جزئیات کش کمر', 2, 1, 1782302200, 1782302200);
INSERT INTO `product_image` VALUES (120, 2, 24, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'شلوار اسپرت نوید - جزئیات دمپا', 3, 1, 1782302200, 1782302200);
INSERT INTO `product_image` VALUES (121, 1, 25, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'شلوارک سعید - تصویر اصلی', 0, 1, 1782302300, 1782302300);
INSERT INTO `product_image` VALUES (122, 2, 25, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'شلوارک سعید - نمای جلو', 0, 1, 1782302300, 1782302300);
INSERT INTO `product_image` VALUES (123, 2, 25, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'شلوارک سعید - نمای پشت', 1, 1, 1782302300, 1782302300);
INSERT INTO `product_image` VALUES (124, 2, 25, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'شلوارک سعید - جزئیات جیب', 2, 1, 1782302300, 1782302300);
INSERT INTO `product_image` VALUES (125, 2, 25, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'شلوارک سعید - جزئیات کش', 3, 1, 1782302300, 1782302300);
INSERT INTO `product_image` VALUES (126, 1, 26, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'تیشرت امیر - تصویر اصلی', 0, 1, 1782302400, 1782302400);
INSERT INTO `product_image` VALUES (127, 2, 26, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'تیشرت امیر - نمای جلو', 0, 1, 1782302400, 1782302400);
INSERT INTO `product_image` VALUES (128, 2, 26, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'تیشرت امیر - نمای پشت', 1, 1, 1782302400, 1782302400);
INSERT INTO `product_image` VALUES (129, 2, 26, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'تیشرت امیر - جزئیات یقه', 2, 1, 1782302400, 1782302400);
INSERT INTO `product_image` VALUES (130, 2, 26, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'تیشرت امیر - جزئیات پارچه', 3, 1, 1782302400, 1782302400);
INSERT INTO `product_image` VALUES (131, 1, 27, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'ست اسپرت علی - تصویر اصلی', 0, 1, 1782302500, 1782302500);
INSERT INTO `product_image` VALUES (132, 2, 27, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'ست اسپرت علی - نمای جلو', 0, 1, 1782302500, 1782302500);
INSERT INTO `product_image` VALUES (133, 2, 27, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'ست اسپرت علی - نمای پشت', 1, 1, 1782302500, 1782302500);
INSERT INTO `product_image` VALUES (134, 2, 27, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'ست اسپرت علی - شلوار', 2, 1, 1782302500, 1782302500);
INSERT INTO `product_image` VALUES (135, 2, 27, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'ست اسپرت علی - بالاپوش', 3, 1, 1782302500, 1782302500);
INSERT INTO `product_image` VALUES (136, 1, 28, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'بلوز آستین بلند حسن - تصویر اصلی', 0, 1, 1782302600, 1782302600);
INSERT INTO `product_image` VALUES (137, 2, 28, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'بلوز آستین بلند حسن - نمای جلو', 0, 1, 1782302600, 1782302600);
INSERT INTO `product_image` VALUES (138, 2, 28, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'بلوز آستین بلند حسن - نمای پشت', 1, 1, 1782302600, 1782302600);
INSERT INTO `product_image` VALUES (139, 2, 28, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'بلوز آستین بلند حسن - جزئیات یقه', 2, 1, 1782302600, 1782302600);
INSERT INTO `product_image` VALUES (140, 2, 28, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'بلوز آستین بلند حسن - جزئیات آستین', 3, 1, 1782302600, 1782302600);
INSERT INTO `product_image` VALUES (141, 1, 29, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'کلاه مجید - تصویر اصلی', 0, 1, 1782302700, 1782302700);
INSERT INTO `product_image` VALUES (142, 2, 29, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'کلاه مجید - نمای جلو', 0, 1, 1782302700, 1782302700);
INSERT INTO `product_image` VALUES (143, 2, 29, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'کلاه مجید - نمای کنار', 1, 1, 1782302700, 1782302700);
INSERT INTO `product_image` VALUES (144, 2, 29, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'کلاه مجید - جزئیات بافت', 2, 1, 1782302700, 1782302700);
INSERT INTO `product_image` VALUES (145, 2, 29, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'کلاه مجید - جزئیات حاشیه', 3, 1, 1782302700, 1782302700);
INSERT INTO `product_image` VALUES (146, 1, 30, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'جوراب کریم - تصویر اصلی', 0, 1, 1782302800, 1782302800);
INSERT INTO `product_image` VALUES (147, 2, 30, 'formal-coat-gallery-1.webp', 'formal-coat-gallery-1.jpg', 'جوراب کریم - نمای جلو', 0, 1, 1782302800, 1782302800);
INSERT INTO `product_image` VALUES (148, 2, 30, 'formal-coat-gallery-2.webp', 'formal-coat-gallery-2.jpg', 'جوراب کریم - نمای کنار', 1, 1, 1782302800, 1782302800);
INSERT INTO `product_image` VALUES (149, 2, 30, 'formal-coat-gallery-3.webp', 'formal-coat-gallery-3.jpg', 'جوراب کریم - جزئیات پاشنه', 2, 1, 1782302800, 1782302800);
INSERT INTO `product_image` VALUES (150, 2, 30, 'formal-coat-gallery-4.webp', 'formal-coat-gallery-4.jpg', 'جوراب کریم - جزئیات ساق', 3, 1, 1782302800, 1782302800);
INSERT INTO `product_image` VALUES (151, 1, 31, 'formal-coat-thumb.webp', 'formal-coat-thumb.jpg', 'کمربند فرهاد - تصویر ', 0, 1, 1782302900, 1782783188);
INSERT INTO `product_image` VALUES (157, 1, 31, '1782853056_formal-coat-gallery-2.webp', 'formal-coat-gallery-2.webp', 'پشت', 2, 1, 1782853056, 1782853056);
INSERT INTO `product_image` VALUES (158, 2, 31, '1782853165_formal-coat-thumb.webp', 'formal-coat-thumb.webp', ' کمربند مردانه مدل فرهاد ', 0, 1, 1782853165, 1782853165);

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
INSERT INTO `product_image_type` VALUES (1, 'تصویر گالری', 800, 800, 'jpg|png|webp', 2048, 'images/products', 1, 1781736267, 1781736267);
INSERT INTO `product_image_type` VALUES (2, 'تصویر thumbnail', 400, 400, 'jpg|png|webp', 1024, 'images/products', 1, 1781736267, 1781736267);

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
) ENGINE = InnoDB AUTO_INCREMENT = 33 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

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
INSERT INTO `product_menu` VALUES (31, 31, 41, 1782302900, 1782862789);
INSERT INTO `product_menu` VALUES (32, 31, 30, 1782863614, 1782863620);

-- ----------------------------
-- Table structure for product_option
-- ----------------------------
DROP TABLE IF EXISTS `product_option`;
CREATE TABLE `product_option`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` int UNSIGNED NOT NULL,
  `option_id` int UNSIGNED NOT NULL,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_product_option_product_id`(`product_id` ASC) USING BTREE,
  INDEX `fk_product_option_option_id`(`option_id` ASC) USING BTREE,
  CONSTRAINT `fk_product_option_option_id` FOREIGN KEY (`option_id`) REFERENCES `option` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_product_option_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 223 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of product_option
-- ----------------------------
INSERT INTO `product_option` VALUES (1, 1, 1, 1781736444, 1781736444);
INSERT INTO `product_option` VALUES (4, 1, 2, 1781736444, 1781736444);
INSERT INTO `product_option` VALUES (6, 1, 3, 1781736444, 1781736444);
INSERT INTO `product_option` VALUES (8, 1, 5, 1781920240, 1781920240);
INSERT INTO `product_option` VALUES (9, 1, 6, 1781920240, 1781920240);
INSERT INTO `product_option` VALUES (10, 1, 7, 1781920240, 1781920240);
INSERT INTO `product_option` VALUES (11, 1, 8, 1781920240, 1781920240);
INSERT INTO `product_option` VALUES (12, 1, 9, 1781920247, 1781920247);
INSERT INTO `product_option` VALUES (13, 1, 10, 1781920247, 1781920247);
INSERT INTO `product_option` VALUES (14, 1, 11, 1781920247, 1781920247);
INSERT INTO `product_option` VALUES (15, 2, 1, 1782300000, 1782300000);
INSERT INTO `product_option` VALUES (16, 2, 3, 1782300000, 1782300000);
INSERT INTO `product_option` VALUES (17, 2, 5, 1782300000, 1782300000);
INSERT INTO `product_option` VALUES (18, 2, 6, 1782300000, 1782300000);
INSERT INTO `product_option` VALUES (19, 2, 7, 1782300000, 1782300000);
INSERT INTO `product_option` VALUES (20, 2, 9, 1782300000, 1782300000);
INSERT INTO `product_option` VALUES (21, 3, 2, 1782300100, 1782300100);
INSERT INTO `product_option` VALUES (22, 3, 4, 1782300100, 1782300100);
INSERT INTO `product_option` VALUES (23, 3, 5, 1782300100, 1782300100);
INSERT INTO `product_option` VALUES (24, 3, 6, 1782300100, 1782300100);
INSERT INTO `product_option` VALUES (25, 3, 7, 1782300100, 1782300100);
INSERT INTO `product_option` VALUES (26, 3, 9, 1782300100, 1782300100);
INSERT INTO `product_option` VALUES (27, 4, 1, 1782300200, 1782300200);
INSERT INTO `product_option` VALUES (28, 4, 2, 1782300200, 1782300200);
INSERT INTO `product_option` VALUES (29, 4, 5, 1782300200, 1782300200);
INSERT INTO `product_option` VALUES (30, 4, 6, 1782300200, 1782300200);
INSERT INTO `product_option` VALUES (31, 4, 7, 1782300200, 1782300200);
INSERT INTO `product_option` VALUES (32, 4, 10, 1782300200, 1782300200);
INSERT INTO `product_option` VALUES (33, 5, 1, 1782300300, 1782300300);
INSERT INTO `product_option` VALUES (34, 5, 2, 1782300300, 1782300300);
INSERT INTO `product_option` VALUES (35, 5, 4, 1782300300, 1782300300);
INSERT INTO `product_option` VALUES (36, 5, 5, 1782300300, 1782300300);
INSERT INTO `product_option` VALUES (37, 5, 6, 1782300300, 1782300300);
INSERT INTO `product_option` VALUES (38, 5, 7, 1782300300, 1782300300);
INSERT INTO `product_option` VALUES (39, 5, 11, 1782300300, 1782300300);
INSERT INTO `product_option` VALUES (40, 6, 1, 1782300400, 1782300400);
INSERT INTO `product_option` VALUES (41, 6, 3, 1782300400, 1782300400);
INSERT INTO `product_option` VALUES (42, 6, 5, 1782300400, 1782300400);
INSERT INTO `product_option` VALUES (43, 6, 6, 1782300400, 1782300400);
INSERT INTO `product_option` VALUES (44, 6, 7, 1782300400, 1782300400);
INSERT INTO `product_option` VALUES (45, 6, 10, 1782300400, 1782300400);
INSERT INTO `product_option` VALUES (46, 7, 1, 1782300500, 1782300500);
INSERT INTO `product_option` VALUES (47, 7, 3, 1782300500, 1782300500);
INSERT INTO `product_option` VALUES (48, 7, 4, 1782300500, 1782300500);
INSERT INTO `product_option` VALUES (49, 7, 5, 1782300500, 1782300500);
INSERT INTO `product_option` VALUES (50, 7, 6, 1782300500, 1782300500);
INSERT INTO `product_option` VALUES (51, 7, 7, 1782300500, 1782300500);
INSERT INTO `product_option` VALUES (52, 7, 8, 1782300500, 1782300500);
INSERT INTO `product_option` VALUES (53, 7, 10, 1782300500, 1782300500);
INSERT INTO `product_option` VALUES (54, 8, 1, 1782300600, 1782300600);
INSERT INTO `product_option` VALUES (55, 8, 2, 1782300600, 1782300600);
INSERT INTO `product_option` VALUES (56, 8, 3, 1782300600, 1782300600);
INSERT INTO `product_option` VALUES (57, 8, 5, 1782300600, 1782300600);
INSERT INTO `product_option` VALUES (58, 8, 6, 1782300600, 1782300600);
INSERT INTO `product_option` VALUES (59, 8, 7, 1782300600, 1782300600);
INSERT INTO `product_option` VALUES (60, 8, 11, 1782300600, 1782300600);
INSERT INTO `product_option` VALUES (61, 9, 1, 1782300700, 1782300700);
INSERT INTO `product_option` VALUES (62, 9, 3, 1782300700, 1782300700);
INSERT INTO `product_option` VALUES (63, 9, 4, 1782300700, 1782300700);
INSERT INTO `product_option` VALUES (64, 9, 5, 1782300700, 1782300700);
INSERT INTO `product_option` VALUES (65, 9, 6, 1782300700, 1782300700);
INSERT INTO `product_option` VALUES (66, 9, 7, 1782300700, 1782300700);
INSERT INTO `product_option` VALUES (67, 9, 10, 1782300700, 1782300700);
INSERT INTO `product_option` VALUES (68, 10, 1, 1782300800, 1782300800);
INSERT INTO `product_option` VALUES (69, 10, 4, 1782300800, 1782300800);
INSERT INTO `product_option` VALUES (70, 10, 5, 1782300800, 1782300800);
INSERT INTO `product_option` VALUES (71, 10, 6, 1782300800, 1782300800);
INSERT INTO `product_option` VALUES (72, 10, 7, 1782300800, 1782300800);
INSERT INTO `product_option` VALUES (73, 10, 10, 1782300800, 1782300800);
INSERT INTO `product_option` VALUES (74, 11, 1, 1782300900, 1782300900);
INSERT INTO `product_option` VALUES (75, 11, 2, 1782300900, 1782300900);
INSERT INTO `product_option` VALUES (76, 11, 3, 1782300900, 1782300900);
INSERT INTO `product_option` VALUES (77, 11, 5, 1782300900, 1782300900);
INSERT INTO `product_option` VALUES (78, 11, 6, 1782300900, 1782300900);
INSERT INTO `product_option` VALUES (79, 11, 7, 1782300900, 1782300900);
INSERT INTO `product_option` VALUES (80, 11, 8, 1782300900, 1782300900);
INSERT INTO `product_option` VALUES (81, 11, 11, 1782300900, 1782300900);
INSERT INTO `product_option` VALUES (82, 12, 1, 1782301000, 1782301000);
INSERT INTO `product_option` VALUES (83, 12, 2, 1782301000, 1782301000);
INSERT INTO `product_option` VALUES (84, 12, 4, 1782301000, 1782301000);
INSERT INTO `product_option` VALUES (85, 12, 5, 1782301000, 1782301000);
INSERT INTO `product_option` VALUES (86, 12, 6, 1782301000, 1782301000);
INSERT INTO `product_option` VALUES (87, 12, 7, 1782301000, 1782301000);
INSERT INTO `product_option` VALUES (88, 12, 9, 1782301000, 1782301000);
INSERT INTO `product_option` VALUES (89, 13, 1, 1782301100, 1782301100);
INSERT INTO `product_option` VALUES (90, 13, 3, 1782301100, 1782301100);
INSERT INTO `product_option` VALUES (91, 13, 5, 1782301100, 1782301100);
INSERT INTO `product_option` VALUES (92, 13, 6, 1782301100, 1782301100);
INSERT INTO `product_option` VALUES (93, 13, 7, 1782301100, 1782301100);
INSERT INTO `product_option` VALUES (94, 13, 11, 1782301100, 1782301100);
INSERT INTO `product_option` VALUES (95, 14, 1, 1782301200, 1782301200);
INSERT INTO `product_option` VALUES (96, 14, 3, 1782301200, 1782301200);
INSERT INTO `product_option` VALUES (97, 14, 4, 1782301200, 1782301200);
INSERT INTO `product_option` VALUES (98, 14, 5, 1782301200, 1782301200);
INSERT INTO `product_option` VALUES (99, 14, 6, 1782301200, 1782301200);
INSERT INTO `product_option` VALUES (100, 14, 7, 1782301200, 1782301200);
INSERT INTO `product_option` VALUES (101, 14, 8, 1782301200, 1782301200);
INSERT INTO `product_option` VALUES (102, 14, 10, 1782301200, 1782301200);
INSERT INTO `product_option` VALUES (103, 15, 1, 1782301300, 1782301300);
INSERT INTO `product_option` VALUES (104, 15, 4, 1782301300, 1782301300);
INSERT INTO `product_option` VALUES (105, 15, 5, 1782301300, 1782301300);
INSERT INTO `product_option` VALUES (106, 15, 6, 1782301300, 1782301300);
INSERT INTO `product_option` VALUES (107, 15, 7, 1782301300, 1782301300);
INSERT INTO `product_option` VALUES (108, 15, 10, 1782301300, 1782301300);
INSERT INTO `product_option` VALUES (109, 16, 1, 1782301400, 1782301400);
INSERT INTO `product_option` VALUES (110, 16, 3, 1782301400, 1782301400);
INSERT INTO `product_option` VALUES (111, 16, 5, 1782301400, 1782301400);
INSERT INTO `product_option` VALUES (112, 16, 6, 1782301400, 1782301400);
INSERT INTO `product_option` VALUES (113, 16, 7, 1782301400, 1782301400);
INSERT INTO `product_option` VALUES (114, 16, 11, 1782301400, 1782301400);
INSERT INTO `product_option` VALUES (115, 17, 1, 1782301500, 1782301500);
INSERT INTO `product_option` VALUES (116, 17, 3, 1782301500, 1782301500);
INSERT INTO `product_option` VALUES (117, 17, 4, 1782301500, 1782301500);
INSERT INTO `product_option` VALUES (118, 17, 5, 1782301500, 1782301500);
INSERT INTO `product_option` VALUES (119, 17, 6, 1782301500, 1782301500);
INSERT INTO `product_option` VALUES (120, 17, 7, 1782301500, 1782301500);
INSERT INTO `product_option` VALUES (121, 17, 8, 1782301500, 1782301500);
INSERT INTO `product_option` VALUES (122, 17, 9, 1782301500, 1782301500);
INSERT INTO `product_option` VALUES (123, 18, 1, 1782301600, 1782301600);
INSERT INTO `product_option` VALUES (124, 18, 2, 1782301600, 1782301600);
INSERT INTO `product_option` VALUES (125, 18, 3, 1782301600, 1782301600);
INSERT INTO `product_option` VALUES (126, 18, 5, 1782301600, 1782301600);
INSERT INTO `product_option` VALUES (127, 18, 6, 1782301600, 1782301600);
INSERT INTO `product_option` VALUES (128, 18, 7, 1782301600, 1782301600);
INSERT INTO `product_option` VALUES (129, 18, 8, 1782301600, 1782301600);
INSERT INTO `product_option` VALUES (130, 18, 9, 1782301600, 1782301600);
INSERT INTO `product_option` VALUES (131, 19, 1, 1782301700, 1782301700);
INSERT INTO `product_option` VALUES (132, 19, 3, 1782301700, 1782301700);
INSERT INTO `product_option` VALUES (133, 19, 5, 1782301700, 1782301700);
INSERT INTO `product_option` VALUES (134, 19, 6, 1782301700, 1782301700);
INSERT INTO `product_option` VALUES (135, 19, 7, 1782301700, 1782301700);
INSERT INTO `product_option` VALUES (136, 19, 8, 1782301700, 1782301700);
INSERT INTO `product_option` VALUES (137, 19, 11, 1782301700, 1782301700);
INSERT INTO `product_option` VALUES (138, 20, 1, 1782301800, 1782301800);
INSERT INTO `product_option` VALUES (139, 20, 2, 1782301800, 1782301800);
INSERT INTO `product_option` VALUES (140, 20, 4, 1782301800, 1782301800);
INSERT INTO `product_option` VALUES (141, 20, 5, 1782301800, 1782301800);
INSERT INTO `product_option` VALUES (142, 20, 6, 1782301800, 1782301800);
INSERT INTO `product_option` VALUES (143, 20, 7, 1782301800, 1782301800);
INSERT INTO `product_option` VALUES (144, 20, 8, 1782301800, 1782301800);
INSERT INTO `product_option` VALUES (145, 20, 10, 1782301800, 1782301800);
INSERT INTO `product_option` VALUES (146, 21, 1, 1782301900, 1782301900);
INSERT INTO `product_option` VALUES (147, 21, 3, 1782301900, 1782301900);
INSERT INTO `product_option` VALUES (148, 21, 5, 1782301900, 1782301900);
INSERT INTO `product_option` VALUES (149, 21, 6, 1782301900, 1782301900);
INSERT INTO `product_option` VALUES (150, 21, 7, 1782301900, 1782301900);
INSERT INTO `product_option` VALUES (151, 21, 8, 1782301900, 1782301900);
INSERT INTO `product_option` VALUES (152, 21, 11, 1782301900, 1782301900);
INSERT INTO `product_option` VALUES (153, 22, 1, 1782302000, 1782302000);
INSERT INTO `product_option` VALUES (154, 22, 3, 1782302000, 1782302000);
INSERT INTO `product_option` VALUES (155, 22, 5, 1782302000, 1782302000);
INSERT INTO `product_option` VALUES (156, 22, 6, 1782302000, 1782302000);
INSERT INTO `product_option` VALUES (157, 22, 7, 1782302000, 1782302000);
INSERT INTO `product_option` VALUES (158, 22, 8, 1782302000, 1782302000);
INSERT INTO `product_option` VALUES (159, 22, 11, 1782302000, 1782302000);
INSERT INTO `product_option` VALUES (160, 23, 1, 1782302100, 1782302100);
INSERT INTO `product_option` VALUES (161, 23, 4, 1782302100, 1782302100);
INSERT INTO `product_option` VALUES (162, 23, 5, 1782302100, 1782302100);
INSERT INTO `product_option` VALUES (163, 23, 6, 1782302100, 1782302100);
INSERT INTO `product_option` VALUES (164, 23, 7, 1782302100, 1782302100);
INSERT INTO `product_option` VALUES (165, 23, 8, 1782302100, 1782302100);
INSERT INTO `product_option` VALUES (166, 23, 10, 1782302100, 1782302100);
INSERT INTO `product_option` VALUES (167, 24, 1, 1782302200, 1782302200);
INSERT INTO `product_option` VALUES (168, 24, 3, 1782302200, 1782302200);
INSERT INTO `product_option` VALUES (169, 24, 5, 1782302200, 1782302200);
INSERT INTO `product_option` VALUES (170, 24, 6, 1782302200, 1782302200);
INSERT INTO `product_option` VALUES (171, 24, 7, 1782302200, 1782302200);
INSERT INTO `product_option` VALUES (172, 24, 8, 1782302200, 1782302200);
INSERT INTO `product_option` VALUES (173, 24, 11, 1782302200, 1782302200);
INSERT INTO `product_option` VALUES (174, 25, 1, 1782302300, 1782302300);
INSERT INTO `product_option` VALUES (175, 25, 3, 1782302300, 1782302300);
INSERT INTO `product_option` VALUES (176, 25, 4, 1782302300, 1782302300);
INSERT INTO `product_option` VALUES (177, 25, 5, 1782302300, 1782302300);
INSERT INTO `product_option` VALUES (178, 25, 6, 1782302300, 1782302300);
INSERT INTO `product_option` VALUES (179, 25, 7, 1782302300, 1782302300);
INSERT INTO `product_option` VALUES (180, 25, 10, 1782302300, 1782302300);
INSERT INTO `product_option` VALUES (181, 26, 1, 1782302400, 1782302400);
INSERT INTO `product_option` VALUES (182, 26, 2, 1782302400, 1782302400);
INSERT INTO `product_option` VALUES (183, 26, 3, 1782302400, 1782302400);
INSERT INTO `product_option` VALUES (184, 26, 4, 1782302400, 1782302400);
INSERT INTO `product_option` VALUES (185, 26, 5, 1782302400, 1782302400);
INSERT INTO `product_option` VALUES (186, 26, 6, 1782302400, 1782302400);
INSERT INTO `product_option` VALUES (187, 26, 7, 1782302400, 1782302400);
INSERT INTO `product_option` VALUES (188, 26, 8, 1782302400, 1782302400);
INSERT INTO `product_option` VALUES (189, 26, 9, 1782302400, 1782302400);
INSERT INTO `product_option` VALUES (190, 27, 1, 1782302500, 1782302500);
INSERT INTO `product_option` VALUES (191, 27, 3, 1782302500, 1782302500);
INSERT INTO `product_option` VALUES (192, 27, 5, 1782302500, 1782302500);
INSERT INTO `product_option` VALUES (193, 27, 6, 1782302500, 1782302500);
INSERT INTO `product_option` VALUES (194, 27, 7, 1782302500, 1782302500);
INSERT INTO `product_option` VALUES (195, 27, 8, 1782302500, 1782302500);
INSERT INTO `product_option` VALUES (196, 27, 11, 1782302500, 1782302500);
INSERT INTO `product_option` VALUES (197, 28, 1, 1782302600, 1782302600);
INSERT INTO `product_option` VALUES (198, 28, 2, 1782302600, 1782302600);
INSERT INTO `product_option` VALUES (199, 28, 3, 1782302600, 1782302600);
INSERT INTO `product_option` VALUES (200, 28, 5, 1782302600, 1782302600);
INSERT INTO `product_option` VALUES (201, 28, 6, 1782302600, 1782302600);
INSERT INTO `product_option` VALUES (202, 28, 7, 1782302600, 1782302600);
INSERT INTO `product_option` VALUES (203, 28, 8, 1782302600, 1782302600);
INSERT INTO `product_option` VALUES (204, 28, 9, 1782302600, 1782302600);
INSERT INTO `product_option` VALUES (205, 29, 1, 1782302700, 1782302700);
INSERT INTO `product_option` VALUES (206, 29, 2, 1782302700, 1782302700);
INSERT INTO `product_option` VALUES (207, 29, 3, 1782302700, 1782302700);
INSERT INTO `product_option` VALUES (208, 29, 9, 1782302700, 1782302700);
INSERT INTO `product_option` VALUES (209, 30, 1, 1782302800, 1782302800);
INSERT INTO `product_option` VALUES (210, 30, 2, 1782302800, 1782302800);
INSERT INTO `product_option` VALUES (211, 30, 3, 1782302800, 1782302800);
INSERT INTO `product_option` VALUES (212, 30, 9, 1782302800, 1782302800);
INSERT INTO `product_option` VALUES (213, 31, 1, 1782302900, 1782302900);
INSERT INTO `product_option` VALUES (214, 31, 3, 1782302900, 1782302900);
INSERT INTO `product_option` VALUES (215, 31, 10, 1782302900, 1782302900);
INSERT INTO `product_option` VALUES (216, 30, 5, 1782868349, 1782868349);
INSERT INTO `product_option` VALUES (218, 30, 7, 1782868349, 1782868349);
INSERT INTO `product_option` VALUES (219, 30, 11, 1782868360, 1782868360);
INSERT INTO `product_option` VALUES (220, 2, 2, 1782300000, 1782300000);
INSERT INTO `product_option` VALUES (221, 2, 4, 1782300000, 1782300000);
INSERT INTO `product_option` VALUES (222, 2, 8, 1782300000, 1782300000);

-- ----------------------------
-- Table structure for product_price
-- ----------------------------
DROP TABLE IF EXISTS `product_price`;
CREATE TABLE `product_price`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` int UNSIGNED NOT NULL,
  `color_option_id` int UNSIGNED NULL DEFAULT NULL,
  `size_option_id` int UNSIGNED NULL DEFAULT NULL,
  `price` decimal(15, 2) NOT NULL,
  `sale_price` decimal(15, 2) NULL DEFAULT NULL,
  `sale_start_date` int NULL DEFAULT NULL,
  `sale_end_date` int NULL DEFAULT NULL,
  `stock` int NOT NULL DEFAULT 0,
  `sku` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `unique_product_color_size`(`product_id` ASC, `color_option_id` ASC, `size_option_id` ASC) USING BTREE,
  INDEX `idx_product_id`(`product_id` ASC) USING BTREE,
  INDEX `idx_color_option_id`(`color_option_id` ASC) USING BTREE,
  INDEX `idx_size_option_id`(`size_option_id` ASC) USING BTREE,
  CONSTRAINT `fk_product_price_color_option` FOREIGN KEY (`color_option_id`) REFERENCES `option` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_product_price_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `fk_product_price_size_option` FOREIGN KEY (`size_option_id`) REFERENCES `option` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 346 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of product_price
-- ----------------------------
INSERT INTO `product_price` VALUES (40, 2, 2, 5, 130000.00, 92000.00, 1782300000, 1784900000, 0, 'KNIT-ARIA-BLK-S', 0, 1782300000, 1782300000);
INSERT INTO `product_price` VALUES (41, 2, 3, 8, 170000.00, 96000.00, 1782300000, 1784900000, 15, 'KNIT-ARIA-BLK-M', 0, 1782300000, 1782300000);
INSERT INTO `product_price` VALUES (42, 2, 1, 7, 120000.00, 91000.00, 1782300000, 1784900000, 0, 'KNIT-ARIA-BLK-L', 0, 1782300000, 1782300000);
INSERT INTO `product_price` VALUES (43, 2, 3, 5, 150000.00, 94000.00, 1782300000, 1784900000, 10, 'KNIT-ARIA-GRY-S', 0, 1782300000, 1782300000);
INSERT INTO `product_price` VALUES (44, 2, 1, 5, 110000.00, 90000.00, 1782300000, 1784900000, 0, 'KNIT-ARIA-GRY-M', 0, 1782300000, 1782300000);
INSERT INTO `product_price` VALUES (45, 2, 3, 7, 160000.00, 95000.00, 1782300000, 1784900000, 10, 'KNIT-ARIA-GRY-L', 0, 1782300000, 1782300000);
INSERT INTO `product_price` VALUES (73, 2, 2, 6, 140000.00, 93000.00, 1782300000, 1784900000, 10, NULL, 0, 1782300100, 1782300100);
INSERT INTO `product_price` VALUES (74, 2, 4, 5, 180000.00, 97000.00, 1782300000, 1784900000, 6, 'KNIT-ARIA-BLK-M', 0, 1782300000, 1782300000);
INSERT INTO `product_price` VALUES (75, 3, 2, 5, 185000.00, 185000.00, NULL, NULL, 25, 'BLOUSE-NEGAR-WHT-S', 0, 1784213900, 1784213900);
INSERT INTO `product_price` VALUES (76, 3, 2, 6, 195000.00, 125000.00, 1784061000, 1786739400, 18, 'BLOUSE-NEGAR-WHT-M', 0, 1784213900, 1784213900);
INSERT INTO `product_price` VALUES (77, 3, 2, 7, 205000.00, 135000.00, NULL, NULL, 0, 'BLOUSE-NEGAR-WHT-L', 0, 1784213900, 1784213900);
INSERT INTO `product_price` VALUES (78, 3, 4, 5, 175000.00, 115000.00, NULL, NULL, 30, 'BLOUSE-NEGAR-BGE-S', 0, 1784213900, 1784213900);
INSERT INTO `product_price` VALUES (79, 3, 4, 6, 190000.00, 120000.00, NULL, NULL, 22, 'BLOUSE-NEGAR-BGE-M', 0, 1784213900, 1784213900);
INSERT INTO `product_price` VALUES (80, 3, 4, 7, 210000.00, 140000.00, NULL, NULL, 12, 'BLOUSE-NEGAR-BGE-L', 0, 1784213900, 1784213900);
INSERT INTO `product_price` VALUES (81, 4, 1, 5, 165000.00, 165000.00, NULL, NULL, 20, 'TUNIC-DANA-BLK-S', 0, 1784213906, 1784213906);
INSERT INTO `product_price` VALUES (82, 4, 1, 6, 180000.00, 115000.00, 1784061000, 1786739400, 15, 'TUNIC-DANA-BLK-M', 0, 1784213906, 1784213906);
INSERT INTO `product_price` VALUES (83, 4, 1, 7, 195000.00, 125000.00, NULL, NULL, 0, 'TUNIC-DANA-BLK-L', 0, 1784213906, 1784213906);
INSERT INTO `product_price` VALUES (84, 4, 2, 5, 155000.00, 105000.00, NULL, NULL, 25, 'TUNIC-DANA-WHT-S', 0, 1784213906, 1784213906);
INSERT INTO `product_price` VALUES (85, 4, 2, 6, 170000.00, 110000.00, NULL, NULL, 18, 'TUNIC-DANA-WHT-M', 0, 1784213906, 1784213906);
INSERT INTO `product_price` VALUES (86, 4, 2, 7, 190000.00, 120000.00, NULL, NULL, 10, 'TUNIC-DANA-WHT-L', 0, 1784213906, 1784213906);
INSERT INTO `product_price` VALUES (87, 5, 1, 5, 220000.00, 220000.00, NULL, NULL, 15, 'SHIRT-SONA-BLK-S', 0, 1784213914, 1784213914);
INSERT INTO `product_price` VALUES (88, 5, 1, 6, 235000.00, 150000.00, 1784061000, 1786739400, 12, 'SHIRT-SONA-BLK-M', 0, 1784213914, 1784213914);
INSERT INTO `product_price` VALUES (89, 5, 1, 7, 250000.00, 160000.00, NULL, NULL, 0, 'SHIRT-SONA-BLK-L', 0, 1784213914, 1784213914);
INSERT INTO `product_price` VALUES (90, 5, 2, 5, 210000.00, 140000.00, NULL, NULL, 20, 'SHIRT-SONA-WHT-S', 0, 1784213914, 1784213914);
INSERT INTO `product_price` VALUES (91, 5, 2, 6, 225000.00, 145000.00, NULL, NULL, 14, 'SHIRT-SONA-WHT-M', 0, 1784213914, 1784213914);
INSERT INTO `product_price` VALUES (92, 5, 2, 7, 240000.00, 155000.00, NULL, NULL, 8, 'SHIRT-SONA-WHT-L', 0, 1784213914, 1784213914);
INSERT INTO `product_price` VALUES (93, 5, 4, 5, 215000.00, 142000.00, NULL, NULL, 18, 'SHIRT-SONA-BGE-S', 0, 1784213914, 1784213914);
INSERT INTO `product_price` VALUES (94, 5, 4, 6, 230000.00, 148000.00, NULL, NULL, 10, 'SHIRT-SONA-BGE-M', 0, 1784213914, 1784213914);
INSERT INTO `product_price` VALUES (95, 5, 4, 7, 245000.00, 158000.00, NULL, NULL, 6, 'SHIRT-SONA-BGE-L', 0, 1784213914, 1784213914);
INSERT INTO `product_price` VALUES (96, 6, 1, 5, 195000.00, 185000.00, NULL, NULL, 22, 'OVERALL-PANIA-BLK-S', 0, 1784213933, 1784213933);
INSERT INTO `product_price` VALUES (97, 6, 1, 6, 210000.00, 135000.00, 1784061000, 1786739400, 16, 'OVERALL-PANIA-BLK-M', 0, 1784213933, 1784213933);
INSERT INTO `product_price` VALUES (98, 6, 1, 7, 225000.00, 145000.00, NULL, NULL, 0, 'OVERALL-PANIA-BLK-L', 0, 1784213933, 1784213933);
INSERT INTO `product_price` VALUES (99, 6, 3, 5, 185000.00, 120000.00, NULL, NULL, 20, 'OVERALL-PANIA-GRY-S', 0, 1784213933, 1784213933);
INSERT INTO `product_price` VALUES (100, 6, 3, 6, 200000.00, 128000.00, NULL, NULL, 14, 'OVERALL-PANIA-GRY-M', 0, 1784213933, 1784213933);
INSERT INTO `product_price` VALUES (101, 6, 3, 7, 215000.00, 138000.00, NULL, NULL, 8, 'OVERALL-PANIA-GRY-L', 0, 1784213933, 1784213933);
INSERT INTO `product_price` VALUES (102, 7, 1, 5, 320000.00, 310000.00, NULL, NULL, 10, 'COAT-SETAREH-BLK-S', 0, 1784213937, 1784213937);
INSERT INTO `product_price` VALUES (103, 7, 1, 6, 340000.00, 220000.00, 1784061000, 1786739400, 8, 'COAT-SETAREH-BLK-M', 0, 1784213937, 1784213937);
INSERT INTO `product_price` VALUES (104, 7, 1, 7, 360000.00, 230000.00, NULL, NULL, 0, 'COAT-SETAREH-BLK-L', 0, 1784213937, 1784213937);
INSERT INTO `product_price` VALUES (105, 7, 1, 8, 380000.00, 250000.00, NULL, NULL, 5, 'COAT-SETAREH-BLK-XL', 0, 1784213937, 1784213937);
INSERT INTO `product_price` VALUES (106, 7, 3, 5, 310000.00, 200000.00, NULL, NULL, 12, 'COAT-SETAREH-GRY-S', 0, 1784213937, 1784213937);
INSERT INTO `product_price` VALUES (107, 7, 3, 6, 330000.00, 210000.00, NULL, NULL, 8, 'COAT-SETAREH-GRY-M', 0, 1784213937, 1784213937);
INSERT INTO `product_price` VALUES (108, 7, 3, 7, 350000.00, 225000.00, NULL, NULL, 6, 'COAT-SETAREH-GRY-L', 0, 1784213937, 1784213937);
INSERT INTO `product_price` VALUES (109, 7, 3, 8, 370000.00, 240000.00, NULL, NULL, 3, 'COAT-SETAREH-GRY-XL', 0, 1784213937, 1784213937);
INSERT INTO `product_price` VALUES (110, 7, 4, 5, 315000.00, 205000.00, NULL, NULL, 10, 'COAT-SETAREH-BGE-S', 0, 1784213937, 1784213937);
INSERT INTO `product_price` VALUES (111, 7, 4, 6, 335000.00, 215000.00, NULL, NULL, 7, 'COAT-SETAREH-BGE-M', 0, 1784213937, 1784213937);
INSERT INTO `product_price` VALUES (112, 7, 4, 7, 355000.00, 228000.00, NULL, NULL, 4, 'COAT-SETAREH-BGE-L', 0, 1784213937, 1784213937);
INSERT INTO `product_price` VALUES (113, 7, 4, 8, 375000.00, 245000.00, NULL, NULL, 2, 'COAT-SETAREH-BGE-XL', 0, 1784213937, 1784213937);
INSERT INTO `product_price` VALUES (114, 8, 1, 5, 280000.00, 205000.00, NULL, NULL, 12, 'JACKET-AVA-BLK-S', 0, 1784213941, 1784213941);
INSERT INTO `product_price` VALUES (115, 8, 1, 6, 300000.00, 195000.00, 1784061000, 1786739400, 8, 'JACKET-AVA-BLK-M', 0, 1784213941, 1784213941);
INSERT INTO `product_price` VALUES (116, 8, 1, 7, 320000.00, 205000.00, NULL, NULL, 0, 'JACKET-AVA-BLK-L', 0, 1784213941, 1784213941);
INSERT INTO `product_price` VALUES (117, 8, 2, 5, 270000.00, 175000.00, NULL, NULL, 15, 'JACKET-AVA-WHT-S', 0, 1784213941, 1784213941);
INSERT INTO `product_price` VALUES (118, 8, 2, 6, 290000.00, 185000.00, NULL, NULL, 10, 'JACKET-AVA-WHT-M', 0, 1784213941, 1784213941);
INSERT INTO `product_price` VALUES (119, 8, 2, 7, 310000.00, 200000.00, NULL, NULL, 5, 'JACKET-AVA-WHT-L', 0, 1784213941, 1784213941);
INSERT INTO `product_price` VALUES (120, 8, 3, 5, 275000.00, 180000.00, NULL, NULL, 12, 'JACKET-AVA-GRY-S', 0, 1784213941, 1784213941);
INSERT INTO `product_price` VALUES (121, 8, 3, 6, 295000.00, 190000.00, NULL, NULL, 8, 'JACKET-AVA-GRY-M', 0, 1784213941, 1784213941);
INSERT INTO `product_price` VALUES (122, 8, 3, 7, 315000.00, 202000.00, NULL, NULL, 4, 'JACKET-AVA-GRY-L', 0, 1784213941, 1784213941);
INSERT INTO `product_price` VALUES (123, 9, 1, 5, 510000.00, 480000.00, NULL, NULL, 8, 'PALTO-LEILA-BLK-S', 0, 1784213945, 1784213945);
INSERT INTO `product_price` VALUES (124, 9, 1, 6, 480000.00, 310000.00, 1784061000, 1786739400, 5, 'PALTO-LEILA-BLK-M', 0, 1784213945, 1784213945);
INSERT INTO `product_price` VALUES (125, 9, 1, 7, 510000.00, 330000.00, NULL, NULL, 0, 'PALTO-LEILA-BLK-L', 0, 1784213945, 1784213945);
INSERT INTO `product_price` VALUES (126, 9, 3, 5, 430000.00, 280000.00, NULL, NULL, 10, 'PALTO-LEILA-GRY-S', 0, 1784213945, 1784213945);
INSERT INTO `product_price` VALUES (127, 9, 3, 6, 460000.00, 300000.00, NULL, NULL, 6, 'PALTO-LEILA-GRY-M', 0, 1784213945, 1784213945);
INSERT INTO `product_price` VALUES (128, 9, 3, 7, 490000.00, 315000.00, NULL, NULL, 3, 'PALTO-LEILA-GRY-L', 0, 1784213945, 1784213945);
INSERT INTO `product_price` VALUES (129, 9, 4, 5, 440000.00, 285000.00, NULL, NULL, 8, 'PALTO-LEILA-BGE-S', 0, 1784213945, 1784213945);
INSERT INTO `product_price` VALUES (130, 9, 4, 6, 470000.00, 305000.00, NULL, NULL, 4, 'PALTO-LEILA-BGE-M', 0, 1784213945, 1784213945);
INSERT INTO `product_price` VALUES (131, 9, 4, 7, 500000.00, 320000.00, NULL, NULL, 2, 'PALTO-LEILA-BGE-L', 0, 1784213945, 1784213945);
INSERT INTO `product_price` VALUES (132, 10, 1, 5, 380000.00, 379000.00, NULL, NULL, 10, 'TRENCH-RAHA-BLK-S', 1, 1784213948, 1784213948);
INSERT INTO `product_price` VALUES (133, 10, 1, 6, 400000.00, 260000.00, 1784061000, 1786739400, 7, 'TRENCH-RAHA-BLK-M', 0, 1784213948, 1784213948);
INSERT INTO `product_price` VALUES (134, 10, 1, 7, 420000.00, 270000.00, NULL, NULL, 0, 'TRENCH-RAHA-BLK-L', 0, 1784213948, 1784213948);
INSERT INTO `product_price` VALUES (135, 10, 4, 5, 370000.00, 240000.00, NULL, NULL, 12, 'TRENCH-RAHA-BGE-S', 0, 1784213948, 1784213948);
INSERT INTO `product_price` VALUES (136, 10, 4, 6, 390000.00, 250000.00, NULL, NULL, 8, 'TRENCH-RAHA-BGE-M', 0, 1784213948, 1784213948);
INSERT INTO `product_price` VALUES (137, 10, 4, 7, 410000.00, 265000.00, NULL, NULL, 4, 'TRENCH-RAHA-BGE-L', 0, 1784213948, 1784213948);
INSERT INTO `product_price` VALUES (138, 11, 1, 5, 165000.00, 150000.00, NULL, NULL, 25, 'HOODIE-MAHSA-BLK-S', 0, 1784213951, 1784213951);
INSERT INTO `product_price` VALUES (139, 11, 1, 6, 175000.00, 112000.00, 1784061000, 1786739400, 18, 'HOODIE-MAHSA-BLK-M', 0, 1784213951, 1784213951);
INSERT INTO `product_price` VALUES (140, 11, 1, 7, 190000.00, 122000.00, NULL, NULL, 0, 'HOODIE-MAHSA-BLK-L', 0, 1784213951, 1784213951);
INSERT INTO `product_price` VALUES (141, 11, 1, 8, 205000.00, 132000.00, NULL, NULL, 10, 'HOODIE-MAHSA-BLK-XL', 0, 1784213951, 1784213951);
INSERT INTO `product_price` VALUES (142, 11, 2, 5, 150000.00, 98000.00, NULL, NULL, 30, 'HOODIE-MAHSA-WHT-S', 0, 1784213951, 1784213951);
INSERT INTO `product_price` VALUES (143, 11, 2, 6, 165000.00, 105000.00, NULL, NULL, 20, 'HOODIE-MAHSA-WHT-M', 0, 1784213951, 1784213951);
INSERT INTO `product_price` VALUES (144, 11, 2, 7, 180000.00, 115000.00, NULL, NULL, 12, 'HOODIE-MAHSA-WHT-L', 0, 1784213951, 1784213951);
INSERT INTO `product_price` VALUES (145, 11, 2, 8, 195000.00, 125000.00, NULL, NULL, 8, 'HOODIE-MAHSA-WHT-XL', 0, 1784213951, 1784213951);
INSERT INTO `product_price` VALUES (146, 11, 3, 5, 155000.00, 100000.00, NULL, NULL, 22, 'HOODIE-MAHSA-GRY-S', 0, 1784213951, 1784213951);
INSERT INTO `product_price` VALUES (147, 11, 3, 6, 170000.00, 108000.00, NULL, NULL, 15, 'HOODIE-MAHSA-GRY-M', 0, 1784213951, 1784213951);
INSERT INTO `product_price` VALUES (148, 11, 3, 7, 185000.00, 118000.00, NULL, NULL, 8, 'HOODIE-MAHSA-GRY-L', 0, 1784213951, 1784213951);
INSERT INTO `product_price` VALUES (149, 11, 3, 8, 200000.00, 128000.00, NULL, NULL, 5, 'HOODIE-MAHSA-GRY-XL', 0, 1784213951, 1784213951);
INSERT INTO `product_price` VALUES (150, 1, 1, 5, 550000.00, 550000.00, NULL, NULL, 8, 'COAT-ELIZABETH-BLK-S', 0, 1784213975, 1784213975);
INSERT INTO `product_price` VALUES (151, 1, 1, 6, 580000.00, 380000.00, 1784061000, 1786739400, 5, 'COAT-ELIZABETH-BLK-M', 0, 1784213975, 1784213975);
INSERT INTO `product_price` VALUES (152, 1, 1, 7, 610000.00, 400000.00, NULL, NULL, 0, 'COAT-ELIZABETH-BLK-L', 0, 1784213975, 1784213975);
INSERT INTO `product_price` VALUES (153, 1, 1, 8, 640000.00, 420000.00, NULL, NULL, 3, 'COAT-ELIZABETH-BLK-XL', 0, 1784213975, 1784213975);
INSERT INTO `product_price` VALUES (154, 1, 2, 5, 530000.00, 350000.00, NULL, NULL, 10, 'COAT-ELIZABETH-WHT-S', 0, 1784213975, 1784213975);
INSERT INTO `product_price` VALUES (155, 1, 2, 6, 560000.00, 370000.00, NULL, NULL, 6, 'COAT-ELIZABETH-WHT-M', 0, 1784213975, 1784213975);
INSERT INTO `product_price` VALUES (156, 1, 2, 7, 590000.00, 390000.00, NULL, NULL, 4, 'COAT-ELIZABETH-WHT-L', 0, 1784213975, 1784213975);
INSERT INTO `product_price` VALUES (157, 1, 2, 8, 620000.00, 410000.00, NULL, NULL, 2, 'COAT-ELIZABETH-WHT-XL', 0, 1784213975, 1784213975);
INSERT INTO `product_price` VALUES (158, 1, 3, 5, 540000.00, 355000.00, NULL, NULL, 8, 'COAT-ELIZABETH-GRY-S', 0, 1784213975, 1784213975);
INSERT INTO `product_price` VALUES (159, 1, 3, 6, 570000.00, 375000.00, NULL, NULL, 5, 'COAT-ELIZABETH-GRY-M', 0, 1784213975, 1784213975);
INSERT INTO `product_price` VALUES (160, 1, 3, 7, 600000.00, 395000.00, NULL, NULL, 3, 'COAT-ELIZABETH-GRY-L', 0, 1784213975, 1784213975);
INSERT INTO `product_price` VALUES (161, 1, 3, 8, 630000.00, 415000.00, NULL, NULL, 10, 'COAT-ELIZABETH-GRY-XL', 0, 1784213975, 1784213975);
INSERT INTO `product_price` VALUES (162, 12, 1, 5, 180000.00, 118000.00, NULL, NULL, 20, 'SWEATER-NAZNIN-BLK-S', 0, 1784213982, 1784213982);
INSERT INTO `product_price` VALUES (163, 12, 1, 6, 195000.00, 125000.00, 1784061000, 1786739400, 14, 'SWEATER-NAZNIN-BLK-M', 0, 1784213982, 1784213982);
INSERT INTO `product_price` VALUES (164, 12, 1, 7, 210000.00, 135000.00, NULL, NULL, 0, 'SWEATER-NAZNIN-BLK-L', 0, 1784213982, 1784213982);
INSERT INTO `product_price` VALUES (165, 12, 2, 5, 170000.00, 110000.00, NULL, NULL, 25, 'SWEATER-NAZNIN-WHT-S', 0, 1784213982, 1784213982);
INSERT INTO `product_price` VALUES (166, 12, 2, 6, 185000.00, 118000.00, NULL, NULL, 18, 'SWEATER-NAZNIN-WHT-M', 0, 1784213982, 1784213982);
INSERT INTO `product_price` VALUES (167, 12, 2, 7, 200000.00, 128000.00, NULL, NULL, 10, 'SWEATER-NAZNIN-WHT-L', 0, 1784213982, 1784213982);
INSERT INTO `product_price` VALUES (168, 12, 4, 5, 175000.00, 112000.00, NULL, NULL, 22, 'SWEATER-NAZNIN-BGE-S', 0, 1784213982, 1784213982);
INSERT INTO `product_price` VALUES (169, 12, 4, 6, 190000.00, 120000.00, NULL, NULL, 15, 'SWEATER-NAZNIN-BGE-M', 0, 1784213982, 1784213982);
INSERT INTO `product_price` VALUES (170, 12, 4, 7, 205000.00, 130000.00, NULL, NULL, 8, 'SWEATER-NAZNIN-BGE-L', 0, 1784213982, 1784213982);
INSERT INTO `product_price` VALUES (171, 13, 1, 5, 145000.00, 145000.00, NULL, NULL, 30, 'VEST-SHIVA-BLK-S', 0, 1784213986, 1784213986);
INSERT INTO `product_price` VALUES (172, 13, 1, 6, 160000.00, 102000.00, 1784061000, 1786739400, 22, 'VEST-SHIVA-BLK-M', 0, 1784213986, 1784213986);
INSERT INTO `product_price` VALUES (173, 13, 1, 7, 175000.00, 112000.00, NULL, NULL, 0, 'VEST-SHIVA-BLK-L', 0, 1784213986, 1784213986);
INSERT INTO `product_price` VALUES (174, 13, 3, 5, 140000.00, 90000.00, NULL, NULL, 35, 'VEST-SHIVA-GRY-S', 0, 1784213986, 1784213986);
INSERT INTO `product_price` VALUES (175, 13, 3, 6, 155000.00, 98000.00, NULL, NULL, 25, 'VEST-SHIVA-GRY-M', 0, 1784213986, 1784213986);
INSERT INTO `product_price` VALUES (176, 13, 3, 7, 170000.00, 108000.00, NULL, NULL, 15, 'VEST-SHIVA-GRY-L', 0, 1784213986, 1784213986);
INSERT INTO `product_price` VALUES (177, 14, 1, 5, 230000.00, 230000.00, NULL, NULL, 15, 'TROUSERS-MELIKA-BLK-S', 0, 1784213991, 1784213991);
INSERT INTO `product_price` VALUES (178, 14, 1, 6, 250000.00, 160000.00, 1784061000, 1786739400, 10, 'TROUSERS-MELIKA-BLK-M', 1, 1784213991, 1784213991);
INSERT INTO `product_price` VALUES (179, 14, 1, 7, 270000.00, 175000.00, NULL, NULL, 0, 'TROUSERS-MELIKA-BLK-L', 0, 1784213991, 1784213991);
INSERT INTO `product_price` VALUES (180, 14, 1, 8, 290000.00, 190000.00, NULL, NULL, 5, 'TROUSERS-MELIKA-BLK-XL', 0, 1784213991, 1784213991);
INSERT INTO `product_price` VALUES (181, 14, 3, 5, 220000.00, 145000.00, NULL, NULL, 18, 'TROUSERS-MELIKA-GRY-S', 0, 1784213991, 1784213991);
INSERT INTO `product_price` VALUES (182, 14, 3, 6, 240000.00, 155000.00, NULL, NULL, 12, 'TROUSERS-MELIKA-GRY-M', 0, 1784213991, 1784213991);
INSERT INTO `product_price` VALUES (183, 14, 3, 7, 260000.00, 168000.00, NULL, NULL, 8, 'TROUSERS-MELIKA-GRY-L', 0, 1784213991, 1784213991);
INSERT INTO `product_price` VALUES (184, 14, 3, 8, 280000.00, 182000.00, NULL, NULL, 3, 'TROUSERS-MELIKA-GRY-XL', 0, 1784213991, 1784213991);
INSERT INTO `product_price` VALUES (185, 14, 4, 5, 225000.00, 148000.00, NULL, NULL, 15, 'TROUSERS-MELIKA-BGE-S', 0, 1784213991, 1784213991);
INSERT INTO `product_price` VALUES (186, 14, 4, 6, 245000.00, 158000.00, NULL, NULL, 10, 'TROUSERS-MELIKA-BGE-M', 0, 1784213991, 1784213991);
INSERT INTO `product_price` VALUES (187, 14, 4, 7, 265000.00, 170000.00, NULL, NULL, 6, 'TROUSERS-MELIKA-BGE-L', 0, 1784213991, 1784213991);
INSERT INTO `product_price` VALUES (188, 14, 4, 8, 285000.00, 185000.00, NULL, NULL, 2, 'TROUSERS-MELIKA-BGE-XL', 0, 1784213991, 1784213991);
INSERT INTO `product_price` VALUES (189, 15, 1, 5, 160000.00, 160000.00, NULL, NULL, 28, 'FABRIC-YAS-BLK-S', 1, 1784213996, 1784213996);
INSERT INTO `product_price` VALUES (190, 15, 1, 6, 175000.00, 112000.00, 1784061000, 1786739400, 20, 'FABRIC-YAS-BLK-M', 0, 1784213996, 1784213996);
INSERT INTO `product_price` VALUES (191, 15, 1, 7, 190000.00, 122000.00, NULL, NULL, 0, 'FABRIC-YAS-BLK-L', 0, 1784213996, 1784213996);
INSERT INTO `product_price` VALUES (192, 15, 4, 5, 155000.00, 100000.00, NULL, NULL, 32, 'FABRIC-YAS-BGE-S', 0, 1784213996, 1784213996);
INSERT INTO `product_price` VALUES (193, 15, 4, 6, 170000.00, 108000.00, NULL, NULL, 22, 'FABRIC-YAS-BGE-M', 0, 1784213996, 1784213996);
INSERT INTO `product_price` VALUES (194, 15, 4, 7, 185000.00, 118000.00, NULL, NULL, 14, 'FABRIC-YAS-BGE-L', 0, 1784213996, 1784213996);
INSERT INTO `product_price` VALUES (195, 16, 1, 5, 100000.00, 80000.00, NULL, NULL, 50, 'LEGGINGS-ROUSHA-BLK-S', 0, 1784214000, 1784214000);
INSERT INTO `product_price` VALUES (196, 16, 1, 6, 90000.00, 58000.00, 1784061000, 1786739400, 35, 'LEGGINGS-ROUSHA-BLK-M', 0, 1784214000, 1784214000);
INSERT INTO `product_price` VALUES (197, 16, 1, 7, 100000.00, 65000.00, NULL, NULL, 0, 'LEGGINGS-ROUSHA-BLK-L', 0, 1784214000, 1784214000);
INSERT INTO `product_price` VALUES (198, 16, 3, 5, 75000.00, 48000.00, NULL, NULL, 55, 'LEGGINGS-ROUSHA-GRY-S', 0, 1784214000, 1784214000);
INSERT INTO `product_price` VALUES (199, 16, 3, 6, 85000.00, 54000.00, NULL, NULL, 40, 'LEGGINGS-ROUSHA-GRY-M', 0, 1784214000, 1784214000);
INSERT INTO `product_price` VALUES (200, 16, 3, 7, 95000.00, 60000.00, NULL, NULL, 28, 'LEGGINGS-ROUSHA-GRY-L', 0, 1784214000, 1784214000);
INSERT INTO `product_price` VALUES (201, 17, 1, 5, 220000.00, 182000.00, NULL, NULL, 12, 'KNIT-KAMYAR-BLK-S', 0, 1784214004, 1784214004);
INSERT INTO `product_price` VALUES (202, 17, 1, 6, 240000.00, 155000.00, 1784061000, 1786739400, 8, 'KNIT-KAMYAR-BLK-M', 0, 1784214004, 1784214004);
INSERT INTO `product_price` VALUES (203, 17, 1, 7, 260000.00, 168000.00, NULL, NULL, 0, 'KNIT-KAMYAR-BLK-L', 0, 1784214004, 1784214004);
INSERT INTO `product_price` VALUES (204, 17, 1, 8, 280000.00, 182000.00, NULL, NULL, 4, 'KNIT-KAMYAR-BLK-XL', 0, 1784214004, 1784214004);
INSERT INTO `product_price` VALUES (205, 17, 3, 5, 210000.00, 138000.00, NULL, NULL, 15, 'KNIT-KAMYAR-GRY-S', 0, 1784214004, 1784214004);
INSERT INTO `product_price` VALUES (206, 17, 3, 6, 230000.00, 148000.00, NULL, NULL, 10, 'KNIT-KAMYAR-GRY-M', 0, 1784214004, 1784214004);
INSERT INTO `product_price` VALUES (207, 17, 3, 7, 250000.00, 160000.00, NULL, NULL, 6, 'KNIT-KAMYAR-GRY-L', 0, 1784214004, 1784214004);
INSERT INTO `product_price` VALUES (208, 17, 3, 8, 270000.00, 175000.00, NULL, NULL, 2, 'KNIT-KAMYAR-GRY-XL', 0, 1784214004, 1784214004);
INSERT INTO `product_price` VALUES (209, 17, 4, 5, 215000.00, 140000.00, NULL, NULL, 12, 'KNIT-KAMYAR-BGE-S', 0, 1784214004, 1784214004);
INSERT INTO `product_price` VALUES (210, 17, 4, 6, 235000.00, 150000.00, NULL, NULL, 8, 'KNIT-KAMYAR-BGE-M', 0, 1784214004, 1784214004);
INSERT INTO `product_price` VALUES (211, 17, 4, 7, 255000.00, 162000.00, NULL, NULL, 4, 'KNIT-KAMYAR-BGE-L', 0, 1784214004, 1784214004);
INSERT INTO `product_price` VALUES (212, 17, 4, 8, 275000.00, 178000.00, NULL, NULL, 2, 'KNIT-KAMYAR-BGE-XL', 0, 1784214004, 1784214004);
INSERT INTO `product_price` VALUES (213, 18, 1, 5, 200000.00, 160000.00, NULL, NULL, 18, 'SWEATER-SINA-BLK-S', 0, 1784214086, 1784214086);
INSERT INTO `product_price` VALUES (214, 18, 1, 6, 215000.00, 140000.00, 1784061000, 1786739400, 12, 'SWEATER-SINA-BLK-M', 0, 1784214086, 1784214086);
INSERT INTO `product_price` VALUES (215, 18, 1, 7, 230000.00, 150000.00, NULL, NULL, 0, 'SWEATER-SINA-BLK-L', 0, 1784214086, 1784214086);
INSERT INTO `product_price` VALUES (216, 18, 1, 8, 245000.00, 160000.00, NULL, NULL, 6, 'SWEATER-SINA-BLK-XL', 0, 1784214086, 1784214086);
INSERT INTO `product_price` VALUES (217, 18, 2, 5, 190000.00, 125000.00, NULL, NULL, 22, 'SWEATER-SINA-WHT-S', 0, 1784214086, 1784214086);
INSERT INTO `product_price` VALUES (218, 18, 2, 6, 205000.00, 132000.00, NULL, NULL, 15, 'SWEATER-SINA-WHT-M', 0, 1784214086, 1784214086);
INSERT INTO `product_price` VALUES (219, 18, 2, 7, 220000.00, 142000.00, NULL, NULL, 8, 'SWEATER-SINA-WHT-L', 0, 1784214086, 1784214086);
INSERT INTO `product_price` VALUES (220, 18, 2, 8, 235000.00, 152000.00, NULL, NULL, 4, 'SWEATER-SINA-WHT-XL', 0, 1784214086, 1784214086);
INSERT INTO `product_price` VALUES (221, 18, 3, 5, 195000.00, 128000.00, NULL, NULL, 20, 'SWEATER-SINA-GRY-S', 0, 1784214086, 1784214086);
INSERT INTO `product_price` VALUES (222, 18, 3, 6, 210000.00, 135000.00, NULL, NULL, 14, 'SWEATER-SINA-GRY-M', 0, 1784214086, 1784214086);
INSERT INTO `product_price` VALUES (223, 18, 3, 7, 225000.00, 145000.00, NULL, NULL, 6, 'SWEATER-SINA-GRY-L', 0, 1784214086, 1784214086);
INSERT INTO `product_price` VALUES (224, 18, 3, 8, 240000.00, 155000.00, NULL, NULL, 3, 'SWEATER-SINA-GRY-XL', 0, 1784214086, 1784214086);
INSERT INTO `product_price` VALUES (225, 19, 1, 5, 350000.00, 275000.00, NULL, NULL, 10, 'JACKET-ARASH-BLK-S', 0, 1784214091, 1784214091);
INSERT INTO `product_price` VALUES (226, 19, 1, 6, 375000.00, 245000.00, 1784061000, 1786739400, 7, 'JACKET-ARASH-BLK-M', 0, 1784214091, 1784214091);
INSERT INTO `product_price` VALUES (227, 19, 1, 7, 400000.00, 260000.00, NULL, NULL, 0, 'JACKET-ARASH-BLK-L', 0, 1784214091, 1784214091);
INSERT INTO `product_price` VALUES (228, 19, 1, 8, 425000.00, 275000.00, NULL, NULL, 3, 'JACKET-ARASH-BLK-XL', 0, 1784214091, 1784214091);
INSERT INTO `product_price` VALUES (229, 19, 3, 5, 340000.00, 220000.00, NULL, NULL, 12, 'JACKET-ARASH-GRY-S', 0, 1784214091, 1784214091);
INSERT INTO `product_price` VALUES (230, 19, 3, 6, 365000.00, 235000.00, NULL, NULL, 8, 'JACKET-ARASH-GRY-M', 0, 1784214091, 1784214091);
INSERT INTO `product_price` VALUES (231, 19, 3, 7, 390000.00, 250000.00, NULL, NULL, 4, 'JACKET-ARASH-GRY-L', 0, 1784214091, 1784214091);
INSERT INTO `product_price` VALUES (232, 19, 3, 8, 415000.00, 268000.00, NULL, NULL, 2, 'JACKET-ARASH-GRY-XL', 0, 1784214091, 1784214091);
INSERT INTO `product_price` VALUES (233, 20, 1, 5, 180000.00, 145000.00, NULL, NULL, 20, 'SHIRT-BEHRAD-BLK-S', 1, 1784214095, 1784214095);
INSERT INTO `product_price` VALUES (234, 20, 1, 6, 195000.00, 125000.00, 1784061000, 1786739400, 14, 'SHIRT-BEHRAD-BLK-M', 0, 1784214095, 1784214095);
INSERT INTO `product_price` VALUES (235, 20, 1, 7, 210000.00, 135000.00, NULL, NULL, 0, 'SHIRT-BEHRAD-BLK-L', 0, 1784214095, 1784214095);
INSERT INTO `product_price` VALUES (236, 20, 1, 8, 225000.00, 145000.00, NULL, NULL, 6, 'SHIRT-BEHRAD-BLK-XL', 0, 1784214095, 1784214095);
INSERT INTO `product_price` VALUES (237, 20, 2, 5, 170000.00, 110000.00, NULL, NULL, 25, 'SHIRT-BEHRAD-WHT-S', 0, 1784214095, 1784214095);
INSERT INTO `product_price` VALUES (238, 20, 2, 6, 185000.00, 118000.00, NULL, NULL, 18, 'SHIRT-BEHRAD-WHT-M', 0, 1784214095, 1784214095);
INSERT INTO `product_price` VALUES (239, 20, 2, 7, 200000.00, 128000.00, NULL, NULL, 10, 'SHIRT-BEHRAD-WHT-L', 0, 1784214095, 1784214095);
INSERT INTO `product_price` VALUES (240, 20, 2, 8, 215000.00, 138000.00, NULL, NULL, 5, 'SHIRT-BEHRAD-WHT-XL', 0, 1784214095, 1784214095);
INSERT INTO `product_price` VALUES (241, 20, 4, 5, 175000.00, 112000.00, NULL, NULL, 22, 'SHIRT-BEHRAD-BGE-S', 0, 1784214095, 1784214095);
INSERT INTO `product_price` VALUES (242, 20, 4, 6, 190000.00, 120000.00, NULL, NULL, 15, 'SHIRT-BEHRAD-BGE-M', 0, 1784214095, 1784214095);
INSERT INTO `product_price` VALUES (243, 20, 4, 7, 205000.00, 130000.00, NULL, NULL, 8, 'SHIRT-BEHRAD-BGE-L', 0, 1784214095, 1784214095);
INSERT INTO `product_price` VALUES (244, 20, 4, 8, 220000.00, 140000.00, NULL, NULL, 4, 'SHIRT-BEHRAD-BGE-XL', 0, 1784214095, 1784214095);
INSERT INTO `product_price` VALUES (245, 21, 1, 5, 185000.00, 185000.00, NULL, NULL, 22, 'HOODIE-DARYUSH-BLK-S', 1, 1784214099, 1784214099);
INSERT INTO `product_price` VALUES (246, 21, 1, 6, 200000.00, 128000.00, 1784061000, 1786739400, 15, 'HOODIE-DARYUSH-BLK-M', 0, 1784214099, 1784214099);
INSERT INTO `product_price` VALUES (247, 21, 1, 7, 215000.00, 138000.00, NULL, NULL, 0, 'HOODIE-DARYUSH-BLK-L', 0, 1784214099, 1784214099);
INSERT INTO `product_price` VALUES (248, 21, 1, 8, 230000.00, 148000.00, NULL, NULL, 8, 'HOODIE-DARYUSH-BLK-XL', 0, 1784214099, 1784214099);
INSERT INTO `product_price` VALUES (249, 21, 3, 5, 175000.00, 112000.00, NULL, NULL, 28, 'HOODIE-DARYUSH-GRY-S', 0, 1784214099, 1784214099);
INSERT INTO `product_price` VALUES (250, 21, 3, 6, 190000.00, 120000.00, NULL, NULL, 20, 'HOODIE-DARYUSH-GRY-M', 0, 1784214099, 1784214099);
INSERT INTO `product_price` VALUES (251, 21, 3, 7, 205000.00, 130000.00, NULL, NULL, 12, 'HOODIE-DARYUSH-GRY-L', 0, 1784214099, 1784214099);
INSERT INTO `product_price` VALUES (252, 21, 3, 8, 220000.00, 140000.00, NULL, NULL, 6, 'HOODIE-DARYUSH-GRY-XL', 0, 1784214099, 1784214099);
INSERT INTO `product_price` VALUES (253, 22, 1, 5, 260000.00, 260000.00, NULL, NULL, 15, 'JEANS-PARSA-BLK-S', 0, 1784214104, 1784214104);
INSERT INTO `product_price` VALUES (254, 22, 1, 6, 280000.00, 180000.00, 1784061000, 1786739400, 10, 'JEANS-PARSA-BLK-M', 0, 1784214104, 1784214104);
INSERT INTO `product_price` VALUES (255, 22, 1, 7, 300000.00, 195000.00, NULL, NULL, 0, 'JEANS-PARSA-BLK-L', 0, 1784214104, 1784214104);
INSERT INTO `product_price` VALUES (256, 22, 1, 8, 320000.00, 210000.00, NULL, NULL, 5, 'JEANS-PARSA-BLK-XL', 0, 1784214104, 1784214104);
INSERT INTO `product_price` VALUES (257, 22, 3, 5, 250000.00, 165000.00, NULL, NULL, 18, 'JEANS-PARSA-GRY-S', 0, 1784214104, 1784214104);
INSERT INTO `product_price` VALUES (258, 22, 3, 6, 270000.00, 175000.00, NULL, NULL, 12, 'JEANS-PARSA-GRY-M', 0, 1784214104, 1784214104);
INSERT INTO `product_price` VALUES (259, 22, 3, 7, 290000.00, 188000.00, NULL, NULL, 8, 'JEANS-PARSA-GRY-L', 0, 1784214104, 1784214104);
INSERT INTO `product_price` VALUES (260, 22, 3, 8, 310000.00, 202000.00, NULL, NULL, 3, 'JEANS-PARSA-GRY-XL', 0, 1784214104, 1784214104);
INSERT INTO `product_price` VALUES (261, 23, 1, 5, 210000.00, 210000.00, NULL, NULL, 20, 'FABRIC-REZA-BLK-S', 1, 1784214108, 1784214108);
INSERT INTO `product_price` VALUES (262, 23, 1, 6, 230000.00, 148000.00, 1784061000, 1786739400, 14, 'FABRIC-REZA-BLK-M', 0, 1784214108, 1784214108);
INSERT INTO `product_price` VALUES (263, 23, 1, 7, 250000.00, 162000.00, NULL, NULL, 0, 'FABRIC-REZA-BLK-L', 0, 1784214108, 1784214108);
INSERT INTO `product_price` VALUES (264, 23, 1, 8, 270000.00, 175000.00, NULL, NULL, 6, 'FABRIC-REZA-BLK-XL', 0, 1784214108, 1784214108);
INSERT INTO `product_price` VALUES (265, 23, 4, 5, 200000.00, 130000.00, NULL, NULL, 25, 'FABRIC-REZA-BGE-S', 0, 1784214108, 1784214108);
INSERT INTO `product_price` VALUES (266, 23, 4, 6, 220000.00, 140000.00, NULL, NULL, 18, 'FABRIC-REZA-BGE-M', 0, 1784214108, 1784214108);
INSERT INTO `product_price` VALUES (267, 23, 4, 7, 240000.00, 155000.00, NULL, NULL, 10, 'FABRIC-REZA-BGE-L', 0, 1784214108, 1784214108);
INSERT INTO `product_price` VALUES (268, 23, 4, 8, 260000.00, 168000.00, NULL, NULL, 5, 'FABRIC-REZA-BGE-XL', 0, 1784214108, 1784214108);
INSERT INTO `product_price` VALUES (269, 24, 1, 5, 160000.00, 160000.00, NULL, NULL, 30, 'JOGGER-NAVID-BLK-S', 1, 1784214115, 1784214115);
INSERT INTO `product_price` VALUES (270, 24, 1, 6, 175000.00, 112000.00, 1784061000, 1786739400, 22, 'JOGGER-NAVID-BLK-M', 0, 1784214115, 1784214115);
INSERT INTO `product_price` VALUES (271, 24, 1, 7, 190000.00, 122000.00, NULL, NULL, 0, 'JOGGER-NAVID-BLK-L', 0, 1784214115, 1784214115);
INSERT INTO `product_price` VALUES (272, 24, 1, 8, 205000.00, 132000.00, NULL, NULL, 12, 'JOGGER-NAVID-BLK-XL', 0, 1784214115, 1784214115);
INSERT INTO `product_price` VALUES (273, 24, 3, 5, 150000.00, 98000.00, NULL, NULL, 35, 'JOGGER-NAVID-GRY-S', 0, 1784214115, 1784214115);
INSERT INTO `product_price` VALUES (274, 24, 3, 6, 165000.00, 105000.00, NULL, NULL, 25, 'JOGGER-NAVID-GRY-M', 0, 1784214115, 1784214115);
INSERT INTO `product_price` VALUES (275, 24, 3, 7, 180000.00, 115000.00, NULL, NULL, 16, 'JOGGER-NAVID-GRY-L', 0, 1784214115, 1784214115);
INSERT INTO `product_price` VALUES (276, 24, 3, 8, 195000.00, 125000.00, NULL, NULL, 8, 'JOGGER-NAVID-GRY-XL', 0, 1784214115, 1784214115);
INSERT INTO `product_price` VALUES (277, 25, 1, 5, 120000.00, 120000.00, NULL, NULL, 40, 'SHORTS-SAED-BLK-S', 0, 1784214119, 1784214119);
INSERT INTO `product_price` VALUES (278, 25, 1, 6, 135000.00, 88000.00, 1784061000, 1786739400, 30, 'SHORTS-SAED-BLK-M', 0, 1784214119, 1784214119);
INSERT INTO `product_price` VALUES (279, 25, 1, 7, 150000.00, 98000.00, NULL, NULL, 0, 'SHORTS-SAED-BLK-L', 0, 1784214119, 1784214119);
INSERT INTO `product_price` VALUES (280, 25, 3, 5, 115000.00, 75000.00, NULL, NULL, 45, 'SHORTS-SAED-GRY-S', 0, 1784214119, 1784214119);
INSERT INTO `product_price` VALUES (281, 25, 3, 6, 130000.00, 85000.00, NULL, NULL, 35, 'SHORTS-SAED-GRY-M', 0, 1784214119, 1784214119);
INSERT INTO `product_price` VALUES (282, 25, 3, 7, 145000.00, 94000.00, NULL, NULL, 22, 'SHORTS-SAED-GRY-L', 0, 1784214119, 1784214119);
INSERT INTO `product_price` VALUES (283, 25, 4, 5, 118000.00, 77000.00, NULL, NULL, 42, 'SHORTS-SAED-BGE-S', 0, 1784214119, 1784214119);
INSERT INTO `product_price` VALUES (284, 25, 4, 6, 133000.00, 86000.00, NULL, NULL, 32, 'SHORTS-SAED-BGE-M', 0, 1784214119, 1784214119);
INSERT INTO `product_price` VALUES (285, 25, 4, 7, 148000.00, 96000.00, NULL, NULL, 20, 'SHORTS-SAED-BGE-L', 0, 1784214119, 1784214119);
INSERT INTO `product_price` VALUES (286, 26, 1, 5, 103000.00, 72000.00, NULL, NULL, 50, 'TSHIRT-AMIR-BLK-S', 0, 1784214123, 1784214123);
INSERT INTO `product_price` VALUES (287, 26, 1, 6, 90000.00, 58000.00, 1784061000, 1786739400, 38, 'TSHIRT-AMIR-BLK-M', 0, 1784214123, 1784214123);
INSERT INTO `product_price` VALUES (288, 26, 1, 7, 100000.00, 65000.00, NULL, NULL, 0, 'TSHIRT-AMIR-BLK-L', 0, 1784214123, 1784214123);
INSERT INTO `product_price` VALUES (289, 26, 1, 8, 110000.00, 72000.00, NULL, NULL, 22, 'TSHIRT-AMIR-BLK-XL', 0, 1784214123, 1784214123);
INSERT INTO `product_price` VALUES (290, 26, 2, 5, 75000.00, 48000.00, NULL, NULL, 55, 'TSHIRT-AMIR-WHT-S', 0, 1784214123, 1784214123);
INSERT INTO `product_price` VALUES (291, 26, 2, 6, 85000.00, 54000.00, NULL, NULL, 42, 'TSHIRT-AMIR-WHT-M', 0, 1784214123, 1784214123);
INSERT INTO `product_price` VALUES (292, 26, 2, 7, 95000.00, 60000.00, NULL, NULL, 28, 'TSHIRT-AMIR-WHT-L', 0, 1784214123, 1784214123);
INSERT INTO `product_price` VALUES (293, 26, 2, 8, 105000.00, 68000.00, NULL, NULL, 15, 'TSHIRT-AMIR-WHT-XL', 0, 1784214123, 1784214123);
INSERT INTO `product_price` VALUES (294, 26, 3, 5, 78000.00, 50000.00, NULL, NULL, 48, 'TSHIRT-AMIR-GRY-S', 0, 1784214123, 1784214123);
INSERT INTO `product_price` VALUES (295, 26, 3, 6, 88000.00, 56000.00, NULL, NULL, 36, 'TSHIRT-AMIR-GRY-M', 0, 1784214123, 1784214123);
INSERT INTO `product_price` VALUES (296, 26, 3, 7, 98000.00, 62000.00, NULL, NULL, 24, 'TSHIRT-AMIR-GRY-L', 0, 1784214123, 1784214123);
INSERT INTO `product_price` VALUES (297, 26, 3, 8, 108000.00, 70000.00, NULL, NULL, 12, 'TSHIRT-AMIR-GRY-XL', 0, 1784214123, 1784214123);
INSERT INTO `product_price` VALUES (298, 26, 4, 5, 77000.00, 49000.00, NULL, NULL, 50, 'TSHIRT-AMIR-BGE-S', 0, 1784214123, 1784214123);
INSERT INTO `product_price` VALUES (299, 26, 4, 6, 87000.00, 55000.00, NULL, NULL, 38, 'TSHIRT-AMIR-BGE-M', 0, 1784214123, 1784214123);
INSERT INTO `product_price` VALUES (300, 26, 4, 7, 97000.00, 61000.00, NULL, NULL, 25, 'TSHIRT-AMIR-BGE-L', 0, 1784214123, 1784214123);
INSERT INTO `product_price` VALUES (301, 26, 4, 8, 107000.00, 69000.00, NULL, NULL, 14, 'TSHIRT-AMIR-BGE-XL', 0, 1784214123, 1784214123);
INSERT INTO `product_price` VALUES (302, 27, 1, 5, 280000.00, 280000.00, NULL, NULL, 12, 'SET-ALI-BLK-S', 0, 1784214127, 1784214127);
INSERT INTO `product_price` VALUES (303, 27, 1, 6, 300000.00, 195000.00, 1784061000, 1786739400, 8, 'SET-ALI-BLK-M', 0, 1784214127, 1784214127);
INSERT INTO `product_price` VALUES (304, 27, 1, 7, 320000.00, 208000.00, NULL, NULL, 0, 'SET-ALI-BLK-L', 0, 1784214127, 1784214127);
INSERT INTO `product_price` VALUES (305, 27, 1, 8, 340000.00, 220000.00, NULL, NULL, 4, 'SET-ALI-BLK-XL', 0, 1784214127, 1784214127);
INSERT INTO `product_price` VALUES (306, 27, 3, 5, 270000.00, 175000.00, NULL, NULL, 15, 'SET-ALI-GRY-S', 0, 1784214127, 1784214127);
INSERT INTO `product_price` VALUES (307, 27, 3, 6, 290000.00, 188000.00, NULL, NULL, 10, 'SET-ALI-GRY-M', 0, 1784214127, 1784214127);
INSERT INTO `product_price` VALUES (308, 27, 3, 7, 310000.00, 200000.00, NULL, NULL, 6, 'SET-ALI-GRY-L', 0, 1784214127, 1784214127);
INSERT INTO `product_price` VALUES (309, 27, 3, 8, 330000.00, 215000.00, NULL, NULL, 3, 'SET-ALI-GRY-XL', 0, 1784214127, 1784214127);
INSERT INTO `product_price` VALUES (310, 28, 1, 5, 170000.00, 170000.00, NULL, NULL, 22, 'LS-HASAN-BLK-S', 0, 1784214131, 1784214131);
INSERT INTO `product_price` VALUES (311, 28, 1, 6, 185000.00, 118000.00, 1784061000, 1786739400, 15, 'LS-HASAN-BLK-M', 0, 1784214131, 1784214131);
INSERT INTO `product_price` VALUES (312, 28, 1, 7, 200000.00, 128000.00, NULL, NULL, 0, 'LS-HASAN-BLK-L', 0, 1784214131, 1784214131);
INSERT INTO `product_price` VALUES (313, 28, 1, 8, 215000.00, 138000.00, NULL, NULL, 8, 'LS-HASAN-BLK-XL', 0, 1784214131, 1784214131);
INSERT INTO `product_price` VALUES (314, 28, 2, 5, 160000.00, 102000.00, NULL, NULL, 28, 'LS-HASAN-WHT-S', 0, 1784214131, 1784214131);
INSERT INTO `product_price` VALUES (315, 28, 2, 6, 175000.00, 112000.00, NULL, NULL, 20, 'LS-HASAN-WHT-M', 0, 1784214131, 1784214131);
INSERT INTO `product_price` VALUES (316, 28, 2, 7, 190000.00, 122000.00, NULL, NULL, 12, 'LS-HASAN-WHT-L', 0, 1784214131, 1784214131);
INSERT INTO `product_price` VALUES (317, 28, 2, 8, 205000.00, 132000.00, NULL, NULL, 6, 'LS-HASAN-WHT-XL', 0, 1784214131, 1784214131);
INSERT INTO `product_price` VALUES (318, 28, 3, 5, 165000.00, 105000.00, NULL, NULL, 25, 'LS-HASAN-GRY-S', 0, 1784214131, 1784214131);
INSERT INTO `product_price` VALUES (319, 28, 3, 6, 180000.00, 115000.00, NULL, NULL, 18, 'LS-HASAN-GRY-M', 0, 1784214131, 1784214131);
INSERT INTO `product_price` VALUES (320, 28, 3, 7, 195000.00, 125000.00, NULL, NULL, 10, 'LS-HASAN-GRY-L', 0, 1784214131, 1784214131);
INSERT INTO `product_price` VALUES (321, 28, 3, 8, 210000.00, 135000.00, NULL, NULL, 4, 'LS-HASAN-GRY-XL', 0, 1784214131, 1784214131);
INSERT INTO `product_price` VALUES (322, 29, 1, 5, 60000.00, 60000.00, NULL, NULL, 60, 'HAT-MAJID-BLK-S', 0, 1784214134, 1784214134);
INSERT INTO `product_price` VALUES (323, 29, 1, 6, 70000.00, 45000.00, 1784061000, 1786739400, 45, 'HAT-MAJID-BLK-M', 0, 1784214134, 1784214134);
INSERT INTO `product_price` VALUES (324, 29, 1, 7, 80000.00, 52000.00, NULL, NULL, 0, 'HAT-MAJID-BLK-L', 0, 1784214134, 1784214134);
INSERT INTO `product_price` VALUES (325, 29, 2, 5, 55000.00, 35000.00, NULL, NULL, 70, 'HAT-MAJID-WHT-S', 0, 1784214134, 1784214134);
INSERT INTO `product_price` VALUES (326, 29, 2, 6, 65000.00, 42000.00, NULL, NULL, 50, 'HAT-MAJID-WHT-M', 0, 1784214134, 1784214134);
INSERT INTO `product_price` VALUES (327, 29, 2, 7, 75000.00, 48000.00, NULL, NULL, 35, 'HAT-MAJID-WHT-L', 0, 1784214134, 1784214134);
INSERT INTO `product_price` VALUES (328, 29, 3, 5, 58000.00, 38000.00, NULL, NULL, 65, 'HAT-MAJID-GRY-S', 0, 1784214134, 1784214134);
INSERT INTO `product_price` VALUES (329, 29, 3, 6, 68000.00, 44000.00, NULL, NULL, 48, 'HAT-MAJID-GRY-M', 0, 1784214134, 1784214134);
INSERT INTO `product_price` VALUES (330, 29, 3, 7, 78000.00, 50000.00, NULL, NULL, 32, 'HAT-MAJID-GRY-L', 0, 1784214134, 1784214134);
INSERT INTO `product_price` VALUES (331, 30, 1, 5, 40000.00, 40000.00, NULL, NULL, 100, 'SOCKS-KARIM-BLK-S', 0, 1784214137, 1784214137);
INSERT INTO `product_price` VALUES (332, 30, 1, 6, 45000.00, 29000.00, 1784061000, 1786739400, 80, 'SOCKS-KARIM-BLK-M', 0, 1784214137, 1784214137);
INSERT INTO `product_price` VALUES (333, 30, 1, 7, 50000.00, 32000.00, NULL, NULL, 0, 'SOCKS-KARIM-BLK-L', 0, 1784214137, 1784214137);
INSERT INTO `product_price` VALUES (334, 30, 2, 5, 38000.00, 24000.00, NULL, NULL, 120, 'SOCKS-KARIM-WHT-S', 0, 1784214137, 1784214137);
INSERT INTO `product_price` VALUES (335, 30, 2, 6, 43000.00, 28000.00, NULL, NULL, 90, 'SOCKS-KARIM-WHT-M', 0, 1784214137, 1784214137);
INSERT INTO `product_price` VALUES (336, 30, 2, 7, 48000.00, 31000.00, NULL, NULL, 60, 'SOCKS-KARIM-WHT-L', 0, 1784214137, 1784214137);
INSERT INTO `product_price` VALUES (337, 30, 3, 5, 39000.00, 25000.00, NULL, NULL, 110, 'SOCKS-KARIM-GRY-S', 0, 1784214137, 1784214137);
INSERT INTO `product_price` VALUES (338, 30, 3, 6, 44000.00, 28500.00, NULL, NULL, 85, 'SOCKS-KARIM-GRY-M', 0, 1784214137, 1784214137);
INSERT INTO `product_price` VALUES (339, 30, 3, 7, 49000.00, 31500.00, NULL, NULL, 55, 'SOCKS-KARIM-GRY-L', 0, 1784214137, 1784214137);
INSERT INTO `product_price` VALUES (340, 31, 1, 5, 150000.00, 150000.00, NULL, NULL, 25, 'BELT-FARHAD-BLK-S', 0, 1784214141, 1784214141);
INSERT INTO `product_price` VALUES (341, 31, 1, 6, 165000.00, 105000.00, 1784061000, 1786739400, 18, 'BELT-FARHAD-BLK-M', 0, 1784214141, 1784214141);
INSERT INTO `product_price` VALUES (342, 31, 1, 7, 180000.00, 115000.00, NULL, NULL, 0, 'BELT-FARHAD-BLK-L', 0, 1784214141, 1784214141);
INSERT INTO `product_price` VALUES (343, 31, 3, 5, 145000.00, 92000.00, NULL, NULL, 30, 'BELT-FARHAD-GRY-S', 0, 1784214141, 1784214141);
INSERT INTO `product_price` VALUES (344, 31, 3, 6, 160000.00, 102000.00, NULL, NULL, 22, 'BELT-FARHAD-GRY-M', 0, 1784214141, 1784214141);
INSERT INTO `product_price` VALUES (345, 31, 3, 7, 175000.00, 112000.00, NULL, NULL, 14, 'BELT-FARHAD-GRY-L', 0, 1784214141, 1784214141);

-- ----------------------------
-- Table structure for shipping_price
-- ----------------------------
DROP TABLE IF EXISTS `shipping_price`;
CREATE TABLE `shipping_price`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `shipping_type_id` int UNSIGNED NOT NULL,
  `city_id` int UNSIGNED NOT NULL,
  `price` decimal(15, 2) NOT NULL,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `unique_shipping_city`(`shipping_type_id` ASC, `city_id` ASC) USING BTREE,
  INDEX `idx_shipping_type_id`(`shipping_type_id` ASC) USING BTREE,
  INDEX `idx_city_id`(`city_id` ASC) USING BTREE,
  CONSTRAINT `fk_shipping_price_city` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `fk_shipping_price_type` FOREIGN KEY (`shipping_type_id`) REFERENCES `shipping_type` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of shipping_price
-- ----------------------------

-- ----------------------------
-- Table structure for shipping_type
-- ----------------------------
DROP TABLE IF EXISTS `shipping_type`;
CREATE TABLE `shipping_type`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int NOT NULL DEFAULT 0,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of shipping_type
-- ----------------------------
INSERT INTO `shipping_type` VALUES (1, 'پست پیشتاز', 1, 1783643313, 1783643313);
INSERT INTO `shipping_type` VALUES (2, 'تیپاکس', 2, 1783643313, 1783643313);

-- ----------------------------
-- Table structure for state
-- ----------------------------
DROP TABLE IF EXISTS `state`;
CREATE TABLE `state`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int NOT NULL DEFAULT 0,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 32 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of state
-- ----------------------------
INSERT INTO `state` VALUES (1, 'مرکزی', 0, 0, 0);
INSERT INTO `state` VALUES (2, 'گیلان', 0, 0, 0);
INSERT INTO `state` VALUES (3, 'مازندران', 0, 0, 0);
INSERT INTO `state` VALUES (4, 'آذربایجان شرقی', 0, 0, 0);
INSERT INTO `state` VALUES (5, 'آذربایجان غربی', 0, 0, 0);
INSERT INTO `state` VALUES (6, 'کرمانشاه', 0, 0, 0);
INSERT INTO `state` VALUES (7, 'خوزستان', 0, 0, 0);
INSERT INTO `state` VALUES (8, 'فارس', 0, 0, 0);
INSERT INTO `state` VALUES (9, 'کرمان', 0, 0, 0);
INSERT INTO `state` VALUES (10, 'خراسان رضوی', 0, 0, 0);
INSERT INTO `state` VALUES (11, 'اصفهان', 0, 0, 0);
INSERT INTO `state` VALUES (12, 'سیستان و بلوچستان', 0, 0, 0);
INSERT INTO `state` VALUES (13, 'کردستان', 0, 0, 0);
INSERT INTO `state` VALUES (14, 'همدان', 0, 0, 0);
INSERT INTO `state` VALUES (15, 'چهارمحال و بختیاری', 0, 0, 0);
INSERT INTO `state` VALUES (16, 'لرستان', 0, 0, 0);
INSERT INTO `state` VALUES (17, 'ایلام', 0, 0, 0);
INSERT INTO `state` VALUES (18, 'کهگیلویه و بویراحمد', 0, 0, 0);
INSERT INTO `state` VALUES (19, 'بوشهر', 0, 0, 0);
INSERT INTO `state` VALUES (20, 'زنجان', 0, 0, 0);
INSERT INTO `state` VALUES (21, 'سمنان', 0, 0, 0);
INSERT INTO `state` VALUES (22, 'یزد', 0, 0, 0);
INSERT INTO `state` VALUES (23, 'هرمزگان', 0, 0, 0);
INSERT INTO `state` VALUES (24, 'تهران', 0, 0, 0);
INSERT INTO `state` VALUES (25, 'اردبیل', 0, 0, 0);
INSERT INTO `state` VALUES (26, 'قم', 0, 0, 0);
INSERT INTO `state` VALUES (27, 'قزوین', 0, 0, 0);
INSERT INTO `state` VALUES (28, 'گلستان', 0, 0, 0);
INSERT INTO `state` VALUES (29, 'خراسان شمالی', 0, 0, 0);
INSERT INTO `state` VALUES (30, 'خراسان جنوبی', 0, 0, 0);
INSERT INTO `state` VALUES (31, 'البرز', 0, 0, 0);

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
INSERT INTO `user` VALUES (1, 'admin', '123456', 'محمد ایران نژاد', 'admin', 1784598101, 'assets/images/user/profile-img-2.jpg', 1, 0, 1784598101);

SET FOREIGN_KEY_CHECKS = 1;
