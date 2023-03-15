-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2022 at 03:56 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pemwebuts`
--

-- --------------------------------------------------------

--
-- Table structure for table `likes_posts`
--

CREATE TABLE `likes_posts` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `likes_posts`
--

INSERT INTO `likes_posts` (`id`, `post_id`, `user_id`) VALUES
(21, 19, 27),
(22, 20, 27),
(23, 19, 22),
(24, 19, 29),
(25, 23, 30);

-- --------------------------------------------------------

--
-- Table structure for table `likes_replies`
--

CREATE TABLE `likes_replies` (
  `id` int(11) NOT NULL,
  `replies_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `likes_replies`
--

INSERT INTO `likes_replies` (`id`, `replies_id`, `user_id`) VALUES
(22, 26, 27),
(23, 26, 22),
(24, 27, 22),
(25, 31, 29);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `author` varchar(20) NOT NULL,
  `title` varchar(128) NOT NULL,
  `body` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `topic_id`, `user_id`, `author`, `title`, `body`, `created_at`) VALUES
(19, 1, 22, 'dzaky2636', 'Tutorial HTML', 'Ada yang punya tutorial untuk belajar HTML dari dasar disini? Akan sangat membantu, terima kasih atas perhatiannya.', '2022-10-12 11:36:23'),
(20, 1, 27, 'odokawa47', 'Teks Lorem Ipsum untuk di Copy Paste', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"', '2022-10-12 11:39:47'),
(22, 2, 29, 'adminastra47', 'Keuntungan PHP', 'Menurut kalian, keuntungan PHP apa saja?\n\nKirim disini ya.', '2022-10-12 11:53:24'),
(23, 1, 30, 'adminastra48', 'PENDAFTARAN ADMIN ASTRA', 'adminastra47, dan adminastra48 (saya) sedang mengadakan pendaftaran admin.\r\n\r\nMohon kontak kami di adminastra@gmail.com\r\n\r\n- Untuk info selanjutnya mohon tunggu selama dua minggu.\r\n- Akan ada tahap seleksi', '2022-10-12 12:01:00'),
(24, 1, 22, 'dzaky2636', '<p>halo</p>', '<p>halo</p>', '2022-10-12 12:13:28'),
(26, 8, 22, 'dzaky2636', 'Halo python', 'Halo', '2022-10-12 13:59:04'),
(27, 7, 22, 'dzaky2636', 'Halo C#', 'halo', '2022-10-12 13:59:37'),
(28, 6, 22, 'dzaky2636', 'Halo C++', 'halo', '2022-10-12 13:59:49'),
(29, 5, 22, 'dzaky2636', 'Halo C', 'halo', '2022-10-12 14:00:05'),
(30, 4, 22, 'dzaky2636', 'Halo java', 'halo', '2022-10-12 14:00:17'),
(31, 3, 22, 'dzaky2636', 'Halo JavaScript', 'halo', '2022-10-12 14:00:28'),
(32, 8, 22, 'dzaky2636', 'Halo', 'Halo python', '2022-10-12 14:00:52');

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE `replies` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `author` varchar(20) NOT NULL,
  `body` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `replies`
--

INSERT INTO `replies` (`id`, `post_id`, `author`, `body`, `created_at`) VALUES
(26, 19, 'odokawa47', 'Ada di youtube.', '2022-10-12 11:39:07'),
(27, 19, 'dzaky2636', 'Terima kasih Odokawa.', '2022-10-12 11:40:42'),
(28, 19, 'adminastra47', 'w3schools tempat yang bagus untuk memulai belajar.', '2022-10-12 11:51:07'),
(29, 22, 'adminastra47', 'Halo ini\r\n\r\nlinebreak\r\n\r\nini juga', '2022-10-12 11:57:31'),
(30, 23, 'adminastra48', 'Pendaftaran akan tutup dalam tiga minggu.', '2022-10-12 12:01:39'),
(31, 24, 'adminastra47', 'Mohon untuk tidak menggunakan XSS.', '2022-10-12 12:38:02');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `name`, `created_at`) VALUES
(1, 'HTML', '2022-10-09 00:00:00'),
(2, 'PHP', '2022-10-09 00:00:00'),
(3, 'JavaScript', '2022-10-09 00:00:00'),
(4, 'Java', '2022-10-09 00:00:00'),
(5, 'C', '2022-10-09 00:00:00'),
(6, 'C++', '2022-10-09 00:00:00'),
(7, 'C#', '2022-10-09 00:00:00'),
(8, 'Python', '2022-10-09 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(120) NOT NULL,
  `namalengkap` varchar(50) NOT NULL,
  `email` varchar(40) NOT NULL,
  `fotoprofil` varchar(256) NOT NULL,
  `role` varchar(10) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `is_banned` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `namalengkap`, `email`, `fotoprofil`, `role`, `date_added`, `is_banned`) VALUES
(22, 'dzaky2636', '$2y$10$XRoGzQ4vcGGyqlMtv/yDMOARc.mzQXIO.uX2V0971DY1Gfe3Xy5We', 'Dzaky Fatur Rahman', 'dzaky24@gmail.com', 'example-person.png', 'admin', '2022-10-09 00:00:00', b'0'),
(23, 'bukandzaky', '$2y$10$Ia2BCIxYdMD.Rd5yFf02reZOkLXP4ndOkFXT79RnK2oPSy48YgTDy', 'bukandzaky', 'dzaky2636@gmail.com', 'Chuck_1992.webp', 'admin', '2022-10-09 00:00:00', b'0'),
(27, 'odokawa47', '$2y$10$F/QcZsLyttTaeFoMWeStnuesIYZ55bcedp8zna9hF2tZr5.tiyomi', 'Hiroshi Odokawa', 'odokawa47@gmail.com', 'Screenshot (2097).png', 'user', '2022-10-12 11:38:28', b'0'),
(29, 'adminastra47', '$2y$10$3sZ3sEaQ395EAuH9B7hvsu0IV61k63RfXsw37VFMUXqFXJnixMSH.', 'Admin Astra', 'adminastra@gmail.com', 'Chuck_1992.webp', 'admin', '2022-10-12 11:46:45', b'0'),
(30, 'adminastra48', '$2y$10$l4VOa9ZB.3I5SRSbdp1y9exjj1m8bqAS4o5oaRL0FT7cVEq7vA9Ru', 'Admin Astra 2', 'adminastra@gmail.com', 'dave_mccormack.jpg', 'admin', '2022-10-12 11:59:14', b'0'),
(31, 'dzaky278', '$2y$10$sfhGJOWDrckGVBkSoqFtG.VVDTOgNFrJSxQYbiPdEOyV6HKr2n3.a', 'dzaky', 'dzaky2636@gmail.com', 'default.jpg', 'user', '2022-10-12 12:08:22', b'0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `likes_posts`
--
ALTER TABLE `likes_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes_replies`
--
ALTER TABLE `likes_replies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `likes_posts`
--
ALTER TABLE `likes_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `likes_replies`
--
ALTER TABLE `likes_replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
