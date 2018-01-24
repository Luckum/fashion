-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Мар 16 2016 г., 10:30
-- Версия сервера: 5.5.46-0ubuntu0.14.04.2
-- Версия PHP: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `fashion`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'User ID',
  `username` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'User Name',
  `password` char(40) COLLATE utf8_bin NOT NULL COMMENT 'User Password',
  `email` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'User Email',
  `last_login` datetime NOT NULL COMMENT 'Last Login',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `email`, `last_login`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin@admin.com', '2016-03-14 08:17:21');

-- --------------------------------------------------------

--
-- Структура таблицы `alerts`
--

CREATE TABLE IF NOT EXISTS `alerts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_id` int(11) NOT NULL,
  `size_type` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user_id`),
  KEY `category` (`category_id`),
  KEY `subcategory` (`subcategory_id`),
  KEY `size_type` (`size_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `attribute`
--

CREATE TABLE IF NOT EXISTS `attribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `type` enum('textarea','text','dropdown','checkbox') COLLATE utf8_bin NOT NULL DEFAULT 'text',
  `alias` varchar(255) COLLATE utf8_bin NOT NULL,
  `required` enum('yes','no') COLLATE utf8_bin NOT NULL DEFAULT 'no',
  `status` enum('active','inactive') COLLATE utf8_bin NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `attribute`
--

INSERT INTO `attribute` (`id`, `category_id`, `type`, `alias`, `required`, `status`) VALUES
(1, 11, 'checkbox', 'socks_size', 'yes', 'active'),
(3, 1, 'dropdown', 'size_unisex', 'yes', 'active'),
(4, 35, 'dropdown', 'size', 'no', 'active');

-- --------------------------------------------------------

--
-- Структура таблицы `attribute_name`
--

CREATE TABLE IF NOT EXISTS `attribute_name` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute_id` int(11) NOT NULL,
  `language` char(2) COLLATE utf8_bin NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `values` text COLLATE utf8_bin,
  PRIMARY KEY (`id`),
  KEY `attribute_id` (`attribute_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `attribute_name`
--

INSERT INTO `attribute_name` (`id`, `attribute_id`, `language`, `name`, `values`) VALUES
(1, 1, 'en', 'socks', NULL),
(2, 1, 'de', 'tops', NULL),
(4, 3, 'en', 'unisex clothing', NULL),
(5, 4, 'en', 'Size', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `bid`
--

CREATE TABLE IF NOT EXISTS `bid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `price` decimal(9,2) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `brand`
--

CREATE TABLE IF NOT EXISTS `brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Brand ID',
  `name` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'Brand Name',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=459 ;

--
-- Дамп данных таблицы `brand`
--

INSERT INTO `brand` (`id`, `name`) VALUES
(1, '5preview'),
(2, '202 factory'),
(4, 'A.p.c.'),
(5, 'A.w.a.k.e.'),
(6, 'Acne'),
(7, 'Acne kids'),
(8, 'Acne studios'),
(9, 'Adaism'),
(10, 'Adidas'),
(11, 'Adidas by raf simons'),
(12, 'Adieu'),
(13, 'Af vandevorst'),
(14, 'Aganovich'),
(15, 'Agent provocateur'),
(16, 'Agnona'),
(17, 'Aiezen'),
(18, 'Aigle'),
(19, 'Alaïa'),
(20, 'Alain mikli'),
(21, 'Alexa stark'),
(22, 'Album di famiglia'),
(23, 'Alexa chung for ag'),
(24, 'Alexander mcqueen'),
(25, 'Alexander wang'),
(26, 'Alexander wang pour h&m'),
(27, 'Alexandre herchcovitch'),
(28, 'Alice hubert'),
(29, 'Alix'),
(30, 'Altuzarra'),
(31, 'Amélie pichard'),
(32, 'Ami'),
(33, 'Ancient greek sandals'),
(34, 'Andres sarda'),
(35, 'Ann demeulemeester'),
(36, 'Anne sofie madsen'),
(37, 'Anntian'),
(38, 'Antipodium'),
(39, 'Aravore'),
(40, 'Area'),
(41, 'Arielle de pinto'),
(42, 'Ashish'),
(43, 'Astrid andersen'),
(44, 'Astrology irl'),
(45, 'Athena procopiou'),
(46, 'Attachment '),
(47, 'Aurelie bidermann'),
(48, 'Baby alpaga'),
(49, 'Baby dior'),
(50, 'Babybjorn'),
(51, 'Bagllerina'),
(52, 'Balenciaga'),
(53, 'Balmain'),
(54, 'Balmain x h&m '),
(55, 'Bamin'),
(56, 'Band of outsiders'),
(57, 'Bape'),
(58, 'Barny nakhle'),
(59, 'Bao bao'),
(60, 'Benedikt von lepel - by bvl'),
(61, 'Bernhard willhelm'),
(62, 'Beth richards'),
(63, 'Billieblush'),
(64, 'Bionda castana'),
(65, 'Birkenstock'),
(66, 'Bjorg'),
(67, 'Blackmeans'),
(68, 'Black boy place'),
(69, 'Bless'),
(70, 'Blk dnm'),
(71, 'Blyszak'),
(72, 'Bobo chose'),
(73, 'Bonpoint'),
(74, 'Bonton'),
(75, 'Bordelle'),
(76, 'Boris bidjan saberi'),
(77, 'Brian lichtenberg'),
(78, 'Bronzette'),
(79, 'Bugaboo'),
(80, 'Building block'),
(81, 'Bulgari'),
(82, 'Burberry'),
(83, 'Calvin klein collection'),
(84, 'Calvin klein x opening ceremony'),
(85, 'Camilla skovgaard'),
(86, 'Canada goose'),
(87, 'Caramel baby & child'),
(88, 'Carel'),
(89, 'Carhatt'),
(90, 'Cartier'),
(91, 'Carven'),
(92, 'Cauliflower'),
(93, 'Cédric charlier'),
(94, 'Celine'),
(95, 'Chanel'),
(96, 'Charlotte olympia'),
(97, 'Cherevichkiotvichki'),
(98, 'Chiyome'),
(99, 'Chloe sevigny for opening ceremony'),
(100, 'Chrishabana'),
(101, 'Christian dior'),
(102, 'Christian louboutin'),
(103, 'Christian wijnants'),
(104, 'Christophe lemaire'),
(105, 'Christopher kane'),
(106, 'Clotaire'),
(107, 'Comme des garcons'),
(108, 'Comme des garcons girl'),
(109, 'Comme des garcons play'),
(110, 'Comme des garcons for h&m'),
(111, 'Comme des garçons wallet'),
(112, 'Common projects'),
(113, 'Converse'),
(114, 'Coperni femme'),
(115, 'Cordelia de castellane'),
(116, 'Cos'),
(117, 'Costume national'),
(118, 'Côte&ciel'),
(119, 'Courreges'),
(120, 'Craig green'),
(121, 'Craig lawrence'),
(122, 'Crescent down works'),
(123, 'Cruz'),
(124, 'Chromat'),
(125, 'Damir doma'),
(126, 'David koma'),
(127, 'Ddugoff'),
(128, 'Deerdana'),
(129, 'Delfina delettrez'),
(130, 'Delphine delafon'),
(131, 'Denim x alexander wang'),
(132, 'Denis gagnon'),
(133, 'Devon halfnight leflufy'),
(134, 'Diadora heritage'),
(135, 'Dick moby'),
(136, 'Diemme'),
(137, 'Dino et lucia'),
(138, 'Dion lee'),
(139, 'Dior'),
(140, 'Dior homme'),
(141, 'Dioralop'),
(142, 'Dorateymur'),
(143, 'Dr. martens'),
(144, 'E.tautz'),
(145, 'Each x other'),
(146, 'Eli reed'),
(147, 'Emiliano rinaldi'),
(148, 'Enza costa'),
(149, 'Equipment'),
(150, 'Erickson beamon'),
(151, 'Ermenegildo zegna'),
(152, 'Etre cecile'),
(153, 'Eyevan'),
(154, 'Eytys'),
(155, 'Fanmail'),
(156, 'Faustine steinmetz'),
(157, 'Feit'),
(158, 'Fendi'),
(159, 'Fleamadonna'),
(160, 'Fleet ilya'),
(161, 'Frame denim'),
(162, 'Galvan'),
(163, 'Gareth pugh'),
(164, 'Garrett leight'),
(165, 'Giamba'),
(166, 'Girls from omsk'),
(167, 'Givenchy'),
(168, 'Golden goose'),
(169, 'Guidi'),
(170, 'Gurkee'),
(171, 'Haal'),
(172, 'Haider ackermann'),
(173, 'Harris wharf london'),
(174, 'Helen lawrence'),
(175, 'Helmut lang'),
(176, 'Henrik vibskov'),
(177, 'Hereu'),
(178, 'Hermès'),
(179, 'Hood by air'),
(180, 'House of holland'),
(181, 'Hunter'),
(182, 'Husam el odeh'),
(183, 'Hussein chalayan'),
(184, 'Hyein seo'),
(185, 'Illesteva'),
(186, 'Iq+ berlin'),
(187, 'Iris van herpen'),
(188, 'Isa arfen'),
(189, 'Isaac reina'),
(190, 'Isaac reina & kostas murkudis'),
(191, 'Isabel marant'),
(192, 'Isabel marant etoile'),
(193, 'Isabel marant pour h&m'),
(194, 'Issey miyake'),
(195, 'Issey miyake men plissé'),
(196, 'J brand'),
(197, 'J.w. anderson'),
(198, 'Jacquemus'),
(199, 'James long'),
(200, 'Jan-jan van essche'),
(201, 'Jeffrey campbell'),
(202, 'Jem jewellery ethically minded'),
(203, 'Jil sander'),
(204, 'Jimmy choo'),
(205, 'Jimmy choo for h&m'),
(206, 'Joomi lim'),
(207, 'Jourden'),
(208, 'Julius'),
(209, 'Junya watanabe'),
(210, 'Juunj'),
(211, 'Kamalikulture'),
(212, 'Kara'),
(213, 'Karen walker'),
(214, 'Karmuel young'),
(215, 'Kate spade'),
(216, 'Katrien van hecke'),
(217, 'Katie gallagher'),
(218, 'Kenzo'),
(219, 'Kiko mizuhara for opening ceremony'),
(220, 'Kim haller'),
(221, 'Kolor'),
(222, 'Kowtow'),
(223, 'Ktz'),
(224, 'Kuboraum'),
(225, 'L''eclaireur'),
(226, 'Lahssan'),
(227, 'Lala berlin'),
(228, 'Lanvin'),
(229, 'Lanvin for h&m'),
(230, 'Larke'),
(231, 'Larose'),
(232, 'Laura laurens'),
(233, 'Lauren klassen'),
(234, 'Lea peckre'),
(235, 'Levi''s'),
(236, 'Lisa marie fernandez'),
(237, 'Litkovskaya'),
(238, 'L.g.r'),
(239, 'Longchamp'),
(240, 'Longines'),
(241, 'Louis vuitton'),
(242, 'Lunge'),
(243, 'M2malletier'),
(244, 'Mackage'),
(245, 'Mademe'),
(246, 'Maison martin margiela'),
(247, 'Maison margiela artisanal'),
(248, 'Maison martin margiela pour h&m'),
(249, 'Maison michel'),
(250, 'Makoto komatsu'),
(251, 'Mandarina duck'),
(252, 'Manolo blahnik'),
(253, 'Mansur gavriel'),
(254, 'Marcelo burlon'),
(255, 'Marsèll'),
(256, 'Marius petrus'),
(257, 'Marni'),
(258, 'Marni for h&m'),
(259, 'Marques almeida'),
(260, 'Marques''almeida kids'),
(261, 'Mary katrantzou'),
(262, 'Mary katrantzou for adidas'),
(263, 'Mary katrantzou for topshop'),
(264, 'Marvielab'),
(265, 'Meadham kirchhoff'),
(266, 'Melanie georgacopoulos'),
(267, 'Missoni home'),
(268, 'Miu miu'),
(269, 'Mm6'),
(270, 'Mother of pearl'),
(271, 'Mou'),
(272, 'Mr & mrs furs'),
(273, 'Msgm'),
(274, 'Mulberry'),
(275, 'Murkuidis'),
(276, 'Mykita'),
(277, 'Nasir mazhar'),
(278, 'Nektar de stagni'),
(279, 'New balance'),
(280, 'Nicholas kirkwood'),
(281, 'Nicomede talavera'),
(282, 'Nicopanda'),
(283, 'Niels peeraer'),
(284, 'Nike'),
(285, 'Nina donis'),
(286, 'No 6 store'),
(287, 'No name'),
(288, 'Noir kei ninomiya'),
(289, 'Norma kamali'),
(290, 'Number 288'),
(291, 'Oak'),
(292, 'Oamc'),
(293, 'Obey'),
(294, 'Odeur'),
(295, 'Off white'),
(296, 'Öhlin/d'),
(297, 'Oliver peoples'),
(298, 'Olivia von halle'),
(299, 'Olympia le tan'),
(300, 'Opening ceremony'),
(301, 'Organic by john patrick'),
(302, 'Orley'),
(303, 'Osklen praia'),
(304, 'Our family'),
(305, 'Our legacy'),
(306, 'Paco rabanne'),
(307, 'Pallas'),
(308, 'Palm angels'),
(309, 'Pamela love'),
(310, 'Paula cademartori'),
(311, 'Pb 0110'),
(312, 'Pearls before swine'),
(313, 'Pierre hardy'),
(314, 'Piers atkinson'),
(315, 'Petar petrov'),
(316, 'Petrucha'),
(317, 'Pollini'),
(318, 'Porter'),
(319, 'Prada'),
(320, 'Preen'),
(321, 'Prism'),
(322, 'Proenza schouler'),
(323, 'Prospekt supply'),
(324, 'Puma'),
(325, 'Rachel comey'),
(326, 'Rad'),
(327, 'Rad hourani'),
(328, 'Raf simons'),
(329, 'Rag & bone'),
(330, 'Raquel allegra'),
(331, 'Rau berlin'),
(332, 'Ray-ban'),
(333, 'Reebok'),
(334, 'Reinhard plank'),
(335, 'Rejina pyo'),
(336, 'Repetto'),
(337, 'Repossi'),
(338, 'Richard nicoll'),
(339, 'Rick owens'),
(340, 'Rick owens drkshdw'),
(341, 'Rick owens lilies'),
(342, 'Rigards'),
(343, 'Riudavets for opening ceremony'),
(344, 'Robert clergerie'),
(345, 'Rodarte'),
(346, 'Rodarte for target'),
(347, 'Roksanda'),
(348, 'Roksanda ilincic'),
(349, 'Rolex'),
(350, 'Ron dorff'),
(351, 'Rosetta getty'),
(352, 'Ruff and huddle'),
(353, 'Rupert sanderson'),
(354, 'Ruuger'),
(355, 'Sacai luck'),
(356, 'Saint laurent'),
(357, 'Sankuanz'),
(358, 'Saucony'),
(359, 'Sen wye'),
(360, 'Schmidttakahashi'),
(361, 'Sibling'),
(362, 'Simon miller'),
(363, 'Simone rocha'),
(364, 'Siyu'),
(365, 'Slow and steady wins the race'),
(366, 'Solace london'),
(367, 'Sophia webster'),
(368, 'Sophie bille brahe'),
(369, 'Sophie hulme'),
(370, 'Spektre'),
(371, 'Stella mc cartney'),
(372, 'Stella mc cartney for h&m'),
(373, 'Stella mc cartney kids'),
(376, 'Stephan schneider'),
(377, 'Studio nicholson'),
(378, 'Study new york'),
(379, 'Studio one eighty nine'),
(380, 'Suno'),
(381, 'Sun buddies'),
(382, 'Sunspel'),
(383, 'Superga'),
(384, 'Supreme'),
(385, 'Surface to air'),
(386, 'T by alexander wang'),
(387, 'Termite eyewear'),
(388, 'Teva'),
(389, 'Thakoon'),
(390, 'Thakoon addition'),
(391, 'Thamanyah'),
(392, 'The row'),
(393, 'Thierry boutemy for opening ceremony'),
(394, 'Thierry lasry'),
(395, 'Thom browne'),
(396, 'Thomsen'),
(397, 'Tiffany & co'),
(398, 'Tigran avetisyan'),
(399, 'Toga'),
(400, 'Toga pulla'),
(401, 'Tom ford'),
(402, 'Topman'),
(403, 'Topshop'),
(404, 'Topshop boutique'),
(405, 'Topshop unique'),
(406, 'Truss'),
(407, 'Undercover'),
(408, 'Underground'),
(409, 'Uniqlo'),
(410, 'Urban outfitters'),
(411, 'Uy'),
(412, 'Vacheron constantin'),
(413, 'Vagabond'),
(414, 'Valentino'),
(415, 'Van cleef & arpels'),
(416, 'Vans'),
(417, 'Vans vault'),
(418, 'Veja'),
(419, 'Venessa arizaga'),
(420, 'Vera wang'),
(421, 'Véronique branquinho'),
(422, 'Veronique leroy'),
(423, 'Vetements'),
(424, 'Vika gazinskaya'),
(425, 'Viktor & rolf'),
(428, 'Vince'),
(429, 'Vionnet'),
(430, 'Vivienne westwood'),
(431, 'Vivienne westwood anglomania'),
(432, 'Vivienne westwood red label'),
(433, 'Vladimir karaleev'),
(434, 'Vowel'),
(435, 'Vpl'),
(436, 'Walk of shame'),
(437, 'Walter van beirendonck'),
(438, 'Want les essentiels de la vie'),
(439, 'Ward whillas'),
(440, 'We are handsome'),
(441, 'Wil fry'),
(442, 'Wolford'),
(443, 'Won hundred'),
(444, 'Wood wood'),
(445, 'Wooyoungmi'),
(446, 'Y-3'),
(447, 'Yang li'),
(448, 'Yasmine eslami'),
(449, 'Yohji yamamoto'),
(450, 'Yulia yefimtchuk+'),
(451, 'Yves saint laurent'),
(452, 'Yves salomon'),
(453, 'Zana bayne'),
(454, 'Zara'),
(455, 'Zddz'),
(456, 'Zenith'),
(457, 'Zodiac'),
(458, '& other stories');

-- --------------------------------------------------------

--
-- Структура таблицы `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `alias` varchar(255) COLLATE utf8_bin NOT NULL,
  `status` enum('active','inactive') COLLATE utf8_bin NOT NULL DEFAULT 'active',
  `menu_order` int(11) NOT NULL,
  `size_chart_cat_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `size_chart_cat_id` (`size_chart_cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=54 ;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `parent_id`, `alias`, `status`, `menu_order`, `size_chart_cat_id`) VALUES
