-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : ven. 17 avr. 2020 à 22:10
-- Version du serveur :  10.3.16-MariaDB
-- Version de PHP : 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `id13265287_bdd`
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
(41, 1, 14, '2020-04-13', 'facile', 0.800, '26'),
(42, 1, 14, '2020-04-13', 'facile', 0.500, '17'),
(60, 1, 19, '2020-04-16', 'difficile', 0.364, '80'),
(61, 1, 19, '2020-04-16', 'difficile', 0.636, '90'),
(63, 1, 21, '2020-04-17', 'facile', 0.636, '87'),
(85, 1, 17, '2020-04-17', 'facile', 1.000, '166'),
(86, 1, 23, '2020-04-17', 'facile', 1.000, '24'),
(87, 1, 23, '2020-04-17', 'facile', 1.000, '45'),
(88, 1, 23, '2020-04-17', 'facile', 0.333, '1587127886'),
(89, 1, 23, '2020-04-17', 'facile', 0.000, '1587127936'),
(90, 1, 23, '2020-04-17', 'facile', 1.000, '1587128307'),
(92, 1, 23, '2020-04-17', 'facile', 0.667, '10'),
(93, 1, 23, '2020-04-17', 'facile', 1.000, '15'),
(94, 1, 23, '2020-04-17', 'facile', 0.667, '12'),
(95, 1, 23, '2020-04-17', 'facile', 0.667, '9'),
(97, 1, 17, '2020-04-17', 'facile', 0.800, '40'),
(98, 1, 19, '2020-04-17', 'facile', 0.909, '87'),
(99, 1, 17, '2020-04-17', 'moyen', 1.000, '59'),
(100, 1, 17, '2020-04-17', 'moyen', 1.000, '119'),
(101, 13, 17, '2020-04-17', 'facile', 0.600, '43'),
(102, 13, 17, '2020-04-17', 'facile', 0.600, '63'),
(103, 13, 17, '2020-04-17', 'facile', 0.500, '30'),
(104, 13, 19, '2020-04-17', 'facile', 0.545, '29'),
(105, 2, 32, '2020-04-17', 'facile', 0.500, '6'),
(106, 1, 17, '2020-04-17', 'facile', 0.600, '207');

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

