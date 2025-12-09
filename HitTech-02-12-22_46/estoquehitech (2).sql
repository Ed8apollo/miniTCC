
CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `categorias` (`id`, `nome`) VALUES
(1, 'Acessórios'),
(2, 'Notebooks'),
(3, 'Periféricos');



CREATE TABLE `mensagens_chat` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `mensagem` text NOT NULL,
  `remetente` enum('usuario','admin') NOT NULL,
  `lida` tinyint(1) DEFAULT 0,
  `data_envio` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `mensagens_chat` (`id`, `usuario_id`, `mensagem`, `remetente`, `lida`, `data_envio`) VALUES
(1, 14, 'oi', 'usuario', 1, '2025-12-02 21:52:23'),
(2, 14, 'ol', 'usuario', 1, '2025-12-02 21:52:28'),
(3, 14, '987', 'usuario', 1, '2025-12-02 21:53:01'),
(4, 14, '65', 'usuario', 1, '2025-12-02 21:53:15'),
(5, 14, 'as', 'usuario', 1, '2025-12-02 21:54:27'),
(6, 14, 'poiklsx,a', 'usuario', 1, '2025-12-02 21:56:12'),
(7, 14, 'oi', 'usuario', 1, '2025-12-02 21:57:05'),
(8, 14, 'oi meu nome é', 'usuario', 1, '2025-12-02 21:57:13'),
(9, 14, 'S', 'usuario', 1, '2025-12-02 21:57:17'),
(10, 14, 'OPA', 'usuario', 1, '2025-12-02 21:57:29'),
(11, 14, 'ujyhgfdsaweratesydrtfgbxvczasewrteydrjcm', 'usuario', 1, '2025-12-02 21:59:48'),
(12, 14, 'ola', 'admin', 0, '2025-12-02 22:18:16'),
(13, 14, 'oi', 'admin', 0, '2025-12-02 22:18:30'),
(14, 14, 'oi', 'admin', 0, '2025-12-02 22:18:49'),
(15, 14, 'oi como vc ta? queria saber se o site esta passando por manutenção', 'usuario', 1, '2025-12-02 22:19:35'),
(16, 14, 'oi', 'admin', 0, '2025-12-03 01:36:20'),
(17, 14, 'oi', 'usuario', 1, '2025-12-03 01:36:37'),
(18, 13, 'io', 'admin', 0, '2025-12-03 01:37:00'),
(19, 13, 'io', 'admin', 0, '2025-12-03 01:37:02'),
(20, 10, 'oi', 'admin', 0, '2025-12-03 01:37:12'),
(21, 10, 'oi', 'usuario', 1, '2025-12-03 01:37:29');



CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `quantidade` int(11) DEFAULT 0,
  `descricao` varchar(200) DEFAULT NULL,
  `categorias` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `produtos` (`id`, `nome`, `preco`, `quantidade`, `descricao`, `categorias`) VALUES
(1, 'tv', 200.00, 2, '', '1'),
(7, 'Edson', 2.00, 12, 'as', '1'),
(10, 'Edson', 2000.00, 2, '', '1'),
(11, 'Edson', 200.00, 11, 'asd', '2'),
(14, 'Edson', 2000.00, 4, 'hj', '3'),
(17, 'Celular Note 10', 200.00, 4, 'Preto', '1');

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `nivel` enum('admin','usuario') DEFAULT 'usuario',
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `foto`, `nivel`, `data_cadastro`) VALUES
(1, 'Apollo', 'admin@site.com', '$2y$10$nxC2n.uudqwGmATLS9Imn.ZA4vJxxd5ZnQtsmDuaHMq3tQ5YBxY1m', 'usuario_1_1764700902.jpg', 'admin', '2025-11-30 21:08:52'),
(2, 'Edinho', 'edson@site.com', '$2y$10$spPBIkXmtDf8syzfA7K30eVrLk8WiRo32Wgl1e65oTXYBKwuyJTMW', 'usuario_2_1764634309.jpg', 'admin', '2025-11-30 21:08:52'),
(10, 'João Pedro da Silva Duarte', 'duarte@gmail.com', '$2y$10$6kpHpUIh0cLmO/eZ8.xC9uBqEtdoz2YYD38Rouaa4GLTvro2lcnfq', 'usuario_10_1764633937.jpg', 'usuario', '2025-12-01 12:38:52'),
(11, 'Paulo Otávio Biz Manuel', 'biz@gmail.com', '$2y$10$aoDevdRkoCEDYJgAiconou1QzVnKK9UoB65j.F/i9cRGgYwDJLRYW', 'usuario_11_1764634323.jpg', 'usuario', '2025-12-01 17:17:42'),
(12, 'Marcos Amaro', 'amaro@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL, 'usuario', '2025-12-01 23:51:01'),
(13, 'Helivelton', 'lenhador@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL, 'usuario', '2025-12-02 00:16:52'),
(14, 'Vanusa Cardoso Sefström Amaro', 'vanusa@gmail.com', '$2y$10$rcw7xREACq3BUQgcOHiaoOy0yNw8onuzfhhTRX89wUia8UxGv8vm2', 'usuario_14_1764701065.jpg', 'usuario', '2025-12-02 18:43:52');


ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `mensagens_chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_usuario_data` (`usuario_id`,`data_envio`),
  ADD KEY `idx_remetente_lida` (`remetente`,`lida`);

ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

ALTER TABLE `mensagens_chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;


ALTER TABLE `mensagens_chat`
  ADD CONSTRAINT `mensagens_chat_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

