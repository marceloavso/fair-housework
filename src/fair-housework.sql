-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25/10/2023 às 20:03
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `fair-housework`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `a_fazer`
--

CREATE TABLE `a_fazer` (
  `id_afazer` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_tarefa` int(11) NOT NULL,
  `id_residencia` int(11) NOT NULL,
  `dia_semana` int(1) NOT NULL,
  `descricao` text DEFAULT NULL,
  `feita` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `a_fazer`
--

INSERT INTO `a_fazer` (`id_afazer`, `id_usuario`, `id_tarefa`, `id_residencia`, `dia_semana`, `descricao`, `feita`) VALUES
(1, 7, 5, 8, 1, NULL, 0),
(2, 10, 6, 8, 6, NULL, 0),
(3, 10, 5, 8, 2, NULL, 0),
(4, 7, 5, 8, 3, NULL, 0),
(5, 10, 5, 8, 4, NULL, 0),
(6, 7, 5, 8, 5, NULL, 0),
(7, 10, 5, 8, 6, NULL, 0),
(8, 7, 5, 8, 7, NULL, 0),
(9, 7, 6, 8, 4, NULL, 0),
(10, 10, 6, 8, 1, NULL, 0),
(11, 7, 12, 11, 3, NULL, 0),
(12, 7, 12, 11, 7, NULL, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `residencia`
--

CREATE TABLE `residencia` (
  `id_residencia` int(11) NOT NULL,
  `nome_residencia` varchar(40) NOT NULL,
  `logradouro` varchar(255) NOT NULL,
  `numero` int(11) NOT NULL,
  `bairro` varchar(255) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL,
  `tipo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `residencia`
--

INSERT INTO `residencia` (`id_residencia`, `nome_residencia`, `logradouro`, `numero`, `bairro`, `cidade`, `estado`, `tipo`) VALUES
(8, 'Casa 1', 'a', 3, 'b', 'c', 'e', 'ap'),
(11, 'Casa 2', 'aaa', 333, 'vbbb', 'eeee', 'rr', 'casa'),
(12, 'Casa 3', 'n', 9, 'a', 'q', 'e', 'Apartamento');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tarefa`
--

CREATE TABLE `tarefa` (
  `id_tarefa` int(11) NOT NULL,
  `id_residencia` int(11) NOT NULL,
  `nome_tarefa` varchar(60) NOT NULL,
  `frequencia` int(11) NOT NULL,
  `dia_semana` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tarefa`
--

INSERT INTO `tarefa` (`id_tarefa`, `id_residencia`, `nome_tarefa`, `frequencia`, `dia_semana`) VALUES
(5, 8, 'Cozinhar', 7, NULL),
(6, 8, 'Varrer', 3, NULL),
(12, 11, 'Compras', 2, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(32) NOT NULL,
  `nome_usuario` varchar(30) NOT NULL,
  `sobrenome_usuario` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `email`, `senha`, `nome_usuario`, `sobrenome_usuario`) VALUES
(7, 'teste@email.com', '827ccb0eea8a706c4c34a16891f84e7b', 'teste', 'usuario'),
(10, 'teste2@email.com', '123456', 'teste2', 'usuario2');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario_residencia`
--

CREATE TABLE `usuario_residencia` (
  `id_usuario` int(11) NOT NULL,
  `id_residencia` int(11) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario_residencia`
--

INSERT INTO `usuario_residencia` (`id_usuario`, `id_residencia`, `admin`) VALUES
(7, 8, 1),
(7, 11, 0),
(7, 12, 1),
(10, 8, 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `a_fazer`
--
ALTER TABLE `a_fazer`
  ADD PRIMARY KEY (`id_afazer`),
  ADD KEY `fk_afazer_tarefa` (`id_tarefa`),
  ADD KEY `fk_afazer_usuario` (`id_usuario`),
  ADD KEY `fk_afazer_residencia` (`id_residencia`);

--
-- Índices de tabela `residencia`
--
ALTER TABLE `residencia`
  ADD PRIMARY KEY (`id_residencia`);

--
-- Índices de tabela `tarefa`
--
ALTER TABLE `tarefa`
  ADD PRIMARY KEY (`id_tarefa`),
  ADD UNIQUE KEY `nome_tarefa` (`nome_tarefa`),
  ADD KEY `fk_residencia_tarefa` (`id_residencia`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `u_usuario_email` (`email`);

--
-- Índices de tabela `usuario_residencia`
--
ALTER TABLE `usuario_residencia`
  ADD PRIMARY KEY (`id_usuario`,`id_residencia`),
  ADD KEY `fk_ures_residencia` (`id_residencia`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `a_fazer`
--
ALTER TABLE `a_fazer`
  MODIFY `id_afazer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `residencia`
--
ALTER TABLE `residencia`
  MODIFY `id_residencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `tarefa`
--
ALTER TABLE `tarefa`
  MODIFY `id_tarefa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `a_fazer`
--
ALTER TABLE `a_fazer`
  ADD CONSTRAINT `fk_afazer_residencia` FOREIGN KEY (`id_residencia`) REFERENCES `tarefa` (`id_residencia`),
  ADD CONSTRAINT `fk_afazer_tarefa` FOREIGN KEY (`id_tarefa`) REFERENCES `tarefa` (`id_tarefa`),
  ADD CONSTRAINT `fk_afazer_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario_residencia` (`id_usuario`);

--
-- Restrições para tabelas `tarefa`
--
ALTER TABLE `tarefa`
  ADD CONSTRAINT `fk_residencia_tarefa` FOREIGN KEY (`id_residencia`) REFERENCES `residencia` (`id_residencia`);

--
-- Restrições para tabelas `usuario_residencia`
--
ALTER TABLE `usuario_residencia`
  ADD CONSTRAINT `fk_ures_residencia` FOREIGN KEY (`id_residencia`) REFERENCES `residencia` (`id_residencia`),
  ADD CONSTRAINT `fk_ures_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
