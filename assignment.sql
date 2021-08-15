-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 15, 2021 at 01:54 PM
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
-- Table structure for table `display_event`
--

CREATE TABLE `display_event` (
  `Event_Title` varchar(30) NOT NULL,
  `Event_Description` text NOT NULL,
  `Event_Price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `display_event`
--

INSERT INTO `display_event` (`Event_Title`, `Event_Description`, `Event_Price`) VALUES
('3 Wealth Creation Strategies', '\"Nothing comes easy, but everything is possible\" - Ernie Chen Dear Tarcians, we have proudly invited Sifu Ernie Chen, Asia\'s No.1 Business Coach to conduct a webinar with us! Date= 21/01/21 Time= 8pm-9.30pm Venue=Zoom Sifu Ernie is Asia\'s No.1 Business Coach & also a serial entrepreneur who has mentored, coached & helped many individuals, entrepreneurs, SME business owners, multinational companies all over Asia in the areas of business, marketing, property investments & stock investments He is also a TV & Radio personality, award winning director & a producer producing box office hit movies! If you are wondering on: 1.How to create a cash generating machine to increase cash flow immediately both online & offline? 2. How to invest in stock market to generate 30% ROI consistently without any technical knowledge? 3. How to invest with very little or no money down in properties with other peoples\' money & gain massive capital gains?', 16.95),
('Employee Investor Program', 'Introducing Mr Alfred Chen from 松大资本集团 Grandpine Capital who will be conducting a webinar with us on July 8, 2021!!! Mr Alfred is an experienced and professional investor that you wouldn’t want to miss! This webinar aims to educate students on proper financial planning methods especially when one steps into the corporate world. Thirst for knowledge? Wish to stay competitive and relevant? Join us! Date: July 8, 2021 (8PM - 10PM) Venue: Google Meet (link will be provided via WhatsApp upon successful registration) Speaker: Alfred Chen', 16.95),
('Financial Leteracy Workshop', 'Always heard of Rich Dad Poor Dad, but never knew what it is. Then, THIS IS FOR YOU!!\r\n                        Bringing to you, our Financial Literacy Workshop organized by Aspiratio Advisory happening this August‼️ \r\n                        Come join our team to this fun-filled workshop and gain multiple insights which would enable you to: \r\n                        ✅ Increase your awareness on the importance of keeping your financials in check\r\n                        ✅ Realize the value of early financial planning \r\n                        ✅ Gain a valuable exposure towards financial freedom \r\n                        ✅ FREE Personality Test \r\n                        ✅ Soft skill points provided\r\n                        ✅ Internship opportunity with Aspiratio Advisory\r\n                        ? Mark your calendar! \r\n                        Date: 1 August 2021 (Sunday) \r\n                        Time: 2.00pm to 6.00pm \r\n                        Venue: Zoom\r\n                        Grab your chance now! ', 24.95),
('Investing Note Trading Cup', 'Hey, you know what? We have a good news for you!! Go head-to-head with other traders in the Biggest & Most Exciting Virtual Trading Tournament in Malaysia: Participants will be given RM100,000 virtual capital to trade Bursa Malaysia listed stock using real market data. Total worth up to RM30,000 of GRAND prizes up for win and the tournament is Free-For-All to join! Register, trade and stand a chance to win latest version of Apple Ipad Pro and LUMOS RAY Home Cinema Projector. ?Beginners who are interested to trade but are unsure on how to, this will be a great opportunity for you to get started. If you are already a pro trader, be sure not to miss out on this active trading challenge and stand a chance to walk away with fame, glory and amazing prizes!', 24.95),
('Power Up Your FQ', 'We received some enquiries about the Soft Skill Points and entrance fee! Don’t worry, “Power Up You FQ! ” doesn’t require entrance fee, just make sure you’ve filled in & submitted the participant registration form successfully to enroll into the webinar on 10 June ! And yes! Soft Skill Points will be provided for TARUC students who’re pursuing studies in KL Campus (fill in your name, student ID, email & details accurately) Participant Registration Form easy! https://us02web.zoom.us/.../941.../WN_zyQGXW2dQkmA6uuWDrKSvQ Wish to become our member? Join us at: https://forms.gle/PYHHZWvhVRv31J8K6 Follow our Instagram page: https://www.instagram.com/byic.taruc/ Welcome for enquiries! See you on 10 June!', 35.95);

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE `participants` (
  `user_id` int(8) NOT NULL,
  `Event_Title` varchar(30) NOT NULL,
  `gender` varchar(1) NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `participants`
--

INSERT INTO `participants` (`user_id`, `Event_Title`, `gender`, `first_name`, `last_name`) VALUES
(1, '3 Wealth Creation Strategies', 'M', 'B', 'C'),
(1, 'Financial Leteracy Workshop', 'M', 'B', 'C'),
(1, 'Investing Note Trading Cup', 'M', 'B', 'C'),
(1, 'Employee Investor Program', 'M', 'B', 'C'),
(1, 'Power Up Your FQ', 'M', 'B', 'C');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(30) NOT NULL,
  `email` text NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `password` text NOT NULL,
  `gender` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email`, `first_name`, `last_name`, `password`, `gender`) VALUES
(1, 'brandoncch-wm20@student.tarc.edu.my', 'Brandon', 'Chan Chi Heen', '111', ''),
(2, 'heenbrandon@yahoo.com', 'Brandon', 'Chan Chi Heen', '1234', ''),
(3, 'heenbrandon@gmail.com', 'Brandon', 'Chan Chi Heen', '1234', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `display_event`
--
ALTER TABLE `display_event`
  ADD PRIMARY KEY (`Event_Title`);

--
-- Indexes for table `participants`
--
ALTER TABLE `participants`
  ADD KEY `Event_Title` (`Event_Title`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `email` (`email`) USING HASH;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `participants`
--
ALTER TABLE `participants`
  ADD CONSTRAINT `Event_Title` FOREIGN KEY (`Event_Title`) REFERENCES `display_event` (`Event_Title`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
