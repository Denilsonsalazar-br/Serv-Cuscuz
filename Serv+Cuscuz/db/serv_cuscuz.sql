-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 19/10/2024 às 22:59
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
  `T_Cliente_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `t_cliente`
--

CREATE TABLE `t_cliente` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `sobrenome` varchar(100) DEFAULT NULL,
  `cpf` varchar(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_atualizacao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `senha` varchar(255) DEFAULT NULL,
  `T_Endereco_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `t_cliente`
--

INSERT INTO `t_cliente` (`id`, `nome`, `sobrenome`, `cpf`, `email`, `telefone`, `data_criacao`, `data_atualizacao`, `senha`, `T_Endereco_id`) VALUES
(1, 'teste', 'Silva', '12345678978', 'teste@gmail.com', '99999-9999', '2024-10-18 15:14:55', '2024-10-19 19:21:33', '$2b$12$8KS1blsOQMi3uLw/ykDcwOYwf.XronZKqZhtAQ4jPgDNWwSUGJHx2', 1),
(2, 'denilson', 'salazar', '05398531271', 'sales@gmail.com', '12345678973', '2024-10-19 20:25:36', '2024-10-19 20:25:36', '$2y$10$AU0Yb.Ku04DNmj1CiDaEs.cdnRkEY.589GJa1B8EOkE.lMYXdwu7.', NULL),
(4, 'denilson', 'salazar', '11111111111', 'sales1@gmail.com', '12345678973', '2024-10-19 20:27:28', '2024-10-19 20:27:28', '$2y$10$Lq474rMmyd9YY6Ok93iYZOzm2Iv30Y9LitYZKHxkobuGeRwEEnh5O', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `t_endereco`
--

CREATE TABLE `t_endereco` (
  `id` int(11) NOT NULL,
  `rua` varchar(100) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `complemento` varchar(50) DEFAULT NULL,
  `bairro` varchar(50) DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `estado` char(2) DEFAULT NULL,
  `cep` varchar(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `t_endereco`
--

INSERT INTO `t_endereco` (`id`, `rua`, `numero`, `complemento`, `bairro`, `cidade`, `estado`, `cep`) VALUES
(1, 'Rua Exemplo', 123, 'Apt 45', 'Centro', 'Cidade Exemplo', 'Es', '12345-678');

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
  `senha` varchar(255) DEFAULT NULL,
  `T_Perfil_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `t_funcionario`
--

INSERT INTO `t_funcionario` (`id`, `nome`, `cpf`, `email`, `telefone`, `data_criacao`, `senha`, `T_Perfil_id`) VALUES
(1, 'Denilson\r\n', '12345678900', 'admin@gmail.com', '12345678900', NULL, '$2b$12$eJ1doeIKzH9trAmeTh/Yue5LngvEFz5I4HPmIqCoLwFKFIOnYc5CW', 1),
(27, 'denilson', '065423197804', 'funcionario@gmail.com', '12345678976', '2024-10-19', '$2y$10$TtFu3lI3zT5bX9kIA/d0Z.5.opN1gkSCmriAtXcq9I70crhC2ROgK', 2),
(28, 'Administrador', '11111111112', 'administrador@gmail.com', '12345678978', '2024-10-19', '$2y$10$wOcJ2sJnt0u06j3CDBu0Iur/guqaFYbvPYsEl3CR1avH.KCAOg/7i', 1);

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
  `T_Pedido_id` int(11) DEFAULT NULL,
  `T_Produto_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `t_itempedidoopcaoadicional`
--

CREATE TABLE `t_itempedidoopcaoadicional` (
  `id` int(11) NOT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `T_ItemPedido_id` int(11) DEFAULT NULL,
  `T_OpcaoAdicional_id` int(11) DEFAULT NULL
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
  `T_Pedido_id` int(11) DEFAULT NULL
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
  `T_Cliente_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `t_perfil`
--

CREATE TABLE `t_perfil` (
  `id` int(11) NOT NULL,
  `tipo_perfil` enum('CLIENTE','FUNCIONARIO','ADMINISTRADOR') DEFAULT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `t_perfil`
--

INSERT INTO `t_perfil` (`id`, `tipo_perfil`, `descricao`) VALUES
(1, 'ADMINISTRADOR', 'Perfil com acesso a funcionalidades administrativas.'),
(2, 'FUNCIONARIO', 'Perfil de Funcionário');

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
  `T_Produto_id` int(11) DEFAULT NULL,
  `T_Ingrediente_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `t_produto`
--

CREATE TABLE `t_produto` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `estoque` int(11) DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL,
  `personalizavel` tinyint(1) DEFAULT NULL,
  `tipo_personalizacao` varchar(50) DEFAULT NULL,
  `descricao_personalizacao` text DEFAULT NULL,
  `unidade_medida` varchar(50) DEFAULT NULL,
  `disponivel` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `T_Produto_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `t_alergia`
--
ALTER TABLE `t_alergia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `T_Cliente_id` (`T_Cliente_id`);

--
-- Índices de tabela `t_cliente`
--
ALTER TABLE `t_cliente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD UNIQUE KEY `cpf_2` (`cpf`),
  ADD KEY `T_Endereco_id` (`T_Endereco_id`);

--
-- Índices de tabela `t_endereco`
--
ALTER TABLE `t_endereco`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `t_funcionario`
--
ALTER TABLE `t_funcionario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD KEY `T_Perfil_id` (`T_Perfil_id`);

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
  ADD KEY `T_Pedido_id` (`T_Pedido_id`),
  ADD KEY `T_Produto_id` (`T_Produto_id`);

--
-- Índices de tabela `t_itempedidoopcaoadicional`
--
ALTER TABLE `t_itempedidoopcaoadicional`
  ADD PRIMARY KEY (`id`),
  ADD KEY `T_ItemPedido_id` (`T_ItemPedido_id`),
  ADD KEY `T_OpcaoAdicional_id` (`T_OpcaoAdicional_id`);

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
  ADD KEY `T_Pedido_id` (`T_Pedido_id`);

--
-- Índices de tabela `t_pedido`
--
ALTER TABLE `t_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `T_Cliente_id` (`T_Cliente_id`);

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
  ADD KEY `T_Ingrediente_id` (`T_Ingrediente_id`),
  ADD KEY `T_Produto_id` (`T_Produto_id`);

--
-- Índices de tabela `t_produto`
--
ALTER TABLE `t_produto`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `t_promocao`
--
ALTER TABLE `t_promocao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `T_Produto_id` (`T_Produto_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `t_alergia`
--
ALTER TABLE `t_alergia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `t_cliente`
--
ALTER TABLE `t_cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `t_endereco`
--
ALTER TABLE `t_endereco`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `t_funcionario`
--
ALTER TABLE `t_funcionario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `t_produto`
--
ALTER TABLE `t_produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  ADD CONSTRAINT `t_alergia_ibfk_1` FOREIGN KEY (`T_Cliente_id`) REFERENCES `t_cliente` (`id`);

--
-- Restrições para tabelas `t_personalizacaoprodutoingrediente`
--
ALTER TABLE `t_personalizacaoprodutoingrediente`
  ADD CONSTRAINT `t_personalizacaoprodutoingrediente_ibfk_1` FOREIGN KEY (`T_Ingrediente_id`) REFERENCES `t_ingrediente` (`id`),
  ADD CONSTRAINT `t_personalizacaoprodutoingrediente_ibfk_2` FOREIGN KEY (`T_Produto_id`) REFERENCES `t_produto` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
