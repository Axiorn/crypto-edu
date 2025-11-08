-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 08, 2025 at 12:38 AM
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
-- Database: `crypto_edu`
--

-- --------------------------------------------------------

--
-- Table structure for table `demo_passwords`
--

CREATE TABLE `demo_passwords` (
  `id` int NOT NULL,
  `original` text NOT NULL,
  `scrypt_hash` text NOT NULL,
  `chacha_encrypted` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `demo_passwords`
--

INSERT INTO `demo_passwords` (`id`, `original`, `scrypt_hash`, `chacha_encrypted`, `created_at`) VALUES
(5, '123', '$argon2id$v=19$m=65536,t=2,p=1$njdKsMCKD+7Qfc1/G2bHuA$LEQG4tJMkEvnQ4KalOUgFxxahZULWoKwfQnc274CMKE', 'q7RvaXogRpzC088C/8BDTB02cu4XGex+bheF6K3ovA6bC4BNEpx9Sao07y3mpfc9E+rXN8Rlr9NTr/Vo3Oq1L8ozqEeKGnKQ4RfJNY2ZjQQINBqQDrm25jAMYHVa/s9HeCG0VS//vFBptSRavK3ebI+30Iiy1A53xHzUwDAULjRI6XLmnZUWk1M=', '2025-11-08 00:04:37'),
(6, '321', '$argon2id$v=19$m=65536,t=2,p=1$1icNBo7YHxIfx9wF7EbaZA$CKkcWH9Ayfg2GS4bjvtWVLLMnG7rKeE9UOAEKdzJnL0', '5t14BKuPMFYhOpkCD7jqEE3QDihnwTH6fUN2qLOIMPo+kR64Vzb5zk+9rqxMEcJ1IsWYhWnDe6dvwIe0E+QOZAzbKc4FeYgL/N1NwJ4Bb93iqfmC/YQs0hSKjOXu1nDPB8/GANzhxxlCXIifuOiVyXSFS+0IulppU+Bs1r1VW50peWb+HidYWPU=', '2025-11-08 00:04:44');

-- --------------------------------------------------------

--
-- Table structure for table `demo_texts`
--

CREATE TABLE `demo_texts` (
  `id` int NOT NULL,
  `original` text NOT NULL,
  `super_encrypted` text NOT NULL,
  `chacha_encrypted` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password_hash`, `created_at`) VALUES
(13, 'rudi', 'ATxFfVkl5bzEutvUMlKFQG0xCy5tmai/IHPpeJWvwdu8gcSvk9QF8rKUK5Ba3icyME05Roy75273amkTg1oCn7lHujLkQulEJxkZc7KAWSkSvXsoE6BpG1ITrv5gQnZlXN0uLXzlH3k0TeZ+TZ4coil5uj7ipzKpGg==', '2025-11-07 12:41:25'),
(14, 'ahmad', 'gLWMcP8u96Gj07bdGh+VBVWC3uH8K01A0p43gfvEKkmv3aMnCyDMvRwtv6DEAMm6+NLCmBpfn/3IwdBGFZXjar5Q1ZH5HMvK768DyIwloNDrvx0ZYR4ovZB3xI98mt7BYnJI+p/5oK7PCWl2VbRvpapa09kXmOzokw==', '2025-11-07 12:47:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `demo_passwords`
--
ALTER TABLE `demo_passwords`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `demo_texts`
--
ALTER TABLE `demo_texts`
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
-- AUTO_INCREMENT for table `demo_passwords`
--
ALTER TABLE `demo_passwords`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `demo_texts`
--
ALTER TABLE `demo_texts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
