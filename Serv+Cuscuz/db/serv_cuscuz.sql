-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16/03/2026 às 17:24
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
-- Banco de dados: `serv+cuscuz`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `t_alergia`
--

CREATE TABLE `t_alergia` (
  `id` int(11) NOT NULL,
  `nome_alergia` varchar(100) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `t_cliente_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `t_carrossel`
--

CREATE TABLE `t_carrossel` (
  `id` int(11) NOT NULL,
  `imagem_url` varchar(255) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descricao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `t_carrossel`
--

INSERT INTO `t_carrossel` (`id`, `imagem_url`, `titulo`, `descricao`) VALUES
(10, 'assets/img/cuscuz1.jpg', 'Cuscuz do Clemilson', ''),
(11, 'assets/img/cuscuz2.jpg', '', ''),
(12, 'assets/img/67268a324ab82-CARROSSEL_02.jpg', '', ''),
(13, 'assets/img/Cuscuz-nordestino.jpg', '', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `t_categoria`
--

CREATE TABLE `t_categoria` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `t_categoria`
--

INSERT INTO `t_categoria` (`id`, `nome`) VALUES
(1, 'Cuscuz Nordestino'),
(2, 'Cuscuz Paulista'),
(3, 'Cuscuz Marroquino'),
(4, 'Cuscuz de Coco'),
(6, 'Cuscuz Simples e facil'),
(10, 'Cuscuz gostos');

-- --------------------------------------------------------

--
-- Estrutura para tabela `t_cliente`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `t_cliente`
--

INSERT INTO `t_cliente` (`id`, `nome`, `sobrenome`, `cpf`, `email`, `telefone`, `data_criacao`, `data_atualizacao`, `senha`) VALUES
(38, 'Cliente', 'Sales', '02165497847', 'cliente@gmail.com', '12345678912', '2026-03-16 16:22:45', '2026-03-16 16:23:57', '$2y$10$/TF1XL1rYS3UVz4uojHOxuaEY9gIc6w4ZUkVfKwIJUQ.DJ8M/Znxe');

-- --------------------------------------------------------

--
-- Estrutura para tabela `t_endereco`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `t_funcionario`
--

CREATE TABLE `t_funcionario` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `cpf` char(14) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone` char(20) DEFAULT NULL,
  `data_criacao` timestamp NULL DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `t_perfil_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `t_funcionario`
--

INSERT INTO `t_funcionario` (`id`, `nome`, `cpf`, `email`, `telefone`, `data_criacao`, `senha`, `t_perfil_id`) VALUES
(1, 'Administrador', '01234567891', 'administrador@gmail.com', '01234567890', NULL, '$2y$10$wOcJ2sJnt0u06j3CDBu0Iur/guqaFYbvPYsEl3CR1avH.KCAOg/7i', 1),
(7, 'Funcionario', '05398531271', 'funcionario@gmail.com', '12345678912', NULL, '$2y$10$uhcd0AzBVJ7uY/upzNIyJOgv84jZfylC4ciVnNYXgTmZT1MUQHvKO', 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `t_itempedido`
--

CREATE TABLE `t_itempedido` (
  `id` int(11) NOT NULL,
  `quantidade` tinyint(3) UNSIGNED DEFAULT NULL,
  `t_pedido_id` int(11) NOT NULL,
  `t_produto_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `t_pagamento`
--

CREATE TABLE `t_pagamento` (
  `id` int(11) NOT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `data` datetime DEFAULT current_timestamp(),
  `status_pagamento` enum('PENDENTE','APROVADO','REJEITADO') DEFAULT NULL COMMENT 'Status dos pagamentos, podendo ser:\n''PENDENTE'', ''APROVADO'' ou ''REJEITADO''',
  `forma_pagamento` tinyint(4) DEFAULT NULL COMMENT 'Formas de Pagamento, pode ser: \n1 = Dinheiro;\n2 = PIX;\n3 = Cartão de Crédito.',
  `t_pedido_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `t_pedido`
--

CREATE TABLE `t_pedido` (
  `id` int(11) NOT NULL,
  `data` datetime DEFAULT current_timestamp(),
  `status` enum('PENDENTE','PREPARANDO','A_CAMINHO','ENTREGUE','CANCELADO') DEFAULT NULL,
  `entrega_domicilio` tinyint(1) DEFAULT NULL COMMENT '1 = Sim\n0 = Não',
  `preco_total` decimal(10,2) DEFAULT NULL,
  `t_cliente_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `t_perfil`
--

CREATE TABLE `t_perfil` (
  `id` int(11) NOT NULL,
  `tipo_perfil` enum('FUNCIONARIO','ADMINISTRADOR') DEFAULT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `t_perfil`
--

INSERT INTO `t_perfil` (`id`, `tipo_perfil`, `descricao`) VALUES
(1, 'ADMINISTRADOR', 'Perfil com acesso a funcionalidades administrativas.'),
(2, 'FUNCIONARIO', 'Perfil do funcionário');

-- --------------------------------------------------------

--
-- Estrutura para tabela `t_produto`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `t_produto`
--

INSERT INTO `t_produto` (`id`, `nome`, `descricao`, `imagem`, `preco`, `t_funcionario_id`, `tamanho`, `valor_unitario`, `t_categoria_id`) VALUES
(1, 'Cuscuz paulista', 'Cuscuz, cheiro-verde, legumes, ovos cozidos. 400g', 'Cuscuz_paulista.jpg', 14.99, 1, 'M', NULL, 1),
(3, 'Cuscuz simples', 'Cuscuz de milho, manteiga. 300g', 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/CARROSEEL 01.jpg', 9.99, 1, 'G', NULL, 1),
(4, 'Cuscuz Recheado', 'Cuscuz, peito de frango e bacon. 350g', 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/Cuscuz_Recheado_frango.jpg', 14.99, 1, 'M', NULL, 1),
(6, 'Cuscuz delicia', 'Cuscuz, frango e bacon. \r\n400g', 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/Cuscuz-nordestino.jpg', 13.99, 7, 'P', NULL, 1),
(7, 'Cuscuz do Clemilson', 'Cuscuz e manteiga. 300g', 'Cuscuz_normal.jpg', 7.99, 1, 'P', NULL, 1),
(8, 'cuscusz  padrao', 'fsfaddgafdg', 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/Cuscuz_normal.jpg', 14.00, 1, 'G', NULL, 6),
(9, 'Cuscuz paulista', 'hjghg', 'cuscuz3.jpg', 18.50, 1, 'P', NULL, 1),
(10, 'cuscuz  brasileiro', 'fdgfdgs', 'cuscuz2.jpg', 16.90, 1, 'P', NULL, 1),
(32, 'gostoso', 'fssdfdsg', 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/teste2.jpg', 17.99, 1, 'P', NULL, 10),
(34, 'cuscuz delicía', 'adssfá\r\n700g', 'cuscuz3.jpg', 25.99, 1, 'P', NULL, 10);

-- --------------------------------------------------------

--
-- Estrutura para tabela `t_promocao`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `t_alergia`
--
ALTER TABLE `t_alergia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_t_alergia_t_cliente_idx` (`t_cliente_id`);

--
-- Índices de tabela `t_carrossel`
--
ALTER TABLE `t_carrossel`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `t_categoria`
--
ALTER TABLE `t_categoria`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `t_cliente`
--
ALTER TABLE `t_cliente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_cpf` (`cpf`),
  ADD UNIQUE KEY `unique_email` (`email`);

--
-- Índices de tabela `t_endereco`
--
ALTER TABLE `t_endereco`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_endereco_cliente_idx` (`t_cliente_id`);

--
-- Índices de tabela `t_funcionario`
--
ALTER TABLE `t_funcionario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_cpf` (`cpf`),
  ADD UNIQUE KEY `unique_email` (`email`),
  ADD KEY `fk_t_funcionario_t_perfil_idx` (`t_perfil_id`);

--
-- Índices de tabela `t_itempedido`
--
ALTER TABLE `t_itempedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `T_Produto_id` (`t_produto_id`),
  ADD KEY `fk_itempedido_pedido` (`t_pedido_id`);

--
-- Índices de tabela `t_pagamento`
--
ALTER TABLE `t_pagamento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_t_pagamento_t_pedido1_idx` (`t_pedido_id`);

--
-- Índices de tabela `t_pedido`
--
ALTER TABLE `t_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `T_Cliente_id` (`t_cliente_id`),
  ADD KEY `idx_t_cliente_id` (`t_cliente_id`);

--
-- Índices de tabela `t_perfil`
--
ALTER TABLE `t_perfil`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `t_produto`
--
ALTER TABLE `t_produto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_produto_funcionario_idx` (`t_funcionario_id`),
  ADD KEY `fk_t_produto_t_categoria1_idx` (`t_categoria_id`);

--
-- Índices de tabela `t_promocao`
--
ALTER TABLE `t_promocao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `T_Produto_id` (`t_produto_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `t_alergia`
--
ALTER TABLE `t_alergia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `t_carrossel`
--
ALTER TABLE `t_carrossel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `t_categoria`
--
ALTER TABLE `t_categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `t_cliente`
--
ALTER TABLE `t_cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de tabela `t_endereco`
--
ALTER TABLE `t_endereco`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT de tabela `t_funcionario`
--
ALTER TABLE `t_funcionario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de tabela `t_itempedido`
--
ALTER TABLE `t_itempedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de tabela `t_pagamento`
--
ALTER TABLE `t_pagamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `t_pedido`
--
ALTER TABLE `t_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de tabela `t_perfil`
--
ALTER TABLE `t_perfil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `t_produto`
--
ALTER TABLE `t_produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de tabela `t_promocao`
--
ALTER TABLE `t_promocao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `t_alergia`
--
ALTER TABLE `t_alergia`
  ADD CONSTRAINT `fk_alergia_cliente_idx` FOREIGN KEY (`t_cliente_id`) REFERENCES `t_cliente` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `t_endereco`
--
ALTER TABLE `t_endereco`
  ADD CONSTRAINT `fk_endereco_cliente` FOREIGN KEY (`t_cliente_id`) REFERENCES `t_cliente` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `t_funcionario`
--
ALTER TABLE `t_funcionario`
  ADD CONSTRAINT `fk_t_funcionario_t_perfil` FOREIGN KEY (`t_perfil_id`) REFERENCES `t_perfil` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `t_itempedido`
--
ALTER TABLE `t_itempedido`
  ADD CONSTRAINT `fk_itemPedido_produto` FOREIGN KEY (`t_produto_id`) REFERENCES `t_produto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_itempedido_pedido` FOREIGN KEY (`t_pedido_id`) REFERENCES `t_pedido` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `t_pagamento`
--
ALTER TABLE `t_pagamento`
  ADD CONSTRAINT `fk_t_pagamento_t_pedido1` FOREIGN KEY (`t_pedido_id`) REFERENCES `t_pedido` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `t_pedido`
--
ALTER TABLE `t_pedido`
  ADD CONSTRAINT `fk_pedido_cliente` FOREIGN KEY (`t_cliente_id`) REFERENCES `t_cliente` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_pedido_cliente_idx` FOREIGN KEY (`t_cliente_id`) REFERENCES `t_cliente` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `t_produto`
--
ALTER TABLE `t_produto`
  ADD CONSTRAINT `fk_produto_funcionario` FOREIGN KEY (`t_funcionario_id`) REFERENCES `t_funcionario` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_t_produto_t_categoria1` FOREIGN KEY (`t_categoria_id`) REFERENCES `t_categoria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `t_promocao`
--
ALTER TABLE `t_promocao`
  ADD CONSTRAINT `fk_promocao_produto` FOREIGN KEY (`t_produto_id`) REFERENCES `t_produto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

