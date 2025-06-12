-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2024 at 03:51 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sql7779546`
--
CREATE DATABASE IF NOT EXISTS d0019e_blog;
USE d0019e_blog;
-- --------------------------------------------------------
-- Delete tables
DROP TABLE IF EXISTS image;
DROP TABLE IF EXISTS post;
DROP TABLE IF EXISTS user;

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `presentation` mediumtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- -------------------------------------------------------
--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `userId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  CONSTRAINT `post_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `postId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `postId` (`postId`),
  CONSTRAINT `image_ibfk_1` FOREIGN KEY (`postId`) REFERENCES `post` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Indexes for dumped tables
--

--
-- Indexes for table `image`
--
-- ALTER TABLE `image`
--  ADD PRIMARY KEY (`id`),
--   ADD KEY `postId` (`postId`) USING BTREE;

--
-- Indexes for table `post`
--
-- ALTER TABLE `post`
--   ADD PRIMARY KEY (`id`),
--   ADD KEY `userId` (`userId`);

--
-- Indexes for table `user`
--
-- ALTER TABLE `user`
--   ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `image`
--
-- ALTER TABLE `image`
--   MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post`
--
-- ALTER TABLE `post`
--   MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
-- ALTER TABLE `user`
--   MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
--
-- Alter table for online database 
--
-- ALTER TABLE `user`
-- MODIFY COLUMN `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;

-- ALTER TABLE `post`
-- MODIFY COLUMN `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;

-- ALTER TABLE `image`
-- MODIFY COLUMN `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;


-- Constraints for dumped tables
--

--
-- Constraints for table `image`
--
-- ALTER TABLE `image`
--  ADD CONSTRAINT `image_ibfk_1` FOREIGN KEY (`postId`) REFERENCES `post` (`id`);

--
-- Constraints for table `post`
--
-- ALTER TABLE `post`
--   ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`);
-- COMMIT;

--
-- Insert data into tables
--

--
-- insert into user
--
-- Insert a sample user into the user table
INSERT INTO user (username, password, title, presentation, image, created)
VALUES
    ('hassan', '$2y$10$4iRvzIW2gqglfDNXndb/ZuG2MYwX5BiI5G07un8YFQsAGIaSanmVa', 'Mr.', 'A passionate blogger.', 'default.jpg', NOW()),
     ('ali', '$2y$10$AdfmczjnhE06PYuGXCTm6uP4CmvD8TatvMbVXZQ8pYvcJANHvZVO2', 'Mr.', 'A dedicated blogger.', 'default.jpg', NOW()),
       ('test', '$2y$10$qrIG1UcLTQIcj9YA3pvUW.5EutbCMIRD3bUYm0vMpilncXqUPG2my', 'Mr.', 'A new blogger.', 'default.jpg', NOW());

--
-- Insert data into database table post
--

-- Insert sample posts into the posts table
INSERT INTO post (title, content, created, userId)
VALUES
    ('My Journey with Coding', 'I started learning coding a few years ago, and it has been an exciting journey filled with challenges and growth.', NOW(), 1),
    ('Why Blogging Matters', 'Blogging allows me to share my thoughts and experiences with the world.', NOW(), 1),
    ('First Blog Post', 'This is the content of the first blog post.', NOW(), 2),
    ('Second Blog Post', 'Here is the content for the second blog post.', NOW(), 2),
    ('Third Blog Post', 'This is the content of the third blog post.', NOW(), 2),
    ('First Blog Post', 'This is the content of the first blog post.', NOW(), 3);

--
-- Insert data into database table post
--

-- Insert sample posts into the image table
INSERT INTO image (filename, description, created, postId)
VALUES
    ('mvc.png', 'Sample descr test.', NOW(), 1),
    ('banner.jpg', 'Sample descr test..', NOW(), 2),
    ('mvc.png', 'Sample descr test.', NOW(), 3),
    ('hh_logo_b.png', 'Sample descr test..', NOW(), 4),
    ('hh_logo_b.png', 'Sample descr test.', NOW(), 5);
    
    
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
