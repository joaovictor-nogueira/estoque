-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 26/06/2024 às 14:14
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `estoque`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens`
--

CREATE TABLE `itens` (
  `id` int(11) NOT NULL,
  `capa` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `quant_min` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `itens`
--

INSERT INTO `itens` (`id`, `capa`, `slug`, `nome`, `quantidade`, `quant_min`, `status`) VALUES
(1, 'copo.jpg', 'copo', 'copo', 1, 3, 1),
(5, 'prato.jpg', 'prato', 'Prato', 11, 5, 1),
(6, 'lampada.jpg', 'lampada', 'Lampada', 13, 5, 1),
(7, NULL, 'pneu', 'pneu', 0, 1, 1),
(8, 'teclado-simples.jpg', 'teclado-simples', 'Teclado Simples', 9, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `movimentacoes`
--

CREATE TABLE `movimentacoes` (
  `id` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `usuario_responsavel_id` int(11) DEFAULT NULL,
  `usuario_retirante_id` int(11) DEFAULT NULL,
  `usuario_entregador_id` int(11) DEFAULT NULL,
  `tipo` varchar(255) NOT NULL,
  `quantidade_mov` int(11) NOT NULL,
  `data` datetime NOT NULL,
  `descricao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `movimentacoes`
--

INSERT INTO `movimentacoes` (`id`, `id_item`, `usuario_responsavel_id`, `usuario_retirante_id`, `usuario_entregador_id`, `tipo`, `quantidade_mov`, `data`, `descricao`) VALUES
(4, 1, NULL, 2, 1, 'saida', 2, '2024-06-25 14:32:49', 'sub ahaha'),
(5, 5, 1, NULL, NULL, 'entrada', 2, '2024-06-25 15:14:07', 'soma kaka'),
(6, 5, NULL, 72, 1, 'saida', 1, '2024-06-25 15:16:40', 'teste'),
(7, 1, 1, NULL, NULL, 'entrada', 2, '2024-06-25 15:16:51', ''),
(8, 6, NULL, 72, 1, 'saida', 5, '2024-06-25 16:58:31', 'retirei a lâmpada para consertar a quebrada'),
(9, 6, NULL, 1, 1, 'saida', 5, '2024-06-25 17:06:20', 'Para zerar o estoque'),
(10, 6, 1, NULL, NULL, 'entrada', 1, '2024-06-25 17:07:18', ''),
(11, 6, NULL, 0, 1, 'saida', 1, '2024-06-25 17:07:35', ''),
(12, 5, NULL, 0, 1, 'saida', 10, '2024-06-25 17:08:19', ''),
(13, 1, NULL, 0, 1, 'saida', 5, '2024-06-25 17:11:29', ''),
(14, 6, 1, NULL, NULL, 'entrada', 2, '2024-06-25 17:20:30', ''),
(15, 6, 1, NULL, NULL, 'entrada', 10, '2024-06-25 17:21:26', ''),
(16, 5, 1, NULL, NULL, 'entrada', 10, '2024-06-25 17:21:34', ''),
(17, 1, 1, NULL, NULL, 'entrada', 10, '2024-06-25 17:21:48', ''),
(18, 6, NULL, 0, 1, 'saida', 11, '2024-06-25 20:04:40', ''),
(19, 7, NULL, 72, 1, 'saida', 5, '2024-06-25 20:04:56', ''),
(20, 1, NULL, 0, 1, 'saida', 0, '2024-06-25 20:12:16', ''),
(21, 1, NULL, 0, 1, 'saida', 10, '2024-06-25 20:12:22', ''),
(22, 1, NULL, 0, 1, 'saida', 1, '2024-06-25 20:12:26', ''),
(23, 6, 1, NULL, NULL, 'entrada', 1, '2024-06-25 20:18:55', ''),
(24, 6, NULL, 0, 1, 'saida', 1, '2024-06-25 20:20:11', ''),
(25, 6, NULL, 0, 1, 'saida', 1, '2024-06-25 20:20:36', 'retirando'),
(26, 6, 1, NULL, NULL, 'entrada', 2, '2024-06-25 20:21:22', ''),
(27, 6, NULL, 0, 1, 'saida', 1, '2024-06-25 20:21:33', ''),
(28, 6, NULL, 0, 1, 'saida', 1, '2024-06-25 20:22:27', ''),
(29, 6, 1, NULL, NULL, 'entrada', 3, '2024-06-25 20:23:03', ''),
(30, 6, NULL, 0, 1, 'saida', 1, '2024-06-25 20:23:07', ''),
(31, 1, 1, NULL, NULL, 'entrada', 1, '2024-06-25 20:25:15', ''),
(32, 6, 1, NULL, NULL, 'entrada', 10, '2024-06-25 20:25:48', ''),
(33, 6, 1, NULL, NULL, 'entrada', 4, '2024-06-25 22:13:08', 'TEste'),
(35, 6, NULL, 72, 1, 'saida', 3, '2024-06-25 22:44:14', 'Retirada lâmpada para repor quebrada!');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `level` int(11) NOT NULL DEFAULT 1,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `ultimo_login` datetime DEFAULT NULL,
  `cadastrado_em` datetime NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` datetime DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `level`, `nome`, `email`, `senha`, `status`, `ultimo_login`, `cadastrado_em`, `atualizado_em`, `token`) VALUES
(1, 3, 'João Victor', 'jvdoratioto@gmail.com', '$2y$10$fKzky68FGzkgOsm.PyM3PeIOfZ63Q27GYYS8zBLOuZIw/FlzMN1eK', 1, '2024-06-25 22:41:28', '2024-03-04 10:55:28', '2024-05-08 18:59:01', NULL),
(72, 1, 'admin2', 'admin@admin.com', '$2y$10$bnwOdvlms7t9swuxitOwdeio5Nc.Cw0bYwlOoeDZIY8PW033xnAgW', 1, '2024-06-25 22:15:02', '2024-06-24 21:22:13', '2024-06-24 21:25:41', NULL),
(73, 3, 'Anderson', 'anderson@gmail.com', '$2y$10$VSITWEm7RYHYZF0QqprYcuAYVknWyXu2m0L0rpwHpZ8YNANjRyu8u', 1, NULL, '2024-06-25 22:14:31', NULL, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `itens`
--
ALTER TABLE `itens`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `movimentacoes`
--
ALTER TABLE `movimentacoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `itens`
--
ALTER TABLE `itens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `movimentacoes`
--
ALTER TABLE `movimentacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
