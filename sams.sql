-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 01 juin 2025 à 05:45
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sams`
--

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `wilaya_id` int(11) DEFAULT NULL,
  `delivery_method` enum('house_delivery','depot') DEFAULT NULL,
  `total_price` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `commune` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id`, `full_name`, `phone_number`, `address`, `wilaya_id`, `delivery_method`, `total_price`, `created_at`, `commune`) VALUES
(58, 'sami', '0565656565', 'les cretes', 23, 'house_delivery', 63800, '2025-05-14 22:55:02', 'alger'),
(59, 'sami', '0565656565', 'les cretes', 23, 'house_delivery', 42800, '2025-05-15 02:58:11', 'annaba'),
(60, 'sami', '0565656565', 'les cretes', 23, 'house_delivery', 3600, '2025-05-15 17:05:10', 'alger'),
(61, 'nader', '0565656565', 'baraki', 23, 'house_delivery', 59800, '2025-05-16 01:25:26', 'ee'),
(62, 'sami', '0565656565', '', 23, '', NULL, '2025-05-16 01:53:28', ''),
(63, 'sami', '0565656565', '', 23, '', 3200, '2025-05-16 18:21:18', ''),
(64, 'sami', '0565656565', 'les cretes', 23, 'house_delivery', 45600, '2025-05-16 18:23:10', 'alger'),
(65, 'sami', '0565656565', '', 23, '', 24400, '2025-05-16 18:24:25', ''),
(66, 't', 'aa', 'qqq', 23, 'house_delivery', 67600, '2025-05-16 18:27:03', 'qqq'),
(67, 't', 'aa', 'qqq', 23, 'house_delivery', 800, '2025-05-16 18:28:10', 'qqq'),
(68, 'w', 'ww', '', 23, '', 25000, '2025-05-16 18:29:41', ''),
(69, 'nader', '0565656565', '', 23, '', 54500, '2025-05-16 18:41:31', ''),
(70, 'nader', '0565656565', '', 23, '', 54500, '2025-05-16 18:42:23', ''),
(71, 'sami', '0565656565', '16000', 16, 'house_delivery', 60100, '2025-05-16 22:14:57', 'alger'),
(72, 'sami', '0565656565', 'les cretes', 16, 'house_delivery', 6200, '2025-05-17 22:43:52', 'annaba'),
(73, 'sami', '0565656565', '', 23, '', 75700, '2025-05-18 03:46:36', ''),
(74, 'sami', '0565656565', 'les cretes', 23, 'house_delivery', 6400, '2025-05-18 12:31:45', 'alger'),
(75, 'sami', '0565656565', '', 23, '', 26900, '2025-05-18 12:33:26', ''),
(76, 'sami', '0565656565', '', 23, '', 23400, '2025-05-18 12:35:35', ''),
(77, 'sami', '0565656565', '', 23, '', 72400, '2025-05-18 13:16:14', ''),
(78, 'sami', '0565656565', '', 23, '', 24400, '2025-05-18 13:19:48', ''),
(79, 'nader', '0565656565', 'baraki', 23, '', 63400, '2025-05-19 09:52:54', 'alger'),
(80, 'sami', '0565656565', '', 23, '', 3000, '2025-05-19 10:22:17', ''),
(81, 'sami', '0565656565', '', 23, '', 21400, '2025-05-26 01:44:45', ''),
(82, 'nader', '0565656565', '', 23, '', 24400, '2025-05-26 03:06:10', ''),
(83, 'nader', '0565656565', '', 6, '', 36800, '2025-05-26 03:09:12', ''),
(84, 'nader', '0565656565', '', 23, '', 42400, '2025-05-26 03:13:22', ''),
(85, 't', 'a', 'les cretes', 17, 'house_delivery', 29500, '2025-05-26 03:14:43', 'ee'),
(86, '55', 'a', '', 52, '', 24000, '2025-05-26 03:18:53', ''),
(87, 'nader', 'aa', '', 5, '', 36800, '2025-05-26 03:20:59', ''),
(88, 'aaaa', '0565656565', '', 23, '', 61200, '2025-05-26 03:45:39', ''),
(89, 'ala', '077777777', 'baraki', 16, 'house_delivery', 24650, '2025-05-26 03:51:28', 'annaba'),
(90, '55', 'a', 'Pick up point', 16, '', 24450, '2025-05-26 03:57:19', ''),
(91, '55', '0565656565', '', 52, '', 2600, '2025-05-26 03:58:55', ''),
(94, 'ghozlene', '0565656565', 'annaba', 23, 'house_delivery', 47005, '2025-05-26 21:38:59', 'annaba'),
(95, 'nader', '0565656565', 'les cretes', 23, 'house_delivery', 29505, '2025-05-27 22:23:53', 'alger'),
(96, 'nader', '0565656565', '', 23, 'depot', 24400, '2025-05-27 22:36:22', ''),
(97, 'nader', '0565656565', '', 5, 'depot', 2900, '2025-05-27 22:41:46', ''),
(98, 'nader', '0565656565', '', 23, 'depot', 29900, '2025-05-27 22:52:27', '');

