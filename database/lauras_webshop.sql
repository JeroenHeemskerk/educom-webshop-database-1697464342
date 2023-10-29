-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 27 okt 2023 om 10:58
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
-- Tabelstructuur voor tabel `orderlines`
--

CREATE TABLE `orderlines` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `orderlines`
--

INSERT INTO `orderlines` (`id`, `order_id`, `product_id`, `product_quantity`) VALUES
(1, 63, 3, 2),
(2, 63, 4, 1),
(3, 64, 3, 2),
(4, 64, 4, 1),
(5, 65, 3, 3),
(6, 65, 4, 1),
(7, 65, 8, 1),
(8, 65, 9, 1),
(9, 66, 9, 1),
(10, 67, 9, 1),
(11, 68, 9, 1),
(12, 69, 9, 2),
(13, 70, 3, 2);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`) VALUES
(1, 7, 1700),
(2, 7, 1700),
(3, 7, 1700),
(4, 7, 2250),
(5, 7, 2250),
(6, 7, 2250),
(7, 7, 2250),
(8, 7, 2250),
(9, 7, 2250),
(10, 1, 1200),
(11, 1, 1200),
(12, 1, 550),
(13, 1, 550),
(14, 1, 400),
(38, 1, 500),
(39, 1, 500),
(40, 1, 1500),
(41, 1, 1500),
(42, 1, 1500),
(43, 1, 1500),
(44, 1, 1500),
(45, 1, 1500),
(46, 1, 1500),
(47, 1, 1900),
(48, 1, 1900),
(49, 1, 1450),
(50, 1, 950),
(51, 1, 950),
(52, 1, 550),
(53, 1, 550),
(54, 1, 550),
(55, 1, 550),
(56, 1, 550),
(57, 1, 550),
(58, 1, 1100),
(59, 1, 1100),
(60, 1, 1500),
(61, 1, 1500),
(62, 1, 1500),
(63, 1, 1500),
(64, 1, 1500),
(65, 1, 3150),
(66, 7, 600),
(67, 7, 600),
(68, 7, 600),
(69, 7, 1200),
(70, 7, 1100);

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

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `email`, `name`, `password`) VALUES
(1, 'jan@hotmail.com', 'jan', 'jantje123'),
(2, 'piet@hotmail.com', 'piet', 'pietje123'),
(3, 'moos@moos.nl', 'moos', 'moos!'),
(4, 'meike@meike.nl', 'meike', 'meike!'),
(5, 'hoi@hoi.nl', 'hoi', 'hoi!'),
(6, 'jaap@jaap.nl', 'jaap', 'jaap!'),
(7, 'anne@anne.nl', 'anne', 'anne!'),
(8, 'roos@roos.nl', 'roos', 'roos!'),
(9, 'james@hotmail.com', 'james', 'james!');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `orderlines`
--
ALTER TABLE `orderlines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexen voor tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexen voor tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `orderlines`
--
ALTER TABLE `orderlines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT voor een tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT voor een tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `orderlines`
--
ALTER TABLE `orderlines`
  ADD CONSTRAINT `FK_ORDER` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `FK_PRODUCT` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Beperkingen voor tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `FOREIGN_KEY` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
