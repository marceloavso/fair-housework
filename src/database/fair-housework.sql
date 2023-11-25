-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25/11/2023 às 22:19
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
  `id_usuario` int(11) DEFAULT NULL,
  `id_tarefa` int(11) DEFAULT NULL,
  `id_residencia` int(11) NOT NULL,
  `dia_semana` int(1) NOT NULL,
  `descricao` text DEFAULT NULL,
  `feita` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `a_fazer`
--

INSERT INTO `a_fazer` (`id_afazer`, `id_usuario`, `id_tarefa`, `id_residencia`, `dia_semana`, `descricao`, `feita`) VALUES
(3084, 10, 12, 11, 3, NULL, 0),
(3085, 10, 12, 11, 5, NULL, 0),
(3086, NULL, 19, 11, 4, NULL, 0),
(3087, NULL, 19, 11, 7, NULL, 0),
(3116, 14, 26, 17, 2, NULL, 0),
(3117, 14, 26, 17, 4, NULL, 0),
(3118, 14, 27, 17, 6, NULL, 0),
(3119, 10, 5, 8, 5, NULL, 0),
(3120, 10, 5, 8, 4, NULL, 0),
(3121, 7, 5, 8, 3, NULL, 0),
(3122, 7, 5, 8, 1, NULL, 0),
(3123, 10, 6, 8, 6, NULL, 0),
(3124, 7, 5, 8, 7, NULL, 0),
(3125, 7, 5, 8, 2, NULL, 0),
(3126, 10, 5, 8, 6, NULL, 0),
(3127, 10, 6, 8, 1, NULL, 0),
(3128, 10, 6, 8, 2, NULL, 0),
(3129, 11, 24, 14, 1, NULL, 0),
(3130, 7, 24, 14, 6, NULL, 0),
(3131, 13, 24, 14, 5, NULL, 0),
(3132, 13, 23, 14, 2, NULL, 0),
(3133, 11, 23, 14, 6, NULL, 0),
(3134, 13, 24, 14, 4, NULL, 0),
(3135, 11, 24, 14, 3, NULL, 0),
(3136, 7, 23, 14, 4, NULL, 0),
(3137, 7, 24, 14, 7, NULL, 0),
(3138, 13, 24, 14, 2, NULL, 0);

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
(13, 'Casa 3', 'rrr', 333, 'bbb', 'ccc', 'eee', 'Apartamento'),
(14, 'Casa 4', 'Rua 4', 444, 'Bairro 4', 'Cidade 4', 'Estado 4', 'República'),
(16, 'Nova', 'Rua 2', 222, 'B1', 'C2', 'E6', 'Apartamento'),
(17, 'Casa6', 'Rua 6', 666, 'Bairro 6', 'Cidade 6', 'Estado 6', 'Casa');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tarefa`
--

CREATE TABLE `tarefa` (
  `id_tarefa` int(11) NOT NULL,
  `id_residencia` int(11) NOT NULL,
  `nome_tarefa` varchar(60) NOT NULL,
  `frequencia` int(11) NOT NULL,
  `dia_semana` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tarefa`
--

INSERT INTO `tarefa` (`id_tarefa`, `id_residencia`, `nome_tarefa`, `frequencia`, `dia_semana`) VALUES
(5, 8, 'Cozinhar', 7, NULL),
(6, 8, 'Varrer', 3, NULL),
(12, 11, 'Compras', 2, NULL),
(19, 11, 'Limpar Banheiro', 2, '[\"4\",\"7\"]'),
(23, 14, 'Limpar', 3, '[\"2\",\"4\",\"6\"]'),
(24, 14, 'Cozinhar', 7, NULL),
(25, 17, 'Lavar Roupa', 1, '[\"7\"]'),
(26, 17, 'Cozinhar', 2, '[\"2\",\"4\"]'),
(27, 17, 'Varre', 1, NULL);

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
(10, 'teste2@email.com', '123456', 'teste2', 'usuario2'),
(11, 'marceloavso@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Marcelo', 'Soares'),
(13, '02080402@aluno.canoas.ifrs.edu.br', 'e10adc3949ba59abbe56e057f20f883e', 'teste3', 'usuario3'),
(14, 'teste6@email.com', '827ccb0eea8a706c4c34a16891f84e7b', 'teste6', 'usuario6');

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
(7, 13, 1),
(7, 14, 0),
(10, 8, 0),
(10, 11, 0),
(11, 14, 0),
(13, 14, 1),
(14, 17, 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `a_fazer`
--
ALTER TABLE `a_fazer`
  ADD PRIMARY KEY (`id_afazer`),
  ADD KEY `fk_afazer_usuario` (`id_usuario`),
  ADD KEY `fk_afazer_residencia` (`id_residencia`),
  ADD KEY `fk_afazer_tarefa` (`id_tarefa`);

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
  MODIFY `id_afazer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3139;

--
-- AUTO_INCREMENT de tabela `residencia`
--
ALTER TABLE `residencia`
  MODIFY `id_residencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `tarefa`
--
ALTER TABLE `tarefa`
  MODIFY `id_tarefa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `a_fazer`
--
ALTER TABLE `a_fazer`
  ADD CONSTRAINT `fk_afazer_residencia` FOREIGN KEY (`id_residencia`) REFERENCES `residencia` (`id_residencia`),
  ADD CONSTRAINT `fk_afazer_tarefa` FOREIGN KEY (`id_tarefa`) REFERENCES `tarefa` (`id_tarefa`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_afazer_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario_residencia` (`id_usuario`) ON DELETE SET NULL;

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
