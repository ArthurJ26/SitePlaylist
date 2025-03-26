-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 19/11/2024 às 04:23
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
-- Banco de dados: `cadastro-site`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `email` varchar(60) NOT NULL,
  `senha` varchar(45) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `senha`, `nome`, `is_admin`) VALUES
(2, 'amigo1@gmail.com', '123456', 'amigo', 1),
(5, 'teste123@gmail.com', 'alo1234', 'teste123', 0),
(9, 'ab@gmail.com', '123456', 'abigalinde', 0),
(10, 'paulogao12@gmail.com', '123456', 'paulo', 0),
(11, '12345@gmail.com', '1234567', 'ultimoteste', 0),
(14, 'boliche2@gmail.com', '123456', 'boliche', 0),
(15, 'games123@gmail.com', '1123456', 'boladao', 1),
(16, 'leandor@gmail.com', '123456', 'leonardoadm', 1),
(17, 'dia17@gmail.com', '123456', '17boladao', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `videos`
--

CREATE TABLE `videos` (
  `id` int(11) NOT NULL,
  `video_url` varchar(255) NOT NULL,
  `thumbnail_url` varchar(255) NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `videos`
--

INSERT INTO `videos` (`id`, `video_url`, `thumbnail_url`, `usuario_id`) VALUES
(1, 'https://www.youtube.com/watch?v=_wPTPK3ZXFI', 'https://img.youtube.com/vi/_wPTPK3ZXFI/maxresdefault.jpg', 0),
(30, 'https://www.youtube.com/watch?v=bsAAfbtzZ1I', 'https://img.youtube.com/vi/bsAAfbtzZ1I/maxresdefault.jpg', 10),
(43, 'https://www.youtube.com/watch?v=WkTkZxdEWe8', 'https://img.youtube.com/vi/WkTkZxdEWe8/maxresdefault.jpg', 2),
(52, 'https://www.youtube.com/watch?v=RwxEKiO4Ccs', 'https://img.youtube.com/vi/RwxEKiO4Ccs/maxresdefault.jpg', 2),
(55, 'https://www.youtube.com/watch?v=f1wwS2iMtgk', 'https://img.youtube.com/vi/f1wwS2iMtgk/maxresdefault.jpg', 2),
(63, 'https://www.youtube.com/watch?v=XmmtizLpw4c', 'https://img.youtube.com/vi/XmmtizLpw4c/maxresdefault.jpg', 17),
(72, 'https://www.youtube.com/watch?v=tFq2xWOLYn4', 'https://img.youtube.com/vi/tFq2xWOLYn4/maxresdefault.jpg', 9),
(73, 'https://www.youtube.com/watch?v=cylWzi40SSo', 'https://img.youtube.com/vi/cylWzi40SSo/maxresdefault.jpg', 9);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
