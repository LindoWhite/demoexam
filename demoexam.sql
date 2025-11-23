-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: MySQL-5.7
-- Время создания: Окт 30 2025 г., 15:01
-- Версия сервера: 5.7.44
-- Версия PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `demoexam`
--

-- --------------------------------------------------------

--
-- Структура таблицы `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `course_name` enum('Основы алгоритмизации и программирования','Основы веб-дизайна','Основы проектирования баз данных') COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` date NOT NULL,
  `payment` enum('наличными','переводом по номеру телефона') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Новая','Идет обучение','Обучение завершено') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Новая',
  `feedback` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `users_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `applications`
--

INSERT INTO `applications` (`id`, `course_name`, `data`, `payment`, `status`, `feedback`, `users_id`) VALUES
(3, 'Основы алгоритмизации и программирования', '2025-11-11', 'наличными', 'Обучение завершено', NULL, 2),
(4, 'Основы веб-дизайна', '2025-12-12', 'переводом по номеру телефона', 'Новая', NULL, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `fullname`, `phone`, `email`) VALUES
(1, 'Admin', 'KorokNET', 'Админ Админович Админов', '8(900)000-00-00', 'admin@gmail.com'),
(2, 'ivanov', '12345678', 'Иван Иванов Иванов', '89000000000', 'ivan@gmail.com'),
(3, 'olegov', 'KorokNET', 'Олег Олегович Олегов ', '8(900)000-00-00', 'olegiv@mail.ru');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_id` (`users_id`) USING BTREE;

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