CREATE TABLE `question` (
  `ques_id` int(11) NOT NULL,
  `ques_cont` text NOT NULL,
  `ques_type` enum('texte','radio','checkbox') NOT NULL,
  `ques_media` text DEFAULT NULL,
  `quiz_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `question`
--

INSERT INTO `question` (`ques_id`, `ques_cont`, `ques_type`, `ques_media`, `quiz_id`) VALUES
(41, 'Le 16 août 2009, en combien de temps Usain Bolt a-t-il parcouru les 100 mètres, discipline dont il détient le record?', 'radio', 'NULL', 14),
(42, 'Quelle(s) ville(s) ont déjà accueilli les jeux olympiques ?', 'checkbox', 'NULL', 14),
(43, 'Quand auront lieu les prochains jeux olympiques d’hiver? (Notez l’année)', 'texte', 'NULL', 14),
(44, 'Qui détient le record du saut le plus haut depuis 1993 ?', 'radio', NULL, 14),
(45, 'Qui détient le record du saut le plus long depuis 1991 ?', 'radio', NULL, 14),
(46, 'Combien de fois l’équipe de france de handball masculine a-t-elle gagné le titre olympique ? ', 'texte', NULL, 14),
(47, 'Au total, depuis 1896, dans quelle(s) discipline(s) la France comptabilise-t-elle plus de 20 médailles d’or ? ', 'checkbox', NULL, 14),
(48, 'En 2016, combien de médailles d’or la France a-t-elle gagné?', 'texte', NULL, 14),
(49, 'Le record au lancer de poids est détenu par R Barnes (USA) avec ', 'radio', NULL, 14),
(50, 'Le record au lancer du disques est détenu par J. Schult (RDA) avec ...', 'radio', NULL, 14),
(64, 'Qui interprète la musique de cet extrait, issu du film \"Drive\" sorti en 2011 ?', 'texte', 'files/drive.mp4', 17),
(65, 'Quel groupe interprète cette musique issue d\'un grand film Américain ?', 'texte', 'files/eye_of_the_tiger.mp4', 17),
(66, 'Qui a composé cette célèbre valse ?', 'radio', 'files/amelie_poulain.mp4', 17),
(67, 'De quel film est issue cette célèbre danse exécutée par Louis de Funès ?', 'radio', 'files/de_funes.mp4', 17),
(68, 'Dans quel film d\'animation peut-on entendre cette musique ?', 'texte', 'files/all_stars.mp3', 17),
(70, 'Quel est le nom du pays coloré ?', 'texte', 'files/suriname.PNG', 19),
(71, 'Quel est le nom du pays coloré ?', 'radio', 'files/perou.PNG', 19),
(72, 'Cochez les pays limitrophes (qui ont une frontière commune) au pays coloré ?', 'checkbox', 'files/uruguay.PNG', 19),
(73, 'Quel est le nom du pays coloré ?', 'radio', 'files/bolivie.PNG', 19),
(74, 'Quel est le nom du pays coloré ?', 'radio', 'files/paraguay.PNG', 19),
(75, 'Quel est le nom du pays coloré ?', 'radio', 'files/equateur.PNG', 19),
(76, 'Quel est le nom du pays coloré ?', 'texte', 'files/venezuela.PNG', 19),
(77, 'Quel est le nom du pays coloré ?', 'radio', 'files/guyana.PNG', 19),
(78, 'Cochez les pays limitrophes (qui ont des frontières communes) au pays coloré :', 'checkbox', 'files/chile.PNG', 19),
(79, 'Cochez les pays limitrophes (qui ont des frontières communes) au pays coloré :', 'checkbox', 'files/bresil.PNG', 19),
(80, 'Cochez les pays limitrophes (qui ont une frontière commune) au pays coloré :', 'checkbox', 'files/colombie.PNG', 19),
(81, 'En 2017, à quel rang économique mondial la France se situe-t-elle ?', 'radio', 'NULL', 20),
(82, 'De quelles organisations mondiales la France fait-elle partie ?', 'checkbox', 'NULL', 20),
(83, 'Quelle superficie recouvre la ZEE française ?', 'radio', 'NULL', 20),
(84, 'Quel est le sigle désignant l’organisation regroupant les francophones du monde entier ?', 'texte', 'NULL', 20),
(85, 'Quel est le sigle représentant une entreprise dont la majorité du chiffre d’affaire est effectué en dehors de son pays d’origine ?', 'texte', 'NULL', 20),
(86, 'Combien de membres l’UE possède-t-elle actuellement ?', 'texte', 'NULL', 20),
(87, 'Quelle part de la richesse mondiale est produite par l’UE ?', 'radio', 'NULL', 20),
(88, 'Comment s’appelle l’ensemble d’Etats ou de régions qui exercent une forte influence sur l’organisation du monde ?', 'radio', 'NULL', 20),
(89, 'Quel pourcentage des flux internationaux de touristes sont captés par les membres de l’UE ?', 'radio', 'NULL', 20),
(90, 'Quand a été créée la fonction de Haut représentant pour la politique européenne et de sécurité commune ?', 'texte', 'NULL', 20),
(91, 'Sélectionnez le(s) membre(s) fondateur(s) de la Communauté économique Européenne en 1957 : ', 'checkbox', 'NULL', 20),
(92, 'Sélectionnez les pays qui ne font pas parti de l\'Union Européenne : ', 'checkbox', 'NULL', 20),
(93, 'Sélectionnez les années où des pays ont effectivement intégré l\'Union Européenne :', 'checkbox', 'NULL', 20),
(94, 'Comment appelle-t-on un malentendu, au théâtre ?', 'radio', 'NULL', 21),
(95, 'Comment appelle-t-on la situation d\'un personnage, placé devant un choix impossible ?', 'radio', 'NULL', 21),
(96, 'Quel dramaturge est célèbre pour ses dilemmes ?', 'texte', 'NULL', 21),
(97, 'Qu\'est-ce qu\'une tirade ?', 'radio', 'NULL', 21),
(98, 'Comment appelle-t-on un auteur de théâtre ?', 'radio', 'NULL', 21),
(99, 'Quel philosophe donne la définition de la catharsis ?', 'texte', 'NULL', 21),
(100, 'Comment est divisée une pièce de théâtre ? La pièce de théâtre est traditionnellement divisée...', 'radio', 'NULL', 21),
(101, 'A quel genre théâtral appartient la farce ? Est-ce un type de...', 'radio', 'NULL', 21),
(102, 'Combien d\'actes comporte la tragédie classique ?', 'texte', 'NULL', 21),
(103, 'Sélectionnez le(s) oeuvre(s) écrite(s) par Molière :', 'checkbox', 'NULL', 21),
(104, 'Sélectionnez les figures de style désignées comme figures d\'opposition :', 'checkbox', 'NULL', 21),
(105, 'Quel est le nom de ce morceau de piano présent dans Intouchables ?', 'radio', 'files/intouchables.mp4', 17),
(106, 'Sélectionnez les musiques qui ont déjà été bande originale d\'un des James Bond :', 'checkbox', 'files/james_bond.mp4', 17),
(107, 'Dans quel volet de la saga Pirates des Caraibes peut-on trouver cet extrait musical ?', 'radio', 'files/pirates.mp4', 17),
(108, 'Sélectionnez le(s) cérémonie(s) lors de laquelle/desquelles cette chanson a reçu un prix :', 'checkbox', 'files/shallow.mp4', 17),
(109, 'Sélectionnez le(s) cérémonie(s) lors de laquelle/desquelles cette chanson a reçu un prix :', 'checkbox', 'files/titanic.mp4', 17),
(110, 'Sélectionnez la/les proposition(s) qui sont effectivement vraie(s) à propos de cette chanson de Johnny Hallyday :', 'checkbox', 'files/johnny.mp4', 23),
(111, 'Comment est mort Daniel Balavoine ?', 'radio', 'files/balavoine.png', 23),
(112, 'En quelle année est mort l\'interprète de cette chanson ?', 'texte', 'files/la_boheme.mp3', 23),
(132, 'Quel est cet animal?', 'texte', NULL, 32),
(133, 'Combien de pattes possèdent le chien ?', 'radio', NULL, 32);

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
(14, 'Les records des jeux olympiques', 10, '2020-04-13 00:35:50', 1, 'elise'),
(17, 'Musiques de film', 10, '2020-04-15 16:14:20', 2, 'elise'),
(19, 'Les pays d\'Amérique du Sud', 11, '2020-04-16 13:44:45', 4, 'elise'),
(20, 'La place de la France et de l\'Europe dans le Monde', 13, '2020-04-16 20:01:45', 4, 'elise'),
(21, 'Champ lexical du théâtre', 11, '2020-04-16 20:23:33', 16, 'elise'),
(23, 'Les chanteurs français défunts', 3, '2020-04-16 21:56:50', 2, 'elise'),
(32, 'animaux', 2, '2020-04-17 19:53:52', 24, 'eduboz');

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
(57, '94m08', 'difficile', 'faux', 50),
(106, 'perou', 'facile', 'vrai', 71),
(107, 'bolivie', 'facile', 'faux', 71),
(108, 'colombie', 'moyen', 'faux', 71),
(109, 'chili', 'difficile', 'faux', 71),
(110, 'argentine', 'facile', 'vrai', 72),
(111, 'paraguay', 'facile', 'faux', 72),
(112, 'chili', 'moyen', 'faux', 72),
(113, 'equateur', 'difficile', 'faux', 72),
(114, 'bolivie', 'facile', 'vrai', 73),
(115, 'colombie', 'facile', 'faux', 73),
(116, 'perou', 'moyen', 'faux', 73),
(117, 'chili', 'difficile', 'faux', 73),
(118, 'paraguay', 'facile', 'vrai', 74),
(119, 'bresil', 'facile', 'faux', 74),
(120, 'uruguay', 'moyen', 'faux', 74),
(121, 'panama', 'difficile', 'faux', 74),
(122, 'equateur', 'facile', 'vrai', 75),
(123, 'venezuela', 'facile', 'faux', 75),
(124, 'honduras', 'moyen', 'faux', 75),
(125, 'colombie', 'difficile', 'faux', 75),
(126, 'venezuela', 'facile', 'vrai', 76),
(127, 'guyana', 'facile', 'vrai', 77),
(128, 'panama', 'facile', 'faux', 77),
(129, 'equateur', 'moyen', 'faux', 77),
(130, 'honduras', 'difficile', 'faux', 77),
(131, 'bresil', 'facile', 'faux', 78),
(132, 'bolivie', 'facile', 'vrai', 78),
(133, 'colombie', 'moyen', 'faux', 78),
(134, 'uruguay', 'difficile', 'faux', 78),
(135, 'equateur', 'facile', 'faux', 79),
(136, 'venezuela', 'facile', 'vrai', 79),
(137, 'argentine', 'moyen', 'faux', 79),
(138, 'uruguay', 'difficile', 'vrai', 79),
(139, 'argentine', 'facile', 'faux', 80),
(140, 'venezuela', 'facile', 'vrai', 80),
(141, 'guyana', 'moyen', 'faux', 80),
(142, 'bresil', 'difficile', 'vrai', 80),
(143, '6e puissance économique mondiale', 'facile', 'vrai', 81),
(144, '10e puissance économique mondiale', 'facile', 'faux', 81),
(145, '8e puissance économique mondiale', 'moyen', 'faux', 81),
(146, '4e puissance économique mondiale', 'difficile', 'faux', 81),
(147, 'onu', 'facile', 'vrai', 82),
(148, 'otan', 'facile', 'vrai', 82),
(149, 'omc', 'moyen', 'vrai', 82),
(150, 'fmi', 'difficile', 'vrai', 82),
(151, '11 millions de km²', 'facile', 'vrai', 83),
(152, '7 millions de km²', 'facile', 'faux', 83),
(153, '15 millions de km²', 'moyen', 'faux', 83),
(154, '1 millions de km²', 'difficile', 'faux', 83),
(155, 'oif', 'facile', 'vrai', 84),
(156, 'ftn', 'facile', 'vrai', 85),
(157, '28', 'facile', 'vrai', 86),
(158, '25%', 'facile', 'vrai', 87),
(159, '50%', 'facile', 'faux', 87),
(160, '35%', 'moyen', 'faux', 87),
(161, '10%', 'difficile', 'faux', 87),
(162, 'aire de puissance', 'facile', 'vrai', 88),
(163, 'pma', 'facile', 'faux', 88),
(164, 'pôle d\'influence', 'moyen', 'faux', 88),
(165, 'puissance émergente', 'difficile', 'faux', 88),
(166, '55%', 'facile', 'vrai', 89),
(167, '40%', 'facile', 'faux', 89),
(168, '70%', 'moyen', 'faux', 89),
(169, '35%', 'difficile', 'faux', 89),
(170, '2009', 'facile', 'vrai', 90),
(171, 'france', 'facile', 'vrai', 91),
(172, 'autriche', 'facile', 'faux', 91),
(173, 'espagne', 'moyen', 'faux', 91),
(174, 'royaume-uni', 'difficile', 'faux', 91),
(175, 'suisse', 'facile', 'vrai', 92),
(176, 'slovaquie', 'facile', 'faux', 92),
(177, 'chypre', 'moyen', 'faux', 92),
(178, 'norvège', 'difficile', 'vrai', 92),
(179, '1973', 'facile', 'vrai', 93),
(180, '1981', 'facile', 'vrai', 93),
(181, '1986', 'moyen', 'vrai', 93),
(182, '1995', 'difficile', 'vrai', 93),
(183, 'un quiproquo', 'facile', 'vrai', 94),
(184, 'une discussion', 'facile', 'faux', 94),
(185, 'la catharsis', 'moyen', 'faux', 94),
(186, 'un embrouillamini', 'difficile', 'faux', 94),
(187, 'le dilemme', 'facile', 'vrai', 95),
(188, 'l\'anathème', 'facile', 'faux', 95),
(189, 'le blocage', 'moyen', 'faux', 95),
(190, 'la catharsis', 'difficile', 'faux', 95),
(191, 'corneille', 'facile', 'vrai', 96),
(192, 'une longue réplique', 'facile', 'vrai', 97),
(193, 'un monologue', 'facile', 'faux', 97),
(194, 'une bagarre sur scène', 'moyen', 'faux', 97),
(195, 'un duel sur scène', 'difficile', 'faux', 97),
(196, 'un dramaturge', 'facile', 'vrai', 98),
(197, 'un tragédiste', 'facile', 'faux', 98),
(198, 'un écrivain', 'moyen', 'faux', 98),
(199, 'un poète', 'difficile', 'faux', 98),
(200, 'aristote', 'facile', 'vrai', 99),
(201, 'en actes, divisés en scène', 'facile', 'vrai', 100),
(202, 'en scènes, divisées en acte', 'facile', 'faux', 100),
(203, 'seulement en scènes', 'moyen', 'faux', 100),
(204, 'en actes ou en scènes, mais pas les deux à la fois', 'difficile', 'faux', 100),
(205, 'comédie ?', 'facile', 'vrai', 101),
(206, 'tragédie ?', 'facile', 'faux', 101),
(207, 'drame ?', 'moyen', 'faux', 101),
(208, 'mélodrame ?', 'difficile', 'faux', 101),
(209, '5', 'facile', 'vrai', 102),
(210, 'les fourberies de scapin', 'facile', 'vrai', 103),
(211, 'l\'avare', 'facile', 'vrai', 103),
(212, 'phèdre', 'moyen', 'faux', 103),
(213, 'oedipe', 'difficile', 'faux', 103),
(214, 'le chiasme', 'facile', 'vrai', 104),
(215, 'la litote', 'facile', 'faux', 104),
(216, 'l\'anaphore', 'moyen', 'faux', 104),
(217, 'la périphrase', 'difficile', 'faux', 104),
(241, 'kavinsky', 'facile', 'vrai', 64),
(242, 'survivor', 'facile', 'vrai', 65),
(243, 'yann tiersen', 'facile', 'vrai', 66),
(244, 'yan tiersen', 'facile', 'faux', 66),
(245, 'yann tiercen', 'moyen', 'faux', 66),
(246, 'yan tiercène', 'difficile', 'faux', 66),
(247, 'les aventures de rabbi jacob', 'facile', 'vrai', 67),
(248, 'la soupe aux choux', 'facile', 'faux', 67),
(249, 'le gendarme de saint-tropez', 'moyen', 'faux', 67),
(250, 'la grande vadrouille', 'difficile', 'faux', 67),
(251, 'shrek', 'facile', 'vrai', 68),
(252, 'una mattina', 'facile', 'vrai', 105),
(253, 'fly', 'facile', 'faux', 105),
(254, 'senza respiro', 'moyen', 'faux', 105),
(255, 'cache-cache', 'difficile', 'faux', 105),
(256, 'adèle - skyfall', 'facile', 'vrai', 106),
(257, 'chris cornell - you know my name', 'facile', 'vrai', 106),
(258, 'wings - live and let die', 'moyen', 'vrai', 106),
(259, 'sam smith - writing\'s on the wall', 'difficile', 'vrai', 106),
(260, 'jusqu\'au bout du monde', 'facile', 'vrai', 107),
(261, 'la malédiction du black pearl', 'facile', 'faux', 107),
(262, 'le secret du coffre maudit', 'moyen', 'faux', 107),
(263, 'la fontaine de jouvence', 'difficile', 'faux', 107),
(264, 'oscars', 'facile', 'vrai', 108),
(265, 'bafta', 'facile', 'vrai', 108),
(266, 'golden globes', 'moyen', 'vrai', 108),
(267, 'peta oscat', 'difficile', 'faux', 108),
(268, 'mtv movie awards', 'facile', 'faux', 109),
(269, 'golden globes', 'facile', 'vrai', 109),
(270, 'empire awards', 'moyen', 'faux', 109),
(271, 'saturn awards', 'difficile', 'faux', 109),
(272, 'la chanson a été composée par zazie', 'facile', 'vrai', 110),
(273, 'la chanson figure sur l\'album nommé \"allumer le feu\"', 'facile', 'faux', 110),
(274, 'la chanson est sortie en août 1998', 'moyen', 'faux', 110),
(275, 'la chanson est restée 20 semaines consécutives dans le classement des meilleurs ventes en france', 'difficile', 'vrai', 110),
(276, 'd\'une crise cardiaque', 'facile', 'vrai', 111),
(277, 'électrocuté', 'facile', 'faux', 111),
(278, 'suite à un accident d\'hélicoptère', 'moyen', 'faux', 111),
(279, 'suite à un suicide', 'difficile', 'faux', 111),
(280, '2018', 'facile', 'vrai', 112),
(300, 'suriname', 'facile', 'vrai', 70),
(301, 'chat', 'facile', 'vrai', 132),
(302, '4', 'facile', 'vrai', 133),
(303, '5', 'facile', 'faux', 133),
(304, '6', 'moyen', 'faux', 133),
(305, '2', 'moyen', 'faux', 133);

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
(4, 'Histoire-Géographie', 2),
(16, 'Français', 2),
(24, 'testquiz', 1);

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
  `avatar` varchar(255) DEFAULT NULL,
  `lastlogin` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`ut_id`, `ut_nom`, `ut_mail`, `ut_mdp`, `ut_role`, `avatar`, `lastlogin`) VALUES
(1, 'elise', 'pvilayleck@ensc.fr', 'bonjour', 'administrateur', 'elise.jpg', 1587156786),
(2, 'eduboz', 'dubozemma@gmail.com', 'K2Ga2XzZ', 'administrateur', NULL, 1587153345),
(13, 'joueur1', 'eduboz@ensc.fr', 'za', 'joueur', 'joueur1.jpg', 1587151562);

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
  ADD PRIMARY KEY (`rep_id`),
  ADD KEY `ques_id` (`ques_id`) USING BTREE;

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
  MODIFY `part_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT pour la table `question`
--
ALTER TABLE `question`
  MODIFY `ques_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT pour la table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pour la table `reponse`
--
ALTER TABLE `reponse`
  MODIFY `rep_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=306;

--
-- AUTO_INCREMENT pour la table `theme`
--
ALTER TABLE `theme`
  MODIFY `theme_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `ut_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
