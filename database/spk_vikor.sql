-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 19 Agu 2024 pada 18.24
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spk_vikor`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `alternatif`
--

CREATE TABLE `alternatif` (
  `id_alternatif` int(11) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jk` varchar(20) NOT NULL,
  `nohp` varchar(15) NOT NULL,
  `alamat` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `alternatif`
--

INSERT INTO `alternatif` (`id_alternatif`, `nis`, `nama`, `jk`, `nohp`, `alamat`) VALUES
(1, '18101152610510', 'Nur Aini Pertiwi', 'Wanita', '08989089080', 'padang'),
(2, '18101152610511', 'Nanda Wira Andika', 'Pria', '08877787987', 'padang'),
(3, '18101152610512', 'Fitri Anggraini', 'Wanita', '9843920404', 'Padang'),
(4, '18101152610514', 'M. Yasir', 'Pria', '898908908', 'padang'),
(5, '18101152610515', 'Syahyudi Tanjung', 'Pria', '08203482034', 'Padang'),
(6, '181152610516', 'Alhabib Husein', 'Pria', '809890890', 'padang'),
(7, '18101152610516', 'Zahwatul Khairi', 'Wanita', '080802802', 'Padang'),
(8, '18101152610518', 'Tio Rafanza', 'Pria', '0808204820', 'Padang'),
(9, '18101152610519', 'Nini Yusvi Maria', 'Wanita', '0890809809', 'Padang'),
(10, '18101152610520', 'Salsa Ayu Pratiwi', 'Wanita', '08382038234', 'Padang');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil`
--

CREATE TABLE `hasil` (
  `id_hasil` int(11) NOT NULL,
  `id_alternatif` int(11) NOT NULL,
  `nilai` float NOT NULL,
  `tgl` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `hasil`
--

INSERT INTO `hasil` (`id_hasil`, `id_alternatif`, `nilai`, `tgl`) VALUES
(1, 1, 0.0833, '2024'),
(2, 2, 0.875, '2024'),
(3, 3, 0.4583, '2024'),
(4, 4, 0.3333, '2024'),
(5, 5, 1, '2024'),
(6, 6, 0.1042, '2024'),
(7, 7, 0.5625, '2024'),
(8, 8, 0.5, '2024'),
(9, 9, 0.0208, '2024'),
(10, 10, 0.5833, '2024');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` int(11) NOT NULL,
  `kode_kriteria` varchar(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `bobot` float NOT NULL,
  `ada_pilihan` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `kode_kriteria`, `nama`, `bobot`, `ada_pilihan`) VALUES
