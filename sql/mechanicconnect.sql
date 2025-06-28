-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2025 at 08:28 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mechanicconnect`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `mechanic_id` int(11) DEFAULT NULL,
  `service_type` varchar(100) DEFAULT NULL,
  `job_description` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `location` text DEFAULT NULL,
  `preferred_time` varchar(255) DEFAULT NULL,
  `requested_date` date NOT NULL,
  `time_flexibility` enum('yes','no') DEFAULT NULL,
  `status` varchar(255) DEFAULT 'pending',
  `created_at` time NOT NULL DEFAULT current_timestamp(),
  `proposed_date` date DEFAULT NULL,
  `proposed_time` time DEFAULT NULL,
  `reschedule_reason` text DEFAULT NULL,
  `reschedule_requested_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `client_id`, `mechanic_id`, `service_type`, `job_description`, `phone`, `location`, `preferred_time`, `requested_date`, `time_flexibility`, `status`, `created_at`, `proposed_date`, `proposed_time`, `reschedule_reason`, `reschedule_requested_at`) VALUES
(12, 57, 58, 'Battery Replacement', 'add a new battery', '0775282655', 'Kochchikade', NULL, '0000-00-00', 'yes', 'confirmed', '13:03:49', NULL, NULL, NULL, NULL),
(15, 57, 69, 'cutting', 'Place a new door', '0775282655', '106/4 , sandamali,  palangathuraya , kochchikade', 'in the day', '2025-05-23', 'yes', 'confirmed', '01:42:54', NULL, NULL, NULL, NULL),
(16, 57, 69, 'Framing', 'Make window', '0775282655', '106/4 , sandamali,  palangathuraya , kochchikade', 'in the day', '2025-05-23', 'yes', 'pending', '01:54:52', NULL, NULL, NULL, NULL),
(17, 57, 69, 'Other', 'Place a door', '0775282655', '106/4 , sandamali,  palangathuraya , kochchikade', '19:28:00', '2025-05-22', 'yes', 'confirmed', '01:55:45', NULL, NULL, NULL, NULL),
(18, 57, 69, 'fixing', 'place a new door', '0775282655', '106/4 , sandamali,  palangathuraya , kochchikade', '22:55:00', '2025-05-22', 'yes', 'confirmed', '06:20:58', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mechanic_services`
--

CREATE TABLE `mechanic_services` (
  `id` int(11) NOT NULL,
  `mechanic_id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mechanic_services`
--

INSERT INTO `mechanic_services` (`id`, `mechanic_id`, `service_name`) VALUES
(1, 69, 'cutting'),
(2, 69, 'fixing'),
(3, 69, 'Framing'),
(4, 69, 'Formwork');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `message` text NOT NULL,
  `related_booking_id` int(11) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `type`, `message`, `related_booking_id`, `is_read`, `created_at`) VALUES
(6, 57, 'reschedule_request', 'Your mechanic proposed a new time for your booking. Please confirm or reject.', 17, 1, '2025-05-20 23:56:15'),
(7, 57, 'reschedule_request', 'Your mechanic proposed a new time for your booking. Please confirm or reject.', 18, 1, '2025-05-21 04:24:35');

-- --------------------------------------------------------

--
-- Table structure for table `service_categories`
--

CREATE TABLE `service_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_categories`
--

INSERT INTO `service_categories` (`id`, `name`) VALUES
(6, 'Appliance Installation'),
(1, 'Carpenter'),
(3, 'Electrician'),
(5, 'Furniture Assembly'),
(7, 'Landscaping'),
(4, 'Painting'),
(8, 'Roof Repair'),
(10, 'sola');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `email_verified` tinyint(1) DEFAULT 0,
  `verification_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `status`, `created_at`, `email_verified`, `verification_token`) VALUES
