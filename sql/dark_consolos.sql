-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 06/09/2024 às 02:56
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
-- Banco de dados: `dark_consolos`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbclientes`
--

CREATE TABLE `tbclientes` (
  `idCli` int(11) NOT NULL,
  `nomeCli` varchar(255) NOT NULL,
  `emailCli` varchar(255) NOT NULL,
  `senhaCli` varchar(255) NOT NULL,
  `cpf` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbclientes`
--

INSERT INTO `tbclientes` (`idCli`, `nomeCli`, `emailCli`, `senhaCli`, `cpf`) VALUES
(4, 'penis da silva', 'merda@merda.com', '$2y$10$3ubCEXmnSwZePgumPBC83uTq69vaHizVvFyS0w9c2K1VrLsEg7182', '12345678911'),
(5, 'penis da silva', 'merda@merda.com', '$2y$10$IEo0g0c7MXeSTtIjElVYquQItjFtp6OlC4PWqFcBbB6CzCTMGp30e', '12345678912'),
(6, 'kagaro nakama 2', 'semem@merda.com', '$2y$10$9kGpk9WrI0evbY7BIgrYiuxG1DpTwVlgLU.F3qE0tag8HbqhzSInK', '12345678914');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbfuncionarios`
--

CREATE TABLE `tbfuncionarios` (
  `idFunc` int(11) NOT NULL,
  `nomeFunc` varchar(255) NOT NULL,
  `emailFunc` varchar(255) NOT NULL,
  `senhaFunc` varchar(255) NOT NULL,
  `ativo` tinyint(1) NOT NULL,
  `cargo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbfuncionarios`
--

INSERT INTO `tbfuncionarios` (`idFunc`, `nomeFunc`, `emailFunc`, `senhaFunc`, `ativo`, `cargo`) VALUES
(3, 'admin', 'admin@admin.com', '$2y$10$CorBWBFqTqeEVc0uahpfa.0cGh.i5vT6qx2wIWd6gqhuiuWNK9Agy', 1, 'admin');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbpedidos`
--

CREATE TABLE `tbpedidos` (
  `idPedido` int(11) NOT NULL,
  `idProduto` int(11) NOT NULL,
  `idCli` int(11) NOT NULL,
  `data` date NOT NULL DEFAULT current_timestamp(),
  `precoVenda` decimal(10,2) NOT NULL,
  `qnt` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbpedidos`
--

INSERT INTO `tbpedidos` (`idPedido`, `idProduto`, `idCli`, `data`, `precoVenda`, `qnt`) VALUES
(19, 4, 4, '2024-08-31', 4.20, 3),
(20, 2, 4, '2024-08-31', 69.99, 1),
(21, 4, 4, '2024-08-31', 4.20, 3),
(22, 2, 4, '2024-08-31', 69.99, 1),
(23, 4, 4, '2024-09-01', 4.20, 4),
(24, 4, 4, '2024-09-01', 4.20, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbproduto`
--

CREATE TABLE `tbproduto` (
  `idProd` int(11) NOT NULL,
  `nomeProd` varchar(255) NOT NULL,
  `descrProd` varchar(255) NOT NULL,
  `fotoProd` varchar(255) NOT NULL,
  `qnt` int(11) NOT NULL,
  `precoVenda` decimal(10,2) NOT NULL,
  `promocao` tinyint(1) NOT NULL,
  `precoProm` decimal(10,2) NOT NULL,
  `ativo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbproduto`
--

INSERT INTO `tbproduto` (`idProd`, `nomeProd`, `descrProd`, `fotoProd`, `qnt`, `precoVenda`, `promocao`, `precoProm`, `ativo`) VALUES
(2, 'carlinhos', 'o homem que bateu o recorde mundial em dar a bunda', 'img6416a59cf3fe73.webp', 4, 69.99, 0, 39.69, 1),
(4, 'dalva', 'dalva é a maior vagabunda de todo', 'dalva.png', 0, 4.20, 1, 0.69, 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tbclientes`
--
ALTER TABLE `tbclientes`
  ADD PRIMARY KEY (`idCli`);

--
-- Índices de tabela `tbfuncionarios`
--
ALTER TABLE `tbfuncionarios`
  ADD PRIMARY KEY (`idFunc`);

--
-- Índices de tabela `tbpedidos`
--
ALTER TABLE `tbpedidos`
  ADD PRIMARY KEY (`idPedido`);

--
-- Índices de tabela `tbproduto`
--
ALTER TABLE `tbproduto`
  ADD PRIMARY KEY (`idProd`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tbclientes`
--
ALTER TABLE `tbclientes`
  MODIFY `idCli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `tbfuncionarios`
--
ALTER TABLE `tbfuncionarios`
  MODIFY `idFunc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tbpedidos`
--
ALTER TABLE `tbpedidos`
  MODIFY `idPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de tabela `tbproduto`
--
ALTER TABLE `tbproduto`
  MODIFY `idProd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
