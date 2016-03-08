-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Мар 09 2016 г., 01:00
-- Версия сервера: 5.5.25
-- Версия PHP: 5.2.12

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `db_ruby`
--

-- --------------------------------------------------------

--
-- Структура таблицы `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `id_project` int(11) NOT NULL AUTO_INCREMENT,
  `name_project` varchar(45) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_state` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  PRIMARY KEY (`id_project`),
  KEY `fk_project_user` (`id_user`),
  KEY `fk_project_sate1` (`id_state`),
  KEY `fk_project_priority1` (`priority`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='таблица проэктов' AUTO_INCREMENT=55 ;

--
-- Дамп данных таблицы `project`
--

INSERT INTO `project` (`id_project`, `name_project`, `id_user`, `id_state`, `priority`) VALUES
(50, '''hgkj''', 8, 0, 1),
(54, '', 9, 0, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `state`
--

CREATE TABLE IF NOT EXISTS `state` (
  `id_state` int(11) NOT NULL AUTO_INCREMENT,
  `name_state` varchar(45) NOT NULL,
  PRIMARY KEY (`id_state`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `task`
--

CREATE TABLE IF NOT EXISTS `task` (
  `id_task` int(11) NOT NULL AUTO_INCREMENT,
  `name_task` varchar(45) NOT NULL,
  `id_project` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_state` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  PRIMARY KEY (`id_task`),
  KEY `fk_task_project1` (`id_project`),
  KEY `fk_task_user1` (`id_user`),
  KEY `fk_task_sate1` (`id_state`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Дамп данных таблицы `task`
--

INSERT INTO `task` (`id_task`, `name_task`, `id_project`, `id_user`, `id_state`, `priority`) VALUES
(14, '''3''', 50, 8, 1, 2),
(17, 'fghg', 50, 8, 0, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `name_user` varchar(45) NOT NULL,
  `login_user` varchar(45) NOT NULL,
  `password_user` varchar(45) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='таблица, для хранения данных о пользователях' AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id_user`, `name_user`, `login_user`, `password_user`) VALUES
(9, 'Olga', 'Olga', 'e10adc3949ba59abbe56e057f20f883e'),
(10, 'Vasya', 'Vasya', 'e10adc3949ba59abbe56e057f20f883e'),
(11, 'Max', 'Max', 'e10adc3949ba59abbe56e057f20f883e');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
