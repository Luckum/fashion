-- phpMyAdmin SQL Dump
-- version 4.6.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Авг 16 2016 г., 09:50
-- Версия сервера: 10.0.17-MariaDB
-- Версия PHP: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `fashion`
--

-- --------------------------------------------------------

--
-- Структура таблицы `homepage_block`
--

CREATE TABLE `homepage_block` (
  `id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8_bin NOT NULL,
  `link_type` enum('direct','filter','image') COLLATE utf8_bin NOT NULL DEFAULT 'direct',
  `block_type` varchar(15) COLLATE utf8_bin NOT NULL,
  `url` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `homepage_block`
--

INSERT INTO `homepage_block` (`id`, `image`, `link_type`, `block_type`, `url`) VALUES
(22, 'image_57b1cdeb2f568.jpg', '', 'main_menu_1', 'http://www.23-15.com/'),
(23, 'image_57b1ce3238dff.jpg', '', 'main_menu_2', 'http://www.23-15.com/');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `homepage_block`
--
ALTER TABLE `homepage_block`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `homepage_block`
--
ALTER TABLE `homepage_block`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
