-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 27 déc. 2021 à 13:06
-- Version du serveur : 10.4.21-MariaDB
-- Version de PHP : 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `article` text NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `id_categorie` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `titre` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id`, `article`, `id_utilisateur`, `id_categorie`, `date`, `titre`) VALUES
(1, 'charlie delta', 3, 1, '2021-12-08 16:17:18', 'deklta'),
(2, 'beta', 3, 2, '2021-12-08 16:17:26', 'betabe'),
(3, 'lorem', 3, 1, '2021-12-13 14:28:25', 'testarticle'),
(4, 'lorem', 3, 1, '2021-12-14 09:20:03', 'testarticle'),
(5, 'Fait pas le mec mr SQL', 1, 2, '2021-12-20 08:56:42', 'count stp'),
(6, '1', 1, 1, '2021-12-20 10:07:51', 'il menfau 10'),
(7, '1', 1, 1, '2021-12-20 10:07:55', 'il menfau 10'),
(8, '2', 1, 1, '2021-12-20 10:08:06', 'encore'),
(9, '3', 1, 1, '2021-12-20 10:08:17', 'et c moi'),
(10, '4', 1, 1, '2021-12-20 10:08:28', 'je spam samer'),
(11, 'ouioui', 1, 1, '2021-12-20 10:08:39', 'je pense que c bonm'),
(12, 'oui', 1, 1, '2021-12-20 10:08:47', 'dernier'),
(13, 'cat1test', 1, 1, '2021-12-21 09:21:46', 'test3333'),
(14, 'cat1test', 1, 1, '2021-12-21 09:25:17', 'test3333'),
(15, 'azeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazevazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazev', 1, 1, '2021-12-23 19:36:19', 'aeazeazeaz'),
(16, 'marche pas mec', 1, 3, '2021-12-24 15:37:06', 'ça marche pas');

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `nom` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `nom`) VALUES
(1, 'catégorie1 '),
(2, 'catégorie2'),
(3, 'jkjhkjhb');

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

CREATE TABLE `commentaires` (
  `id` int(11) NOT NULL,
  `commentaire` varchar(1024) NOT NULL,
  `id_article` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `commentaires`
--

INSERT INTO `commentaires` (`id`, `commentaire`, `id_article`, `id_utilisateur`, `date`) VALUES
(1, '1', 1, 1, '2021-12-23 12:57:47'),
(2, '1', 1, 1, '2021-12-23 12:59:05'),
(3, 'toto', 14, 1, '2021-12-23 13:22:50'),
(4, 'test', 14, 1, '2021-12-23 13:37:21'),
(5, 'test', 14, 1, '2021-12-23 13:37:25'),
(6, 'test', 14, 1, '2021-12-23 13:40:00'),
(7, 'test', 14, 1, '2021-12-23 13:40:16'),
(8, 'test', 14, 1, '2021-12-23 13:40:50'),
(9, 'oui', 14, 1, '2021-12-23 13:40:57'),
(10, 'non', 14, 1, '2021-12-23 13:41:04'),
(11, 'non', 14, 1, '2021-12-23 13:42:12'),
(12, 'non', 14, 1, '2021-12-23 13:42:21'),
(13, 'test', 5, 1, '2021-12-23 13:42:36'),
(14, 'test', 5, 1, '2021-12-23 13:42:40'),
(15, 'test', 5, 1, '2021-12-23 13:43:04'),
(16, 'test', 5, 1, '2021-12-23 13:44:01'),
(17, 'test', 5, 1, '2021-12-23 13:45:01'),
(18, 'test', 5, 1, '2021-12-23 13:45:12'),
(19, 'test', 5, 1, '2021-12-23 13:45:24'),
(20, 'test', 5, 1, '2021-12-23 13:46:06'),
(21, 'test', 5, 1, '2021-12-23 13:47:04'),
(22, 'test', 5, 1, '2021-12-23 13:47:20'),
(23, 'test', 5, 1, '2021-12-23 13:48:00'),
(24, 'test', 5, 1, '2021-12-23 13:48:36'),
(25, 'test', 5, 1, '2021-12-23 13:49:27'),
(26, 'aa', 16, 1, '2021-12-24 16:13:16'),
(27, 'aezzaeazeaz', 15, 1, '2021-12-25 10:17:04');

-- --------------------------------------------------------

--
-- Structure de la table `droits`
--

CREATE TABLE `droits` (
  `id` int(11) NOT NULL,
  `nom` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `droits`
--

INSERT INTO `droits` (`id`, `nom`) VALUES
(1, 'utilisateur'),
(42, 'modérateur'),
(1337, 'administrateur');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `id_droits` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `login`, `password`, `email`, `id_droits`) VALUES
(1, 'behemoth', '$2y$10$KFQadQjGrKnOdHVRxpIkN.pE8QNSerTmnVNPi7ILAtMV1XqcBFkjO', 'alexzicaro20@gmail.com', 1337),
(3, 'charle', '$2y$10$7T1e2C/hf.tuaFPUnLcLluQ7Q02dd3dSlfH.GarZeWpEskZQcnTQS', 'charle@charle.com', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `droits`
--
ALTER TABLE `droits`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `commentaires`
--
ALTER TABLE `commentaires`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
