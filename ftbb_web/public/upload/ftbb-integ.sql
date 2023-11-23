-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 27, 2021 at 12:20 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ftbb-integ`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `number` int(8) NOT NULL,
  `birthday` date DEFAULT NULL,
  `sex` varchar(255) DEFAULT NULL,
  `password_id` int(11) DEFAULT NULL,
  `photo_url` varchar(255) NOT NULL,
  `role` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `surname`, `email`, `number`, `birthday`, `sex`, `password_id`, `photo_url`, `role`) VALUES
(12526797, 'yassine', 'makhlouf', 'makhlouf@gmail.com', 25147258, '2021-03-02', 'Male', 85953848, 'null', 1),
(19686343, 'bob', 'makh', 'bob@gmail.com', 41258258, '2016-11-09', 'Femme', 54454723, 'null', 1),
(36680067, 'Ali', 'Dagdoug', 'dagdoug.ali@esprit.tn', 67665555, '2018-04-20', 'Male', 37234415, 'null', 2),
(47056258, 'ahmed', 'de', 'debbech.ahmed@gmail.com', 49493, '2021-03-05', 'Male', 50081127, 'null', 2),
(47910120, 'ons', 'kechrid', 'ons.kechrid@esprit.tn', 4444, '2021-03-12', 'Femme', 17253083, 'null', 3),
(97127924, 'yassine', 'makhlouf', 'yassineusm1@gmail.com', 93493156, '1997-09-02', 'Male', 38344242, 'null', 1);

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `article_id` int(8) NOT NULL,
  `admin_id` int(8) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` varchar(2048) NOT NULL,
  `author` varchar(255) NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `photo_url` varchar(255) NOT NULL,
  `category` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`article_id`, `admin_id`, `title`, `text`, `author`, `date`, `photo_url`, `category`) VALUES
