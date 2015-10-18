-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 22. Sep 2015 um 18:42
-- Server-Version: 5.6.25
-- PHP-Version: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `oopcrudproject`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `categories`
--

INSERT INTO `categories` (`id`, `name`, `created`) VALUES
(1, 'Students', '2015-05-31 22:35:07'),
(2, 'Pensioners', '2015-05-31 22:35:07'),
(3, 'Employees', '2015-05-31 22:35:07'),
(4, 'Unemployed', '2015-12-04 20:12:03');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(30) CHARACTER SET utf8 NOT NULL,
  `category_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `mobile`, `category_id`, `created`) VALUES
(1, 'Ekin', 'Polat', 'ekinpolat@googlemail.com', '2147483647', 1, '2014-05-31 07:12:26'),
(2, 'Matthias', 'Kruse', 'mat-kruse@t-online.de', '1776375287', 2, '2014-05-31 07:12:26'),
(3, 'Alper', 'Catak', 'a.catak78@gmail.com', '1729166924', 2, '2014-05-31 07:12:26'),
(6, 'Ayse', 'Oluk', 'ayse.oluk@googlemail.com', '+491612936743', 1, '2014-05-30 16:18:31'),
(7, 'Cavit', 'Ates', 'cavit.ates@personal-phoenix.com', '177982122', 2, '2014-06-05 08:09:51'),
(8, 'Christoph', 'Knoppik', 'christoph.knoppik@freenet.de', '2147483647', 4, '2014-06-05 08:10:54'),
(9, 'Danijel', 'Stenzel', 'dstenzel72@googlemail.com', '1769237645', 2, '2015-06-20 08:19:45'),
(10, 'Eray', 'Gueclue', 'ibrahimerayguclu@gmail', '1782856396', 3, '2014-06-05 08:12:11'),
(11, 'Jutta', 'Collet', 'collet.jutta@gmail.com', '2147483647', 1, '2014-06-05 08:12:49'),
(12, 'George', 'Michael', 'g.michael@gmx.de', '12386733', 2, '2015-08-27 06:43:55'),
(13, 'Javier', 'Bardem', 'j.bardem@gmail.com', '129566888', 3, '2015-08-27 06:56:52'),
(14, 'Michael', 'Jackson', 'm.jackson@hotmail.de', '1988227733', 3, '2015-08-27 08:27:50'),
(15, 'Eros', 'Ramazotti', 'e.ram78@yahoo.com', '2147483647', 3, '2015-08-27 08:29:53'),
(16, 'Angelo', 'Bautista', 'baucoolangel@yandex.ru', '2147483647', 3, '2015-08-27 08:37:17'),
(17, 'George', 'Clonny', 'georgy@yahoo.com', '2147483647', 3, '2015-08-27 09:26:57'),
(18, 'Angelina', 'Jolie', 'angy156@angyjlolie.com', '+491612936743', 1, '2015-08-27 17:48:18'),
(19, 'Yasin', 'Giray', 'yasso@hotmail.de', '2147483647', 4, '2015-08-27 17:52:55'),
(21, 'Tarik', 'Akan', 't.a@unluler.com', '2147483647', 3, '2015-08-27 17:56:03'),
(24, 'Hallo', 'Happy', 'happyafrican@gmail.com', '1772149867', 4, '2015-08-28 10:00:56'),
(30, 'Ayhan', 'Oluk', 'a.oenal@gmx.de', '+491612936743', 2, '2015-09-10 15:10:01');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
