-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql103.byetcluster.com
-- Tempo de geração: 29-Out-2024 às 08:15
-- Versão do servidor: 10.6.19-MariaDB
-- versão do PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `b7_37575800_ringg_db`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cards`
--

CREATE TABLE `cards` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `column_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `color` varchar(7) DEFAULT NULL,
  `tasks` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ;

--
-- Extraindo dados da tabela `cards`
--

INSERT INTO `cards` (`id`, `user_id`, `column_id`, `title`, `due_date`, `color`, `tasks`, `is_deleted`, `created_at`) VALUES
(9, 1, 6, 'Novo Card', NULL, '#ffffff', '[]', 0, '2024-10-27 05:52:43'),
(8, NULL, 1, 'Novo Card', NULL, '#ffffff', '[]', 0, '2024-10-27 05:52:15'),
(7, NULL, 1, 'Novo Card', NULL, '#ffffff', '[]', 0, '2024-10-27 05:52:09'),
(10, NULL, 0, 'Novo Card', NULL, '#ffffff', '[]', 0, '2024-10-27 05:52:54'),
(11, NULL, 0, 'Novo Card', NULL, '#ffffff', '[]', 0, '2024-10-27 06:28:58'),
(12, NULL, 1, 'Novo Card', NULL, '#ffffff', '[]', 0, '2024-10-27 06:33:22'),
(13, NULL, 1, 'Novo Card', NULL, '#ffffff', '[]', 0, '2024-10-27 06:33:48'),
(14, NULL, 0, 'Novo Card', NULL, '#ffffff', '[]', 0, '2024-10-27 06:34:05'),
(15, NULL, 0, 'Novo Card', NULL, '#ffffff', '[]', 0, '2024-10-28 15:15:47'),
(16, NULL, 0, 'Novo Card', NULL, '#ffffff', '[]', 0, '2024-10-28 15:15:53'),
(17, NULL, 0, 'Novo Card', NULL, '#ffffff', '[]', 0, '2024-10-28 15:16:28'),
(18, NULL, 0, 'Novo Card', NULL, '#ffffff', '[]', 0, '2024-10-28 15:38:59'),
(19, NULL, 0, 'Novo Card', NULL, '#ffffff', '[]', 0, '2024-10-28 16:58:02'),
(20, NULL, 0, 'Novo Card', NULL, '#ffffff', '[]', 0, '2024-10-28 16:58:03'),
(21, NULL, 0, 'Novo Card', NULL, '#ffffff', '[]', 0, '2024-10-28 16:58:04'),
(22, NULL, 0, 'Novo Card', NULL, '#ffffff', '[]', 0, '2024-10-28 16:58:04'),
(23, NULL, 0, 'Novo Card', NULL, '#ffffff', '[]', 0, '2024-10-29 04:27:29'),
(24, NULL, 0, 'Novo Card', NULL, '#ffffff', '[]', 0, '2024-10-29 04:27:30'),
(25, NULL, 0, 'Novo Card', NULL, '#ffffff', '[]', 0, '2024-10-29 04:27:31'),
(26, NULL, 0, 'Novo Card', NULL, '#ffffff', '[]', 0, '2024-10-29 04:53:16');

-- --------------------------------------------------------

--
-- Estrutura da tabela `columns`
--

CREATE TABLE `columns` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `order_index` int(11) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Extraindo dados da tabela `columns`
--

INSERT INTO `columns` (`id`, `user_id`, `title`, `order_index`, `is_deleted`) VALUES
(19, NULL, 'Coluna 1', 1, 0),
(18, NULL, 'Coluna 2', 2, 0),
(17, NULL, 'Coluna 1', 1, 0),
(16, NULL, 'Coluna 2', 2, 0),
(15, NULL, 'Coluna 1', 1, 0),
(14, NULL, 'Coluna 1', 1, 0),
(13, NULL, 'Coluna 1', 1, 0),
(12, NULL, 'Coluna 1', 1, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `nome`, `email`, `senha`) VALUES
(1, 'ricardo', 'ricardo@gmail.com', '$2y$10$H2W9/n.rD6A6cxMWbSCNYuj/vr2dBcLSCgVJmSAxyz13smGqlnr8W');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `columns`
--
ALTER TABLE `columns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `columns`
--
ALTER TABLE `columns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
