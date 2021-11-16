-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 29 sep. 2021 à 12:36
-- Version du serveur :  10.4.11-MariaDB
-- Version de PHP : 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet5_blog`
--
CREATE DATABASE IF NOT EXISTS `projet5_blog` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `projet5_blog`;

-- --------------------------------------------------------

--
-- Structure de la table `bpf_blog_posts`
--

CREATE TABLE `bpf_blog_posts` (
  `id` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `last_date_change` datetime NOT NULL,
  `chapo` text COLLATE utf8mb4_bin NOT NULL,
  `contents` text COLLATE utf8mb4_bin NOT NULL,
  `publish` enum('valid','waiting') COLLATE utf8mb4_bin NOT NULL DEFAULT 'waiting' COMMENT 'Expected values:\r\nvalid: Article validated by Admin\r\nwaiting : ''Draft'' article awaiting validation by the Admin',
  `id_bpf_users` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `bpf_comments`
--

CREATE TABLE `bpf_comments` (
  `id` int(11) NOT NULL,
  `contents` text COLLATE utf8mb4_bin NOT NULL,
  `publish` enum('valid','waiting','refuse') COLLATE utf8mb4_bin NOT NULL DEFAULT 'waiting' COMMENT 'Expected values:\r\nvalid: Comment validated by Admin\r\nwaiting: Comment awaiting validation by Admin\r\nrefused: Comment refused by Admin ',
  `id_bpf_blog_posts` int(11) NOT NULL,
  `id_bpf_users` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `bpf_users`
--

CREATE TABLE `bpf_users` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(200) COLLATE utf8mb4_bin NOT NULL,
  `rank` enum('admin','pending','registered') COLLATE utf8mb4_bin NOT NULL DEFAULT 'pending' COMMENT 'Expected values:\r\nadmin: Define the Admin profile\r\npending: Registered user awaiting validation by Admin\r\nregistered: Registered user validated by Admin Expected values:\r\nadmin: Define the Admin profile\r\npending: Registered user awaiting validation by Admin\r\nregistered: Registered user validated by Admin '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `bpf_blog_posts`
--
ALTER TABLE `bpf_blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_bpf_users` (`id_bpf_users`) USING BTREE;

--
-- Index pour la table `bpf_comments`
--
ALTER TABLE `bpf_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bpf_comments_ibfk_1` (`id_bpf_blog_posts`),
  ADD KEY `id_bpf_users` (`id_bpf_users`) USING BTREE;

--
-- Index pour la table `bpf_users`
--
ALTER TABLE `bpf_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pseudo` (`pseudo`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `bpf_blog_posts`
--
ALTER TABLE `bpf_blog_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT pour la table `bpf_comments`
--
ALTER TABLE `bpf_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT pour la table `bpf_users`
--
ALTER TABLE `bpf_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `bpf_blog_posts`
--
ALTER TABLE `bpf_blog_posts`
  ADD CONSTRAINT `bpf_blog_posts_ibfk_1` FOREIGN KEY (`id_bpf_users`) REFERENCES `bpf_users` (`id`);

--
-- Contraintes pour la table `bpf_comments`
--
ALTER TABLE `bpf_comments`
  ADD CONSTRAINT `bpf_comments_ibfk_1` FOREIGN KEY (`id_bpf_blog_posts`) REFERENCES `bpf_blog_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bpf_comments_ibfk_2` FOREIGN KEY (`id_bpf_users`) REFERENCES `bpf_users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
