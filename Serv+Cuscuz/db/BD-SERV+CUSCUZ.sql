-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 12-Nov-2024 às 01:49
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `serv+cuscuz`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `t_alergia`
--

CREATE TABLE `t_alergia` (
  `id` int(11) NOT NULL,
  `nome_alergia` varchar(100) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `t_cliente_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `t_carrossel`
--

CREATE TABLE `t_carrossel` (
  `id` int(11) NOT NULL,
  `imagem_url` varchar(255) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descricao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `t_carrossel`
--

INSERT INTO `t_carrossel` (`id`, `imagem_url`, `titulo`, `descricao`) VALUES
(1, 'assets/img/CARROSEEL 01.jpg', 'Cuscuz 1', 'Boa opção para quem ama as raízes nordestinas. '),
(2, 'assets/img/67268a324ab82-CARROSSEL 02.jpg', 'Cuscuz recheado ', 'Ótima opção para quem está seguindo uma boa dieta.'),
(3, 'assets/img/Cuscuz_Recheado.jpeg', 'Cuscuz com carne', 'Esse serve como uma refeição.');

-- --------------------------------------------------------

--
-- Estrutura da tabela `t_categoria`
--

CREATE TABLE `t_categoria` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `t_categoria`
--

INSERT INTO `t_categoria` (`id`, `nome`) VALUES
(1, 'Cuscuz Nordestino'),
(2, 'Cuscuz Paulista'),
(3, 'Cuscuz Marroquino'),
(4, 'Cuscuz de Coco'),
(5, 'Cuscuz Caipira'),
(6, 'Cuscuz Simples e facil'),
(10, 'Cuscuz gostoso ');

-- --------------------------------------------------------

--
-- Estrutura da tabela `t_cliente`
--

CREATE TABLE `t_cliente` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `sobrenome` varchar(100) DEFAULT NULL,
  `cpf` char(14) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone` char(20) DEFAULT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_atualizacao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `senha` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `t_cliente`
--

INSERT INTO `t_cliente` (`id`, `nome`, `sobrenome`, `cpf`, `email`, `telefone`, `data_criacao`, `data_atualizacao`, `senha`) VALUES
(29, 'Tiago', 'Santos', '05398531271', 'tiago@gmail.com', '12345678978', '2024-10-28 19:09:58', '2024-10-28 19:09:58', '$2y$10$qfZaog6ftzPyHpP3lxQi8Om9uKx7hNoTlFGD6L5C3GyaPb9l460v.'),
(33, 'Neuzimar', 'Salazar', '71185402268', 'neuzimar@gmail.com', '11111111111', '2024-11-11 19:46:03', '2024-11-11 19:46:03', '$2y$10$KokbsA6ZyQvBeY26DHW08O0Ja.4LS3D81P3H35bBPrhOXmLxBm6ry'),
(34, 'Pablo', 'Santos', '05848771103', 'pablo@gmail.com', '11111111111', '2024-11-12 00:41:33', '2024-11-12 00:41:33', '$2y$10$AD8gn4eioBzVGLsMQznyGuhQiLq0n8kCv7ynqYUHQbEZUvdoLCaCW');

-- --------------------------------------------------------

--
-- Estrutura da tabela `t_endereco`
--

CREATE TABLE `t_endereco` (
  `id` int(14) NOT NULL,
  `rua` varchar(100) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `complemento` varchar(50) DEFAULT NULL,
  `bairro` varchar(50) DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `estado` char(2) DEFAULT NULL,
  `cep` char(9) DEFAULT NULL,
  `t_cliente_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `t_funcionario`
--

CREATE TABLE `t_funcionario` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `cpf` char(14) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone` char(20) DEFAULT NULL,
  `data_criacao` date DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `t_perfil_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `t_funcionario`
--

INSERT INTO `t_funcionario` (`id`, `nome`, `cpf`, `email`, `telefone`, `data_criacao`, `senha`, `t_perfil_id`) VALUES
(1, 'Administrador', '01234567891', 'administrador@gmail.com', '01234567890', NULL, '$2y$10$wOcJ2sJnt0u06j3CDBu0Iur/guqaFYbvPYsEl3CR1avH.KCAOg/7i', 1),
(7, 'Funcionario', '12345678912', 'funcionario@gmail.com', '12345678912', NULL, '$2y$10$pPizy0yB1q1e8WzvNgBA5.9aNgzw4aBYL72GApAbgGixPIGg.pkbW', 2),
(14, 'jonas', '14875982356', 'jonas@gmail.com', '12345475823', NULL, '$2y$10$Zh361/U/AwvPNhtEMsqr2u0fzGJxHsumAwY.yILMGNMu.7lpW29NG', 2),
(36, 'Denilson Salazar', '05398531271', 'denilson@gmail.com', '12345671111', NULL, '$2y$10$iU/HHt4VpwZBMYLtpbKLsePUo2ZvrCssSnLrCfVwcod6kHFKpuQZe', 2),
(37, 'Neuzimar Salazar', '71185402268', 'funcionarioneuzimar@gmail.com', '11111111112', '2024-11-09', '$2y$10$rekoi.6PBkhV6tMqPy0Qbetfqo2Vh3pq4aO5l7kZWv68MiozyBi2W', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `t_itempedido`
--

CREATE TABLE `t_itempedido` (
  `id` int(11) NOT NULL,
  `quantidade` tinyint(3) UNSIGNED DEFAULT NULL,
  `t_pedido_id` int(11) NOT NULL,
  `t_produto_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `t_pagamento`
--

CREATE TABLE `t_pagamento` (
  `id` int(11) NOT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `data` datetime DEFAULT current_timestamp(),
  `status_pagamento` enum('PENDENTE','APROVADO','REJEITADO') DEFAULT NULL COMMENT 'Status dos pagamentos, podendo ser:\n''PENDENTE'', ''APROVADO'' ou ''REJEITADO''',
  `forma_pagamento` tinyint(4) DEFAULT NULL COMMENT 'Formas de Pagamento, pode ser: \n1 = Dinheiro;\n2 = PIX;\n3 = Cartão de Crédito.',
  `t_pedido_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `t_pedido`
--

CREATE TABLE `t_pedido` (
  `id` int(11) NOT NULL,
  `data` datetime DEFAULT current_timestamp(),
  `status` enum('PENDENTE','EM_PREPARO','A_CAMINHO','ENTREGUE','CANCELADO') DEFAULT NULL,
  `entrega_domicilio` tinyint(1) DEFAULT NULL COMMENT '1 = Sim\n0 = Não',
  `preco_total` decimal(10,2) DEFAULT NULL,
  `t_cliente_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `t_perfil`
--

CREATE TABLE `t_perfil` (
  `id` int(11) NOT NULL,
  `tipo_perfil` enum('FUNCIONARIO','ADMINISTRADOR') DEFAULT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `t_perfil`
--

INSERT INTO `t_perfil` (`id`, `tipo_perfil`, `descricao`) VALUES
(1, 'ADMINISTRADOR', 'Perfil com acesso a funcionalidades administrativas.'),
(2, 'FUNCIONARIO', 'Perfil do funcionário');

-- --------------------------------------------------------

--
-- Estrutura da tabela `t_produto`
--

CREATE TABLE `t_produto` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `t_funcionario_id` int(11) DEFAULT NULL,
  `tamanho` varchar(100) NOT NULL,
  `valor_unitario` decimal(10,2) DEFAULT NULL,
  `t_categoria_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `t_produto`
--

INSERT INTO `t_produto` (`id`, `nome`, `descricao`, `imagem`, `preco`, `t_funcionario_id`, `tamanho`, `valor_unitario`, `t_categoria_id`) VALUES
(1, 'salazar 02', 'sasdsdfsd', 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/CARROSSEL 03.jpg', '14.00', 1, 'M', NULL, 1),
(3, 'cuscusz ', 'adssfsdf', 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/CARROSEEL 01.jpg', '14.00', 36, 'G', NULL, 2),
(4, 'cuscusz  bondoso', 'dassdfgfgdyf', 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/Cuscuz_Recheado_frango.jpg', '14.00', 37, 'M', NULL, 3),
(6, 'Denilson salazar 1456', 'denilsonffsdafdf', 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/teste3.jpg', '15.00', 36, 'P', NULL, 10),
(7, 'cuscusz  delicia 0', 'fsdafsdgfdsag', 'teste3.jpg', '14.00', 36, 'P', NULL, 5),
(8, 'cuscusz  padrao', 'fsfaddgafdg', 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/Cuscuz_normal.jpg', '14.00', 1, 'G', NULL, 6),
(9, 'cuscusz  bley X', 'sfasdfdgdg', 'Cuscuz_Recheado_jerked.jpg', '14.00', 36, 'P', NULL, 1),
(10, 'cuscusz  bla', 'fdgfdgs', 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/Cuscuz_Recheado_jerked.jpg', '14.00', 1, 'P', NULL, 2),
(12, 'sadsfs', 'sddgdg', 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/teste3.jpg', '11.00', 1, 'G', NULL, 3),
(14, 'fsfds', 'dsgasdgf', 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/CARROSSEL 03.jpg', '12.00', 36, 'M', NULL, 4),
(15, 'sfdfdg', 'fdsfgfdf', 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/Cuscuz_Recheado_frango.jpg', '15.00', 36, 'M', NULL, 6),
(16, 'dsdasf', 'fsdafdsf', 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/CARROSSEL 03.jpg', '14.00', 36, 'P', NULL, 6),
(17, 'sfdffdg', 'fdsdfdg', 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/CARROSEEL 01.jpg', '15.00', 36, 'P', NULL, 1),
(18, 'ereeter477', 'srafrfgrg', 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/TESTE IMAGEM CANVA.jpg', '15.00', 37, 'P', NULL, 4),
(26, 'cuscusz  charmoso', 'asasfddfg', 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/Cuscuz_Recheado.jpeg', '18.00', 37, 'G', NULL, 1),
(27, 'ereeter47788', 'gfsfasfdsf', 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/Cuscuz_Recheado_jerked.jpg', '18.00', 37, 'G', NULL, 4),
(28, '147', 'sasdfdsf', 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/Cuscuz_Recheado_jerked.jpg', '14.00', 1, 'G', NULL, 5),
(29, 'sfadgf123', 'sfdsgfdghf', 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/CARROSSEL 03.jpg', '15.00', 37, 'P', NULL, 1),
(30, 'sales', 'gfdsgdfgfd', 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/teste3.jpg', '19.00', 1, 'P', NULL, 6);

-- --------------------------------------------------------

--
-- Estrutura da tabela `t_promocao`
--

CREATE TABLE `t_promocao` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `desconto` decimal(10,2) DEFAULT NULL,
  `tipo_promocao` tinyint(4) DEFAULT NULL COMMENT 'Tipo de Promoções, podendo ser:\n1 = Promoções Relampago;\n2 = Feriado;\n3 = Data Comemorativa;',
  `condição_promocao` text DEFAULT NULL,
  `data_inicio` date DEFAULT NULL,
  `data_fim` date DEFAULT NULL,
  `campo_porcentagem` tinyint(4) DEFAULT NULL,
  `t_produto_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `t_alergia`
--
ALTER TABLE `t_alergia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_t_alergia_t_cliente_idx` (`t_cliente_id`);

--
-- Índices para tabela `t_categoria`
--
ALTER TABLE `t_categoria`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `t_cliente`
--
ALTER TABLE `t_cliente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_cpf` (`cpf`),
  ADD UNIQUE KEY `unique_email` (`email`);

--
-- Índices para tabela `t_endereco`
--
ALTER TABLE `t_endereco`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_endereco_cliente_idx` (`t_cliente_id`);

--
-- Índices para tabela `t_funcionario`
--
ALTER TABLE `t_funcionario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_cpf` (`cpf`),
  ADD UNIQUE KEY `unique_email` (`email`),
  ADD KEY `fk_t_funcionario_t_perfil_idx` (`t_perfil_id`);

--
-- Índices para tabela `t_itempedido`
--
ALTER TABLE `t_itempedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `T_Pedido_id` (`t_pedido_id`),
  ADD KEY `T_Produto_id` (`t_produto_id`);

--
-- Índices para tabela `t_pagamento`
--
ALTER TABLE `t_pagamento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_t_pagamento_t_pedido1_idx` (`t_pedido_id`);

--
-- Índices para tabela `t_pedido`
--
ALTER TABLE `t_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `T_Cliente_id` (`t_cliente_id`);

--
-- Índices para tabela `t_perfil`
--
ALTER TABLE `t_perfil`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `t_produto`
--
ALTER TABLE `t_produto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_produto_funcionario_idx` (`t_funcionario_id`),
  ADD KEY `fk_t_produto_t_categoria1_idx` (`t_categoria_id`);

--
-- Índices para tabela `t_promocao`
--
ALTER TABLE `t_promocao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `T_Produto_id` (`t_produto_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `t_alergia`
--
ALTER TABLE `t_alergia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `t_categoria`
--
ALTER TABLE `t_categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `t_cliente`
--
ALTER TABLE `t_cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de tabela `t_endereco`
--
ALTER TABLE `t_endereco`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `t_funcionario`
--
ALTER TABLE `t_funcionario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de tabela `t_itempedido`
--
ALTER TABLE `t_itempedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `t_pagamento`
--
ALTER TABLE `t_pagamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `t_pedido`
--
ALTER TABLE `t_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `t_perfil`
--
ALTER TABLE `t_perfil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `t_produto`
--
ALTER TABLE `t_produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de tabela `t_promocao`
--
ALTER TABLE `t_promocao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `t_alergia`
--
ALTER TABLE `t_alergia`
  ADD CONSTRAINT `fk_t_alergia_t_cliente` FOREIGN KEY (`t_cliente_id`) REFERENCES `t_cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `t_endereco`
--
ALTER TABLE `t_endereco`
  ADD CONSTRAINT `fk_endereco_cliente` FOREIGN KEY (`t_cliente_id`) REFERENCES `t_cliente` (`id`) ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `t_funcionario`
--
ALTER TABLE `t_funcionario`
  ADD CONSTRAINT `fk_t_funcionario_t_perfil` FOREIGN KEY (`t_perfil_id`) REFERENCES `t_perfil` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `t_itempedido`
--
ALTER TABLE `t_itempedido`
  ADD CONSTRAINT `fk_itemPedido_pedido` FOREIGN KEY (`t_pedido_id`) REFERENCES `t_pedido` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_itemPedido_produto` FOREIGN KEY (`t_produto_id`) REFERENCES `t_produto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `t_pagamento`
--
ALTER TABLE `t_pagamento`
  ADD CONSTRAINT `fk_t_pagamento_t_pedido1` FOREIGN KEY (`t_pedido_id`) REFERENCES `t_pedido` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `t_pedido`
--
ALTER TABLE `t_pedido`
  ADD CONSTRAINT `fk_pedido_cliente` FOREIGN KEY (`t_cliente_id`) REFERENCES `t_cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `t_produto`
--
ALTER TABLE `t_produto`
  ADD CONSTRAINT `fk_produto_funcionario` FOREIGN KEY (`t_funcionario_id`) REFERENCES `t_funcionario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_t_produto_t_categoria1` FOREIGN KEY (`t_categoria_id`) REFERENCES `t_categoria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `t_promocao`
--
ALTER TABLE `t_promocao`
  ADD CONSTRAINT `fk_promocao_produto` FOREIGN KEY (`t_produto_id`) REFERENCES `t_produto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