-- --------------------------------------------------------

--
-- Structure de la table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `variant_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `variant_id`, `quantity`) VALUES
(26, 82, 20, 1),
(27, 83, 20, 1),
(28, 83, 19, 4),
(29, 84, 12, 2),
(30, 85, 4, 1),
(31, 86, 20, 1),
(32, 87, 20, 1),
(33, 87, 19, 4),
(34, 88, 20, 1),
(35, 88, 19, 4),
(36, 88, 16, 1),
(37, 89, 16, 1),
(38, 90, 16, 1),
(39, 91, 15, 1),
(42, 94, 2, 1),
(43, 94, 20, 1),
(44, 95, 22, 1),
(45, 96, 18, 1),
(46, 97, 17, 1),
(47, 98, 22, 1);

-- --------------------------------------------------------

--
-- Structure de la table `perfumes`
--

CREATE TABLE `perfumes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `brand` varchar(50) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `is_trendy` tinyint(1) DEFAULT 0,
  `is_new_arrival` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `perfumes`
--

INSERT INTO `perfumes` (`id`, `name`, `image`, `brand`, `category`, `is_trendy`, `is_new_arrival`) VALUES
(1, 'YVES SAINT LAURENT Y EDP', 'YSL.PNG', 'YSL', 'Man', 0, 0),
(3, 'BLEU DE CHANEL', 'CHANEL.B.png', 'Chanel', 'Man', 0, 1),
(5, 'JEAN PAUL GAULTIER LE BEAU PARADISE GARDEN', 'JPG.P.png', 'JEAN PAUL GAULTIER', 'Man', 0, 1),
(6, 'PRADA L\'HOMME EDT', 'PRADA.png', 'PRADA', 'Man', 0, 0),
(7, 'YVES SAINT LAURENT MYSELF EDP', 'MYSELF.png', 'YVES SAINT LAURENT', 'Man', 0, 1),
(8, 'DIOR HOMME', 'DIOR.PNG', 'DIOR', 'Man', 1, 0),
(9, 'AZZARO FOREVER WANTED ELIXIR', 'AZZARO.png', 'AZZARO', 'Man', 0, 1),
(10, 'JEAN PAUL GAULTIER LE MALE LE PARFUM', 'JPG.PARFUM.png', 'JEAN PAUL GAULTIER', 'Man', 1, 0),
(11, 'VALENTINO DONNA', 'VALENTINO.PNG', 'VALENTINO', 'Woman', 1, 0),
(12, 'GIVENCHY L\'INTERDIT ', 'GIVENCHY.png', 'GIVENCHY', 'Woman', 1, 0),
(13, 'NARCISO POUDRE', 'NARCISO.png', 'NARCISO', 'Woman', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `variants`
--

CREATE TABLE `variants` (
  `id` int(11) NOT NULL,
  `perfume_id` int(11) DEFAULT NULL,
  `type` enum('decant','full') DEFAULT NULL,
  `size_ml` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `variants`
--

INSERT INTO `variants` (`id`, `perfume_id`, `type`, `size_ml`, `price`, `quantity`) VALUES
(1, 1, 'decant', 10, '2800.00', 1),
(2, 1, 'full', 100, '23000.00', 1),
(3, 3, 'decant', 10, '3200.00', 1),
(4, 3, 'full', 100, '29500.00', 1),
(5, 5, 'decant', 10, '2800.00', 1),
(6, 5, 'full', 125, '27000.00', 1),
(7, 6, 'decant', 10, '2300.00', 1),
(8, 6, 'full', 100, '22000.00', 1),
(9, 7, 'decant', 10, '2600.00', 1),
(10, 7, 'full', 100, '22000.00', 1),
(11, 8, 'decant', 10, '2500.00', 1),
(12, 8, 'full', 100, '21000.00', 1),
(13, 9, 'decant', 10, '2600.00', 1),
(14, 9, 'full', 100, '24500.00', 1),
(15, 10, 'decant', 10, '2600.00', 1),
(16, 10, 'full', 100, '24000.00', 1),
(17, 11, 'decant', 10, '2900.00', 0),
(18, 11, 'full', 100, '24000.00', 0),
(19, 12, 'decant', 10, '3200.00', 1),
(20, 12, 'full', 100, '24000.00', 1),
(21, 13, 'decant', 10, '3200.00', 1),
(22, 13, 'full', 100, '29500.00', 0);

-- --------------------------------------------------------

--
-- Structure de la table `wilayas`
--

CREATE TABLE `wilayas` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price_depot` int(11) NOT NULL,
  `price_home` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `wilayas`
--

INSERT INTO `wilayas` (`id`, `name`, `price_depot`, `price_home`) VALUES
(1, 'Adrar', 0, 0),
(2, 'Chlef', 0, 0),
(3, 'Laghouat', 0, 0),
(4, 'Oum El Bouaghi', 0, 0),
(5, 'Batna', 0, 0),
(6, 'Béjaïa', 0, 0),
(7, 'Biskra', 0, 0),
(8, 'Béchar', 0, 0),
(9, 'Blida', 0, 0),
(10, 'Bouira', 0, 0),
(11, 'Tamanrasset', 0, 0),
(12, 'Tébessa', 0, 0),
(13, 'Tlemcen', 0, 0),
(14, 'Tiaret', 0, 0),
(15, 'Tizi Ouzou', 0, 0),
(16, 'Alger', 450, 650),
(17, 'Djelfa', 0, 0),
(18, 'Jijel', 0, 0),
(19, 'Sétif', 0, 0),
(20, 'Saïda', 0, 0),
(21, 'Skikda', 0, 0),
(22, 'Sidi Bel Abbès', 0, 0),
(23, 'Annaba', 400, 5),
(24, 'Guelma', 400, 650),
(25, 'Constantine', 0, 0),
(26, 'Médéa', 0, 0),
(27, 'Mostaganem', 0, 0),
(28, 'MSila', 0, 0),
(29, 'Mascara', 0, 0),
(30, 'Ouargla', 0, 0),
(31, 'Oran', 0, 0),
(32, 'El Bayadh', 0, 0),
(34, 'Bordj Bou Arreridj', 0, 0),
(35, 'Boumerdès', 0, 0),
(36, 'El Tarf', 0, 0),
(38, 'Tissemsilt', 0, 0),
(39, 'El Oued', 0, 0),
(40, 'Khenchela', 0, 0),
(41, 'Souk Ahras', 0, 0),
(42, 'Tipaza', 0, 0),
(43, 'Mila', 0, 0),
(44, 'Aïn Defla', 0, 0),
(45, 'Naâma', 0, 0),
(46, 'Aïn Témouchent', 0, 0),
(47, 'Ghardaïa', 0, 0),
(48, 'Relizane', 0, 0),
(49, 'Timimoun', 0, 0),
(51, 'Ouled Djellal', 0, 0),
(52, 'Béni Abbès', 0, 0),
(53, 'In Salah', 0, 0),
(54, 'In Guezzam', 0, 0),
(55, 'Touggourt', 0, 0),
(57, 'El M’Ghair', 0, 0),
(58, 'El Meniaa', 0, 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wilaya_id` (`wilaya_id`);

--
-- Index pour la table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `fk_variant` (`variant_id`);

--
-- Index pour la table `perfumes`
--
ALTER TABLE `perfumes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `variants`
--
ALTER TABLE `variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `perfume_id` (`perfume_id`);

--
-- Index pour la table `wilayas`
--
ALTER TABLE `wilayas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT pour la table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT pour la table `perfumes`
--
ALTER TABLE `perfumes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `variants`
--
ALTER TABLE `variants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `wilayas`
--
ALTER TABLE `wilayas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`wilaya_id`) REFERENCES `wilayas` (`id`);

--
-- Contraintes pour la table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_variant` FOREIGN KEY (`variant_id`) REFERENCES `variants` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Contraintes pour la table `variants`
--
ALTER TABLE `variants`
  ADD CONSTRAINT `variants_ibfk_1` FOREIGN KEY (`perfume_id`) REFERENCES `perfumes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
