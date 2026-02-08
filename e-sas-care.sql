-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 08, 2026 at 08:44 AM
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
(1, 2, 4, 3, 4, 2, 4, 1, 4, 3, 4, 4, 3, 4, 4, 2, 3, 4, 3, 4, 4, 2, 66, 82.50, 'Kecemasan Berat', '2026-02-02 17:03:03'),
(2, 3, 3, 3, 2, 3, 3, 3, 3, 2, 3, 3, 2, 3, 4, 2, 3, 3, 4, 3, 2, 4, 58, 72.50, 'Kecemasan Sedang', '2026-02-08 07:22:33'),
(3, 3, 1, 1, 1, 2, 1, 2, 1, 2, 1, 2, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 24, 30.00, 'Normal (Tidak Ada Kecemasan Signifikan)', '2026-02-08 07:23:35'),
(4, 3, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 40, 50.00, 'Kecemasan Ringan', '2026-02-08 07:24:39'),
(5, 3, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 80, 100.00, 'Kecemasan Berat', '2026-02-08 07:25:11');

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
(1, 'Normal', 'Teknik Relaksasi Pernapasan Dalam (Deep Breathing) : \r\nTeknik ini merupakan salah satu teknik sederhana yang efektif untuk membantu meredakan kecemasan. Pola napas yang dilakukan secara perlahan dan teratur dapat memicu respon relaksasi tubuh, sehingga ketegangan otot berkurang, denyut jantung menjadi lebih stabil, dan individuu merasa lebih tenang saat menghadapi situasi yang menegangkan.\r\nTeknik ini dapat dilakukan dengan posisi yang nyaman lalu tarik nafas secara perlahan melalui hidung kemudian hembuskan melalui mulut. Dan ulangi selama 5-10 menit saat merasa cemas.\r\n', 1, '2026-02-03 03:16:53'),
(2, 'Normal', 'Relaksasi ASMR (Autonomous Sensory Meridian Response) : \r\nRelaksasi ASMR memanfaatkan rangsangan suara atau visual tertentu yang memberikan sensasi nyaman dan menenangkan. Teknik ini dapat membantu menurunkan kecemasan dengan menciptakan suasan rileks dan mengurangi ketegangan mental, terutama pada mahasiswa yang mudah merasa tertekan. Teknik ini bisa dilakukan dengan mendengarkan suara hujan, suara alam saat pengguna sedang merasa gelisah atau sulit tidur.\r\n', 2, '2026-02-03 03:16:53'),
(3, 'Normal', 'Psychoeducation (Edukasi Kesehatan Mental) : \r\nPsychoeducation merupakan upaya pemberian informasi terkait kecemasab, mulai dari gejala hingga cara penanganannya. Dengan pemahaman yang baik, individu diharapkan mampu mengenali kondisi kecemasannya sejak dini dan melakukan langkah-langkah pencegahan agar kecemasan tidak berkembang menjadi masalah yang lebih serius.', 3, '2026-02-03 03:16:53'),
(5, 'Ringan', 'Terapi Relaksasi Progresif : \r\nRelaksasi progresif ini dilakukan dengan cara menegangkan lalu melemaskan otot-otot tubuh secara bertahap. Teknik ini membantu individu menyadari perbedaan antara kondisi tubuh yang tegang dan rileks, sehingga mampu mengurangi keluhan fisik maupun psikologis yang muncul akibat kecemasan. Teknik ini juga dapat dilakukan sambil berbaring atau duduk.\r\n', 1, '2026-02-03 03:16:53'),
(6, 'Ringan', 'Terapi Relaksasi Benson : \r\nTerapi Benson menggabungkan teknik relaksasi dengan unsur sugesti positif atau keyakinan individu. Pendekatan ini bertujuan untuk menenangkan pikiran, menurunkan tingkat stres, serta membantu individu mengendalikan respon emosional yang muncul akibat kecemasan. Terapi ini dapat dilakukan saat berbaring atau duduk dengan nyaman, pejamkan mata lalu atur napas secara perlahan. Lalu saat menghembuskan napas ulangi kalimat positif secara perlahan didalam hati.', 2, '2026-02-03 03:16:53'),
(7, 'Ringan', 'Terapi Suportif : \r\nTerapi Suportif befokus pada pemberian dukungan emosional melalui empati, komunikasi yang baik, dan sikap saling memahami. Dengan adanya dukungan tersebut, individu merasa lebih diterima dan tidak sendirian dalam menghadapi masalah, sehingga tingkat kecemasan dapat berkurang secara bertahap, khususnya pada tekanan akademik dan sosial.\r\nTeknik ini dapat pengguna lakukan dengan cera menceritakan perasaan cemas kepada teman dekat, keluarga atau orang yang anda percaya. Pengguna juga dapat mengikuti sesi konseling untuk mendapatkan dukungan, motivasi dan arahan.\r\n', 3, '2026-02-03 03:16:53'),
(8, 'Ringan', 'Self-Healing Therapy : \r\nSelf-Healing Therapy menekankan pada proses mengenali dan menerima emosi yang dirasakan, serta mengelola pikiran negatif secara mandiri. Pendekatan ini membantu individu memahami sumber kecemasan yang dialami dan membangun strategi koping yang lebih sehat dalam kehidupan sehari-hari. Pengguna dapat melakukan afirmasi positif kepada diri sendiri setiap hari, menuliskan perasaan dan pikiran dalam jurnal harian, melakukan aktivitas yang disukai, melungkan waktu untuk diri sendiri.', 4, '2026-02-03 03:16:53'),
(11, 'Sedang', 'Terapi Suportif (Intensif) : \r\nTerapi Suportif befokus pada pemberian dukungan emosional melalui empati, komunikasi yang baik, dan sikap saling memahami. Dengan adanya dukungan tersebut, individu merasa lebih diterima dan tidak sendirian dalam menghadapi masalah, sehingga tingkat kecemasan dapat berkurang secara bertahap, khususnya pada tekanan akademik dan sosial.\r\nTeknik ini dapat pengguna lakukan dengan cera menceritakan perasaan cemas kepada teman dekat, keluarga atau orang yang anda percaya. Pengguna juga dapat mengikuti sesi konseling untuk mendapatkan dukungan, motivasi dan arahan.\r\n', 1, '2026-02-03 03:16:53'),
(12, 'Sedang', 'Terapi Relaksasi Benson : \r\nTerapi Benson menggabungkan teknik relaksasi dengan unsur sugesti positif atau keyakinan individu. Pendekatan ini bertujuan untuk menenangkan pikiran, menurunkan tingkat stres, serta membantu individu mengendalikan respon emosional yang muncul akibat kecemasan. Terapi ini dapat dilakukan saat berbaring atau duduk dengan nyaman, pejamkan mata lalu atur napas secara perlahan. Lalu saat menghembuskan napas ulangi kalimat positif secara perlahan didalam hati.', 2, '2026-02-03 03:16:53'),
(13, 'Sedang', 'Self-Healing Therapy : \r\nSelf-Healing Therapy menekankan pada proses mengenali dan menerima emosi yang dirasakan, serta mengelola pikiran negatif secara mandiri. Pendekatan ini membantu individu memahami sumber kecemasan yang dialami dan membangun strategi koping yang lebih sehat dalam kehidupan sehari-hari. Pengguna dapat melakukan afirmasi positif kepada diri sendiri setiap hari, menuliskan perasaan dan pikiran dalam jurnal harian, melakukan aktivitas yang disukai, melungkan waktu untuk diri sendiri.', 3, '2026-02-03 03:16:53'),
(18, 'Berat', 'Teknik Relaksasi Pernapasan Dalam (Deep Breathing) : \r\nTeknik ini merupakan salah satu teknik sederhana yang efektif untuk membantu meredakan kecemasan. Pola napas yang dilakukan secara perlahan dan teratur dapat memicu respon relaksasi tubuh, sehingga ketegangan otot berkurang, denyut jantung menjadi lebih stabil, dan individuu merasa lebih tenang saat menghadapi situasi yang menegangkan.\r\nTeknik ini dapat dilakukan dengan posisi yang nyaman lalu tarik nafas secara perlahan melalui hidung kemudian hembuskan melalui mulut. Dan ulangi selama 5-10 menit saat merasa cemas.', 1, '2026-02-03 03:16:53'),
(19, 'Berat', 'Terapi Suportif (Krisis) : \r\nTerapi Suportif befokus pada pemberian dukungan emosional melalui empati, komunikasi yang baik, dan sikap saling memahami. Dengan adanya dukungan tersebut, individu merasa lebih diterima dan tidak sendirian dalam menghadapi masalah, sehingga tingkat kecemasan dapat berkurang secara bertahap, khususnya pada tekanan akademik dan sosial.\r\nTeknik ini dapat pengguna lakukan dengan cera menceritakan perasaan cemas kepada teman dekat, keluarga atau orang yang anda percaya. Pengguna juga dapat mengikuti sesi konseling untuk mendapatkan dukungan, motivasi dan arahan.', 2, '2026-02-03 03:16:53'),
(20, 'Berat', 'Psychoeducation (Edukasi Kesehatan Mental) : \r\nPsychoeducation merupakan upaya pemberian informasi terkait kecemasab, mulai dari gejala hingga cara penanganannya. Dengan pemahaman yang baik, individu diharapkan mampu mengenali kondisi kecemasannya sejak dini dan melakukan langkah-langkah pencegahan agar kecemasan tidak berkembang menjadi masalah yang lebih serius.\r\n', 3, '2026-02-03 03:16:53');

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
(2, '0', 'Jean', 'jean@esascare.com', '0', '2002-08-10', '$2y$10$kbV/KfF8vHBiMv0T8OWO/e1Kp4j85k3xXy2/W5kMpc2vipMwr5hfy', '2026-02-02 16:22:36', '2026-02-05 09:21:07'),
(3, '1', 'Administrator', 'admin@esascare.com', '1', '2000-07-10', '$2y$10$W5OdEPulj8wD3Jtsm7XOdO1OptDYCdZ1kkJi25NWO8eJ5vQEI6wd2', '2026-02-03 02:16:40', '2026-02-05 09:21:17');

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