(57, 'vimukthis830@gmail.com', '$2y$10$JxhsmFUe3aPufs8IAi8ELefx2HQfMU7A62077oCXUFjqigfkwDzva', 'active', '2025-05-20 08:50:54', 0, '176c42c0766ccd9b2caf3338f135099ea90e8af20712300265eeca92bed650ec'),
(68, 'perera@gmail.com', '$2y$10$qE2M7K1ua6uZfmNAgvm3n.HP1/3.r.ZW6D0YsExGhHzuPXJjpAWWy', 'active', '2025-05-20 19:53:36', 0, NULL),
(69, 'sahan@gmail.com', '$2y$10$PT6apTj2j4MXLgDboPNVgOlwpLQnOpfDj1khVIQHk.Aet6A6szSD6', 'active', '2025-05-20 20:17:12', 0, NULL),
(70, 'kavindu@gmail.com', '$2y$10$auutAkR37IyRFVgVhHoufesTp0fMuOn85onG1DaedBoa6ytUJNe1i', 'reject', '2025-05-20 20:19:42', 0, NULL),
(71, 'chathu@gmail.com', '$2y$10$Yk27fzOfi3O2kc.sgh6Xqeiz13FPu/BzJReNNaGShGiquLw/7OdNa', 'active', '2025-05-20 20:24:05', 0, NULL),
(72, 'nadun@gmail.com', '$2y$10$UQZ/mifkqYbNzSEH2VVDKutZ60KNTexzV5GFRkk1Q2Zz30NlvnZlC', 'active', '2025-05-20 20:25:45', 0, NULL),
(73, 'avi@gmail.com', '$2y$10$N6MlZbb5Ar5jvm/qdJf4uezoklCIyeVWjBGoIl5kyaizZyWQjEIgO', 'active', '2025-05-21 00:41:43', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `service_category` varchar(255) DEFAULT NULL,
  `experience` int(11) DEFAULT NULL,
  `skills` text DEFAULT NULL,
  `hourly_rate` decimal(10,2) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `user_role` varchar(50) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `district` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`id`, `user_id`, `full_name`, `phone`, `address`, `service_category`, `experience`, `skills`, `hourly_rate`, `first_name`, `last_name`, `user_role`, `profile_image`, `province`, `district`, `city`) VALUES
(31, 57, NULL, '0771748485', 'negombo', NULL, NULL, NULL, NULL, 'Vimukthi', 'Sankalpa', 'client', '57_1747801307.jpg', NULL, NULL, NULL),
(42, 68, 'VDP Perera', '0771748485', '106/4sandamali,palagathure,kochchikade', 'Electrician', 2, 'cutting', 1000.00, NULL, NULL, 'mechanic', 'img_682ce8e2f3c678.40496445.jpg', 'Western', 'Gampaha', 'Negombo'),
(43, 69, 'Sahan Malcom', '0777473526', '106/4sandamali,palagathure,kochchikade', 'Carpenter', 4, 'cutting', 5.00, NULL, NULL, 'mechanic', 'img_682d5541497e69.37495502.jpg', 'Western', 'Gampaha', 'kochchikade'),
(44, 70, 'kavindu Silva', '0771748485', '106/4sandamali,palagathure,kochchikade', 'Painting', 6, 'cutting', 3.00, NULL, NULL, 'mechanic', 'img_682ce94b5f0181.15440567.jpg', 'Uva', 'Badulla', 'haputale'),
(45, 71, 'Chathu Nimesh', '0771748485', '106/4sandamali,palagathure,kochchikade', 'Painting', 4, 'cutting', 3.00, NULL, NULL, 'mechanic', 'img_682ce4e5185d73.45736570.jpg', 'Northern', 'Kilinochchi', 'puttalam'),
(46, 72, 'Nadun Idush', '0777473526', '106/4sandamali,palagathure,kochchikade', 'Appliance Installation', 4, 'cutting', 5.00, NULL, NULL, 'mechanic', 'img_682ce54921e7b4.32911881.jpg', 'Central', 'Kandy', 'nuwara'),
(47, 73, 'Avinash Fernando', '0771748485', '106/4sandamali,palagathure,kochchikade', 'Electrician', 0, NULL, 6.00, NULL, NULL, 'mechanic', 'img_682d2147aeffa1.13951471.jpg', 'Western', 'Gampaha', 'Negombo');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mechanic_services`
--
ALTER TABLE `mechanic_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mechanic_id` (`mechanic_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `related_booking_id` (`related_booking_id`);

--
-- Indexes for table `service_categories`
--
ALTER TABLE `service_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `mechanic_services`
--
ALTER TABLE `mechanic_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `service_categories`
--
ALTER TABLE `service_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mechanic_services`
--
ALTER TABLE `mechanic_services`
  ADD CONSTRAINT `mechanic_services_ibfk_1` FOREIGN KEY (`mechanic_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_details` (`user_id`),
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`related_booking_id`) REFERENCES `bookings` (`id`);

--
-- Constraints for table `user_details`
--
ALTER TABLE `user_details`
  ADD CONSTRAINT `user_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
