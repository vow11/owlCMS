-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Июл 01 2015 г., 00:56
-- Версия сервера: 5.5.43-0ubuntu0.14.04.1
-- Версия PHP: 5.5.9-1ubuntu4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `dev`
--

-- --------------------------------------------------------

--
-- Структура таблицы `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `html_content` longtext,
  `template` varchar(250) NOT NULL DEFAULT 'blank',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `articles`
--

INSERT INTO `articles` (`id`, `name`, `html_content`, `template`) VALUES
(1, 'Главная', 'Mauris quis erat turpis. Aenean nisl metus, luctus vitae consectetur venenatis, tincidunt quis nisl. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Etiam sed ipsum in nisl fermentum blandit. Sed ante lacus, pretium in semper eget, dictum nec lectus. Sed sapien lectus, consectetur ut ultrices in, vehicula sed felis. Donec tincidunt eros ut orci dictum eu ornare tellus auctor. Duis dui arcu, venenatis sed semper vitae, posuere eget metus. Aliquam purus nulla, sagittis eu facilisis eu, faucibus at dui. Maecenas et elit erat. Aliquam sapien tortor, tristique id convallis non, pharetra a dui. Lorem ipsum dolor sit amet, consectetur adipiscing elit.\r\nAliquam gravida massa eu arcu. Fusce mollis tristique sem. Sed eu eros imperdiet eros interdum blandit. Vivamus sagittis bibendum erat. Curabitur malesuada turpis nec ante. Suspendisse quis felis. Suspendisse potenti. Nullam et orci in erat viverra ornare. Nunc pellentesque. Sed vestibulum blandit nisl. Quisque elementum convallis purus.', 'default');

-- --------------------------------------------------------

--
-- Структура таблицы `chunks`
--

CREATE TABLE IF NOT EXISTS `chunks` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `chunk_content` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(30) NOT NULL,
  `user_password` varchar(32) NOT NULL,
  `user_hash` varchar(32) NOT NULL,
  `user_ip` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_login` (`user_login`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