(1121301, 97127924, 'LA CONFIRMATION\r\n', 'Lors de la seconde sortie face à l’Algérie, une première période équilibrée avec des tirs d’El Mabrouk et des mouvements collectifs par Makrem Ben Romdhane, Hammoudi et Abeda pour riposter aux assauts des Touhami et Dekkiche qui ont bien résisté (10-9) après 5’ de jeu et (21-20) à la fin du 1QT.\r\n\r\nAu second quart, les Mouhli, Chennoufi et Knioua prirent le dessus avec une excellente réussite à distance pour prendre l’ascendant (34-26) et clôturer la mi-temps avec dix points d’écart (42-32).\r\n\r\nDe retour des vestiaires, nos gladiateurs passent à la vitesse supérieure (55-38) avec des bons mouvements collectifs en attaque et un bon comportement défensif des Ghayeza et Hammoudi qui vont permettre à la sélection de se mettre à l’abri (64-45) à la fin du 3QT.\r\n\r\nAu dernier quart, une bonne gestion de l’avantage qui se stabilise à 19 points (72-53) à 5’ de la fin.\r\n\r\nLa suite un arbitrage maison qui a favorisé les algériens pour diminuer l’écart par Touhami et surtout Cheriat qui a été adroit à distance mais les carottes étaient déjà cuites avec une bonne marge bien défendue au finish (87-77).\r\n\r\nEvolution du score:\r\n\r\nCi-après l’évolution du score :\r\n\r\n1er Quart-temps : 21-20\r\n2ème Quart-temps : 42-32\r\n3ème Quart-temps : 64-45\r\n4ème Quart-temps :  87-77\r\nRépartition des points :\r\n\r\nAbada 8pts, El Mabrouk 12pts, M. Hadidane 12pts, Ben Romdhane 10pts, Mouhli 9pts, Knioua 10pts, Chennoufi 12pts, Ghayaza 9pts, Seyeh 2pts, Braa 1pt, Slimane 2pts', 'evf', '2021-03-06 23:00:00', 'http://127.0.0.1/uploads/photo.jpg', 2),
(21738344, 47056258, 'TIRAGE AU SORT DES 1/4 DE FINALE COUPE SEAT DE BASKET BALL', 'Le Tirage au sort des 1/4 de Finale Coupe SEAT de Basket Ball tenu le dimanche 19 mars 2017 à Radio Jeunes a donné les affiches suivantes :\r\n\r\nSeniors Filles\r\nESCB-ASF\r\nCSPC-ASFJ\r\nAFDF-ASFC\r\nCSS-ESS\r\nSeniors Garçons\r\nCA-USM\r\nJSK-ESS\r\nCSC-EZS\r\nESR-SN\r\n\r\nNB/Les rencontres (SG) auront lieu le mardi 4 avril 2017.', 'setgwergwerg', '2021-03-19 23:00:00', 'http://127.0.0.1/uploads/photo.jpg', 1),
(24864616, 47056258, 'Tredegar provides taster for FTBB Summer School', 'Welsh Champion Tredegar has been working with Artistic Director Stephen Crooks and the organising team of the Fermanagh/Tyrone Brass Band Summer School (FTBBSS).\r\n\r\nSupported by Fermanagh and Omagh District Council and Besson Brass they have joined the international team of tutors to present a light hearted concert on Wednesday 31st March (8.00pm).', 'ahmed', '2021-04-23 15:58:00', 'http://127.0.0.1/ftbb_web/ftbb_web/public/images/articles_upload/-6082e0b014db0.jpeg', 2),
(36508696, 97127924, 'Billet gratuit pour les premiers 500 inscrits', 'A l’occasion du lancement de son nouveau site officiel, la FTBB offre un billet gratuit pour les premiers 500 inscrits dans la rubrique LA FAMILLE DU BASKET et ce pour les matchs de la Tunisie à l’occasion du tournoi qualificatif à l’AfroBasket qui se déroulera à la Salle Multidisciplinaire de Rades du 24 au 26 Mars.\n\nNe ratez pas l’occasion pour assister à la fête du basket tunisien en famille et inscrivez-vous vite', 'ah', '2021-03-31 10:21:23', 'http://127.0.0.1/uploads/22781996.JPG', 0),
(45464472, 47056258, 'DLN WINTER ALL-AREA: Boys Basketball First Team, Second Team, Honorable Mention & Coach of the Year', 'First Team\r\nRahdir Hicks, Sr, Malvern Prep\r\nHicks averaged 14 points per game as the Friars’ senior point guard was arguably the best on-ball defender in the Inter-Academic League. Hicks is headed to play his collegiate basketball at Towson University next fall.\r\n\r\nJalen Warley, Sr, Westtown\r\nThe Moose senior averaged 17-2 points per game to go along with six assists and was the main offensive threat for a 20-win Moose squad. Warley will play his college basketball at Florida State University next fall.', 'alter', '2021-04-25 03:11:00', 'http://127.0.0.1/ftbb_web/ftbb_web/public/images/articles_upload/-6084cfbb405df.jpeg', 1),
(48126715, 47056258, 'LA FÊTE DU BASKET EN FAMILLE À LA SALLE MULTIDISCIPLINAIRE DE RADES DU 24 AU 26 MARS 2017', 'hello this is corrected', 'tester', '2021-03-09 23:00:00', 'http://127.0.0.1/ftbb_web/ftbb_web/public/images/articles_upload/-6082f3990a52e.jpeg', 0),
(61109032, 47056258, '@@@LISTE DES ÉQUIPES QUALIFIÉES POUR L’AFROBASKET 2017', 'dff', 'sdfsadf', '2021-04-23 00:21:00', 'http://127.0.0.1/ftbb_web/ftbb_web/public/images/articles_upload/-6082f345adcf8.jpeg', 3),
(67052814, 47056258, 'COMMUNIQUÉ : PRÉSENCE DU PUBLIC', 'Le Bureau Fédéral de la Fédération Tunisienne de Basket-Ball informe les clubs que seuls les supporters des équipes recevantes sont autorisés à assister aux rencontres officielles, selon quota du Ministère de l’Intérieur.\r\n\r\nPar ailleurs, il rappelle que le Président ou le Président de Section Basket-Ball du Club peut assister son équipe sur présentation obligatoire de la carte délivrée par La Fédération Tunisienne de Basket-Ball.', 'jed', '2021-04-17 03:34:00', 'https://res.cloudinary.com/grohealth/image/upload/f_auto,fl_lossy,q_auto/v1581678662/DCUK/Content/iStock-959080376.jpg', 2),
(73680515, 47056258, 'werfwerf', 'this article is modified', 'rrferf', '2021-03-20 13:52:31', 'http://127.0.0.1/uploads/photo.jpg', 1),
(89377902, 47056258, 'LISTE DES ÉQUIPES QUALIFIÉES POUR L’AFROBASKET 2017', 'Treize équipes nationales issues des quatre coins de l’Afrique dont la Tunisie ont déjà leurs billets pour la phase finale à Brazzaville (19-30 août).\r\n\r\nSont donc qualifiés : le Nigeria, la République du Congo, la République démocratique du Congo, la Côte d’Ivoire, le Maroc, le Mozambique, la Tunisie, l’Égypte, l’Ouganda, l’Angola, le Mali, le Cameroun et le Sénégal.\r\n\r\nDeux billets seront attribués via des invitations (« wild cards »).\r\n\r\nLa sélection qui finira deuxième à Lusaka affrontera en barrage le Zimbabwe – deuxième du Groupe H de la Zone 6 – pour déterminer quel sera le dernier pays à venir compléter le tableau à 16 équipes de Brazzaville.', 'ahmed', '2021-04-20 09:11:00', 'https://images.unsplash.com/photo-1519861531473-9200262188bf?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxleHBsb3JlLWZlZWR8Mnx8fGVufDB8fHx8&w=1000&q=80', 2);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(8) NOT NULL,
  `id_client` int(8) NOT NULL,
  `num_products` int(3) NOT NULL,
  `total_price` int(9) NOT NULL,
  `ref_product` int(8) NOT NULL,
  `addition_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `id_client`, `num_products`, `total_price`, `ref_product`, `addition_id`) VALUES
(2, 2, 1, 55, 61914019, 23376607),
(2, 2, 1, 555, 84247774, 27397601),
(2, 2, 1, 120, 79140997, 47423663);

-- --------------------------------------------------------

--
-- Table structure for table `classement`
--

CREATE TABLE `classement` (
  `id` int(11) NOT NULL,
  `id_phase` int(11) NOT NULL,
  `id_competition` int(11) NOT NULL,
  `id_team` int(11) NOT NULL,
  `nbr_pts_P` int(11) DEFAULT NULL,
  `nbr_pts_G` int(11) DEFAULT NULL,
  `nbr_pts_D` int(11) DEFAULT NULL,
  `pts_diff` int(11) DEFAULT NULL,
  `nbr_pts` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `id` int(8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `number` int(8) NOT NULL,
  `birthday` date DEFAULT NULL,
  `sex` varchar(255) NOT NULL,
  `creation_date` date NOT NULL DEFAULT current_timestamp(),
  `password_id` int(8) NOT NULL,
  `photo_url` varchar(255) NOT NULL,
  `id_cart` int(8) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id`, `name`, `surname`, `email`, `number`, `birthday`, `sex`, `creation_date`, `password_id`, `photo_url`, `id_cart`, `status`) VALUES
