-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 10, 2022 at 02:18 PM
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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `name` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`name`) VALUES
('Bangla'),
('Math'),
('English Novel'),
('Programming');

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
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`id`, `postId`, `posterUserId`, `accepterUserId`, `receiverUserId`, `pendingMsgUserId`, `isSuccess`, `createdAt`) VALUES
(1, 2, 1, 2, 1, NULL, 1, '2022-10-10 12:07:07');

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

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `conversationId`, `message`, `userId`, `userName`, `createdAt`) VALUES
(1, 1, 'test message', 1, 'user one', '2022-10-10 12:10:45'),
(2, 1, 'test', 1, 'user one', '2022-10-10 12:15:13'),
(3, 1, 'tets', 2, 'user two', '2022-10-10 12:15:19'),
(4, 1, 'test', 2, 'user two', '2022-10-10 12:15:40');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `writerName` varchar(100) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `tag` varchar(50) DEFAULT NULL,
  `type` varchar(15) NOT NULL,
  `isSuccess` tinyint(1) NOT NULL DEFAULT 0,
  `userId` int(11) NOT NULL,
  `photo` longblob DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `writerName`, `description`, `tag`, `type`, `isSuccess`, `userId`, `photo`, `createdAt`) VALUES
(2, 'test post', 'test writer', 'test description', 'Bangla', 'Request', 1, 1, 0x2e2f696d616765732f3831323435343232332e706e67, '2022-10-10 11:27:40'),
(3, 'book offer', 'Mr. Xsdfds', 'sdfsdaf', 'Programming', 'Offer', 0, 2, 0x2e2e2f696d672f64656d6f5f626f6f6b2e737667, '2022-10-10 12:12:05');

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
  `photo` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `address`, `phone`, `point`, `password`, `department`, `roll`, `photo`) VALUES
(1, 'user one', 'userone@gmail.com', 'user one address', '01763183408', 1, 'userone', 'ice', 'ASH1611029M', 0x696d616765732f3536353537383430312e706e67),
(2, 'user two', 'usertwo@gmail.com', 'user two address', '01763183401', 3, 'usertwo', 'eee', 'ASH1611022M', 0x2e2f696d616765732f3530313530363734312e706e67);

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
(4, 1, 'Math'),
(5, 1, 'English Novel');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_category`
--
ALTER TABLE `user_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
