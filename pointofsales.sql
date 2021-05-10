-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 30 Apr 2021 pada 03.48
-- Versi server: 10.4.14-MariaDB
-- Versi PHP: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pointofsales`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `brand`
--

CREATE TABLE `brand` (
  `id_brand` int(11) NOT NULL,
  `nama_brand` varchar(100) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `brand`
--

INSERT INTO `brand` (`id_brand`, `nama_brand`, `created`, `updated`) VALUES
(1, 'Wardah', '2021-04-06 16:33:21', NULL),
(2, 'Make Over', '2021-04-06 16:33:21', NULL),
(7, 'Emina', '2021-04-06 16:33:21', NULL),
(9, 'Viva', '2021-04-06 16:33:21', NULL),
(10, 'Y.O.U', '2021-04-06 16:33:21', NULL),
(11, 'Maybelline', '2021-04-06 16:33:21', NULL),
(13, 'Safi', '2021-04-06 16:33:21', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `customer`
--

CREATE TABLE `customer` (
  `id_customer` int(11) NOT NULL,
  `nama_customer` varchar(100) NOT NULL,
  `gender` enum('L','P') NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `alamat` text NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `customer`
--

INSERT INTO `customer` (`id_customer`, `nama_customer`, `gender`, `no_hp`, `alamat`, `created`, `updated`) VALUES
(1, 'sdsggh', 'L', '08617258263', 'Bekasi', '2021-04-07 06:06:57', '2021-04-07 01:11:17'),
(2, 'Ani', 'P', '0812567834', 'Bekasi Timur Regensi ', '2021-04-07 06:09:13', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis`
--

