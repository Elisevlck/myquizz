-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 13 avr. 2020 à 02:14
-- Version du serveur :  10.4.11-MariaDB
-- Version de PHP : 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `myquizz`
--

-- --------------------------------------------------------

--
-- Structure de la table `genre`
--

CREATE TABLE `genre` (
  `genre_id` int(11) NOT NULL,
  `genre_nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `ut_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `part_date` date NOT NULL DEFAULT current_timestamp(),
  `quiz_niveau` varchar(255) NOT NULL,
  `part_score` decimal(11,3) NOT NULL,
  `part_temps` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `partie`
--

INSERT INTO `partie` (`part_id`, `ut_id`, `quiz_id`, `part_date`, `quiz_niveau`, `part_score`, `part_temps`) VALUES
(41, 1, 14, '2020-04-13', 'facile', '0.800', '26'),
(42, 1, 14, '2020-04-13', 'facile', '0.500', '17');

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

CREATE TABLE `question` (
  `ques_id` int(11) NOT NULL,
  `ques_cont` text NOT NULL,
  `ques_type` enum('texte','radio','checkbox') NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `ques_num` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `question`
--

INSERT INTO `question` (`ques_id`, `ques_cont`, `ques_type`, `quiz_id`, `ques_num`) VALUES
(41, 'Le 16 août 2009, en combien de temps Usain Bolt a-t-il parcouru les 100 mètres, discipline dont il détient le record?', 'radio', 14, 1),
(42, 'Quelle(s) ville(s) ont déjà accueilli les jeux olympiques ?', 'checkbox', 14, 2),
(43, 'Quand auront lieu les prochains jeux olympiques d’hiver? (Notez l’année)', 'texte', 14, 3),
(44, 'Qui détient le record du saut le plus haut depuis 1993 ?', 'radio', 14, 4),
(45, 'Qui détient le record du saut le plus long depuis 1991 ?', 'radio', 14, 5),
(46, 'Combien de fois l’équipe de france de handball masculine a-t-elle gagné le titre olympique ? ', 'texte', 14, 6),
(47, 'Au total, depuis 1896, dans quelle(s) discipline(s) la France comptabilise-t-elle plus de 20 médailles d’or ? ', 'checkbox', 14, 7),
(48, 'En 2016, combien de médailles d’or la France a-t-elle gagné?', 'texte', 14, 8),
(49, 'Le record au lancer de poids est détenu par R Barnes (USA) avec ', 'radio', 14, 9),
(50, 'Le record au lancer du disques est détenu par J. Schult (RDA) avec ...', 'radio', 14, 10);

-- --------------------------------------------------------

--
-- Structure de la table `quiz`
--

CREATE TABLE `quiz` (
  `quiz_id` int(11) NOT NULL,
  `quiz_nom` varchar(255) NOT NULL,
  `nbquestions` int(11) NOT NULL DEFAULT 10,
  `datecreation` datetime NOT NULL DEFAULT current_timestamp(),
  `theme_id` int(11) NOT NULL,
  `createur` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `quiz`
--

INSERT INTO `quiz` (`quiz_id`, `quiz_nom`, `nbquestions`, `datecreation`, `theme_id`, `createur`) VALUES
(14, 'Les records des jeux olympiques', 10, '2020-04-13 00:35:50', 1, 'elise');

-- --------------------------------------------------------

--
-- Structure de la table `reponse`
--

CREATE TABLE `reponse` (
  `rep_id` int(11) NOT NULL,
  `rep_cont` varchar(255) NOT NULL,
  `rep_niveau` enum('facile','moyen','difficile') DEFAULT NULL,
  `rep_estVrai` enum('vrai','faux') NOT NULL DEFAULT 'faux',
  `ques_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `reponse`
--

INSERT INTO `reponse` (`rep_id`, `rep_cont`, `rep_niveau`, `rep_estVrai`, `ques_id`) VALUES
(27, '9m58', 'facile', 'vrai', 41),
(28, '9m48', 'facile', 'faux', 41),
(29, '9m38', 'moyen', 'faux', 41),
(30, '9m28', 'difficile', 'faux', 41),
(31, 'France', 'facile', 'vrai', 42),
(32, 'Usa', 'facile', 'vrai', 42),
(33, 'Thaïlande', 'difficile', 'faux', 42),
(34, 'Afrique du Sud', 'moyen', 'faux', 42),
(35, '2022', 'facile', 'vrai', 43),
(36, 'J.Sotomayor(CUB)', 'facile', 'vrai', 44),
(37, 'M.Powell(USA)', 'facile', 'faux', 44),
(38, 'S.Bubka(UKR)', 'moyen', 'faux', 44),
(39, 'C.Lewis(USA)', 'difficile', 'faux', 44),
(40, 'M.Powell(USA)', 'facile', 'vrai', 45),
(41, 'X.Liu(CHN)', 'facile', 'faux', 45),
(42, 'C.Lewis(USA)', 'moyen', 'faux', 45),
(43, 'S.Bubka(UKR)', 'difficile', 'faux', 45),
(44, '2', 'facile', 'vrai', 46),
(45, 'Escrime', 'facile', 'vrai', 47),
(46, 'Cyclisme', 'difficile', 'vrai', 47),
(47, 'Judo', 'moyen', 'faux', 47),
(48, 'Athlétisme', 'facile', 'faux', 47),
(49, '10', 'facile', 'vrai', 48),
(50, '23m12', 'facile', 'vrai', 49),
(51, '43m12', 'facile', 'faux', 49),
(52, '60m12', 'moyen', 'faux', 49),
(53, '38m12', 'difficile', 'faux', 49),
(54, '74m08', 'facile', 'vrai', 50),
(55, '34m08', 'facile', 'faux', 50),
(56, '103m08', 'moyen', 'faux', 50),
(57, '94m08', 'difficile', 'faux', 50);

-- --------------------------------------------------------

--
-- Structure de la table `theme`
--

CREATE TABLE `theme` (
  `theme_id` int(11) NOT NULL,
  `theme_nom` varchar(255) NOT NULL,
  `genre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `theme`
--

INSERT INTO `theme` (`theme_id`, `theme_nom`, `genre_id`) VALUES
(1, 'Sport', 1),
(2, 'Musique', 1),
(3, 'Mathématiques', 2),
(4, 'Géographie', 2);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `ut_id` int(11) NOT NULL,
  `ut_nom` varchar(255) NOT NULL,
  `ut_mail` varchar(255) NOT NULL,
  `ut_mdp` varchar(255) NOT NULL,
  `ut_role` enum('administrateur','joueur') NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `lastlogin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`ut_id`, `ut_nom`, `ut_mail`, `ut_mdp`, `ut_role`, `avatar`, `lastlogin`) VALUES
(1, 'elise', 'pvilayleck@ensc.fr', 'bonjour', 'administrateur', '', 0),
(2, 'eduboz', 'eduboz@ensc.fr', 'coucou', 'administrateur', '', 0),
(3, 'dub', 'didier.duboz@wanadoo.fr', 'a', 'joueur', '', 0);

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
  ADD PRIMARY KEY (`part_id`);

--
-- Index pour la table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`ques_id`);

--
-- Index pour la table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`quiz_id`),
  ADD UNIQUE KEY `quiz_nom` (`quiz_nom`);

--
-- Index pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD PRIMARY KEY (`rep_id`);

--
-- Index pour la table `theme`
--
ALTER TABLE `theme`
  ADD PRIMARY KEY (`theme_id`),
  ADD UNIQUE KEY `theme_nom` (`theme_nom`);

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
  MODIFY `part_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT pour la table `question`
--
ALTER TABLE `question`
  MODIFY `ques_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT pour la table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `reponse`
--
ALTER TABLE `reponse`
  MODIFY `rep_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT pour la table `theme`
--
ALTER TABLE `theme`
  MODIFY `theme_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `ut_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
