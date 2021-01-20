-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Янв 20 2021 г., 22:27
-- Версия сервера: 5.7.29-0ubuntu0.18.04.1
-- Версия PHP: 7.2.24-0ubuntu0.18.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `testForIiko`
--

-- --------------------------------------------------------

--
-- Структура таблицы `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `status` int(3) NOT NULL,
  `date` int(11) NOT NULL,
  `discount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `invoices`
--

INSERT INTO `invoices` (`id`, `number`, `status`, `date`, `discount`) VALUES
(1, 1, 1, 1577826000, 10),
(2, 2, 1, 1577826500, 2),
(3, 3, 0, 1577826000, 2),
(4, 4, 1, 1277826000, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `invoices_positions`
--

CREATE TABLE `invoices_positions` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `position_name` varchar(255) NOT NULL,
  `counts` int(11) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `invoices_positions`
--

INSERT INTO `invoices_positions` (`id`, `invoice_id`, `position_name`, `counts`, `price`) VALUES
(121, 1, 'Пицца \"Маргарита\"', 1, 450),
(123, 1, 'Пицца \"4 сезона\"', 1, 400),
(124, 1, 'Пицца \"Чизбургер\"', 1, 650),
(125, 2, 'Кофе', 1, 75),
(126, 2, 'Булочка \"Фирменная\"', 1, 50),
(127, 3, 'Сет \"Якимадзи\"', 1, 1250),
(128, 3, 'Сет \"Праздничный\"', 1, 2000),
(129, 3, 'Сашими', 1, 500),
(130, 3, 'Васаби', 3, 60),
(131, 4, 'Пицца \"Грибная\"', 1, 800);

--
-- Индексы таблицы `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `invoices_positions`
--
ALTER TABLE `invoices_positions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для таблицы `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `invoices_positions`
--
ALTER TABLE `invoices_positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;