CREATE TABLE `jenis` (
  `id_jenis` int(11) NOT NULL,
  `nama_jenis` varchar(100) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jenis`
--

INSERT INTO `jenis` (`id_jenis`, `nama_jenis`, `created`, `updated`) VALUES
(1, 'Bedak', '2021-04-06 16:32:36', NULL),
(2, 'Maskara', '2021-04-06 16:32:36', NULL),
(7, 'Lipstik', '2021-04-06 16:32:36', NULL),
(9, 'Foundation', '2021-04-06 16:32:36', NULL),
(10, 'Eyeliner', '2021-04-06 16:32:36', NULL),
(11, 'Eyeshadow', '2021-04-06 16:32:36', NULL),
(12, 'Pensil Alis', '2021-04-06 16:32:36', NULL),
(13, 'Pelembab', '2021-04-06 16:32:36', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `invoice` varchar(50) NOT NULL,
  `harga_total` int(11) NOT NULL,
  `diskon` int(11) NOT NULL,
  `final_harga` int(11) NOT NULL,
  `cash` int(11) NOT NULL,
  `kembali` int(11) NOT NULL,
  `note` text NOT NULL,
  `date` date NOT NULL,
  `id_user` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan_detail`
--

CREATE TABLE `penjualan_detail` (
  `id_detail` int(11) NOT NULL,
  `id_penjualan` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `diskon_item` int(11) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `barcode` varchar(100) DEFAULT NULL,
  `nama_produk` varchar(100) DEFAULT NULL,
  `id_brand` int(11) NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `harga` int(11) DEFAULT NULL,
  `stock` int(10) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id_produk`, `barcode`, `nama_produk`, `id_brand`, `id_jenis`, `harga`, `stock`, `created`, `updated`) VALUES
(3, 'A002', 'Bedak Wardah 06', 1, 1, 20000, 100, '2021-04-06 16:34:04', NULL),
(6, 'A003', 'Emina compact powder No.03', 7, 9, 45000, 140, '2021-04-06 16:34:04', NULL),
(7, 'A004', 'Compact', 2, 1, 35000, 150, '2021-04-06 16:34:04', NULL),
(8, 'B001', 'Emina Liptin 03', 7, 7, 45000, 0, '2021-04-12 14:44:55', '2021-04-12 09:45:15'),
(9, 'A001', 'Wardah Two a cake', 1, 1, 55000, 0, '2021-04-12 19:15:48', NULL),
(10, 'B002', 'hjk', 2, 2, 50000, 100, '2021-04-23 13:24:04', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `stock`
--

CREATE TABLE `stock` (
  `id_stock` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `type` enum('in','out') NOT NULL,
  `detail` varchar(200) NOT NULL,
  `id_supplier` int(11) DEFAULT NULL,
  `qty` int(10) NOT NULL,
  `date` date NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `id_user` int(11) NOT NULL,
  `info` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `stock`
--

INSERT INTO `stock` (`id_stock`, `id_produk`, `type`, `detail`, `id_supplier`, `qty`, `date`, `created`, `id_user`, `info`) VALUES
(3, 3, 'in', 'Kulakan', 2, 100, '2021-04-07', '2021-04-07 12:37:28', 1, ''),
(4, 6, 'in', 'Kulakan', NULL, 150, '2021-04-07', '2021-04-07 12:45:49', 1, ''),
(7, 7, 'in', 'Kulakan', NULL, 50, '2021-04-08', '2021-04-08 05:40:31', 1, ''),
(9, 7, 'in', 'Tambahan', 1, 100, '2021-04-12', '2021-04-12 14:40:37', 1, ''),
(14, 8, 'in', 'Kulakan', 1, 10, '2021-04-12', '2021-04-12 19:16:40', 1, ''),
(18, 7, 'in', 'Tambahan', NULL, 150, '2021-04-19', '2021-04-19 10:12:46', 1, ''),
(20, 10, 'in', 'Tambahan', 1, 100, '2021-04-27', '2021-04-27 12:25:41', 1, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama_supplier` varchar(100) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `no_hp`, `alamat`, `deskripsi`, `created`, `updated`) VALUES
(1, 'PT Paragon ', '081256783569', 'Setu, Bekasi', 'PT. Kosmetik', '2021-04-06 21:11:41', '2021-04-07 00:35:43'),
(2, 'PT. Jaya Makmur', '089625189251', 'Bogor', 'Toko Kosmetik Lokal', '2021-04-06 21:11:41', NULL),
(5, 'Toko ABC', '021567892', 'Jakarta', NULL, '2021-04-07 05:22:36', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(50) NOT NULL,
  `email` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `hak_akses` int(11) NOT NULL COMMENT '1;admin,2;kasir',
  `status_user` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_user`
--

INSERT INTO `tbl_user` (`id_user`, `nama_user`, `email`, `password`, `hak_akses`, `status_user`, `created`, `updated`) VALUES
(1, 'Seno', 'seno@gmail.com', 'seno123', 1, 1, '2021-04-06 16:34:37', NULL),
(2, 'susi', 'susi@gmail.com', 'susi123', 2, 1, '2021-04-06 16:34:37', NULL),
(7, 'kasir1', 'kasir1@gmail.com', 'kasir123', 2, 1, '2021-04-06 16:34:37', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id_brand`);

--
-- Indeks untuk tabel `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id_customer`);

--
-- Indeks untuk tabel `jenis`
--
ALTER TABLE `jenis`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indeks untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`);

--
-- Indeks untuk tabel `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  ADD PRIMARY KEY (`id_detail`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD UNIQUE KEY `barcode` (`barcode`),
  ADD KEY `id_brand` (`id_brand`),
  ADD KEY `id_jenis` (`id_jenis`);

--
-- Indeks untuk tabel `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id_stock`),
  ADD KEY `id_produk` (`id_produk`),
  ADD KEY `id_supplier` (`id_supplier`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indeks untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `brand`
--
ALTER TABLE `brand`
  MODIFY `id_brand` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `customer`
--
ALTER TABLE `customer`
  MODIFY `id_customer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `jenis`
--
ALTER TABLE `jenis`
  MODIFY `id_jenis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `stock`
--
ALTER TABLE `stock`
  MODIFY `id_stock` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`id_jenis`) REFERENCES `jenis` (`id_jenis`),
  ADD CONSTRAINT `produk_ibfk_2` FOREIGN KEY (`id_brand`) REFERENCES `brand` (`id_brand`);

--
-- Ketidakleluasaan untuk tabel `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stock_ibfk_2` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`),
  ADD CONSTRAINT `stock_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `tbl_user` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
