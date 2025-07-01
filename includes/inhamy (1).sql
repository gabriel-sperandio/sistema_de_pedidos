-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 01/07/2025 às 16:34
-- Versão do servidor: 8.0.42
-- Versão do PHP: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `inhamy`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `avaliacoes`
--

CREATE TABLE `avaliacoes` (
  `id` int NOT NULL,
  `prato_id` int NOT NULL,
  `usuario_id` int NOT NULL,
  `nota` tinyint(1) NOT NULL,
  `comentario` text,
  `data_avaliacao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens_pedido`
--

CREATE TABLE `itens_pedido` (
  `id` int NOT NULL,
  `pedido_id` int NOT NULL COMMENT 'ID do pedido relacionado',
  `prato_id` int NOT NULL COMMENT 'ID do prato pedido',
  `quantidade` int NOT NULL DEFAULT '1',
  `preco_unitario` decimal(10,2) NOT NULL COMMENT 'Preço no momento do pedido (para histórico)',
  `observacoes` varchar(255) DEFAULT NULL COMMENT 'Observações específicas para este item'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `itens_pedido`
--

INSERT INTO `itens_pedido` (`id`, `pedido_id`, `prato_id`, `quantidade`, `preco_unitario`, `observacoes`) VALUES
(1, 1, 11, 1, 112.00, ''),
(2, 4, 11, 1, 112.00, ''),
(3, 4, 7, 1, 19.90, ''),
(4, 5, 11, 1, 112.00, '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int NOT NULL,
  `usuario_id` int NOT NULL COMMENT 'ID do cliente que fez o pedido',
  `data_pedido` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Data e hora em que o pedido foi realizado',
  `status` varchar(20) NOT NULL DEFAULT 'pendente' COMMENT 'pendente, preparando, pronto, entregue, cancelado',
  `total` decimal(10,2) NOT NULL COMMENT 'Valor total do pedido',
  `observacoes` text COMMENT 'Observações do cliente sobre o pedido',
  `forma_pagamento` varchar(50) DEFAULT NULL COMMENT 'cartao, dinheiro, pix, etc',
  `endereco_entrega` varchar(255) DEFAULT NULL COMMENT 'Para pedidos de delivery'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `pedidos`
--

INSERT INTO `pedidos` (`id`, `usuario_id`, `data_pedido`, `status`, `total`, `observacoes`, `forma_pagamento`, `endereco_entrega`) VALUES
(1, 6, '2025-06-30 18:32:05', 'pronto', 112.00, 'quero sem um A', 'dinheiro', 'Aqui em casa'),
(4, 6, '2025-06-30 18:59:02', 'cancelado', 131.90, 'Muito molho', 'cartao', 'La na rua'),
(5, 4, '2025-07-01 00:19:21', 'cancelado', 112.00, 'to fora', 'pix', 'Aqui em casa');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pratos`
--

CREATE TABLE `pratos` (
  `id` int NOT NULL,
  `nome` varchar(100) NOT NULL,
  `ingredientes` text NOT NULL,
  `tempo_preparo` int NOT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `favorito` tinyint(1) DEFAULT '0' COMMENT '1=sim, 0=não',
  `preco` decimal(10,2) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL COMMENT 'caminho da imagem',
  `ativo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `pratos`
--

INSERT INTO `pratos` (`id`, `nome`, `ingredientes`, `tempo_preparo`, `categoria`, `favorito`, `preco`, `imagem`, `ativo`) VALUES
(7, 'yese', 'Ingrediente A, B', 30, 'principal', 0, 19.90, 'default.jpg', 1),
(8, 'Prato de Testado', 'Arroz, feijão, bife', 1, 'principal', 1, 25.99, 'default.jpg', 1),
(11, 'olaa', 'o. la', 1, 'principal', 1, 112.00, '6862ed7709318_Captura de tela 2025-06-24 150022.png', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL COMMENT 'Hash bcrypt',
  `is_admin` tinyint(1) DEFAULT '0' COMMENT '1=admin, 0=comum',
  `data_cadastro` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `is_admin`, `data_cadastro`) VALUES
(4, 'admin', 'admin@exemplo.com', 'tofu25', 1, '2025-06-30 14:18:16'),
(5, 'Administrador', 'admin@inhamy.com', '123456', 1, '2025-06-30 14:28:20'),
(6, 'gabriel', 'gab@ex.com', 'gabb', 0, '2025-06-30 14:49:44');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_avaliacao_prato` (`prato_id`),
  ADD KEY `fk_avaliacao_usuario` (`usuario_id`);

--
-- Índices de tabela `itens_pedido`
--
ALTER TABLE `itens_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`),
  ADD KEY `prato_id` (`prato_id`);

--
-- Índices de tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `pratos`
--
ALTER TABLE `pratos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome_UNIQUE` (`nome`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `itens_pedido`
--
ALTER TABLE `itens_pedido`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `pratos`
--
ALTER TABLE `pratos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD CONSTRAINT `fk_avaliacao_prato` FOREIGN KEY (`prato_id`) REFERENCES `pratos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_avaliacao_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `itens_pedido`
--
ALTER TABLE `itens_pedido`
  ADD CONSTRAINT `itens_pedido_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `itens_pedido_ibfk_2` FOREIGN KEY (`prato_id`) REFERENCES `pratos` (`id`);

--
-- Restrições para tabelas `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
