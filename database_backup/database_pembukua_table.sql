/*
SQLyog Job Agent v12.5.1 (64 bit) Copyright(c) Webyog Inc. All Rights Reserved.


MySQL - 10.4.19-MariaDB : Database - pembukuan_palkes
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`pembukuan_palkes` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `pembukuan_palkes`;

/*Table structure for table `anggota_keluar` */

DROP TABLE IF EXISTS `anggota_keluar`;

CREATE TABLE `anggota_keluar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_anggota` varchar(30) DEFAULT NULL,
  `jumlah_simpanan` int(11) DEFAULT NULL,
  `link_form_keluar` text DEFAULT NULL,
  `link_bukti_kirim` text DEFAULT NULL,
  `insert_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `no_anggota` (`no_anggota`),
  CONSTRAINT `anggota_keluar_ibfk_1` FOREIGN KEY (`no_anggota`) REFERENCES `anggota_masuk` (`no_anggota`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `anggota_masuk` */

DROP TABLE IF EXISTS `anggota_masuk`;

CREATE TABLE `anggota_masuk` (
  `no_anggota` varchar(30) NOT NULL,
  `nama_anggota` varchar(255) NOT NULL,
  `nik` varchar(255) NOT NULL,
  `no_npwp` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `agama` varchar(30) DEFAULT NULL,
  `jenis_kelamin` char(1) DEFAULT NULL,
  `unit` varchar(50) NOT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `link_ktp` text DEFAULT NULL,
  `link_npwp` text DEFAULT NULL,
  `link_foto` text DEFAULT NULL,
  `link_formulir` text DEFAULT NULL,
  `insert_date` datetime DEFAULT NULL,
  PRIMARY KEY (`no_anggota`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `belanja_operasional` */

DROP TABLE IF EXISTS `belanja_operasional`;

CREATE TABLE `belanja_operasional` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `insert_date` datetime DEFAULT NULL,
  `kode_transaksi` varchar(255) DEFAULT NULL,
  `uraian_belanja` text DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `link_kwitansi` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `pembayaran_anggota_keluar` */

DROP TABLE IF EXISTS `pembayaran_anggota_keluar`;

CREATE TABLE `pembayaran_anggota_keluar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_anggota` varchar(30) DEFAULT NULL,
  `insert_date` datetime DEFAULT NULL,
  `kode_transaksi` varchar(255) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `link_pembayaran_anggota_keluar` text DEFAULT NULL,
  `link_bukti_bayar` text DEFAULT NULL,
  `folder` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `no_anggota` (`no_anggota`),
  CONSTRAINT `pembayaran_anggota_keluar_ibfk_1` FOREIGN KEY (`no_anggota`) REFERENCES `anggota_masuk` (`no_anggota`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `pembayaran_lainnya` */

DROP TABLE IF EXISTS `pembayaran_lainnya`;

CREATE TABLE `pembayaran_lainnya` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_kwitansi_penerimaan` varchar(255) DEFAULT NULL,
  `uraian` text DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `insert_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `pembayaran_pajak` */

DROP TABLE IF EXISTS `pembayaran_pajak`;

CREATE TABLE `pembayaran_pajak` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `insert_date` datetime DEFAULT NULL,
  `jenis_pajak` varchar(255) DEFAULT NULL,
  `kode_transaksi` varchar(255) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `link_bill_pajak` text DEFAULT NULL,
  `link_bukti_bayar` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `pembayaran_pinjam` */

DROP TABLE IF EXISTS `pembayaran_pinjam`;

CREATE TABLE `pembayaran_pinjam` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` datetime DEFAULT NULL,
  `no_anggota` varchar(30) NOT NULL,
  `pembayaran_bulan` date DEFAULT NULL,
  `pokok_pinjaman` int(11) DEFAULT NULL,
  `ujrah` int(11) DEFAULT NULL,
  `bagi_hasil` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `no_anggota` (`no_anggota`),
  CONSTRAINT `pembayaran_pinjam_ibfk_1` FOREIGN KEY (`no_anggota`) REFERENCES `anggota_masuk` (`no_anggota`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `pembayaran_pinjaman_anggota` */

DROP TABLE IF EXISTS `pembayaran_pinjaman_anggota`;

CREATE TABLE `pembayaran_pinjaman_anggota` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `insert_date` datetime DEFAULT NULL,
  `kode_transaksi` varchar(255) DEFAULT NULL,
  `no_anggota` varchar(30) DEFAULT NULL,
  `lama_pinjaman` varchar(255) DEFAULT NULL,
  `jumlah_pinjaman` int(11) DEFAULT NULL,
  `link_formulir` text DEFAULT NULL,
  `link_bukti_bayar` text DEFAULT NULL,
  `folder` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `no_anggota` (`no_anggota`),
  CONSTRAINT `pembayaran_pinjaman_anggota_ibfk_1` FOREIGN KEY (`no_anggota`) REFERENCES `anggota_masuk` (`no_anggota`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `rekap_anggota` */

DROP TABLE IF EXISTS `rekap_anggota`;

CREATE TABLE `rekap_anggota` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_anggota` varchar(30) DEFAULT NULL,
  `status` varchar(15) DEFAULT NULL,
  `insert_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `no_anggota` (`no_anggota`),
  CONSTRAINT `rekap_anggota_ibfk_1` FOREIGN KEY (`no_anggota`) REFERENCES `anggota_masuk` (`no_anggota`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `simpanan_anggota` */

DROP TABLE IF EXISTS `simpanan_anggota`;

CREATE TABLE `simpanan_anggota` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` datetime DEFAULT NULL,
  `no_anggota` varchar(30) DEFAULT NULL,
  `simpanan_pokok` int(11) DEFAULT NULL,
  `simpanan_wajib` int(11) DEFAULT NULL,
  `simpanan_sukarela` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `no_anggota` (`no_anggota`),
  CONSTRAINT `simpanan_anggota_ibfk_1` FOREIGN KEY (`no_anggota`) REFERENCES `anggota_masuk` (`no_anggota`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
