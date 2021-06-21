-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Hostiteľ: 127.0.0.1
-- Čas generovania: Po 21.Jún 2021, 01:39
-- Verzia serveru: 10.4.14-MariaDB
-- Verzia PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáza: `lidl_db`
--

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `category`
--

CREATE TABLE `category` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(1) NOT NULL,
  `decs` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Sťahujem dáta pre tabuľku `category`
--

INSERT INTO `category` (`id`, `code`, `decs`) VALUES
(1, '1', '#01FFD1'),
(2, '2', '#931515'),
(3, '3', '#2a8d75');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `category_list`
--

CREATE TABLE `category_list` (
  `id` int(30) NOT NULL,
  `project_id` int(30) NOT NULL,
  `task` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `category_color` varchar(7) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Sťahujem dáta pre tabuľku `category_list`
--

INSERT INTO `category_list` (`id`, `project_id`, `task`, `description`, `date_created`, `category_color`) VALUES
(1, 3, 'Reporting', '', '2020-12-03 13:50:15', '#C40811'),
(2, 3, 'Dovolenka', '														', '2021-04-20 22:27:11', '#4E5861'),
(3, 3, 'Stretnutie', '							', '2021-04-20 22:27:18', '#0050AA'),
(4, 3, 'Ad Hoc', '							', '2021-04-20 22:27:18', '#E60A14'),
(5, 3, 'Školenie', '							', '2021-04-20 22:27:18', '#0078FF'),
(6, 3, 'Pravidelná činnosť', '							', '2021-04-20 22:27:18', '#43fac0');


INSERT INTO `category_list` (`id`, `project_id`, `task`, `description`, `date_created`, `category_color`) VALUES
(7, 5, 'Reporting', '', '2020-12-03 13:50:15', '#C40811'),
(8, 5, 'Dovolenka', '														', '2021-04-20 22:27:11', '#4E5861'),
(9, 5, 'Stretnutie', '							', '2021-04-20 22:27:18', '#0050AA'),
(10, 5, 'Ad Hoc', '							', '2021-04-20 22:27:18', '#E60A14'),
(11, 5, 'Školenie', '							', '2021-04-20 22:27:18', '#0078FF');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `category_project`
--

CREATE TABLE `category_project` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `project_id` int(30) NOT NULL,
  `color` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Sťahujem dáta pre tabuľku `category_project`
--

INSERT INTO `category_project` (`id`, `category_id`, `project_id`, `color`) VALUES
(1, 1, 3, '#01FFD1'),
(2, 2, 3, '#931515'),
(3, 3, 3, '#2a8d75');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `priority`
--

CREATE TABLE `priority` (
  `id` int(11) NOT NULL,
  `priority` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Sťahujem dáta pre tabuľku `priority`
--

INSERT INTO `priority` (`id`, `priority`) VALUES
(1, 'Nízka'),
(2, 'Stredná'),
(3, 'Vysoká');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `cover_img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Sťahujem dáta pre tabuľku `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `address`, `cover_img`) VALUES
(1, 'Lidl Management System', 'info@sample.comm', '+421 234 567 890', 'Ružinovská\r\nBratislava 821 02', '');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `task_list`
--

CREATE TABLE `task_list` (
  `id` int(30) NOT NULL,
  `project_id` int(30) NOT NULL,
  `task_id` int(30) NOT NULL,
  `comment` text NOT NULL,
  `title` varchar(200) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `user_id` int(30) NOT NULL,
  `time_rendered` float NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `color` varchar(7) CHARACTER SET utf8 DEFAULT NULL,
  `priority_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Sťahujem dáta pre tabuľku `task_list`
--

INSERT INTO `task_list` (`id`, `project_id`, `task_id`, `comment`, `title`, `start`, `end`, `user_id`, `time_rendered`, `date_created`, `color`, `priority_id`) VALUES
(61, 3, 0, '', 'fjasbdnflvks', '2021-04-19 08:00:00', '2021-04-19 10:15:00', 1, 0, '2021-05-03 13:43:53', NULL, 0),
(62, 3, 0, '', 'daknlfkdmôls', '2021-04-19 08:30:00', '2021-04-19 09:45:00', 1, 0, '2021-05-03 13:43:59', NULL, 0),
(63, 3, 0, '', 'das§', '2021-04-26 07:00:00', '2021-04-26 12:00:00', 1, 0, '2021-05-03 13:44:06', NULL, 0),
(64, 3, 0, '', 'fdsA', '2021-04-26 07:45:00', '2021-04-26 09:45:00', 1, 0, '2021-05-03 13:44:10', NULL, 0),
(65, 3, 0, '', 'sdadsa', '2021-05-05 00:00:00', '2021-05-06 00:00:00', 1, 0, '2021-05-05 18:37:41', NULL, 0),
(67, 1, 0, '', 'wawawiwa', '2021-05-04 00:00:00', '2021-05-05 00:00:00', 1, 0, '2021-05-05 20:02:46', NULL, 0),
(68, 3, 0, '', 'dasda', '2021-05-11 00:00:00', '2021-05-12 00:00:00', 1, 0, '2021-05-05 20:06:25', NULL, 0),
(70, 3, 0, '', 'anonano', '2021-05-10 08:15:00', '2021-05-11 11:00:00', 1, 0, '2021-05-10 18:34:31', NULL, 0),
(71, 3, 0, '', 'abc', '2021-05-11 16:45:00', '2021-05-12 13:15:00', 1, 0, '2021-05-10 18:35:11', NULL, 0),
(72, 3, 0, '', 'dadada', '2021-05-12 08:00:00', '2021-05-12 18:00:00', 1, 0, '2021-05-10 18:35:36', NULL, 0),
(73, 3, 0, '', 'dad', '2021-05-12 11:15:00', '2021-05-12 18:15:00', 1, 0, '2021-05-10 18:35:42', NULL, 0),
(74, 3, 0, '', 'a', '2021-05-12 13:30:00', '2021-05-12 18:30:00', 1, 0, '2021-05-10 18:35:48', NULL, 0),
(75, 3, 0, '', 'b', '2021-05-12 14:00:00', '2021-05-12 17:00:00', 1, 0, '2021-05-10 18:36:00', NULL, 0),
(76, 3, 0, '', 'c', '2021-05-12 14:30:00', '2021-05-12 16:45:00', 1, 0, '2021-05-10 18:36:04', NULL, 0),
(77, 3, 0, '', 'd', '2021-05-12 14:45:00', '2021-05-12 16:30:00', 1, 0, '2021-05-10 18:36:15', NULL, 0),
(78, 3, 0, '', 'e', '2021-05-12 15:00:00', '2021-05-12 16:15:00', 1, 0, '2021-05-10 18:36:21', NULL, 0),
(79, 3, 0, '', 'f', '2021-05-12 15:15:00', '2021-05-12 16:00:00', 1, 0, '2021-05-10 18:36:26', NULL, 0),
(80, 3, 0, '', 'g', '2021-05-12 15:30:00', '2021-05-12 15:45:00', 1, 0, '2021-05-10 18:36:43', NULL, 0),
(81, 3, 0, '', 'h', '2021-05-12 15:30:00', '2021-05-12 15:45:00', 1, 0, '2021-05-10 18:36:50', NULL, 0),
(82, 3, 0, '', 'ano', '2021-05-14 08:15:00', '2021-05-14 11:15:00', 1, 0, '2021-05-10 19:45:57', NULL, 0),
(83, 3, 0, '', 'nie', '2021-05-14 09:30:00', '2021-05-14 13:45:00', 1, 0, '2021-05-10 19:46:01', NULL, 0),
(84, 3, 0, '', 'možno', '2021-05-14 09:30:00', '2021-05-14 11:15:00', 1, 0, '2021-05-10 19:46:20', NULL, 0),
(85, 3, 0, '', 'tak', '2021-05-14 14:30:00', '2021-05-14 15:45:00', 1, 0, '2021-05-10 19:46:26', NULL, 0),
(86, 3, 0, '', ' ', '2021-05-14 07:00:00', '2021-05-14 07:45:00', 1, 0, '2021-05-10 19:46:57', NULL, 0),
(87, 3, 0, '', 'optimus', '2021-05-12 07:00:00', '2021-05-12 12:45:00', 1, 0, '2021-05-10 22:58:03', '#0050aa', 0),
(88, 3, 0, '', 'heureka', '2021-05-12 07:30:00', '2021-05-12 10:45:00', 1, 0, '2021-05-10 22:58:18', NULL, 0),
(89, 3, 0, '', 'žeby?', '2021-05-17 07:45:00', '2021-05-17 09:30:00', 1, 0, '2021-05-10 22:58:36', NULL, 0),
(90, 3, 0, '', '1', '2021-05-12 08:45:00', '2021-05-12 11:30:00', 1, 0, '2021-05-10 22:59:55', NULL, 0),
(91, 3, 0, '', 'y', '2021-05-12 10:30:00', '2021-05-12 12:15:00', 1, 0, '2021-05-10 23:00:07', NULL, 0),
(92, 3, 7, 'Popis', 'Názov', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, '2021-05-10 23:16:22', NULL, 0),
(93, 3, 0, '', 'test', '2021-05-18 00:00:00', '2021-05-19 00:00:00', 1, 0, '2021-05-12 17:36:40', NULL, 0),
(94, 3, 0, '', 'test123', '2021-05-19 00:00:00', '2021-05-20 00:00:00', 1, 0, '2021-05-12 17:41:05', NULL, 0),
(97, 3, 0, '', 'asasa', '2021-05-20 00:00:00', '2021-05-21 00:00:00', 1, 0, '2021-05-25 17:15:15', NULL, 0),
(98, 3, 0, '', 'k', '2021-05-21 00:00:00', '2021-05-22 00:00:00', 1, 0, '2021-05-25 17:41:00', NULL, 0),
(99, 3, 0, '', 'o', '2021-05-20 00:00:00', '2021-05-21 00:00:00', 1, 0, '2021-05-25 17:41:14', NULL, 0),
(100, 3, 5, 'Maturita', 'Formalita', '2021-05-26 19:33:00', '2021-05-27 19:35:00', 1, 0, '2021-05-26 19:33:42', NULL, 0),
(101, 3, 5, 'Maturita', 'Formalita', '2021-05-26 19:37:00', '2021-05-27 19:40:00', 1, 0, '2021-05-26 19:36:27', NULL, 0),
(102, 3, 0, '', 'vajce', '2021-05-04 00:00:00', '2021-05-05 00:00:00', 1, 0, '2021-05-26 19:39:55', NULL, 0),
(103, 3, 0, '', 'nový údaj', '2021-05-06 00:00:00', '2021-05-07 00:00:00', 1, 0, '2021-05-26 19:41:53', NULL, 0),
(104, 3, 0, 'da', 'add', '2021-05-26 20:18:00', '2021-05-27 20:15:00', 1, 0, '2021-05-26 20:15:24', NULL, 0),
(105, 3, 0, 'k n&aacute;m', 'pridaj sa', '2021-05-26 20:15:00', '2021-05-27 20:15:00', 1, 0, '2021-05-26 20:16:00', NULL, 0),
(106, 3, 0, 'ide proti n&aacute;m', 'Kto nejde s nami', '2021-05-01 20:16:00', '2021-05-31 20:16:00', 1, 0, '2021-05-26 20:16:51', NULL, 0),
(107, 3, 0, '													', 'ide proti nám', '2021-05-01 21:04:00', '2021-05-31 21:04:00', 1, 0, '2021-05-26 21:04:20', NULL, 0),
(108, 3, 0, '													', 'Spešl tlačidlo', '2021-05-24 21:04:00', '2021-05-30 21:05:00', 1, 0, '2021-05-26 21:05:04', NULL, 0),
(109, 3, 0, '													', '', '2021-05-26 00:00:00', '2021-05-27 00:00:00', 1, 0, '2021-05-26 21:07:57', NULL, 0),
(110, 3, 5, '													', 'a', '2021-05-27 15:10:00', '2021-05-27 15:10:00', 1, 0, '2021-05-27 15:10:59', NULL, 0),
(111, 3, 0, 'dsfsdfbndfgsfad', 'Formalita', '2021-05-27 15:24:00', '2021-05-27 15:24:00', 1, 0, '2021-05-27 15:24:35', NULL, 0),
(112, 3, 0, '													', 'Farba', '2021-05-27 15:30:00', '2021-05-27 15:30:00', 1, 0, '2021-05-27 15:30:30', '#ff0000', 0),
(113, 3, 0, '													', 'Modrá', '2021-05-25 15:32:00', '2021-05-29 15:32:00', 1, 0, '2021-05-27 15:32:35', '#05deff', 0),
(114, 3, 0, 'funguj', 'Oranžová', '2021-05-26 15:36:00', '2021-05-28 15:36:00', 1, 0, '2021-05-27 15:36:55', '#ff8800', 0),
(118, 3, 1, '&scaron;lo', 'Reporting v akcií', '2021-06-10 21:20:00', '2021-06-10 21:20:00', 1, 0, '2021-06-09 21:21:03', NULL, 0),
(119, 3, 5, '													', 'Školenie o enkapsulácií', '2021-06-11 11:50:00', '2021-06-11 11:50:00', 1, 0, '2021-06-11 11:50:17', NULL, 0),
(121, 3, 5, 'askew', 'Seminár o efektivite', '2021-06-17 11:06:00', '2021-06-17 11:06:00', 1, 0, '2021-06-17 11:06:22', NULL, 0),
(122, 3, 3, 'askew', 'Meeting s Veronikou Bušovou', '2021-06-17 11:14:00', '2021-06-17 11:14:00', 1, 0, '2021-06-17 11:14:42', NULL, 0),
(123, 3, 2, 'askew', 'Dovolenka', '2021-06-17 11:15:00', '2021-06-17 11:15:00', 1, 0, '2021-06-17 11:15:28', NULL, 0),
(124, 3, 2, '													', 'Formalita', '2021-06-17 13:44:00', '2021-06-17 13:44:00', 1, 0, '2021-06-17 13:44:08', NULL, 0),
(125, 3, 1, 'askew', 'Report obratov', '2021-06-17 14:17:00', '2021-06-17 14:17:00', 1, 0, '2021-06-17 14:17:34', '#0050aa', 0),
(129, 3, 5, '													', 'Dnešný task', '2021-06-19 06:40:00', '2021-06-19 18:40:00', 1, 0, '2021-06-19 12:40:43', NULL, 0),
(130, 3, 5, 'wawawiwa', 'Produktívny workshop', '2021-06-20 08:55:00', '2021-06-20 11:00:00', 8, 0, '2021-06-19 13:55:58', NULL, 0),
(131, 0, 0, '', 'Nová udalosť', '2021-06-19 08:00:00', '2021-06-19 09:00:00', 0, 0, '2021-06-19 21:43:57', NULL, 0),
(132, 0, 0, '', 'Nová udalosť', '2021-06-19 12:00:00', '2021-06-19 18:00:00', 8, 0, '2021-06-19 21:44:09', NULL, 0),
(133, 3, 2, 'suje', 'Zapisuje', '2021-06-20 13:54:00', '2021-06-20 17:00:00', 1, 0, '2021-06-20 13:54:50', NULL, 0),
(136, 0, 0, '', 'zamest', '2021-06-20 12:00:00', '2021-06-20 13:00:00', 8, 0, '2021-06-20 14:07:33', NULL, 0),
(137, 0, 0, '', 'niečo', '2021-06-20 14:00:00', '2021-06-20 16:00:00', 8, 0, '2021-06-20 14:09:21', NULL, 0),
(138, 3, 1, 'dasda', 'test', '2021-06-21 20:40:00', '2021-06-21 20:40:00', 1, 0, '2021-06-20 20:40:17', NULL, 0),
(139, 3, 4, '													', 'Ad Hoc', '2021-06-22 14:49:00', '2021-06-22 18:49:00', 1, 0, '2021-06-20 21:49:38', NULL, 0),
(140, 3, 2, '													', 'Dovolenka', '2021-06-22 06:50:00', '2021-06-22 01:19:54', 1, 0, '2021-06-20 21:50:12', NULL, 0),
(141, 3, 6, '													', 'Pravidelná činnosť', '2021-06-22 07:50:00', '2021-06-22 21:50:00', 1, 0, '2021-06-20 21:50:46', NULL, 0),
(142, 3, 1, '													', 'Reporting', '2021-06-22 08:51:00', '2021-06-22 09:51:00', 1, 0, '2021-06-20 21:51:34', NULL, 0),
(143, 3, 5, '													', 'Školenie', '2021-06-22 09:51:00', '2021-06-22 10:52:00', 1, 0, '2021-06-20 21:52:05', NULL, 0),
(144, 3, 3, '													', 'Stretnutie', '2021-06-22 09:52:00', '2021-06-22 11:52:00', 1, 0, '2021-06-20 21:52:39', NULL, 0),
(148, 3, 3, '													', 'Stretnutie s Marcelom Ihnačákom', '2021-06-21 08:00:00', '2021-06-21 11:00:00', 1, 0, '2021-06-21 01:01:48', NULL, 0),
(149, 3, 5, '													', 'IT školenie', '2021-06-21 10:07:00', '2021-06-21 14:07:00', 1, 0, '2021-06-21 01:07:42', NULL, 0);

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `team_list`
--

CREATE TABLE `team_list` (
  `id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `manager_id` int(30) NOT NULL,
  `user_ids` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Sťahujem dáta pre tabuľku `team_list`
--

INSERT INTO `team_list` (`id`, `name`, `description`, `status`, `start_date`, `end_date`, `manager_id`, `user_ids`, `date_created`) VALUES
(3, 'COPRA', '																																				&lt;span style=&quot;font-family: Arial, Helvetica, sans-serif; font-size: small; background-color: rgb(255, 255, 255);&quot;&gt;&lt;font color=&quot;#000000&quot;&gt;Controlling Projekte &amp;amp; Reporting &amp;amp; Analysen&lt;/font&gt;&lt;/span&gt;																																																				', 0, '2021-03-27', '2021-03-28', 1, '6,1,8,7', '2021-03-27 20:07:01'),
(5, 'Resortcontrolling ', '																																												', 0, '0000-00-00', '0000-00-00', 6, '8,7', '2021-05-10 23:05:50'),
(6, 'Vedľajší Tím', '											', 3, '0000-00-00', '0000-00-00', 7, '8', '2021-05-10 23:06:32'),
(7, 'Tím Testov', '																																	', 0, '0000-00-00', '0000-00-00', 7, '8', '2021-05-10 23:08:25');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `team_user`
--

CREATE TABLE `team_user` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `team_list_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Sťahujem dáta pre tabuľku `team_user`
--

INSERT INTO `team_user` (`id`, `user_id`, `team_list_id`) VALUES
(1, 1, 3),
(2, 8, 5),
(3, 6, 3),
(4, 7, 3),
(5, 8, 3),
(6, 7, 5),
(7, 6, 11),
(8, 1, 11),
(9, 6, 12),
(10, 1, 12),
(11, 6, 13),
(12, 1, 13);

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 2 COMMENT '1 = admin, 2 = zamestnanec, 3 = stážista',
  `avatar` text NOT NULL DEFAULT 'no-image-available.png',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Sťahujem dáta pre tabuľku `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `type`, `avatar`, `date_created`) VALUES
(1, 'Meno manažéra', 'Priezvisko manažéra', 'manazer@manazer.com	', 'dba61a5802ed5b60b029a290309be04a', 1, 'user.svg', '2020-11-26 10:57:04'),
(6, 'Dávid', 'Krátky', 'david.kratky.sk@gmail.com', '0192023a7bbd73250516f069df18b500', 1, '1620063240_IMG_20210216_002208.jpg', '2021-03-27 20:03:34'),
(7, 'Meno zamestnanca', ' Priezvisko zamestnanca', 'zamestnanec@zamestnanec.com', '549027cd88d54004a23d2fb5aeaef55d', 2, 'user.svg', '2021-05-10 22:43:01'),
(8, 'Meno stážistu', ' Priezvisko stážistu', 'stazista@stazista.com', 'e82e7f3aa41a39ff682d0371aeffbd68', 3, 'user.svg', '2021-05-10 22:43:34');

--
-- Kľúče pre exportované tabuľky
--

--
-- Indexy pre tabuľku `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `category_list`
--
ALTER TABLE `category_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `category_project`
--
ALTER TABLE `category_project`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category_idx` (`category_id`),
  ADD KEY `fk_team_idx` (`project_id`);

--
-- Indexy pre tabuľku `priority`
--
ALTER TABLE `priority`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `task_list`
--
ALTER TABLE `task_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `priority_id` (`priority_id`);

--
-- Indexy pre tabuľku `team_list`
--
ALTER TABLE `team_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `team_user`
--
ALTER TABLE `team_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ix_user_id` (`user_id`),
  ADD KEY `ix_team_list_id` (`team_list_id`);

--
-- Indexy pre tabuľku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pre exportované tabuľky
--

--
-- AUTO_INCREMENT pre tabuľku `category`
--
ALTER TABLE `category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pre tabuľku `category_list`
--
ALTER TABLE `category_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pre tabuľku `category_project`
--
ALTER TABLE `category_project`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pre tabuľku `priority`
--
ALTER TABLE `priority`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pre tabuľku `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pre tabuľku `task_list`
--
ALTER TABLE `task_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT pre tabuľku `team_list`
--
ALTER TABLE `team_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pre tabuľku `team_user`
--
ALTER TABLE `team_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pre tabuľku `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Obmedzenie pre exportované tabuľky
--

--
-- Obmedzenie pre tabuľku `category_project`
--
ALTER TABLE `category_project`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `fk_team` FOREIGN KEY (`project_id`) REFERENCES `team_list` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