(1, 'C1', 'Rata - rata nilai Raport', 0.3, 0),
(2, 'C2', 'Test Tulis', 0.25, 0),
(3, 'C3', 'Nilai Wawancara', 0.15, 0),
(4, 'C4', 'Pengetahuan Budaya', 0.1, 1),
(5, 'C5', 'Kepribadian', 0.2, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_test`
--

CREATE TABLE `nilai_test` (
  `id_test` int(11) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `nilai` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `nilai_test`
--

INSERT INTO `nilai_test` (`id_test`, `keterangan`, `nilai`) VALUES
(1, '1', 1),
(2, '2', 1),
(3, '3', 1),
(4, '4', 1),
(5, '5', 1),
(6, '6', 1),
(7, '7', 1),
(8, '8', 1),
(9, '9', 1),
(10, '10', 1),
(11, '11', 1),
(12, '12', 1),
(13, '13', 1),
(14, '14', 1),
(15, '15', 1),
(16, '16', 1),
(17, '17', 1),
(18, '18', 1),
(19, '19', 1),
(20, '20', 1),
(21, '21', 1),
(22, '22', 1),
(23, '23', 1),
(24, '24', 1),
(25, '25', 1),
(26, '26', 1),
(27, '27', 1),
(28, '28', 1),
(29, '29', 1),
(30, '30', 1),
(31, '31', 1),
(32, '32', 1),
(33, '33', 1),
(34, '34', 1),
(35, '35', 1),
(36, '36', 1),
(37, '37', 1),
(38, '38', 1),
(39, '39', 1),
(40, '40', 1),
(41, '41', 1),
(42, '42', 1),
(43, '43', 1),
(44, '44', 1),
(45, '45', 1),
(46, '46', 1),
(47, '47', 1),
(48, '48', 1),
(49, '49', 1),
(50, '50', 1),
(51, '51', 1),
(52, '52', 1),
(53, '53', 1),
(54, '54', 1),
(55, '55', 1),
(56, '56', 1),
(57, '57', 1),
(58, '58', 1),
(59, '59', 1),
(60, '60', 1),
(61, '61', 1),
(62, '62', 1),
(63, '63', 1),
(64, '64', 1),
(65, '65', 1),
(66, '66', 1),
(67, '67', 1),
(68, '68', 1),
(69, '69', 1),
(70, '70', 1),
(71, '71', 1),
(72, '72', 1),
(73, '73', 1),
(74, '74', 1),
(75, '75', 1),
(76, '76', 2),
(77, '77', 2),
(78, '78', 2),
(79, '79', 2),
(80, '80', 2),
(81, '81', 2),
(82, '82', 2),
(83, '83', 2),
(84, '84', 2),
(85, '85', 2),
(86, '86', 3),
(87, '87', 3),
(88, '88', 3),
(89, '89', 3),
(90, '90', 3),
(91, '91', 3),
(92, '92', 3),
(93, '93', 3),
(94, '94', 3),
(95, '95', 3),
(96, '96', 3),
(97, '97', 3),
(98, '98', 3),
(99, '99', 3),
(100, '100', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penilaian`
--

CREATE TABLE `penilaian` (
  `id_penilaian` int(11) NOT NULL,
  `id_alternatif` int(10) NOT NULL,
  `id_kriteria` int(10) NOT NULL,
  `nilai` float NOT NULL,
  `tgl` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `penilaian`
--

INSERT INTO `penilaian` (`id_penilaian`, `id_alternatif`, `id_kriteria`, `nilai`, `tgl`) VALUES
(1, 1, 1, 2, '2024'),
(2, 1, 2, 3, '2024'),
(3, 1, 3, 1, '2024'),
(4, 1, 4, 8, '2024'),
(5, 1, 5, 10, '2024'),
(6, 2, 1, 1, '2024'),
(7, 2, 2, 1, '2024'),
(8, 2, 3, 3, '2024'),
(9, 2, 4, 6, '2024'),
(10, 2, 5, 14, '2024'),
(11, 3, 1, 3, '2024'),
(12, 3, 2, 1, '2024'),
(13, 3, 3, 3, '2024'),
(14, 3, 4, 8, '2024'),
(15, 3, 5, 11, '2024'),
(16, 4, 1, 3, '2024'),
(17, 4, 2, 1, '2024'),
(18, 4, 3, 3, '2024'),
(19, 4, 4, 7, '2024'),
(20, 4, 5, 10, '2024'),
(21, 5, 1, 1, '2024'),
(22, 5, 2, 1, '2024'),
(23, 5, 3, 1, '2024'),
(24, 5, 4, 6, '2024'),
(25, 5, 5, 14, '2024'),
(26, 6, 1, 2, '2024'),
(27, 6, 2, 3, '2024'),
(28, 6, 3, 2, '2024'),
(29, 6, 4, 8, '2024'),
(30, 6, 5, 11, '2024'),
(31, 7, 1, 2, '2024'),
(32, 7, 2, 1, '2024'),
(33, 7, 3, 2, '2024'),
(34, 7, 4, 6, '2024'),
(35, 7, 5, 11, '2024'),
(36, 8, 1, 3, '2024'),
(37, 8, 2, 1, '2024'),
(38, 8, 3, 3, '2024'),
(39, 8, 4, 7, '2024'),
(40, 8, 5, 14, '2024'),
(41, 9, 1, 2, '2024'),
(42, 9, 2, 3, '2024'),
(43, 9, 3, 2, '2024'),
(44, 9, 4, 8, '2024'),
(45, 9, 5, 10, '2024'),
(46, 10, 1, 2, '2024'),
(47, 10, 2, 1, '2024'),
(48, 10, 3, 1, '2024'),
(49, 10, 4, 7, '2024'),
(50, 10, 5, 10, '2024');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sub_kriteria`
--

CREATE TABLE `sub_kriteria` (
  `id_sub_kriteria` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `nilai` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `sub_kriteria`
--

INSERT INTO `sub_kriteria` (`id_sub_kriteria`, `id_kriteria`, `nama`, `nilai`) VALUES
(1, 1, 'Sangat Baik', 50),
(2, 1, 'Baik', 40),
(3, 1, 'Cukup', 30),
(4, 1, 'Buruk', 20),
(5, 1, 'Sangat Buruk', 10),
(6, 4, 'Sangat Baik', 3),
(7, 4, 'Baik', 2),
(8, 4, 'Kurang Baik', 1),
(10, 5, 'Sangat Baik', 3),
(11, 5, 'Baik', 2),
(14, 5, 'Kurang Baik', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(5) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nama` varchar(70) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `role` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama`, `email`, `role`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Admin', 'admin@gmail.com', '1'),
(8, 'efrizal', '12dea96fec20593566ab75692c9949596833adc9', 'User', 'user@gmail.com', '2');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`id_alternatif`);

--
-- Indeks untuk tabel `hasil`
--
ALTER TABLE `hasil`
  ADD PRIMARY KEY (`id_hasil`);

--
-- Indeks untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indeks untuk tabel `nilai_test`
--
ALTER TABLE `nilai_test`
  ADD PRIMARY KEY (`id_test`);

--
-- Indeks untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`id_penilaian`);

--
-- Indeks untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD PRIMARY KEY (`id_sub_kriteria`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `alternatif`
--
ALTER TABLE `alternatif`
  MODIFY `id_alternatif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `hasil`
--
ALTER TABLE `hasil`
  MODIFY `id_hasil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `nilai_test`
--
ALTER TABLE `nilai_test`
  MODIFY `id_test` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id_penilaian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  MODIFY `id_sub_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
