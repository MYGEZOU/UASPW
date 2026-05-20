-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Bulan Mei 2026 pada 16.13
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_turnamen_esports`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `akun`
--

CREATE TABLE `akun` (
  `id_akun` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `peran` enum('Admin','Peserta','AdminGame') DEFAULT 'Peserta',
  `tanggal_dibuat` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `akun`
--

INSERT INTO `akun` (`id_akun`, `username`, `email`, `password`, `nama_lengkap`, `peran`, `tanggal_dibuat`) VALUES
(1, 'sat', 'satriadarzkine@gmail.com', '$2y$10$GW56f3RwEERc1P.AsJGG6.BXSdUsHkuBZNOluDEKOffkeLY/7fJRS', NULL, 'Peserta', '2026-05-04 21:04:59'),
(2, 'yug', 'yuga@gmail.com', '$2y$10$gfZOPGp16oE91.9gikHXrOwcLJFGVXN8rjN368kpjPuxZrgPXxDFa', 'yuga', 'AdminGame', '2026-05-06 11:02:16'),
(3, 'admingame', 'admingame@gmail.com', '$2y$10$TuprjfvPiXHHOMa4kSOrTeGA1Np5d.8PIGkYhhzbMvwI3/4W8oYpS', 'admingame', 'AdminGame', '2026-05-07 18:11:08'),
(4, 'sat28648', 'satriadarzkine420@gmail.com', '$2y$10$7gjQuuhGap3dd99IZR94huWcnfGrhNS4fUnBslbnuQ6jJCQ8afKje', 'sat2', 'Peserta', '2026-05-17 14:23:14'),
(5, 'admin', 'admin@gmail.com', '$2y$10$EaXO5di.OngVoI0B99SXweqetk7uFbVgKYpiOY/42mvtDmb5xm1nq', 'admin', 'Admin', '2026-05-19 19:14:53'),
(6, 'bayu6368', 'bayu@gmail.com', '$2y$10$yYo12xc2dSkvkI/NZBx.9efRbgHZY3O4rBfe/gCLqiGNGw4e9M3Em', 'bayu', 'Peserta', '2026-05-19 13:42:52'),
(7, 'apis581', 'apis@gmail.com', '$2y$10$dy3oC5Yp4szDvbd00gmGaeR5vdI4ef/z98b/75YlwQxuS.7f6/aNe', 'apis', 'Peserta', '2026-05-19 13:43:24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `anggota`
--

CREATE TABLE `anggota` (
  `id_anggota` int(11) NOT NULL,
  `id_tim` int(11) DEFAULT NULL,
  `id_akun` int(11) DEFAULT NULL,
  `nickname` varchar(50) NOT NULL,
  `peran` varchar(30) DEFAULT NULL,
  `peringkat_game` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `anggota`
--

INSERT INTO `anggota` (`id_anggota`, `id_tim`, `id_akun`, `nickname`, `peran`, `peringkat_game`) VALUES
(1, 1, NULL, 'sat2', 'Support', 'Mytic'),
(2, 1, NULL, 'aaa', 'aa', 'aa'),
(3, 3, 6, 'bayu6368', 'Support', 'Mytic');

-- --------------------------------------------------------

--
-- Struktur dari tabel `daftar`
--

CREATE TABLE `daftar` (
  `id_daftar` int(11) NOT NULL,
  `id_turnamen` int(11) DEFAULT NULL,
  `id_tim` int(11) DEFAULT NULL,
  `tanggal_daftar` datetime DEFAULT current_timestamp(),
  `status_pembayaran` enum('Menunggu','Lunas') DEFAULT 'Menunggu',
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `tanggal_konfirmasi` datetime DEFAULT NULL,
  `id_akun_konfirmasi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `daftar`
--

