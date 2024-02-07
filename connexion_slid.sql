-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 07 fév. 2024 à 10:55
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `connexion_slid`
--

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `google_email` varchar(150) DEFAULT NULL,
  `google_sub` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `name`, `email`, `password`, `google_email`, `google_sub`) VALUES
(3, 'asasas', 'as@sa.asass', '$2y$10$JFJEanh8hsFjjsBvFT921eKjNZHgPULFIKOW7oxNSlS0M3RDSPZfG', 'alexissimoes94@gmail.com', '$2y$10$DNxi5nC0iu5l23q/ygSs6.zvbwyfWfD2RmC0gDbiayai08pUvfN6G'),
(4, 'sas', 'ssss@asass', '$2y$10$hw9tZh/qFiH2T1SpxKPa0ORAC3AX0YH0EpYEunhjiD5GRq2ZlAnXC', NULL, NULL),
(60, 'sasas', 'sasa@sasa', '$2y$10$1yT/4xJLQkZ/9vOhEJW9Feb0xjouc22wLi/t4q9LH4h77Y0xsUYq2', NULL, NULL),
(6625, 'alexis', 'alexis@alexis.alexis', '$2y$10$7LT6QkWKI7TNRLasAa00P.x5xfF9zFXwDKgFmwqh40bMyKof6ew6G', NULL, NULL),
(6627, '', '', '$2y$10$6VK6vb9UssuW17/EtY3wM.RZ7zAoP0QCLFIPYYHq60Q4BAAqsZrDS', NULL, NULL),
(6628, NULL, NULL, NULL, '[value-5]', '[value-6]'),
(6629, NULL, NULL, NULL, 'alexissimoes94v2@gmail.com', '$2y$10$Ykk4k3IfB0ujZluY.uOOReqBuYiFiBRxpgwd5WwBcFthc/IgqtUCO');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `google_email` (`google_email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6630;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
