-- MySQL dump 10.13  Distrib 8.0.30, for Linux (x86_64)
--
-- Host: localhost    Database: orizon_offers
-- ------------------------------------------------------
-- Server version	8.0.30-0ubuntu0.22.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `orizon_offers`
--
CREATE DATABASE IF NOT EXISTS `orizon_offers` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `orizon_offers`;

-- --------------------------------------------------------

--
-- Struttura della tabella `countries`
--

CREATE TABLE `countries` (
  `country_id` int(3) NOT NULL,
  `name` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `countries`
--

INSERT INTO `countries` (`country_id`, `name`) VALUES
(1, 'Italy'),
(2, 'Spain'),
(3, 'France'),
(4, 'Germany'),
(5, 'England'),
(6, 'Netherlands'),
(7, 'Greece'),
(8, 'USA'),
(9, 'Canada'),
(10, 'Brazil'),
(11, 'Argentina'),
(12, 'China'),
(13, 'Japan'),
(14, 'Australia');

-- --------------------------------------------------------

--
-- Struttura della tabella `travels`
--

CREATE TABLE `travels` (
  `travel_id` int(11) NOT NULL,
  `departure_id` int(3) NOT NULL,
  `destination_id` int(3) NOT NULL,
  `available_places` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `travels`
--

INSERT INTO `travels` (`travel_id`, `departure_id`, `destination_id`, `available_places`) VALUES
(1, 2, 1, 48),
(2, 3, 1, 12),
(3, 1, 4, 55),
(4, 3, 5, 24),
(5, 4, 1, 0),
(6, 1, 3, 33),
(7, 2, 4, 28),
(8, 6, 4, 5),
(9, 6, 4, 47),
(10, 8, 9, 41),
(11, 9, 8, 64),
(12, 10, 11, 0),
(13, 11, 10, 22),
(14, 13, 12, 0),
(15, 4, 5, 33),
(16, 2, 1, 48),
(17, 10, 11, 18),
(18, 8, 5, 55),
(19, 3, 5, 34),
(20, 13, 12, 0),
(21, 1, 3, 13),
(22, 8, 2, 29),
(23, 5, 8, 7),
(24, 6, 8, 45);

--
-- Indici per le tabelle `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`country_id`);

--
-- Indici per le tabelle `travels`
--
ALTER TABLE `travels`
  ADD PRIMARY KEY (`travel_id`),
  ADD KEY `fk_departure` (`departure_id`),
  ADD KEY `fk_destination` (`destination_id`);
--
-- AUTO_INCREMENT per la tabella `countries`
--
ALTER TABLE `countries`
  MODIFY `country_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT per la tabella `travels`
--
ALTER TABLE `travels`
  MODIFY `travel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;
