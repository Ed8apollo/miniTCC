-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 02/12/2025 às 22:21
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `estoquehitech`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `categorias`
--

INSERT INTO `categorias` (`id`, `nome`) VALUES
(1, 'Acessórios'),
(2, 'Notebooks'),
(3, 'Periféricos');

-- --------------------------------------------------------

--
-- Estrutura para tabela `mensagens_chat`
--

CREATE TABLE `mensagens_chat` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `mensagem` text NOT NULL,
  `remetente` enum('usuario','admin') NOT NULL,
  `lida` tinyint(1) DEFAULT 0,
  `data_envio` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `quantidade` int(11) DEFAULT 0,
  `descricao` varchar(200) DEFAULT NULL,
  `categorias` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `preco`, `quantidade`, `descricao`, `categorias`) VALUES
(1, 'tv', 200.00, 2, '', '1'),
(7, 'Edson', 2.00, 12, 'as', '1'),
(10, 'Edson', 2000.00, 2, '', '1'),
(11, 'Edson', 200.00, 11, 'asd', '2'),
(14, 'Edson', 2000.00, 4, 'hj', '3'),
(17, 'Celular Note 10', 200.00, 4, 'Preto', '1');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `nivel` enum('admin','usuario') DEFAULT 'usuario',
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `foto`, `nivel`, `data_cadastro`) VALUES
(1, 'Apollo', 'admin@site.com', '$2y$10$ZquQohL3CWXlxmNsMPGq9eKU2SoaorG08rsM5/LcHIndZofK5qIQ6', 'usuario_1_1764700902.jpg', 'admin', '2025-11-30 21:08:52'),
(2, 'Edinho', 'edson@site.com', '$2y$10$spPBIkXmtDf8syzfA7K30eVrLk8WiRo32Wgl1e65oTXYBKwuyJTMW', 'usuario_2_1764634309.jpg', 'admin', '2025-11-30 21:08:52'),
(10, 'João Pedro da Silva Duarte', 'duarte@gmail.com', '$2y$10$6kpHpUIh0cLmO/eZ8.xC9uBqEtdoz2YYD38Rouaa4GLTvro2lcnfq', 'usuario_10_1764633937.jpg', 'usuario', '2025-12-01 12:38:52'),
(11, 'Paulo Otávio Biz Manuel', 'biz@gmail.com', '$2y$10$aoDevdRkoCEDYJgAiconou1QzVnKK9UoB65j.F/i9cRGgYwDJLRYW', 'usuario_11_1764634323.jpg', 'usuario', '2025-12-01 17:17:42'),
(12, 'Marcos Amaro', 'amaro@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL, 'usuario', '2025-12-01 23:51:01'),
(13, 'Helivelton', 'lenhador@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL, 'usuario', '2025-12-02 00:16:52'),
(14, 'Vanusa Cardoso Sefström Amaro', 'vanusa@gmail.com', '$2y$10$rcw7xREACq3BUQgcOHiaoOy0yNw8onuzfhhTRX89wUia8UxGv8vm2', 'usuario_14_1764701065.jpg', 'usuario', '2025-12-02 18:43:52');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `mensagens_chat`
--
ALTER TABLE `mensagens_chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_usuario_data` (`usuario_id`,`data_envio`),
  ADD KEY `idx_remetente_lida` (`remetente`,`lida`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `mensagens_chat`
--
ALTER TABLE `mensagens_chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `mensagens_chat`
--
ALTER TABLE `mensagens_chat`
  ADD CONSTRAINT `mensagens_chat_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
