-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 27-07-2019 a las 22:07:41
-- Versión del servidor: 10.3.15-MariaDB
-- Versión de PHP: 7.3.6

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
  `cat_title` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_title`) VALUES
(1, 'Javascript'),
(2, 'Bootstraps'),
(3, 'React.JS'),
(4, 'PHP'),
(29, 'React.JS');

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
(36, 68, 'aaaa', 'analysis@yipitdata.com', '<p>aaa</p>', 'Unapproved', '2019-07-17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posts`
--

CREATE TABLE `posts` (
  `post_id` int(3) NOT NULL,
  `post_category_id` int(3) NOT NULL,
  `post_title` varchar(255) COLLATE utf8_bin NOT NULL,
  `post_user` varchar(255) COLLATE utf8_bin NOT NULL,
  `post_date` date NOT NULL,
  `post_image` text COLLATE utf8_bin NOT NULL,
  `post_content` text COLLATE utf8_bin NOT NULL,
  `post_tags` varchar(255) COLLATE utf8_bin NOT NULL,
  `post_comment_count` int(11) DEFAULT NULL,
  `post_status` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT 'draft',
  `post_views_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `posts`
--

INSERT INTO `posts` (`post_id`, `post_category_id`, `post_title`, `post_user`, `post_date`, `post_image`, `post_content`, `post_tags`, `post_comment_count`, `post_status`, `post_views_count`) VALUES
(68, 1, 'Leonardo', 'MarioBros', '2019-07-17', 'cms_proyect_1.png', '<ol><li>PHP is awesome!</li></ol>', 'PHP', 5, 'Draft', 79),
(75, 3, 'Yandel', 'MarioBros', '2019-07-17', 'cms_proyect_2.jpg', '<p><strong>SISI</strong></p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>', 'React.Js', 0, 'Draft', 0),
(92, 1, 'Leonardo', 'MarioBros', '2019-07-18', 'cms_proyect_1.png', '<ol><li>PHP is awesome!</li></ol>', 'PHP', NULL, 'Draft', 0),
(93, 2, 'Yandel', 'MarioBros', '2019-07-18', 'cms_proyect_2.jpg', '<p><strong>SISI</strong></p>', 'React.Js', NULL, 'Draft', 1),
(95, 1, 'Leonardo', 'MarioBros', '2019-07-18', 'cms_proyect_1.png', '<ol><li>PHP is awesome!</li></ol>', 'PHP', NULL, 'Draft', 13),
(97, 2, 'Yandel', 'MarioBros', '2019-07-23', 'cms_proyect_2.jpg', '<p><strong>SISI</strong></p>', 'React.Js', NULL, 'Draft', 0),
(98, 1, 'Leonardo', 'MarioBros', '2019-07-23', 'cms_proyect_1.png', '<ol><li>PHP is awesome!</li></ol>', 'PHP', NULL, 'Draft', 0),
(99, 1, 'Leonardo', 'MarioBros', '2019-07-23', 'cms_proyect_1.png', '<ol><li>PHP is awesome!</li></ol>', 'PHP', NULL, 'Draft', 0),
(100, 1, 'Leonardo', 'MarioBros', '2019-07-23', 'cms_proyect_1.png', '<ol><li>PHP is awesome!</li></ol>', 'PHP', NULL, 'Draft', 0),
(101, 1, 'Leonardo', 'MarioBros', '2019-07-23', 'cms_proyect_1.png', '<ol><li>PHP is awesome!</li></ol>', 'PHP', NULL, 'Draft', 0),
(102, 1, 'TEST', '', '2019-07-27', '', '<p>SSSSSS</p>', 'AAAA', 0, 'Draft', 0);

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
  `user_role` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user_id`, `username`, `user_password`, `user_firstname`, `user_lastname`, `user_email`, `user_image`, `user_role`) VALUES
(15, 'MarioBros', '$2y$10$iusesomecrazystrings2uvgnjnDOGIE6JPA9zzq36EdPnYMUav/S', 'MarioBros', 'Bros', 'Mario@gmail.com', NULL, 'Admin'),
(16, 'leonardo', '$2y$10$iusesomecrazystrings2uvgnjnDOGIE6JPA9zzq36EdPnYMUav/S', 'Leonardo', '', 'test@gmail.com', NULL, 'Admin'),
(24, 'Asanchez', '$2y$10$vYtmNwhwPAyrOdIZWjJLPuHsCkdvYMJudyFpopoN4LQMOxM8hj2oy', 'Alexis', 'Sanchez', 'analysis@yipitdata.com', NULL, 'Subscriber'),
(25, 'asaa', '$2y$10$kKT1YOmyVTdpQkjFVwsq4OID/TC1Zrss2Ax31UZIM1CJlUzBh3vm.', 'Ssassa', 'Sssa', 'analysis@yipitdata.com', NULL, 'Subscriber'),
(28, '', '$2y$10$co.8tRcSEXgfrE11TEptku1N.cc67MiJWQ32Rs0D3oMrEbgCVFe0W', 'Yipit', 'Data', 'analysis@yipitdata.com', NULL, 'Subscriber');

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
(8, 'bb19afe0006ef72c4f1f84536931448d', 1564258063);

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
  MODIFY `cat_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `users_online`
--
ALTER TABLE `users_online`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
