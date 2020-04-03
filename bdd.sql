-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mar. 24 mars 2020 à 12:54
-- Version du serveur :  10.3.16-MariaDB
-- Version de PHP :  7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `myquizz`
--

-- --------------------------------------------------------

--
-- Structure de la table `genre`
--

CREATE TABLE `genre` (
  `genre_id` int(11) NOT NULL,
  `genre_nom` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `genre`
--

INSERT INTO `genre` (`genre_id`, `genre_nom`) VALUES
(1, 'Thèmes'),
(2, 'Révisions');

-- --------------------------------------------------------

--
-- Structure de la table `partie`
--

CREATE TABLE `partie` (
  `part_id` int(11) NOT NULL,
  `part_score` int(11) NOT NULL,
  `part_temps` time NOT NULL,
  `part_date` date NOT NULL DEFAULT current_timestamp(),
  `ut_id` int(11) NOT NULL,
  `quiz_nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

CREATE TABLE `question` (
  `ques_id` int(11) NOT NULL,
  `ques_type` enum('texte','radio','checkbox') NOT NULL,
  `ques_cont` varchar(255) NOT NULL,
  `quiz_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `question`
--

INSERT INTO `question` (`ques_id`, `ques_type`, `ques_cont`, `quiz_id`) VALUES
(1, 'texte', 'Combien de fois l’équipe de France de handball masculine a-t-elle gagné le titre olympique ? ', 1),
(2, 'radio', 'Le 16 août 2009, en combien de temps Usain Bolt a-t-il parcouru les 100 mètres, discipline dont il détient le record?', 1),
(3, 'checkbox', 'Quelle(s) ville(s) ont déjà accueilli les jeux olympiques ?\r\n', 1);

-- --------------------------------------------------------

--
-- Structure de la table `quiz`
--

CREATE TABLE `quiz` (
  `quiz_id` int(11) NOT NULL,
  `quiz_nom` varchar(255) NOT NULL,
  `nbquestions` int(11) DEFAULT 10,
  `datecreation` date NOT NULL DEFAULT current_timestamp(),
  `id_theme` int(11) NOT NULL,
  `ut_nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `quiz`
--

INSERT INTO `quiz` (`quiz_id`, `quiz_nom`, `nbquestions`, `datecreation`, `id_theme`, `ut_nom`) VALUES
(1, 'Les records des jeux olympiques', 10, '2020-03-20', 1, ''),
(2, 'Les années 2000', 10, '2020-03-23', 2, ''),
(3, 'Révisions pour le brevet', 10, '2020-03-23', 3, ''),
(4, 'La seconde guerre mondiale', 10, '2020-03-23', 4, '');

-- --------------------------------------------------------

--
-- Structure de la table `reponse`
--

CREATE TABLE `reponse` (
  `rep_id` int(11) NOT NULL,
  `rep_cont` varchar(255) NOT NULL,
  `rep_niveau` enum('facile','intermédiaire','difficile') NOT NULL,
  `rep_estVrai` enum('vrai','faux') NOT NULL DEFAULT 'faux',
  `ques_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `reponse`
--

INSERT INTO `reponse` (`rep_id`, `rep_cont`, `rep_niveau`, `rep_estVrai`, `ques_id`) VALUES
(1, 'France', 'facile', 'vrai', 3),
(2, 'USA', 'facile', 'vrai', 3),
(3, 'Thailande', 'difficile', 'faux', 3),
(4, '9m38', 'facile', 'faux', 2),
(5, '9m48', 'facile', 'faux', 2),
(6, '9m58', 'facile', 'vrai', 2);

-- --------------------------------------------------------

--
-- Structure de la table `theme`
--

CREATE TABLE `theme` (
  `theme_id` int(11) NOT NULL,
  `theme_nom` varchar(255) NOT NULL,
  `genre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `theme`
--

INSERT INTO `theme` (`theme_id`, `theme_nom`, `genre_id`) VALUES
(1, 'Sport', 1),
(2, 'Musique', 1),
(3, 'Mathématiques', 2),
(4, 'Gégraphie', 2);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `ut_id` int(11) NOT NULL,
  `ut_nom` varchar(255) NOT NULL,
  `ut_mail` varchar(255) NOT NULL,
  `ut_mdp` varchar(255) NOT NULL,
  `ut_role` enum('joueur','administrateur') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`ut_id`, `ut_nom`, `ut_mail`, `ut_mdp`, `ut_role`) VALUES
(1, 'elise', 'pvilayleck@ensc.fr', 'prout', 'joueur');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`genre_id`);

--
-- Index pour la table `partie`
--
ALTER TABLE `partie`
  ADD PRIMARY KEY (`part_id`),
  ADD KEY `ut_id` (`ut_id`),
  ADD KEY `quiz_nom` (`quiz_nom`);

--
-- Index pour la table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`ques_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Index pour la table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`quiz_id`),
  ADD UNIQUE KEY `quiz_nom` (`quiz_nom`),
  ADD KEY `id_theme` (`id_theme`),
  ADD KEY `ut_nom` (`ut_nom`);

--
-- Index pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD PRIMARY KEY (`rep_id`),
  ADD KEY `ques_id` (`ques_id`);

--
-- Index pour la table `theme`
--
ALTER TABLE `theme`
  ADD PRIMARY KEY (`theme_id`),
  ADD KEY `genre_id` (`genre_id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`ut_id`),
  ADD UNIQUE KEY `ut_nom` (`ut_nom`),
  ADD UNIQUE KEY `ut_mail` (`ut_mail`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `genre`
--
ALTER TABLE `genre`
  MODIFY `genre_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `partie`
--
ALTER TABLE `partie`
  MODIFY `part_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `question`
--
ALTER TABLE `question`
  MODIFY `ques_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `theme`
--
ALTER TABLE `theme`
  MODIFY `theme_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `ut_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `partie`
--
ALTER TABLE `partie`
  ADD CONSTRAINT `quiz_nom` FOREIGN KEY (`quiz_nom`) REFERENCES `quiz` (`quiz_nom`),
  ADD CONSTRAINT `ut_id` FOREIGN KEY (`ut_id`) REFERENCES `utilisateur` (`ut_id`);

--
-- Contraintes pour la table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `quiz_id` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`quiz_id`);

--
-- Contraintes pour la table `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `id_theme` FOREIGN KEY (`id_theme`) REFERENCES `theme` (`theme_id`);

--
-- Contraintes pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD CONSTRAINT `ques_id` FOREIGN KEY (`ques_id`) REFERENCES `question` (`ques_id`);

--
-- Contraintes pour la table `theme`
--
ALTER TABLE `theme`
  ADD CONSTRAINT `genre_id` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`genre_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



