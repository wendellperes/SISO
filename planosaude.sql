-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 16-Mar-2020 às 15:18
-- Versão do servidor: 10.1.22-MariaDB
-- PHP Version: 7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `planosaude`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `anamnese`
--

CREATE TABLE `anamnese` (
  `cod` int(11) NOT NULL primary key auto_increment,
  `cod_usu` int(11) NOT NULL,
  `dentista_antes` varchar(5) NOT NULL,
  `reacao_anestesia` varchar(50) NOT NULL,
  `como` varchar(50) NOT NULL,
  `alergia_medicamento` varchar(50) NOT NULL,
  `qual` varchar(100) NOT NULL,
  `outras_alergias` varchar(100) NOT NULL,
  `doencas` varchar(100) NOT NULL,
  `outra_doenca` varchar(100) NOT NULL,
  `doenca_familia` varchar(100) NOT NULL,
  `medicamento` varchar(100) NOT NULL,
  `data` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoriaserfin`
--

CREATE TABLE `categoriaserfin` (
  `cod` int(11) NOT NULL primary key auto_increment,
  `nome` varchar(60) NOT NULL,
  `img` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `categoriaserfin`
--

INSERT INTO `categoriaserfin` (`cod`, `nome`, `img`) VALUES
(1, 'UMA NOVA CATEGORIA', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `dentes`
--

CREATE TABLE `dentes` (
  `cod` int(11) NOT NULL primary key auto_increment,
  `nome` varchar(10) NOT NULL,
  `descricao` varchar(100) NOT NULL,
  `quadrante` int(11) NOT NULL,
  `imagem` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `dentes`
--

INSERT INTO `dentes` (`cod`, `nome`, `descricao`, `quadrante`, `imagem`) VALUES
(1, '01 ', 'INCISIVO CENTRAL SUPERIOR DIREITO(11)', 1, '795c17a39126a6ce1258e26eff5b4bee.png'),
(2, '02', 'INCISIVO CENTRAL LATERAL DIREITO(12)', 1, 'e322a5c062712c99cabf729bb742a65b.png'),
(3, '03', 'CANINO SUPERIOR DIREITO(13)', 1, '52baf7c8692f88d879b8f53005c407cf.png'),
(4, '04', 'PRIMEIRO PRÉ-MOLAR SUPERIOR DIREITO(14) ', 1, '6d99e304d35ae5e68c800320fbb8d588.png'),
(5, '05', 'SEGUNDO PRÉ-MOLAR SUPERIOR DIREITO(15)', 1, '6d7885cec9a63dac567755b526bf3e5f.png'),
(6, '06', 'PRIMEIRO MOLAR SUPERIOR DIREITO(16) ', 1, 'ac1d41af04c8c67c26b0844a68bcf12e.png'),
(7, '07', 'SEGUNDO MOLAR SUPERIOR DIREITO(17)', 1, 'd08ca128771b444cf7ea1a9692536526.png'),
(8, '08', 'TERCEIRO MOLAR SUPERIOR DIREITO(18)', 1, '114c33b43425b5c8fdb1d1ec6f93e1be.png'),
(9, '09', 'INCISIVO CENTRAL SUPERIOR ESQUERDO(21)', 2, '1d878895dc45f3e8adc384aec934eb1a.png'),
(10, '10', 'INCISIVO LATERAL SUPERIOR ESQUERDO(22)', 2, '4898dee8c716005e59563fbba1e4504d.png'),
(11, '11', 'CANINO SUPERIOR ESQUERDO(23)', 2, '5a5c4ecc086e5cd1fb1885e37564bc41.png'),
(12, '12', 'PRIMEIRO PRÉ-MOLAR SUPERIOR ESQUERDO(24)', 2, 'f9b175a26f9893f3efd6e91dbff4449a.png'),
(13, '13', 'SEGUNDO PRÉ-MOLAR SUPERIOR ESQUERDO(25)', 2, '999f23f7b85e6e958d06f71f5f81923a.png'),
(14, '14', 'PRIMEIRO MOLAR SUPERIOR ESQUERDO(26)', 2, '453d8f7f209b9f93393104342b2d9134.png'),
(15, '15', 'SEGUNDO MOLAR SUPERIOR ESQUERDO(27)', 2, 'f8811667171b994b3bdc4297e8de9d75.png'),
(16, '16', 'TERCEIRO MOLAR SUPERIOR ESQUERDO(28)', 2, '90303321da8666309fd11c801d5a3a8b.png'),
(17, '17', 'INCISIVO CENTRAL INFERIOR DIREITO(41)', 3, 'b2cba50294b7ebd5d967ec30f51977a5.png'),
(18, '18', 'INCISIVO LATERAL SUPERIOR DIREITO(42)', 3, '32955fa49b7738076296f482678bd9e6.png'),
(19, '19', 'CANINO INFERIOR DIREITO(43)', 3, '750d1481d1cf850b0c6469642e45020b.png'),
(20, '20', 'PRIMEIRO PRÉ-MOLAR INFERIOR DIREITO(44)', 3, 'bca46277222413099465df2c26127830.png'),
(21, '21', 'SEGUNDO PRÉ-MOLAR INFERIOR DIREITO(45)', 3, '966b8dc5d26aaad6b4f15d72e62ccf8d.png'),
(22, '22', 'PRIMEIRO MOLAR INFERIOR DIREITO(46)', 3, '280156e207afcdaa46e84820cfda57e0.png'),
(23, '23', 'SEGUNDO MOLAR INFERIOR DIREITO(47)', 3, '1288367958f0848f07063d5242e88e9b.png'),
(24, '24', 'TERCEIRO MOLAR INFERIOR DIREITO(48)', 3, '8a2c639d60e3334b3904a53582bd2888.png'),
(25, '25', 'INCISIVO CENTRAL INFERIOR ESQUERDO(31)', 4, '8cc057909f594fbdf2328b36c064deeb.png'),
(26, '26', 'INCISIVO LATERAL INFERIOR ESQUERDO(32)', 4, 'bba4af9b511c0250e36913342fbcda28.png'),
(27, '27', 'CANINO INFERIOR ESQUERDO(33)', 4, 'e0c0c9bc435123e306a1d5cda67a9efb.png'),
(28, '28', 'PRIMEIRO PRÉ-MOLAR INFERIOR ESQUERDO(34)', 4, '3a0b7d054a56df61bf1d48a18c73db27.png'),
(29, '29', 'SEGUNDO PRÉ-MOLAR INFERIOR ESQUERDO(35)', 4, 'bc6d97c3886061e533308ac923aa75b2.png'),
(30, '30', 'PRIMEIRO MOLAR INFERIOR ESQUERDO(36)', 4, '7e2743e9f296e8258d007769b6ba215c.png'),
(31, '31', 'SEGUNDO MOLAR INFERIOR ESQUERDO(37)', 4, 'c60a17eca78f88c86ea25e912a3ab005.png'),
(32, '32', 'TERCEIRO MOLAR INFERIOR ESQUERDO(38)', 4, '67e3d54450da18806880a8acd0b7cd02.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `eventos`
--

CREATE TABLE `eventos` (
  `id` int(10) UNSIGNED NOT NULL primary key auto_increment,
  `title` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `endereco` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `bairro` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `complemento` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `telefone` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `body` text COLLATE utf8_spanish_ci NOT NULL,
  `url` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `class` varchar(45) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'event-important',
  `start` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `end` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `inicio_normal` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `final_normal` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `paciente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `financeiro_pac`
--

CREATE TABLE `financeiro_pac` (
  `cod` int(11) NOT NULL primary key auto_increment,
  `cod_orcamento` int(11) NOT NULL,
  `tipo` int(11) NOT NULL,
  `subtotal` varchar(20) NOT NULL,
  `total` varchar(20) NOT NULL,
  `descricao` varchar(100) NOT NULL,
  `numparcelas` int(11) DEFAULT NULL,
  `tipopag` varchar(20) NOT NULL,
  `categoria` int(11) NOT NULL,
  `dia` int(11) NOT NULL,
  `mes` int(11) NOT NULL,
  `ano` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `financeiro_sorrident`
--

CREATE TABLE `financeiro_sorrident` (
  `id` int(11) NOT NULL primary key auto_increment,
  `tipo` int(11) DEFAULT NULL,
  `dia` int(11) DEFAULT NULL,
  `mes` int(11) DEFAULT NULL,
  `ano` int(11) DEFAULT NULL,
  `cat` int(11) DEFAULT NULL,
  `descricao` longtext,
  `valor` float DEFAULT NULL,
  `cod_usu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `lc_cat`
--

CREATE TABLE `lc_cat` (
  `id` int(11) NOT NULL primary key auto_increment,
  `nome` varchar(255) DEFAULT NULL,
  `cod_usu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `lc_cat`
--

INSERT INTO `lc_cat` (`id`, `nome`, `cod_usu`) VALUES
(1, 'DESPESAS DIÁRIAS', 1),
(2, 'FUNCIONÁRIOS', 0),
(3, 'DESPESAS MENSAIS\r\n', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `listaespera`
--

CREATE TABLE `listaespera` (
  `cod` int(11) NOT NULL primary key auto_increment,
  `cod_paciente` int(11) NOT NULL,
  `data` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `orcamento`
--

CREATE TABLE `orcamento` (
  `cod` int(11) NOT NULL primary key auto_increment,
  `status` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `dia` int(11) NOT NULL,
  `mes` int(11) NOT NULL,
  `ano` int(11) NOT NULL,
  `func` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `paciente`
--

CREATE TABLE `paciente` (
  `id` int(11) NOT NULL primary key auto_increment,
  `nome` varchar(60) NOT NULL,
  `nascimento` varchar(20) NOT NULL,
  `rg` varchar(20) NOT NULL,
  `cpf` varchar(20) NOT NULL,
  `endereco` varchar(100) NOT NULL,
  `numero` varchar(10) NOT NULL,
  `complemento` varchar(60) DEFAULT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `residencial` varchar(20) DEFAULT NULL,
  `responsavel` varchar(60) DEFAULT NULL,
  `indicacao` varchar(200) DEFAULT NULL,
  `data` varchar(20) NOT NULL,
  `ultimovisita` varchar(30) NOT NULL,
  `status` varchar(2) NOT NULL,
  `dr` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pag_par_pro`
--

CREATE TABLE `pag_par_pro` (
  `cod` int(11) NOT NULL primary key auto_increment,
  `descricao` varchar(60) NOT NULL,
  `valor` varchar(20) NOT NULL,
  `financeiro_pac` int(11) NOT NULL,
  `tipopag` varchar(20) NOT NULL,
  `dia` int(11) NOT NULL,
  `mes` int(11) NOT NULL,
  `ano` int(11) NOT NULL,
  `esp_proc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `procedimentos`
--

CREATE TABLE `procedimentos` (
  `cod` int(11) NOT NULL primary key auto_increment,
  `dente` int(11) NOT NULL,
  `servico` int(11) NOT NULL,
  `usuario` int(10) NOT NULL,
  `valor` varchar(20) NOT NULL,
  `status` int(20) NOT NULL,
  `nivel` varchar(11) NOT NULL,
  `obs` varchar(100) DEFAULT NULL,
  `tipo` int(11) NOT NULL,
  `dia` int(11) NOT NULL,
  `mes` int(11) NOT NULL,
  `ano` int(11) NOT NULL,
  `categoria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `servicos`
--

CREATE TABLE `servicos` (
  `cod` int(11) NOT NULL primary key auto_increment,
  `nome` varchar(60) ,
  `descricao` varchar(100),
  `categoria` int(11) NOT NULL,
  `valor` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `servicos`
--

INSERT INTO `servicos` (`cod`, `nome`, `descricao`, `categoria`, `valor`) VALUES
(1, 'UM NOVO SERVIÇO', 'UM NOVO SERVIÇO', 1, '1000');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `cod` int(11) NOT NULL primary key auto_increment,
  `nome` varchar(60) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `rg` varchar(20) NOT NULL,
  `cpf` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `permissao` int(11) NOT NULL,
  `rua` varchar(40) NOT NULL,
  `bairro` varchar(40) NOT NULL,
  `numero` varchar(10) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `senha` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`cod`, `nome`, `usuario`, `rg`, `cpf`, `email`, `foto`, `permissao`, `rua`, `bairro`, `numero`, `celular`, `senha`) VALUES
(6, 'LUCAS GABRIEL DA SILVA LIMA', 'elanddji', '2420850-7', '021.057.712-62', 'elanddji@icloud.com', 'b9387bc8dfc489c6f4fc7c538ba21c9f.png', 1, 'RUA VIEIRA MARTINS', ' ruaviera martins', '659', '97-981186852', 'f5bb0c8de146c67b44babbf4e6584cc0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anamnese`
--
ALTER TABLE `anamnese`
  ADD PRIMARY KEY (`cod`);

--
-- Indexes for table `categoriaserfin`
--
ALTER TABLE `categoriaserfin`
  ADD PRIMARY KEY (`cod`);

--
-- Indexes for table `dentes`
--
ALTER TABLE `dentes`
  ADD PRIMARY KEY (`cod`);

--
-- Indexes for table `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `financeiro_pac`
--
ALTER TABLE `financeiro_pac`
  ADD PRIMARY KEY (`cod`);

--
-- Indexes for table `financeiro_sorrident`
--
ALTER TABLE `financeiro_sorrident`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lc_cat`
--
ALTER TABLE `lc_cat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `listaespera`
--
ALTER TABLE `listaespera`
  ADD PRIMARY KEY (`cod`);

--
-- Indexes for table `orcamento`
--
ALTER TABLE `orcamento`
  ADD PRIMARY KEY (`cod`);

--
-- Indexes for table `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pag_par_pro`
--
ALTER TABLE `pag_par_pro`
  ADD PRIMARY KEY (`cod`);

--
-- Indexes for table `procedimentos`
--
ALTER TABLE `procedimentos`
  ADD PRIMARY KEY (`cod`);

--
-- Indexes for table `servicos`
--
ALTER TABLE `servicos`
  ADD PRIMARY KEY (`cod`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`cod`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anamnese`
--
ALTER TABLE `anamnese`
  MODIFY `cod` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `categoriaserfin`
--
ALTER TABLE `categoriaserfin`
  MODIFY `cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `dentes`
--
ALTER TABLE `dentes`
  MODIFY `cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `financeiro_pac`
--
ALTER TABLE `financeiro_pac`
  MODIFY `cod` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `financeiro_sorrident`
--
ALTER TABLE `financeiro_sorrident`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lc_cat`
--
ALTER TABLE `lc_cat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `listaespera`
--
ALTER TABLE `listaespera`
  MODIFY `cod` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `orcamento`
--
ALTER TABLE `orcamento`
  MODIFY `cod` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `paciente`
--
ALTER TABLE `paciente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pag_par_pro`
--
ALTER TABLE `pag_par_pro`
  MODIFY `cod` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `procedimentos`
--
ALTER TABLE `procedimentos`
  MODIFY `cod` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `servicos`
--
ALTER TABLE `servicos`
  MODIFY `cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
