

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";




CREATE TABLE `sport2025` (
  `id` int(11) NOT NULL,
  `fullname` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `age` int(2) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `category` varchar(20) NOT NULL,
  `reg_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



INSERT INTO `sport2025` (`id`, `fullname`, `email`, `age`, `gender`, `category`, `reg_time`) VALUES
(1, 'Melisent Chewter', 'mchewter0@usnews.com', 49, 'Female', 'ujumine', '2024-10-14'),
(2, 'Josie Durram', 'jdurram1@prnewswire.com', 18, 'Female', 'hyppe', '2024-10-14'),
(3, 'Darb Yu', 'dyu2@networksolutions.com', 25, 'Male', 'hyppe', '2024-10-14'),
(5, 'Uriel Bruster', 'ubruster4@twitter.com', 82, 'Male', 'hyppe', '2024-10-14'),
(6, 'Marven Cruess', 'mcruess5@home.pl', 85, 'Male', 'hyppe', '2024-10-14'),
(7, 'Lenna Livard', 'llivard6@studiopress.com', 68, 'Female', 'ratsutamine', '2024-10-14'),
(8, 'Aaron Furbank', 'afurbank7@moonfruit.com', 82, 'Male', '', '2024-10-14'),
(9, 'Pryce Murch', 'pmurch8@who.int', 74, 'Male', 'hyppe', '2024-10-14'),
(10, 'Brendin O''Kerin', 'bokerin9@etsy.com', 28, 'Male', '', '2024-10-14'),
(11, 'Shermy Cypler', 'scyplera@cnn.com', 93, 'Male', 'ratsutamine', '2024-10-14'),
(13, 'Edlin Pritchard', 'epritchardc@ucla.edu', 26, 'Male', 'jooks', '2024-10-14'),
(14, 'Ingemar Welds', 'iweldsd@icio.us', 71, 'Male', 'ratsutamine', '2024-10-14'),
(15, 'Janifer Feasby', 'jfeasbye@webs.com', 26, 'Female', 'hyppe', '2024-10-14'),
(17, 'Felipa Crippell', 'fcrippellg@wikia.com', 24, 'Female', 'ratsutamine', '2024-10-14'),
(18, 'Evania Duplan', 'eduplanh@booking.com', 70, 'Female', 'hyppe', '2024-10-14'),
(19, 'Carol-jean Iacabucci', 'ciacabuccii@360.cn', 84, 'Female', 'jooks', '2024-10-14'),
(20, 'Lizette McGeorge', 'lmcgeorgej@cbslocal.com', 19, 'Female', 'ratsutamine', '2024-10-14'),
(21, 'Salli Dwine', 'sdwinek@weibo.com', 13, 'Female', 'hyppe', '2024-10-14'),
(23, 'Heidi Alsobrook', 'halsobrookm@ocn.ne.jp', 38, 'Female', 'hyppe', '2024-10-14'),
(24, 'Ronny Asbrey', 'rasbreyn@phoca.cz', 52, 'Male', '', '2024-10-14'),
(25, 'Meara Partlett', 'mpartletto@constantcontact.com', 40, 'Female', 'ratsutamine', '2024-10-14'),
(26, 'Javier Gouge', 'jgougep@msu.edu', 69, 'Male', '', '2024-10-14'),
(28, 'Derry Mackin', 'dmackinr@examiner.com', 53, 'Male', 'hyppe', '2024-10-14'),
(29, 'Waiter Wrighton', 'wwrightons@pagesperso-orange.fr', 23, 'Male', 'jooks', '2024-10-14'),
(30, 'Scott Chomiszewski', 'schomiszewskit@discuz.net', 2, 'Male', 'ujumine', '2024-10-14'),
(31, 'Killian Meader', 'kmeaderu@quantcast.com', 46, 'Male', 'jooks', '2024-10-14'),
(32, 'Giacomo Klammt', 'gklammtv@samsung.com', 87, 'Male', 'ujumine', '2024-10-14'),
(33, 'Gabriello Hollyland', 'ghollylandw@e-recht24.de', 10, 'Male', '', '2024-10-14'),
(34, 'Rafaello McCusker', 'rmccuskerx@reverbnation.com', 42, 'Male', 'ujumine', '2024-10-14'),
(36, 'Helen-elizabeth Pegden', 'hpegdenz@digg.com', 55, 'Female', '', '2024-10-14'),
(37, 'Edeline De Ambrosi', 'ede10@wufoo.com', 38, 'Female', 'ujumine', '2024-10-14'),
(38, 'Christye Gilcriest', 'cgilcriest11@rakuten.co.jp', 42, 'Female', 'hyppe', '2024-10-14'),
(39, 'Jonathon Rymell', 'jrymell12@hp.com', 38, 'Male', 'jooks', '2024-10-14'),
(40, 'Robbyn Meaney', 'rmeaney13@mail.ru', 44, 'Female', 'ujumine', '2024-10-14'),
(41, 'Munroe Leat', 'mleat14@archive.org', 58, 'Male', 'jooks', '2024-10-14'),
(42, 'Marcos MacCarter', 'mmaccarter15@list-manage.com', 30, 'Male', 'ujumine', '2024-10-14'),
(43, 'Adam Bonwell', 'abonwell16@dailymotion.com', 42, 'Male', '', '2024-10-14'),
(44, 'Jaymie Embleton', 'jembleton17@blogspot.com', 90, 'Male', 'ujumine', '2024-10-14'),
(45, 'Gerald Melarkey', 'gmelarkey18@latimes.com', 95, 'Male', 'ujumine', '2024-10-14'),
(46, 'Trisha Haberjam', 'thaberjam19@bing.com', 88, 'Female', '', '2024-10-14'),
(47, 'Willi Sterndale', 'wsterndale1a@wiley.com', 47, 'Female', 'ratsutamine', '2024-10-14'),
(48, 'Matilda Diddams', 'mdiddams1b@hhs.gov', 5, 'Female', 'ujumine', '2024-10-14'),
(49, 'Cristobal Kennsley', 'ckennsley1c@plala.or.jp', 2, 'Male', 'ratsutamine', '2024-10-14');




CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



INSERT INTO `users` (`user_id`, `user`, `password`) VALUES
(3, 'admin', '$2y$10$RzwpR/Pz2ULBu3HoCjSPJertKX00czbypsKXnxO5VRmK9h9KaGzxS');


ALTER TABLE `sport2025`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);


ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

ALTER TABLE `sport2025`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

