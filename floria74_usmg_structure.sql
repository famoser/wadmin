-- phpMyAdmin SQL Dump
-- version 4.4.8
-- http://www.phpmyadmin.net
--
-- Host: mysql14j03.db.internal
-- Generation Time: Jul 02, 2015 at 06:26 AM
-- Server version: 5.5.40-log
-- PHP Version: 5.4.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `floria74_usmg`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `Id` int(11) NOT NULL,
  `UserId` int(11) DEFAULT NULL,
  `Email` longtext COLLATE utf8_unicode_ci,
  `Password` text COLLATE utf8_unicode_ci NOT NULL,
  `Level` int(11) NOT NULL,
  `AuthHash` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `Id` int(11) NOT NULL,
  `Vorname` text COLLATE utf8_unicode_ci,
  `Nachname` text COLLATE utf8_unicode_ci,
  `Adresszusatz` text COLLATE utf8_unicode_ci,
  `Strasse` text COLLATE utf8_unicode_ci,
  `Land` text COLLATE utf8_unicode_ci,
  `PLZ` int(11) DEFAULT NULL,
  `Ort` text COLLATE utf8_unicode_ci,
  `TelPrivat` text COLLATE utf8_unicode_ci,
  `TelGeschaeft` text COLLATE utf8_unicode_ci,
  `Mobile` text COLLATE utf8_unicode_ci,
  `Email` longtext COLLATE utf8_unicode_ci,
  `Geburtsdatum` date DEFAULT NULL,
  `Bemerkung` text COLLATE utf8_unicode_ci,
  `Adresswarnung` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
