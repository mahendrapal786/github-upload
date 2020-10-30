-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2020 at 01:21 PM
-- Server version: 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `pm_room`
--

CREATE TABLE `pm_room` (
  `id` int(11) NOT NULL,
  `lang` int(11) NOT NULL,
  `max_children` int(11) DEFAULT '1',
  `max_adults` int(11) DEFAULT '1',
  `max_people` int(11) DEFAULT NULL,
  `min_people` int(11) DEFAULT NULL,
  `title` varchar(250) DEFAULT NULL,
  `subtitle` varchar(250) DEFAULT NULL,
  `alias` varchar(100) DEFAULT NULL,
  `descr` longtext,
  `facilities` varchar(250) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT '1',
  `price` double NOT NULL DEFAULT '0',
  `home` int(11) DEFAULT '0',
  `checked` int(11) DEFAULT '0',
  `rank` int(11) DEFAULT '0',
  `start_lock` int(11) DEFAULT NULL,
  `end_lock` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pm_room`
--

INSERT INTO `pm_room` (`id`, `lang`, `max_children`, `max_adults`, `max_people`, `min_people`, `title`, `subtitle`, `alias`, `descr`, `facilities`, `stock`, `price`, `home`, `checked`, `rank`, `start_lock`, `end_lock`) VALUES
(1, 2, 2, 2, 3, 2, 'Urban Room', 'Breakfast included', 'beds-and-beddings-maximum-occupancy-2-1-king-size-bed-mattress-available-as-per-availability', '<p>Room size: 550 square feet (approx.) • Air-conditioned • Safe Wardrobe with lock • Telephone • 48” LCD TV • Study Table With 2 chairs • Shower Cubical • 2 Bottled Water, Complimentary per day • Complimentary Tea/Coffee Maker • Mini Bar Fridge • Hot water Resort Services & Amenities • Complimentary Entry band of park which includes lot of activities(contact reception for more information) • Room Service • Housekeeping service daily • Newspaper Delivered To Room On Request • Wakeup Calls</p>\r\n', '1,5,11,13,17,18,21,23,24,25,27,28,29,31,32', 8, 3000, 1, 1, 1, NULL, NULL),
(2, 2, 2, 2, 4, 1, 'Urban cottages', 'Urban cottages', 'room-amenities-beds-and-beddings-maximum-occupancy-2-1-1-king-size-bed-mattress-available-as-per-ava', '<p>Room Features • Room size: 650 square feet (approx.) • Standing balcony • Specious living area • Air-conditioned • Safe Wardrobe with lock • Telephone • 48” LCD TV • Study Table With 2 chairs • Shower Cubical • 2 Bottled Water, Complimentary per day • Complimentary Tea/Coffee Maker • Mini Bar Fridge • Hot water Resort Services & Amenities • Complimentary Entry band of park which includes lot of activities(contact reception for more information) • Room Service • Housekeeping service daily • Newspaper Delivered To Room On Request • Wakeup Calls</p>\r\n', '1,2,5,39,35,11,13,36,17,18,21,37,38,23,24,25,26,27,28,32', 100, 3500, 1, 1, 1, NULL, NULL),
(3, 3, 4, 5, 5, 1, 'Royal suite', 'Pool & Jacuzzi Suite', 'royal-suite', '', '1,2,5,39,35,11,13,36,17,18,21,37,38,23,24,25,27,28,32', 1, 410, 1, 1, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pm_room_meta`
--

CREATE TABLE `pm_room_meta` (
  `id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `room_type_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pm_room_meta`
--

INSERT INTO `pm_room_meta` (`id`, `room_id`, `room_type_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `pm_room_type`
--

CREATE TABLE `pm_room_type` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pm_room_type`
--

INSERT INTO `pm_room_type` (`id`, `name`) VALUES
(1, 'Urban'),
(2, 'Cottages'),
(3, 'Royal');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pm_room`
--
ALTER TABLE `pm_room`
  ADD PRIMARY KEY (`id`,`lang`),
  ADD KEY `room_lang_fkey` (`lang`);

--
-- Indexes for table `pm_room_meta`
--
ALTER TABLE `pm_room_meta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pm_room_type`
--
ALTER TABLE `pm_room_type`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pm_room`
--
ALTER TABLE `pm_room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `pm_room_meta`
--
ALTER TABLE `pm_room_meta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `pm_room_type`
--
ALTER TABLE `pm_room_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
