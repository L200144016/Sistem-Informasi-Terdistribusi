-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2017 at 10:45 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `university`
--

-- --------------------------------------------------------

--
-- Table structure for table `krs`
--

CREATE TABLE `krs` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `semester` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `krs`
--

INSERT INTO `krs` (`id`, `subject_id`, `student_id`, `semester`) VALUES
(1, 6, 1, 3),
(2, 1, 2, 6),
(3, 1, 3, 6),
(6, 2, 4, 6);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `nim` varchar(10) NOT NULL,
  `age` int(3) NOT NULL,
  `year` int(4) NOT NULL,
  `name` varchar(160) NOT NULL,
  `class` char(1) NOT NULL,
  `address` varchar(160) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `nim`, `age`, `year`, `name`, `class`, `address`) VALUES
(1, 'l200124021', 21, 2012, 'Moch Rizky Prasetya Kurniadi', 'X', 'Ngawi'),
(2, 'l200134022', 20, 2013, 'Muhammad Satrio Sujarwo', 'X', 'Sragen'),
(3, 'l200144023', 20, 2014, 'Didik Maryono', 'X', 'Sukoharjo'),
(4, 'l200154024', 20, 2015, 'Rasyid Burhanuddin', 'X', 'Kalimantan'),
(5, 'l200164025', 20, 2016, 'Makarima Fahreza Fathony', 'X', 'Semarang'),
(6, 'l200174026', 20, 2017, 'Rofi Abdillah', 'X', 'Cilacap');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `title` varchar(160) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `code`, `title`) VALUES
(1, 'TIF20833', 'Visual Programming'),
(2, 'TIF60233', 'Metodologi Penelitian dan Publikasi Ilmiah'),
(3, 'TIF60333', 'Audit dan Tata Kelola Teknologi Informasi'),
(4, 'TIF60433', 'Perancangan Sistem Enterprise'),
(5, 'TIF60533', 'Perancangan Sistem Informasi'),
(6, 'TIF61733', 'Pemrograman Perangkat Mobile'),
(7, 'UMS80112', 'Pendidikan Kewarganegaraan'),
(8, 'TIF80843', 'Sistem Informasi Terdistribusi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `krs`
--
ALTER TABLE `krs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `krs`
--
ALTER TABLE `krs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `krs`
--
ALTER TABLE `krs`
  ADD CONSTRAINT `krs_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `krs_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
