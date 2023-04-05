-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2023 at 05:13 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `show_social`
--

-- --------------------------------------------------------

--
-- Table structure for table `friendslist`
--

CREATE TABLE `friendslist` (
  `requesterId` int(11) NOT NULL,
  `adresseeId` int(11) NOT NULL,
  `isConfirmed` tinyint(1) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `friendslist`
--

INSERT INTO `friendslist` (`requesterId`, `adresseeId`, `isConfirmed`, `timestamp`) VALUES
(2, 1, 0, '2023-04-05 01:22:18');

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `movie_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `original_title` varchar(100) NOT NULL,
  `overview` varchar(1000) NOT NULL,
  `poster_path` varchar(50) NOT NULL,
  `release_date` date NOT NULL,
  `runtime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `seen_episodes`
--

CREATE TABLE `seen_episodes` (
  `id` bigint(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `seen_episodes`
--

INSERT INTO `seen_episodes` (`id`, `timestamp`, `user_id`) VALUES
(1337906, '2023-04-03 22:35:55', 1),
(1379139, '2023-04-03 22:35:56', 1),
(1379140, '2023-04-03 22:35:56', 1),
(1582216, '2023-04-03 22:37:52', 1),
(1586260, '2023-04-05 02:41:37', 1),
(1857024, '2023-04-05 02:41:37', 1),
(1953812, '2023-04-02 17:07:54', 1),
(1980403, '2023-04-05 02:08:07', 1),
(1980404, '2023-04-05 02:08:07', 1),
(1987336, '2023-04-05 02:41:31', 1),
(1987337, '2023-04-05 02:41:31', 1),
(2023593, '2023-04-05 02:41:31', 1),
(2181581, '2023-04-02 16:41:22', 1),
(2403865, '2023-04-05 02:07:58', 1),
(2464374, '2023-04-05 02:05:01', 1),
(2464375, '2023-04-05 02:07:58', 1),
(2464378, '2023-04-05 02:08:02', 1),
(2464379, '2023-04-05 02:08:03', 1),
(2464380, '2023-04-05 02:08:02', 1),
(2464381, '2023-04-05 02:08:05', 1),
(3241290, '2023-04-02 17:07:55', 1),
(4071039, '2023-04-02 16:41:22', 1),
(4071040, '2023-04-02 16:41:23', 1);

-- --------------------------------------------------------

--
-- Table structure for table `seen_movies`
--

CREATE TABLE `seen_movies` (
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabulka viděných filmů.';

--
-- Dumping data for table `seen_movies`
--

INSERT INTO `seen_movies` (`user_id`, `movie_id`, `timestamp`) VALUES
(1, 597, '2023-04-04 00:28:45'),
(1, 19995, '2023-02-26 23:42:44'),
(1, 24428, '2023-02-27 03:14:58'),
(1, 76600, '2023-02-26 23:42:21'),
(1, 140607, '2023-02-26 23:45:56'),
(1, 181808, '2023-04-04 00:34:58'),
(1, 181812, '2023-02-26 23:46:00'),
(1, 284052, '2022-11-19 23:21:10'),
(1, 299534, '2023-02-25 03:36:52'),
(1, 338953, '2023-02-26 05:37:48'),
(1, 419704, '2022-11-20 01:25:59'),
(1, 438631, '2023-02-26 23:45:42'),
(1, 510355, '2023-02-25 03:42:11'),
(1, 593643, '2023-02-26 23:44:59'),
(1, 640146, '2023-02-26 23:42:59'),
(1, 804150, '2023-04-04 00:21:58'),
(1, 913290, '2023-02-25 15:59:24'),
(1, 1078862, '2023-02-25 04:13:23');

-- --------------------------------------------------------

--
-- Table structure for table `tv_shows`
--

CREATE TABLE `tv_shows` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `poster_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tv_shows`
--

INSERT INTO `tv_shows` (`id`, `name`, `original_name`, `poster_path`) VALUES
(456, 'Simpsonovi', 'The Simpsons', '/poTtFCp1LjEl187NuqD6ekFplb6.jpg'),
(60554, 'Star Wars: Povstalci', 'Star Wars Rebels', '/jmgR8330sKEJehr27rQ3bODnrlP.jpg'),
(67744, 'MINDHUNTER: Lovci myšlenek', 'Mindhunter', '/fbKE87mojpIETWepSbD5Qt741fp.jpg'),
(82856, 'Mandalorian', 'The Mandalorian', '/6upwFpQr6XqQenoWZ9rFnjCUpTv.jpg'),
(94605, 'Arcane', 'Arcane', '/fqldf2t8ztc9aiwn3k6mlX3tvRT.jpg'),
(100088, 'The Last of Us', 'The Last of Us', '/uKvVjHNqB5VmOrdxqAt2F7J78ED.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tv_show_episodes`
--

CREATE TABLE `tv_show_episodes` (
  `id` bigint(11) NOT NULL,
  `show_id` int(11) NOT NULL,
  `season_number` smallint(6) NOT NULL,
  `episode_number` smallint(11) NOT NULL,
  `air_date` date NOT NULL,
  `runtime` smallint(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tv_show_episodes`
--

INSERT INTO `tv_show_episodes` (`id`, `show_id`, `season_number`, `episode_number`, `air_date`, `runtime`, `name`) VALUES
(35007, 615, 1, 2, '1999-04-04', 23, ''),
(35008, 615, 1, 3, '1999-04-06', 23, ''),
(35013, 615, 1, 8, '1999-05-11', 23, ''),
(35014, 615, 1, 9, '1999-05-18', 23, ''),
(1010972, 60554, 1, 3, '2014-10-27', 22, 'Tajemství starých mistrů'),
(1053814, 60554, 1, 2, '2014-10-20', 22, 'Ukradená stíhačka'),
(1053815, 60554, 1, 1, '2014-10-13', 22, 'Droidi v nesnázích'),
(1337906, 67744, 1, 1, '2017-10-13', 60, '1. epizoda'),
(1379139, 67744, 1, 2, '2017-10-13', 56, '2. epizoda'),
(1379140, 67744, 1, 3, '2017-10-13', 45, '3. epizoda'),
(1582216, 456, 30, 1, '2018-09-30', 22, 'Návrat z ráje'),
(1586260, 82856, 1, 1, '2019-11-12', 41, 'Kapitola 1: Mandalorian'),
(1857024, 82856, 1, 2, '2019-11-15', 34, 'Kapitola 2: Dítě'),
(1953812, 94605, 1, 1, '2021-11-06', 43, 'Tak vás tu vítáme'),
(1980403, 82856, 1, 3, '2019-11-22', 39, 'Kapitola 3: Hřích'),
(1980404, 82856, 1, 4, '2019-11-29', 43, 'Kapitola 4: Útočiště'),
(1987335, 82856, 1, 5, '2019-12-06', 37, 'Kapitola 5: Pistolník'),
(1987336, 82856, 1, 6, '2019-12-13', 45, 'Kapitola 6: Vězeň'),
(1987337, 82856, 1, 7, '2019-12-18', 42, 'Kapitola 7: Zúčtování'),
(2023593, 82856, 1, 8, '2019-12-27', 50, 'Kapitola 8: Vykoupení'),
(2181581, 100088, 1, 1, '2023-01-15', 81, 'Když se ztratíš v temnotě'),
(2403865, 82856, 2, 1, '2020-10-30', 56, 'Kapitola 9: Šerif'),
(2464374, 82856, 2, 2, '2020-11-06', 43, 'Kapitola 10: Pasažérka'),
(2464375, 82856, 2, 3, '2020-11-13', 37, 'Kapitola 11: Dědička'),
(2464377, 82856, 2, 4, '2020-11-20', 41, 'Kapitola 12: Infiltrace'),
(2464378, 82856, 2, 5, '2020-11-27', 48, 'Kapitola 13: Jedi'),
(2464379, 82856, 2, 6, '2020-12-04', 35, 'Kapitola 14: Tragédie'),
(2464380, 82856, 2, 7, '2020-12-11', 40, 'Kapitola 15: Přesvědčení'),
(2464381, 82856, 2, 8, '2020-12-18', 48, 'Kapitola 16: Záchrana'),
(3241290, 94605, 1, 2, '2021-11-06', 40, 'Některá tajemství je lepší nechat být'),
(4071039, 100088, 1, 2, '2023-01-22', 53, 'Nakažení'),
(4071040, 100088, 1, 3, '2023-01-29', 77, 'Long Long Time'),
(4082902, 82856, 3, 1, '2023-03-01', 37, 'Kapitola 17: Odpadlík'),
(4237589, 82856, 3, 2, '2023-03-08', 45, 'Kapitola 18: Doly na Mandaloru'),
(4237591, 82856, 3, 3, '2023-03-15', 58, 'Kapitola 19: Obrácení'),
(4237593, 82856, 3, 4, '2023-03-22', 33, 'Kapitola 20: Nalezenec'),
(4237594, 82856, 3, 5, '2023-03-29', 44, 'Kapitola 21: Pirát');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `watch_limit` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabulka uživatelů.';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `first_name`, `last_name`, `email`, `password_hash`, `created_at`, `watch_limit`) VALUES
(1, 'vojtechnerad', 'Vojtěch', 'Nerad', 'nerv01@vse.cz', '$2y$10$PEd7r4J2fT0VdsI2ImSmCeFfZum5qaYotYP4A9S7mwMhzrl.J.yn2', '2023-04-05 02:05:14', 500),
(2, 'nejakejuzivatel', 'Nějakej', 'Uživatel', 'nejakej@uzivatel.cz', '$2y$10$PEd7r4J2fT0VdsI2ImSmCeFfZum5qaYotYP4A9S7mwMhzrl.J.yn2', '2023-04-05 01:47:11', 180);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `friendslist`
--
ALTER TABLE `friendslist`
  ADD PRIMARY KEY (`requesterId`,`adresseeId`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`movie_id`);

--
-- Indexes for table `seen_episodes`
--
ALTER TABLE `seen_episodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seen_movies`
--
ALTER TABLE `seen_movies`
  ADD PRIMARY KEY (`user_id`,`movie_id`);

--
-- Indexes for table `tv_shows`
--
ALTER TABLE `tv_shows`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tv_show_episodes`
--
ALTER TABLE `tv_show_episodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `seen_movies`
--
ALTER TABLE `seen_movies`
  ADD CONSTRAINT `user_id_constraint` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
