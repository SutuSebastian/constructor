-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 27, 2020 at 02:54 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `constructor`
--

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created` varchar(25) NOT NULL,
  `modified` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `type` varchar(10) NOT NULL,
  `author` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `name`, `created`, `modified`, `status`, `type`, `author`) VALUES
(14, 'styles', '14 Jul 2019 - 5:41 PM', '14 Jul 2019 - 7:01 PM', 1, 'css', 'admin'),
(15, 'main', '14 Jul 2019 - 5:41 PM', '14 Jul 2019 - 7:02 PM', 1, 'js', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `published` tinyint(1) NOT NULL,
  `link` varchar(50) NOT NULL,
  `last_update` varchar(25) NOT NULL,
  `created` varchar(25) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `robots` varchar(20) DEFAULT 'index, follow',
  `author` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `published`, `link`, `last_update`, `created`, `description`, `keywords`, `robots`, `author`) VALUES
(24, 'Home', 1, 'home', '16 Aug 2019 - 10:24 PM', '14 Jul 2019 - 5:22 PM', '', '', 'index, follow', 'admin'),
(36, 'About', 1, 'about', '27 Jan 2020 - 4:45 PM', '27 Jan 2020 - 4:44 PM', NULL, NULL, 'index, follow', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset`
--

CREATE TABLE `password_reset` (
  `id` int(15) NOT NULL,
  `email` text NOT NULL,
  `selector` text NOT NULL,
  `token` text NOT NULL,
  `expires` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `total_visits`
--

CREATE TABLE `total_visits` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(30) NOT NULL,
  `visit_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `unique_visits`
--

CREATE TABLE `unique_visits` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(30) NOT NULL,
  `visit_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id` int(10) NOT NULL,
  `fullname` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `last_activity` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `id`, `fullname`, `email`, `type`, `last_activity`) VALUES
('admin', '$2y$10$cHZZfA031GBHoY4PBLTR3uWp9HFHEtTXk3TJ4JG1ETXDO1dG4U/UK', 3, 'Administrator', '', 2, '27 Jan 2020 - 2:47 PM');

-- --------------------------------------------------------

--
-- Table structure for table `website`
--

CREATE TABLE `website` (
  `id` int(10) NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT 'Website',
  `description` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `author` varchar(50) NOT NULL,
  `robots` varchar(20) NOT NULL,
  `favicon` varchar(255) NOT NULL,
  `maintenance` tinyint(1) NOT NULL DEFAULT 0,
  `default_page` varchar(255) DEFAULT NULL,
  `ga_code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `website`
--

INSERT INTO `website` (`id`, `title`, `description`, `keywords`, `author`, `robots`, `favicon`, `maintenance`, `default_page`, `ga_code`) VALUES
(1, 'Demo Website', '', '', '', 'noindex, nofollow', '', 0, 'home', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `total_visits`
--
ALTER TABLE `total_visits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unique_visits`
--
ALTER TABLE `unique_visits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`password`);

--
-- Indexes for table `website`
--
ALTER TABLE `website`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `total_visits`
--
ALTER TABLE `total_visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unique_visits`
--
ALTER TABLE `unique_visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