(1, NULL, 'unisex', 'active', 5, NULL),
(2, NULL, 'women', 'active', 2, NULL),
(3, NULL, 'men', 'active', 3, NULL),
(4, NULL, 'kids', 'active', 4, NULL),
(10, 1, 'tops', 'active', 1, 11),
(11, 1, 'T-shirts', 'active', 2, 11),
(12, 1, 'Knitwear', 'active', 3, 11),
(13, 2, 'Tops', 'active', 2, 1),
(14, 2, 'Sweats and hoodies', 'active', 1, 1),
(16, 2, 'Dresses', 'active', 6, 1),
(17, 3, 'Shirts', 'active', 1, 5),
(18, 3, 'T-shirts', 'active', 2, 5),
(19, 3, 'Polo shirts', 'active', 3, 5),
(20, 4, 'scarves', 'active', 1, 9),
(21, 4, 'gloves', 'active', 2, 9),
(23, 1, 'Sweatshirts', 'active', 5, 11),
(25, 1, 'Jackets', 'active', 7, 11),
(26, 1, 'Coats', 'active', 8, 11),
(28, 1, 'Bottoms ', 'active', 10, 11),
(29, 1, 'Shorts', 'active', 11, 11),
(30, 1, 'Jeans', 'active', 12, 11),
(31, 1, 'Suits', 'active', 13, 11),
(33, 2, 'Jackets', 'active', 4, 1),
(34, 2, 'Coats', 'active', 5, 1),
(35, 2, 'Skirts', 'active', 7, 1),
(36, 2, 'Trousers', 'active', 8, 2),
(37, 2, 'Shorts', 'active', 9, 2),
(38, 2, 'Jeans', 'active', 10, 2),
(39, 2, 'Jumpsuits', 'active', 11, 2),
(40, 2, 'Lingerie', 'active', 12, 2),
(41, 2, 'Beachwear', 'active', 13, 2),
(42, 2, 'Activewear', 'active', 14, 2),
(43, 1, 'Activewear', 'active', 14, 11),
(44, 3, 'Sweats and hoodies', 'active', 4, 5),
(45, 3, 'Jackets', 'active', 5, 5),
(46, 3, 'Coats', 'active', 6, 5),
(47, 3, 'Trousers', 'active', 7, 6),
(48, 3, 'Shorts', 'active', 8, 6),
(49, 3, 'Jeans', 'active', 9, 6),
(50, 3, 'Suits', 'active', 10, 5),
(51, 3, 'Beachwear', 'active', 11, 5),
(52, 3, 'Activewear', 'active', 12, 5),
(53, 3, 'Workwear', 'active', 13, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `category_name`
--

CREATE TABLE IF NOT EXISTS `category_name` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `language` char(2) COLLATE utf8_bin NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `seo_title` varchar(255) COLLATE utf8_bin NOT NULL,
  `seo_description` varchar(255) COLLATE utf8_bin NOT NULL,
  `seo_keywords` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `language` (`language`,`category_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=97 ;

--
-- Дамп данных таблицы `category_name`
--

INSERT INTO `category_name` (`id`, `category_id`, `language`, `name`, `seo_title`, `seo_description`, `seo_keywords`) VALUES
(12, 1, 'en', 'unisex', '', ' ', ' '),
(13, 1, 'de', 'unisex', 'unisex', ' ', ' '),
(14, 1, 'ru', 'унисекс', 'unisex', '', ''),
(15, 2, 'en', 'women', 'women', '      ', '      '),
(16, 2, 'de', 'frau', ' 	women', '      ', '      '),
(17, 2, 'ru', 'женщины', 'women', '', ''),
(18, 3, 'en', 'men', 'men', '', ''),
(19, 3, 'de', 'menschen', ' 	men', '', ''),
(20, 3, 'ru', 'мужчины', ' 	men', '', ''),
(21, 4, 'en', 'kids', 'kids', '', ''),
(22, 4, 'de', 'kinder', 'kids', '', ''),
(23, 4, 'ru', 'дети', 'kids', '', ''),
(24, 10, 'en', 'tops', 'tops', '  ', '  '),
(25, 10, 'de', 'tops', 'tops', '  ', '  '),
(26, 10, 'ru', 'tops', 'tops', '', ''),
(27, 11, 'en', 'socks', 'socks', '  ', '  '),
(28, 11, 'de', 'socken', 'socks', '  ', '  '),
(29, 11, 'ru', 'носки', 'socks', '', ''),
(30, 12, 'en', 'Knitwear', 'Knitwear', '  ', '  '),
(31, 12, 'de', 'glas', '', '  ', '  '),
(32, 12, 'ru', 'очки', '', '', ''),
(33, 13, 'en', 'Tops', 'Tops', 'Tops', 'Tops'),
(34, 13, 'de', 'kleider', '', ' ', ' '),
(35, 13, 'ru', 'платья', '', '', ''),
(36, 14, 'en', 'Sweats and hoodies', 'Sweats and hoodies', ' ', ' '),
(37, 14, 'de', 'rock', '', ' ', ' '),
(38, 14, 'ru', 'юбки', '', '', ''),
(41, 16, 'en', 'Dresses', 'Dresses', ' ', ' '),
(42, 16, 'de', 'damenunterwäsche', '', ' ', ' '),
(43, 16, 'ru', 'нижнее белье', '', '', ''),
(44, 17, 'en', 'Shirts', 'Shirts', ' ', ' '),
(45, 17, 'de', 'beziehungen', '', ' ', ' '),
(46, 17, 'ru', 'галстуки', '', '', ''),
(47, 18, 'en', 'T-shirts', 'Man Trousers', '  ', '  '),
(48, 18, 'de', 'hose', '', '  ', '  '),
(49, 18, 'ru', 'брюки', '', ' ', ' '),
(50, 19, 'en', 'Polo shirts', 'Polo shirts', ' ', ' '),
(51, 19, 'de', 'pullover', '', ' ', ' '),
(52, 19, 'ru', 'свитера', '', '', ''),
(53, 20, 'en', 'scarves', 'scarves', '', ''),
(54, 20, 'de', 'schals', '', '', ''),
(55, 20, 'ru', 'шарфы', '', '', ''),
(56, 21, 'en', 'gloves', 'gloves', '', ''),
(57, 21, 'de', 'handschuhe', '', '', ''),
(58, 21, 'ru', 'перчатки', '', '', ''),
(60, 23, 'en', 'Sweatshirts', 'Sweatshirts', '    ', '    '),
(63, 25, 'en', 'Jackets', 'Jackets', '  ', '  '),
(64, 26, 'en', 'Coats', 'Coats', '  ', '  '),
(66, 28, 'en', 'Bottoms ', 'Bottoms', '  ', '  '),
(67, 25, 'de', 'Unisex Jackets', '', '  ', '  '),
(68, 26, 'de', 'Unisex Coats', '', '  ', '  '),
(70, 23, 'de', 'Sweats and hoodies', '', '    ', '    '),
(71, 29, 'en', 'Shorts', 'Shorts', ' ', ' '),
(72, 30, 'en', 'Jeans', 'Jeans', ' ', ' '),
(73, 31, 'en', 'Suits', 'Suits', ' ', ' '),
(75, 33, 'en', 'Jackets', 'Jackets', ' ', ' '),
(76, 34, 'en', 'Coats', 'Coats', ' ', ' '),
(77, 35, 'en', 'Skirts', 'Skirts', ' ', ' '),
(78, 36, 'en', 'Trousers', 'Trousers', ' ', ' '),
(79, 37, 'en', 'Shorts', 'Shorts', ' ', ' '),
(80, 38, 'en', 'Jeans', 'Jeans', ' ', ' '),
(81, 39, 'en', 'Jumpsuits', 'Jumpsuits', ' ', ' '),
(82, 40, 'en', 'Lingerie', 'Lingerie', ' ', ' '),
(83, 41, 'en', 'Beachwear', 'Beachwear', ' ', ' '),
(84, 42, 'en', 'Activewear', 'Activewear', ' ', ' '),
(85, 43, 'en', 'Activewear', 'Activewear', ' ', ' '),
(86, 44, 'en', 'Sweats and hoodies', 'Sweats and hoodies', ' ', ' '),
(87, 45, 'en', 'Jackets', 'Jackets', ' ', ' '),
(88, 46, 'en', 'Coats', 'Coats', ' ', ' '),
(89, 47, 'en', 'Trousers', 'Trousers', ' ', ' '),
(90, 48, 'en', 'Shorts', 'Shorts', ' ', ' '),
(91, 49, 'en', 'Jeans', 'Jeans', ' ', ' '),
(92, 50, 'en', 'Suits', 'Suits', ' ', ' '),
(93, 51, 'en', 'Beachwear', 'Beachwear', ' ', ' '),
(94, 52, 'en', 'Activewear', 'Activewear', ' ', ' '),
(95, 53, 'en', 'Workwear', 'Workwear', ' ', ' '),
(96, 28, 'de', 'Unisex Trousers', 'Unisex Trousers', '  ', '  ');

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `comment` varchar(255) COLLATE utf8_bin NOT NULL,
  `response` varchar(255) COLLATE utf8_bin NOT NULL,
  `comment_status` enum('published','banned') COLLATE utf8_bin NOT NULL DEFAULT 'published',
  `response_status` enum('published','banned') COLLATE utf8_bin NOT NULL DEFAULT 'published',
  `added_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `user_id` (`user_id`),
  KEY `seller_id` (`seller_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `code_iso` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=246 ;

--
-- Дамп данных таблицы `country`
--

INSERT INTO `country` (`id`, `name`, `code_iso`) VALUES
(1, 'Afghanistan', 'AF'),
(2, 'Aland Islands', 'AX'),
(3, 'Albania', 'AL'),
(4, 'Algeria', 'DZ'),
(5, 'American Samoa', 'AS'),
(6, 'Andorra', 'AD'),
(7, 'Angola', 'AO'),
(8, 'Anguilla', 'AI'),
(9, 'Antarctica', 'AQ'),
(10, 'Antigua And Barbuda', 'AG'),
(11, 'Argentina', 'AR'),
(12, 'Armenia', 'AM'),
(13, 'Aruba', 'AW'),
(14, 'Australia', 'AU'),
(15, 'Austria', 'AT'),
(16, 'Azerbaijan', 'AZ'),
(17, 'Bahamas', 'BS'),
(18, 'Bahrain', 'BH'),
(19, 'Bangladesh', 'BD'),
(20, 'Barbados', 'BB'),
(21, 'Belarus', 'BY'),
(22, 'Belgium', 'BE'),
(23, 'Belize', 'BZ'),
(24, 'Benin', 'BJ'),
(25, 'Bermuda', 'BM'),
(26, 'Bhutan', 'BT'),
(27, 'Bolivia', 'BO'),
(28, 'Bosnia And Herzegovina', 'BA'),
(29, 'Botswana', 'BW'),
(30, 'Bouvet Island', 'BV'),
(31, 'Brazil', 'BR'),
(32, 'British Indian Ocean Territory', 'IO'),
(33, 'Brunei Darussalam', 'BN'),
(34, 'Bulgaria', 'BG'),
(35, 'Burkina Faso', 'BF'),
(36, 'Burundi', 'BI'),
(37, 'Cambodia', 'KH'),
(38, 'Cameroon', 'CM'),
(39, 'Canada', 'CA'),
(40, 'Cape Verde', 'CV'),
(41, 'Cayman Islands', 'KY'),
(42, 'Central African Republic', 'CF'),
(43, 'Chad', 'TD'),
(44, 'Chile', 'CL'),
(45, 'China', 'CN'),
(46, 'Christmas Island', 'CX'),
(47, 'Cocos (Keeling) Islands', 'CC'),
(48, 'Colombia', 'CO'),
(49, 'Comoros', 'KM'),
(50, 'Congo', 'CG'),
(51, 'Congo, Democratic Republic', 'CD'),
(52, 'Cook Islands', 'CK'),
(53, 'Costa Rica', 'CR'),
(54, 'Cote D''Ivoire', 'CI'),
(55, 'Croatia', 'HR'),
(56, 'Cuba', 'CU'),
(57, 'Cyprus', 'CY'),
(58, 'Czech Republic', 'CZ'),
(59, 'Denmark', 'DK'),
(60, 'Djibouti', 'DJ'),
(61, 'Dominica', 'DM'),
(62, 'Dominican Republic', 'DO'),
(63, 'Ecuador', 'EC'),
(64, 'Egypt', 'EG'),
(65, 'El Salvador', 'SV'),
(66, 'Equatorial Guinea', 'GQ'),
(67, 'Eritrea', 'ER'),
(68, 'Estonia', 'EE'),
(69, 'Ethiopia', 'ET'),
(70, 'Falkland Islands (Malvinas)', 'FK'),
(71, 'Faroe Islands', 'FO'),
(72, 'Fiji', 'FJ'),
(73, 'Finland', 'FI'),
(74, 'France', 'FR'),
(75, 'French Guiana', 'GF'),
(76, 'French Polynesia', 'PF'),
(77, 'French Southern Territories', 'TF'),
(78, 'Gabon', 'GA'),
(79, 'Gambia', 'GM'),
(80, 'Georgia', 'GE'),
(81, 'Germany', 'DE'),
(82, 'Ghana', 'GH'),
(83, 'Gibraltar', 'GI'),
(84, 'Greece', 'GR'),
(85, 'Greenland', 'GL'),
(86, 'Grenada', 'GD'),
(87, 'Guadeloupe', 'GP'),
(88, 'Guam', 'GU'),
(89, 'Guatemala', 'GT'),
(90, 'Guernsey', 'GG'),
(91, 'Guinea', 'GN'),
(92, 'Guinea-Bissau', 'GW'),
(93, 'Guyana', 'GY'),
(94, 'Haiti', 'HT'),
(95, 'Heard Island & Mcdonald Islands', 'HM'),
(96, 'Holy See (Vatican City State)', 'VA'),
(97, 'Honduras', 'HN'),
(98, 'Hong Kong', 'HK'),
(99, 'Hungary', 'HU'),
(100, 'Iceland', 'IS'),
(101, 'India', 'IN'),
(102, 'Indonesia', 'ID'),
(103, 'Iran, Islamic Republic Of', 'IR'),
(104, 'Iraq', 'IQ'),
(105, 'Ireland', 'IE'),
(106, 'Isle Of Man', 'IM'),
(107, 'Israel', 'IL'),
(108, 'Italy', 'IT'),
(109, 'Jamaica', 'JM'),
(110, 'Japan', 'JP'),
(111, 'Jersey', 'JE'),
(112, 'Jordan', 'JO'),
(113, 'Kazakhstan', 'KZ'),
(114, 'Kenya', 'KE'),
(115, 'Kiribati', 'KI'),
(116, 'Korea', 'KR'),
(117, 'Kuwait', 'KW'),
(118, 'Kyrgyzstan', 'KG'),
(119, 'Lao People''s Democratic Republic', 'LA'),
(120, 'Latvia', 'LV'),
(121, 'Lebanon', 'LB'),
(122, 'Lesotho', 'LS'),
(123, 'Liberia', 'LR'),
(124, 'Libyan Arab Jamahiriya', 'LY'),
(125, 'Liechtenstein', 'LI'),
(126, 'Lithuania', 'LT'),
(127, 'Luxembourg', 'LU'),
(128, 'Macao', 'MO'),
(129, 'Macedonia', 'MK'),
(130, 'Madagascar', 'MG'),
(131, 'Malawi', 'MW'),
(132, 'Malaysia', 'MY'),
(133, 'Maldives', 'MV'),
(134, 'Mali', 'ML'),
(135, 'Malta', 'MT'),
(136, 'Marshall Islands', 'MH'),
(137, 'Martinique', 'MQ'),
(138, 'Mauritania', 'MR'),
(139, 'Mauritius', 'MU'),
(140, 'Mayotte', 'YT'),
(141, 'Mexico', 'MX'),
(142, 'Micronesia, Federated States Of', 'FM'),
(143, 'Moldova', 'MD'),
(144, 'Monaco', 'MC'),
(145, 'Mongolia', 'MN'),
(146, 'Montenegro', 'ME'),
(147, 'Montserrat', 'MS'),
(148, 'Morocco', 'MA'),
(149, 'Mozambique', 'MZ'),
(150, 'Myanmar', 'MM'),
(151, 'Namibia', 'NA'),
(152, 'Nauru', 'NR'),
(153, 'Nepal', 'NP'),
(154, 'Netherlands', 'NL'),
(155, 'Netherlands Antilles', 'AN'),
(156, 'New Caledonia', 'NC'),
(157, 'New Zealand', 'NZ'),
(158, 'Nicaragua', 'NI'),
(159, 'Niger', 'NE'),
(160, 'Nigeria', 'NG'),
(161, 'Niue', 'NU'),
(162, 'Norfolk Island', 'NF'),
(163, 'Northern Mariana Islands', 'MP'),
(164, 'Norway', 'NO'),
(165, 'Oman', 'OM'),
(166, 'Pakistan', 'PK'),
(167, 'Palau', 'PW'),
(168, 'Palestinian Territory, Occupied', 'PS'),
(169, 'Panama', 'PA'),
(170, 'Papua New Guinea', 'PG'),
(171, 'Paraguay', 'PY'),
(172, 'Peru', 'PE'),
(173, 'Philippines', 'PH'),
(174, 'Pitcairn', 'PN'),
(175, 'Poland', 'PL'),
(176, 'Portugal', 'PT'),
(177, 'Puerto Rico', 'PR'),
(178, 'Qatar', 'QA'),
(179, 'Reunion', 'RE'),
(180, 'Romania', 'RO'),
(181, 'Russian Federation', 'RU'),
(182, 'Rwanda', 'RW'),
(183, 'Saint Barthelemy', 'BL'),
(184, 'Saint Helena', 'SH'),
(185, 'Saint Kitts And Nevis', 'KN'),
(186, 'Saint Lucia', 'LC'),
(187, 'Saint Martin', 'MF'),
(188, 'Saint Pierre And Miquelon', 'PM'),
(189, 'Saint Vincent And Grenadines', 'VC'),
(190, 'Samoa', 'WS'),
(191, 'San Marino', 'SM'),
(192, 'Sao Tome And Principe', 'ST'),
(193, 'Saudi Arabia', 'SA'),
(194, 'Senegal', 'SN'),
(195, 'Serbia', 'RS'),
(196, 'Seychelles', 'SC'),
(197, 'Sierra Leone', 'SL'),
(198, 'Singapore', 'SG'),
(199, 'Slovakia', 'SK'),
(200, 'Slovenia', 'SI'),
(201, 'Solomon Islands', 'SB'),
(202, 'Somalia', 'SO'),
(203, 'South Africa', 'ZA'),
(204, 'South Georgia And Sandwich Isl.', 'GS'),
(205, 'Spain', 'ES'),
(206, 'Sri Lanka', 'LK'),
(207, 'Sudan', 'SD'),
(208, 'Suriname', 'SR'),
(209, 'Svalbard And Jan Mayen', 'SJ'),
(210, 'Swaziland', 'SZ'),
(211, 'Sweden', 'SE'),
(212, 'Switzerland', 'CH'),
(213, 'Syrian Arab Republic', 'SY'),
(214, 'Taiwan', 'TW'),
(215, 'Tajikistan', 'TJ'),
(216, 'Tanzania', 'TZ'),
(217, 'Thailand', 'TH'),
(218, 'Timor-Leste', 'TL'),
(219, 'Togo', 'TG'),
(220, 'Tokelau', 'TK'),
(221, 'Tonga', 'TO'),
(222, 'Trinidad And Tobago', 'TT'),
(223, 'Tunisia', 'TN'),
(224, 'Turkey', 'TR'),
(225, 'Turkmenistan', 'TM'),
(226, 'Turks And Caicos Islands', 'TC'),
(227, 'Tuvalu', 'TV'),
(228, 'Uganda', 'UG'),
(229, 'Ukraine', 'UA'),
(230, 'United Arab Emirates', 'AE'),
(231, 'United Kingdom', 'GB'),
(232, 'United States', 'US'),
(233, 'United States Outlying Islands', 'UM'),
(234, 'Uruguay', 'UY'),
(235, 'Uzbekistan', 'UZ'),
(236, 'Vanuatu', 'VU'),
(237, 'Venezuela', 'VE'),
(238, 'Viet Nam', 'VN'),
(239, 'Virgin Islands, British', 'VG'),
(240, 'Virgin Islands, U.S.', 'VI'),
(241, 'Wallis And Futuna', 'WF'),
(242, 'Western Sahara', 'EH'),
(243, 'Yemen', 'YE'),
(244, 'Zambia', 'ZM'),
(245, 'Zimbabwe', 'ZW');

-- --------------------------------------------------------

--
-- Структура таблицы `email_template`
--

CREATE TABLE IF NOT EXISTS `email_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(255) COLLATE utf8_bin NOT NULL,
  `content` text COLLATE utf8_bin NOT NULL,
  `subject` varchar(50) COLLATE utf8_bin NOT NULL,
  `language` char(2) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `alias` (`alias`,`language`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=43 ;

--
-- Дамп данных таблицы `email_template`
--

INSERT INTO `email_template` (`id`, `alias`, `content`, `subject`, `language`) VALUES
(1, 'registration', '<p>Hello,</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Thank you very much for your registration.</p>\r\n\r\n<p>You can change&nbsp;your registration details anytime in My account.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>The 23-15.com team</strong></p>\r\n', 'Thank you for signing up', 'en'),
(2, 'Thank you for submitting your item', '<p>Hello,&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Thank you for selling&nbsp;with us.</p>\r\n\r\n<p>We will review your item and get back to you shortly.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>The 23-15.com team</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n', 'Thank you for submitting your item', 'en'),
(3, 'Item is accepted for sale', '<p>Hello,&nbsp;</p>\r\n\r\n<p>Good news! Your item is accepted and will&nbsp;appear in the shop as well as on your profile page available for viewing instantly by other users. &nbsp;</p>\r\n\r\n<p>Thank you.</p>\r\n\r\n<p><strong>The 23-15.com team.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n', 'Item is accepted for sale', 'en'),
(4, 'Item is rejected', '<p>Hello,&nbsp;</p>\r\n\r\n<p>We are sorry&nbsp;to reject your item this time.&nbsp;</p>\r\n\r\n<p>Comment from our moderation team:&nbsp;</p>\r\n\r\n<p>Thank you.</p>\r\n\r\n<p><strong>The 23-15.com team.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n', 'Item is rejected', 'en'),
(5, 'Please edit your item', '<p>Hello,</p>\r\n\r\n<p>Your item requires some changes.&nbsp;Please edit your item here.</p>\r\n\r\n<p>Thank you.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>The 23-15.com team</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n', 'Please edit your item', 'en'),
(6, 'Price offer made', '<p>Hello,&nbsp;</p>\r\n\r\n<p>You have received a&nbsp;price offer on:&nbsp;</p>\r\n\r\n<p>To view, accept or decline the offer, please go to My account &gt; Inbox &gt; Offers or click here.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Thank you.</p>\r\n\r\n<p><strong>The 23-15.com team</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n', 'Price offer made', 'en'),
(7, 'Item is sold', '<p>Hello,&nbsp;</p>\r\n\r\n<p>Your item was sold.</p>\r\n\r\n<p>Below you will find a <strong>pre-paid shipping voucher</strong> with <strong>instructions</strong>&nbsp;on how to send your item to the buyer.</p>\r\n\r\n<p>If you have any questions, please contact us on enquires@23-15.com</p>\r\n\r\n<p>Thank you.</p>\r\n\r\n<p><strong>The 23-15.com team</strong></p>\r\n', 'Item is sold', 'en'),
(8, 'Order confirmation', '<p>The order is placed with a score in the applicationOrder&nbsp;</p>\r\n', 'Order confirmation', 'en'),
(9, 'Shipping confirmation', '<p>Goods shipped with Tracking No.</p>\r\n', 'Shipping confirmation', 'en'),
(11, 'Feedback', '<p>Review: Seller vote (after the buyer received the order and if everything is in order)</p>\r\n', 'Feedback', 'en'),
(12, 'complaint', '<p>A new complaint is received (to the administrator)</p>\r\n', 'Complaint', 'en'),
(13, 'Price alert notification', '<p>Notification of a price for the goods from the &quot;my list&quot; to add new products,<br />\r\nmatching the specified size</p>\r\n', 'Price alert notification', 'en'),
(14, 'Comment received', '<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Added comments with reference to the answer</p>\r\n', 'Comment received', 'en'),
(15, 'My Account password', '<p>Click on the following link to reset your password</p>\r\n\r\n<p>{link}</p>\r\n', 'My Account password', 'en'),
(16, 'Size alert notification', '<p>Product {product} size {size} has been added</p>\r\n\r\n<p>For view click on the link</p>\r\n\r\n<p>{link}</p>\r\n', 'Size alert notification', 'en'),
(18, 'alerts', '', '', 'de'),
(19, 'alerts', '', '', 'ru'),
(20, 'registration', '', '', 'de'),
(21, 'Item Submitted ', '', '', 'de'),
(22, 'Item is accepted', '', '', 'de'),
(23, 'Item is submitted ', '', '', 'de'),
(24, 'Thank you for submitting your item', '', '', 'de'),
(25, 'Item is accepted for sale', '', '', 'de'),
(26, 'Item is rejected', '', '', 'de'),
(27, 'requires editing', '', '', 'de'),
(28, 'Please edit your item', '', '', 'de'),
(29, 'Price offer made', '', '', 'de'),
(30, 'Item is sold', '', '', 'de'),
(31, 'Order confirmation', '', '', 'de'),
(32, 'Shipping confirmation', '', '', 'de'),
(33, 'Feedback', '', '', 'de'),
(34, 'complaint', '', '', 'de'),
(35, 'Comment received', '', '', 'de'),
(36, 'Alert notification', '', '', 'de'),
(37, 'My Account password', '', '', 'de'),
(38, 'Price alert notification', '', '', 'de'),
(39, 'Size alert notification', '', '', 'de'),
(40, 'forgot password', '<p>Here&#39;s the link to set new password: {link}</p>\r\n', 'Restore Password', 'en'),
(41, 'forgot password', '', '', 'de'),
(42, 'confirmation placement', '<p>Adding the product has been successfully.</p>', 'New product', 'en');

-- --------------------------------------------------------

--
-- Структура таблицы `filters`
--

CREATE TABLE IF NOT EXISTS `filters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `brand` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `size_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `condition` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seller_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- Дамп данных таблицы `filters`
--

INSERT INTO `filters` (`id`, `user_id`, `category`, `brand`, `size_type`, `country`, `condition`, `seller_type`) VALUES
(5, 6, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 19, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 20, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 24, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 25, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 22, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 27, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 38, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 41, '', '', '', '', '', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `homepage_block`
--

CREATE TABLE IF NOT EXISTS `homepage_block` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8_bin NOT NULL,
  `link_type` enum('direct','filter') COLLATE utf8_bin NOT NULL DEFAULT 'direct',
  `block_type` varchar(15) COLLATE utf8_bin NOT NULL,
  `url` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=20 ;

--
-- Дамп данных таблицы `homepage_block`
--

INSERT INTO `homepage_block` (`id`, `image`, `link_type`, `block_type`, `url`) VALUES
(1, '02-15-2016-08-19-14-Screen Shot 2015-10-23 at 16_id_1.jpg', 'filter', 'big_1', 'en/category/women/Tops'),
(2, '02-03-2016-06-23-59-02-02-2016-09-08-42-img-1_id_1_id_2.png', 'direct', 'small_1', '/en/site/page/view/about'),
(3, '02-04-2016-07-44-05-black-hole_id_3.jpg', 'direct', 'smallImg_1', '/'),
(4, '02-02-2016-09-23-56-img-1_id_4.png', 'direct', 'smallImg_2', '/'),
(5, '02-03-2016-06-26-45-02-02-2016-09-25-06-img-1_id_8_id_5.png', 'direct', 'big_2', '/en/category/unisex/tops'),
(6, '12-03-2015-12-12-27-item4_id_7.png', 'direct', 'smallImg_3', '/'),
(7, '12-03-2015-12-14-52-item5_id_8.png', 'direct', 'smallImg_4', '/'),
(8, '02-02-2016-09-25-06-img-1_id_8.png', 'direct', 'big_3', 'en/category/men/Shirts'),
(9, '12-03-2015-12-15-14-item6_id_9.png', 'direct', 'smallImg_5', '/'),
(10, '12-03-2015-12-16-16-item7_id_12.png', 'direct', 'smallImg_6', '/'),
(11, '02-02-2016-09-12-54-img-1_id_11.png', 'direct', 'small_2', '/en/members/auth/login'),
(12, '02-02-2016-09-14-06-img-1_id_12.png', 'direct', 'big_4', '/en/category/kids/scarves'),
(13, '02-03-2016-06-12-41-img-1_id_13.png', 'direct', 'big_5', 'https://23-15-blog.tumblr.com/'),
(14, '12-03-2015-12-16-36-item8_id_13.png', 'direct', 'smallImg_7', '/'),
(15, '12-03-2015-12-12-05-item3_id_6.png', 'direct', 'smallImg_8', '/'),
(16, '', 'direct', 'blockShopHere', '/en/category/unisex/tops'),
(17, '02-15-2016-05-53-40-12080632_1662060237369931_563116282_n(1)_id_17.jpg', 'direct', 'instagram_1', 'https://www.instagram.com/2315_mrktplc/'),
(18, '02-03-2016-06-13-42-img-1_id_18.png', 'direct', 'instagramBig', 'https://www.instagram.com/2315_mrktplc/'),
(19, '02-03-2016-06-14-49-img-1_id_19.png', 'direct', 'instagram_2', 'https://www.instagram.com/2315_mrktplc/');

-- --------------------------------------------------------

--
-- Структура таблицы `homepage_block_content`
--

CREATE TABLE IF NOT EXISTS `homepage_block_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `block_id` int(11) NOT NULL,
  `language` char(2) COLLATE utf8_bin NOT NULL,
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `content` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `block_id` (`block_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=52 ;

--
-- Дамп данных таблицы `homepage_block_content`
--

INSERT INTO `homepage_block_content` (`id`, `block_id`, `language`, `title`, `content`) VALUES
(1, 1, 'en', 'Shop Women', '<p>Vetements</p>'),
(2, 1, 'de', 'Opening ceremony', '<p>white t-shirt</p>\r\n'),
(3, 1, 'ru', 'Opening ceremony', '<p>white t-shirt</p>\r\n'),
(4, 5, 'en', 'Opening ceremony', '<p>white t-shirt</p>\r\n'),
(5, 8, 'en', 'Opening ceremony', '<p>white t-shirt</p>\r\n'),
(6, 3, 'en', 'DRX Romanelli x Felix the Cat', '<p>white t-shirt</p>\r\n'),
(7, 4, 'en', 'Kenzo', '<p>gommato kalifornia wallet on chain</p>\r\n'),
(8, 15, 'en', 'DRX Romanelli x Felix the Cat', '<p>white t-shirt</p>\r\n'),
(9, 6, 'en', 'Kenzo', '<p>gommato kalifornia wallet on chain</p>\r\n'),
(10, 7, 'en', 'DRX Romanelli x Felix the Cat', '<p>white t-shirt</p>\r\n'),
(11, 9, 'en', 'Kenzo', '<p>gommato kalifornia wallet on chain</p>\r\n'),
(12, 12, 'en', 'Opening ceremony', '<p>white t-shirt</p>\r\n'),
(13, 13, 'en', 'Our blog', '<p>A private session with Marina Nery @ Joy photographed by Higor Bastos</p>\r\n'),
(14, 10, 'en', 'DRX Romanelli x Felix the Cat', '<p>white t-shirt</p>\r\n'),
(15, 14, 'en', 'Kenzo', '<p>gommato kalifornia wallet on chain</p>\r\n'),
(16, 5, 'de', 'Opening ceremony', '<p>white t-shirt</p>\r\n'),
(17, 5, 'ru', 'Opening ceremony', '<p>white t-shirt</p>\r\n'),
(18, 8, 'de', 'Opening ceremony', '<p>white t-shirt</p>\r\n'),
(19, 8, 'ru', 'Opening ceremony', '<p>white t-shirt</p>\r\n'),
(20, 12, 'de', 'Opening ceremony', '<p>white t-shirt</p>\r\n'),
(21, 12, 'ru', 'Opening ceremony', '<p>white t-shirt</p>\r\n'),
(22, 13, 'de', 'A private session with Marina Nery @ Joy photographed by Higor Bastos', '<p>read more</p>\r\n'),
(23, 13, 'ru', 'A private session with Marina Nery @ Joy photographed by Higor Bastos', '<p>read more</p>\r\n'),
(24, 3, 'de', 'DRX Romanelli x Felix the Cat', '<p>white t-shirt</p>\r\n'),
(25, 3, 'ru', 'DRX Romanelli x Felix the Cat', '<p>white t-shirt</p>\r\n'),
(26, 4, 'de', 'Kenzo', '<p>gommato kalifornia wallet on chain</p>\r\n'),
(27, 4, 'ru', 'Kenzo', '<p>gommato kalifornia wallet on chain</p>\r\n'),
(28, 15, 'de', 'DRX Romanelli x Felix the Cat', '<p>white t-shirt</p>\r\n'),
(29, 15, 'ru', 'DRX Romanelli x Felix the Cat', '<p>white t-shirt</p>\r\n'),
(30, 6, 'de', 'Kenzo', '<p>gommato kalifornia wallet on chain</p>\r\n'),
(31, 6, 'ru', 'Kenzo', '<p>gommato kalifornia wallet on chain</p>\r\n'),
(32, 7, 'de', 'DRX Romanelli x Felix the Cat', '<p>white t-shirt</p>\r\n'),
(33, 7, 'ru', 'DRX Romanelli x Felix the Cat', '<p>white t-shirt</p>\r\n'),
(34, 9, 'de', 'Kenzo', '<p>gommato kalifornia wallet on chain</p>\r\n'),
(35, 9, 'ru', 'Kenzo', '<p>gommato kalifornia wallet on chain</p>\r\n'),
(36, 10, 'de', 'DRX Romanelli x Felix the Cat', '<p>white t-shirt</p>\r\n'),
(37, 10, 'ru', 'DRX Romanelli x Felix the Cat', '<p>white t-shirt</p>\r\n'),
(38, 14, 'de', 'Kenzo', '<p>gommato kalifornia wallet on chain</p>\r\n'),
(39, 14, 'ru', 'Kenzo', '<p>gommato kalifornia wallet on chain</p>\r\n'),
(40, 16, 'en', 'space for tagline', '<p>A private<br />\r\nsession with<br />\r\nMarina Nery @<br />\r\nJoy photographed<br />\r\nby Higor Bastos</p>\r\n'),
(41, 16, 'de', 'space for tagline', '<p>A private session with Marina Nery @ Joy photographed by Higor Bastos</p>\r\n'),
(42, 2, 'en', 'about us', '<p>23-15.com is a curated marketplace platform for agender fashion. Here you can find beautiful&nbsp;pieces from&nbsp;young talented designers and more&nbsp;established names.&nbsp;Here you can create your own store and sell your special items hassle-free.&nbsp;</p>\r\n'),
(43, 2, 'de', 'about us', '<p>Lorem ipsum dolor sit amet, vel eu hinc epicuri noluisse, choro laudem adipisci qui id. Has cibo ludus fuisset te.</p>\r\n'),
(44, 11, 'en', 'sell with us', '<p>Lorem ipsum dolor sit amet, vel eu hinc epicuri noluisse, choro laudem adipisci qui id. Has cibo ludus fuisset te.</p>\r\n'),
(45, 17, 'en', 'instagram_1', '<p>instagram_1</p>\r\n'),
(46, 19, 'en', 'instagram_2', '<p>instagram_2</p>\r\n'),
(47, 18, 'en', 'instagram', '<p>follow us</p>\r\n'),
(48, 18, 'de', 'instagram', '<p>follow us</p>\r\n'),
(49, 11, 'de', 'sell with us', '<p>Lorem ipsum dolor sit amet, vel eu hinc epicuri noluisse, choro laudem adipisci qui id. Has cibo ludus fuisset te.</p>\r\n'),
(50, 19, 'de', 'instagram_2', '<p>instagram_2</p>\r\n'),
(51, 17, 'de', 'instagram_1', '<p>instagram_1</p>\r\n');

-- --------------------------------------------------------

--
-- Структура таблицы `offers`
--

CREATE TABLE IF NOT EXISTS `offers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `offer` int(11) NOT NULL,
  `added_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user_id`),
  KEY `seller` (`seller_id`),
  KEY `product` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total` decimal(9,2) NOT NULL,
  `shipping_address_id` int(11) NOT NULL,
  `status` enum('open','processed','uncompleted','complete','failed','canceled') COLLATE utf8_bin NOT NULL DEFAULT 'open',
  `paypal_id` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `shipping_address_id` (`shipping_address_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `order_item`
--

CREATE TABLE IF NOT EXISTS `order_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `status` enum('awaiting','paid','couponed','shipped','received') COLLATE utf8_bin DEFAULT NULL,
  `price` decimal(9,2) NOT NULL,
  `comission_rate` decimal(2,2) NOT NULL,
  `shipping_status` enum('started','processed','recieved','returned','complete') COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  KEY `coupon_id` (`coupon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8_bin NOT NULL,
  `footer_order` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` enum('active','inactive') COLLATE utf8_bin NOT NULL DEFAULT 'inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=14 ;

--
-- Дамп данных таблицы `page`
--

INSERT INTO `page` (`id`, `slug`, `footer_order`, `status`) VALUES
(2, 'contact', 1, 'active'),
(3, 'faq', 2, 'active'),
(9, 'privacy', 3, 'active'),
(10, 'terms', 1, 'active'),
(11, 'about', 3, 'active'),
(13, 'Terms', 2, 'active');

-- --------------------------------------------------------

--
-- Структура таблицы `page_content`
--

CREATE TABLE IF NOT EXISTS `page_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `language` char(2) COLLATE utf8_bin NOT NULL DEFAULT 'en',
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `content` text COLLATE utf8_bin NOT NULL,
  `seo_description` varchar(255) COLLATE utf8_bin NOT NULL,
  `seo_keywords` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=25 ;

--
-- Дамп данных таблицы `page_content`
--

INSERT INTO `page_content` (`id`, `page_id`, `language`, `title`, `content`, `seo_description`, `seo_keywords`) VALUES
(2, 2, 'en', '', '<p><strong>Contact &nbsp; </strong>&nbsp; &nbsp; enquires@23-15.com</p>\r\n\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Monday - Friday, from 10am to 7pm CET</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Imprint &nbsp; &nbsp; &nbsp; &nbsp;</strong>Responsible for the content according to &sect;10 Abs. 3MDStVG<br />\r\n&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 23-15 MODE-PLATTFORM UG<br />\r\n&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 13355 Berlin, Germany<br />\r\n&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Registration court:<br />\r\n&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Amtsgericht Charlottenburg<br />\r\n&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Commercial registar number:<br />\r\n&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; HRB 172413 B<br />\r\n&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; UST-ID:&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Credits &nbsp; &nbsp; &nbsp; </strong>Website design:&nbsp;<a href="http://www.joaonoberto.com">www.joaonoberto.com</a></p>\r\n\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Website development:&nbsp;<a href="http://www.eip-soft.com">www.eip-soft.com</a></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n', '    ', '    '),
(3, 3, 'en', 'Frequently asked questions', '<p align="center">Is it going to have a text here?</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Lorem ipsum dolor sit amet?</strong></p>\r\n\r\n<p><strong>Dolor sit amet?</strong></p>\r\n\r\n<p><strong>Lorem ipsum sit amet?</strong></p>\r\n\r\n<p><strong>Dolor sit amet?</strong></p>\r\n\r\n<p><strong>Dolor sit amet lorem ipsum dolor?</strong></p>\r\n', '    ', '    '),
(11, 2, 'de', 'Contact us', '<p>Contact us</p>\r\n', '    ', '    '),
(12, 2, 'ru', 'Contact us', '<p>Contact us</p>\r\n', '  ', '  '),
(15, 9, 'en', 'Privacy policy', '<p>Privacy policy page</p>\r\n', '  ', '  '),
(16, 10, 'en', 'Terms and Conditions for users', '<p>Terms &amp; Conditions page</p>\r\n', '   ', '   '),
(17, 11, 'en', 'About Us', '<div class="uk-h3 uk-text-center uk-padding-x uk-margin-large-bottom">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas laoreet eleifend congue. Nunc imperdiet est risus, et porttitor ante semper non.</div>\n						<div class="uk-text-about uk-margin-bottom">Consectetur adipiscing elit. Maecenas laoreet eleifend congue. Nunc imperdiet est risus, et porttitor ante semper non. Morbi nulla arcu, tristique non faucibus non, vestibulum eget sem. Sed ultricies eros quis ante cursus, sollicitudin placerat ipsum consectetur. Praesent sit amet tristique odio. Aliquam vehicula tempor est, quis lobortis mi vestibulum non. Quisque mollis turpis nec tincidunt euismod. Fusce commodo velit quis ornare dignissim. Quisque sodales enim et arcu dapibus, vel varius urna dictum. Donec eu facilisis sem, quis tincidunt nulla. In tincidunt ultricies velit id tristique. Sed lobortis, orci at consequat sodales, sapien felis ultricies purus, nec tempor quam eros id nibh.</div>\n						<div class="uk-h3 uk-text-line-height"><b>Lorem ipsum dolor sit amet</b></div>\n						<div class="uk-text-about">Consectetur adipiscing elit. Maecenas laoreet eleifend congue. Nunc imperdiet est risus, et porttitor ante semper non. Morbi nulla arcu, tristique non faucibus non, vestibulum eget sem. Sed ultricies eros quis ante cursus, sollicitudin placerat ipsum consectetur. Praesent sit amet tristique odio. Aliquam vehicula tempor est, quis lobortis mi vestibulum non. Quisque mollis turpis nec tincidunt euismod. Fusce commodo velit quis ornare dignissim. Quisque sodales enim et arcu dapibus, vel varius urna dictum. Donec eu facilisis sem, quis tincidunt nulla. In tincidunt ultricies velit id tristique. Sed lobortis, orci at consequat sodales, sapien felis ultricies purus, nec tempor quam eros id nibh.</div>', '    ', '    '),
(19, 11, 'de', 'About Us', '<p>Lorem ipsum dolor sit amet, wisi purus nulla etiam lacinia auctor velit. Consequat ut cras maecenas ac, metus hendrerit in. In quam purus sociis, et mauris nisl pellentesque rutrum libero, bibendum enim suscipit et pede. Hendrerit luctus porttitor nulla felis interdum tortor, blandit risus, at mauris accumsan in, sed vehicula, wisi etiam sed morbi tellus. Sit mauris lobortis tincidunt ante fringilla, integer sed tellus praesent. Metus ipsum felis placerat in, a mattis, pharetra sed suspendisse integer ante sed placerat. Et sed, sodales non dui sed pellentesque. Lectus turpis harum laoreet felis massa. Sodales diam nisl laoreet lectus potenti eligendi. Hac donec donec feugiat vulputate, in sit arcu, proin mauris sit, sit nostra tempus suspendisse nibh ullamcorper. Orci placeat tellus suspendisse orci, massa dolor, ipsum dolor consectetuer. Vestibulum enim urna est quis nunc, eveniet consequat purus quis, luctus mi duis amet mauris luctus tellus. Justo vestibulum et, eros urna nec ut justo rutrum. Tortor facilisi ut etiam ultricies fringilla, condimentum id, sit lacinia eget nisl eget, urna mollit enim quis mauris est, pellentesque massa in a. Aliquam accumsan erat. Nullam nulla morbi, ornare ut lectus sem metus commodo, velit egestas semper adipiscing adipisci velit non, erat ad sed rutrum maecenas mollis, sagittis turpis. Lacus non feugiat imperdiet amet, erat mauris. Eligendi eget scelerisque elementum quis ac, ac orci sapien tellus duis aliquet, consectetuer imperdiet est ante laoreet, massa scelerisque vestibulum quis. Luctus neque in in sit, leo mollis felis non nonummy, amet sed blandit est sed amet lorem. Turpis neque vitae amet, ipsum magnis morbi ligula minus. Pellentesque facilisis voluptatem feugiat duis nam erat, in sodales sit, vitae quam sed dictum massa lacus non, vulputate dui proin maecenas varius rhoncus nec, nec at at suspendisse nisl. Auctor pellentesque in urna mauris ut, amet arcu, consectetuer mauris vel quis condimentum aliquet. Sapien turpis, odio sed quisque quam, ipsum a, qui libero praesent integer. Massa vestibulum donec praesent et risus, magna in. Posuere pellentesque. Dolor augue, sed a et neque scelerisque, ac imperdiet fringilla odio faucibus, eu malesuada. Platea natoque congue nonummy duis, lacus malesuada scelerisque, mauris in, pede amet nulla vivamus.</p>\r\n', '    ', '    '),
(20, 10, 'de', '', '<p>Terms &amp; Conditions page</p>\r\n', '   ', '   '),
(21, 13, 'en', 'Terms and Conditions for sellers', '<p>shjdtkfkyzrk</p>\r\n', '  ', '  '),
(22, 13, 'de', 'Terms and Conditions for sellers', '<p>shjdtkfkyzrk</p>\r\n', '  ', '  '),
(23, 9, 'de', 'Privacy policy', '<p>Privacy policy page</p>\r\n', '  ', '  '),
(24, 3, 'de', 'FAQ', '<p>FAQ</p>\r\n', '    ', '    ');

-- --------------------------------------------------------

--
-- Структура таблицы `pma__bookmark`
--

CREATE TABLE IF NOT EXISTS `pma__bookmark` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dbase` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `user` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `query` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `pma__central_columns`
--

CREATE TABLE IF NOT EXISTS `pma__central_columns` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_type` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_length` text COLLATE utf8_bin,
  `col_collation` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) COLLATE utf8_bin DEFAULT '',
  `col_default` text COLLATE utf8_bin,
  PRIMARY KEY (`db_name`,`col_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Структура таблицы `pma__column_info`
--

CREATE TABLE IF NOT EXISTS `pma__column_info` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `column_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `transformation` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `transformation_options` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `input_transformation` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `pma__favorite`
--

CREATE TABLE IF NOT EXISTS `pma__favorite` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `tables` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Структура таблицы `pma__history`
--

CREATE TABLE IF NOT EXISTS `pma__history` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sqlquery` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`,`db`,`table`,`timevalue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `pma__navigationhiding`
--

CREATE TABLE IF NOT EXISTS `pma__navigationhiding` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `item_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `item_type` varchar(64) COLLATE utf8_bin NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Структура таблицы `pma__pdf_pages`
--

CREATE TABLE IF NOT EXISTS `pma__pdf_pages` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `page_nr` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `page_descr` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '',
  PRIMARY KEY (`page_nr`),
  KEY `db_name` (`db_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `pma__recent`
--

CREATE TABLE IF NOT EXISTS `pma__recent` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `tables` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

--
-- Дамп данных таблицы `pma__recent`
--

INSERT INTO `pma__recent` (`username`, `tables`) VALUES
('root', '[{"db":"fashion","table":"product"}]');

-- --------------------------------------------------------

--
-- Структура таблицы `pma__relation`
--

CREATE TABLE IF NOT EXISTS `pma__relation` (
  `master_db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `master_table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `master_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  KEY `foreign_field` (`foreign_db`,`foreign_table`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Структура таблицы `pma__savedsearches`
--

CREATE TABLE IF NOT EXISTS `pma__savedsearches` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `search_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `search_data` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `pma__table_coords`
--

CREATE TABLE IF NOT EXISTS `pma__table_coords` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT '0',
  `x` float unsigned NOT NULL DEFAULT '0',
  `y` float unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Структура таблицы `pma__table_info`
--

CREATE TABLE IF NOT EXISTS `pma__table_info` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `display_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`db_name`,`table_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Структура таблицы `pma__table_uiprefs`
--

CREATE TABLE IF NOT EXISTS `pma__table_uiprefs` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `prefs` text COLLATE utf8_bin NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`username`,`db_name`,`table_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

-- --------------------------------------------------------

--
-- Структура таблицы `pma__tracking`
--

CREATE TABLE IF NOT EXISTS `pma__tracking` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `version` int(10) unsigned NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text COLLATE utf8_bin NOT NULL,
  `schema_sql` text COLLATE utf8_bin,
  `data_sql` longtext COLLATE utf8_bin,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') COLLATE utf8_bin DEFAULT NULL,
  `tracking_active` int(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`db_name`,`table_name`,`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Структура таблицы `pma__userconfig`
--

CREATE TABLE IF NOT EXISTS `pma__userconfig` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `config_data` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

-- --------------------------------------------------------

--
-- Структура таблицы `pma__usergroups`
--

CREATE TABLE IF NOT EXISTS `pma__usergroups` (
  `usergroup` varchar(64) COLLATE utf8_bin NOT NULL,
  `tab` varchar(64) COLLATE utf8_bin NOT NULL,
  `allowed` enum('Y','N') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  PRIMARY KEY (`usergroup`,`tab`,`allowed`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Структура таблицы `pma__users`
--

CREATE TABLE IF NOT EXISTS `pma__users` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `usergroup` varchar(64) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`username`,`usergroup`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Product ID',
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `size_type` int(10) unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'Product Title',
  `description` text COLLATE utf8_bin NOT NULL COMMENT 'Product Description',
  `image1` varchar(255) COLLATE utf8_bin NOT NULL,
  `image2` varchar(255) COLLATE utf8_bin NOT NULL,
  `image3` varchar(255) COLLATE utf8_bin NOT NULL,
  `image4` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `image5` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `color` varchar(20) COLLATE utf8_bin NOT NULL,
  `price` decimal(9,2) NOT NULL COMMENT 'Current Price',
  `init_price` decimal(9,2) NOT NULL COMMENT 'Initial Price',
  `item_number` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT 'Item Number',
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Added Date',
  `condition` enum('1','2','3','4') COLLATE utf8_bin NOT NULL DEFAULT '1' COMMENT 'Condition',
  `length` varchar(255) COLLATE utf8_bin NOT NULL,
  `width` varchar(255) COLLATE utf8_bin NOT NULL,
  `height` varchar(255) COLLATE utf8_bin NOT NULL,
  `depth` varchar(255) COLLATE utf8_bin NOT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `featured_order` tinyint(1) NOT NULL DEFAULT '0',
  `status` enum('active','invalid','declined','deactive') COLLATE utf8_bin NOT NULL DEFAULT 'deactive' COMMENT 'Status',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `brand_id` (`brand_id`),
  KEY `user_id` (`user_id`),
  KEY `size_type` (`size_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=59 ;

--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`id`, `user_id`, `category_id`, `brand_id`, `size_type`, `title`, `description`, `image1`, `image2`, `image3`, `image4`, `image5`, `color`, `price`, `init_price`, `item_number`, `added_date`, `condition`, `length`, `width`, `height`, `depth`, `featured`, `featured_order`, `status`) VALUES
(26, 6, 16, 1, 7, 'Modern Cotton Bikini', 'Cute and comfortable bikini. Embossed logo on smooth elastic waistband. View Full Product Details.', 'ck_1.jpg', 'ck_2.jpg', 'ck_3.jpg', NULL, NULL, 'blue', 40.00, 65.00, '10', '2015-10-28 13:30:40', '1', '', '', '', '', 0, 0, 'active'),
(27, 6, 16, 1, 7, 'Erotic Thong', 'Feel sexy in this lace thong with G-string back.', 'ck_4.jpg', 'ck_5.jpg', 'ck_6.jpg', NULL, NULL, 'maroon', 27.00, 32.00, '50', '2015-10-29 09:46:24', '1', '', '', '', '', 0, 0, 'active'),
(28, 6, 16, 1, 7, 'BLACK Evocative Thong', 'Elastic waistband hugs the body for a great fit. Beautiful semi-sheer stretch lace.', 'ck_7.jpg', 'ck_8.jpg', 'ck_9.jpg', NULL, NULL, '', 50.00, 70.00, '45', '2015-10-29 09:59:36', '1', '', '', '', '', 0, 0, 'active'),
(29, 6, 16, 2, 7, 'Merci Push Up Bra', 'The Chantelle Merci Push Up Bra is exclusive to John Lewis, designed with an everyday lace line creating a geometric look. Combining a chic foliage design resulting in a scale-like effect.', 'ch_1.jpg', 'ch_2.jpg', 'ch_3.jpg', NULL, NULL, 'purple', 20.00, 15.00, '10', '2015-10-29 10:25:41', '1', '', '', '', '', 0, 0, 'active'),
(30, 6, 16, 2, 7, 'Revelation Four Part Bra', 'A new innovative style adapted to the needs of women with larger busts, full or shallow busts: the Revelation bra from Chantelle features 4 section cups providing maximum support in a lightweight design.', 'ch_4.jpg', 'ch_5.jpg', 'ch_6.jpg', NULL, NULL, 'black', 25.00, 30.00, '10', '2015-10-29 10:36:53', '1', '', '', '', '', 0, 0, 'active'),
(31, 6, 10, 4, 7, 'Canvas Jersey T-shirt', 'This contemporary t-shirt easily brings together comfort and style. This t-shirt is made to have a worn in feel right out of the box, an easy choice for your next event.', 'cj_1.jpg', '', '', NULL, NULL, '', 15.00, 10.00, NULL, '2015-10-29 10:48:30', '1', '', '', '', '', 0, 0, 'active'),
(32, 6, 10, 4, 7, 'Canvas Jersey V-Neck T-shirt', 'This t-shirt is sure to become a group favorite! Popular v-neck version of our Canvas Jersey t-shirt. Great contemporary colors make this style a winner!', 'cj_2.jpg', '', '', NULL, NULL, 'navy', 10.00, 7.00, '30', '2015-10-29 10:54:02', '1', '', '', '', '', 0, 0, 'active'),
(33, 6, 10, 4, 7, 'Canvas Jersey Pocket T-shirt', 'This pocket t-shirt is right on trend! This comfortable, pocket t-shirt is a great choice for your next event. Trendy, popular and soft - your group is sure to love this tee!', 'cj_3.jpg', '', '', NULL, NULL, 'white', 12.00, 10.00, NULL, '2015-10-29 10:57:13', '1', '', '', '', '', 0, 0, 'active'),
(34, 6, 11, 5, 7, 'Pantherella Rib Cotton Lisle Socks', 'A proper gentlemans dress sock, classically styled and traditionally made in England using beautiful mercerised cotton, with a lovely lustre and smooth sheen, Pantherella Rib Cotton Lisle Socks have understated elegance and quality.', 'pn_1.jpg', '', '', NULL, NULL, 'violet', 5.00, 3.00, '20', '2015-10-29 11:05:39', '1', '', '', '', '', 0, 0, 'active'),
(35, 6, 11, 6, 7, 'HotSox Flower Garden Cotton', 'Whatever the weather, and wherever you might be, you can take along a little touch of the floral with you in these bright, bold HotSox Flower Garden Cotton Socks. Made from a fine, light cotton rich blend of fibres, these fully woven graphic socks come as a classic half calf length, so if you want to wear them with a suit, go right ahead!', 'hs_1.jpg', '', '', NULL, NULL, 'mixed', 5.00, 10.00, '10', '2015-10-29 11:12:26', '1', '', '', '', '', 0, 0, 'active'),
(37, 6, 12, 7, 7, 'BURBERRY BE2073', 'The first name in British fashion, Burberry® eyewear leverages the strength of its 150-year heritage, balancing classic and modern design.', 'br_1.jpg', '', '', NULL, NULL, '', 300.00, 349.00, '20', '2015-10-29 11:25:44', '1', '', '', '', '', 0, 0, 'active'),
(38, 6, 12, 8, 7, 'OAKLEY CROSSLINK', 'Oakley® Crosslink™ is a new category of ophthalmic frames with a true crossover design that lets you go from work to play without missing a beat. Crosslink™ has the performance you need if sports and fitness are part of your week.', 'oa_1.jpg', '', '', NULL, NULL, 'blue', 250.00, 279.00, '100', '2015-10-29 11:30:17', '1', '', '', '', '', 0, 0, 'active'),
(39, 6, 13, 9, 7, 'Long Strapless Sweetheart Blush', 'Floor length strapless sweetheart prom dress by Blush with an embellished bodice.', 'bl_1.jpg', '', '', NULL, NULL, 'pink', 100.00, 120.00, NULL, '2015-10-29 11:40:17', '1', '', '', '', '', 0, 0, 'active'),
(40, 6, 13, 9, 7, 'Blush Aqua Fit and Flare Gold Lace Party Dress', 'This Blush fit and flare party dress features a flowy aqua blue chiffon skirt and a slim fitting embroidered gold lace bodice. The sexy back of this cocktail dress lets you show off some skin with a racer back design and seductive cutouts on the sheer fabric. A short gold lace dress that has a style that is sassy and chic, perfect for homecoming, holiday parties, or any special occasion.', 'bl_2.jpg', '', '', NULL, NULL, 'gold', 170.00, 200.00, '40', '2015-10-29 11:44:58', '1', '', '', '', '', 0, 0, 'active'),
(41, 6, 14, 10, 7, 'Navy ribbed and flared skirt', 'Lightweight, ribbed woven Faux leather waistband with elasticized smocking at back; exposed rear zip closure Zip-close angled front pockets Flared skirt Contemporary fit Full slip lining.', 'gr_1.jpg', '', '', NULL, NULL, 'navy', 100.00, 150.00, '45', '2015-10-29 11:55:06', '1', '', '', '', '', 0, 0, 'active'),
(42, 6, 14, 11, 7, 'black and white stripe print pleated midi skirt', 'Lightweight stretch woven Concealed rear zip closure Allover stripe print; box pleated design Flared cut; contemporary fit Self lined.', 'wt_1.jpg', '', '', NULL, NULL, 'black', 80.00, 100.00, '5', '2015-10-29 12:01:11', '1', '', '', '', '', 0, 0, 'active'),
(43, 6, 17, 12, 7, 'medium blue micro checkered silk tie', 'Lightweight silk woven Allover micro checkered pattern Silk twill lining Measures approximately 3¼ at widest point 100% Silk; Dry Clean; Italy;', 'er_1.jpg', '', '', NULL, NULL, 'blue', 50.00, 60.00, '20', '2015-10-29 12:09:07', '1', '', '', '', '', 0, 0, 'active'),
(44, 6, 17, 13, 7, 'grey and light blue diagonal stripe patterned silk tie', '100% Silk, Dry Clean, Italy.', 'ar_1.jpg', '', '', NULL, NULL, 'light blue', 50.00, 60.00, '10', '2015-10-29 12:16:04', '1', '', '', '', '', 0, 0, 'active'),
(45, 6, 17, 13, 7, 'Grey geometric dot pattern silk tie', 'Lightweight silk woven Geometric oval and dot pattern allover Logo jacquard silk lining.', 'ar_2.jpg', '', '', NULL, NULL, 'grey', 20.00, 30.00, '5', '2015-10-29 12:18:53', '1', '', '', '', '', 0, 0, 'active'),
(48, 6, 18, 14, 7, 'Homme grey slim fit trousers', 'Model is 6 foot 1 and wears a 32R, 100% Cotton, Machine Washable.', 'hg_1.jpg', '', '', NULL, NULL, 'grey', 100.00, 120.00, '50', '2015-10-29 12:34:00', '1', '', '', '', '', 0, 0, 'active'),
(49, 6, 18, 14, 7, 'Selected homme black tailored trousers', 'Model is 6 foot 1 and wears a 32R, 100% cotton, machine washable.', 'hg_2.jpg', '', '', NULL, NULL, 'black', 70.00, 100.00, '20', '2015-10-29 12:39:34', '1', '', '', '', '', 0, 0, 'active'),
(50, 6, 19, 15, 7, 'CLYDE SHAWL Style 7M50395 ', 'Machine Wash Cold, With Like Colors, Non-Chlorine Bleach, Tumble Dry Low, Cool Iron.', 'cs_1.jpg', '', '', NULL, NULL, 'maroon', 50.00, 70.00, '10', '2015-10-29 12:49:36', '1', '', '', '', '', 0, 0, 'active'),
(51, 6, 20, 16, 7, 'Trim Scarf', 'The perfect scarf to compliment any outfit over the cooler months. Featuring an all over print and cute little tassels.', 'sc_1.jpg', '', '', NULL, NULL, 'blue', 20.00, 25.00, '10', '2015-10-29 12:55:48', '1', '', '', '', '', 0, 0, 'active'),
(52, 6, 21, 17, 7, 'Children Magic Gloves', 'Mittens Girl Boy Kid Stretchy Knitted Winter Warm New.', 'gl_1.jpg', '', '', NULL, NULL, 'red', 10.00, 12.00, '10', '2015-10-29 13:03:52', '1', '', '', '', '', 0, 0, 'active'),
(58, 41, 10, 4, 394, 'Test 700', 'Description', '14247604687185.png', '1447267439_889154460.jpg', '1434895980_788018054.jpg', NULL, NULL, 'green', 15.00, 15.00, NULL, '2016-03-12 20:45:59', '', '', '', '', '', 0, 0, 'deactive');

-- --------------------------------------------------------

--
-- Структура таблицы `product_attribute`
--

CREATE TABLE IF NOT EXISTS `product_attribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `value` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `attribute_id` (`attribute_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `product_invalid`
--

CREATE TABLE IF NOT EXISTS `product_invalid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `field_alias` varchar(255) COLLATE utf8_bin NOT NULL,
  `value` varchar(255) COLLATE utf8_bin NOT NULL,
  `comment` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `quickbooks_auth`
--

CREATE TABLE IF NOT EXISTS `quickbooks_auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `access_token` varchar(255) COLLATE utf8_bin NOT NULL,
  `access_token_secret` varchar(255) COLLATE utf8_bin NOT NULL,
  `realm_id` bigint(20) NOT NULL,
  `service_type` varchar(255) COLLATE utf8_bin NOT NULL,
  `added_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `quickbooks_auth`
--

INSERT INTO `quickbooks_auth` (`id`, `access_token`, `access_token_secret`, `realm_id`, `service_type`, `added_date`) VALUES
(3, 'qyprdO4Pdj30GnK2D2zTdYrAZrQOTHHrP2DHx1Xy6L6TpIcb', '30NQ4WBMR8qO1EHujBwlMsamqJ8uFJI9ClYHsGE3', 123145719560442, 'QBO', '2016-02-26');

-- --------------------------------------------------------

--
-- Структура таблицы `rating`
--

CREATE TABLE IF NOT EXISTS `rating` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `communication` tinyint(1) unsigned NOT NULL,
  `description` tinyint(1) unsigned NOT NULL,
  `shipment` tinyint(3) unsigned NOT NULL,
  `total` decimal(3,2) NOT NULL,
  `comment` varchar(255) COLLATE utf8_bin NOT NULL,
  `response` varchar(255) COLLATE utf8_bin NOT NULL,
  `comment_status` enum('published','banned') COLLATE utf8_bin NOT NULL DEFAULT 'published',
  `response_status` enum('published','banned') COLLATE utf8_bin NOT NULL DEFAULT 'published',
  `added_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `user_id` (`user_id`),
  KEY `seller_id` (`seller_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `seller_profile`
--

CREATE TABLE IF NOT EXISTS `seller_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `seller_type` enum('business','private') COLLATE utf8_bin NOT NULL DEFAULT 'private',
  `comission_rate` decimal(2,2) NOT NULL,
  `paypal_email` varchar(255) COLLATE utf8_bin NOT NULL,
  `rating` decimal(3,2) NOT NULL DEFAULT '0.00',
  `billing_address` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `billing_address2` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `billing_city` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `billing_state` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `billing_zip` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `billing_country_id` int(11) NOT NULL DEFAULT '1',
  `billing_first_name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `billing_surname` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `bank_first_name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `bank_surname` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `bank_iban` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `bank_swift_bik` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `billing_country_id` (`billing_country_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `seller_profile`
--

INSERT INTO `seller_profile` (`id`, `user_id`, `seller_type`, `comission_rate`, `paypal_email`, `rating`, `billing_address`, `billing_address2`, `billing_city`, `billing_state`, `billing_zip`, `billing_country_id`, `billing_first_name`, `billing_surname`, `bank_first_name`, `bank_surname`, `bank_iban`, `bank_swift_bik`) VALUES
(4, 6, 'private', 0.20, 'asd@zdas.sdf', 0.00, '', '', '', '', '', 1, '', '', '', '', '', ''),
(5, 22, 'private', 0.23, 'user123@user.123', 0.00, '', '', '', '', '', 1, '', '', '', '', '', ''),
(7, 25, 'private', 0.15, 'test3@test.com', 0.00, '', '', '', '', '', 1, '', '', '', '', '', ''),
(8, 41, '', 0.30, 'is5157@mail.ru', 0.00, '', '', '', '', '', 1, '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `shipping_address`
--

CREATE TABLE IF NOT EXISTS `shipping_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `address` varchar(255) COLLATE utf8_bin NOT NULL,
  `address_2` varchar(255) COLLATE utf8_bin NOT NULL,
  `city` varchar(255) COLLATE utf8_bin NOT NULL,
  `state` varchar(255) COLLATE utf8_bin NOT NULL,
  `zip` varchar(20) COLLATE utf8_bin NOT NULL,
  `country_id` int(11) NOT NULL,
  `last_used` tinyint(1) NOT NULL DEFAULT '0',
  `first_name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `surname` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `country_id` (`country_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `shipping_address`
--

INSERT INTO `shipping_address` (`id`, `user_id`, `address`, `address_2`, `city`, `state`, `zip`, `country_id`, `last_used`, `first_name`, `surname`) VALUES
(2, 19, 'buyer, buyer 1/1', 'buyer buyer 34', 'moscow', 'singapore', '20098', 9, 0, '', ''),
(3, 19, 'n,jn,j67', 'bhjghj 666', 'hukgyg', 'gbjhkghfh', '67896', 12, 1, '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `shipping_coupon`
--

CREATE TABLE IF NOT EXISTS `shipping_coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(255) COLLATE utf8_bin NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `shipping_rate`
--

CREATE TABLE IF NOT EXISTS `shipping_rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `seller_country_id` int(11) NOT NULL,
  `buyer_country_id` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `seller_country_id` (`seller_country_id`),
  KEY `buyer_country_id` (`buyer_country_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Дамп данных таблицы `shipping_rate`
--

INSERT INTO `shipping_rate` (`id`, `seller_country_id`, `buyer_country_id`, `rate`) VALUES
(1, 81, 81, 10),
(2, 81, 181, 20),
(4, 81, 231, 15),
(5, 81, 232, 20),
(6, 81, 74, 15),
(7, 81, 108, 15),
(8, 81, 15, 15),
(9, 81, 22, 15),
(10, 81, 34, 15),
(11, 81, 59, 15),
(12, 81, 73, 15),
(13, 81, 84, 15),
(14, 81, 105, 15),
(15, 81, 127, 15),
(16, 81, 154, 15),
(18, 81, 176, 15),
(19, 81, 211, 15),
(20, 81, 199, 15),
(22, 81, 58, 15),
(23, 81, 107, 20);

-- --------------------------------------------------------

--
-- Структура таблицы `shipping_rate_default`
--

CREATE TABLE IF NOT EXISTS `shipping_rate_default` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `shipping_rate_default`
--

INSERT INTO `shipping_rate_default` (`id`, `country_id`, `rate`) VALUES
(1, 181, 20),
(2, 231, 10);

-- --------------------------------------------------------

--
-- Структура таблицы `size`
--

CREATE TABLE IF NOT EXISTS `size` (
  `id` int(11) NOT NULL,
  `size_type_id` int(11) NOT NULL,
  `country` varchar(20) COLLATE utf8_bin NOT NULL,
  `size` varchar(20) COLLATE utf8_bin NOT NULL,
  `gender` enum('M','W') COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `size_type` (`size_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `size`
--

INSERT INTO `size` (`id`, `size_type_id`, `country`, `size`, `gender`) VALUES
(1, 1, 'International', 'XXXS', 'M'),
(2, 1, 'International', 'XXS', 'M'),
(3, 1, 'International', 'XS', 'M'),
(4, 1, 'International', 'S', 'M'),
(5, 1, 'International', 'L', 'M'),
(6, 1, 'International', 'XL', 'M'),
(7, 1, 'International', 'XXL', 'M'),
(8, 1, 'International', 'XXXL', 'M'),
(9, 1, 'UK', '30', 'M'),
(10, 1, 'UK', '32', 'M'),
(11, 1, 'UK', '34', 'M'),
(12, 1, 'UK', '36', 'M'),
(13, 1, 'UK', '38', 'M'),
(14, 1, 'UK', '40', 'M'),
(15, 1, 'UK', '42', 'M'),
(16, 1, 'UK', '44', 'M'),
(17, 1, 'UK', '46', 'M'),
(18, 1, 'US', '34', 'M'),
(19, 1, 'US', '36', 'M'),
(20, 1, 'US', '38', 'M'),
(21, 1, 'US', '40', 'M'),
(22, 1, 'US', '42', 'M'),
(23, 1, 'US', '44', 'M'),
(24, 1, 'US', '46', 'M'),
(25, 1, 'EU', '38', 'M'),
(26, 1, 'EU', '40', 'M'),
(27, 1, 'EU', '42', 'M'),
(28, 1, 'EU', '44', 'M'),
(29, 1, 'EU', '46', 'M'),
(30, 1, 'EU', '48', 'M'),
(31, 1, 'IT', '42', 'M'),
(32, 1, 'IT', '44', 'M'),
(33, 1, 'IT', '46', 'M'),
(34, 1, 'IT', '48', 'M'),
(35, 1, 'IT', '50', 'M'),
(36, 1, 'IT', '52', 'M'),
(37, 1, 'IT', '54', 'M'),
(38, 1, 'IT', '56', 'M'),
(39, 1, 'RUS', '44', 'M'),
(40, 1, 'RUS', '46', 'M'),
(41, 1, 'RUS', '48', 'M'),
(42, 1, 'RUS', '50', 'M'),
(43, 1, 'RUS', '52', 'M'),
(44, 1, 'RUS', '54', 'M'),
(45, 1, 'RUS', '56', 'M'),
(46, 1, 'RUS', '58', 'M'),
(47, 2, 'International', 'S', 'M'),
(48, 2, 'International', 'M', 'M'),
(49, 2, 'International', 'L', 'M'),
(50, 2, 'International', 'XL', 'M'),
(51, 2, 'International', 'XXL', 'M'),
(52, 2, 'International', 'XXXL', 'M'),
(53, 2, 'UK', '30', 'M'),
(54, 2, 'UK', '32', 'M'),
(55, 2, 'UK', '34', 'M'),
(56, 2, 'UK', '36', 'M'),
(57, 2, 'UK', '38', 'M'),
(58, 2, 'UK', '40', 'M'),
(59, 2, 'UK', '42', 'M'),
(60, 2, 'UK', '44', 'M'),
(61, 2, 'UK', '46', 'M'),
(62, 2, 'US', '34', 'M'),
(63, 2, 'US', '36', 'M'),
(64, 2, 'US', '38', 'M'),
(65, 2, 'US', '40', 'M'),
(66, 2, 'US', '42', 'M'),
(67, 2, 'US', '44', 'M'),
(68, 2, 'US', '46', 'M'),
(69, 2, 'US', '48', 'M'),
(70, 2, 'EU', '38', 'M'),
(71, 2, 'EU', '40', 'M'),
(72, 2, 'EU', '42', 'M'),
(73, 2, 'EU', '44', 'M'),
(74, 2, 'EU', '46', 'M'),
(75, 2, 'EU', '48', 'M'),
(76, 2, 'EU', '50', 'M'),
(77, 2, 'EU', '52', 'M'),
(78, 2, 'IT', '42', 'M'),
(79, 2, 'IT', '44', 'M'),
(80, 2, 'IT', '46', 'M'),
(81, 2, 'IT', '48', 'M'),
(82, 2, 'IT', '50', 'M'),
(83, 2, 'IT', '52', 'M'),
(84, 2, 'IT', '54', 'M'),
(85, 2, 'IT', '56', 'M'),
(86, 2, 'RUS', '44', 'M'),
(87, 2, 'RUS', '46', 'M'),
(88, 2, 'RUS', '48', 'M'),
(89, 2, 'RUS', '50', 'M'),
(90, 2, 'RUS', '52', 'M'),
(91, 2, 'RUS', '54', 'M'),
(92, 2, 'RUS', '56', 'M'),
(93, 2, 'RUS', '58', 'M'),
(94, 3, 'International', 'XXXS', 'M'),
(95, 3, 'International', 'XXS', 'M'),
(96, 3, 'International', 'XS', 'M'),
(97, 3, 'International', 'S', 'M'),
(98, 3, 'International', 'M', 'M'),
(99, 3, 'International', 'L', 'M'),
(100, 3, 'International', 'XL', 'M'),
(101, 3, 'International', 'XXL', 'M'),
(102, 3, 'International', 'XXXL', 'M'),
(103, 3, 'Inches', '24', 'M'),
(104, 3, 'Inches', '26', 'M'),
(105, 3, 'Inches', '28', 'M'),
(106, 3, 'Inches', '30', 'M'),
(107, 3, 'Inches', '32', 'M'),
(108, 3, 'Inches', '34', 'M'),
(109, 3, 'Inches', '36', 'M'),
(110, 3, 'Inches', '38', 'M'),
(111, 3, 'Inches', '40', 'M'),
(112, 3, 'US', '2', 'M'),
(113, 3, 'US', '4', 'M'),
(114, 3, 'US', '6', 'M'),
(115, 3, 'US', '8', 'M'),
(116, 3, 'US', '10', 'M'),
(117, 3, 'US', '12', 'M'),
(118, 3, 'US', '14', 'M'),
(119, 3, 'US', '16', 'M'),
(120, 3, 'US', '18', 'M'),
(121, 4, 'International', 'S', 'M'),
(122, 4, 'International', 'M', 'M'),
(123, 4, 'International', 'One Size', 'M'),
(124, 5, 'International', 'XXXS', 'M'),
(125, 5, 'International', 'XXS', 'M'),
(126, 5, 'International', 'XS', 'M'),
(127, 5, 'International', 'S', 'M'),
(128, 5, 'International', 'M', 'M'),
(129, 5, 'International', 'L', 'M'),
(130, 5, 'International', 'XL', 'M'),
(131, 5, 'International', 'XXL', 'M'),
(132, 5, 'International', 'XXXL', 'M'),
(133, 5, 'UK', '32', 'M'),
(134, 5, 'UK', '34', 'M'),
(135, 5, 'UK', '36', 'M'),
(136, 5, 'UK', '38', 'M'),
(137, 5, 'UK', '40', 'M'),
(138, 5, 'UK', '42', 'M'),
(139, 5, 'UK', '44', 'M'),
(140, 5, 'UK', '46', 'M'),
(141, 5, 'US', '34', 'M'),
(142, 5, 'US', '36', 'M'),
(143, 5, 'US', '38', 'M'),
(144, 5, 'US', '40', 'M'),
(145, 5, 'US', '42', 'M'),
(146, 5, 'US', '44', 'M'),
(147, 5, 'US', '46', 'M'),
(148, 5, 'US', '48', 'M'),
(149, 5, 'EU', '38', 'M'),
(150, 5, 'EU', '40', 'M'),
(151, 5, 'EU', '42', 'M'),
(152, 5, 'EU', '44', 'M'),
(153, 5, 'EU', '46', 'M'),
(154, 5, 'EU', '48', 'M'),
(155, 5, 'EU', '50', 'M'),
(156, 5, 'EU', '52', 'M'),
(157, 5, 'IT', '42', 'M'),
(158, 5, 'IT', '44', 'M'),
(159, 5, 'IT', '46', 'M'),
(160, 5, 'IT', '48', 'M'),
(161, 5, 'IT', '50', 'M'),
(162, 5, 'IT', '52', 'M'),
(163, 5, 'IT', '54', 'M'),
(164, 5, 'IT', '56', 'M'),
(165, 5, 'RUS', '44', 'M'),
(166, 5, 'RUS', '46', 'M'),
(167, 5, 'RUS', '48', 'M'),
(168, 5, 'RUS', '50', 'M'),
(169, 5, 'RUS', '52', 'M'),
(170, 5, 'RUS', '54', 'M'),
(171, 5, 'RUS', '56', 'M'),
(172, 5, 'RUS', '58', 'M'),
(173, 6, 'UK', '3', 'M'),
(174, 6, 'UK', '4', 'M'),
(175, 6, 'UK', '5', 'M'),
(176, 6, 'UK', '6', 'M'),
(177, 6, 'UK', '7', 'M'),
(178, 6, 'UK', '7.5', 'M'),
(179, 6, 'UK', '8', 'M'),
(180, 6, 'UK', '8.5', 'M'),
(181, 6, 'UK', '9', 'M'),
(182, 6, 'UK', '9.5', 'M'),
(183, 6, 'UK', '10', 'M'),
(184, 6, 'UK', '10.5', 'M'),
(185, 6, 'UK', '11', 'M'),
(186, 6, 'UK', '12', 'M'),
(187, 6, 'UK', '13', 'M'),
(188, 6, 'UK', '14', 'M'),
(189, 6, 'EU', '35.5', 'M'),
(190, 6, 'EU', '37', 'M'),
(191, 6, 'EU', '38', 'M'),
(192, 6, 'EU', '39', 'M'),
(193, 6, 'EU', '40.5', 'M'),
(194, 6, 'EU', '41', 'M'),
(195, 6, 'EU', '42', 'M'),
(196, 6, 'EU', '42.5', 'M'),
(197, 6, 'EU', '43', 'M'),
(198, 6, 'EU', '44', 'M'),
(199, 6, 'EU', '44.5', 'M'),
(200, 6, 'EU', '45', 'M'),
(201, 6, 'EU', '46', 'M'),
(202, 6, 'EU', '47', 'M'),
(203, 6, 'EU', '48', 'M'),
(204, 6, 'EU', '49.5', 'M'),
(205, 6, 'US', '4', 'M'),
(206, 6, 'US', '5', 'M'),
(207, 6, 'US', '6', 'M'),
(208, 6, 'US', '7', 'M'),
(209, 6, 'US', '8', 'M'),
(210, 6, 'US', '8.5', 'M'),
(211, 6, 'US', '9', 'M'),
(212, 6, 'US', '9.5', 'M'),
(213, 6, 'US', '10', 'M'),
(214, 6, 'US', '10.5', 'M'),
(215, 6, 'US', '11', 'M'),
(216, 6, 'US', '11.5', 'M'),
(217, 6, 'US', '12', 'M'),
(218, 6, 'US', '13', 'M'),
(219, 6, 'US', '14', 'M'),
(220, 6, 'US', '15', 'M'),
(221, 1, 'International', 'M', 'M'),
(222, 7, 'International', 'XXXS', 'M'),
(223, 7, 'International', 'XXS', 'M'),
(224, 7, 'International', 'XS', 'M'),
(225, 7, 'International', 'S', 'M'),
(226, 7, 'International', 'M', 'M'),
(227, 7, 'International', 'L', 'M'),
(228, 7, 'International', 'XL', 'M'),
(229, 7, 'International', 'XXL', 'M'),
(230, 7, 'International', 'XXXL', 'M'),
(231, 7, 'UK', '32', 'M'),
(232, 7, 'UK', '34', 'M'),
(233, 7, 'UK', '36', 'M'),
(234, 7, 'UK', '38', 'M'),
(235, 7, 'UK', '40', 'M'),
(236, 7, 'UK', '42', 'M'),
(237, 7, 'UK', '44', 'M'),
(238, 7, 'UK', '46', 'M'),
(239, 7, 'US', '34', 'M'),
(240, 7, 'US', '36', 'M'),
(241, 7, 'US', '38', 'M'),
(242, 7, 'US', '40', 'M'),
(243, 7, 'US', '42', 'M'),
(244, 7, 'US', '44', 'M'),
(245, 7, 'US', '46', 'M'),
(246, 7, 'US', '48', 'M'),
(247, 7, 'EU', '38', 'M'),
(248, 7, 'EU', '40', 'M'),
(249, 7, 'EU', '42', 'M'),
(250, 7, 'EU', '44', 'M'),
(251, 7, 'EU', '46', 'M'),
(252, 7, 'EU', '48', 'M'),
(253, 7, 'EU', '50', 'M'),
(254, 7, 'EU', '52', 'M'),
(255, 7, 'IT', '42', 'M'),
(256, 7, 'IT', '44', 'M'),
(257, 7, 'IT', '46', 'M'),
(258, 7, 'IT', '48', 'M'),
(259, 7, 'IT', '50', 'M'),
(260, 7, 'IT', '52', 'M'),
(261, 7, 'IT', '54', 'M'),
(262, 7, 'IT', '56', 'M'),
(263, 7, 'RUS', '44', 'M'),
(264, 7, 'RUS', '46', 'M'),
(265, 7, 'RUS', '48', 'M'),
(266, 7, 'RUS', '50', 'M'),
(267, 7, 'RUS', '52', 'M'),
(268, 7, 'RUS', '54', 'M'),
(269, 7, 'RUS', '56', 'M'),
(270, 7, 'RUS', '58', 'M'),
(271, 8, 'International', 'XXXS', 'M'),
(272, 8, 'International', 'XXS', 'M'),
(273, 8, 'International', 'XS', 'M'),
(274, 8, 'International', 'S', 'M'),
(275, 8, 'International', 'M', 'M'),
(276, 8, 'International', 'L', 'M'),
(277, 8, 'International', 'XL', 'M'),
(278, 8, 'International', 'XXL', 'M'),
(279, 8, 'International', 'XXXL', 'M'),
(280, 8, 'UK', '32', 'M'),
(281, 8, 'UK', '34', 'M'),
(282, 8, 'UK', '36', 'M'),
(283, 8, 'UK', '38', 'M'),
(284, 8, 'UK', '40', 'M'),
(285, 8, 'UK', '42', 'M'),
(286, 8, 'UK', '44', 'M'),
(287, 8, 'UK', '46', 'M'),
(288, 8, 'US', '34', 'M'),
(289, 8, 'US', '36', 'M'),
(290, 8, 'US', '38', 'M'),
(291, 8, 'US', '40', 'M'),
(292, 8, 'US', '42', 'M'),
(293, 8, 'US', '44', 'M'),
(294, 8, 'US', '46', 'M'),
(295, 8, 'US', '48', 'M'),
(296, 8, 'EU', '38', 'M'),
(297, 8, 'EU', '40', 'M'),
(298, 8, 'EU', '42', 'M'),
(299, 8, 'EU', '44', 'M'),
(300, 8, 'EU', '46', 'M'),
(301, 8, 'EU', '48', 'M'),
(302, 8, 'EU', '50', 'M'),
(303, 8, 'EU', '52', 'M'),
(304, 8, 'IT', '42', 'M'),
(305, 8, 'IT', '44', 'M'),
(306, 8, 'IT', '46', 'M'),
(307, 8, 'IT', '48', 'M'),
(308, 8, 'IT', '50', 'M'),
(309, 8, 'IT', '52', 'M'),
(310, 8, 'IT', '54', 'M'),
(311, 8, 'IT', '56', 'M'),
(312, 8, 'RUS', '44', 'M'),
(313, 8, 'RUS', '46', 'M'),
(314, 8, 'RUS', '48', 'M'),
(315, 8, 'RUS', '50', 'M'),
(316, 8, 'RUS', '52', 'M'),
(317, 8, 'RUS', '54', 'M'),
(318, 8, 'RUS', '56', 'M'),
(319, 8, 'RUS', '58', 'M'),
(320, 9, 'International', 'XXXS', 'M'),
(321, 9, 'International', 'XXS', 'M'),
(322, 9, 'International', 'XS', 'M'),
(323, 9, 'International', 'S', 'M'),
(324, 9, 'International', 'M', 'M'),
(325, 9, 'International', 'L', 'M'),
(326, 9, 'International', 'XL', 'M'),
(327, 9, 'International', 'XXL', 'M'),
(328, 9, 'International', 'XXXL', 'M'),
(329, 9, 'UK', '32', 'M'),
(330, 9, 'UK', '34', 'M'),
(331, 9, 'UK', '36', 'M'),
(332, 9, 'UK', '38', 'M'),
(333, 9, 'UK', '40', 'M'),
(334, 9, 'UK', '42', 'M'),
(335, 9, 'UK', '44', 'M'),
(336, 9, 'UK', '46', 'M'),
(337, 9, 'US', '34', 'M'),
(338, 9, 'US', '36', 'M'),
(339, 9, 'US', '38', 'M'),
(340, 9, 'US', '40', 'M'),
(341, 9, 'US', '42', 'M'),
(342, 9, 'US', '44', 'M'),
(343, 9, 'US', '46', 'M'),
(344, 9, 'US', '48', 'M'),
(345, 9, 'EU', '38', 'M'),
(346, 9, 'EU', '40', 'M'),
(347, 9, 'EU', '42', 'M'),
(348, 9, 'EU', '44', 'M'),
(349, 9, 'EU', '46', 'M'),
(350, 9, 'EU', '48', 'M'),
(351, 9, 'EU', '50', 'M'),
(352, 9, 'EU', '52', 'M'),
(353, 9, 'IT', '42', 'M'),
(354, 9, 'IT', '44', 'M'),
(355, 9, 'IT', '46', 'M'),
(356, 9, 'IT', '48', 'M'),
(357, 9, 'IT', '50', 'M'),
(358, 9, 'IT', '52', 'M'),
(359, 9, 'IT', '54', 'M'),
(360, 9, 'IT', '56', 'M'),
(361, 9, 'RUS', '44', 'M'),
(362, 9, 'RUS', '46', 'M'),
(363, 9, 'RUS', '48', 'M'),
(364, 9, 'RUS', '50', 'M'),
(365, 9, 'RUS', '52', 'M'),
(366, 9, 'RUS', '54', 'M'),
(367, 9, 'RUS', '56', 'M'),
(368, 9, 'RUS', '58', 'M'),
(369, 10, 'International', 'XXXS', 'M'),
(370, 10, 'International', 'XXS', 'M'),
(371, 10, 'International', 'XS', 'M'),
(372, 10, 'International', 'S', 'M'),
(373, 10, 'International', 'M', 'M'),
(374, 10, 'International', 'L', 'M'),
(375, 10, 'International', 'XL', 'M'),
(376, 10, 'International', 'XXL', 'M'),
(377, 10, 'International', 'XXXL', 'M'),
(378, 10, 'Inches', '24', 'M'),
(379, 10, 'Inches', '26', 'M'),
(380, 10, 'Inches', '28', 'M'),
(381, 10, 'Inches', '30', 'M'),
(382, 10, 'Inches', '32', 'M'),
(383, 10, 'Inches', '34', 'M'),
(384, 10, 'Inches', '36', 'M'),
(385, 10, 'Inches', '38', 'M'),
(386, 10, 'Inches', '40', 'M'),
(387, 10, 'US', '2', 'M'),
(388, 10, 'US', '4', 'M'),
(389, 10, 'US', '6', 'M'),
(390, 10, 'US', '8', 'M'),
(391, 10, 'US', '10', 'M'),
(392, 10, 'US', '12', 'M'),
(393, 10, 'US', '14', 'M'),
(394, 10, 'US', '16', 'M'),
(395, 10, 'US', '18', 'M'),
(396, 10, 'US', '20', 'M'),
(397, 2, 'International', 'XXXS', 'M'),
(398, 2, 'International', 'XXS', 'M'),
(399, 2, 'International', 'XS', 'M'),
(400, 11, 'International', 'XXXS', 'M'),
(401, 11, 'International', 'XXS', 'M'),
(402, 11, 'International', 'XS', 'M'),
(403, 11, 'International', 'S', 'M'),
(404, 11, 'International', 'M', 'M'),
(405, 11, 'International', 'L', 'M'),
(406, 11, 'International', 'XL', 'M'),
(407, 11, 'International', 'XXL', 'M'),
(408, 11, 'International', 'XXXL', 'M'),
(409, 11, 'UK', '30', 'M'),
(410, 11, 'UK', '32', 'M'),
(411, 11, 'UK', '34', 'M'),
(412, 11, 'UK', '36', 'M'),
(413, 11, 'UK', '38', 'M'),
(414, 11, 'UK', '40', 'M'),
(415, 11, 'UK', '42', 'M'),
(416, 11, 'UK', '44', 'M'),
(417, 11, 'UK', '46', 'M'),
(418, 11, 'US', '34', 'M'),
(419, 11, 'US', '36', 'M'),
(420, 11, 'US', '38', 'M'),
(421, 11, 'US', '40', 'M'),
(422, 11, 'US', '42', 'M'),
(423, 11, 'US', '44', 'M'),
(424, 11, 'US', '46', 'M'),
(425, 11, 'US', '48', 'M'),
(426, 11, 'EU', '38', 'M'),
(427, 11, 'EU', '40', 'M'),
(428, 11, 'EU', '42', 'M'),
(429, 11, 'EU', '44', 'M'),
(430, 11, 'EU', '46', 'M'),
(431, 11, 'EU', '48', 'M'),
(432, 11, 'EU', '50', 'M'),
(433, 11, 'EU', '52', 'M'),
(434, 11, 'IT', '42', 'M'),
(435, 11, 'IT', '44', 'M'),
(436, 11, 'IT', '46', 'M'),
(437, 11, 'IT', '48', 'M'),
(438, 11, 'IT', '50', 'M'),
(439, 11, 'IT', '52', 'M'),
(440, 11, 'IT', '54', 'M'),
(441, 11, 'IT', '56', 'M'),
(442, 11, 'RUS', '44', 'M'),
(443, 11, 'RUS', '46', 'M'),
(444, 11, 'RUS', '48', 'M'),
(445, 11, 'RUS', '50', 'M'),
(446, 11, 'RUS', '52', 'M'),
(447, 11, 'RUS', '54', 'M'),
(448, 11, 'RUS', '56', 'M'),
(449, 11, 'RUS', '58', 'M'),
(450, 12, 'International', 'XXS', 'M'),
(451, 12, 'International', 'XS', 'M'),
(452, 12, 'International', 'S', 'M'),
(453, 12, 'International', 'M', 'M'),
(454, 12, 'International', 'L', 'M'),
(455, 12, 'International', 'XL', 'M'),
(456, 12, 'International', 'XXL', 'M'),
(457, 12, 'Inches', '26', 'M'),
(458, 12, 'Inches', '27', 'M'),
(459, 12, 'Inches', '28', 'M'),
(460, 12, 'Inches', '29', 'M'),
(461, 12, 'Inches', '30', 'M'),
(462, 12, 'Inches', '31', 'M'),
(463, 12, 'Inches', '32', 'M'),
(464, 12, 'Inches', '33', 'M'),
(465, 12, 'Inches', '34', 'M'),
(466, 12, 'Inches', '35', 'M'),
(467, 12, 'Inches', '36', 'M'),
(468, 12, 'Inches', '37', 'M'),
(469, 12, 'Inches', '38', 'M'),
(470, 12, 'Inches', '39', 'M'),
(471, 12, 'Inches', '40', 'M'),
(472, 12, 'Inches', '41', 'M'),
(473, 12, 'Inches', '42', 'M'),
(474, 12, 'Inches', '43', 'M'),
(475, 12, 'Inches', '44', 'M'),
(476, 12, 'Inches', '45', 'M'),
(477, 12, 'Inches', '46', 'M'),
(478, 12, 'Inches', '47', 'M'),
(479, 12, 'Inches', '48', 'M'),
(480, 12, 'Inches', '49', 'M'),
(481, 12, 'Inches', '50', 'M'),
(482, 13, 'International', 'XXXS', 'M'),
(483, 13, 'International', 'XXS', 'M'),
(484, 13, 'International', 'XS', 'M'),
(485, 13, 'International', 'S', 'M'),
(486, 13, 'International', 'M', 'M'),
(487, 13, 'International', 'L', 'M'),
(488, 13, 'International', 'XL', 'M'),
(489, 13, 'International', 'XXL', 'M'),
(490, 13, 'International', 'XXXL', 'M'),
(491, 13, 'UK', '32', 'M'),
(492, 13, 'UK', '34', 'M'),
(493, 13, 'UK', '36', 'M'),
(494, 13, 'UK', '38', 'M'),
(495, 13, 'UK', '40', 'M'),
(496, 13, 'UK', '42', 'M'),
(497, 13, 'UK', '44', 'M'),
(498, 13, 'UK', '46', 'M'),
(499, 13, 'US', '34', 'M'),
(500, 13, 'US', '36', 'M'),
(501, 13, 'US', '38', 'M'),
(502, 13, 'US', '40', 'M'),
(503, 13, 'US', '42', 'M'),
(504, 13, 'US', '44', 'M'),
(505, 13, 'US', '46', 'M'),
(506, 13, 'US', '48', 'M'),
(507, 13, 'EU', '38', 'M'),
(508, 13, 'EU', '40', 'M'),
(509, 13, 'EU', '42', 'M'),
(510, 13, 'EU', '44', 'M'),
(511, 13, 'EU', '46', 'M'),
(512, 13, 'EU', '48', 'M'),
(513, 13, 'EU', '50', 'M'),
(514, 13, 'EU', '52', 'M'),
(515, 13, 'IT', '42', 'M'),
(516, 13, 'IT', '44', 'M'),
(517, 13, 'IT', '46', 'M'),
(518, 13, 'IT', '48', 'M'),
(519, 13, 'IT', '50', 'M'),
(520, 13, 'IT', '52', 'M'),
(521, 13, 'IT', '54', 'M'),
(522, 13, 'IT', '56', 'M'),
(523, 13, 'RUS', '44', 'M'),
(524, 13, 'RUS', '46', 'M'),
(525, 13, 'RUS', '48', 'M'),
(526, 13, 'RUS', '50', 'M'),
(527, 13, 'RUS', '52', 'M'),
(528, 13, 'RUS', '54', 'M'),
(529, 13, 'RUS', '56', 'M'),
(530, 13, 'RUS', '58', 'M'),
(531, 14, 'International', 'XXXS', 'M'),
(532, 14, 'International', 'XXS', 'M'),
(533, 14, 'International', 'XS', 'M'),
(534, 14, 'International', 'S', 'M'),
(535, 14, 'International', 'M', 'M'),
(536, 14, 'International', 'L', 'M'),
(537, 14, 'International', 'XL', 'M'),
(538, 14, 'International', 'XXL', 'M'),
(539, 14, 'International', 'XXXL', 'M'),
(540, 14, 'Inches', '24', 'M'),
(541, 14, 'Inches', '26', 'M'),
(542, 14, 'Inches', '28', 'M'),
(543, 14, 'Inches', '30', 'M'),
(544, 14, 'Inches', '32', 'M'),
(545, 14, 'Inches', '34', 'M'),
(546, 14, 'Inches', '36', 'M'),
(547, 14, 'Inches', '38', 'M'),
(548, 14, 'Inches', '40', 'M'),
(549, 14, 'US', '2', 'M'),
(550, 14, 'US', '4', 'M'),
(551, 14, 'US', '6', 'M'),
(552, 14, 'US', '8', 'M'),
(553, 14, 'US', '10', 'M'),
(554, 14, 'US', '12', 'M'),
(555, 14, 'US', '14', 'M'),
(556, 14, 'US', '16', 'M'),
(557, 14, 'EU', '18', 'M'),
(558, 15, 'International', 'XXXS', 'M'),
(559, 15, 'International', 'XXS', 'M'),
(560, 15, 'International', 'XS', 'M'),
(561, 15, 'International', 'S', 'M'),
(562, 15, 'International', 'M', 'M'),
(563, 15, 'International', 'L', 'M'),
(564, 15, 'International', 'XL', 'M'),
(565, 15, 'International', 'XXL', 'M'),
(566, 15, 'International', 'XXXL', 'M'),
(567, 15, 'Inches', '24', 'M'),
(568, 15, 'Inches', '26', 'M'),
(569, 15, 'Inches', '28', 'M'),
(570, 15, 'Inches', '30', 'M'),
(571, 15, 'Inches', '32', 'M'),
(572, 15, 'Inches', '34', 'M'),
(573, 15, 'Inches', '36', 'M'),
(574, 15, 'Inches', '38', 'M'),
(575, 15, 'Inches', '40', 'M'),
(576, 15, 'US', '2', 'M'),
(577, 15, 'US', '4', 'M'),
(578, 15, 'US', '6', 'M'),
(579, 15, 'US', '8', 'M'),
(580, 15, 'US', '10', 'M'),
(581, 15, 'US', '12', 'M'),
(582, 15, 'US', '14', 'M'),
(583, 15, 'US', '16', 'M'),
(584, 15, 'EU', '18', 'M'),
(585, 16, 'International', 'XXXS', 'W'),
(586, 16, 'International', 'XXS', 'W'),
(587, 16, 'International', 'XS', 'W'),
(588, 16, 'International', 'S', 'W'),
(589, 16, 'International', 'M', 'W'),
(590, 16, 'International', 'L', 'W'),
(591, 16, 'International', 'XL', 'W'),
(592, 16, 'International', 'XXL', 'W'),
(593, 16, 'International', 'XXXL', 'W'),
(594, 16, 'UK', '4', 'W'),
(595, 16, 'UK', '6', 'W'),
(596, 16, 'UK', '8', 'W'),
(597, 16, 'UK', '10', 'W'),
(598, 16, 'UK', '12', 'W'),
(599, 16, 'UK', '14', 'W'),
(600, 16, 'UK', '16', 'W'),
(601, 16, 'UK', '18', 'W'),
(602, 16, 'US', '0', 'W'),
(603, 16, 'US', '2', 'W'),
(604, 16, 'US', '4', 'W'),
(605, 16, 'US', '6', 'W'),
(606, 16, 'US', '8', 'W'),
(607, 16, 'US', '10', 'W'),
(608, 16, 'US', '12', 'W'),
(609, 16, 'US', '14', 'W'),
(610, 16, 'EU', '32', 'W'),
(611, 16, 'EU', '34', 'W'),
(612, 16, 'EU', '36', 'W'),
(613, 16, 'EU', '38', 'W'),
(614, 16, 'EU', '40', 'W'),
(615, 16, 'EU', '42', 'W'),
(616, 16, 'EU', '44', 'W'),
(617, 16, 'EU', '46', 'W'),
(618, 16, 'IT', '36', 'W'),
(619, 16, 'IT', '38', 'W'),
(620, 16, 'IT', '40', 'W'),
(621, 16, 'IT', '42', 'W'),
(622, 16, 'IT', '44', 'W'),
(623, 16, 'IT', '46', 'W'),
(624, 16, 'IT', '48', 'W'),
(625, 16, 'IT', '50', 'W'),
(626, 16, 'RUS', '38', 'W'),
(627, 16, 'RUS', '40', 'W'),
(628, 16, 'RUS', '42', 'W'),
(629, 16, 'RUS', '44', 'W'),
(630, 16, 'RUS', '46', 'W'),
(631, 16, 'RUS', '48', 'W'),
(632, 16, 'RUS', '50', 'W'),
(633, 16, 'RUS', '52', 'W'),
(634, 16, 'JP', '38', 'W'),
(635, 16, 'JP', '40', 'W'),
(636, 16, 'JP', '42', 'W'),
(637, 16, 'JP', '44', 'W'),
(638, 16, 'JP', '46', 'W'),
(639, 16, 'JP', '48', 'W'),
(640, 16, 'JP', '50', 'W'),
(641, 16, 'JP', '52', 'W'),
(642, 15, 'International', 'XXXS', 'W'),
(643, 15, 'International', 'XXS', 'W'),
(644, 15, 'International', 'XS', 'W'),
(645, 15, 'International', 'S', 'W'),
(646, 15, 'International', 'W', 'W'),
(647, 15, 'International', 'L', 'W'),
(648, 15, 'International', 'XL', 'W'),
(649, 15, 'International', 'XXL', 'W'),
(650, 15, 'International', 'XXXL', 'W'),
(651, 15, 'UK', '4', 'W'),
(652, 15, 'UK', '6', 'W'),
(653, 15, 'UK', '8', 'W'),
(654, 15, 'UK', '10', 'W'),
(655, 15, 'UK', '12', 'W'),
(656, 15, 'UK', '14', 'W'),
(657, 15, 'UK', '16', 'W'),
(658, 15, 'UK', '18', 'W'),
(659, 15, 'US', '0', 'W'),
(660, 15, 'US', '2', 'W'),
(661, 15, 'US', '4', 'W'),
(662, 15, 'US', '6', 'W'),
(663, 15, 'US', '8', 'W'),
(664, 15, 'US', '10', 'W'),
(665, 15, 'US', '12', 'W'),
(666, 15, 'US', '14', 'W'),
(667, 15, 'EU', '32', 'W'),
(668, 15, 'EU', '34', 'W'),
(669, 15, 'EU', '36', 'W'),
(670, 15, 'EU', '38', 'W'),
(671, 15, 'EU', '40', 'W'),
(672, 15, 'EU', '42', 'W'),
(673, 15, 'EU', '44', 'W'),
(674, 15, 'EU', '46', 'W'),
(675, 15, 'IT', '36', 'W'),
(676, 15, 'IT', '38', 'W'),
(677, 15, 'IT', '40', 'W'),
(678, 15, 'IT', '42', 'W'),
(679, 15, 'IT', '44', 'W'),
(680, 15, 'IT', '46', 'W'),
(681, 15, 'IT', '48', 'W'),
(682, 15, 'IT', '50', 'W'),
(683, 15, 'RUS', '38', 'W'),
(684, 15, 'RUS', '40', 'W'),
(685, 15, 'RUS', '42', 'W'),
(686, 15, 'RUS', '44', 'W'),
(687, 15, 'RUS', '46', 'W'),
(688, 15, 'RUS', '48', 'W'),
(689, 15, 'RUS', '50', 'W'),
(690, 15, 'RUS', '52', 'W'),
(691, 15, 'JP', '38', 'W'),
(692, 15, 'JP', '40', 'W'),
(693, 15, 'JP', '42', 'W'),
(694, 15, 'JP', '44', 'W'),
(695, 15, 'JP', '46', 'W'),
(696, 15, 'JP', '48', 'W'),
(697, 15, 'JP', '50', 'W'),
(698, 15, 'JP', '52', 'W'),
(699, 14, 'International', 'XXXS', 'W'),
(700, 14, 'International', 'XXS', 'W'),
(701, 14, 'International', 'XS', 'W'),
(702, 14, 'International', 'S', 'W'),
(703, 14, 'International', 'W', 'W'),
(704, 14, 'International', 'L', 'W'),
(705, 14, 'International', 'XL', 'W'),
(706, 14, 'International', 'XXL', 'W'),
(707, 14, 'International', 'XXXL', 'W'),
(708, 14, 'UK', '4', 'W'),
(709, 14, 'UK', '6', 'W'),
(710, 14, 'UK', '8', 'W'),
(711, 14, 'UK', '10', 'W'),
(712, 14, 'UK', '12', 'W'),
(713, 14, 'UK', '14', 'W'),
(714, 14, 'UK', '16', 'W'),
(715, 14, 'UK', '18', 'W'),
(716, 14, 'US', '0', 'W'),
(717, 14, 'US', '2', 'W'),
(718, 14, 'US', '4', 'W'),
(719, 14, 'US', '6', 'W'),
(720, 14, 'US', '8', 'W'),
(721, 14, 'US', '10', 'W'),
(722, 14, 'US', '12', 'W'),
(723, 14, 'US', '14', 'W'),
(724, 14, 'EU', '32', 'W'),
(725, 14, 'EU', '34', 'W'),
(726, 14, 'EU', '36', 'W'),
(727, 14, 'EU', '38', 'W'),
(728, 14, 'EU', '40', 'W'),
(729, 14, 'EU', '42', 'W'),
(730, 14, 'EU', '44', 'W'),
(731, 14, 'EU', '46', 'W'),
(732, 14, 'IT', '36', 'W'),
(733, 14, 'IT', '38', 'W'),
(734, 14, 'IT', '40', 'W'),
(735, 14, 'IT', '42', 'W'),
(736, 14, 'IT', '44', 'W'),
(737, 14, 'IT', '46', 'W'),
(738, 14, 'IT', '48', 'W'),
(739, 14, 'IT', '50', 'W'),
(740, 14, 'RUS', '38', 'W'),
(741, 14, 'RUS', '40', 'W'),
(742, 14, 'RUS', '42', 'W'),
(743, 14, 'RUS', '44', 'W'),
(744, 14, 'RUS', '46', 'W'),
(745, 14, 'RUS', '48', 'W'),
(746, 14, 'RUS', '50', 'W'),
(747, 14, 'RUS', '52', 'W'),
(748, 14, 'JP', '38', 'W'),
(749, 14, 'JP', '40', 'W'),
(750, 14, 'JP', '42', 'W'),
(751, 14, 'JP', '44', 'W'),
(752, 14, 'JP', '46', 'W'),
(753, 14, 'JP', '48', 'W'),
(754, 14, 'JP', '50', 'W'),
(755, 14, 'JP', '52', 'W'),
(757, 17, 'International', 'XXXS', 'W'),
(758, 17, 'International', 'XXS', 'W'),
(759, 17, 'International', 'XS', 'W'),
(760, 17, 'International', 'S', 'W'),
(761, 17, 'International', 'W', 'W'),
(762, 17, 'International', 'L', 'W'),
(763, 17, 'International', 'XL', 'W'),
(764, 17, 'International', 'XXL', 'W'),
(765, 17, 'International', 'XXXL', 'W'),
(766, 17, 'UK', '4', 'W'),
(767, 17, 'UK', '6', 'W'),
(768, 17, 'UK', '8', 'W'),
(769, 17, 'UK', '10', 'W'),
(770, 17, 'UK', '12', 'W'),
(771, 17, 'UK', '14', 'W'),
(772, 17, 'UK', '16', 'W'),
(773, 17, 'UK', '18', 'W'),
(774, 17, 'US', '0', 'W'),
(775, 17, 'US', '2', 'W'),
(776, 17, 'US', '4', 'W'),
(777, 17, 'US', '6', 'W'),
(778, 17, 'US', '8', 'W'),
(779, 17, 'US', '10', 'W'),
(780, 17, 'US', '12', 'W'),
(781, 17, 'US', '14', 'W'),
(782, 17, 'EU', '32', 'W'),
(783, 17, 'EU', '34', 'W'),
(784, 17, 'EU', '36', 'W'),
(785, 17, 'EU', '38', 'W'),
(786, 17, 'EU', '40', 'W'),
(787, 17, 'EU', '42', 'W'),
(788, 17, 'EU', '44', 'W'),
(789, 17, 'EU', '46', 'W'),
(790, 17, 'IT', '36', 'W'),
(791, 17, 'IT', '38', 'W'),
(792, 17, 'IT', '40', 'W'),
(793, 17, 'IT', '42', 'W'),
(794, 17, 'IT', '44', 'W'),
(795, 17, 'IT', '46', 'W'),
(796, 17, 'IT', '48', 'W'),
(797, 17, 'IT', '50', 'W'),
(798, 17, 'RUS', '38', 'W'),
(799, 17, 'RUS', '40', 'W'),
(800, 17, 'RUS', '42', 'W'),
(801, 17, 'RUS', '44', 'W'),
(802, 17, 'RUS', '46', 'W'),
(803, 17, 'RUS', '48', 'W'),
(804, 17, 'RUS', '50', 'W'),
(805, 17, 'RUS', '52', 'W'),
(806, 17, 'JP', '38', 'W'),
(807, 17, 'JP', '40', 'W'),
(808, 17, 'JP', '42', 'W'),
(809, 17, 'JP', '44', 'W'),
(810, 17, 'JP', '46', 'W'),
(811, 17, 'JP', '48', 'W'),
(812, 17, 'JP', '50', 'W'),
(813, 17, 'JP', '52', 'W'),
(814, 18, 'International', 'XXXS', 'W'),
(815, 18, 'International', 'XXS', 'W'),
(816, 18, 'International', 'XS', 'W'),
(817, 18, 'International', 'S', 'W'),
(818, 18, 'International', 'W', 'W'),
(819, 18, 'International', 'L', 'W'),
(820, 18, 'International', 'XL', 'W'),
(821, 18, 'International', 'XXL', 'W'),
(822, 18, 'International', 'XXXL', 'W'),
(823, 18, 'UK', '4', 'W'),
(824, 18, 'UK', '6', 'W'),
(825, 18, 'UK', '8', 'W'),
(826, 18, 'UK', '10', 'W'),
(827, 18, 'UK', '12', 'W'),
(828, 18, 'UK', '14', 'W'),
(829, 18, 'UK', '16', 'W'),
(830, 18, 'UK', '18', 'W'),
(831, 18, 'US', '0', 'W'),
(832, 18, 'US', '2', 'W'),
(833, 18, 'US', '4', 'W'),
(834, 18, 'US', '6', 'W'),
(835, 18, 'US', '8', 'W'),
(836, 18, 'US', '10', 'W'),
(837, 18, 'US', '12', 'W'),
(838, 18, 'US', '14', 'W'),
(839, 18, 'EU', '32', 'W'),
(840, 18, 'EU', '34', 'W'),
(841, 18, 'EU', '36', 'W'),
(842, 18, 'EU', '38', 'W'),
(843, 18, 'EU', '40', 'W'),
(844, 18, 'EU', '42', 'W'),
(845, 18, 'EU', '44', 'W'),
(846, 18, 'EU', '46', 'W'),
(847, 18, 'IT', '36', 'W'),
(848, 18, 'IT', '38', 'W'),
(849, 18, 'IT', '40', 'W'),
(850, 18, 'IT', '42', 'W'),
(851, 18, 'IT', '44', 'W'),
(852, 18, 'IT', '46', 'W'),
(853, 18, 'IT', '48', 'W'),
(854, 18, 'IT', '50', 'W'),
(855, 18, 'RUS', '38', 'W'),
(856, 18, 'RUS', '40', 'W'),
(857, 18, 'RUS', '42', 'W'),
(858, 18, 'RUS', '44', 'W'),
(859, 18, 'RUS', '46', 'W'),
(860, 18, 'RUS', '48', 'W'),
(861, 18, 'RUS', '50', 'W'),
(862, 18, 'RUS', '52', 'W'),
(863, 18, 'JP', '38', 'W'),
(864, 18, 'JP', '40', 'W'),
(865, 18, 'JP', '42', 'W'),
(866, 18, 'JP', '44', 'W'),
(867, 18, 'JP', '46', 'W'),
(868, 18, 'JP', '48', 'W'),
(869, 18, 'JP', '50', 'W'),
(870, 18, 'JP', '52', 'W'),
(871, 19, 'International', 'XXXS', 'W'),
(872, 19, 'International', 'XXS', 'W'),
(873, 19, 'International', 'XS', 'W'),
(874, 19, 'International', 'S', 'W'),
(875, 19, 'International', 'W', 'W'),
(876, 19, 'International', 'L', 'W'),
(877, 19, 'International', 'XL', 'W'),
(878, 19, 'International', 'XXL', 'W'),
(879, 19, 'International', 'XXXL', 'W'),
(880, 19, 'UK', '4', 'W'),
(881, 19, 'UK', '6', 'W'),
(882, 19, 'UK', '8', 'W'),
(883, 19, 'UK', '10', 'W'),
(884, 19, 'UK', '12', 'W'),
(885, 19, 'UK', '14', 'W'),
(886, 19, 'UK', '16', 'W'),
(887, 19, 'UK', '18', 'W'),
(888, 19, 'US', '0', 'W'),
(889, 19, 'US', '2', 'W'),
(890, 19, 'US', '4', 'W'),
(891, 19, 'US', '6', 'W'),
(892, 19, 'US', '8', 'W'),
(893, 19, 'US', '10', 'W'),
(894, 19, 'US', '12', 'W'),
(895, 19, 'US', '14', 'W'),
(896, 19, 'EU', '32', 'W'),
(897, 19, 'EU', '34', 'W'),
(898, 19, 'EU', '36', 'W'),
(899, 19, 'EU', '38', 'W'),
(900, 19, 'EU', '40', 'W'),
(901, 19, 'EU', '42', 'W'),
(902, 19, 'EU', '44', 'W'),
(903, 19, 'EU', '46', 'W'),
(904, 19, 'IT', '36', 'W'),
(905, 19, 'IT', '38', 'W'),
(906, 19, 'IT', '40', 'W'),
(907, 19, 'IT', '42', 'W'),
(908, 19, 'IT', '44', 'W'),
(909, 19, 'IT', '46', 'W'),
(910, 19, 'IT', '48', 'W'),
(911, 19, 'IT', '50', 'W'),
(912, 19, 'RUS', '38', 'W'),
(913, 19, 'RUS', '40', 'W'),
(914, 19, 'RUS', '42', 'W'),
(915, 19, 'RUS', '44', 'W'),
(916, 19, 'RUS', '46', 'W'),
(917, 19, 'RUS', '48', 'W'),
(918, 19, 'RUS', '50', 'W'),
(919, 19, 'RUS', '52', 'W'),
(920, 19, 'JP', '38', 'W'),
(921, 19, 'JP', '40', 'W'),
(922, 19, 'JP', '42', 'W'),
(923, 19, 'JP', '44', 'W'),
(924, 19, 'JP', '46', 'W'),
(925, 19, 'JP', '48', 'W'),
(926, 19, 'JP', '50', 'W'),
(927, 19, 'JP', '52', 'W'),
(928, 2, 'International', 'XXXS', 'W'),
(929, 2, 'International', 'XXS', 'W'),
(930, 2, 'International', 'XS', 'W'),
(931, 2, 'International', 'S', 'W'),
(932, 2, 'International', 'W', 'W'),
(933, 2, 'International', 'L', 'W'),
(934, 2, 'International', 'XL', 'W'),
(935, 2, 'International', 'XXL', 'W'),
(936, 2, 'International', 'XXXL', 'W'),
(937, 2, 'UK', '4', 'W'),
(938, 2, 'UK', '6', 'W'),
(939, 2, 'UK', '8', 'W'),
(940, 2, 'UK', '10', 'W'),
(941, 2, 'UK', '12', 'W'),
(942, 2, 'UK', '14', 'W'),
(943, 2, 'UK', '16', 'W'),
(944, 2, 'UK', '18', 'W'),
(945, 2, 'US', '0', 'W'),
(946, 2, 'US', '2', 'W'),
(947, 2, 'US', '4', 'W'),
(948, 2, 'US', '6', 'W'),
(949, 2, 'US', '8', 'W'),
(950, 2, 'US', '10', 'W'),
(951, 2, 'US', '12', 'W'),
(952, 2, 'US', '14', 'W'),
(953, 2, 'EU', '32', 'W'),
(954, 2, 'EU', '34', 'W'),
(955, 2, 'EU', '36', 'W'),
(956, 2, 'EU', '38', 'W'),
(957, 2, 'EU', '40', 'W'),
(958, 2, 'EU', '42', 'W'),
(959, 2, 'EU', '44', 'W'),
(960, 2, 'EU', '46', 'W'),
(961, 2, 'IT', '36', 'W'),
(962, 2, 'IT', '38', 'W'),
(963, 2, 'IT', '40', 'W'),
(964, 2, 'IT', '42', 'W'),
(965, 2, 'IT', '44', 'W'),
(966, 2, 'IT', '46', 'W'),
(967, 2, 'IT', '48', 'W'),
(968, 2, 'IT', '50', 'W'),
(969, 2, 'RUS', '38', 'W'),
(970, 2, 'RUS', '40', 'W'),
(971, 2, 'RUS', '42', 'W'),
(972, 2, 'RUS', '44', 'W'),
(973, 2, 'RUS', '46', 'W'),
(974, 2, 'RUS', '48', 'W'),
(975, 2, 'RUS', '50', 'W'),
(976, 2, 'RUS', '52', 'W'),
(977, 2, 'JP', '38', 'W'),
(978, 2, 'JP', '40', 'W'),
(979, 2, 'JP', '42', 'W'),
(980, 2, 'JP', '44', 'W'),
(981, 2, 'JP', '46', 'W'),
(982, 2, 'JP', '48', 'W'),
(983, 2, 'JP', '50', 'W'),
(984, 2, 'JP', '52', 'W'),
(985, 1, 'International', 'XXXS', 'W'),
(986, 1, 'International', 'XXS', 'W'),
(987, 1, 'International', 'XS', 'W'),
(988, 1, 'International', 'S', 'W'),
(989, 1, 'International', 'W', 'W'),
(990, 1, 'International', 'L', 'W'),
(991, 1, 'International', 'XL', 'W'),
(992, 1, 'International', 'XXL', 'W'),
(993, 1, 'International', 'XXXL', 'W'),
(994, 1, 'UK', '4', 'W'),
(995, 1, 'UK', '6', 'W'),
(996, 1, 'UK', '8', 'W'),
(997, 1, 'UK', '10', 'W'),
(998, 1, 'UK', '12', 'W'),
(999, 1, 'UK', '14', 'W'),
(1000, 1, 'UK', '16', 'W'),
(1001, 1, 'UK', '18', 'W'),
(1002, 1, 'US', '0', 'W'),
(1003, 1, 'US', '2', 'W'),
(1004, 1, 'US', '4', 'W'),
(1005, 1, 'US', '6', 'W'),
(1006, 1, 'US', '8', 'W'),
(1007, 1, 'US', '10', 'W'),
(1008, 1, 'US', '12', 'W'),
(1009, 1, 'US', '14', 'W'),
(1010, 1, 'EU', '32', 'W'),
(1011, 1, 'EU', '34', 'W'),
(1012, 1, 'EU', '36', 'W'),
(1013, 1, 'EU', '38', 'W'),
(1014, 1, 'EU', '40', 'W'),
(1015, 1, 'EU', '42', 'W'),
(1016, 1, 'EU', '44', 'W'),
(1017, 1, 'EU', '46', 'W'),
(1018, 1, 'IT', '36', 'W'),
(1019, 1, 'IT', '38', 'W'),
(1020, 1, 'IT', '40', 'W'),
(1021, 1, 'IT', '42', 'W'),
(1022, 1, 'IT', '44', 'W'),
(1023, 1, 'IT', '46', 'W'),
(1024, 1, 'IT', '48', 'W'),
(1025, 1, 'IT', '50', 'W'),
(1026, 1, 'RUS', '38', 'W'),
(1027, 1, 'RUS', '40', 'W'),
(1028, 1, 'RUS', '42', 'W'),
(1029, 1, 'RUS', '44', 'W'),
(1030, 1, 'RUS', '46', 'W'),
(1031, 1, 'RUS', '48', 'W'),
(1032, 1, 'RUS', '50', 'W'),
(1033, 1, 'RUS', '52', 'W'),
(1034, 1, 'JP', '38', 'W'),
(1035, 1, 'JP', '40', 'W'),
(1036, 1, 'JP', '42', 'W'),
(1037, 1, 'JP', '44', 'W'),
(1038, 1, 'JP', '46', 'W'),
(1039, 1, 'JP', '48', 'W'),
(1040, 1, 'JP', '50', 'W'),
(1041, 1, 'JP', '52', 'W'),
(1042, 5, 'International', 'XXXS', 'W'),
(1043, 5, 'International', 'XXS', 'W'),
(1044, 5, 'International', 'XS', 'W'),
(1045, 5, 'International', 'S', 'W'),
(1046, 5, 'International', 'W', 'W'),
(1047, 5, 'International', 'L', 'W'),
(1048, 5, 'International', 'XL', 'W'),
(1049, 5, 'International', 'XXL', 'W'),
(1050, 5, 'International', 'XXXL', 'W'),
(1051, 5, 'UK', '4', 'W'),
(1052, 5, 'UK', '6', 'W'),
(1053, 5, 'UK', '8', 'W'),
(1054, 5, 'UK', '10', 'W'),
(1055, 5, 'UK', '12', 'W'),
(1056, 5, 'UK', '14', 'W'),
(1057, 5, 'UK', '16', 'W'),
(1058, 5, 'UK', '18', 'W'),
(1059, 5, 'US', '0', 'W'),
(1060, 5, 'US', '2', 'W'),
(1061, 5, 'US', '4', 'W'),
(1062, 5, 'US', '6', 'W'),
(1063, 5, 'US', '8', 'W'),
(1064, 5, 'US', '10', 'W'),
(1065, 5, 'US', '12', 'W'),
(1066, 5, 'US', '14', 'W'),
(1067, 5, 'EU', '32', 'W'),
(1068, 5, 'EU', '34', 'W'),
(1069, 5, 'EU', '36', 'W'),
(1070, 5, 'EU', '38', 'W'),
(1071, 5, 'EU', '40', 'W'),
(1072, 5, 'EU', '42', 'W'),
(1073, 5, 'EU', '44', 'W'),
(1074, 5, 'EU', '46', 'W'),
(1075, 5, 'IT', '36', 'W'),
(1076, 5, 'IT', '38', 'W'),
(1077, 5, 'IT', '40', 'W'),
(1078, 5, 'IT', '42', 'W'),
(1079, 5, 'IT', '44', 'W'),
(1080, 5, 'IT', '46', 'W'),
(1081, 5, 'IT', '48', 'W'),
(1082, 5, 'IT', '50', 'W'),
(1083, 5, 'RUS', '38', 'W'),
(1084, 5, 'RUS', '40', 'W'),
(1085, 5, 'RUS', '42', 'W'),
(1086, 5, 'RUS', '44', 'W'),
(1087, 5, 'RUS', '46', 'W'),
(1088, 5, 'RUS', '48', 'W'),
(1089, 5, 'RUS', '50', 'W'),
(1090, 5, 'RUS', '52', 'W'),
(1091, 5, 'JP', '38', 'W'),
(1092, 5, 'JP', '40', 'W'),
(1093, 5, 'JP', '42', 'W'),
(1094, 5, 'JP', '44', 'W'),
(1095, 5, 'JP', '46', 'W'),
(1096, 5, 'JP', '48', 'W'),
(1097, 5, 'JP', '50', 'W'),
(1098, 5, 'JP', '52', 'W'),
(1099, 7, 'International', 'XXXS', 'W'),
(1100, 7, 'International', 'XXS', 'W'),
(1101, 7, 'International', 'XS', 'W'),
(1102, 7, 'International', 'S', 'W'),
(1103, 7, 'International', 'W', 'W'),
(1104, 7, 'International', 'L', 'W'),
(1105, 7, 'International', 'XL', 'W'),
(1106, 7, 'International', 'XXL', 'W'),
(1107, 7, 'International', 'XXXL', 'W'),
(1108, 7, 'UK', '4', 'W'),
(1109, 7, 'UK', '6', 'W'),
(1110, 7, 'UK', '8', 'W'),
(1111, 7, 'UK', '10', 'W'),
(1112, 7, 'UK', '12', 'W'),
(1113, 7, 'UK', '14', 'W'),
(1114, 7, 'UK', '16', 'W'),
(1115, 7, 'UK', '18', 'W'),
(1116, 7, 'US', '0', 'W'),
(1117, 7, 'US', '2', 'W'),
(1118, 7, 'US', '4', 'W'),
(1119, 7, 'US', '6', 'W'),
(1120, 7, 'US', '8', 'W'),
(1121, 7, 'US', '10', 'W'),
(1122, 7, 'US', '12', 'W'),
(1123, 7, 'US', '14', 'W'),
(1124, 7, 'EU', '32', 'W'),
(1125, 7, 'EU', '34', 'W'),
(1126, 7, 'EU', '36', 'W'),
(1127, 7, 'EU', '38', 'W'),
(1128, 7, 'EU', '40', 'W'),
(1129, 7, 'EU', '42', 'W'),
(1130, 7, 'EU', '44', 'W'),
(1131, 7, 'EU', '46', 'W'),
(1132, 7, 'IT', '36', 'W'),
(1133, 7, 'IT', '38', 'W'),
(1134, 7, 'IT', '40', 'W'),
(1135, 7, 'IT', '42', 'W'),
(1136, 7, 'IT', '44', 'W'),
(1137, 7, 'IT', '46', 'W'),
(1138, 7, 'IT', '48', 'W'),
(1139, 7, 'IT', '50', 'W'),
(1140, 7, 'RUS', '38', 'W'),
(1141, 7, 'RUS', '40', 'W'),
(1142, 7, 'RUS', '42', 'W'),
(1143, 7, 'RUS', '44', 'W'),
(1144, 7, 'RUS', '46', 'W'),
(1145, 7, 'RUS', '48', 'W'),
(1146, 7, 'RUS', '50', 'W'),
(1147, 7, 'RUS', '52', 'W'),
(1148, 7, 'JP', '38', 'W'),
(1149, 7, 'JP', '40', 'W'),
(1150, 7, 'JP', '42', 'W'),
(1151, 7, 'JP', '44', 'W'),
(1152, 7, 'JP', '46', 'W'),
(1153, 7, 'JP', '48', 'W'),
(1154, 7, 'JP', '50', 'W'),
(1155, 7, 'JP', '52', 'W'),
(1156, 3, 'International', 'XXXS', 'W'),
(1157, 3, 'International', 'XXS', 'W'),
(1158, 3, 'International', 'XS', 'W'),
(1159, 3, 'International', 'S', 'W'),
(1160, 3, 'International', 'W', 'W'),
(1161, 3, 'International', 'L', 'W'),
(1162, 3, 'International', 'XL', 'W'),
(1163, 3, 'International', 'XXL', 'W'),
(1164, 3, 'International', 'XXXL', 'W'),
(1165, 3, 'UK', '4', 'W'),
(1166, 3, 'UK', '6', 'W'),
(1167, 3, 'UK', '8', 'W'),
(1168, 3, 'UK', '10', 'W'),
(1169, 3, 'UK', '12', 'W'),
(1170, 3, 'UK', '14', 'W'),
(1171, 3, 'UK', '16', 'W'),
(1172, 3, 'UK', '18', 'W'),
(1173, 3, 'US', '0', 'W'),
(1174, 3, 'US', '2', 'W'),
(1175, 3, 'US', '4', 'W'),
(1176, 3, 'US', '6', 'W'),
(1177, 3, 'US', '8', 'W'),
(1178, 3, 'US', '10', 'W'),
(1179, 3, 'US', '12', 'W'),
(1180, 3, 'US', '14', 'W'),
(1181, 3, 'EU', '32', 'W'),
(1182, 3, 'EU', '34', 'W'),
(1183, 3, 'EU', '36', 'W'),
(1184, 3, 'EU', '38', 'W'),
(1185, 3, 'EU', '40', 'W'),
(1186, 3, 'EU', '42', 'W'),
(1187, 3, 'EU', '44', 'W'),
(1188, 3, 'EU', '46', 'W'),
(1189, 3, 'IT', '36', 'W'),
(1190, 3, 'IT', '38', 'W'),
(1191, 3, 'IT', '40', 'W'),
(1192, 3, 'IT', '42', 'W'),
(1193, 3, 'IT', '44', 'W'),
(1194, 3, 'IT', '46', 'W'),
(1195, 3, 'IT', '48', 'W'),
(1196, 3, 'IT', '50', 'W'),
(1197, 3, 'RUS', '38', 'W'),
(1198, 3, 'RUS', '40', 'W'),
(1199, 3, 'RUS', '42', 'W'),
(1200, 3, 'RUS', '44', 'W'),
(1201, 3, 'RUS', '46', 'W'),
(1202, 3, 'RUS', '48', 'W'),
(1203, 3, 'RUS', '50', 'W'),
(1204, 3, 'RUS', '52', 'W'),
(1205, 3, 'JP', '38', 'W'),
(1206, 3, 'JP', '40', 'W'),
(1207, 3, 'JP', '42', 'W'),
(1208, 3, 'JP', '44', 'W'),
(1209, 3, 'JP', '46', 'W'),
(1210, 3, 'JP', '48', 'W'),
(1211, 3, 'JP', '50', 'W'),
(1212, 3, 'JP', '52', 'W'),
(1213, 8, 'International', 'XXXS', 'W'),
(1214, 8, 'International', 'XXS', 'W'),
(1215, 8, 'International', 'XS', 'W'),
(1216, 8, 'International', 'S', 'W'),
(1217, 8, 'International', 'W', 'W'),
(1218, 8, 'International', 'L', 'W'),
(1219, 8, 'International', 'XL', 'W'),
(1220, 8, 'International', 'XXL', 'W'),
(1221, 8, 'International', 'XXXL', 'W'),
(1222, 8, 'UK', '4', 'W'),
(1223, 8, 'UK', '6', 'W'),
(1224, 8, 'UK', '8', 'W'),
(1225, 8, 'UK', '10', 'W'),
(1226, 8, 'UK', '12', 'W'),
(1227, 8, 'UK', '14', 'W'),
(1228, 8, 'UK', '16', 'W'),
(1229, 8, 'UK', '18', 'W'),
(1230, 8, 'US', '0', 'W'),
(1231, 8, 'US', '2', 'W'),
(1232, 8, 'US', '4', 'W'),
(1233, 8, 'US', '6', 'W'),
(1234, 8, 'US', '8', 'W'),
(1235, 8, 'US', '10', 'W'),
(1236, 8, 'US', '12', 'W'),
(1237, 8, 'US', '14', 'W'),
(1238, 8, 'EU', '32', 'W'),
(1239, 8, 'EU', '34', 'W'),
(1240, 8, 'EU', '36', 'W'),
(1241, 8, 'EU', '38', 'W'),
(1242, 8, 'EU', '40', 'W'),
(1243, 8, 'EU', '42', 'W'),
(1244, 8, 'EU', '44', 'W'),
(1245, 8, 'EU', '46', 'W'),
(1246, 8, 'IT', '36', 'W'),
(1247, 8, 'IT', '38', 'W'),
(1248, 8, 'IT', '40', 'W'),
(1249, 8, 'IT', '42', 'W'),
(1250, 8, 'IT', '44', 'W'),
(1251, 8, 'IT', '46', 'W'),
(1252, 8, 'IT', '48', 'W'),
(1253, 8, 'IT', '50', 'W'),
(1254, 8, 'RUS', '38', 'W'),
(1255, 8, 'RUS', '40', 'W'),
(1256, 8, 'RUS', '42', 'W'),
(1257, 8, 'RUS', '44', 'W'),
(1258, 8, 'RUS', '46', 'W'),
(1259, 8, 'RUS', '48', 'W'),
(1260, 8, 'RUS', '50', 'W'),
(1261, 8, 'RUS', '52', 'W'),
(1262, 8, 'JP', '38', 'W'),
(1263, 8, 'JP', '40', 'W'),
(1264, 8, 'JP', '42', 'W'),
(1265, 8, 'JP', '44', 'W'),
(1266, 8, 'JP', '46', 'W'),
(1267, 8, 'JP', '48', 'W'),
(1268, 8, 'JP', '50', 'W'),
(1269, 8, 'JP', '52', 'W'),
(1270, 9, 'International', 'XXXS', 'W'),
(1271, 9, 'International', 'XXS', 'W'),
(1272, 9, 'International', 'XS', 'W'),
(1273, 9, 'International', 'S', 'W'),
(1274, 9, 'International', 'W', 'W'),
(1275, 9, 'International', 'L', 'W'),
(1276, 9, 'International', 'XL', 'W'),
(1277, 9, 'International', 'XXL', 'W'),
(1278, 9, 'International', 'XXXL', 'W'),
(1279, 9, 'UK', '4', 'W'),
(1280, 9, 'UK', '6', 'W'),
(1281, 9, 'UK', '8', 'W'),
(1282, 9, 'UK', '10', 'W'),
(1283, 9, 'UK', '12', 'W'),
(1284, 9, 'UK', '14', 'W'),
(1285, 9, 'UK', '16', 'W'),
(1286, 9, 'UK', '18', 'W'),
(1287, 9, 'US', '0', 'W'),
(1288, 9, 'US', '2', 'W'),
(1289, 9, 'US', '4', 'W'),
(1290, 9, 'US', '6', 'W'),
(1291, 9, 'US', '8', 'W'),
(1292, 9, 'US', '10', 'W'),
(1293, 9, 'US', '12', 'W'),
(1294, 9, 'US', '14', 'W'),
(1295, 9, 'EU', '32', 'W'),
(1296, 9, 'EU', '34', 'W'),
(1297, 9, 'EU', '36', 'W'),
(1298, 9, 'EU', '38', 'W'),
(1299, 9, 'EU', '40', 'W'),
(1300, 9, 'EU', '42', 'W'),
(1301, 9, 'EU', '44', 'W'),
(1302, 9, 'EU', '46', 'W'),
(1303, 9, 'IT', '36', 'W'),
(1304, 9, 'IT', '38', 'W'),
(1305, 9, 'IT', '40', 'W'),
(1306, 9, 'IT', '42', 'W'),
(1307, 9, 'IT', '44', 'W'),
(1308, 9, 'IT', '46', 'W'),
(1309, 9, 'IT', '48', 'W'),
(1310, 9, 'IT', '50', 'W'),
(1311, 9, 'RUS', '38', 'W'),
(1312, 9, 'RUS', '40', 'W'),
(1313, 9, 'RUS', '42', 'W'),
(1314, 9, 'RUS', '44', 'W'),
(1315, 9, 'RUS', '46', 'W'),
(1316, 9, 'RUS', '48', 'W'),
(1317, 9, 'RUS', '50', 'W'),
(1318, 9, 'RUS', '52', 'W'),
(1319, 9, 'JP', '38', 'W'),
(1320, 9, 'JP', '40', 'W'),
(1321, 9, 'JP', '42', 'W'),
(1322, 9, 'JP', '44', 'W'),
(1323, 9, 'JP', '46', 'W'),
(1324, 9, 'JP', '48', 'W'),
(1325, 9, 'JP', '50', 'W'),
(1326, 9, 'JP', '52', 'W'),
(1327, 10, 'International', 'XXXS', 'W'),
(1328, 10, 'International', 'XXS', 'W'),
(1329, 10, 'International', 'XS', 'W'),
(1330, 10, 'International', 'S', 'W'),
(1331, 10, 'International', 'W', 'W'),
(1332, 10, 'International', 'L', 'W'),
(1333, 10, 'International', 'XL', 'W'),
(1334, 10, 'International', 'XXL', 'W'),
(1335, 10, 'International', 'XXXL', 'W'),
(1336, 10, 'UK', '4', 'W'),
(1337, 10, 'UK', '6', 'W'),
(1338, 10, 'UK', '8', 'W'),
(1339, 10, 'UK', '10', 'W'),
(1340, 10, 'UK', '12', 'W'),
(1341, 10, 'UK', '14', 'W'),
(1342, 10, 'UK', '16', 'W'),
(1343, 10, 'UK', '18', 'W'),
(1344, 10, 'US', '0', 'W'),
(1345, 10, 'US', '2', 'W'),
(1346, 10, 'US', '4', 'W'),
(1347, 10, 'US', '6', 'W'),
(1348, 10, 'US', '8', 'W'),
(1349, 10, 'US', '10', 'W'),
(1350, 10, 'US', '12', 'W'),
(1351, 10, 'US', '14', 'W'),
(1352, 10, 'EU', '32', 'W'),
(1353, 10, 'EU', '34', 'W'),
(1354, 10, 'EU', '36', 'W'),
(1355, 10, 'EU', '38', 'W'),
(1356, 10, 'EU', '40', 'W'),
(1357, 10, 'EU', '42', 'W'),
(1358, 10, 'EU', '44', 'W'),
(1359, 10, 'EU', '46', 'W'),
(1360, 10, 'IT', '36', 'W'),
(1361, 10, 'IT', '38', 'W'),
(1362, 10, 'IT', '40', 'W'),
(1363, 10, 'IT', '42', 'W'),
(1364, 10, 'IT', '44', 'W'),
(1365, 10, 'IT', '46', 'W'),
(1366, 10, 'IT', '48', 'W'),
(1367, 10, 'IT', '50', 'W'),
(1368, 10, 'RUS', '38', 'W'),
(1369, 10, 'RUS', '40', 'W'),
(1370, 10, 'RUS', '42', 'W'),
(1371, 10, 'RUS', '44', 'W'),
(1372, 10, 'RUS', '46', 'W'),
(1373, 10, 'RUS', '48', 'W'),
(1374, 10, 'RUS', '50', 'W'),
(1375, 10, 'RUS', '52', 'W'),
(1376, 10, 'JP', '38', 'W'),
(1377, 10, 'JP', '40', 'W'),
(1378, 10, 'JP', '42', 'W'),
(1379, 10, 'JP', '44', 'W'),
(1380, 10, 'JP', '46', 'W'),
(1381, 10, 'JP', '48', 'W'),
(1382, 10, 'JP', '50', 'W'),
(1383, 10, 'JP', '52', 'W'),
(1384, 11, 'International', 'XXXS', 'W'),
(1385, 11, 'International', 'XXS', 'W'),
(1386, 11, 'International', 'XS', 'W'),
(1387, 11, 'International', 'S', 'W'),
(1388, 11, 'International', 'W', 'W'),
(1389, 11, 'International', 'L', 'W'),
(1390, 11, 'International', 'XL', 'W'),
(1391, 11, 'International', 'XXL', 'W'),
(1392, 11, 'International', 'XXXL', 'W'),
(1393, 11, 'UK', '4', 'W'),
(1394, 11, 'UK', '6', 'W'),
(1395, 11, 'UK', '8', 'W'),
(1396, 11, 'UK', '10', 'W'),
(1397, 11, 'UK', '12', 'W'),
(1398, 11, 'UK', '14', 'W'),
(1399, 11, 'UK', '16', 'W'),
(1400, 11, 'UK', '18', 'W'),
(1401, 11, 'US', '0', 'W'),
(1402, 11, 'US', '2', 'W'),
(1403, 11, 'US', '4', 'W'),
(1404, 11, 'US', '6', 'W'),
(1405, 11, 'US', '8', 'W'),
(1406, 11, 'US', '10', 'W'),
(1407, 11, 'US', '12', 'W'),
(1408, 11, 'US', '14', 'W'),
(1409, 11, 'EU', '32', 'W'),
(1410, 11, 'EU', '34', 'W'),
(1411, 11, 'EU', '36', 'W'),
(1412, 11, 'EU', '38', 'W'),
(1413, 11, 'EU', '40', 'W'),
(1414, 11, 'EU', '42', 'W'),
(1415, 11, 'EU', '44', 'W'),
(1416, 11, 'EU', '46', 'W'),
(1417, 11, 'IT', '36', 'W'),
(1418, 11, 'IT', '38', 'W'),
(1419, 11, 'IT', '40', 'W'),
(1420, 11, 'IT', '42', 'W'),
(1421, 11, 'IT', '44', 'W'),
(1422, 11, 'IT', '46', 'W'),
(1423, 11, 'IT', '48', 'W'),
(1424, 11, 'IT', '50', 'W'),
(1425, 11, 'RUS', '38', 'W'),
(1426, 11, 'RUS', '40', 'W'),
(1427, 11, 'RUS', '42', 'W'),
(1428, 11, 'RUS', '44', 'W'),
(1429, 11, 'RUS', '46', 'W'),
(1430, 11, 'RUS', '48', 'W'),
(1431, 11, 'RUS', '50', 'W'),
(1432, 11, 'RUS', '52', 'W'),
(1433, 11, 'JP', '38', 'W'),
(1434, 11, 'JP', '40', 'W'),
(1435, 11, 'JP', '42', 'W'),
(1436, 11, 'JP', '44', 'W'),
(1437, 11, 'JP', '46', 'W'),
(1438, 11, 'JP', '48', 'W'),
(1439, 11, 'JP', '50', 'W'),
(1440, 11, 'JP', '52', 'W'),
(1441, 13, 'International', 'XXXS', 'W'),
(1442, 13, 'International', 'XXS', 'W'),
(1443, 13, 'International', 'XS', 'W'),
(1444, 13, 'International', 'S', 'W'),
(1445, 13, 'International', 'W', 'W'),
(1446, 13, 'International', 'L', 'W'),
(1447, 13, 'International', 'XL', 'W'),
(1448, 13, 'International', 'XXL', 'W'),
(1449, 13, 'International', 'XXXL', 'W'),
(1450, 13, 'UK', '4', 'W'),
(1451, 13, 'UK', '6', 'W'),
(1452, 13, 'UK', '8', 'W'),
(1453, 13, 'UK', '10', 'W'),
(1454, 13, 'UK', '12', 'W'),
(1455, 13, 'UK', '14', 'W'),
(1456, 13, 'UK', '16', 'W'),
(1457, 13, 'UK', '18', 'W'),
(1458, 13, 'US', '0', 'W'),
(1459, 13, 'US', '2', 'W'),
(1460, 13, 'US', '4', 'W'),
(1461, 13, 'US', '6', 'W'),
(1462, 13, 'US', '8', 'W'),
(1463, 13, 'US', '10', 'W'),
(1464, 13, 'US', '12', 'W'),
(1465, 13, 'US', '14', 'W'),
(1466, 13, 'EU', '32', 'W'),
(1467, 13, 'EU', '34', 'W'),
(1468, 13, 'EU', '36', 'W'),
(1469, 13, 'EU', '38', 'W'),
(1470, 13, 'EU', '40', 'W'),
(1471, 13, 'EU', '42', 'W'),
(1472, 13, 'EU', '44', 'W'),
(1473, 13, 'EU', '46', 'W'),
(1474, 13, 'IT', '36', 'W'),
(1475, 13, 'IT', '38', 'W'),
(1476, 13, 'IT', '40', 'W'),
(1477, 13, 'IT', '42', 'W'),
(1478, 13, 'IT', '44', 'W'),
(1479, 13, 'IT', '46', 'W'),
(1480, 13, 'IT', '48', 'W'),
(1481, 13, 'IT', '50', 'W'),
(1482, 13, 'RUS', '38', 'W'),
(1483, 13, 'RUS', '40', 'W'),
(1484, 13, 'RUS', '42', 'W'),
(1485, 13, 'RUS', '44', 'W'),
(1486, 13, 'RUS', '46', 'W'),
(1487, 13, 'RUS', '48', 'W'),
(1488, 13, 'RUS', '50', 'W'),
(1489, 13, 'RUS', '52', 'W'),
(1490, 13, 'JP', '38', 'W'),
(1491, 13, 'JP', '40', 'W'),
(1492, 13, 'JP', '42', 'W'),
(1493, 13, 'JP', '44', 'W'),
(1494, 13, 'JP', '46', 'W'),
(1495, 13, 'JP', '48', 'W'),
(1496, 13, 'JP', '50', 'W'),
(1497, 13, 'JP', '52', 'W'),
(1498, 12, 'International', 'XXS', 'W'),
(1499, 12, 'International', 'XS', 'W'),
(1500, 12, 'International', 'S', 'W'),
(1501, 12, 'International', 'M', 'W'),
(1502, 12, 'International', 'L', 'W'),
(1503, 12, 'International', 'XL', 'W'),
(1504, 12, 'International', 'XXL', 'W'),
(1505, 12, 'Inches', '26', 'W'),
(1506, 12, 'Inches', '27', 'W'),
(1507, 12, 'Inches', '28', 'W'),
(1508, 12, 'Inches', '29', 'W'),
(1509, 12, 'Inches', '30', 'W'),
(1510, 12, 'Inches', '31', 'W'),
(1511, 12, 'Inches', '32', 'W'),
(1512, 12, 'Inches', '33', 'W'),
(1513, 12, 'Inches', '34', 'W'),
(1514, 12, 'Inches', '35', 'W'),
(1515, 12, 'Inches', '36', 'W'),
(1516, 12, 'Inches', '37', 'W'),
(1517, 12, 'Inches', '38', 'W'),
(1518, 12, 'Inches', '39', 'W'),
(1519, 12, 'Inches', '40', 'W'),
(1520, 12, 'Inches', '41', 'W'),
(1521, 12, 'Inches', '42', 'W'),
(1522, 12, 'Inches', '43', 'W'),
(1523, 12, 'Inches', '44', 'W'),
(1524, 12, 'Inches', '45', 'W'),
(1525, 12, 'Inches', '46', 'W'),
(1526, 12, 'Inches', '47', 'M'),
(1527, 12, 'Inches', '48', 'M'),
(1528, 4, 'International', 'S', 'W'),
(1529, 4, 'International', 'M', 'W'),
(1530, 4, 'International', 'L', 'W'),
(1531, 4, 'International', 'One Size', 'W'),
(1532, 6, 'UK', '2', 'W'),
(1533, 6, 'UK', '3', 'W'),
(1534, 6, 'UK', '4', 'W'),
(1535, 6, 'UK', '5', 'W'),
(1536, 6, 'UK', '6', 'W'),
(1537, 6, 'UK', '7', 'W'),
(1538, 6, 'UK', '8', 'W'),
(1539, 6, 'UK', '9', 'W'),
(1540, 6, 'EU', '35', 'W'),
(1541, 6, 'EU', '36', 'W'),
(1542, 6, 'EU', '37', 'W'),
(1543, 6, 'EU', '38', 'W'),
(1544, 6, 'EU', '39', 'W'),
(1545, 6, 'EU', '40', 'W'),
(1546, 6, 'EU', '41', 'W'),
(1547, 6, 'EU', '42', 'W'),
(1548, 6, 'US', '5', 'W'),
(1549, 6, 'US', '6', 'W'),
(1550, 6, 'US', '7', 'W'),
(1551, 6, 'US', '8', 'W'),
(1552, 6, 'US', '9', 'W'),
(1553, 6, 'US', '10', 'W'),
(1554, 6, 'US', '11', 'W'),
(1555, 6, 'US', '12', 'W');

-- --------------------------------------------------------

--
-- Структура таблицы `size_chart`
--

CREATE TABLE IF NOT EXISTS `size_chart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(20) COLLATE utf8_bin NOT NULL,
  `size` varchar(20) COLLATE utf8_bin NOT NULL,
  `size_chart_cat_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `size_chart_cat_id` (`size_chart_cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=428 ;

--
-- Дамп данных таблицы `size_chart`
--

INSERT INTO `size_chart` (`id`, `type`, `size`, `size_chart_cat_id`) VALUES
(1, 'INT', 'XXS', 1),
(2, 'INT', 'XS', 1),
(3, 'INT', 'S', 1),
(4, 'INT', 'M', 1),
(5, 'INT', 'L', 1),
(6, 'INT', 'XL', 1),
(7, 'INT', 'XXL', 1),
(8, 'INT', 'ONE SIZE', 1),
(9, 'EU', '32', 1),
(10, 'EU', '34', 1),
(11, 'EU', '36', 1),
(12, 'EU', '38', 1),
(13, 'EU', '40', 1),
(14, 'EU', '42', 1),
(15, 'EU', '44', 1),
(16, 'IT', '38', 1),
(17, 'IT', '40', 1),
(18, 'IT', '42', 1),
(19, 'IT', '44', 1),
(20, 'IT', '46', 1),
(21, 'IT', '48', 1),
(22, 'IT', '50', 1),
(23, 'RUS', '40', 1),
(24, 'RUS', '42', 1),
(25, 'RUS', '44', 1),
(26, 'RUS', '46', 1),
(27, 'RUS', '48', 1),
(28, 'RUS', '50', 1),
(29, 'RUS', '52', 1),
(30, 'UK', '6', 1),
(31, 'UK', '8', 1),
(32, 'UK', '10', 1),
(33, 'UK', '12', 1),
(34, 'UK', '14', 1),
(35, 'UK', '16', 1),
(36, 'UK', '18', 1),
(37, 'US', '2', 1),
(38, 'US', '4', 1),
(39, 'US', '6', 1),
(40, 'US', '8', 1),
(41, 'US', '10', 1),
(42, 'US', '12', 1),
(43, 'US', '14', 1),
(44, 'JEANS', '22-23', 2),
(45, 'JEANS', '24-25', 2),
(46, 'JEANS', '26-27', 2),
(47, 'JEANS', '28-29', 2),
(48, 'JEANS', '30-31', 2),
(49, 'JEANS', '32-33', 2),
(50, 'JEANS', '34-35', 2),
(51, 'JEANS', '36-37', 2),
(52, 'INT', 'XXS', 2),
(53, 'INT', 'XS', 2),
(54, 'INT', 'S', 2),
(55, 'INT', 'M', 2),
(56, 'INT', 'L', 2),
(57, 'INT', 'XL', 2),
(58, 'INT', 'XXL', 2),
(59, 'INT', 'XXXL', 2),
(60, 'IT', '35', 3),
(61, 'IT', '35.5', 3),
(62, 'IT', '36', 3),
(63, 'IT', '36.5', 3),
(64, 'IT', '37', 3),
(65, 'IT', '37.5', 3),
(66, 'IT', '38', 3),
(67, 'IT', '38.5', 3),
(68, 'IT', '39', 3),
(69, 'IT', '39.5', 3),
(70, 'IT', '40', 3),
(71, 'IT', '40.5', 3),
(72, 'IT', '41', 3),
(73, 'US', '4.5', 3),
(74, 'US', '5', 3),
(75, 'US', '5.5', 3),
(76, 'US', '6', 3),
(77, 'US', '6.5', 3),
(78, 'US', '7', 3),
(79, 'US', '7.5', 3),
(80, 'US', '8', 3),
(81, 'US', '8.5', 3),
(82, 'US', '9', 3),
(83, 'US', '9.5', 3),
(84, 'US', '10', 3),
(85, 'US', '10.5', 3),
(86, 'FR', '36', 3),
(87, 'FR', '36.5', 3),
(88, 'FR', '37', 3),
(89, 'FR', '37.5', 3),
(90, 'FR', '38', 3),
(91, 'FR', '38.5', 3),
(92, 'FR', '39', 3),
(93, 'FR', '39.5', 3),
(94, 'FR', '40', 3),
(95, 'FR', '40.5', 3),
(96, 'FR', '41', 3),
(97, 'FR', '41.5', 3),
(98, 'FR', '42', 3),
(99, 'UK', '2', 3),
(100, 'UK', '2.5', 3),
(101, 'UK', '3', 3),
(102, 'UK', '3.5', 3),
(103, 'UK', '4', 3),
(104, 'UK', '4,5', 3),
(105, 'UK', '5', 3),
(106, 'UK', '5,5', 3),
(107, 'UK', '6', 3),
(108, 'UK', '6,5', 3),
(109, 'UK', '7', 3),
(110, 'UK', '7,5', 3),
(111, 'UK', '8', 3),
(112, 'INT', 'XXS', 4),
(113, 'INT', 'XS', 4),
(114, 'INT', 'S', 4),
(115, 'INT', 'M', 4),
(116, 'INT', 'L', 4),
(117, 'INT', 'XL', 4),
(118, 'INT', 'XXL', 4),
(119, 'INT', 'ONE SIZE', 4),
(120, 'EU', '65', 4),
(121, 'EU', '70', 4),
(122, 'EU', '75', 4),
(123, 'EU', '80', 4),
(124, 'EU', '85', 4),
(125, 'EU', '90', 4),
(126, 'EU', '95', 4),
(127, 'EU', '100-105', 4),
(128, 'INT', 'XXS', 5),
(129, 'INT', 'XS', 5),
(130, 'INT', 'S', 5),
(131, 'INT', 'M', 5),
(132, 'INT', 'L', 5),
(133, 'INT', 'XL', 5),
(134, 'INT', 'XXL', 5),
(135, 'EU', '38', 5),
(136, 'EU', '40', 5),
(137, 'EU', '42', 5),
(138, 'EU', '44', 5),
(139, 'EU', '46', 5),
(140, 'EU', '48', 5),
(141, 'EU', '50', 5),
(142, 'IT', '42', 5),
(143, 'IT', '44', 5),
(144, 'IT', '46', 5),
(145, 'IT', '48', 5),
(146, 'IT', '50', 5),
(147, 'IT', '52', 5),
(148, 'IT', '54', 5),
(149, 'DE', '42', 5),
(150, 'DE', '44', 5),
(151, 'DE', '46', 5),
(152, 'DE', '48', 5),
(153, 'DE', '50', 5),
(154, 'DE', '52', 5),
(155, 'DE', '54', 5),
(156, 'US', '32', 5),
(157, 'US', '34', 5),
(158, 'US', '36', 5),
(159, 'US', '38', 5),
(160, 'US', '40', 5),
(161, 'US', '42', 5),
(162, 'US', '44', 5),
(163, 'UK', '32', 5),
(164, 'UK', '34', 5),
(165, 'UK', '36', 5),
(166, 'UK', '38', 5),
(167, 'UK', '40', 5),
(168, 'UK', '42', 5),
(169, 'UK', '44', 5),
(170, 'RUS', '44', 5),
(171, 'RUS', '46', 5),
(172, 'RUS', '48', 5),
(173, 'RUS', '50', 5),
(174, 'RUS', '52', 5),
(175, 'RUS', '54', 5),
(176, 'RUS', '56', 5),
(177, 'JEANS', '28', 6),
(178, 'JEANS', '29', 6),
(179, 'JEANS', '30', 6),
(180, 'JEANS', '31', 6),
(181, 'JEANS', '32', 6),
(182, 'JEANS', '33', 6),
(183, 'JEANS', '34', 6),
(184, 'JEANS', '36', 6),
(185, 'JEANS', '38', 6),
(186, 'INT', 'XXS', 6),
(187, 'INT', 'XS', 6),
(188, 'INT', 'XS', 6),
(189, 'INT', 'S', 6),
(190, 'INT', 'S', 6),
(191, 'INT', 'M', 6),
(192, 'INT', 'M', 6),
(193, 'INT', 'L', 6),
(194, 'INT', 'L', 6),
(195, 'EU', '38', 6),
(196, 'EU', '40', 6),
(197, 'EU', '40', 6),
(198, 'EU', '42', 6),
(199, 'EU', '42', 6),
(200, 'EU', '44', 6),
(201, 'EU', '44', 6),
(202, 'EU', '46', 6),
(203, 'EU', '46', 6),
(204, 'IT', '42', 6),
(205, 'IT', '44', 6),
(206, 'IT', '44', 6),
(207, 'IT', '46', 6),
(208, 'IT', '46', 6),
(209, 'IT', '48', 6),
(210, 'IT', '48', 6),
(211, 'IT', '50', 6),
(212, 'IT', '50', 6),
(213, 'US', '28', 6),
(214, 'US', '32', 6),
(215, 'US', '34', 6),
(216, 'US', '34', 6),
(217, 'US', '36', 6),
(218, 'US', '36', 6),
(219, 'US', '38', 6),
(220, 'US', '38', 6),
(221, 'US', '40', 6),
(222, 'US', '40', 6),
(223, 'UK', '32', 6),
(224, 'UK', '34', 6),
(225, 'UK', '34', 6),
(226, 'UK', '36', 6),
(227, 'UK', '36', 6),
(228, 'UK', '38', 6),
(229, 'UK', '38', 6),
(230, 'UK', '40', 6),
(231, 'UK', '40', 6),
(232, 'EU', '39', 7),
(233, 'EU', '39.5', 7),
(234, 'EU', '40', 7),
(235, 'EU', '40.5', 7),
(236, 'EU', '41', 7),
(237, 'EU', '41.5', 7),
(238, 'EU', '42', 7),
(239, 'EU', '42.5', 7),
(240, 'EU', '43', 7),
(241, 'EU', '43.5', 7),
(242, 'EU', '44', 7),
(243, 'EU', '44.5', 7),
(244, 'EU', '45', 7),
(245, 'EU', '45.5', 7),
(246, 'EU', '46', 7),
(247, 'EU', '46.5', 7),
(248, 'EU', '47', 7),
(249, 'US', '6', 7),
(250, 'US', '6.5', 7),
(251, 'US', '7', 7),
(252, 'US', '7.5', 7),
(253, 'US', '8', 7),
(254, 'US', '8.5', 7),
(255, 'US', '9', 7),
(256, 'US', '9.5', 7),
(257, 'US', '10', 7),
(258, 'US', '10.5', 7),
(259, 'US', '11', 7),
(260, 'US', '11.5', 7),
(261, 'US', '12', 7),
(262, 'US', '12.5', 7),
(263, 'US', '13', 7),
(264, 'US', '13.5', 7),
(265, 'US', '14', 7),
(266, 'UK', '5', 7),
(267, 'UK', '5.5', 7),
(268, 'UK', '6', 7),
(269, 'UK', '6.5', 7),
(270, 'UK', '7', 7),
(271, 'UK', '7.5', 7),
(272, 'UK', '8', 7),
(273, 'UK', '8.5', 7),
(274, 'UK', '9', 7),
(275, 'UK', '9.5', 7),
(276, 'UK', '10', 7),
(277, 'UK', '10.5', 7),
(278, 'UK', '11', 7),
(279, 'UK', '11.5', 7),
(280, 'UK', '12', 7),
(281, 'UK', '12.5', 7),
(282, 'UK', '13', 7),
(283, 'INT', 'XS', 8),
(284, 'INT', 'S', 8),
(285, 'INT', 'M', 8),
(286, 'INT', 'L', 8),
(287, 'INT', 'XL', 8),
(288, 'INT', 'XXL', 8),
(289, 'INT', '3XL', 8),
(290, 'INT', '4XL', 8),
(291, 'INT', 'ONE SIZE', 8),
(292, 'EU', '85', 8),
(293, 'EU', '90', 8),
(294, 'EU', '95', 8),
(295, 'EU', '100', 8),
(296, 'EU', '105', 8),
(297, 'EU', '110', 8),
(298, 'EU', '115', 8),
(299, 'EU', '120', 8),
(300, 'Age', '0 m', 9),
(301, 'Age', '1 m', 9),
(302, 'Age', '3 m', 9),
(303, 'Age', '6 m', 9),
(304, 'Age', '9 m', 9),
(305, 'Age', '12 m', 9),
(306, 'Age', '18 m', 9),
(307, 'Age', '2 y', 9),
(308, 'Age', '3 y', 9),
(309, 'Age', '4 y', 9),
(310, 'Age', '5 y', 9),
(311, 'Age', '6 y', 9),
(312, 'Age', '7 y', 9),
(313, 'Age', '8 y', 9),
(314, 'Age', '9 y', 9),
(315, 'Age', '10 y', 9),
(316, 'Age', '11 y', 9),
(317, 'Age', '12 y', 9),
(318, 'Age', '13 y', 9),
(319, 'Age', '14 y', 9),
(320, 'Age', '15 y', 9),
(321, 'EU', '50 cm', 9),
(322, 'EU', '56 cm', 9),
(323, 'EU', '62 cm', 9),
(324, 'EU', '68 cm', 9),
(325, 'EU', '74 cm', 9),
(326, 'EU', '80 cm', 9),
(327, 'EU', '86 cm', 9),
(328, 'EU', '92 cm', 9),
(329, 'EU', '98 cm', 9),
(330, 'EU', '104 cm', 9),
(331, 'EU', '110 cm', 9),
(332, 'EU', '116 cm', 9),
(333, 'EU', '122 cm', 9),
(334, 'EU', '128 cm', 9),
(335, 'EU', '134 cm', 9),
(336, 'EU', '140 cm', 9),
(337, 'EU', '146 cm', 9),
(338, 'EU', '152 cm', 9),
(339, 'EU', '156 cm', 9),
(340, 'EU', '158 cm', 9),
(341, 'EU', '164 cm', 9),
(342, 'EU', '0', 10),
(343, 'EU', '0.5', 10),
(344, 'EU', '1', 10),
(345, 'EU', '2', 10),
(346, 'EU', '3', 10),
(347, 'EU', '4', 10),
(348, 'EU', '4.5', 10),
(349, 'EU', '5', 10),
(350, 'EU', '6', 10),
(351, 'EU', '7', 10),
(352, 'EU', '8', 10),
(353, 'EU', '8.5', 10),
(354, 'EU', '9', 10),
(355, 'EU', '10', 10),
(356, 'EU', '11', 10),
(357, 'EU', '12', 10),
(358, 'EU', '12.5', 10),
(359, 'EU', '13', 10),
(360, 'EU', '1 Adult', 10),
(361, 'EU', '2 Adult', 10),
(362, 'EU', '2.5 Adult', 10),
(363, 'EU', '3 Adult', 10),
(364, 'EU', '4 Adult', 10),
(365, 'EU', '5 Adult', 10),
(366, 'EU', '6 Adult', 10),
(367, 'EU', '6.5 Adult', 10),
(368, 'UK', '15', 10),
(369, 'UK', '16', 10),
(370, 'UK', '17', 10),
(371, 'UK', '18', 10),
(372, 'UK', '19', 10),
(373, 'UK', '20', 10),
(374, 'UK', '21', 10),
(375, 'UK', '22', 10),
(376, 'UK', '23', 10),
(377, 'UK', '24', 10),
(378, 'UK', '25', 10),
(379, 'UK', '26', 10),
(380, 'UK', '27', 10),
(381, 'UK', '28', 10),
(382, 'UK', '29', 10),
(383, 'UK', '30', 10),
(384, 'UK', '31', 10),
(385, 'UK', '32', 10),
(386, 'UK', '33', 10),
(387, 'UK', '34', 10),
(388, 'UK', '35', 10),
(389, 'UK', '36', 10),
(390, 'UK', '37', 10),
(391, 'UK', '38', 10),
(392, 'UK', '39', 10),
(393, 'UK', '40', 10),
(394, 'INT', 'XS', 11),
(395, 'INT', 'S', 11),
(396, 'INT', 'M', 11),
(397, 'INT', 'L', 11),
(398, 'INT', 'ONE SIZE', 11),
(399, 'CHEST, cm', '76-81', 11),
(400, 'CHEST, cm', '86-91', 11),
(401, 'CHEST, cm', '97-102', 11),
(402, 'CHEST, cm', '107-112', 11),
(403, 'WAIST, cm', '71-76', 11),
(404, 'WAIST, cm', '76-81', 11),
(405, 'WAIST, cm', '81-84', 11),
(406, 'WAIST, cm', '84-86', 11),
(407, 'EU', '37', 12),
(408, 'EU', '37.5', 12),
(409, 'EU', '38', 12),
(410, 'EU', '39', 12),
(411, 'EU', '39.5', 12),
(412, 'EU', '40', 12),
(413, 'EU', '40.5', 12),
(414, 'EU', '41.5', 12),
(415, 'EU', '42', 12),
(416, 'EU', '42.5', 12),
(417, 'CM', '28', 12),
(418, 'CM', '23', 12),
(419, 'CM', '23.5', 12),
(420, 'CM', '24', 12),
(421, 'CM', '24.5', 12),
(422, 'CM', '25', 12),
(423, 'CM', '25.3', 12),
(424, 'CM', '25.5', 12),
(425, 'CM', '26', 12),
(426, 'CM', '26.5', 12),
(427, 'CM', '27', 12);

-- --------------------------------------------------------

--
-- Структура таблицы `size_chart_cat`
--

CREATE TABLE IF NOT EXISTS `size_chart_cat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `top_category` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `top_category` (`top_category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=13 ;

--
-- Дамп данных таблицы `size_chart_cat`
--

INSERT INTO `size_chart_cat` (`id`, `name`, `top_category`) VALUES
(1, 'Women''s clothing', 2),
(2, 'Women''s jeans', 2),
(3, 'Women''s shoes', 2),
(4, 'Women''s accessories', 2),
(5, 'Men''s clothing', 3),
(6, 'Men''s jeans', 3),
(7, 'Men''s shoes', 3),
(8, 'Men''s accessories', 3),
(9, 'Kid''s clothing', 4),
(10, 'Kid''s shoes', 4),
(11, 'Unisex clothing', 1),
(12, 'Unisex shoes', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `size_type`
--

CREATE TABLE IF NOT EXISTS `size_type` (
  `id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `size_type`
--

INSERT INTO `size_type` (`id`, `type`) VALUES
(1, 'Jackets'),
(2, 'T-Shirts'),
(3, 'Shorts'),
(4, 'Hats'),
(5, 'Blazers'),
(6, 'Footwear'),
(7, 'Coats'),
(8, 'Cardigans'),
(9, 'Jumpers'),
(10, 'Swimwear'),
(11, 'Vests'),
(12, 'Belts'),
(13, 'Sweatshirts'),
(14, 'Jeans'),
(15, 'Trousers'),
(16, 'Dresses'),
(17, 'Leggings'),
(18, 'Skirts'),
(19, 'Tops'),
(20, 'Tights');

-- --------------------------------------------------------

--
-- Структура таблицы `transaction`
--

CREATE TABLE IF NOT EXISTS `transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `txn_id` varchar(255) COLLATE utf8_bin NOT NULL,
  `order_id` int(11) NOT NULL,
  `total` decimal(9,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `transaction_seller`
--

CREATE TABLE IF NOT EXISTS `transaction_seller` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `txn_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `order_item_id` int(11) NOT NULL,
  `total` decimal(9,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `order_item_id` (`order_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'User ID',
  `username` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'User Name',
  `password` char(40) COLLATE utf8_bin NOT NULL COMMENT 'User Password',
  `email` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'User Email',
  `registration_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Registration Date',
  `last_login` datetime DEFAULT NULL COMMENT 'Last Login',
  `country_id` int(11) NOT NULL COMMENT 'User Country',
  `status` enum('active','blocked') COLLATE utf8_bin NOT NULL DEFAULT 'blocked' COMMENT 'User Status',
  `language` char(2) COLLATE utf8_bin NOT NULL DEFAULT 'en',
  `qb_user_id` int(11) DEFAULT NULL,
  `access_hash` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `time_send` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=54 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `registration_date`, `last_login`, `country_id`, `status`, `language`, `qb_user_id`, `access_hash`, `time_send`) VALUES
(6, 'test', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'test@gmail.com', '2015-09-22 10:26:19', '2016-03-14 05:30:46', 1, 'active', 'en', NULL, 'c6087ed64cf298d7fbce1c6697501cb0', '2015-09-23 14:54:15'),
(19, 'buyer1', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'buyer1@buyer.ru', '2015-10-30 10:49:00', '2016-01-27 03:48:50', 3, 'active', 'en', NULL, NULL, NULL),
(20, 'luckum', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'luckum@gmail.com', '2015-10-30 12:41:13', '2016-01-18 08:26:14', 181, 'active', 'en', NULL, NULL, NULL),
(21, 'fbdhndfh', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'sf`sdg@gmail.com', '2015-12-01 16:28:21', NULL, 181, 'active', 'en', NULL, NULL, NULL),
(22, 'user123', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'user123@qwe.123', '2015-12-18 09:32:09', '2016-01-27 03:49:53', 6, 'blocked', 'en', NULL, NULL, NULL),
(24, 'Vasya', '6184d6847d594ec75c4c07514d4bb490d5e166df', 's0per@mail.ru', '2016-01-18 13:39:25', '2016-01-28 09:19:17', 181, 'active', 'en', NULL, '598fa63da7c1fb66a5c4adbb65d4e22e', '2016-02-10 07:11:18'),
(25, 'test3', 'b13773cfee62f832cacb618b257feec972f30b13', 'test3@test.com', '2016-01-19 08:16:07', '2016-01-22 09:00:04', 1, 'active', 'en', NULL, '8f792575806ec0d26eec4c6d5daf8d55', '2016-01-22 09:00:29'),
(27, 'useruser1', 'f6d053374c2f3e37c686201a40365e1250f6da11', 'useruser@user.user', '2016-01-28 07:46:38', '2016-02-17 07:54:26', 14, 'blocked', 'en', NULL, NULL, NULL),
(28, 'test', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'kfsh@nk.sdf', '2016-02-08 09:01:45', NULL, 16, 'blocked', 'en', NULL, NULL, NULL),
(29, 'test-4', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'test-4@test.com', '2016-02-08 09:57:00', NULL, 14, 'blocked', 'en', NULL, NULL, NULL),
(35, 'Ekaterina', '2e650e210d01aeddad09ae4fbab35d3ccd298938', 'etsukruk@gmail.com', '2016-02-10 11:50:06', '2016-02-12 04:23:05', 181, 'blocked', 'en', NULL, 'b6b903ec9618f2c41c097e6de6ba0ec6', '2016-02-12 04:18:24'),
(38, 'ekaterina', '2e650e210d01aeddad09ae4fbab35d3ccd298938', 'ekaterina.woesthoff@gmail.com', '2016-02-10 12:54:42', '2016-03-14 04:59:53', 81, 'blocked', 'en', NULL, NULL, NULL),
(39, 'user1234', 'd7316a3074d562269cf4302e4eed46369b523687', 'spellsin9er@gmail.com', '2016-02-11 13:49:57', '2016-02-11 08:55:32', 2, 'blocked', 'en', NULL, '254d4eb2890e9112edcc00293ebca6da', '2016-02-11 08:50:11'),
(41, 'is5157', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'is5157@mail.ru', '2016-02-15 10:51:41', '2016-03-14 22:53:15', 113, 'blocked', 'en', NULL, NULL, NULL),
(42, 'testname', '353e8061f2befecb6818ba0c034c632fb0bcae1b', 'ivan.qwww@yandex.ru', '2016-02-22 11:05:02', '2016-02-22 06:05:02', 181, 'blocked', 'en', NULL, '360d4aa32100de35825e530239bbb3b3', '2016-03-04 07:09:31'),
(44, 'no name', 'afdcb6b0db1865c10e1e6e86c1e806b501035ad2', 'no@n.bn', '2016-02-26 11:20:36', '2016-02-26 06:20:36', 151, 'blocked', 'en', NULL, NULL, NULL),
(45, 'test user 1', '4433d57993f8d8a99c9ecf3d70f29962d01c8df0', 't@t.t', '2016-02-26 12:34:59', '2016-02-26 07:35:00', 214, 'blocked', 'en', 22, NULL, NULL),
(46, 'mumba umba', 'a832d8b548a3a4fedd2593969fa85a7748a49f05', 'um@m.m', '2016-02-26 12:35:59', '2016-02-26 07:35:59', 228, 'blocked', 'en', 23, NULL, NULL),
(47, 'test-17', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'test-17@mail.ru', '2016-02-26 12:37:15', '2016-02-26 07:37:16', 1, 'blocked', 'en', 24, NULL, NULL),
(48, 'user_777', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'usr@mail.to', '2016-02-26 12:40:38', '2016-02-26 07:40:39', 48, 'blocked', 'en', 25, NULL, NULL),
(49, 'is5157', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '1111@gmail.com', '2016-02-26 12:43:35', '2016-02-26 07:43:35', 5, 'blocked', 'en', 26, NULL, NULL),
(50, 'test', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'test-15@mail.ru', '2016-02-26 12:47:17', '2016-02-26 07:47:18', 14, 'blocked', 'en', 27, NULL, NULL),
(51, 'noname user ', '3825d70350a385712f92690c79d15aab7b90b53d', 'em@mm.m', '2016-02-26 12:54:26', '2016-02-26 07:54:26', 128, 'blocked', 'en', 28, NULL, NULL),
(52, 'final server test user', '42a82a10f3a311aec6e389c1186be545b0ef0c18', 'f@f.f', '2016-02-26 12:59:38', '2016-02-26 07:59:38', 70, 'blocked', 'en', 29, NULL, NULL),
(53, 'test-500', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'sendmail210@gmail.com', '2016-03-11 14:03:33', '2016-03-11 09:03:33', 172, 'blocked', 'en', 30, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `wishlist`
--

CREATE TABLE IF NOT EXISTS `wishlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `product_id`) VALUES
(2, 19, 26);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `alerts`
--
ALTER TABLE `alerts`
  ADD CONSTRAINT `alerts_ibfk_4` FOREIGN KEY (`size_type`) REFERENCES `size_chart` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `alerts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alerts_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alerts_ibfk_3` FOREIGN KEY (`subcategory_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `attribute_name`
--
ALTER TABLE `attribute_name`
  ADD CONSTRAINT `attribute_name_ibfk_1` FOREIGN KEY (`attribute_id`) REFERENCES `attribute` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `bid`
--
ALTER TABLE `bid`
  ADD CONSTRAINT `bid_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bid_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `category_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `category_ibfk_2` FOREIGN KEY (`size_chart_cat_id`) REFERENCES `size_chart_cat` (`id`);

--
-- Ограничения внешнего ключа таблицы `category_name`
--
ALTER TABLE `category_name`
  ADD CONSTRAINT `category_name_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `filters`
--
ALTER TABLE `filters`
  ADD CONSTRAINT `filters_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `homepage_block_content`
--
ALTER TABLE `homepage_block_content`
  ADD CONSTRAINT `homepage_block_content_ibfk_1` FOREIGN KEY (`block_id`) REFERENCES `homepage_block` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `offers`
--
ALTER TABLE `offers`
  ADD CONSTRAINT `offers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `offers_ibfk_2` FOREIGN KEY (`seller_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `offers_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`shipping_address_id`) REFERENCES `shipping_address` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `order_item_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_item_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_item_ibfk_3` FOREIGN KEY (`coupon_id`) REFERENCES `shipping_coupon` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `page_content`
--
ALTER TABLE `page_content`
  ADD CONSTRAINT `page_content_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `page` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_ibfk_3` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_ibfk_4` FOREIGN KEY (`size_type`) REFERENCES `size_chart` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `product_attribute`
--
ALTER TABLE `product_attribute`
  ADD CONSTRAINT `product_attribute_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_attribute_ibfk_2` FOREIGN KEY (`attribute_id`) REFERENCES `attribute` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `product_invalid`
--
ALTER TABLE `product_invalid`
  ADD CONSTRAINT `product_invalid_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rating_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rating_ibfk_3` FOREIGN KEY (`seller_id`) REFERENCES `product` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `seller_profile`
--
ALTER TABLE `seller_profile`
  ADD CONSTRAINT `seller_profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `seller_profile_ibfk_country` FOREIGN KEY (`billing_country_id`) REFERENCES `country` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `shipping_address`
--
ALTER TABLE `shipping_address`
  ADD CONSTRAINT `shipping_address_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `shipping_address_ibfk_2` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `shipping_rate`
--
ALTER TABLE `shipping_rate`
  ADD CONSTRAINT `shipping_rate_ibfk_1` FOREIGN KEY (`seller_country_id`) REFERENCES `country` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `shipping_rate_ibfk_2` FOREIGN KEY (`buyer_country_id`) REFERENCES `country` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `shipping_rate_default`
--
ALTER TABLE `shipping_rate_default`
  ADD CONSTRAINT `shipping_rate_default_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `size`
--
ALTER TABLE `size`
  ADD CONSTRAINT `size_ibfk_1` FOREIGN KEY (`size_type_id`) REFERENCES `size_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `size_chart`
--
ALTER TABLE `size_chart`
  ADD CONSTRAINT `size_chart_ibfk_1` FOREIGN KEY (`size_chart_cat_id`) REFERENCES `size_chart_cat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `size_chart_cat`
--
ALTER TABLE `size_chart_cat`
  ADD CONSTRAINT `size_chart_cat_ibfk_1` FOREIGN KEY (`top_category`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `transaction_seller`
--
ALTER TABLE `transaction_seller`
  ADD CONSTRAINT `transaction_seller_ibfk_1` FOREIGN KEY (`order_item_id`) REFERENCES `order_item` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
