-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 14-08-2019 a las 05:36:00
-- Versión del servidor: 10.3.16-MariaDB
-- Versión de PHP: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cms`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(3) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cat_title` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`cat_id`, `user_id`, `cat_title`) VALUES
(1, 15, 'Javascript'),
(2, 15, 'Bootstraps');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(3) NOT NULL,
  `comment_post_id` int(3) NOT NULL,
  `comment_author` varchar(255) COLLATE utf8_bin NOT NULL,
  `comment_email` varchar(255) COLLATE utf8_bin NOT NULL,
  `comment_content` text COLLATE utf8_bin NOT NULL,
  `comment_status` varchar(255) COLLATE utf8_bin NOT NULL,
  `comment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `comments`
--

INSERT INTO `comments` (`comment_id`, `comment_post_id`, `comment_author`, `comment_email`, `comment_content`, `comment_status`, `comment_date`) VALUES
(36, 68, 'aaaa', 'analysis@yipitdata.com', '<p>aaa</p>', 'Unapproved', '2019-07-17'),
(42, 68, 'Denver', 'analysis@yipitdata.com', '<p>Denver is <strong>HERE</strong></p>', 'Approved', '2019-08-12'),
(45, 68, 'Goku', 'analysis@yipitdata.com', '<p><strong>aaaahhhhhhhhhhh!</strong></p>', 'Unapproved', '2019-08-13'),
(46, 68, 'Leonardo', 'analysis@yipitdata.com', '<p>aaaaaaaaaa</p>', 'Unapproved', '2019-08-13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posts`
--

CREATE TABLE `posts` (
  `post_id` int(3) NOT NULL,
  `post_category_id` int(3) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_title` varchar(255) COLLATE utf8_bin NOT NULL,
  `post_user` varchar(255) COLLATE utf8_bin NOT NULL,
  `post_date` date NOT NULL,
  `post_image` text COLLATE utf8_bin NOT NULL,
  `post_content` text COLLATE utf8_bin NOT NULL,
  `post_tags` varchar(255) COLLATE utf8_bin NOT NULL,
  `post_comment_count` int(11) DEFAULT NULL,
  `post_status` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT 'draft',
  `post_views_count` int(11) NOT NULL,
  `post_likes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `posts`
--

INSERT INTO `posts` (`post_id`, `post_category_id`, `user_id`, `post_title`, `post_user`, `post_date`, `post_image`, `post_content`, `post_tags`, `post_comment_count`, `post_status`, `post_views_count`, `post_likes`) VALUES
(68, 1, 15, 'Crawling', 'MarioBros', '2019-07-17', 'noplacelike.png', '<ol><li>PHP is awesome! aaaaa</li></ol>', 'PHPa', 10, 'Published', 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `user_id` int(3) NOT NULL,
  `username` varchar(255) COLLATE utf8_bin NOT NULL,
  `user_password` varchar(255) COLLATE utf8_bin NOT NULL,
  `user_firstname` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `user_lastname` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `user_email` varchar(255) COLLATE utf8_bin NOT NULL,
  `user_image` text COLLATE utf8_bin DEFAULT NULL,
  `user_role` varchar(255) COLLATE utf8_bin NOT NULL,
  `token` text COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user_id`, `username`, `user_password`, `user_firstname`, `user_lastname`, `user_email`, `user_image`, `user_role`, `token`) VALUES
(15, 'MarioBros', '$2y$10$qzsZZLBl8RuRIOkt2Vx1YOKcnQUywa0i.dsjGV0AQyacj/PKodoZ2', 'MarioBros', 'Bros', 'Mario@gmail.com', NULL, 'Admin', 'a3270535ac62d31990c9173b13dd092d7beac8d90e8ff1057b046339d809bce8484d227afacb3bf304a7f2c4283ea9d5ebae'),
(16, 'leonardo', '$2y$10$GeDJm6zaceUghzHhjXtKveLVP5FmkHiJfqn5CeEEqm2RBF695UPS.', 'Leonardo', 'Aranguren', 'test@gmail.com', NULL, 'Admin', 'd7d1362f40a9e39358efabbb6b32979a7f25247574e3148919b1f370c0b33bb9423030fbcb1a81ea9a3167e377f14b029d01'),
(54, 'yoshi', '$2y$10$oPh4at9Pwz.X4gxNktHHfehtZ7x3sHUkrnT4F0LGe1ilVO.7vVBqe', 'Yoshi', 'Eggs', 'yoshi@gmail.com', NULL, 'Admin', NULL),
(62, 'luigi', '$2y$10$qJysZLO2OIO3a1WY9Yhzq.sLKxHcuC18x.zCDJ2M1K5bQeMH2K80.', 'Luigi', 'Bros', 'luigi@gmal.com', NULL, 'Subscriber', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_online`
--

CREATE TABLE `users_online` (
  `id` int(11) NOT NULL,
  `session` varchar(255) COLLATE utf8_bin NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `users_online`
--

INSERT INTO `users_online` (`id`, `session`, `time`) VALUES
(6, '90b7ffab2b108c4bbc9b84e5380f9de5', 1563379255),
(7, '1c7b83954eecd9a43b79ecdf53ea83e5', 1562956271),
(8, 'bb19afe0006ef72c4f1f84536931448d', 1564258063),
(9, 'a4ffe9f9b322b6c2a76ee6a9b710a100', 1564674012),
(10, '3c5d68974950e3a72ffc21998e823ff3', 1564699587),
(11, '0d117217ca5db990e67d4a044a31f8dc', 1565752620),
(12, '9cecd6a9b16886a862449169d9fc6ee7', 1565286867),
(13, 'a15643a58fdcdd2704716d1d9801e035', 1565623349);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indices de la tabla `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indices de la tabla `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indices de la tabla `users_online`
--
ALTER TABLE `users_online`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de la tabla `users_online`
--
ALTER TABLE `users_online`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
