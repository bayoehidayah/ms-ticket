-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Waktu pembuatan: 03 Des 2022 pada 09.08
-- Versi server: 5.7.34
-- Versi PHP: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ms_ticket`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id` int(20) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `tipe` enum('it_support','pengguna') NOT NULL DEFAULT 'pengguna'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id`, `username`, `password`, `nama`, `tipe`) VALUES
(1, 'is1', '$2y$10$Y4BCqJ5bY3Xriq3pQdE8IeFEJOi84cqTCkDjWCvLb4uh.6Lux0ZP.', 'Muhammad Aji Alfaridzi', 'it_support'),
(2, 'user1', '$2y$10$zHo9FBFHd5tc7ska6QHNAOPuRkFgI2E8JGKiHbUc2olWbG6IfhNaK', 'Harmanto', 'pengguna'),
(3, 'is2', '$2y$10$78gIAmR9Xf.MARYt6XCspOLutM4WczWnkE.Qr4D62rqbrNYpli7KO', 'Dedi Sianturi ', 'it_support'),
(4, 'is3', '$2y$10$vJuC3Nt0N6D/uNppheZry..MV4SOmFbyZJYn4gnmF7C2abXkSyFwq', 'Rahmat Rezki', 'it_support');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ticket`
--

CREATE TABLE `ticket` (
  `id` int(20) NOT NULL,
  `id_pengguna` varchar(100) DEFAULT NULL,
  `it_support` varchar(100) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `status` enum('new','assign','resolved') NOT NULL DEFAULT 'new',
  `service_type` enum('aplikasi_pendukung_kerja','jaringan_internet','perangkat_pc/laptop_internal','perangkat_pc/laptop_ms_lapto','perangkat_pendukung','server') NOT NULL,
  `group_room` varchar(255) NOT NULL,
  `urgent_level` enum('critical','high','medium','low') NOT NULL DEFAULT 'low',
  `priority` enum('1','2','3','4') NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `ticket`
--

INSERT INTO `ticket` (`id`, `id_pengguna`, `it_support`, `title`, `description`, `status`, `service_type`, `group_room`, `urgent_level`, `priority`, `created_at`) VALUES
(1, '2', '3', 'Enim non accusamus u', 'Exercitation volupta', 'resolved', 'perangkat_pc/laptop_internal', 'Cupiditate in et ten', 'high', '1', '2022-10-02 06:42:16'),
(2, '2', '3', 'Ut modi aut quas vol', 'Perspiciatis esse r', 'new', 'server', 'Mollitia dolores del', 'critical', '4', '2022-10-02 07:00:03'),
(3, '2', '1', 'Voluptatem dolorem i', 'Nulla quia exercitat', 'resolved', 'perangkat_pc/laptop_internal', 'Qui mollit laboriosa', 'high', '3', '2022-10-02 07:00:10'),
(4, '2', 'Sit labore dolor mag', 'Asperiores esse qui', 'Eos et quibusdam ea', 'resolved', 'aplikasi_pendukung_kerja', 'Voluptates quo qui d', 'medium', '1', '2022-10-25 16:51:22'),
(5, '0', 'Reiciendis quia Nam ', 'Voluptatem quia qui', 'Cillum ea atque mini', 'resolved', 'jaringan_internet', 'Anim dolore quam vol', 'medium', '2', '2022-12-03 09:05:04'),
(6, '0', 'Reiciendis quia Nam ', 'Voluptatem quia qui', 'Cillum ea atque mini', 'resolved', 'jaringan_internet', 'Anim dolore quam vol', 'medium', '2', '2022-12-03 09:05:04'),
(7, '0', 'Reiciendis quia Nam ', 'Voluptatem quia qui', 'Cillum ea atque mini', 'resolved', 'jaringan_internet', 'Anim dolore quam vol', 'medium', '2', '2022-12-03 09:05:05'),
(8, 'ASdsdqwewqasda', 'Quis provident qui ', 'Nostrum excepturi et', 'Ea consectetur obcae', 'assign', 'server', 'Velit est iure sol', 'critical', '4', '2022-12-03 09:05:26'),
(9, 'Consequuntur non ess', 'Labore sit tempore ', 'Animi voluptatem mo', 'Ut sit cumque conse', 'resolved', 'perangkat_pendukung', 'Sunt neque tempor si', 'medium', '2', '2022-12-03 09:06:02'),
(10, 'Natus in dolor exped', 'Quisquam aspernatur ', 'Delectus perferendi', 'Voluptatum pariatur', 'resolved', 'perangkat_pc/laptop_internal', 'In temporibus do nul', 'critical', '4', '2022-12-03 09:06:22');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ticket_resolved`
--

CREATE TABLE `ticket_resolved` (
  `id` int(20) NOT NULL,
  `id_ticket` int(20) NOT NULL,
  `cause` varchar(100) NOT NULL,
  `resolved_ket` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `ticket_resolved`
--

INSERT INTO `ticket_resolved` (`id`, `id_ticket`, `cause`, `resolved_ket`) VALUES
(1, 1, 'Et non praesentium e', 'Perferendis id aut c'),
(2, 3, 'Molestias quaerat ap', 'Consequuntur cupidit'),
(3, 10, 'Asdasqw', 'asdASdas');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pengguna` (`id_pengguna`),
  ADD KEY `it_support` (`it_support`);

--
-- Indeks untuk tabel `ticket_resolved`
--
ALTER TABLE `ticket_resolved`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ticket` (`id_ticket`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `ticket_resolved`
--
ALTER TABLE `ticket_resolved`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `ticket_resolved`
--
ALTER TABLE `ticket_resolved`
  ADD CONSTRAINT `ticket_resolved_id_ticket_foreign_key` FOREIGN KEY (`id_ticket`) REFERENCES `ticket` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
