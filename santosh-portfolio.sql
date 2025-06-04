-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2025 at 05:26 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `santosh-portfolio`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_me_content`
--

CREATE TABLE `about_me_content` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_me_content`
--

INSERT INTO `about_me_content` (`id`, `name`, `role`, `description`, `image_path`, `email`, `location`) VALUES
(1, 'Santosh', 'Full-Stack Developer', 'I am a Developer based in Kathmandu, Nepal. I am passionate about coding, enhancing my skills, and creating innovative applications and websites. I specialize in building WebApps and websites using modern technologies. Constantly striving to improve and deliver value, I love working on both personal and professional projects.', 'assets/images/imgg.avif', '1.santoshadh@gmail.com', 'Madhyapur Thimi, Bhaktapur, Nepal');

-- --------------------------------------------------------

--
-- Table structure for table `about_me_links`
--

CREATE TABLE `about_me_links` (
  `id` int(11) NOT NULL,
  `about_me_content_id` int(11) NOT NULL,
  `link_text` varchar(100) NOT NULL,
  `url` varchar(255) NOT NULL,
  `icon_class` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_me_links`
--

INSERT INTO `about_me_links` (`id`, `about_me_content_id`, `link_text`, `url`, `icon_class`) VALUES
(1, 1, 'About More', 'http://www.santoshadhikari111.com.np/?i=1', 'fas fa-chevron-right');

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`, `created_at`, `email`) VALUES
(1, 'Santosh', '$2y$10$Jq9cYGmHzNlXWM5U3SjzIOtrtwi.iO35YIEh5TlxICq2KrKmAV24u', '2025-06-03 23:26:29', '1.santoshadh@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `message` text NOT NULL,
  `submitted_at` datetime DEFAULT current_timestamp(),
  `replied` tinyint(1) DEFAULT 0,
  `is_read` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE `education` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `institution` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `timeline` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `experience`
--

CREATE TABLE `experience` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `position_order` int(11) DEFAULT 0,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `homepage_content`
--

CREATE TABLE `homepage_content` (
  `id` int(11) NOT NULL,
  `greeting` varchar(255) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `intro_text` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `homepage_content`
--

INSERT INTO `homepage_content` (`id`, `greeting`, `name`, `intro_text`, `image_path`) VALUES
(1, 'Namaste, I&#39;m', 'Santosh', 'I am passionate about ...', './assets/images/hero.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `view_url` varchar(255) DEFAULT NULL,
  `code_url` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `alt_text` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `social_links`
--

CREATE TABLE `social_links` (
  `id` int(11) NOT NULL,
  `homepage_content_id` int(11) DEFAULT NULL,
  `platform_name` varchar(50) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `icon_class` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `social_links`
--

INSERT INTO `social_links` (`id`, `homepage_content_id`, `platform_name`, `url`, `icon_class`) VALUES
(1, 1, 'LinkedIn', 'https://www.linkedin.com/in/santosh-adhikari-79a783233/', 'fab fa-linkedin'),
(2, 1, 'GitHub', 'https://github.com/2santosh', 'fab fa-github'),
(3, 1, 'Twitter', 'https://twitter.com/aslicecode', 'fab fa-twitter');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_me_content`
--
ALTER TABLE `about_me_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `about_me_links`
--
ALTER TABLE `about_me_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `about_me_content_id` (`about_me_content_id`);

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `experience`
--
ALTER TABLE `experience`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `homepage_content`
--
ALTER TABLE `homepage_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_links`
--
ALTER TABLE `social_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `homepage_content_id` (`homepage_content_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_me_content`
--
ALTER TABLE `about_me_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `about_me_links`
--
ALTER TABLE `about_me_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `education`
--
ALTER TABLE `education`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `experience`
--
ALTER TABLE `experience`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `homepage_content`
--
ALTER TABLE `homepage_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `social_links`
--
ALTER TABLE `social_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `about_me_links`
--
ALTER TABLE `about_me_links`
  ADD CONSTRAINT `about_me_links_ibfk_1` FOREIGN KEY (`about_me_content_id`) REFERENCES `about_me_content` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `social_links`
--
ALTER TABLE `social_links`
  ADD CONSTRAINT `social_links_ibfk_1` FOREIGN KEY (`homepage_content_id`) REFERENCES `homepage_content` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
