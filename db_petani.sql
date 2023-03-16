/*
 Navicat Premium Data Transfer

 Source Server         : lnpp-8-mysql
 Source Server Type    : MySQL
 Source Server Version : 50722
 Source Host           : 17.17.17.5:3306
 Source Schema         : db_petani

 Target Server Type    : MySQL
 Target Server Version : 50722
 File Encoding         : 65001

 Date: 16/03/2023 13:58:30
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for data_kriteria
-- ----------------------------
DROP TABLE IF EXISTS `data_kriteria`;
CREATE TABLE `data_kriteria` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `id_petani` int(255) NOT NULL,
  `luas_lahan` int(255) NOT NULL,
  `penghasilan` int(255) NOT NULL,
  `hasil_panen` int(255) NOT NULL,
  `lama_usaha_tani` int(255) NOT NULL,
  `jmlh_anggota_keluarga` int(255) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `data_kriteria_id_petani_foreign` (`id_petani`),
  CONSTRAINT `data_kriteria_id_petani_foreign` FOREIGN KEY (`id_petani`) REFERENCES `data_petani` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for data_petani
-- ----------------------------
DROP TABLE IF EXISTS `data_petani`;
CREATE TABLE `data_petani` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_petani` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_petani` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_ktp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_pemohonan` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for hasil
-- ----------------------------
DROP TABLE IF EXISTS `hasil`;
CREATE TABLE `hasil` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `id_petani` int(255) NOT NULL,
  `nilai_akhir` decimal(65,4) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `hasil_user_id_foreign` (`id_petani`),
  CONSTRAINT `hasil_user_id_foreign` FOREIGN KEY (`id_petani`) REFERENCES `data_petani` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=617 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for settings
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `luas_lahan` decimal(65,4) NOT NULL,
  `penghasilan` decimal(65,4) NOT NULL,
  `hasil_panen` decimal(65,4) NOT NULL,
  `lama_usaha_tani` decimal(65,4) NOT NULL,
  `jmlh_anggota_keluarga` decimal(65,4) NOT NULL,
  `v` decimal(65,4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
