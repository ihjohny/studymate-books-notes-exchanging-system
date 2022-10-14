-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2022 at 01:59 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `studymate`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `email` varchar(120) NOT NULL,
  `name` varchar(120) NOT NULL,
  `password` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `email`, `name`, `password`) VALUES
(1, 'admin@email.com', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `name` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`name`) VALUES
('Algorithms'),
('Computer Programming'),
('Data Structure'),
('Economics'),
('English Novel'),
('Science');

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` int(11) NOT NULL,
  `postId` int(11) NOT NULL,
  `posterUserId` int(11) NOT NULL,
  `accepterUserId` int(11) NOT NULL,
  `receiverUserId` int(11) DEFAULT NULL,
  `pendingMsgUserId` int(11) DEFAULT NULL,
  `isSuccess` tinyint(1) NOT NULL,
  `isBlock` tinyint(1) NOT NULL DEFAULT 0,
  `userBlock` tinyint(1) NOT NULL DEFAULT 0,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`id`, `postId`, `posterUserId`, `accepterUserId`, `receiverUserId`, `pendingMsgUserId`, `isSuccess`, `isBlock`, `userBlock`, `createdAt`) VALUES
(15, 15, 4, 5, 5, NULL, 1, 0, 0, '2022-10-12 05:14:22'),
(17, 18, 4, 5, 4, NULL, 1, 0, 0, '2022-10-12 17:54:05'),
(18, 14, 4, 5, 4, NULL, 1, 0, 0, '2022-10-13 05:20:51'),
(19, 20, 5, 4, 5, NULL, 1, 0, 0, '2022-10-13 06:49:52'),
(20, 21, 5, 4, 5, NULL, 1, 0, 0, '2022-10-13 06:50:17'),
(21, 17, 5, 4, 4, NULL, 1, 0, 0, '2022-10-13 07:16:21'),
(22, 22, 4, 5, 4, NULL, 1, 0, 0, '2022-10-13 07:38:57'),
(23, 19, 5, 4, NULL, NULL, 0, 0, 0, '2022-10-13 10:02:27'),
(24, 24, 11, 6, NULL, NULL, 0, 0, 0, '2022-10-13 11:58:01');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `name` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`name`) VALUES
('Applied Math'),
('CSTE'),
('EEE'),
('ICE'),
('SE');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `conversationId` int(11) NOT NULL,
  `message` varchar(500) NOT NULL,
  `userId` int(11) NOT NULL,
  `userName` varchar(100) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `writerName` varchar(100) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `category` varchar(120) DEFAULT NULL,
  `type` varchar(15) NOT NULL,
  `isSuccess` tinyint(1) NOT NULL DEFAULT 0,
  `isBlock` tinyint(1) NOT NULL DEFAULT 0,
  `userBlock` tinyint(1) NOT NULL DEFAULT 0,
  `userId` int(11) NOT NULL,
  `photo` longblob DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `writerName`, `description`, `category`, `type`, `isSuccess`, `isBlock`, `userBlock`, `userId`, `photo`, `createdAt`) VALUES
(14, 'post one', 'post one', '', 'Networking', 'Request', 1, 0, 0, 4, 0x2e2f696d616765732f313839343336303031382e706e67, '2022-10-12 05:11:52'),
(15, 'post two', '', '', 'Algorithms', 'Donate', 1, 0, 0, 4, 0x2e2f696d616765732f323034353330323430332e706e67, '2022-10-12 05:12:07'),
(16, 'post three', '', '', 'Economics', 'Request', 0, 0, 0, 5, 0x2e2e2f696d672f64656d6f5f626f6f6b2e737667, '2022-10-12 05:14:10'),
(17, 'dfsdsfg', '', '', 'Algorithms', 'Donate', 1, 0, 0, 5, 0x2e2e2f696d672f64656d6f5f626f6f6b2e737667, '2022-10-12 14:54:47'),
(18, 'post two', '', '', 'Algorithms', 'Request', 1, 0, 0, 4, 0x2e2e2f696d672f64656d6f5f626f6f6b2e737667, '2022-10-12 17:47:24'),
(19, 'fdgdsfg', '', '', 'Algorithms', 'Donate', 0, 0, 0, 5, 0x2e2e2f696d672f64656d6f5f626f6f6b2e737667, '2022-10-13 06:25:31'),
(20, 'sdfsdf', '', '', 'Algorithms', 'Request', 1, 0, 0, 5, 0x2e2e2f696d672f64656d6f5f626f6f6b2e737667, '2022-10-13 06:49:45'),
(21, 'sdfds', '', '', 'Algorithms', 'Request', 1, 0, 0, 5, 0x2e2e2f696d672f64656d6f5f626f6f6b2e737667, '2022-10-13 06:50:13'),
(22, 'fsdf', '', '', 'Algorithms', 'Request', 1, 0, 0, 4, 0x2e2e2f696d672f64656d6f5f626f6f6b2e737667, '2022-10-13 07:38:48'),
(23, 'userthree', '', '', 'Data Structure', 'Request', 0, 0, 0, 6, 0x2e2e2f696d672f64656d6f5f626f6f6b2e737667, '2022-10-13 11:56:20'),
(24, 'ihjohny10', '', '', 'English Novel', 'Request', 0, 0, 0, 11, 0x2e2e2f696d672f64656d6f5f626f6f6b2e737667, '2022-10-13 11:57:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `point` int(11) NOT NULL,
  `password` varchar(20) NOT NULL,
  `department` varchar(50) NOT NULL,
  `roll` varchar(50) NOT NULL,
  `photo` longblob DEFAULT NULL,
  `isBlock` tinyint(1) NOT NULL DEFAULT 0,
  `giveCount` int(11) NOT NULL DEFAULT 0,
  `takeCount` int(11) NOT NULL DEFAULT 0,
  `verify` tinyint(1) NOT NULL DEFAULT 0,
  `verificationCode` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `address`, `phone`, `point`, `password`, `department`, `roll`, `photo`, `isBlock`, `giveCount`, `takeCount`, `verify`, `verificationCode`) VALUES
(4, 'user one', 'userone@gmail.com', 'user one address', '01763183408', 1, 'userone', 'ICE', 'ASH1611022M', 0x2e2f696d616765732f313237393637363534352e6a7067, 0, 2, 3, 1, '0'),
(5, 'md. imam hossain', 'usertwo@gmail.com', 'user two address', '01763183402', 3, 'admin', 'SE', 'ASH1611022M', 0x2e2f696d616765732f3337353037303137332e706e67, 0, 3, 2, 0, '0'),
(6, 'user three', 'userthree@gmail.com', 'user three address', '01763183101', 2, 'userthree', 'EEE', 'ASH1611028M', 0x2e2f696d616765732f313737313230343333362e706e67, 0, 0, 0, 1, '966455ab4b4'),
(11, 'ihjohny10', 'ihjohny10@gmail.com', 'ihjohny10 address', '01763183101', 2, 'ihjohny10', 'EEE', 'ASH1611022M', 0x2e2f696d616765732f3434313433353532382e6a7067, 0, 0, 0, 1, '42e0e7870b077ba6db7d672c1bfe68ed');

-- --------------------------------------------------------

--
-- Table structure for table `user_category`
--

CREATE TABLE `user_category` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `category` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_category`
--

INSERT INTO `user_category` (`id`, `userId`, `category`) VALUES
(8, 5, 'Computer Programming'),
(9, 5, 'English Novel'),
(10, 11, 'Data Structure'),
(11, 6, 'Data Structure');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_category`
--
ALTER TABLE `user_category`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_category`
--
ALTER TABLE `user_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
