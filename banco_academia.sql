-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 23-Nov-2024 às 19:41
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `banco_academia`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `alunoinstrutor`
--

CREATE TABLE `alunoinstrutor` (
  `id_aluno` int(11) NOT NULL,
  `treino` varchar(250) NOT NULL,
  `tempo` time NOT NULL,
  `fk_id_aluno` int(11) NOT NULL,
  `senha` varchar(250) NOT NULL,
  `nome` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `alunoinstrutor`
--

INSERT INTO `alunoinstrutor` (`id_aluno`, `treino`, `tempo`, `fk_id_aluno`, `senha`, `nome`) VALUES
(1, 'costas', '00:00:01', 3, '123', 'caue');

-- --------------------------------------------------------

--
-- Estrutura da tabela `alunos`
--

CREATE TABLE `alunos` (
  `id` int(11) NOT NULL,
  `nome` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `telefone` varchar(11) NOT NULL,
  `fk_id_instrutor` int(11) NOT NULL,
  `senha` varchar(250) NOT NULL,
  `data_nasc` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `alunos`
--

INSERT INTO `alunos` (`id`, `nome`, `email`, `telefone`, `fk_id_instrutor`, `senha`, `data_nasc`) VALUES
(1, 'caue', 'soterocaue@gmail.com', '12991992477', 4, '$2y$10$tmt9W14L2LxzmKbvwaFbf.hQE7dyTzUCqfJBgXvmD3U5GrJTaQbqy', '2024-11-28'),
(2, 'yan', 'yan@gmail.com', '12991992477', 7, '$2y$10$pXVw.r64xP9jexmpmtjWd./5aiauRTxAjxb9/5LjC.mlc8UP.l3AG', '2024-11-14'),
(3, 'yan', 'yan@gmail.com', '12991992477', 7, '$2y$10$./sDTmG5GQN7rVsTdhVJ6ODRUvnaMCF8Ryzvg5ejAXxvo7fPXwwOu', '2024-11-14'),
(4, 'yan', 'yan@gmail.com', '12991992477', 7, '$2y$10$8n8S2VmCiANI36SMquGvae2sjn2uAmxiFXM3raAzmFui491DsDRKK', '2024-11-14');

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluno_exercicios`
--

CREATE TABLE `aluno_exercicios` (
  `id` int(11) NOT NULL,
  `aluno_id` int(11) NOT NULL,
  `exercicio_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cadastro`
--

CREATE TABLE `cadastro` (
  `id` int(11) NOT NULL,
  `nome` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `tipo_user` enum('Instrutor','Aluno','Administrador') NOT NULL,
  `senha` varchar(250) NOT NULL,
  `telefone` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `cadastro`
--

INSERT INTO `cadastro` (`id`, `nome`, `email`, `tipo_user`, `senha`, `telefone`) VALUES
(6, 'adm', 'adm@gmail.com', 'Administrador', '$2y$10$2PUa37IhETn5vgJzAmY5pOnmQ8bOfcz47ud6FmOxKddRCI21HX2n.', '12991992477'),
(7, 'instrutor', 'instrutor@gmail.com', 'Instrutor', '$2y$10$6ekwPKS2lOgtIMmBP.qIkeLR9TYlxKapS3eXhXze5RpCikGXXzdmm', '12991992477');

-- --------------------------------------------------------

--
-- Estrutura da tabela `equipamentos`
--

CREATE TABLE `equipamentos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `quantidade` int(11) NOT NULL,
  `data_aquisicao` date DEFAULT NULL,
  `status` enum('Disponível','Em Manutenção','Indisponível') DEFAULT 'Disponível',
  `instrutor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `equipamentos`
--

INSERT INTO `equipamentos` (`id`, `nome`, `descricao`, `quantidade`, `data_aquisicao`, `status`, `instrutor_id`) VALUES
(8, 'barrass', 'www', 3, '2024-11-21', '', 4),
(9, 'barra', 'bom', 1, '2024-11-08', 'Em Manutenção', 7);

-- --------------------------------------------------------

--
-- Estrutura da tabela `exercicios`
--

CREATE TABLE `exercicios` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `series` int(11) DEFAULT NULL,
  `repeticoes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `instrutores`
--

CREATE TABLE `instrutores` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `fk_id_instrutor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `series`
--

CREATE TABLE `series` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `quantidade_exercicios` int(11) NOT NULL,
  `data_criacao` date NOT NULL,
  `aluno_id` int(11) NOT NULL,
  `instrutor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `alunoinstrutor`
--
ALTER TABLE `alunoinstrutor`
  ADD PRIMARY KEY (`id_aluno`);

--
-- Índices para tabela `alunos`
--
ALTER TABLE `alunos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `aluno_exercicios`
--
ALTER TABLE `aluno_exercicios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aluno_id` (`aluno_id`),
  ADD KEY `aluno_exercicios_ibfk_2` (`exercicio_id`);

--
-- Índices para tabela `cadastro`
--
ALTER TABLE `cadastro`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `equipamentos`
--
ALTER TABLE `equipamentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `instrutor_id` (`instrutor_id`);

--
-- Índices para tabela `exercicios`
--
ALTER TABLE `exercicios`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `instrutores`
--
ALTER TABLE `instrutores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_instrutor` (`fk_id_instrutor`);

--
-- Índices para tabela `series`
--
ALTER TABLE `series`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aluno_id` (`aluno_id`),
  ADD KEY `instrutor_id` (`instrutor_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `alunoinstrutor`
--
ALTER TABLE `alunoinstrutor`
  MODIFY `id_aluno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `alunos`
--
ALTER TABLE `alunos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `aluno_exercicios`
--
ALTER TABLE `aluno_exercicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `cadastro`
--
ALTER TABLE `cadastro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `equipamentos`
--
ALTER TABLE `equipamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `exercicios`
--
ALTER TABLE `exercicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `instrutores`
--
ALTER TABLE `instrutores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `series`
--
ALTER TABLE `series`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `aluno_exercicios`
--
ALTER TABLE `aluno_exercicios`
  ADD CONSTRAINT `aluno_exercicios_ibfk_1` FOREIGN KEY (`aluno_id`) REFERENCES `alunos` (`id`),
  ADD CONSTRAINT `aluno_exercicios_ibfk_2` FOREIGN KEY (`exercicio_id`) REFERENCES `exercicios` (`id`);

--
-- Limitadores para a tabela `instrutores`
--
ALTER TABLE `instrutores`
  ADD CONSTRAINT `instrutores_ibfk_1` FOREIGN KEY (`fk_id_instrutor`) REFERENCES `cadastro` (`id`);

--
-- Limitadores para a tabela `series`
--
ALTER TABLE `series`
  ADD CONSTRAINT `series_ibfk_1` FOREIGN KEY (`aluno_id`) REFERENCES `alunos` (`id`),
  ADD CONSTRAINT `series_ibfk_2` FOREIGN KEY (`instrutor_id`) REFERENCES `instrutores` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
