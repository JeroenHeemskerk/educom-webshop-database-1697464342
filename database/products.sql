-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 24 okt 2023 om 11:46
-- Serverversie: 10.4.28-MariaDB
-- PHP-versie: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lauras_webshop`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(300) NOT NULL,
  `pricetag` int(11) NOT NULL,
  `image_url` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `pricetag`, `image_url`) VALUES
(3, 'Marbled soap', 'Nam sit amet erat diam. Aliquam nec nulla a nibh accumsan gravida nec quis elit. Maecenas porttitor, lacus id tincidunt blandit, ante nibh posuere purus, sit amet vestibulum dui mauris consectetur nulla.', 550, 'Images\\marbled-soap.jpg'),
(4, 'Oats soap', 'Mauris mattis neque eu fringilla bibendum. Phasellus eu justo scelerisque, commodo augue ac, maximus nulla.', 400, 'Images\\oats-soap.jpg'),
(7, 'Orange soap', 'Curabitur vehicula orci vitae elit sagittis varius. Mauris sollicitudin diam ac leo eleifend, nec dignissim nibh interdum. Fusce tempor lorem nec sagittis suscipit. Vivamus lacinia lorem at ipsum facilisis, nec egestas augue porta. ', 450, 'Images\\orange-soap.jpg'),
(8, 'Swirled soap', 'Integer non eros ut magna rhoncus mollis vel eu odio. Pellentesque eu est urna. Fusce sit amet vestibulum nisl. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. ', 500, 'Images\\swirled-soap.jpg'),
(9, 'Woodgrain soap', ' Cras accumsan euismod sapien, in posuere est feugiat in. Aenean faucibus orci arcu, in tincidunt neque dignissim nec. In imperdiet non sem ut laoreet. Etiam imperdiet tincidunt eleifend. ', 600, 'Images\\woodgrain-soap.jpg');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
