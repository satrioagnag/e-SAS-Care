-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 05, 2026 at 09:02 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e-sas-care`
--

-- --------------------------------------------------------

--
-- Table structure for table `artikel`
--

CREATE TABLE `artikel` (
  `id_artikel` int NOT NULL,
  `judul` varchar(255) NOT NULL,
  `konten` text NOT NULL,
  `penulis` varchar(100) DEFAULT 'Tim Konten',
  `tanggal_publikasi` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ringkasan` text,
  `views` int DEFAULT '0',
  `txt_file` varchar(255) DEFAULT NULL COMMENT 'Optional .txt file for article content'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `artikel`
--

INSERT INTO `artikel` (`id_artikel`, `judul`, `konten`, `penulis`, `tanggal_publikasi`, `ringkasan`, `views`, `txt_file`) VALUES
(4, 'Memahami Kecemasan: Gejala dan Cara Mengatasinya', '<p>Kecemasan adalah respons alami tubuh terhadap stres. Namun, ketika kecemasan menjadi berlebihan dan mengganggu aktivitas sehari-hari, ini bisa menjadi tanda gangguan kecemasan.</p>\r\n\r\n<h3>Gejala Umum Kecemasan</h3>\r\n<p>Beberapa gejala kecemasan yang umum meliputi:</p>\r\n<ul>\r\n<li>Gelisah tanpa alasan yang jelas</li>\r\n<li>Mudah marah atau tersinggung</li>\r\n<li>Kesulitan tidur dan istirahat</li>\r\n<li>Peningkatan detak jantung</li>\r\n<li>Berkeringat berlebihan</li>\r\n<li>Kesulitan berkonsentrasi</li>\r\n</ul>\r\n\r\n<h3>Cara Mengatasi Kecemasan</h3>\r\n<p>Ada beberapa strategi efektif untuk mengelola kecemasan:</p>\r\n<ol>\r\n<li><strong>Teknik Pernapasan:</strong> Pernapasan dalam dapat membantu menenangkan sistem saraf</li>\r\n<li><strong>Olahraga Teratur:</strong> Aktivitas fisik melepaskan endorfin yang meningkatkan mood</li>\r\n<li><strong>Mindfulness:</strong> Fokus pada saat ini dapat mengurangi kecemasan tentang masa depan</li>\r\n<li><strong>Batasi Kafein:</strong> Kafein dapat memperburuk gejala kecemasan</li>\r\n<li><strong>Tidur Cukup:</strong> Kurang tidur dapat meningkatkan tingkat kecemasan</li>\r\n</ol>\r\n\r\n<h3>Kapan Harus Mencari Bantuan Profesional</h3>\r\n<p>Jika kecemasan Anda mengganggu aktivitas sehari-hari, hubungan sosial, atau pekerjaan, sebaiknya konsultasikan dengan profesional kesehatan mental.</p>', 'Tim Konten', '2026-02-03 03:16:53', 'Kecemasan adalah respons alami tubuh terhadap stres. Artikel ini membahas gejala umum kecemasan dan strategi efektif untuk mengelolanya.', 1, NULL),
(5, 'Teknik Relaksasi untuk Mengurangi Kecemasan', '<p>Relaksasi adalah keterampilan yang dapat dipelajari dan dipraktikkan untuk mengurangi kecemasan.</p>\r\n\r\n<h3>1. Pernapasan Diafragma</h3>\r\n<p>Teknik pernapasan dalam yang melibatkan diafragma dapat mengaktifkan respons relaksasi tubuh.</p>\r\n\r\n<h3>2. Relaksasi Otot Progresif</h3>\r\n<p>Teknik ini melibatkan menegangkan dan merelaksaskan kelompok otot secara berurutan.</p>\r\n\r\n<h3>3. Meditasi Mindfulness</h3>\r\n<p>Meditasi mindfulness membantu Anda fokus pada saat ini tanpa menghakimi.</p>', 'Tim Konten', '2026-02-03 03:16:53', 'Pelajari berbagai teknik relaksasi seperti meditasi, pernapasan dalam, dan yoga yang dapat membantu meredakan kecemasan Anda.', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `konsultasi`
--

CREATE TABLE `konsultasi` (
  `id_konsultasi` int NOT NULL,
  `id_user` int NOT NULL,
  `q1` int NOT NULL,
  `q2` int NOT NULL,
  `q3` int NOT NULL,
  `q4` int NOT NULL,
  `q5` int NOT NULL,
  `q6` int NOT NULL,
  `q7` int NOT NULL,
  `q8` int NOT NULL,
  `q9` int NOT NULL,
  `q10` int NOT NULL,
  `q11` int NOT NULL,
  `q12` int NOT NULL,
  `q13` int NOT NULL,
  `q14` int NOT NULL,
  `q15` int NOT NULL,
  `q16` int NOT NULL,
  `q17` int NOT NULL,
  `q18` int NOT NULL,
  `q19` int NOT NULL,
  `q20` int NOT NULL,
  `total_score` int NOT NULL,
  `index_score` decimal(5,2) NOT NULL COMMENT 'Index = (Total/80) * 100',
  `kategori_kecemasan` varchar(50) NOT NULL,
  `tanggal_konsultasi` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ;

--
-- Dumping data for table `konsultasi`
--

INSERT INTO `konsultasi` (`id_konsultasi`, `id_user`, `q1`, `q2`, `q3`, `q4`, `q5`, `q6`, `q7`, `q8`, `q9`, `q10`, `q11`, `q12`, `q13`, `q14`, `q15`, `q16`, `q17`, `q18`, `q19`, `q20`, `total_score`, `index_score`, `kategori_kecemasan`, `tanggal_konsultasi`) VALUES
(1, 2, 4, 3, 4, 2, 4, 1, 4, 3, 4, 4, 3, 4, 4, 2, 3, 4, 3, 4, 4, 2, 66, 82.50, 'Kecemasan Berat', '2026-02-02 17:03:03');

-- --------------------------------------------------------

--
-- Table structure for table `rekomendasi`
--

CREATE TABLE `rekomendasi` (
  `id_rekomendasi` int NOT NULL,
  `kategori_kecemasan` varchar(50) NOT NULL COMMENT 'Normal, Ringan, Sedang, Berat',
  `rekomendasi` text NOT NULL,
  `urutan` int DEFAULT '0' COMMENT 'Order of display',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rekomendasi`
--

INSERT INTO `rekomendasi` (`id_rekomendasi`, `kategori_kecemasan`, `rekomendasi`, `urutan`, `created_at`) VALUES
(1, 'Normal', 'Pertahankan pola hidup sehat dengan olahraga teratur dan tidur yang cukup', 1, '2026-02-03 03:16:53'),
(2, 'Normal', 'Lanjutkan aktivitas positif dan hobi yang Anda sukai', 2, '2026-02-03 03:16:53'),
(3, 'Normal', 'Tetap jaga keseimbangan antara pekerjaan dan istirahat', 3, '2026-02-03 03:16:53'),
(4, 'Normal', 'Lakukan pemeriksaan kesehatan mental rutin sebagai tindakan preventif', 4, '2026-02-03 03:16:53'),
(5, 'Ringan', 'Praktikkan teknik pernapasan dalam selama 5-10 menit setiap hari', 1, '2026-02-03 03:16:53'),
(6, 'Ringan', 'Lakukan olahraga ringan seperti jalan kaki atau yoga minimal 30 menit per hari', 2, '2026-02-03 03:16:53'),
(7, 'Ringan', 'Batasi konsumsi kafein dan nikotin', 3, '2026-02-03 03:16:53'),
(8, 'Ringan', 'Coba teknik mindfulness atau meditasi', 4, '2026-02-03 03:16:53'),
(9, 'Ringan', 'Berbagi perasaan dengan orang terdekat yang Anda percaya', 5, '2026-02-03 03:16:53'),
(10, 'Ringan', 'Jaga pola tidur yang konsisten (7-8 jam per malam)', 6, '2026-02-03 03:16:53'),
(11, 'Sedang', 'Konsultasikan dengan psikolog untuk mendapatkan terapi kognitif perilaku (CBT)', 1, '2026-02-03 03:16:53'),
(12, 'Sedang', 'Atur jadwal harian yang terstruktur untuk mengurangi ketidakpastian', 2, '2026-02-03 03:16:53'),
(13, 'Sedang', 'Praktikkan teknik relaksasi progresif secara rutin', 3, '2026-02-03 03:16:53'),
(14, 'Sedang', 'Hindari alkohol dan zat yang dapat memperburuk kecemasan', 4, '2026-02-03 03:16:53'),
(15, 'Sedang', 'Pertimbangkan untuk bergabung dengan kelompok dukungan', 5, '2026-02-03 03:16:53'),
(16, 'Sedang', 'Jaga pola tidur yang konsisten dan hindari begadang', 6, '2026-02-03 03:16:53'),
(17, 'Sedang', 'Catat pemicu kecemasan Anda untuk mengidentifikasi pola', 7, '2026-02-03 03:16:53'),
(18, 'Berat', 'SEGERA konsultasikan dengan psikiater atau profesional kesehatan mental', 1, '2026-02-03 03:16:53'),
(19, 'Berat', 'Pertimbangkan terapi kombinasi (psikoterapi dan farmakologi jika diperlukan)', 2, '2026-02-03 03:16:53'),
(20, 'Berat', 'Jangan ragu untuk meminta bantuan dari hotline krisis mental: 119 ext 8', 3, '2026-02-03 03:16:53'),
(21, 'Berat', 'Informasikan kondisi Anda kepada keluarga terdekat untuk mendapat dukungan', 4, '2026-02-03 03:16:53'),
(22, 'Berat', 'Hindari isolasi sosial, tetap terhubung dengan support system', 5, '2026-02-03 03:16:53'),
(23, 'Berat', 'Ikuti rencana perawatan yang diberikan oleh profesional secara konsisten', 6, '2026-02-03 03:16:53'),
(24, 'Berat', 'Pertimbangkan rawat jalan atau rawat inap jika kondisi sangat mengganggu', 7, '2026-02-03 03:16:53'),
(25, 'Berat', 'Hotline Kesehatan Mental 24/7: 119 ext 8 atau 500-454 (Halo Kemenkes RI)', 8, '2026-02-03 03:16:53');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `role` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '1' COMMENT '0=Admin, 1=User/Patient, 2=Expert',
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `jenis_kelamin` enum('0','1') DEFAULT NULL COMMENT '0=Perempuan, 1=Laki-Laki',
  `tgl_lahir` date DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `role`, `nama`, `email`, `jenis_kelamin`, `tgl_lahir`, `password`, `created_at`, `updated_at`) VALUES
(2, '0', 'Jean', 'jean@test.com', '0', '2002-08-10', '$2y$10$kbV/KfF8vHBiMv0T8OWO/e1Kp4j85k3xXy2/W5kMpc2vipMwr5hfy', '2026-02-02 16:22:36', '2026-02-02 16:41:59'),
(3, '1', 'Administrator', 'admin@prod.com', '1', '2000-07-10', '$2y$10$W5OdEPulj8wD3Jtsm7XOdO1OptDYCdZ1kkJi25NWO8eJ5vQEI6wd2', '2026-02-03 02:16:40', '2026-02-03 02:17:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id_artikel`);

--
-- Indexes for table `konsultasi`
--
ALTER TABLE `konsultasi`
  ADD PRIMARY KEY (`id_konsultasi`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `rekomendasi`
--
ALTER TABLE `rekomendasi`
  ADD PRIMARY KEY (`id_rekomendasi`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id_artikel` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `konsultasi`
--
ALTER TABLE `konsultasi`
  MODIFY `id_konsultasi` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rekomendasi`
--
ALTER TABLE `rekomendasi`
  MODIFY `id_rekomendasi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `konsultasi`
--
ALTER TABLE `konsultasi`
  ADD CONSTRAINT `konsultasi_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
