-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Hoszt: localhost
-- Létrehozás ideje: 2012. ápr. 17. 12:37
-- Szerver verzió: 5.1.41
-- PHP verzió: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Adatbázis: `szakdoli`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet: `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- A tábla adatainak kiíratása `ci_sessions`
--


-- --------------------------------------------------------

--
-- Tábla szerkezet: `page_config`
--

CREATE TABLE IF NOT EXISTS `page_config` (
  `data` varchar(100) NOT NULL,
  `value` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- A tábla adatainak kiíratása `page_config`
--

INSERT INTO `page_config` (`data`, `value`) VALUES
('registration', '1');

-- --------------------------------------------------------

--
-- Tábla szerkezet: `processes`
--

CREATE TABLE IF NOT EXISTS `processes` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `token` varchar(40) NOT NULL,
  `url` text NOT NULL,
  `uid` bigint(20) NOT NULL,
  `runtime` int(100) NOT NULL,
  `state` int(2) NOT NULL,
  `htmldoctype` varchar(100) NOT NULL,
  `htmlvalidity` tinyint(1) NOT NULL DEFAULT '0',
  `htmlerrornum` int(10) NOT NULL,
  `htmlwarningnum` int(10) NOT NULL,
  `cssdoctype` varchar(100) NOT NULL,
  `cssvalidity` tinyint(1) NOT NULL DEFAULT '0',
  `csserrornum` int(10) NOT NULL,
  `csswarningnum` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- A tábla adatainak kiíratása `processes`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet: `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` varchar(100) NOT NULL,
  `pass` varchar(40) NOT NULL,
  `email` varchar(100) NOT NULL,
  `isadmin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user` (`user`),
  UNIQUE KEY `user_2` (`user`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `user`, `pass`, `email`, `isadmin`) VALUES
(2, 'Proba', '3da541559918a808c2402bba5012f6c60b27661c', 'teszt@teszt.teszt', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