INSERT INTO `daftar` (`id_daftar`, `id_turnamen`, `id_tim`, `tanggal_daftar`, `status_pembayaran`, `bukti_pembayaran`, `tanggal_konfirmasi`, `id_akun_konfirmasi`) VALUES
(1, 1, 1, '2026-05-19 15:01:25', 'Lunas', '1779209722_817bf3408b413ef50b72.png', '2026-05-19 16:56:05', 2),
(2, 3, 1, '2026-05-20 08:14:01', 'Menunggu', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `game`
--

CREATE TABLE `game` (
  `id_game` int(11) UNSIGNED NOT NULL,
  `nama_game` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `game`
--

INSERT INTO `game` (`id_game`, `nama_game`, `slug`, `logo`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'Mobile Legends', 'mobile-legends', NULL, NULL, '2026-05-19 12:41:59', NULL),
(2, 'PUBG Mobile', 'pubg-mobile', NULL, NULL, '2026-05-19 12:41:59', NULL),
(3, 'Free Fire', 'free-fire', NULL, NULL, '2026-05-19 12:41:59', NULL),
(4, 'Valorant', 'valorant', NULL, NULL, '2026-05-19 12:41:59', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal`
--

CREATE TABLE `jadwal` (
  `id_jadwal` int(11) NOT NULL,
  `id_turnamen` int(11) DEFAULT NULL,
  `id_tim_1` int(11) DEFAULT NULL,
  `id_tim_2` int(11) DEFAULT NULL,
  `jadwal_tanding` datetime DEFAULT NULL,
  `babak` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jadwal`
--

INSERT INTO `jadwal` (`id_jadwal`, `id_turnamen`, `id_tim_1`, `id_tim_2`, `jadwal_tanding`, `babak`) VALUES
(1, 1, 1, 3, '2026-05-20 20:46:00', 'Grup a');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2026-05-19-123627', 'App\\Database\\Migrations\\CreateGameTable', 'default', 'App', 1779194519, 1),
(2, '2026-05-19-135916', 'App\\Database\\Migrations\\UpdateDaftarTable', 'default', 'App', 1779199187, 2),
(3, '2026-05-19-162249', 'App\\Database\\Migrations\\AddIdAkunToAnggota', 'default', 'App', 1779207792, 3),
(4, '2026-05-20-073617', 'App\\Database\\Migrations\\AddBannerToTurnamen', 'default', 'App', 1779262594, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `skor`
--

CREATE TABLE `skor` (
  `id_skor` int(11) NOT NULL,
  `id_jadwal` int(11) DEFAULT NULL,
  `skor_tim_1` int(11) DEFAULT 0,
  `skor_tim_2` int(11) DEFAULT 0,
  `id_tim_pemenang` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tim`
--

CREATE TABLE `tim` (
  `id_tim` int(11) NOT NULL,
  `id_akun` int(11) DEFAULT NULL,
  `nama_tim` varchar(50) NOT NULL,
  `asal_kota` varchar(50) DEFAULT NULL,
  `kontak_kapten` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tim`
--

INSERT INTO `tim` (`id_tim`, `id_akun`, `nama_tim`, `asal_kota`, `kontak_kapten`) VALUES
(1, 1, 'SKAYyy', 'Medan', '08226551'),
(3, 7, 'FOREX', 'Medan', '082265180275');

-- --------------------------------------------------------

--
-- Struktur dari tabel `turnamen`
--

CREATE TABLE `turnamen` (
  `id_turnamen` int(11) NOT NULL,
  `nama_turnamen` varchar(100) NOT NULL,
  `id_game` int(11) UNSIGNED DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `biaya_pendaftaran` decimal(10,2) DEFAULT 0.00,
  `status` enum('Pendaftaran','Berlangsung','Selesai') DEFAULT 'Pendaftaran',
  `banner` varchar(255) DEFAULT 'default_banner.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `turnamen`
--

INSERT INTO `turnamen` (`id_turnamen`, `nama_turnamen`, `id_game`, `tanggal_mulai`, `biaya_pendaftaran`, `status`, `banner`) VALUES
(1, 'Turnamen Test', 1, '2026-06-01', 50000.00, 'Pendaftaran', 'default_banner.jpg'),
(2, 'Turnamen Kemerdekaan ML', 1, '2026-08-17', 100000.00, 'Pendaftaran', 'default_banner.jpg'),
(3, 'Kejuaraan Nasional PUBG', 2, '2026-07-20', 150000.00, 'Pendaftaran', '1779262974_3927aee6e44ae3a47dff.jpg'),
(4, 'Piala Pelajar Free Fire', 3, '2026-09-10', 50000.00, 'Berlangsung', 'default_banner.jpg'),
(5, 'Valorant Open Tournament', 4, '2026-06-15', 200000.00, 'Pendaftaran', 'default_banner.jpg');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`id_akun`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id_anggota`),
  ADD KEY `id_tim` (`id_tim`),
  ADD KEY `idx_anggota_akun` (`id_akun`);

--
-- Indeks untuk tabel `daftar`
--
ALTER TABLE `daftar`
  ADD PRIMARY KEY (`id_daftar`),
  ADD KEY `id_turnamen` (`id_turnamen`),
  ADD KEY `id_tim` (`id_tim`),
  ADD KEY `fk_daftar_akun_konfirmasi` (`id_akun_konfirmasi`);

--
-- Indeks untuk tabel `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`id_game`),
  ADD UNIQUE KEY `nama_game` (`nama_game`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indeks untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `id_turnamen` (`id_turnamen`),
  ADD KEY `id_tim_1` (`id_tim_1`),
  ADD KEY `id_tim_2` (`id_tim_2`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `skor`
--
ALTER TABLE `skor`
  ADD PRIMARY KEY (`id_skor`),
  ADD KEY `id_jadwal` (`id_jadwal`),
  ADD KEY `id_tim_pemenang` (`id_tim_pemenang`);

--
-- Indeks untuk tabel `tim`
--
ALTER TABLE `tim`
  ADD PRIMARY KEY (`id_tim`),
  ADD KEY `id_akun` (`id_akun`);

--
-- Indeks untuk tabel `turnamen`
--
ALTER TABLE `turnamen`
  ADD PRIMARY KEY (`id_turnamen`),
  ADD KEY `fk_turnamen_game` (`id_game`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `akun`
--
ALTER TABLE `akun`
  MODIFY `id_akun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id_anggota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `daftar`
--
ALTER TABLE `daftar`
  MODIFY `id_daftar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `game`
--
ALTER TABLE `game`
  MODIFY `id_game` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `skor`
--
ALTER TABLE `skor`
  MODIFY `id_skor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tim`
--
ALTER TABLE `tim`
  MODIFY `id_tim` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `turnamen`
--
ALTER TABLE `turnamen`
  MODIFY `id_turnamen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `anggota`
--
ALTER TABLE `anggota`
  ADD CONSTRAINT `anggota_ibfk_1` FOREIGN KEY (`id_tim`) REFERENCES `tim` (`id_tim`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `daftar`
--
ALTER TABLE `daftar`
  ADD CONSTRAINT `daftar_ibfk_1` FOREIGN KEY (`id_turnamen`) REFERENCES `turnamen` (`id_turnamen`) ON DELETE CASCADE,
  ADD CONSTRAINT `daftar_ibfk_2` FOREIGN KEY (`id_tim`) REFERENCES `tim` (`id_tim`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_daftar_akun_konfirmasi` FOREIGN KEY (`id_akun_konfirmasi`) REFERENCES `akun` (`id_akun`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `jadwal_ibfk_1` FOREIGN KEY (`id_turnamen`) REFERENCES `turnamen` (`id_turnamen`) ON DELETE CASCADE,
  ADD CONSTRAINT `jadwal_ibfk_2` FOREIGN KEY (`id_tim_1`) REFERENCES `tim` (`id_tim`) ON DELETE CASCADE,
  ADD CONSTRAINT `jadwal_ibfk_3` FOREIGN KEY (`id_tim_2`) REFERENCES `tim` (`id_tim`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `skor`
--
ALTER TABLE `skor`
  ADD CONSTRAINT `skor_ibfk_1` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal` (`id_jadwal`) ON DELETE CASCADE,
  ADD CONSTRAINT `skor_ibfk_2` FOREIGN KEY (`id_tim_pemenang`) REFERENCES `tim` (`id_tim`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `tim`
--
ALTER TABLE `tim`
  ADD CONSTRAINT `tim_ibfk_1` FOREIGN KEY (`id_akun`) REFERENCES `akun` (`id_akun`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `turnamen`
--
ALTER TABLE `turnamen`
  ADD CONSTRAINT `fk_turnamen_game` FOREIGN KEY (`id_game`) REFERENCES `game` (`id_game`) ON UPDATE CASCADE,
  ADD CONSTRAINT `turnamen_id_game_foreign` FOREIGN KEY (`id_game`) REFERENCES `game` (`id_game`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
