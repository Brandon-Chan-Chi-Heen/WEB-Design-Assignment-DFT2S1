-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 05, 2021 at 06:03 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `assignment`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `admin_id` varchar(20) NOT NULL,
  `password` varchar(30) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`admin_id`, `password`, `first_name`, `last_name`) VALUES
('1', '1', 'brandon', 'chan'),
('2', '1234', 'Hee', 'Jun Hua'),
('3', '5678', 'Ali', 'Bin Abu'),
('4', '12345678', 'Chan', 'Kai Gui'),
('5', 'henry1234', 'Henry', 'Yim Kah Hing'),
('6', 'kimwah1234', 'Tan', 'Kim Wah');

-- --------------------------------------------------------

--
-- Table structure for table `bookmarks`
--

CREATE TABLE `bookmarks` (
  `bookmark_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `Event_Title` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `user_id` int(11) NOT NULL,
  `Event_Title` varchar(30) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `Event_Title` varchar(30) NOT NULL,
  `Event_Description` varchar(400) NOT NULL,
  `Event_Price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`Event_Title`, `Event_Description`, `Event_Price`) VALUES
('3 Wealth Creation Strategies', '\"Nothing comes easy, but everything is possible\" - Ernie Chen Dear Tarcians, we have proudly invited Sifu Ernie Chen, Asia\'s No.1 Business Coach to conduct a webinar with us! Date= 21/01/21 Time= 8pm-9.30pm Venue=Zoom Sifu Ernie is Asia\'s No.1 Business Coach & also a serial entrepreneur who has mentored, coached & helped many individuals, entrepreneurs, SME business owners, multinational companies', 33.66),
('Employee Investor Program', 'Introducing Mr Alfred Chen from 松大资本集团 Grandpine Capital who will be conducting a webinar with us on July 8, 2021!!! Mr Alfred is an experienced and professional investor that you wouldn’t want to miss! This webinar aims to educate students on proper financial planning methods especially when one steps into the corporate world. Thirst for knowledge? Wish to stay competitive and relevant? Join us! ', 16.95),
('Financial Leteracy Workshop', 'Always heard of Rich Dad Poor Dad, but never knew what it is. Then, THIS IS FOR YOU!!\r\n                        Bringing to you, our Financial Literacy Workshop organized by Aspiratio Advisory happening this August‼️ \r\n                        Come join our team to this fun-filled workshop and gain multiple insights which would enable you to: \r\n                        ✅ Increase your awareness on th', 24.95),
('Investing Note Trading Cup', 'Hey, you know what? We have a good news for you!! Go head-to-head with other traders in the Biggest & Most Exciting Virtual Trading Tournament in Malaysia: Participants will be given RM100,000 virtual capital to trade Bursa Malaysia listed stock using real market data. Total worth up to RM30,000 of GRAND prizes up for win and the tournament is Free-For-All to join! Register, trade and stand a chan', 24.95),
('Power Up Your FQ', 'We received some enquiries about the Soft Skill Points and entrance fee! Don’t worry, “Power Up You FQ! ” doesn’t require entrance fee, just make sure you’ve filled in & submitted the participant registration form successfully to enroll into the webinar on 10 June ! And yes! Soft Skill Points will be provided for TARUC students who’re pursuing studies in KL Campus (fill in your name, student ID, e', 35.95);

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE `participants` (
  `participant_id` int(11) NOT NULL,
  `user_id` int(8) NOT NULL,
  `Event_Title_FK` varchar(30) NOT NULL,
  `gender` varchar(1) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `participants`
--

INSERT INTO `participants` (`participant_id`, `user_id`, `Event_Title_FK`, `gender`, `first_name`, `last_name`) VALUES
(2, 2, '3 Wealth Creation Strategies', 'M', 'Hee', 'Jun Hua'),
(3, 3, 'Employee Investor Program', 'M', 'Ali', 'Bin Abu'),
(8, 1, '3 Wealth Creation Strategies', 'M', 'Brandon', 'Chan Chi Heen'),
(11, 4, 'Financial Leteracy Workshop', 'F', 'Nam', 'Kue Hueh'),
(13, 1, 'Employee Investor Program', 'M', 'Brandon', 'Chan Chi Heen'),
(14, 5, 'Investing Note Trading Cup', 'F', 'Hue', 'Huehue');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `gender` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email`, `first_name`, `last_name`, `password`, `gender`) VALUES
(1, 'heenbrandon@gmail.com', 'Brandon', 'Chan Chi Heen', '1234', 'M'),
(2, 'heejunhua@gmail.com', 'Hee', 'Jun Hua', '1234', 'M'),
(3, 'alibinabu@gmail.com', 'Ali', 'Bin Abu', 'AliBinAbu', 'M'),
(4, 'namkuehueh@gmail.com', 'Nam', 'Kue Hueh', 'namkuekueh', 'F'),
(5, 'huehuehue@gmail.com', 'Hue', 'Huehue', 'huehuehue', 'F'),
(6, 'Anothony@gmail.com', 'Anothony', 'Delius Dlice', '1234512345', 'M');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD PRIMARY KEY (`bookmark_id`,`user_id`,`Event_Title`),
  ADD UNIQUE KEY `user_id` (`user_id`,`Event_Title`),
  ADD KEY `bookmarkEventTitle` (`Event_Title`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`user_id`,`Event_Title`),
  ADD KEY `cartEventTitle` (`Event_Title`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`Event_Title`);

--
-- Indexes for table `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`participant_id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`Event_Title_FK`),
  ADD KEY `eventTitleParticipant` (`Event_Title_FK`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `bookmark_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `participants`
--
ALTER TABLE `participants`
  MODIFY `participant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD CONSTRAINT `bookmarks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `eventTitle` FOREIGN KEY (`Event_Title`) REFERENCES `event` (`Event_Title`);

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cartEventTitle` FOREIGN KEY (`Event_Title`) REFERENCES `event` (`Event_Title`),
  ADD CONSTRAINT `cartUser` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `participants`
--
ALTER TABLE `participants`
  ADD CONSTRAINT `UserId` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `eventTitleParticipant` FOREIGN KEY (`Event_Title_FK`) REFERENCES `event` (`Event_Title`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;