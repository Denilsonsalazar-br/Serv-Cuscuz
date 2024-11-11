-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11/11/2024 às 17:52
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
  `t_cliente_id1` int(11) NOT NULL
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
(1, 'assets/img/CARROSEEL 01.jpg', 'Cuscuz 2', 'Boa opção para quem ama as raízes nordestinas. '),
(2, 'assets/img/67268a324ab82-CARROSSEL 02.jpg', 'Cuscuz recheado ', 'Ótima opção para quem está seguindo uma boa dieta.'),
(3, 'assets/img/Cuscuz_Recheado.jpeg', 'Cuscuz com carne', 'Esse serve como uma refeição.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `t_categoria`
--

CREATE TABLE `t_categoria` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `t_categoria`
--

INSERT INTO `t_categoria` (`id`, `nome`) VALUES
(1, 'Cuscuz Nordestino'),
(2, 'Cuscuz Paulista'),
(3, 'Cuscuz Marroquino'),
(4, 'Cuscuz de Coco'),
(5, 'Cuscuz Caipira'),
(6, 'Cuscuz Simples e facil'),
(10, 'Cuscuz gostoso 2');

-- --------------------------------------------------------

--
-- Estrutura para tabela `t_cliente`
--

CREATE TABLE `t_cliente` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `sobrenome` varchar(100) DEFAULT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_atualizacao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `senha` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `t_cliente`
--

INSERT INTO `t_cliente` (`id`, `nome`, `sobrenome`, `cpf`, `email`, `telefone`, `data_criacao`, `data_atualizacao`, `senha`) VALUES
(29, 'Tiago', 'Santos', '05398531271', 'tiago@gmail.com', '12345678978', '2024-10-28 16:09:58', '2024-10-28 16:09:58', '$2y$10$qfZaog6ftzPyHpP3lxQi8Om9uKx7hNoTlFGD6L5C3GyaPb9l460v.'),
(33, 'Neuzimar', 'Salazar', '71185402268', 'neuzimar@gmail.com', '11111111111', '2024-11-11 16:46:03', '2024-11-11 16:46:03', '$2y$10$KokbsA6ZyQvBeY26DHW08O0Ja.4LS3D81P3H35bBPrhOXmLxBm6ry');

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
  `cep` varchar(9) DEFAULT NULL,
  `t_cliente_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `t_funcionario`
--

CREATE TABLE `t_funcionario` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `data_criacao` date DEFAULT current_timestamp(),
  `senha` varchar(60) DEFAULT NULL,
  `t_perfil_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `t_funcionario`
--

INSERT INTO `t_funcionario` (`id`, `nome`, `cpf`, `email`, `telefone`, `data_criacao`, `senha`, `t_perfil_id`) VALUES
(1, 'Administrador', '01234567891', 'administrador@gmail.com', '01234567890', NULL, '$2y$10$wOcJ2sJnt0u06j3CDBu0Iur/guqaFYbvPYsEl3CR1avH.KCAOg/7i', 1),
(7, 'Funcionario', '12345678912', 'funcionario@gmail.com', '12345678912', NULL, '$2y$10$pPizy0yB1q1e8WzvNgBA5.9aNgzw4aBYL72GApAbgGixPIGg.pkbW', 2),
(14, 'jonas', '14875982356', 'jonas@gmail.com', '12345475823', NULL, '$2y$10$Zh361/U/AwvPNhtEMsqr2u0fzGJxHsumAwY.yILMGNMu.7lpW29NG', 2),
(36, 'Denilson Salazar', '05398531271', 'denilson@gmail.com', '12345671111', NULL, '$2y$10$iU/HHt4VpwZBMYLtpbKLsePUo2ZvrCssSnLrCfVwcod6kHFKpuQZe', 2),
(37, 'Neuzimar Salazar', '71185402268', 'funcionarioneuzimar@gmail.com', '11111111112', '2024-11-09', '$2y$10$rekoi.6PBkhV6tMqPy0Qbetfqo2Vh3pq4aO5l7kZWv68MiozyBi2W', 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `t_ingrediente`
--

CREATE TABLE `t_ingrediente` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `preco_adicional` decimal(10,2) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `t_itempedido`
--

CREATE TABLE `t_itempedido` (
  `id` int(11) NOT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `valor_unitario` decimal(10,2) DEFAULT NULL,
  `preco_total` decimal(10,2) DEFAULT NULL,
  `t_pedido_id` int(11) NOT NULL,
  `t_produto_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `t_itempedidoopcaoadicional`
--

CREATE TABLE `t_itempedidoopcaoadicional` (
  `id` int(11) NOT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `t_itemPedido_id` int(11) NOT NULL,
  `t_opcaoAdicional_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `t_opcaoadicional`
--

CREATE TABLE `t_opcaoadicional` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `t_pagamento`
--

CREATE TABLE `t_pagamento` (
  `id` int(11) NOT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `status_pagamento` enum('PENDENTE','APROVADO','REJEITADO') DEFAULT NULL,
  `forma_pagamento` varchar(50) DEFAULT NULL,
  `t_pedido_id1` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `t_pedido`
--

CREATE TABLE `t_pedido` (
  `id` int(11) NOT NULL,
  `data` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `status` enum('PENDENTE','EM_PREPARO','A_CAMINHO','ENTREGUE','CANCELADO') DEFAULT NULL,
  `entrega_domicilio` tinyint(1) DEFAULT NULL,
  `t_cliente_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `t_perfil`
--

CREATE TABLE `t_perfil` (
  `id` int(11) NOT NULL,
  `tipo_perfil` enum('FUNCIONARIO','ADMINISTRADOR') CHARACTER SET armscii8 COLLATE armscii8_general_ci DEFAULT NULL,
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
-- Estrutura para tabela `t_personalizacaoprodutoingrediente`
--

CREATE TABLE `t_personalizacaoprodutoingrediente` (
  `id` int(11) NOT NULL,
  `obrigatorio` tinyint(1) DEFAULT NULL,
  `preco_unidade` decimal(10,2) DEFAULT NULL,
  `quantidade_padrao` int(11) DEFAULT NULL,
  `quantidade_minima` int(11) DEFAULT NULL,
  `quantidade_maxima` int(11) DEFAULT NULL,
  `t_produto_id` int(11) NOT NULL,
  `t_ingrediente_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `t_produto`
--

CREATE TABLE `t_produto` (
  `id` int(11) NOT NULL,
  `t_funcionario_id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `tamanho` varchar(100) NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `t_categoria_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `t_produto`
--

INSERT INTO `t_produto` (`id`, `t_funcionario_id`, `nome`, `descricao`, `preco`, `tamanho`, `imagem`, `t_categoria_id`) VALUES
(1, 1, 'salazar 01', 'sasdsdfsd', 14.00, 'M', 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/CARROSSEL 03.jpg', 1),
(3, 36, 'cuscusz ', 'adssfsdf', 14.00, 'G', 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/CARROSEEL 01.jpg', 2),
(4, 37, 'cuscusz  bondoso', 'dassdfgfgdyf', 14.00, 'M', 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/Cuscuz_Recheado_frango.jpg', 3),
(6, 36, 'Denilson salazar 1456', 'denilsonffsdafdf', 15.00, 'P', 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/teste3.jpg', 10),
(7, 36, 'cuscusz  delicia 0', 'fsdafsdgfdsag', 14.00, 'P', 'teste3.jpg', 5),
(8, 1, 'cuscusz  padrao', 'fsfaddgafdg', 14.00, 'G', 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/Cuscuz_normal.jpg', 6),
(9, 36, 'cuscusz  bley X', 'sfasdfdgdg', 14.00, 'P', 'Cuscuz_Recheado_jerked.jpg', 1),
(10, 1, 'cuscusz  bla', 'fdgfdgs', 14.00, 'P', 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/Cuscuz_Recheado_jerked.jpg', 2),
(12, 1, 'sadsfs', 'sddgdg', 11.00, 'G', 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/teste3.jpg', 3),
(14, 36, 'fsfds', 'dsgasdgf', 12.00, 'M', 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/CARROSSEL 03.jpg', 4),
(15, 36, 'sfdfdg', 'fdsfgfdf', 15.00, 'M', 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/Cuscuz_Recheado_frango.jpg', 6),
(16, 36, 'dsdasf', 'fsdafdsf', 14.00, 'P', 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/CARROSSEL 03.jpg', 6),
(17, 36, 'sfdffdg', 'fdsdfdg', 15.00, 'P', 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/CARROSEEL 01.jpg', 1),
(18, 37, 'ereeter477', 'srafrfgrg', 15.00, 'P', 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/TESTE IMAGEM CANVA.jpg', 4),
(26, 37, 'cuscusz  charmoso', 'asasfddfg', 18.00, 'G', 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/Cuscuz_Recheado.jpeg', 1),
(27, 37, 'ereeter47788', 'gfsfasfdsf', 18.00, 'G', 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/Cuscuz_Recheado_jerked.jpg', 4),
(28, 1, '147', 'sasdfdsf', 14.00, 'G', 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/Cuscuz_Recheado_jerked.jpg', 5),
(29, 37, 'sfadgf123', 'sfdsgfdghf', 15.00, 'P', 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/CARROSSEL 03.jpg', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `t_promocao`
--

CREATE TABLE `t_promocao` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `desconto` decimal(10,2) DEFAULT NULL,
  `tipo_promocao` varchar(50) DEFAULT NULL,
  `condição_promocao` text DEFAULT NULL,
  `data_inicio` date DEFAULT NULL,
  `data_fim` date DEFAULT NULL,
  `campo_porcentagem` tinyint(1) DEFAULT NULL,
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
  ADD KEY `fk_t_alergia_t_cliente1_idx` (`t_cliente_id1`);

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
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD UNIQUE KEY `cpf_2` (`cpf`);

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
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD KEY `fk_t_funcionario_t_perfil1_idx` (`t_perfil_id`);

--
-- Índices de tabela `t_ingrediente`
--
ALTER TABLE `t_ingrediente`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `t_itempedido`
--
ALTER TABLE `t_itempedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `T_Pedido_id` (`t_pedido_id`),
  ADD KEY `T_Produto_id` (`t_produto_id`);

--
-- Índices de tabela `t_itempedidoopcaoadicional`
--
ALTER TABLE `t_itempedidoopcaoadicional`
  ADD PRIMARY KEY (`id`),
  ADD KEY `T_ItemPedido_id` (`t_itemPedido_id`),
  ADD KEY `T_OpcaoAdicional_id` (`t_opcaoAdicional_id`);

--
-- Índices de tabela `t_opcaoadicional`
--
ALTER TABLE `t_opcaoadicional`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `t_pagamento`
--
ALTER TABLE `t_pagamento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_t_pagamento_t_pedido1_idx` (`t_pedido_id1`);

--
-- Índices de tabela `t_pedido`
--
ALTER TABLE `t_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `T_Cliente_id` (`t_cliente_id`);

--
-- Índices de tabela `t_perfil`
--
ALTER TABLE `t_perfil`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `t_personalizacaoprodutoingrediente`
--
ALTER TABLE `t_personalizacaoprodutoingrediente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_personalizacaoProdutoIngrediente_produto_idx` (`t_produto_id`),
  ADD KEY `fk_personalizacaoProdutoIngrediente_Ingrediente_idx` (`t_ingrediente_id`);

--
-- Índices de tabela `t_produto`
--
ALTER TABLE `t_produto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_produto_funcionario_idx` (`t_funcionario_id`),
  ADD KEY `fk_t_categoria` (`t_categoria_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `t_categoria`
--
ALTER TABLE `t_categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `t_cliente`
--
ALTER TABLE `t_cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

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
-- AUTO_INCREMENT de tabela `t_ingrediente`
--
ALTER TABLE `t_ingrediente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `t_itempedido`
--
ALTER TABLE `t_itempedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `t_itempedidoopcaoadicional`
--
ALTER TABLE `t_itempedidoopcaoadicional`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `t_opcaoadicional`
--
ALTER TABLE `t_opcaoadicional`
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
-- AUTO_INCREMENT de tabela `t_personalizacaoprodutoingrediente`
--
ALTER TABLE `t_personalizacaoprodutoingrediente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `t_produto`
--
ALTER TABLE `t_produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

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
  ADD CONSTRAINT `fk_t_alergia_t_cliente1` FOREIGN KEY (`t_cliente_id1`) REFERENCES `t_cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `t_endereco`
--
ALTER TABLE `t_endereco`
  ADD CONSTRAINT `fk_endereco_cliente` FOREIGN KEY (`t_cliente_id`) REFERENCES `t_cliente` (`id`) ON UPDATE NO ACTION;

--
-- Restrições para tabelas `t_funcionario`
--
ALTER TABLE `t_funcionario`
  ADD CONSTRAINT `fk_t_funcionario_t_perfil1` FOREIGN KEY (`t_perfil_id`) REFERENCES `t_perfil` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `t_itempedido`
--
ALTER TABLE `t_itempedido`
  ADD CONSTRAINT `fk_itemPedido_pedido` FOREIGN KEY (`t_pedido_id`) REFERENCES `t_pedido` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_itemPedido_produto` FOREIGN KEY (`t_produto_id`) REFERENCES `t_produto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `t_itempedidoopcaoadicional`
--
ALTER TABLE `t_itempedidoopcaoadicional`
  ADD CONSTRAINT `fk_ItemPedidoOpcaoAdicional_itemPedido` FOREIGN KEY (`t_itemPedido_id`) REFERENCES `t_itempedido` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ItemPedidoOpcaoAdicional_opcaoAdicional` FOREIGN KEY (`t_opcaoAdicional_id`) REFERENCES `t_opcaoadicional` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `t_pagamento`
--
ALTER TABLE `t_pagamento`
  ADD CONSTRAINT `fk_t_pagamento_t_pedido1` FOREIGN KEY (`t_pedido_id1`) REFERENCES `t_pedido` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `t_pedido`
--
ALTER TABLE `t_pedido`
  ADD CONSTRAINT `fk_pedido_cliente` FOREIGN KEY (`t_cliente_id`) REFERENCES `t_cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `t_personalizacaoprodutoingrediente`
--
ALTER TABLE `t_personalizacaoprodutoingrediente`
  ADD CONSTRAINT `fk_personalizacaoProdutoIngrediente_Ingrediente` FOREIGN KEY (`t_ingrediente_id`) REFERENCES `t_ingrediente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_personalizacaoProdutoIngrediente_produto` FOREIGN KEY (`t_produto_id`) REFERENCES `t_produto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `t_produto`
--
ALTER TABLE `t_produto`
  ADD CONSTRAINT `fk_produto_funcionario` FOREIGN KEY (`t_funcionario_id`) REFERENCES `t_funcionario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_t_categoria` FOREIGN KEY (`t_categoria_id`) REFERENCES `t_categoria` (`id`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `t_promocao`
--
ALTER TABLE `t_promocao`
  ADD CONSTRAINT `fk_promocao_produto` FOREIGN KEY (`t_produto_id`) REFERENCES `t_produto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