(122, 'ahmed', 'debbech', 'debbech.ahmed@gmail.com', 39043444, '2018-12-08', 'Male', '2021-03-31', 58582415, '122.JPG', 0, 0),
(2943763, 'amine', 'ayadi', 'mohamedamine.ayadi@esprit.tn', 34432, '2021-03-17', 'Male', '2021-03-31', 5642003, '2943763.JPG', 0, 0),
(10197866, 'yaiine', 'makhlouf', 'yassinemakhlouf29@gmail.com', 93456123, '1997-09-02', 'Male', '2021-03-31', 88644524, 'null', 0, 0),
(21536512, 'ons', 'ons', 'ons.kechrid@esprit.tn', 3994, '2021-03-12', 'Male', '2021-03-30', 75741123, 'null', 0, 0),
(22781996, 'Aymen22', 'Mabrouk', 'Aymen@gmail.com', 25147258, '2012-02-07', 'Male', '2021-03-21', 1789714, '22781996.JPG', 0, 0),
(27568958, 'ahmed', 'gbdfjngef', 'ahm@gmail.Com', 95852147, '2001-03-02', 'Male', '2021-03-25', 39995105, 'null', 0, 0),
(28057180, 'Slim', 'jaafoura', 'slim@gmail.com', 52147258, NULL, 'Femme', '2021-03-12', 4994666, 'null', 0, 2),
(30691634, 'yassinedsjipf', 'sqdqsd', 'amine@gmail.com', 21456456, NULL, 'Male', '2021-03-12', 61719280, 'null', 0, 2),
(45036844, 'yassineeeo', 'makhlouf', 'yassine@gmail.com', 96258147, NULL, 'Femme', '2021-03-12', 71027446, 'null', 0, 0),
(64281973, 'Ahmed', 'Debbech', 'ahmed.debbech@esprit.tn', 54332133, '2016-04-08', 'Male', '2021-04-02', 17101161, '64281973.JPG', 0, 2),
(96838782, 'ali', 'dagdoug', 'ali@gmail.com', 21258256, NULL, 'Femme', '2021-03-12', 46241344, 'null', 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `command`
--

CREATE TABLE `command` (
  `command_id` int(8) NOT NULL,
  `id_client` int(8) NOT NULL,
  `date_command` timestamp NULL DEFAULT NULL,
  `status` int(1) NOT NULL,
  `total_price` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `command`
--

INSERT INTO `command` (`command_id`, `id_client`, `date_command`, `status`, `total_price`) VALUES
(26965177, 2, '2021-04-26 16:31:00', 1, 5500),
(41849403, 2, '2021-04-26 21:05:00', 1, 216),
(42607543, 2, '2021-04-26 03:07:00', 1, 3585),
(47007156, 2, '2021-04-26 09:26:00', 0, 2155),
(47625366, 2, '2021-04-26 00:57:00', 0, 2775),
(53881136, 2, '2021-04-24 10:00:00', 0, 558),
(74151746, 2, '2021-04-26 16:35:00', 1, 320),
(95787400, 2, '2021-04-26 16:32:00', 0, 16160);

-- --------------------------------------------------------

--
-- Table structure for table `command_product`
--

CREATE TABLE `command_product` (
  `id_cp` int(8) NOT NULL,
  `ref_product` int(8) NOT NULL,
  `id_client` int(8) NOT NULL,
  `command_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `command_product`
--

INSERT INTO `command_product` (`id_cp`, `ref_product`, `id_client`, `command_id`) VALUES
(14978665, 92487890, 2, 52489017),
(15033825, 79140997, 2, 47007156),
(15640574, 62583237, 2, 74151746),
(20616459, 92487890, 2, 31547308),
(27005149, 79140997, 2, 36213860),
(27608695, 79140997, 2, 65232929),
(30132637, 92487890, 2, 89089239),
(34772337, 84247774, 2, 42607543),
(37543759, 84247774, 2, 47625366),
(48462780, 92487890, 2, 42607543),
(49960182, 84247774, 2, 31547308),
(57702407, 62583237, 2, 95787400),
(58561177, 84247774, 2, 36213860),
(60675430, 79140997, 2, 63877707),
(67500083, 79140997, 2, 31547308),
(67921105, 80804359, 2, 41849403),
(69271345, 84247774, 2, 52489017),
(70455575, 92487890, 2, 65232929),
(74665391, 92487890, 2, 81979374),
(80965645, 84247774, 2, 89089239),
(83254663, 61914019, 2, 26965177),
(84294893, 79140997, 2, 69548438),
(85512596, 84247774, 2, 47007156),
(85545484, 84247774, 2, 69548438),
(86176992, 79140997, 2, 42607543);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(8) NOT NULL,
  `content` varchar(255) NOT NULL,
  `client_id` int(8) NOT NULL,
  `article_id` int(8) NOT NULL,
  `date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `content`, `client_id`, `article_id`, `date`) VALUES
(16912074, 'very nice article', 122, 24864616, '2021-04-26 21:03:00'),
(37093893, 'ahmed', 122, 67052814, '2021-04-20 09:32:00'),
(70338739, 'fffff', 122, 1121301, '2021-04-26 22:40:00'),
(88345857, 'article', 122, 21738344, '2021-04-25 13:34:00'),
(90332154, 'this is another comment', 122, 1121301, '2021-02-17 23:00:00'),
(99682131, 'helloooo', 122, 21738344, '2021-04-25 14:48:00');

-- --------------------------------------------------------

--
-- Table structure for table `competition`
--

CREATE TABLE `competition` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `calendar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `competition`
--

INSERT INTO `competition` (`id`, `name`, `calendar`) VALUES
(20, 'Pro B', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favourite`
--

CREATE TABLE `favourite` (
  `id_fav` int(8) NOT NULL,
  `ref_product` int(8) NOT NULL,
  `id_client` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `favourite`
--

INSERT INTO `favourite` (`id_fav`, `ref_product`, `id_client`) VALUES
(10602284, 62583237, 2),
(78909376, 84247774, 2),
(99570716, 61914019, 2);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(8) NOT NULL,
  `client_id` int(8) NOT NULL,
  `feedback_date` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `topic` varchar(255) NOT NULL,
  `text` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `client_id`, `feedback_date`, `email`, `topic`, `text`, `type`) VALUES
(56874, 358742, '2021-03-26', 'opffoinfnoi', 'aembgru', 'nvakpo', 'terytiyo'),
(8080808, 707077, '2021-03-05', 'zregzregz', 'ffdfdfdfdfdd', 'vvvvvvvcvvvvvvvvvvvv', 'ttttttttttttttt'),
(12903583, 65, '2021-03-31', 'mohamedamine.ayadi@esprit.tn', 'dell', 'heroseoaerjaoi', 'lklklklk'),
(27188362, 65, '2021-03-12', 'aer@', 'ddd', 'fff', 'ccccc'),
(28656178, 65, '2021-03-08', 'cxcxccxc', 'poooopo', 'Drayc', 'pppp'),
(59119595, 65, '2021-04-02', 'debbech.ahmed@gmail.com', 'This is a topic', 'i have a problem again xd', 'reclamation'),
(97307693, 2943761, '2021-04-26', 'yassine.ayadi2@esprit.tn', 'a problem guys', 'a lot to say....sertfgvbrthbebyhehrfgbvsdfvb sdtgbhdsfthndfsbwsrgb', 'hola');

-- --------------------------------------------------------

--
-- Table structure for table `galerie`
--

CREATE TABLE `galerie` (
  `galerie_id` int(8) NOT NULL,
  `admin_id` int(8) NOT NULL,
  `photo_url` varchar(255) NOT NULL,
  `photo_title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `galerie`
--

INSERT INTO `galerie` (`galerie_id`, `admin_id`, `photo_url`, `photo_title`, `description`) VALUES
(18580254, 444, 'http://127.0.0.1/uploads/orange.jpg', 'new photo 2021', 'new new new new'),
(30943367, 444, 'C:Users\narugDesktopNew folderwallpapersdiaCXT5hnR.jpg', 'fdsffdsf', 'ffezzefz'),
(54179942, 444, 'http://127.0.0.1/uploads/1438989.jpg', 'BLACK PHOTO 2021', 'a very nice black photo'),
(57930941, 444, 'http://127.0.0.1/uploads/27658.jpg', 'knight', 'knight on horse'),
(58360735, 444, 'bbbb', 'aryyy', ''),
(71192187, 444, 'D:xampphtdocsuploadslack_cat_muzzle_eyes_106808_1920x1080.jpg', 'cat', 'black cat black cat'),
(85801155, 444, 'hhhhhhhh', 'yyyyyy', 'ytrurtyu'),
(85891891, 444, 'bruvkek', 'omegalul', 'iminaeifona'),
(97601054, 444, 'nnnnnnn', 'tyuio', '');

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE `game` (
  `id` int(11) NOT NULL,
  `id_competition` int(11) NOT NULL,
  `id_phase` int(11) NOT NULL,
  `id_week` int(11) NOT NULL,
  `id_team_home` int(11) NOT NULL,
  `id_team_away` int(11) NOT NULL,
  `score_home` int(11) NOT NULL,
  `score_away` int(11) NOT NULL,
  `id_statistique` int(11) DEFAULT NULL,
  `status` int(1) NOT NULL,
  `salle` varchar(255) NOT NULL,
  `time` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id_like` int(8) NOT NULL,
  `id_article` int(8) DEFAULT NULL,
  `id_comment` int(8) DEFAULT NULL,
  `id_client` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id_like`, `id_article`, `id_comment`, `id_client`) VALUES
(70661895, NULL, 90332154, 2943763),
(82454482, 24864616, NULL, 122);

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `option_id` int(8) NOT NULL,
  `description` varchar(255) NOT NULL,
  `poll_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`option_id`, `description`, `poll_id`) VALUES
(18198295, 'teamB', 70985639),
(18627125, 'mestir', 14902667),
(22650603, 'Team B', 93177417),
(24537423, 'team1', 70985639),
(34235588, 'team1', 5989219),
(41751322, 'teamB', 5989219),
(58028890, 'Team A', 93177417),
(78777936, 'FCB', 97778301),
(98673560, 'rades', 14902667),
(98940888, 'REAL', 97778301);

-- --------------------------------------------------------

--
-- Table structure for table `password`
--

CREATE TABLE `password` (
  `password_id` int(8) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `last_change` date NOT NULL DEFAULT current_timestamp(),
  `previous_pwd` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `password`
--

INSERT INTO `password` (`password_id`, `pwd`, `last_change`, `previous_pwd`) VALUES
(1789714, 'HEmxd95KyYnhXVCgoTkf8Q==', '2021-03-21', NULL),
(4994666, 'HEmxd95KyYnhXVCgoTkf8Q==', '2021-03-12', NULL),
(5642003, 'HEmxd95KyYnhXVCgoTkf8Q==', '2021-03-31', NULL),
(17101161, 'HEmxd95KyYnhXVCgoTkf8Q==', '2021-04-02', NULL),
(17253083, 'HEmxd95KyYnhXVCgoTkf8Q==', '2021-03-31', NULL),
(37234415, 'HEmxd95KyYnhXVCgoTkf8Q==', '2021-04-02', NULL),
(38344242, 'HEmxd95KyYnhXVCgoTkf8Q==', '2021-03-28', NULL),
(39995105, 'HEmxd95KyYnhXVCgoTkf8Q==', '2021-03-25', NULL),
(46241344, 'HEmxd95KyYnhXVCgoTkf8Q==', '2021-03-12', NULL),
(50081127, 'd1AqY+p+liX/AmD6h36eSg==', '2021-03-30', NULL),
(54454723, 'HEmxd95KyYnhXVCgoTkf8Q==', '2021-03-12', NULL),
(58582415, 'HEmxd95KyYnhXVCgoTkf8Q==', '2021-03-31', NULL),
(61719280, 'HEmxd95KyYnhXVCgoTkf8Q==', '2021-03-12', NULL),
(71027446, 'HEmxd95KyYnhXVCgoTkf8Q==', '2021-03-12', NULL),
(75741123, 'lI8El6B4Tl+yrKz9xWPRhg==', '2021-03-30', NULL),
(85953848, 'HEmxd95KyYnhXVCgoTkf8Q==', '2021-03-12', NULL),
(88644524, 'h/mnIYar3QJML6sj+YvIBmn9BMd3F7TxUmvMlmjBi5k=', '2021-03-31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `phase`
--

CREATE TABLE `phase` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `phase`
--

INSERT INTO `phase` (`id`, `name`) VALUES
(1, 'PlayOff'),
(2, 'PlayOut');

-- --------------------------------------------------------

--
-- Table structure for table `player`
--

CREATE TABLE `player` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `id_team` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `poll`
--

CREATE TABLE `poll` (
  `poll_id` int(8) NOT NULL,
  `description` varchar(255) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(255) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `poll`
--

INSERT INTO `poll` (`poll_id`, `description`, `creation_date`, `status`) VALUES
(5989219, 'qui va ganger', '2021-04-01 13:08:44', 'Active'),
(14902667, 'who doyou think will wi n?	', '2021-03-31 22:04:28', 'Ended'),
(70985639, 'qui va ganger', '2021-04-01 13:08:39', 'Active'),
(93177417, 'Who is the winner in this match ?', '2021-04-02 15:35:01', 'Active'),
(97778301, 'poll new 2021', '2021-04-02 00:13:42', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ref_product` int(8) NOT NULL,
  `category` varchar(255) NOT NULL,
  `stock` int(6) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(9) NOT NULL,
  `details` varchar(255) NOT NULL,
  `id_admin` int(8) NOT NULL,
  `add_date` date NOT NULL,
  `photo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ref_product`, `category`, `stock`, `name`, `price`, `details`, `id_admin`, `add_date`, `photo`) VALUES
(61914019, 'Vêtements', 451, 'panier', 55, '3 mètres', 45484749, '2021-04-26', '3486f6c59ecd0df3f74d735c3547e24a.jpeg'),
(62583237, 'Vêtements', 563, 'sneakers homme', 160, 'kappa', 84858695, '2021-04-26', 'c01595de4aa97d63637794545a2cb456.jpeg'),
(63150871, 'Vêtements', 120, 'tenue', 150, 'coton', 96949897, '2021-04-26', 'e4abad307e0d5c1d34e3fd82d7ce324b.jpeg'),
(68503615, 'Equipements', 90, 'ball', 100, 'cuir', 61626365, '2021-04-26', 'fd4eed577920273edb7a021befbb1234.jpeg'),
(79140997, 'Equipements', 100, 'ball', 120, 'cuir', 42148594, '2021-04-13', 'd9e2ee6c757c06d5a1ed3e7a2be86186.jpeg'),
(84247774, 'Vêtements', 945, 'tenue!', 555, 'coton', 55964952, '2021-04-18', 'a33ab41d8466e76150d7c19d9ad7e5c2.jpeg'),
(86296788, 'Equipements', 170, 'panier', 50, '3 mètres', 85848785, '2021-04-26', '05a3d22efadd0ba7ef96f2676910c1c3.jpeg'),
(90693469, 'Equipements', 70, 'ball', 125, 'poids 500g', 15151515, '2021-04-26', 'ceeb766e80812ebda688303717daa77e.jpeg'),
(92487890, 'Equipements', 80, 'sneakers homme', 10, 'taille max 50', 3, '2021-04-13', 'cf087154b5b0125dd41ca6df2f3c42bf.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `report_id` int(8) NOT NULL,
  `client_id` int(8) NOT NULL,
  `command_id` int(8) NOT NULL,
  `report_date` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`report_id`, `client_id`, `command_id`, `report_date`, `email`, `description`) VALUES
(3333, 999999, 555555, '2021-03-06', '', 'mlmlmlmlmlmlmlmlm'),
(46840, 999, 7878, '2021-03-12', 'azer@', 'vvcvc'),
(123456, 98764, 63575, '2021-03-30', '', 'aretzgfdfhgdjkuyirtueryz'),
(665333, 999, 7474, '2021-03-12', 'aera@', 'zaerarr'),
(747714, 44444, 8585, '2021-03-02', '', 'zaeraerazerazerazreazeraeraeraerazer'),
(888888, 525252, 969696, '2021-03-31', '', 'tuiytyuityui'),
(1010101, 20202, 30303, '2021-03-27', '', 'pmolikuyhtgferfzdzedz'),
(7863745, 999, 0, '2021-03-12', 'aer', 'azerar'),
(11863218, 122, 488493, '2021-04-26', 'debbech.ahmed@gmail.com', 'uuuuuuuuuuuuuuuuuuuuuuu!!!!!!!!!!!!!!uuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuu'),
(28732114, 999, 33070, '2021-03-29', 'mohamedamine.ayadi@esprit.tn', 'nb3 yassuo'),
(43097787, 999, 0, '2021-03-12', 'eazr@', 'aezrrr'),
(48391613, 22781996, 58499332, '2021-04-02', 'debbech.ahmed@gmail.com', 'i have a problem in ftbb !!!!!!!!!!'),
(51462659, 999, 444, '2021-03-12', 'iii@', ',,hjjj'),
(54079160, 2943763, 34522122, '2021-04-26', 'debbech.ahmed@gmail.com', 'efgvewrfgsarfduehdcvaulsdinfcujahbsedcba;ledbhcajihwbecfbaedcaucawecf'),
(55182251, 999, 74174, '2021-03-08', 'ameriane@gaezm', 'mloiuyfc'),
(59962640, 999, 444, '2021-03-12', 'eazr@', 'aezrrr'),
(61775800, 999, 4141, '2021-03-12', 'azer@', 'zeraaa'),
(65878770, 999, 96325, '2021-03-08', 'deamon@gmail.com', 'hi im gosu 2'),
(69359211, 2943763, 484884, '2021-04-26', 'debbech.ahmed@gmail.com', 'ozozooozozozozozozozoozozozozozozozozozozozoozozozozoz'),
(78718922, 2943763, 89223309, '2021-04-26', 'debbech.ahmed@gmail.com', 'i have a biiig biiig problem !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!???????????????????'),
(81474405, 999, 1, '2021-03-12', 'y@', 'iyo');

-- --------------------------------------------------------

--
-- Table structure for table `statistique`
--

CREATE TABLE `statistique` (
  `id` int(11) NOT NULL,
  `doc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `id_competition` int(11) NOT NULL,
  `logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vote`
--

CREATE TABLE `vote` (
  `vote_id` int(8) NOT NULL,
  `option_id` int(8) NOT NULL,
  `client_id` int(8) DEFAULT NULL,
  `vote_nbr` int(8) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vote`
--

INSERT INTO `vote` (`vote_id`, `option_id`, `client_id`, `vote_nbr`) VALUES
(8309299, 24537423, NULL, 1),
(11168571, 41751322, NULL, 1),
(11685270, 18627125, NULL, 1),
(22001076, 18198295, NULL, 2),
(44766575, 22650603, NULL, 1),
(49595215, 58028890, NULL, 1),
(59924603, 98940888, NULL, 1),
(70107167, 98673560, NULL, 1),
(77498536, 34235588, NULL, 2),
(93130460, 78777936, NULL, 6);

-- --------------------------------------------------------

--
-- Table structure for table `week`
--

CREATE TABLE `week` (
  `id` int(11) NOT NULL,
  `Name_week` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `week`
--

INSERT INTO `week` (`id`, `Name_week`) VALUES
(1, 'Week 1'),
(2, 'Week 2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `password_id` (`password_id`);

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`article_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`addition_id`),
  ADD KEY `id_client` (`id_client`);

--
-- Indexes for table `classement`
--
ALTER TABLE `classement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `c2` (`id_competition`),
  ADD KEY `ph1` (`id_phase`),
  ADD KEY `t2` (`id_team`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `password_id` (`password_id`);

--
-- Indexes for table `command`
--
ALTER TABLE `command`
  ADD PRIMARY KEY (`command_id`),
  ADD KEY `command_ibfk_1` (`id_client`);

--
-- Indexes for table `command_product`
--
ALTER TABLE `command_product`
  ADD PRIMARY KEY (`id_cp`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `article_id` (`article_id`);

--
-- Indexes for table `competition`
--
ALTER TABLE `competition`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `favourite`
--
ALTER TABLE `favourite`
  ADD PRIMARY KEY (`id_fav`),
  ADD KEY `ref_product` (`ref_product`),
  ADD KEY `id_client` (`id_client`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `galerie`
--
ALTER TABLE `galerie`
  ADD PRIMARY KEY (`galerie_id`);

--
-- Indexes for table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`id`),
  ADD KEY `t3` (`id_team_away`),
  ADD KEY `t4` (`id_team_home`),
  ADD KEY `c3` (`id_competition`),
  ADD KEY `ph2` (`id_phase`),
  ADD KEY `statistique` (`id_statistique`),
  ADD KEY `w1` (`id_week`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id_like`),
  ADD KEY `id_article` (`id_article`),
  ADD KEY `id_client` (`id_client`),
  ADD KEY `id_comment` (`id_comment`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`option_id`),
  ADD KEY `poll_id` (`poll_id`);

--
-- Indexes for table `password`
--
ALTER TABLE `password`
  ADD PRIMARY KEY (`password_id`);

--
-- Indexes for table `phase`
--
ALTER TABLE `phase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `player`
--
ALTER TABLE `player`
  ADD PRIMARY KEY (`id`),
  ADD KEY `t1` (`id_team`);

--
-- Indexes for table `poll`
--
ALTER TABLE `poll`
  ADD PRIMARY KEY (`poll_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ref_product`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `command_id` (`command_id`);

--
-- Indexes for table `statistique`
--
ALTER TABLE `statistique`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`),
  ADD KEY `c1` (`id_competition`);

--
-- Indexes for table `vote`
--
ALTER TABLE `vote`
  ADD PRIMARY KEY (`vote_id`),
  ADD KEY `option_id` (`option_id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `week`
--
ALTER TABLE `week`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97127925;

--
-- AUTO_INCREMENT for table `classement`
--
ALTER TABLE `classement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `competition`
--
ALTER TABLE `competition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `game`
--
ALTER TABLE `game`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `phase`
--
ALTER TABLE `phase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `player`
--
ALTER TABLE `player`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `statistique`
--
ALTER TABLE `statistique`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `week`
--
ALTER TABLE `week`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `FK_880E0D763E4A79C1` FOREIGN KEY (`password_id`) REFERENCES `password` (`password_id`);

--
-- Constraints for table `classement`
--
ALTER TABLE `classement`
  ADD CONSTRAINT `c2` FOREIGN KEY (`id_competition`) REFERENCES `competition` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ph1` FOREIGN KEY (`id_phase`) REFERENCES `phase` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t2` FOREIGN KEY (`id_team`) REFERENCES `team` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `client_ibfk_1` FOREIGN KEY (`password_id`) REFERENCES `password` (`password_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `article` (`article_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `favourite`
--
ALTER TABLE `favourite`
  ADD CONSTRAINT `favourite_ibfk_1` FOREIGN KEY (`ref_product`) REFERENCES `product` (`ref_product`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `game`
--
ALTER TABLE `game`
  ADD CONSTRAINT `c3` FOREIGN KEY (`id_competition`) REFERENCES `competition` (`id`),
  ADD CONSTRAINT `ph2` FOREIGN KEY (`id_phase`) REFERENCES `phase` (`id`),
  ADD CONSTRAINT `statistique` FOREIGN KEY (`id_statistique`) REFERENCES `statistique` (`id`),
  ADD CONSTRAINT `t3` FOREIGN KEY (`id_team_away`) REFERENCES `team` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t4` FOREIGN KEY (`id_team_home`) REFERENCES `team` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `w1` FOREIGN KEY (`id_week`) REFERENCES `week` (`id`);

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`id_comment`) REFERENCES `comment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`id_article`) REFERENCES `article` (`article_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likes_ibfk_3` FOREIGN KEY (`id_client`) REFERENCES `client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `options`
--
ALTER TABLE `options`
  ADD CONSTRAINT `options_ibfk_1` FOREIGN KEY (`poll_id`) REFERENCES `poll` (`poll_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `player`
--
ALTER TABLE `player`
  ADD CONSTRAINT `t1` FOREIGN KEY (`id_team`) REFERENCES `team` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `team`
--
ALTER TABLE `team`
  ADD CONSTRAINT `c1` FOREIGN KEY (`id_competition`) REFERENCES `competition` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vote`
--
ALTER TABLE `vote`
  ADD CONSTRAINT `vote_ibfk_1` FOREIGN KEY (`option_id`) REFERENCES `options` (`option_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
