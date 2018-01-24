-- phpMyAdmin SQL Dump
-- version 4.6.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Авг 16 2016 г., 09:51
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
-- Структура таблицы `homepage_block_content`
--

CREATE TABLE `homepage_block_content` (
  `id` int(11) NOT NULL,
  `block_id` int(11) NOT NULL,
  `language` char(2) COLLATE utf8_bin NOT NULL,
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `content` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `homepage_block_content`
--

INSERT INTO `homepage_block_content` (`id`, `block_id`, `language`, `title`, `content`) VALUES
(53, 22, 'en', 'main_menu_1', ''),
(54, 23, 'en', 'main_menu_2', '');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `homepage_block_content`
--
ALTER TABLE `homepage_block_content`
  ADD PRIMARY KEY (`id`),
  ADD KEY `block_id` (`block_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `homepage_block_content`
--
ALTER TABLE `homepage_block_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `homepage_block_content`
--
ALTER TABLE `homepage_block_content`
  ADD CONSTRAINT `homepage_block_content_ibfk_1` FOREIGN KEY (`block_id`) REFERENCES `homepage_block` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
