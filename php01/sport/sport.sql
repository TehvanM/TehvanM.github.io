-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: hoggar.elkdata.ee
-- Generation Time: Jun 10, 2025 at 06:06 PM
-- Server version: 11.4.5-MariaDB-log
-- PHP Version: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vhost137852s2`
--

-- --------------------------------------------------------

--
-- Table structure for table `sport2025`
--

CREATE TABLE `sport2025` (
  `id` int(11) NOT NULL,
  `fullname` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `age` int(2) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `category` varchar(20) NOT NULL,
  `reg_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `sport2025`
--

INSERT INTO `sport2025` (`id`, `fullname`, `email`, `age`, `gender`, `category`, `reg_time`) VALUES
(1, 'Melisent Chewter', 'mchewter0@usnews.com', 49, 'Female', 'ujumine', '21/12/2024');
(2, 'Josie Durram', 'jdurram1@prnewswire.com', 18, 'Female', 'hyppe', '14/10/2024');
(3, 'Darb Yu', 'dyu2@networksolutions.com', 25, 'Male', 'hyppe', '1/11/2024');
(4, 'Sheba Attewell', 'sattewell3@cnbc.com', 57, 'Genderfluid', 'hyppe', '5/2/2025');
(5, 'Uriel Bruster', 'ubruster4@twitter.com', 82, 'Male', 'hyppe', '7/2/2025');
(6, 'Marven Cruess', 'mcruess5@home.pl', 85, 'Male', 'hyppe', '15/5/2025');
(7, 'Lenna Livard', 'llivard6@studiopress.com', 68, 'Female', 'ratsutamine', '13/4/2025');
(8, 'Aaron Furbank', 'afurbank7@moonfruit.com', 82, 'Male', '', '12/2/2025');
(9, 'Pryce Murch', 'pmurch8@who.int', 74, 'Male', 'hyppe', '31/3/2025');
(10, 'Brendin O''Kerin', 'bokerin9@etsy.com', 28, 'Male', '', '9/11/2024');
(11, 'Shermy Cypler', 'scyplera@cnn.com', 93, 'Male', 'ratsutamine', '5/12/2024');
(12, 'Jozef Hutley', 'jhutleyb@nps.gov', 66, 'Bigender', 'jooks', '10/4/2025');
(13, 'Edlin Pritchard', 'epritchardc@ucla.edu', 26, 'Male', 'jooks', '14/10/2024');
(14, 'Ingemar Welds', 'iweldsd@icio.us', 71, 'Male', 'ratsutamine', '8/8/2024');
(15, 'Janifer Feasby', 'jfeasbye@webs.com', 26, 'Female', 'hyppe', '24/7/2024');
(16, 'Diannne Higgan', 'dhigganf@canalblog.com', 46, 'Genderqueer', 'hyppe', '14/7/2024');
(17, 'Felipa Crippell', 'fcrippellg@wikia.com', 24, 'Female', 'ratsutamine', '20/3/2025');
(18, 'Evania Duplan', 'eduplanh@booking.com', 70, 'Female', 'hyppe', '10/6/2025');
(19, 'Carol-jean Iacabucci', 'ciacabuccii@360.cn', 84, 'Female', 'jooks', '23/2/2025');
(20, 'Lizette McGeorge', 'lmcgeorgej@cbslocal.com', 19, 'Female', 'ratsutamine', '11/2/2025');
(21, 'Salli Dwine', 'sdwinek@weibo.com', 13, 'Female', 'hyppe', '14/1/2025');
(22, 'Donny Britt', 'dbrittl@opera.com', 100, 'Genderfluid', 'ujumine', '19/6/2024');
(23, 'Heidi Alsobrook', 'halsobrookm@ocn.ne.jp', 38, 'Female', 'hyppe', '24/5/2025');
(24, 'Ronny Asbrey', 'rasbreyn@phoca.cz', 52, 'Male', '', '14/11/2024');
(25, 'Meara Partlett', 'mpartletto@constantcontact.com', 40, 'Female', 'ratsutamine', '1/11/2024');
(26, 'Javier Gouge', 'jgougep@msu.edu', 69, 'Male', '', '12/11/2024');
(27, 'Henryetta Cordeau]', 'hcordeauq@livejournal.com', 38, 'Genderqueer', 'ujumine', '21/5/2025');
(28, 'Derry Mackin', 'dmackinr@examiner.com', 53, 'Male', 'hyppe', '27/10/2024');
(29, 'Waiter Wrighton', 'wwrightons@pagesperso-orange.fr', 23, 'Male', 'jooks', '22/6/2024');
(30, 'Scott Chomiszewski', 'schomiszewskit@discuz.net', 2, 'Male', 'ujumine', '18/6/2024');
(31, 'Killian Meader', 'kmeaderu@quantcast.com', 46, 'Male', 'jooks', '18/2/2025');
(32, 'Giacomo Klammt', 'gklammtv@samsung.com', 87, 'Male', 'ujumine', '6/4/2025');
(33, 'Gabriello Hollyland', 'ghollylandw@e-recht24.de', 10, 'Male', '', '12/11/2024');
(34, 'Rafaello McCusker', 'rmccuskerx@reverbnation.com', 42, 'Male', 'ujumine', '23/2/2025');
(35, 'Shem Domegan', 'sdomegany@ftc.gov', 74, 'Male', '', '10/8/2024');
(36, 'Helen-elizabeth Pegden', 'hpegdenz@digg.com', 55, 'Female', '', '15/1/2025');
(37, 'Edeline De Ambrosi', 'ede10@wufoo.com', 38, 'Female', 'ujumine', '1/6/2025');
(38, 'Christye Gilcriest', 'cgilcriest11@rakuten.co.jp', 42, 'Female', 'hyppe', '22/12/2024');
(39, 'Jonathon Rymell', 'jrymell12@hp.com', 38, 'Male', 'jooks', '20/12/2024');
(40, 'Robbyn Meaney', 'rmeaney13@mail.ru', 44, 'Female', 'ujumine', '9/7/2024');
(41, 'Munroe Leat', 'mleat14@archive.org', 58, 'Male', 'jooks', '10/6/2025');
(42, 'Marcos MacCarter', 'mmaccarter15@list-manage.com', 30, 'Male', 'ujumine', '7/8/2024');
(43, 'Adam Bonwell', 'abonwell16@dailymotion.com', 42, 'Male', '', '11/6/2025');
(44, 'Jaymie Embleton', 'jembleton17@blogspot.com', 90, 'Male', 'ujumine', '18/10/2024');
(45, 'Gerald Melarkey', 'gmelarkey18@latimes.com', 95, 'Male', 'ujumine', '5/5/2025');
(46, 'Trisha Haberjam', 'thaberjam19@bing.com', 88, 'Female', '', '7/2/2025');
(47, 'Willi Sterndale', 'wsterndale1a@wiley.com', 47, 'Female', 'ratsutamine', '20/11/2024');
(48, 'Matilda Diddams', 'mdiddams1b@hhs.gov', 5, 'Female', 'ujumine', '27/1/2025');
(49, 'Cristobal Kennsley', 'ckennsley1c@plala.or.jp', 2, 'Male', 'ratsutamine', '6/4/2025');
(50, 'Noni Durrand', 'ndurrand1d@infoseek.co.jp', 14, 'Agender', 'ujumine', '21/11/2024');
(51, 'Base Deesly', 'bdeesly1e@imgur.com', 65, 'Male', 'jooks', '4/2/2025');
(52, 'Kaela Ewles', 'kewles1f@bing.com', 2, 'Female', '', '23/3/2025');
(53, 'Huntington Farndell', 'hfarndell1g@yelp.com', 69, 'Male', '', '24/1/2025');
(54, 'Johnette Warne', 'jwarne1h@nps.gov', 51, 'Female', 'hyppe', '11/2/2025');
(55, 'Broddie Geistbeck', 'bgeistbeck1i@springer.com', 36, 'Male', 'hyppe', '4/11/2024');
(56, 'Kristy Chezier', 'kchezier1j@engadget.com', 40, 'Polygender', 'jooks', '7/11/2024');
(57, 'Kev McMickan', 'kmcmickan1k@studiopress.com', 26, 'Male', 'ratsutamine', '13/3/2025');
(58, 'Packston Walklett', 'pwalklett1l@flavors.me', 13, 'Male', 'hyppe', '13/3/2025');
(59, 'Briny MacCawley', 'bmaccawley1m@theglobeandmail.com', 85, 'Female', 'hyppe', '22/9/2024');
(60, 'Winfred Sorey', 'wsorey1n@ftc.gov', 93, 'Male', 'hyppe', '17/9/2024');
(61, 'Lanny Christensen', 'lchristensen1o@newsvine.com', 36, 'Male', '', '21/4/2025');
(62, 'Rafa Darwin', 'rdarwin1p@1688.com', 23, 'Female', 'ratsutamine', '17/8/2024');
(63, 'Derry Twitty', 'dtwitty1q@ftc.gov', 56, 'Male', 'ujumine', '30/7/2024');
(64, 'Rosmunda Denziloe', 'rdenziloe1r@mapquest.com', 37, 'Female', 'hyppe', '9/7/2024');
(65, 'Bax Praten', 'bpraten1s@xinhuanet.com', 23, 'Male', 'ujumine', '27/7/2024');
(66, 'Irvin Carder', 'icarder1t@example.com', 19, 'Male', '', '25/7/2024');
(67, 'Perla Lawlan', 'plawlan1u@prlog.org', 83, 'Female', 'hyppe', '26/7/2024');
(68, 'Martha Camellini', 'mcamellini1v@ted.com', 8, 'Female', 'ujumine', '24/9/2024');
(69, 'Damien Leport', 'dleport1w@studiopress.com', 93, 'Male', 'ratsutamine', '7/11/2024');
(70, 'Cariotta Grimmert', 'cgrimmert1x@deviantart.com', 36, 'Female', 'jooks', '15/7/2024');
(71, 'Dallas Halesworth', 'dhalesworth1y@opera.com', 32, 'Polygender', 'ujumine', '12/5/2025');
(72, 'Brenden Still', 'bstill1z@cafepress.com', 41, 'Male', 'ujumine', '24/4/2025');
(73, 'Leon Mocker', 'lmocker20@harvard.edu', 42, 'Male', 'ratsutamine', '23/10/2024');
(74, 'Jordan Elgie', 'jelgie21@telegraph.co.uk', 83, 'Female', '', '29/6/2024');
(75, 'Eamon Ridoutt', 'eridoutt22@prweb.com', 4, 'Male', 'ratsutamine', '29/5/2025');
(76, 'Barron Tackle', 'btackle23@seattletimes.com', 78, 'Male', '', '12/5/2025');
(77, 'Rafferty Tunstall', 'rtunstall24@xing.com', 72, 'Non-binary', 'hyppe', '2/5/2025');
(78, 'Judas O''Duggan', 'joduggan25@alexa.com', 4, 'Male', 'ratsutamine', '9/10/2024');
(79, 'Mirilla Tinwell', 'mtinwell26@furl.net', 62, 'Female', '', '21/12/2024');
(80, 'Brendan Botte', 'bbotte27@icq.com', 72, 'Male', '', '2/10/2024');
(81, 'Kessiah Geratt', 'kgeratt28@sciencedirect.com', 58, 'Non-binary', 'hyppe', '27/6/2024');
(82, 'Shelba Angeli', 'sangeli29@pinterest.com', 44, 'Female', 'ratsutamine', '3/12/2024');
(83, 'Maude Ingham', 'mingham2a@npr.org', 89, 'Female', 'ujumine', '10/9/2024');
(84, 'Yancy Paddington', 'ypaddington2b@rambler.ru', 37, 'Male', 'ujumine', '9/4/2025');
(85, 'Salmon Hurkett', 'shurkett2c@paypal.com', 89, 'Genderfluid', 'jooks', '9/3/2025');
(86, 'Lisle Shute', 'lshute2d@google.com.au', 51, 'Male', 'hyppe', '19/10/2024');
(87, 'Auguste Kubanek', 'akubanek2e@bizjournals.com', 77, 'Female', 'ratsutamine', '22/7/2024');
(88, 'Shoshanna Hartell', 'shartell2f@skype.com', 49, 'Female', 'hyppe', '22/5/2025');
(89, 'Carmelina Olennikov', 'colennikov2g@abc.net.au', 46, 'Female', 'jooks', '24/3/2025');
(90, 'Manuel Veness', 'mveness2h@zimbio.com', 22, 'Male', 'jooks', '25/12/2024');
(91, 'Luigi Lattka', 'llattka2i@boston.com', 69, 'Male', 'ujumine', '22/7/2024');
(92, 'Zia Whitton', 'zwhitton2j@163.com', 31, 'Female', 'ujumine', '4/1/2025');
(93, 'Bevvy Maltman', 'bmaltman2k@last.fm', 19, 'Female', '', '17/12/2024');
(94, 'Kendall Filyushkin', 'kfilyushkin2l@moonfruit.com', 59, 'Male', 'ujumine', '2/11/2024');
(95, 'Simone Thorburn', 'sthorburn2m@godaddy.com', 88, 'Female', 'jooks', '10/3/2025');
(96, 'Leicester Thurber', 'lthurber2n@state.gov', 86, 'Male', 'ujumine', '29/6/2024');
(97, 'Kelvin Beals', 'kbeals2o@cbslocal.com', 25, 'Male', 'hyppe', '5/9/2024');
(98, 'Tara Laboune', 'tlaboune2p@list-manage.com', 95, 'Female', 'ratsutamine', '6/3/2025');
(99, 'Alfredo Andrei', 'aandrei2q@seesaa.net', 7, 'Male', 'ujumine', '11/12/2024');
(100, 'Aila Stummeyer', 'astummeyer2r@java.com', 1, 'Female', 'ratsutamine', '28/3/2025');
(101, 'Effie Grimestone', 'egrimestone2s@amazon.de', 88, 'Female', '', '19/1/2025');
(102, 'Aluino Aiston', 'aaiston2t@tinypic.com', 12, 'Male', 'jooks', '2/3/2025');
(103, 'Daloris Vedntyev', 'dvedntyev2u@rediff.com', 98, 'Female', 'ujumine', '26/6/2024');
(104, 'Una Puffett', 'upuffett2v@prnewswire.com', 21, 'Female', 'jooks', '9/8/2024');
(105, 'Natasha Pescod', 'npescod2w@cyberchimps.com', 21, 'Female', 'jooks', '22/10/2024');
(106, 'Sabrina Novic', 'snovic2x@fda.gov', 98, 'Female', '', '23/9/2024');
(107, 'Garrett Furnell', 'gfurnell2y@cmu.edu', 100, 'Male', 'jooks', '2/12/2024');
(108, 'Darci McSorley', 'dmcsorley2z@privacy.gov.au', 59, 'Female', 'ujumine', '18/10/2024');
(109, 'Art Stonelake', 'astonelake30@mail.ru', 19, 'Male', 'hyppe', '15/1/2025');
(110, 'Katha Shutle', 'kshutle31@imgur.com', 34, 'Female', 'jooks', '1/12/2024');
(111, 'Gasparo Tarzey', 'gtarzey32@deviantart.com', 21, 'Male', '', '27/4/2025');
(112, 'Lauritz Taffley', 'ltaffley33@sakura.ne.jp', 61, 'Male', 'ratsutamine', '31/5/2025');
(113, 'Yanaton Clell', 'yclell34@4shared.com', 95, 'Non-binary', 'jooks', '11/1/2025');
(114, 'Lizbeth Hearns', 'lhearns35@archive.org', 40, 'Female', 'ujumine', '30/12/2024');
(115, 'Alexio Gunthorpe', 'agunthorpe36@umich.edu', 4, 'Male', 'ujumine', '18/5/2025');
(116, 'Keith Revens', 'krevens37@alibaba.com', 48, 'Male', 'ratsutamine', '12/1/2025');
(117, 'Oswald Bassingden', 'obassingden38@miitbeian.gov.cn', 12, 'Male', 'ujumine', '22/7/2024');
(118, 'Vanny Gillmore', 'vgillmore39@tinypic.com', 22, 'Female', '', '21/7/2024');
(119, 'Gary Spanswick', 'gspanswick3a@skyrock.com', 19, 'Male', '', '29/4/2025');
(120, 'Halsy Roadnight', 'hroadnight3b@scientificamerican.com', 96, 'Bigender', 'jooks', '18/10/2024');
(121, 'Webster Morffew', 'wmorffew3c@wsj.com', 44, 'Male', 'hyppe', '5/10/2024');
(122, 'Josefina Presslie', 'jpresslie3d@loc.gov', 80, 'Non-binary', 'ratsutamine', '18/11/2024');
(123, 'Ede Sandom', 'esandom3e@de.vu', 83, 'Female', 'hyppe', '22/5/2025');
(124, 'Kakalina Jewel', 'kjewel3f@flavors.me', 46, 'Female', 'ratsutamine', '14/11/2024');
(125, 'Elston Rainbow', 'erainbow3g@reference.com', 8, 'Male', 'hyppe', '10/3/2025');
(126, 'Luis Mitcheson', 'lmitcheson3h@spiegel.de', 19, 'Male', 'hyppe', '12/1/2025');
(127, 'Bernarr Southerill', 'bsoutherill3i@si.edu', 2, 'Male', 'hyppe', '14/3/2025');
(128, 'Engelbert Swindon', 'eswindon3j@multiply.com', 40, 'Male', 'hyppe', '13/2/2025');
(129, 'Nathaniel Tanfield', 'ntanfield3k@hubpages.com', 73, 'Male', '', '13/12/2024');
(130, 'Ruy Baytrop', 'rbaytrop3l@over-blog.com', 79, 'Male', 'ratsutamine', '26/1/2025');
(131, 'Corilla Stronack', 'cstronack3m@nifty.com', 60, 'Female', 'jooks', '5/12/2024');
(132, 'Sansone Meffen', 'smeffen3n@cam.ac.uk', 1, 'Male', 'ratsutamine', '22/7/2024');
(133, 'Batsheva Payze', 'bpayze3o@lulu.com', 95, 'Female', '', '5/2/2025');
(134, 'Pammy Scaddon', 'pscaddon3p@yellowbook.com', 20, 'Female', '', '25/5/2025');
(135, 'Luelle Giacopello', 'lgiacopello3q@mayoclinic.com', 90, 'Genderqueer', '', '3/4/2025');
(136, 'Derrick Millott', 'dmillott3r@wikipedia.org', 45, 'Male', 'ratsutamine', '23/6/2024');
(137, 'Yule Channer', 'ychanner3s@t-online.de', 13, 'Agender', '', '22/6/2024');
(138, 'Meredeth Baszkiewicz', 'mbaszkiewicz3t@wikia.com', 92, 'Male', 'ujumine', '29/8/2024');
(139, 'Helen-elizabeth Fagence', 'hfagence3u@feedburner.com', 85, 'Female', 'hyppe', '22/1/2025');
(140, 'Ganny Trussell', 'gtrussell3v@ifeng.com', 80, 'Male', 'jooks', '5/11/2024');
(141, 'Owen Shambroke', 'oshambroke3w@desdev.cn', 25, 'Male', '', '11/4/2025');
(142, 'Nappie Miller', 'nmiller3x@163.com', 82, 'Male', 'jooks', '20/12/2024');
(143, 'Brod Delyth', 'bdelyth3y@mac.com', 39, 'Male', 'jooks', '11/10/2024');
(144, 'Quill Jay', 'qjay3z@example.com', 47, 'Male', 'ujumine', '7/12/2024');
(145, 'Wendye Warlaw', 'wwarlaw40@xing.com', 28, 'Female', 'jooks', '9/4/2025');
(146, 'Mufinella Vondracek', 'mvondracek41@t.co', 55, 'Female', 'hyppe', '3/5/2025');
(147, 'Celesta England', 'cengland42@studiopress.com', 67, 'Female', '', '11/11/2024');
(148, 'Wes Goodbarne', 'wgoodbarne43@disqus.com', 6, 'Genderfluid', '', '12/6/2025');
(149, 'Renaud Whitely', 'rwhitely44@ox.ac.uk', 89, 'Male', 'ratsutamine', '13/3/2025');
(150, 'Ezekiel Burbidge', 'eburbidge45@usnews.com', 98, 'Male', 'ujumine', '16/6/2024');
(151, 'Farrand Mollitt', 'fmollitt46@abc.net.au', 5, 'Female', 'ujumine', '4/3/2025');
(152, 'Galen Geleman', 'ggeleman47@edublogs.org', 14, 'Male', 'hyppe', '3/12/2024');
(153, 'Devlen Dehn', 'ddehn48@salon.com', 22, 'Male', 'ujumine', '16/6/2024');
(154, 'Cornell Handscombe', 'chandscombe49@dyndns.org', 67, 'Male', '', '13/2/2025');
(155, 'Latisha Pendlebery', 'lpendlebery4a@bloglines.com', 38, 'Female', 'hyppe', '5/4/2025');
(156, 'Griz Blencowe', 'gblencowe4b@tiny.cc', 79, 'Polygender', 'jooks', '10/6/2025');
(157, 'Nikoletta Tarrier', 'ntarrier4c@tinyurl.com', 2, 'Female', 'ratsutamine', '30/1/2025');
(158, 'Goran Bunford', 'gbunford4d@friendfeed.com', 74, 'Male', 'jooks', '6/12/2024');
(159, 'Amos Yurivtsev', 'ayurivtsev4e@themeforest.net', 11, 'Genderfluid', 'hyppe', '21/11/2024');
(160, 'Ly Fidelli', 'lfidelli4f@xrea.com', 29, 'Male', 'jooks', '16/11/2024');
(161, 'Bink Rouby', 'brouby4g@redcross.org', 71, 'Male', 'ratsutamine', '5/7/2024');
(162, 'Nye Redolfi', 'nredolfi4h@japanpost.jp', 36, 'Male', 'hyppe', '17/5/2025');
(163, 'Claudia Detoile', 'cdetoile4i@nhs.uk', 35, 'Female', '', '31/10/2024');
(164, 'Abbey Standbrook', 'astandbrook4j@mit.edu', 98, 'Female', 'jooks', '19/9/2024');
(165, 'Iolande Leger', 'ileger4k@g.co', 55, 'Female', 'ratsutamine', '7/12/2024');
(166, 'Albie Tetford', 'atetford4l@cafepress.com', 32, 'Male', 'hyppe', '23/9/2024');
(167, 'Ariana Palomba', 'apalomba4m@cmu.edu', 76, 'Female', '', '1/6/2025');
(168, 'Tana Molnar', 'tmolnar4n@4shared.com', 98, 'Female', 'jooks', '10/3/2025');
(169, 'Standford Squire', 'ssquire4o@ustream.tv', 63, 'Male', 'jooks', '6/7/2024');
(170, 'Ives Mushart', 'imushart4p@fema.gov', 6, 'Male', 'hyppe', '25/8/2024');
(171, 'Tanner O''Sheeryne', 'tosheeryne4q@thetimes.co.uk', 99, 'Male', 'jooks', '24/7/2024');
(172, 'Curtice Job', 'cjob4r@microsoft.com', 63, 'Male', 'ujumine', '1/8/2024');
(173, 'Burnard Wickham', 'bwickham4s@nydailynews.com', 70, 'Male', 'hyppe', '15/10/2024');
(174, 'Arney Rootham', 'arootham4t@tumblr.com', 11, 'Male', '', '1/6/2025');
(175, 'Cad Reignard', 'creignard4u@feedburner.com', 15, 'Male', 'ratsutamine', '2/12/2024');
(176, 'Fidelia Lie', 'flie4v@ihg.com', 22, 'Female', 'jooks', '16/1/2025');
(177, 'Timofei Gilroy', 'tgilroy4w@goodreads.com', 58, 'Male', 'ratsutamine', '7/2/2025');
(178, 'Fulton Sturzaker', 'fsturzaker4x@unc.edu', 68, 'Male', 'ujumine', '26/4/2025');
(179, 'Bernadette Cogdell', 'bcogdell4y@ovh.net', 31, 'Female', 'jooks', '26/3/2025');
(180, 'Annabelle Tetford', 'atetford4z@cbsnews.com', 27, 'Female', 'hyppe', '21/2/2025');
(181, 'Jonis Vairow', 'jvairow50@dedecms.com', 16, 'Female', 'ratsutamine', '12/10/2024');
(182, 'Ira Kleinlerer', 'ikleinlerer51@illinois.edu', 47, 'Male', '', '27/9/2024');
(183, 'Noel Daverin', 'ndaverin52@naver.com', 27, 'Male', '', '11/5/2025');
(184, 'Phedra O''Scully', 'poscully53@lycos.com', 82, 'Female', 'ratsutamine', '16/10/2024');
(185, 'De witt Barthram', 'dwitt54@paginegialle.it', 13, 'Genderqueer', 'jooks', '17/1/2025');
(186, 'Claudianus Wordesworth', 'cwordesworth55@ft.com', 29, 'Male', 'ujumine', '14/4/2025');
(187, 'Charisse Girardoni', 'cgirardoni56@spotify.com', 38, 'Female', 'hyppe', '14/12/2024');
(188, 'Port Lehrmann', 'plehrmann57@dropbox.com', 38, 'Male', 'jooks', '6/2/2025');
(189, 'Reagen Duckerin', 'rduckerin58@imageshack.us', 76, 'Male', 'hyppe', '11/3/2025');
(190, 'Tawnya Castello', 'tcastello59@scribd.com', 1, 'Female', 'hyppe', '24/7/2024');
(191, 'Virgina Pierro', 'vpierro5a@godaddy.com', 43, 'Female', 'hyppe', '21/2/2025');
(192, 'Licha Lidyard', 'llidyard5b@exblog.jp', 36, 'Female', 'hyppe', '29/1/2025');
(193, 'Holly-anne Mertgen', 'hmertgen5c@sfgate.com', 24, 'Female', 'ujumine', '12/6/2025');
(194, 'Beatriz Baggett', 'bbaggett5d@weebly.com', 38, 'Female', 'ujumine', '10/7/2024');
(195, 'Sherrie Kiebes', 'skiebes5e@columbia.edu', 82, 'Female', 'ratsutamine', '24/10/2024');
(196, 'Krista Sherland', 'ksherland5f@google.com.br', 82, 'Female', 'hyppe', '16/6/2024');
(197, 'Natalee McCambrois', 'nmccambrois5g@timesonline.co.uk', 100, 'Female', 'jooks', '22/4/2025');
(198, 'Celinka Phelp', 'cphelp5h@ftc.gov', 15, 'Female', 'ratsutamine', '11/11/2024');
(199, 'Kimberly Healy', 'khealy5i@hexun.com', 93, 'Female', '', '23/6/2024');
(200, 'Augustina Vasyaev', 'avasyaev5j@infoseek.co.jp', 59, 'Female', 'ratsutamine', '2/5/2025');

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user`, `password`) VALUES
(3, 'admin', '$2y$10$RzwpR/Pz2ULBu3HoCjSPJertKX00czbypsKXnxO5VRmK9h9KaGzxS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sport2025`
--
ALTER TABLE `sport2025`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sport2025`
--
ALTER TABLE `sport2025`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
