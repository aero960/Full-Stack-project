-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 05 Kwi 2020, 13:27
-- Wersja serwera: 8.0.13-4
-- Wersja PHP: 7.2.24-0ubuntu0.18.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `rWKlUeAAgN`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `category`
--

CREATE TABLE `category` (
  `category_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `category_title` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `category_content` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `comments`
--

CREATE TABLE `comments` (
  `comment_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `comment_content` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `comment_title` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comment_created_at` datetime DEFAULT NULL,
  `realted_to` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `enable` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `comment_post`
--

CREATE TABLE `comment_post` (
  `cp_post_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cp_comment_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `guests`
--

CREATE TABLE `guests` (
  `guest_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci DEFAULT 'unknown'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `naughty_users`
--

CREATE TABLE `naughty_users` (
  `ng_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `reason` varchar(1000) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `post`
--

CREATE TABLE `post` (
  `post_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `post_title` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `post_published` tinyint(1) NOT NULL DEFAULT '0',
  `post_create_at` datetime NOT NULL,
  `post_published_at` datetime DEFAULT NULL,
  `post_updated_at` datetime NOT NULL,
  `post_content` varchar(15000) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `post`
--

INSERT INTO `post` (`post_id`, `user_id`, `post_title`, `post_published`, `post_create_at`, `post_published_at`, `post_updated_at`, `post_content`) VALUES
('izljw6206430', 'gcfcz778558', 'zombie\'s are everywhere', 1, '2020-04-04 11:55:31', NULL, '2020-04-04 11:55:31', 'zombie ipsum reversus ab viral inferno, nam rick grimes malum cerebro. de carne lumbering animata corpora quaeritis. summus brains sit​​, morbo vel maleficia? de apocalypsi gorger omero undead survivor dictum mauris. hi mindless mortuis soulless creaturas, imo evil stalking monstra adventus resi dentevil vultus comedat cerebella viventium. qui animated corpse, cricket bat max brucks terribilem incessu zomby. the voodoo sacerdos flesh eater, suscitat mortuos comedere carnem virus. zonbi tattered for solum oculi eorum defunctis go lum cerebro. nescio brains an undead zombies. sicut malus putrid voodoo horror. nigh tofth eliv ingdead.'),
('izvde543399540', 'gcfcz778558', 'cupcake ipsum', 1, '2020-04-04 06:19:17', '2020-04-04 06:19:36', '2020-04-04 07:11:04', 'cupcake ipsum dolor sit amet dessert. pie chupa chups donut i love. danish tart ice cream i love. i love muffin sugar plum biscuit. dessert danish marshmallow cotton candy wafer.'),
('jvaqv60', 'gcfcz778558', 'zombie\'s are everywhere', 1, '2020-04-04 10:42:10', NULL, '2020-04-04 10:42:10', 'zombie ipsum reversus ab viral inferno, nam rick grimes malum cerebro. de carne lumbering animata corpora quaeritis. summus brains sit​​, morbo vel maleficia? de apocalypsi gorger omero undead survivor dictum mauris. hi mindless mortuis soulless creaturas, imo evil stalking monstra adventus resi dentevil vultus comedat cerebella viventium. qui animated corpse, cricket bat max brucks terribilem incessu zomby. the voodoo sacerdos flesh eater, suscitat mortuos comedere carnem virus. zonbi tattered for solum oculi eorum defunctis go lum cerebro. nescio brains an undead zombies. sicut malus putrid voodoo horror. nigh tofth eliv ingdead.'),
('pfrmv24625', 'gcfcz778558', 'ocean creatures lorem ipsum', 1, '2020-04-04 11:57:12', NULL, '2020-04-04 11:57:12', 'breathing heavily pipefish, cold and smiling mandarinfish, peaclam slicing water fingernail clam, is swimming sea grape rock lobster at indian ocean. peppered moray clownfish hawkfish a.'),
('ttcvo2268', 'gcfcz778558', 'yar pirate ipsum', 1, '2020-04-04 11:58:13', NULL, '2020-04-04 11:58:13', 'prow scuttle parrel provost sail ho shrouds spirits boom mizzenmast yardarm. pinnace holystone mizzenmast quarter crow\'s nest nipperkin grog yardarm hempen halter furl. swab barque interloper chantey doubloon starboard grog black jack gangway rutters.');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `post_category`
--

CREATE TABLE `post_category` (
  `pc_post_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `pc_category_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `post_category`
--

INSERT INTO `post_category` (`pc_post_id`, `pc_category_id`) VALUES
('kvgwn8357440', 'nttkq15946'),
('izvde543399540', 'nttkq15946'),
('znzef394', 'ccouz49333133'),
('izvde543399540', 'ccouz49333133'),
('jvaqv60', 'ccouz49333133');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `post_tag`
--

CREATE TABLE `post_tag` (
  `pt_post_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `pt_tag_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `post_tag`
--

INSERT INTO `post_tag` (`pt_post_id`, `pt_tag_id`) VALUES
('kvgwn8357440', 'nyyrt0'),
('kvgwn8357440', 'rqmwv3737'),
('fcflq207381', 'angfc96101'),
('fcflq207381', 'lnwvb43188637'),
('fcflq207381', 'jyfiy7'),
('yczwv890', 'angfc96101'),
('yczwv890', 'lnwvb43188637'),
('yczwv890', 'jyfiy7'),
('mjxxg17', 'angfc96101'),
('mjxxg17', 'lnwvb43188637'),
('mjxxg17', 'jyfiy7'),
('amfci38285941', 'angfc96101'),
('amfci38285941', 'lnwvb43188637'),
('amfci38285941', 'jyfiy7'),
('pzfiv2994', 'angfc96101'),
('pzfiv2994', 'lnwvb43188637'),
('pzfiv2994', 'jyfiy7'),
('rxpxo578472', 'angfc96101'),
('rxpxo578472', 'lnwvb43188637'),
('rxpxo578472', 'jyfiy7'),
('eostb472', 'angfc96101'),
('eostb472', 'lnwvb43188637'),
('eostb472', 'jyfiy7'),
('snjut717929', 'angfc96101'),
('snjut717929', 'lnwvb43188637'),
('snjut717929', 'jyfiy7'),
('bcond67652', 'angfc96101'),
('bcond67652', 'lnwvb43188637'),
('bcond67652', 'jyfiy7'),
('zocrr103278', 'angfc96101'),
('zocrr103278', 'lnwvb43188637'),
('zocrr103278', 'jyfiy7'),
('kmfcu10', 'angfc96101'),
('kmfcu10', 'lnwvb43188637'),
('kmfcu10', 'jyfiy7'),
('ckrxf0', 'angfc96101'),
('ckrxf0', 'lnwvb43188637'),
('ckrxf0', 'jyfiy7'),
('kugfm572095', 'angfc96101'),
('kugfm572095', 'lnwvb43188637'),
('kugfm572095', 'jyfiy7'),
('bjjeh7402183', 'angfc96101'),
('bjjeh7402183', 'lnwvb43188637'),
('bjjeh7402183', 'jyfiy7'),
('dhymw90993695', 'angfc96101'),
('dhymw90993695', 'lnwvb43188637'),
('dhymw90993695', 'jyfiy7'),
('fdlrq3348', 'angfc96101'),
('fdlrq3348', 'lnwvb43188637'),
('fdlrq3348', 'jyfiy7'),
('wxyxn520451', 'angfc96101'),
('wxyxn520451', 'lnwvb43188637'),
('wxyxn520451', 'jyfiy7'),
('nbcso0', 'angfc96101'),
('nbcso0', 'lnwvb43188637'),
('nbcso0', 'jyfiy7'),
('bjecu7959577', 'angfc96101'),
('bjecu7959577', 'lnwvb43188637'),
('bjecu7959577', 'jyfiy7'),
('dxsns5', 'angfc96101'),
('dxsns5', 'lnwvb43188637'),
('dxsns5', 'jyfiy7'),
('sduea781164563', 'angfc96101'),
('sduea781164563', 'lnwvb43188637'),
('sduea781164563', 'jyfiy7'),
('izrhn2415', 'angfc96101'),
('izrhn2415', 'lnwvb43188637'),
('izrhn2415', 'jyfiy7'),
('tqbfd22755200', 'angfc96101'),
('tqbfd22755200', 'lnwvb43188637'),
('tqbfd22755200', 'jyfiy7'),
('hrtnb189', 'angfc96101'),
('hrtnb189', 'lnwvb43188637'),
('hrtnb189', 'jyfiy7'),
('rmetz28544', 'angfc96101'),
('rmetz28544', 'lnwvb43188637'),
('rmetz28544', 'jyfiy7'),
('gnqoh1647611', 'angfc96101'),
('gnqoh1647611', 'lnwvb43188637'),
('gnqoh1647611', 'jyfiy7'),
('zvdbh98', 'angfc96101'),
('zvdbh98', 'lnwvb43188637'),
('zvdbh98', 'jyfiy7'),
('unxda48231759', 'angfc96101'),
('unxda48231759', 'lnwvb43188637'),
('unxda48231759', 'jyfiy7'),
('jxlyp81', 'angfc96101'),
('jxlyp81', 'lnwvb43188637'),
('jxlyp81', 'jyfiy7'),
('wbqyd573336287', 'angfc96101'),
('wbqyd573336287', 'lnwvb43188637'),
('wbqyd573336287', 'jyfiy7'),
('vsdvq151569', 'angfc96101'),
('vsdvq151569', 'lnwvb43188637'),
('vsdvq151569', 'jyfiy7'),
('tessl156562246', 'angfc96101'),
('tessl156562246', 'lnwvb43188637'),
('tessl156562246', 'jyfiy7'),
('kreui3724', 'angfc96101'),
('kreui3724', 'lnwvb43188637'),
('kreui3724', 'jyfiy7'),
('xeugv2', 'angfc96101'),
('xeugv2', 'lnwvb43188637'),
('xeugv2', 'jyfiy7'),
('gfhfl97439', 'angfc96101'),
('gfhfl97439', 'lnwvb43188637'),
('gfhfl97439', 'jyfiy7'),
('xegdf648150', 'angfc96101'),
('xegdf648150', 'lnwvb43188637'),
('xegdf648150', 'jyfiy7'),
('phuqp3866581', 'angfc96101'),
('phuqp3866581', 'lnwvb43188637'),
('phuqp3866581', 'jyfiy7'),
('gdvqf56080', 'angfc96101'),
('gdvqf56080', 'lnwvb43188637'),
('gdvqf56080', 'jyfiy7'),
('gzajv217705', 'angfc96101'),
('gzajv217705', 'lnwvb43188637'),
('gzajv217705', 'jyfiy7'),
('wonlt69', 'angfc96101'),
('wonlt69', 'lnwvb43188637'),
('wonlt69', 'jyfiy7'),
('rapgx119819', 'angfc96101'),
('rapgx119819', 'lnwvb43188637'),
('rapgx119819', 'jyfiy7'),
('artzc7', 'angfc96101'),
('artzc7', 'lnwvb43188637'),
('artzc7', 'jyfiy7'),
('izvde543399540', 'nyyrt0'),
('izvde543399540', 'rqmwv3737'),
('jvaqv60', 'angfc96101'),
('jvaqv60', 'lnwvb43188637'),
('jvaqv60', 'jyfiy7'),
('izljw6206430', 'angfc96101'),
('izljw6206430', 'lnwvb43188637'),
('izljw6206430', 'jyfiy7'),
('goynx332', 'angfc96101'),
('goynx332', 'lnwvb43188637'),
('goynx332', 'jyfiy7'),
('pfrmv24625', 'angfc96101'),
('pfrmv24625', 'lnwvb43188637'),
('pfrmv24625', 'jyfiy7'),
('ttcvo2268', 'angfc96101'),
('ttcvo2268', 'lnwvb43188637'),
('ttcvo2268', 'jyfiy7'),
('yytdf588', 'angfc96101'),
('yytdf588', 'lnwvb43188637'),
('yytdf588', 'jyfiy7');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `resources`
--

CREATE TABLE `resources` (
  `resources_id` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstName` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'unknow',
  `LastName` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'unknow',
  `mobile` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'unknow',
  `intro` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'unknow',
  `profile` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'unknow',
  `image` text COLLATE utf8_unicode_ci,
  `date_of_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `resources`
--

INSERT INTO `resources` (`resources_id`, `user_id`, `firstName`, `LastName`, `mobile`, `intro`, `profile`, `image`, `date_of_update`) VALUES
('ddzdl944627551', 'vlrtc227', 'unknow', 'unknow', 'unknow', 'unknow', 'unknow', NULL, NULL),
('hclvz3271', 'stdzd26445', 'unknow', 'unknow', 'unknow', 'unknow', 'unknow', NULL, NULL),
('jjqmw6954', 'viwpv99814', 'unknow', 'unknow', 'unknow', 'unknow', 'unknow', NULL, NULL),
('jnuov5690531', 'ifuyt991866', 'unknow', 'unknow', 'unknow', 'unknow', 'unknow', NULL, NULL),
('qrjjf869', 'asthq558', 'unknow', 'unknow', 'unknow', 'unknow', 'unknow', NULL, NULL),
('vodqa3963', 'hpumc1945787', 'unknow', 'unknow', 'unknow', 'unknow', 'unknow', NULL, NULL),
('vzhfu4429086', 'gcfcz778558', 'reginald', 'mason', '(899)-884-4554', 'zombies reversus ab inferno, nam malum cerebro. de carne animata corpora quaeritis. summus sit​​, morbo vel maleficia? de apocalypsi', 'zombie ipsum brains reversus ab cerebellum viral inferno, brein nam rick mend grimes malum cerveau cerebro. de carne cerebro lumbering animata cervello corpora quaeritis. summus thalamus brains sit​​, morbo basal ganglia vel maleficia? de braaaiiiins apocalypsi gorger omero prefrontal cortex undead survivor fornix dictum mauris. hi brains mindless mortuis limbic cortex soulless creaturas optic nerve, imo evil braaiinns', 'https://randomuser.me/api/portraits/men/75.jpg', '2020-04-04 06:09:43');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tags`
--

CREATE TABLE `tags` (
  `id_tag` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tag_title` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `tags`
--

INSERT INTO `tags` (`id_tag`, `tag_title`) VALUES
('nyyrt0', 'jadlo'),
('rqmwv3737', 'antychryst'),
('angfc96101', 'wojskowi'),
('lnwvb43188637', 'kanonierzy'),
('jyfiy7', 'rynsztunek');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `registeredAt` datetime DEFAULT NULL,
  `lastLogin` timestamp NULL DEFAULT NULL,
  `permission` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `registeredAt`, `lastLogin`, `permission`) VALUES
('asthq558', 'andzeewt', 'rwetwet', 'matulagsd@klopwetew', '2020-04-04 03:14:46', '2020-04-04 03:14:46', 1),
('gcfcz778558', 'reginald maso', 'reginald12345', 'reginald.mason@example.com', '2020-04-03 21:48:33', '2020-04-05 02:32:00', 10),
('hpumc1945787', 'andze', 'r', 'matulagsd@klop', '2020-04-04 03:14:04', '2020-04-04 03:14:04', 1),
('ifuyt991866', 'andzela112345', 'janczar', 'matula@op.pl', '2020-04-04 03:12:39', '2020-04-04 03:12:39', 1),
('stdzd26445', 'kamikadze', 'reginald12345', 'renia@comek.com', '2020-04-03 23:36:34', '2020-04-03 23:36:34', 1),
('viwpv99814', 'andzeewtrqwr', 'rwetwetrwq', 'matulagsd@klopwetewrwqr', '2020-04-04 03:15:07', '2020-04-04 03:15:07', 1),
('vlrtc227', 'andzeldf', 'jr', 'matulagsd@klops.chc', '2020-04-04 03:13:52', '2020-04-04 03:13:52', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users1`
--

CREATE TABLE `users1` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `category`
--
ALTER TABLE `category`
  ADD KEY `category_id` (`category_id`);

--
-- Indeksy dla tabeli `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeksy dla tabeli `comment_post`
--
ALTER TABLE `comment_post`
  ADD KEY `cp_post_id` (`cp_post_id`,`cp_comment_id`),
  ADD KEY `cp_comment_id` (`cp_comment_id`);

--
-- Indeksy dla tabeli `guests`
--
ALTER TABLE `guests`
  ADD PRIMARY KEY (`guest_id`),
  ADD UNIQUE KEY `guests_guest_id_uindex` (`guest_id`);

--
-- Indeksy dla tabeli `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeksy dla tabeli `post_category`
--
ALTER TABLE `post_category`
  ADD KEY `pc_post_id` (`pc_post_id`),
  ADD KEY `pc_category_id` (`pc_category_id`);

--
-- Indeksy dla tabeli `post_tag`
--
ALTER TABLE `post_tag`
  ADD KEY `pt_post_id_2` (`pt_post_id`);

--
-- Indeksy dla tabeli `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`resources_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_id_uindex` (`id`),
  ADD UNIQUE KEY `constr_ID` (`id`);

--
-- Indeksy dla tabeli `users1`
--
ALTER TABLE `users1`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `users1`
--
ALTER TABLE `users1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `resources`
--
ALTER TABLE `resources`
  ADD CONSTRAINT `resources_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
