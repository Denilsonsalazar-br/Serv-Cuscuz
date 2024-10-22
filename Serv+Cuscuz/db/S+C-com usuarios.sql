-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 22/10/2024 às 17:57
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
(0, 'denilson', 'salazar', '12345678978', 'denilson@gmail.com', '12345678973', '2024-10-22 15:25:28', '2024-10-22 15:25:28', '$2y$10$owLMFWaYGckvgf4FOeVqXezLx8EPRAp6fTORyHr69jEHGNI8dIkha');

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
  `data_criacao` date DEFAULT NULL,
  `senha` varchar(60) DEFAULT NULL,
  `t_perfil_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `t_funcionario`
--

INSERT INTO `t_funcionario` (`id`, `nome`, `cpf`, `email`, `telefone`, `data_criacao`, `senha`, `t_perfil_id`) VALUES
(0, 'Funcionario', '12345678912', 'funcionario@gmail.com', '12345678912', NULL, '$2y$10$pPizy0yB1q1e8WzvNgBA5.9aNgzw4aBYL72GApAbgGixPIGg.pkbW', 2),
(1, 'Administrador', '01234567891', 'administrador@gmail.com', '01234567890', NULL, '$2y$10$wOcJ2sJnt0u06j3CDBu0Iur/guqaFYbvPYsEl3CR1avH.KCAOg/7i', 1);

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
  `nome` varchar(100) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `imagem` longblob DEFAULT NULL,
  `estoque` int(11) DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL,
  `personalizavel` tinyint(1) DEFAULT NULL,
  `tipo_personalizacao` varchar(50) DEFAULT NULL,
  `descricao_personalizacao` text DEFAULT NULL,
  `unidade_medida` varchar(50) DEFAULT NULL,
  `disponivel` tinyint(1) DEFAULT NULL,
  `t_funcionario_id` int(11) DEFAULT NULL
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
  ADD KEY `fk_produto_funcionario_idx` (`t_funcionario_id`);

--
-- Índices de tabela `t_promocao`
--
ALTER TABLE `t_promocao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `T_Produto_id` (`t_produto_id`);

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
  ADD CONSTRAINT `fk_produto_funcionario` FOREIGN KEY (`t_funcionario_id`) REFERENCES `t_funcionario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `t_promocao`
--
ALTER TABLE `t_promocao`
  ADD CONSTRAINT `fk_promocao_produto` FOREIGN KEY (`t_produto_id`) REFERENCES `t_produto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
