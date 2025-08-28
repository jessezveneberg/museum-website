-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3307
-- Час створення: Чрв 03 2025 р., 05:03
-- Версія сервера: 8.0.30
-- Версія PHP: 8.0.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `museum_db`
--

-- --------------------------------------------------------

--
-- Структура таблиці `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `exhibit_id` int NOT NULL,
  `user_id` int NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `exhibits`
--

CREATE TABLE `exhibits` (
  `id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `full_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `exhibits`
--

INSERT INTO `exhibits` (`id`, `title`, `description`, `category`, `image`, `full_text`, `created_at`) VALUES
(1, 'Вишита сорочка', 'Жіноча сорочка з Полтавщини, початок 19 ст. Виконана білим по білому.', 'Текстиль', 'shirt1.jpg', 'Детальний опис вишитої сорочки...', '2025-06-02 23:49:13'),
(2, 'Глиняний посуд', 'Колекція глиняного посуду з Київської області, 18-19 ст.', 'Кераміка', 'pottery1.jpg', 'Детальний опис глиняного посуду...', '2025-06-02 23:49:13'),
(3, 'Народні інструменти', 'Традиційні українські музичні інструменти: сопілка, бандура, бубон.', 'Інструменти', 'instruments1.jpg', 'Детальний опис народних інструментів...', '2025-06-02 23:49:13'),
(4, 'Писанки', 'Колекція традиційних українських писанок з різних регіонів.', 'Декоративне мистецтво', 'eggs1.jpg', 'Детальний опис писанок...', '2025-06-02 23:49:13');

-- --------------------------------------------------------

--
-- Структура таблиці `gallery`
--

CREATE TABLE `gallery` (
  `id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `gallery`
--

INSERT INTO `gallery` (`id`, `title`, `image_path`, `description`, `created_at`) VALUES
(1, 'Виставковий зал', 'assets/images/gallery/hall1.jpg', 'Головний виставковий зал музею', '2025-06-02 23:49:13'),
(2, 'Експонати текстилю', 'assets/images/gallery/textile1.jpg', 'Колекція традиційного українського текстилю', '2025-06-02 23:49:13'),
(3, 'Кераміка', 'assets/images/gallery/pottery2.jpg', 'Виставка традиційної української кераміки', '2025-06-02 23:49:13'),
(4, 'Майстер-клас', 'assets/images/gallery/workshop2.jpg', 'Майстер-клас з народних ремесел', '2025-06-02 23:49:13');

-- --------------------------------------------------------

--
-- Структура таблиці `news`
--

CREATE TABLE `news` (
  `id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `image`, `created_at`) VALUES
(1, 'Відкриття нової виставки', 'Запрошуємо відвідати нашу нову виставку \"Українське народне мистецтво\", яка відкриється 15 травня. На виставці представлені унікальні експонати з усіх регіонів України.', 'exhibition1.jpg', '2025-06-02 23:49:13'),
(2, 'Новий експонат у колекції', 'Наш музей поповнився рідкісним експонатом - вишитою сорочкою з Полтавщини, датованою початком 19 століття.', 'shirt1.jpg', '2025-06-02 23:49:13'),
(3, 'Зміни в графіку роботи', 'З 1 червня музей працюватиме за новим графіком: з 10:00 до 18:00, вихідний - понеділок.', NULL, '2025-06-02 23:49:13');

-- --------------------------------------------------------

--
-- Структура таблиці `pages`
--

CREATE TABLE `pages` (
  `id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `pages`
--

INSERT INTO `pages` (`id`, `title`, `slug`, `content`, `created_at`) VALUES
(1, 'Про музей', 'about', 'Наш музей заснований у 1990 році з метою збереження та популяризації української народної культури. У нашій колекції понад 5000 експонатів.', '2025-06-02 23:49:13'),
(2, 'Контакти', 'contacts', 'Адреса: м. Київ, вул. Музейна, 1\nТелефон: (044) 123-45-67\nEmail: info@museum.com\nГрафік роботи: 10:00-18:00, вихідний - понеділок.', '2025-06-02 23:49:13'),
(3, 'Правила відвідування', 'rules', '1. У музеї заборонено торкатися експонатів\n2. Фото- та відеозйомка дозволена без спалаху\n3. Великі сумки необхідно здати у гардероб', '2025-06-02 23:49:13');

-- --------------------------------------------------------

--
-- Структура таблиці `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','editor','user') COLLATE utf8mb4_unicode_ci DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@museum.com', 'admin', '2025-06-02 23:19:22'),
(2, 'user', '$2y$10$tT5MAaob7uTwvxxkP0s87OXGTYpAitlurgu6maeRym/EdEZ92tz8u', 'user1@gmail.com', 'user', '2025-06-03 00:01:02');

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exhibit_id` (`exhibit_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Індекси таблиці `exhibits`
--
ALTER TABLE `exhibits`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Індекси таблиці `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `exhibits`
--
ALTER TABLE `exhibits`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблиці `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблиці `news`
--
ALTER TABLE `news`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблиці `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблиці `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`exhibit_id`) REFERENCES `exhibits` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
