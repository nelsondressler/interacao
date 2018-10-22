-- phpMyAdmin SQL Dump
-- version 4.0.10.12
-- http://www.phpmyadmin.net
--
-- Máquina: 186.202.152.93
-- Data de Criação: 22-Out-2018 às 13:32
-- Versão do servidor: 5.1.73-rel14.11-log
-- versão do PHP: 5.6.30-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `lubavitch1`
--
USE `lubavitch1`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `administracao_usuarios`
--

CREATE TABLE IF NOT EXISTS `administracao_usuarios` (
  `cod_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) NOT NULL DEFAULT '',
  `senha` varchar(100) NOT NULL DEFAULT '',
  `nome` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`cod_usuario`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Extraindo dados da tabela `administracao_usuarios`
--

INSERT INTO `administracao_usuarios` (`cod_usuario`, `login`, `senha`, `nome`, `email`) VALUES
(1, 'admin', '74w2z2y2', 'Administrador', 'moti@lubavitch.org.br'),
(14, 'c.prates', '25o494q4b4m4s2t2r213', 'Prates', 'c.prates@yahoo.com.br');

-- --------------------------------------------------------

--
-- Estrutura da tabela `administracao_usuarios_permissoes`
--

CREATE TABLE IF NOT EXISTS `administracao_usuarios_permissoes` (
  `cod_usuario` int(11) NOT NULL,
  `permissoes_module` varchar(50) DEFAULT NULL,
  `permissoes_acao` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `administracao_usuarios_permissoes`
--

INSERT INTO `administracao_usuarios_permissoes` (`cod_usuario`, `permissoes_module`, `permissoes_acao`) VALUES
(1, 'pag_banner_rodape', 1),
(1, 'pag_banner_home', 4),
(1, 'pag_banner_home', 3),
(1, 'pag_banner_home', 2),
(1, 'pag_banner_home', 1),
(1, 'pag_duvidas', 4),
(1, 'pag_duvidas', 3),
(1, 'pag_duvidas', 2),
(1, 'pag_duvidas', 1),
(1, 'pag_quemsomos', 4),
(1, 'pag_quemsomos', 3),
(1, 'pag_quemsomos', 2),
(1, 'pag_quemsomos', 1),
(1, 'sys_rel_atrasados', 4),
(1, 'sys_rel_atrasados', 3),
(1, 'sys_rel_atrasados', 2),
(1, 'sys_rel_atrasados', 1),
(1, 'sys_rel_apagar', 4),
(1, 'sys_rel_apagar', 3),
(1, 'sys_rel_apagar', 2),
(1, 'sys_rel_apagar', 1),
(1, 'sys_enviar_cobranca', 4),
(1, 'sys_enviar_cobranca', 3),
(1, 'sys_enviar_cobranca', 2),
(1, 'sys_enviar_cobranca', 1),
(1, 'sys_parcelas', 4),
(1, 'sys_parcelas', 3),
(1, 'sys_parcelas', 2),
(1, 'sys_parcelas', 1),
(1, 'sys_clientes', 4),
(1, 'sys_clientes', 3),
(1, 'sys_clientes', 2),
(1, 'sys_clientes', 1),
(1, 'sys_planos', 4),
(1, 'sys_planos', 3),
(1, 'sys_planos', 2),
(1, 'sys_planos', 1),
(1, 'adm_usuarios', 4),
(1, 'adm_usuarios', 3),
(1, 'adm_usuarios', 2),
(1, 'adm_usuarios', 1),
(1, 'adm_configuracao', 4),
(1, 'adm_configuracao', 3),
(1, 'adm_configuracao', 2),
(1, 'adm_configuracao', 1),
(14, 'frm_contato', 4),
(14, 'frm_contato', 3),
(14, 'frm_contato', 2),
(14, 'frm_contato', 1),
(14, 'pag_banner_rodape', 4),
(14, 'pag_banner_rodape', 3),
(14, 'pag_banner_rodape', 1),
(14, 'pag_banner_rodape', 2),
(1, 'pag_banner_rodape', 3),
(1, 'pag_banner_rodape', 4),
(1, 'frm_contato', 1),
(1, 'frm_contato', 2),
(1, 'frm_contato', 3),
(1, 'frm_contato', 4),
(14, 'pag_banner_home', 4),
(14, 'pag_banner_home', 3),
(14, 'pag_banner_home', 2),
(14, 'pag_banner_home', 1),
(14, 'pag_duvidas', 4),
(14, 'pag_duvidas', 3),
(14, 'pag_duvidas', 2),
(14, 'pag_duvidas', 1),
(14, 'pag_quemsomos', 4),
(14, 'pag_quemsomos', 3),
(14, 'pag_quemsomos', 2),
(14, 'pag_quemsomos', 1),
(14, 'sys_rel_atrasados', 4),
(14, 'sys_rel_atrasados', 3),
(14, 'sys_rel_atrasados', 2),
(14, 'sys_rel_atrasados', 1),
(14, 'sys_rel_apagar', 4),
(14, 'sys_rel_apagar', 3),
(14, 'sys_rel_apagar', 2),
(14, 'sys_rel_apagar', 1),
(14, 'sys_assinatura_manual', 4),
(14, 'sys_assinatura_manual', 3),
(14, 'sys_assinatura_manual', 2),
(14, 'sys_assinatura_manual', 1),
(14, 'sys_enviar_cobranca', 4),
(14, 'sys_enviar_cobranca', 3),
(14, 'sys_enviar_cobranca', 2),
(14, 'sys_enviar_cobranca', 1),
(14, 'sys_parcelas', 4),
(14, 'sys_parcelas', 3),
(14, 'sys_parcelas', 2),
(14, 'sys_parcelas', 1),
(14, 'sys_clientes', 4),
(14, 'sys_clientes', 3),
(14, 'sys_clientes', 2),
(14, 'sys_clientes', 1),
(14, 'sys_planos', 4),
(14, 'sys_planos', 3),
(14, 'sys_planos', 2),
(14, 'sys_planos', 1),
(14, 'adm_usuarios', 4),
(14, 'adm_usuarios', 3),
(14, 'adm_usuarios', 2),
(14, 'adm_usuarios', 1),
(14, 'adm_configuracao', 4),
(14, 'adm_configuracao', 3),
(14, 'adm_configuracao', 2),
(14, 'adm_configuracao', 1),
(1, 'sys_assinatura_manual', 1),
(1, 'sys_assinatura_manual', 2),
(1, 'sys_assinatura_manual', 3),
(1, 'sys_assinatura_manual', 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `assinaturas_manuais`
--

CREATE TABLE IF NOT EXISTS `assinaturas_manuais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `email` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `ddd` varchar(10) COLLATE latin1_general_ci DEFAULT NULL,
  `telefone` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  `rua` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `numero` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `complemento` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `bairro` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `cidade` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `estado` varchar(10) COLLATE latin1_general_ci DEFAULT NULL,
  `cep` varchar(10) COLLATE latin1_general_ci DEFAULT NULL,
  `nome_assinatura` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `descricao` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `referencia` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `meses` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=9 ;

--
-- Extraindo dados da tabela `assinaturas_manuais`
--

INSERT INTO `assinaturas_manuais` (`id`, `nome`, `email`, `ddd`, `telefone`, `rua`, `numero`, `complemento`, `bairro`, `cidade`, `estado`, `cep`, `nome_assinatura`, `descricao`, `referencia`, `valor`, `meses`) VALUES
(1, 'Cristiano Pinho Prates', 'c.prates@yahoo.com.br', '41', '33620869', 'Rua Professora Dorotea Spak Choma', '200', '', 'Tarumã', 'Curitiba', 'PR', '82530370', 'Teste de assinatura', 'Este é um teste', '999999-1434562183', 1.00, 12),
(2, 'Vera Philip', 'vera@lubavitch.org.br', '11', '3333-7700', 'Rua Talmud Thorá', '296', '', 'Bom Retiro', 'São Paulo', 'SP', '01126020', 'Vera Philip', '', '-1435673944', 18.00, 12),
(3, 'Silvania Oliveira', 'projetos@lubavitch.org.br', '11', '3333-7700', 'Rua Talmud Thorá', '296', '', 'Bom Retiro', 'São Paulo', 'SP', '01126020', 'Silvania Oliveira', '', '-1435674045', 18.00, 12),
(4, 'Moti Begun', 'moti@lubavitch.org.br', '11', '3333-7700', 'Rua Talmud Thorá', '296', '', 'Bom Retiro', 'São Paulo', 'SP', '01126020', 'Moti Begun', '', '-1435676013', 18.00, 12),
(5, 'Marcel Neuman', 'mn180@hotmail.com', '', '', '', '', '', '', '', '', '', 'Marcel Neuman', 'Renovação 2017', 'marcel neuman 2017-1481111049', 54.00, 12),
(6, 'Reuben Hamoui', 'rhamoui@gmail.com', '11', '976263500', 'Rua Mangabeiras', '135', 'apto 20', 'Santa Cecília', 'São Paulo', 'SP', '01233010', 'Reuben Hamoui', 'Doacao Charidy', 'Parcelamento doacao Charidy-1499436238', 650.00, 10),
(7, 'Sharon Weissman Beting', 'sharon@beting.com.br', '11', '99199-2745', 'Rua Eliseu Visconti', '188', '', 'Paineiras do Morumbi', 'São Paulo', 'SP', '05683010', 'Sharon Weissman Beting', 'Charidy', 'Parcelamento Charidy-1499436417', 72.00, 5),
(8, 'Binho Hamoui', 'rhamoui@gmail.com', '11', '97626-3500', '', '', '', '', '', '', '', 'Binho Hamoui', 'Charidy 2017', 'Doação Charidy 2017-1501074437', 650.00, 10);

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE IF NOT EXISTS `clientes` (
  `cod_cliente` int(10) NOT NULL AUTO_INCREMENT,
  `cod_status` int(10) NOT NULL DEFAULT '0',
  `data_cadastro` date DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `cpf` varchar(12) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(20) DEFAULT NULL,
  `cep` varchar(9) DEFAULT NULL,
  `endereco` varchar(100) DEFAULT NULL,
  `numero` varchar(100) DEFAULT NULL,
  `complemento` varchar(100) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `indicacao` varchar(100) DEFAULT NULL,
  `indicacao_qual` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`cod_cliente`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=95 ;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`cod_cliente`, `cod_status`, `data_cadastro`, `nome`, `cpf`, `telefone`, `celular`, `email`, `senha`, `cep`, `endereco`, `numero`, `complemento`, `estado`, `cidade`, `bairro`, `indicacao`, `indicacao_qual`) VALUES
(83, 1, '2015-01-19', 'Marcos Zeev Begun', '21537996860', '11 3227-7700', '11 99116-1166', 'moti@lubavitch.org.br', 'teste18', '01423-001', 'Rua: José Maria Lisboa', '1060', 'Apt 81', 'SP', 'São Paulo', 'Jardim Paulista', '4', '1975 - 1982'),
(93, 1, '2015-11-13', 'marcel neumann', '05016759812', '36668884', '973101234', 'mn180@hotmail.com', '181055', '01230-010', 'rua brasilio machado', '299', 'apt 20', 'SP', 'sao paulo', 'higienopolis', '1', 'elizebth -'),
(94, 1, '2015-11-16', 'Julio Fainzilber', '00644011890', '11-3361.5951', '11-98147.1800', 'yoel_israel@yahoo.com', 'jf051956', '01126-020', 'Rua: Talmud Thorá', '238', 'ap 72', 'SP', 'São Paulo', 'Bom Retiro', '1', '-'),
(88, 1, '2015-01-26', 'Cristiano Prates', '01234567890', '4133620869', '', 'c.prates@yahoo.com.br', '123456', '82530-370', 'Rua: Professora Dorotea Spak Choma', '200', '', 'PR', 'Curitiba', 'Tarumã', '', '-');

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes_parcelas`
--

CREATE TABLE IF NOT EXISTS `clientes_parcelas` (
  `cod_cli_parcelas` int(10) NOT NULL AUTO_INCREMENT,
  `cod_cli_periodo` int(10) NOT NULL,
  `cod_status` int(11) NOT NULL,
  `data_vencimento` date NOT NULL,
  `data_pagamento` date NOT NULL,
  `num_pedido` varchar(50) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `pagamento` varchar(50) DEFAULT NULL,
  `pagamento_forma` varchar(50) DEFAULT NULL,
  `pagamento_nome` varchar(50) DEFAULT NULL,
  `pagamento_status` varchar(100) DEFAULT NULL,
  `pagamento_cod` varchar(100) DEFAULT NULL,
  `pagamento_id` varchar(100) DEFAULT NULL,
  `pagamento_trans_data` date DEFAULT NULL,
  PRIMARY KEY (`cod_cli_parcelas`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1181 ;

--
-- Extraindo dados da tabela `clientes_parcelas`
--

INSERT INTO `clientes_parcelas` (`cod_cli_parcelas`, `cod_cli_periodo`, `cod_status`, `data_vencimento`, `data_pagamento`, `num_pedido`, `valor`, `pagamento`, `pagamento_forma`, `pagamento_nome`, `pagamento_status`, `pagamento_cod`, `pagamento_id`, `pagamento_trans_data`) VALUES
(1180, 67, 4, '2016-10-16', '0000-00-00', '1180', 54.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1179, 67, 4, '2016-09-16', '0000-00-00', '1179', 54.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1172, 67, 4, '2016-02-16', '0000-00-00', '1172', 54.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1173, 67, 4, '2016-03-16', '0000-00-00', '1173', 54.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1174, 67, 4, '2016-04-16', '0000-00-00', '1174', 54.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1175, 67, 4, '2016-05-16', '0000-00-00', '1175', 54.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1176, 67, 4, '2016-06-16', '0000-00-00', '1176', 54.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1177, 67, 4, '2016-07-16', '0000-00-00', '1177', 54.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1178, 67, 4, '2016-08-16', '0000-00-00', '1178', 54.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1159, 66, 6, '2016-01-13', '2016-01-13', '1159', 54.00, 'pagseguro', NULL, 'Pagseguro Assinatura', 'Aprovado', NULL, 'F93D0303-9A46-405B-8D85-CBCF52B0E853', '2016-01-13'),
(1160, 66, 6, '2016-02-13', '2016-02-13', '1160', 54.00, 'pagseguro', NULL, 'Pagseguro Assinatura', 'Aprovado', NULL, 'C18F2DB1-09C0-40EC-BF8F-A2EBC7736CF6', '2016-02-13'),
(1161, 66, 6, '2016-03-13', '2016-03-13', '1161', 54.00, 'pagseguro', NULL, 'Pagseguro Assinatura', 'Aprovado', NULL, '5B193D78-D8A3-4A7B-848F-6D62C72AC64F', '2016-03-13'),
(1162, 66, 6, '2016-04-13', '2016-04-13', '1162', 54.00, 'pagseguro', NULL, 'Pagseguro Assinatura', 'Aprovado', NULL, '6E257F9B-A432-4156-AB37-FD791A102F2C', '2016-04-13'),
(1163, 66, 6, '2016-05-13', '2016-06-14', '1163', 54.00, 'pagseguro', NULL, 'Pagseguro Assinatura', 'Aprovado', NULL, '9A5D85D0-AC57-471F-A2C9-B3B8288A97AA', '2016-06-14'),
(1164, 66, 6, '2016-06-13', '2016-07-13', '1164', 54.00, 'pagseguro', NULL, 'Pagseguro Assinatura', 'Aprovado', NULL, '9BFB3CCE-E84D-4663-9665-A3C782A98DD3', '2016-07-13'),
(1165, 66, 6, '2016-07-13', '2016-08-13', '1165', 54.00, 'pagseguro', NULL, 'Pagseguro Assinatura', 'Aprovado', NULL, '6E358433-A3AA-4511-9B8D-14E4D482656E', '2016-08-13'),
(1166, 66, 6, '2016-08-13', '2016-09-13', '1166', 54.00, 'pagseguro', NULL, 'Pagseguro Assinatura', 'Aprovado', NULL, '23812844-F8FC-41C7-A57F-455ED4BA7C00', '2016-09-13'),
(1167, 66, 6, '2016-09-13', '2016-10-13', '1167', 54.00, 'pagseguro', NULL, 'Pagseguro Assinatura', 'Aprovado', NULL, 'EC7C0AF2-A726-4845-BDD0-249911959BD2', '2016-10-13'),
(1168, 66, 6, '2016-10-13', '2016-11-13', '1168', 54.00, 'pagseguro', NULL, 'Pagseguro Assinatura', 'Aprovado', NULL, '27A94CC3-A199-407B-88F8-4CE2931E465D', '2016-11-13'),
(1169, 67, 4, '2015-11-16', '0000-00-00', '1169', 54.00, '', NULL, NULL, NULL, NULL, NULL, NULL),
(1170, 67, 4, '2015-12-16', '0000-00-00', '1170', 54.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1097, 61, 6, '2015-01-19', '0000-00-00', '1097', 54.00, 'pagseguro', NULL, 'Pagseguro Assinatura', 'Aprovado', NULL, 'AE8D3923-ED16-4171-8551-4CAC6ED6DBE1', '2015-01-19'),
(1098, 61, 4, '2015-02-19', '0000-00-00', '1098', 54.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1099, 61, 4, '2015-03-19', '0000-00-00', '1099', 54.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1100, 61, 4, '2015-04-19', '0000-00-00', '1100', 54.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1101, 61, 4, '2015-05-19', '0000-00-00', '1101', 54.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1102, 61, 4, '2015-06-19', '0000-00-00', '1102', 54.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1103, 61, 4, '2015-07-19', '0000-00-00', '1103', 54.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1104, 61, 4, '2015-08-19', '0000-00-00', '1104', 54.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1105, 61, 4, '2015-09-19', '0000-00-00', '1105', 54.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1106, 61, 4, '2015-10-19', '0000-00-00', '1106', 54.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1107, 61, 4, '2015-11-19', '0000-00-00', '1107', 54.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1108, 61, 4, '2015-12-19', '0000-00-00', '1108', 54.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1171, 67, 4, '2016-01-16', '0000-00-00', '1171', 54.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1157, 66, 6, '2015-11-13', '2015-11-13', '1157', 54.00, 'pagseguro', NULL, 'Pagseguro Assinatura', 'Aprovado', NULL, '102AAE87-1DBF-4B40-B3A9-DA502BD50078', '2015-11-13'),
(1158, 66, 6, '2015-12-13', '2015-12-13', '1158', 54.00, 'pagseguro', NULL, 'Pagseguro Assinatura', 'Aprovado', NULL, 'EA4842CF-E4A7-4698-993E-248E6EB5C9D7', '2015-12-13');

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes_periodos`
--

CREATE TABLE IF NOT EXISTS `clientes_periodos` (
  `cod_cli_periodo` int(11) NOT NULL AUTO_INCREMENT,
  `cod_periodo` int(11) NOT NULL,
  `cod_cliente` int(11) NOT NULL,
  `data_inserido` date NOT NULL,
  `valor_total` decimal(10,2) NOT NULL,
  `dia_vencimento` int(11) NOT NULL,
  PRIMARY KEY (`cod_cli_periodo`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=68 ;

--
-- Extraindo dados da tabela `clientes_periodos`
--

INSERT INTO `clientes_periodos` (`cod_cli_periodo`, `cod_periodo`, `cod_cliente`, `data_inserido`, `valor_total`, `dia_vencimento`) VALUES
(61, 2, 83, '2015-01-19', 54.00, 19),
(66, 4, 93, '2015-11-13', 54.00, 13),
(67, 4, 94, '2015-11-16', 54.00, 16);

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes_planos`
--

CREATE TABLE IF NOT EXISTS `clientes_planos` (
  `cod_cli_plano` int(11) NOT NULL AUTO_INCREMENT,
  `cod_cli_periodo` int(11) NOT NULL,
  `cod_plano` int(11) DEFAULT NULL,
  `valor` decimal(10,2) NOT NULL,
  `valor_real` decimal(10,2) NOT NULL,
  `desconto` decimal(10,2) NOT NULL,
  PRIMARY KEY (`cod_cli_plano`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=117 ;

--
-- Extraindo dados da tabela `clientes_planos`
--

INSERT INTO `clientes_planos` (`cod_cli_plano`, `cod_cli_periodo`, `cod_plano`, `valor`, `valor_real`, `desconto`) VALUES
(116, 67, 4, 54.00, 54.00, 0.00),
(115, 66, 4, 54.00, 54.00, 0.00),
(110, 61, 4, 54.00, 54.00, 0.00);

-- --------------------------------------------------------

--
-- Estrutura da tabela `conteudos`
--

CREATE TABLE IF NOT EXISTS `conteudos` (
  `cod_conteudo` int(10) NOT NULL AUTO_INCREMENT,
  `cod_conteudo_pai` int(10) DEFAULT '0',
  `cod_conteudo_categoria` int(10) DEFAULT '0',
  `tipo` varchar(50) DEFAULT NULL,
  `status` int(10) DEFAULT NULL,
  `principal` int(10) DEFAULT NULL,
  `posicao` int(10) DEFAULT NULL,
  `ordem` int(10) DEFAULT NULL,
  `idioma` varchar(2) DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  `link` varchar(400) DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `descricao` text,
  `texto1` text,
  `texto2` text,
  `texto3` text,
  `arquivo1` varchar(200) DEFAULT NULL,
  `arquivo1_original` varchar(200) DEFAULT NULL,
  `arquivo2` varchar(200) DEFAULT NULL,
  `arquivo2_original` varchar(200) DEFAULT NULL,
  `urlrewrite` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`cod_conteudo`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Extraindo dados da tabela `conteudos`
--

INSERT INTO `conteudos` (`cod_conteudo`, `cod_conteudo_pai`, `cod_conteudo_categoria`, `tipo`, `status`, `principal`, `posicao`, `ordem`, `idioma`, `data`, `link`, `nome`, `descricao`, `texto1`, `texto2`, `texto3`, `arquivo1`, `arquivo1_original`, `arquivo2`, `arquivo2_original`, `urlrewrite`) VALUES
(1, 0, 0, 'pag_quemsomos', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 0, 0, 'pag_duvidas', 1, 0, 0, 2, 'br', '0000-00-00 00:00:00', '', 'Quem vai administrar o dinheiro para beneficiar devidamente os alunos?', '', '<p>Uma comiss&atilde;o independente de ex-alunos vai supervisionar a utiliza&ccedil;&atilde;o do  valor gerado pela venda dos planos para a devida finalidade, conforme  especificado em cada plano.</p>', '', '', NULL, NULL, NULL, NULL, 'quem-vai-administrar-o-dinheiro-para-beneficiar-devidamente-os-alunos'),
(3, 0, 0, 'pag_banner_home', 1, 0, 0, 2, 'br', '0000-00-00 00:00:00', '', 'Passagem\r\npara', '', 'Israel', '', 'R$ 180,00', '15410457fdedb3.jpg', '15410457fc938a.jpg', NULL, NULL, 'passagempara'),
(4, 0, 0, 'pag_banner_home', 1, 0, 0, 3, 'br', '0000-00-00 00:00:00', '', 'Conhecer a\r\nterra do', '', 'nosso povo', 'os mesmos...', 'R$ 180,00', '2541045da36562.jpg', '2541045da2abee.jpg', NULL, NULL, 'conhecer-aterra-do'),
(5, 0, 0, 'pag_banner_home', 1, 0, 0, 5, 'br', '0000-00-00 00:00:00', '', 'Apoiar a', '', 'Educação Judaica', 'com tudo isso...', 'Não tem preço!', '45241dfe429e3a.jpg', '45241dfe4207ed.jpg', NULL, NULL, 'apoiar-a'),
(6, 0, 0, 'pag_banner_home', 1, 0, 0, 4, 'br', '0000-00-00 00:00:00', '', 'Ter aquelas\r\nmerecidas', '', 'férias', 'os mesmos...', 'R$ 180,00', '35410460b8b5bd.jpg', '35410460b80b77.jpg', NULL, NULL, 'ter-aquelasmerecidas'),
(7, 0, 0, 'pag_banner_home', 1, 0, 0, 6, 'br', '0000-00-00 00:00:00', '', 'Plano', '', 'Férias', 'Passagem para Israel, ida e volta...', 'R$ 180,00', '5541046989cde6.jpg', '5541046988e616.jpg', NULL, NULL, 'plano'),
(8, 0, 0, 'pag_banner_home', 1, 0, 0, 7, 'br', '0000-00-00 00:00:00', '', 'Plano', '', 'Luz', 'Adquira o Plano Luz e ilumine o seu lar com uma linda Menorá.', 'R$ 108,00', '6541046b414768.jpg', '6541046b4095d7.jpg', NULL, NULL, 'plano1'),
(9, 0, 0, 'pag_banner_home', 1, 0, 0, 8, 'br', '0000-00-00 00:00:00', '', 'Plano', '', 'Arte', 'Litografia original do quadro "Quando Mashiach Chegar - When Moshiach comes".', 'R$ 54,00', '7541046d04973d.jpg', '7541046d035c97.jpg', NULL, NULL, 'plano2'),
(10, 0, 0, 'pag_quemsomos', 1, 0, 0, 0, 'br', '0000-00-00 00:00:00', '', 'Quem Somos', 'Um projeto com fins beneficentes', '<p style="padding: 0; margin: 0;"><img src="http://interacao.gani.org.br/assets/conteudo/uploads_editor/top.jpg" alt="" /></p>\r\n<p>Bem-vindo ao projeto <span class="e_conteudo2">InterA&Ccedil;&Atilde;O, uma iniciativa da Comiss&atilde;o de Pais e Ex-alunos da Associa&ccedil;&atilde;o Beneficente Cultural Lubavitch</span> para arrecadar doa&ccedil;&otilde;es e mobilizar s&oacute;cios, com o objetivo de angariar fundos para as obras assistenciais das <span class="e_conteudo2">Escolas Lubavitch</span> (meninos) e <span class="e_conteudo2">Gani </span>(meninas).</p>\r\n<p>O esfor&ccedil;o constante nos fez completar mais de 50 anos de exist&ecirc;ncia, em um misto de tradi&ccedil;&atilde;o e m&eacute;rito, mas que n&atilde;o garante o futuro. Para que este legado seja cada vez mais difundido s&atilde;o necess&aacute;rios f&eacute;, persist&ecirc;ncia e trabalho.</p>\r\n<p><span class="e_conteudo2">InterA&Ccedil;&Atilde;O </span>mant&eacute;m o elo de gratid&atilde;o entre o ex-aluno e sua escola, entre o pai e o professor, entre a comunidade e a escola judaica religiosa. Ao adquirir um dos planos - <span class="e_conteudo2">F&Eacute;RIAS, LUZ ou ARTE</span> -, voc&ecirc; contribui para as Escolas e patrocina o aprendizado de um aluno. Ao final, um pr&ecirc;mio referente a cada pacote ser&aacute; sorteado. &Eacute; uma influ&ecirc;ncia rec&iacute;proca, uma manifesta&ccedil;&atilde;o de reconhecimento, uma maneira de interagir com quem fez parte de sua hist&oacute;ria.</p>\r\n<p>Participe e fa&ccedil;a parte desse mutir&atilde;o de <span class="e_conteudo2">APOIO &Agrave; EDUCA&Ccedil;&Atilde;O JUDAICA!</span></p>\r\n<p>Navegue no site, tire suas d&uacute;vidas e aproveite. Desejamos a todos, boa sorte!</p>\r\n<p>Comiss&atilde;o de Pais e Ex-Alunos</p>\r\n<p>Lubavitch-Gani</p>\r\n<p>&nbsp;</p>', '', '', NULL, NULL, NULL, NULL, 'quem-somos'),
(11, 0, 0, 'pag_duvidas', 1, 0, 0, 1, 'br', '0000-00-00 00:00:00', '', 'O investimento é considerado Tsedacá? Posso tirar do meu maasser?', '', '<p>Sim. O valor investido &eacute; considerado Tsedac&aacute; e pode ser retirado do  maasser, independentemente de haver um sorteio de pr&ecirc;mios ao final.</p>', '', '', NULL, NULL, NULL, NULL, 'o-investimento-e-considerado-tsedaca-posso-tirar-do-meu-maasser'),
(12, 0, 0, 'pag_duvidas', 1, 0, 0, 3, 'br', '0000-00-00 00:00:00', '', 'Como é feito o sorteio?', '', '<p>A cada m&ecirc;s pago, o s&oacute;cio ganha um n&uacute;mero para entrar no sorteio. Ao  final do plano, com os 12 meses pagos, receber&aacute; mais 6 n&uacute;meros, &nbsp;totalizando 18 chances de ganhar.</p>', '', '', NULL, NULL, NULL, NULL, 'como-e-feito-o-sorteio'),
(13, 0, 0, 'pag_duvidas', 1, 0, 0, 4, 'br', '0000-00-00 00:00:00', '', 'O que acontece caso eu desista de pagar o plano antes de completar os 12 meses de investimento?', '', '<p>Neste caso, os valores pagos ficam como Tsedac&aacute;, sem nenhum  ressarcimento devido. Por&eacute;m, o s&oacute;cio ainda poder&aacute; concorrer com os  n&uacute;meros dos meses que j&aacute; havia pago.</p>', '', '', NULL, NULL, NULL, NULL, 'o-que-acontece-caso-eu-desista-de-pagar-o-plano-antes-de-completar-os-12-meses-de-investimento'),
(14, 0, 0, 'pag_duvidas', 1, 0, 0, 5, 'br', '0000-00-00 00:00:00', '', 'Posso comprar mais de um plano?', '', '<p>Sim! Voc&ecirc; pode comprar mais de um plano e, se compr&aacute;-los juntos, na mesma opera&ccedil;&atilde;o, ter&aacute; desconto de 10% no valor do segundo plano (Luz ou Arte) e mais 10% na compra do terceiro plano (Arte). Veja como:</p>\r\n<ul>\r\n <li>Comprando juntos os planos F&eacute;rias + Luz + Arte = de <strike>R$ 342,00</strike> por R$ 325,80</li>\r\n <li>Comprando juntos os planos F&eacute;rias + Luz = de <strike>R$ 288,00</strike> por R$ 277,20</li>\r\n <li>Comprando juntos os planos F&eacute;rias + Arte = de <strike>R$ 234,00</strike> por R$ 228,60</li>\r\n <li>Comprando juntos os planos Luz + Arte = de <strike>R$ 162,00</strike> por R$ 156,60</li>\r\n</ul>', '', '', NULL, NULL, NULL, NULL, 'posso-comprar-mais-de-um-plano'),
(15, 0, 0, 'pag_duvidas', 1, 0, 0, 6, 'br', '0000-00-00 00:00:00', '', 'Posso quitar o meu investimento antes de completar os 12 meses?', '', '<p>Sim. Caso isso ocorra, voc&ecirc; dever&aacute; contatar o setor Financeiro da escola  para efetuar o pagamento e o valor de desconto relativo ao n&uacute;mero de  parcelas que dever&atilde;o ser quitadas. Quanto mais cedo quitar o  investimento, mais descontos para voc&ecirc;.</p>', '', '', NULL, NULL, NULL, NULL, 'posso-quitar-o-meu-investimento-antes-de-completar-os-12-meses'),
(16, 0, 0, 'pag_banner_rodape', 1, 0, 0, 1, 'br', '0000-00-00 00:00:00', '', 'Realização', '', '', '', '', NULL, NULL, NULL, NULL, 'realizacao'),
(17, 0, 0, 'pag_banner_rodape', 1, 0, 0, 2, 'br', '0000-00-00 00:00:00', '', 'Promoção', '', '', '', '', NULL, NULL, NULL, NULL, 'promocao'),
(18, 0, 0, 'pag_banner_rodape', 1, 0, 0, 3, 'br', '0000-00-00 00:00:00', '', 'Agência', '', '', '', '', NULL, NULL, NULL, NULL, 'agencia'),
(19, 0, 0, 'pag_banner_rodape', 1, 0, 0, 4, 'br', '0000-00-00 00:00:00', '', 'Parceiros (com link)', '', '', '', '', NULL, NULL, NULL, NULL, 'parceiros-com-link'),
(21, 0, 0, 'pag_banner_home', 0, 0, 0, 1, 'br', '0000-00-00 00:00:00', '', 'Promoção de', '', 'Lançamento', 'Adquira mais de um plano - até Rosh Hashaná - e receba uma garrafa de vinho importada! \r\n(Promoção válida na cidade de S.Paulo)\r\n\r\n\r\nCom os cumprimentos da:', 'ConfrariaKasher', '5404d8df51e0e.jpg', 'newyear-25404d8c6a77ed.jpg', NULL, NULL, 'promocao-de');

-- --------------------------------------------------------

--
-- Estrutura da tabela `conteudos_assets`
--

CREATE TABLE IF NOT EXISTS `conteudos_assets` (
  `cod_cont_assets` int(10) NOT NULL AUTO_INCREMENT,
  `cod_conteudo` int(10) NOT NULL,
  `tipo` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `nome` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `descricao` text COLLATE latin1_general_ci,
  `texto1` text COLLATE latin1_general_ci,
  `link` varchar(400) COLLATE latin1_general_ci DEFAULT NULL,
  `ordem` int(10) DEFAULT NULL,
  `arquivo1` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
  `arquivo1_original` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
  `arquivo2` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
  `arquivo2_original` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
  `urlrewrite` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`cod_cont_assets`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=43 ;

--
-- Extraindo dados da tabela `conteudos_assets`
--

INSERT INTO `conteudos_assets` (`cod_cont_assets`, `cod_conteudo`, `tipo`, `nome`, `descricao`, `texto1`, `link`, `ordem`, `arquivo1`, `arquivo1_original`, `arquivo2`, `arquivo2_original`, `urlrewrite`) VALUES
(21, 17, '', '', '', '', NULL, 2, 'promocao-site53cd72bdd8351.jpg', 'promocao-site53cd72bdd43e8.jpg', NULL, NULL, ''),
(20, 19, '', '', '', '', 'www.koshermap.com.br', 2, 'anuncio-koshermap-site53cd71a70972d.jpg', 'anuncio-koshermap-site53cd71a706d14.jpg', NULL, NULL, ''),
(14, 16, '', '', '', '', '', 0, 'logos-lubavitch-gani53cd6d5ed144e.jpg', 'logos-lubavitch-gani53cd6d5e7a7ef.jpg', NULL, NULL, ''),
(31, 18, '', '', '', '', 'www.aktual.com.br', 0, 'logo---aktual3bmp53ebdf32a2822.bmp', 'logo---aktual3bmp53ebdf32a06f5.bmp', NULL, NULL, ''),
(42, 19, '', '', '', '', 'www.tnuva.com.br/', 4, 'tnuva-novo-site5404d37bf16e0.jpg', 'tnuva-novo-site5404d37bef638.jpg', NULL, NULL, ''),
(41, 19, '', '', '', '', 'www.confrariakasher.com.br/', 3, 'confraria-site5404d363db13d.jpg', 'confraria-site5404d363d69f0.jpg', NULL, NULL, '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `conteudos_categorias`
--

CREATE TABLE IF NOT EXISTS `conteudos_categorias` (
  `cod_conteudo_categoria` int(10) NOT NULL AUTO_INCREMENT,
  `idioma` varchar(2) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `ordem` int(11) DEFAULT NULL,
  `urlrewrite` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`cod_conteudo_categoria`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `formularios_contatos`
--

CREATE TABLE IF NOT EXISTS `formularios_contatos` (
  `cod_formulario` int(11) NOT NULL AUTO_INCREMENT,
  `data` datetime DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone` varchar(100) DEFAULT NULL,
  `assunto` varchar(100) DEFAULT NULL,
  `mensagem` text,
  PRIMARY KEY (`cod_formulario`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;

--
-- Extraindo dados da tabela `formularios_contatos`
--

INSERT INTO `formularios_contatos` (`cod_formulario`, `data`, `nome`, `email`, `telefone`, `assunto`, `mensagem`) VALUES
(3, '2014-08-12 00:00:00', 'Nancy', 'nannydesign@terra.com.br', '11 2157-9820', 'teste', 'teste'),
(4, '2014-08-12 00:00:00', 'Nancy', 'nanny@nannydesign.com.br', '11 2157-9820', 'teste agora', 'teste depois de alterado a configuração no sistema e a senha do email'),
(18, '2015-01-18 00:00:00', 'Flora M Levaton', 'yflevaton@gmail.com', '3721 8454', 'plano arte interação', 'BS"D\r\nNão consegui acessar o site para dar minha contribuição deste mês. Pensei q receberia um e-mail c o link p fazer o pagamento. Se por acaso chegou, não identifiquei. Como devo proceder?');

-- --------------------------------------------------------

--
-- Estrutura da tabela `opcoes`
--

CREATE TABLE IF NOT EXISTS `opcoes` (
  `idioma` varchar(2) NOT NULL DEFAULT '',
  `nome` varchar(50) DEFAULT '',
  `valor` text,
  KEY `nome_idioma` (`nome`,`idioma`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `opcoes`
--

INSERT INTO `opcoes` (`idioma`, `nome`, `valor`) VALUES
('', 'email_sistema_porta', '587'),
('', 'email_contato', 'info@interacao.gani.org.br'),
('', 'email_sistema_senha', '16f4s4b4w2r2r2t2'),
('', 'email_sistema_host', 'smtp.interacao.gani.org.br'),
('', 'email_sistema_login', 'info@interacao.gani.org.br'),
('', 'google_analytics', '<script language="javascript">\r\n// Código\r\n</script>'),
('', 'email_sistema_seguranca', ''),
('', 'google_maps', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `periodos`
--

CREATE TABLE IF NOT EXISTS `periodos` (
  `cod_periodo` int(10) NOT NULL AUTO_INCREMENT,
  `periodo` varchar(50) DEFAULT NULL,
  `vigente` int(11) DEFAULT NULL,
  `data_inicio` date DEFAULT NULL,
  `data_fim` date DEFAULT NULL,
  PRIMARY KEY (`cod_periodo`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `periodos`
--

INSERT INTO `periodos` (`cod_periodo`, `periodo`, `vigente`, `data_inicio`, `data_fim`) VALUES
(4, '2016', 0, '2016-02-01', '2016-12-31');

-- --------------------------------------------------------

--
-- Estrutura da tabela `planos`
--

CREATE TABLE IF NOT EXISTS `planos` (
  `cod_plano` int(10) NOT NULL AUTO_INCREMENT,
  `cod_periodo` int(10) NOT NULL,
  `plano` varchar(50) DEFAULT NULL,
  `valor` decimal(10,2) NOT NULL,
  `descricao` text,
  `texto1` text,
  `texto2` text,
  `texto3` text,
  `arquivo1` varchar(100) DEFAULT NULL,
  `arquivo1_original` varchar(100) DEFAULT NULL,
  `arquivo2` varchar(100) DEFAULT NULL,
  `arquivo2_original` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`cod_plano`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `planos`
--

INSERT INTO `planos` (`cod_plano`, `cod_periodo`, `plano`, `valor`, `descricao`, `texto1`, `texto2`, `texto3`, `arquivo1`, `arquivo1_original`, `arquivo2`, `arquivo2_original`) VALUES
(2, 4, 'Plano Férias', 180.00, 'Passagem para Israel (incluindo todas as taxas), com direito a 1 (um) acompanhante.', '<p><span class="e_conteudo3">ADQUIRA O PLANO f&Eacute;RIAS E REAlize o sonho da sua viagem para israel</span><br />\r\n<br />\r\nAten&ccedil;&atilde;o, passageiros! Pr&oacute;xima parada: Israel.</p>\r\n<p><span class="e_conteudo2">InterA&Ccedil;&Atilde;O </span>leva voc&ecirc; e um acompanhante para curtir as f&eacute;rias no pa&iacute;s que mant&eacute;m viva a hist&oacute;ria do nosso povo. Israel &eacute; &uacute;nico e perfeito. L&aacute;, a presen&ccedil;a Divina paira: reze no Kotel e sinta, aprecie o Kineret e veja, observe o mar e contemple. Ajude a escola, escolha a melhor data para embarcar e fa&ccedil;a as malas. <span class="e_conteudo2">Afinal, como o pr&oacute;prio plano diz: F&eacute;rias!</span><br />\r\n<br />\r\n<span class="e_conteudo3">caracter&iacute;sticas do plano F&Eacute;RIAS </span><br />\r\n<br />\r\n&bull; Passagem para Israel (incluindo todas as taxas), com direito a 1 (um) acompanhante.<br />\r\n<span class="e_conteudo2">&bull; Valor de s&oacute;cio: R$ 180,00 mensais - Plano de 12 meses.<br />\r\n&bull; Data do Sorteio: Quinta-feira, 26 de Janeiro de 2017.</span><br />\r\nObs.: Restri&ccedil;&otilde;es de datas de alta temporada.<br />\r\n<br />\r\n<span class="e_conteudo3">BENEF&Iacute;CIO DO FUNDO ANGARIADO PARA AS Escolas Lubavitch e Gani</span><br />\r\n<br />\r\n&bull; Custear Bolsas de Estudos.</p>\r\n<p>&nbsp;</p>', 'A sua maravilhosa viagem para a terra do nosso povo: Israel.', 'A sua viagem para Israel', 'plano-ferias-1.jpg', NULL, 'ft-pl-ferias52420de14521c.jpg', 'ft-pl-ferias52420de13d9cc.jpg'),
(3, 4, 'Plano Luz', 108.00, 'Menorá de pura prata, de qualidade única, feita pela marca HAZORFIM.', '<p><span class="e_conteudo3">ADQUIRA O PLANO LUZ E ilumine o seu lar com uma linda menor&aacute;</span><br />\r\n<br />\r\nPelo fato de as luzes da Menor&aacute; serem acesas de modo crescente em Chanuc&aacute;, aprendemos que &eacute; nosso papel reverter a escurid&atilde;o. Ao adquirir o <span class="e_conteudo2">Plano Luz do InterA&Ccedil;&Atilde;O</span>, voc&ecirc; aciona o interruptor da escola e acende as luzes, ilumina os corredores e faz brilhar os estudos de cada aluno.</p>\r\n<p>A mitsv&aacute; de contribuir para a nossa escola far&aacute; refletir um brilho intenso vindo das velas por entre os entalhes da Menor&aacute; de prata. <br />\r\n<br />\r\n<span class="e_conteudo3">caracter&iacute;sticas do plano luz </span><br />\r\n<br />\r\n&bull; Menor&aacute; de pura prata, de qualidade &uacute;nica, feita pela marca HAZORFIM, internacionalmente conhecida, no mercado desde 1952. Com a inovadora e exclusiva tecnologia anti-manchas (nanotecnologia), a pe&ccedil;a tem o brilho da prata protegido por mais de 10 anos. A menor&aacute; recebe o carimbo HAZORFIM 925, que &eacute; garantia de qualidade.<br />\r\n<br />\r\n<span class="e_conteudo2">&bull; Valor de s&oacute;cio: R$ 108,00 mensais - Plano de 12 meses.<br />\r\n&bull; Data do Sorteio: Quinta-feira, 26 de Janeiro de 2017.</span><br />\r\n<br />\r\n<span class="e_conteudo3">BENEF&Iacute;CIO DO FUNDO ANGARIADO PARA AS Escolas Lubavitch e Gani</span><br />\r\n<br />\r\n&bull; Custear livros e material did&aacute;tico para alunos menos favorecidos.</p>\r\n<p>&nbsp;</p>', 'Uma linda Menorá para iluminar o seu lar e a sua família.', 'Linda Menorá de prata', 'plano-luz-1.jpg', NULL, 'ft-pl-luz52420e5aba08e.jpg', 'ft-pl-luz52420e5ab27d4.jpg'),
(4, 4, 'Plano Arte', 54.00, 'Litografia original do quadro "Quando Mashiach chegar - When Moshiach comes".', '<p><span class="e_conteudo3">ADQUIRA O PLANO ARTE E DECORE E INSPIRE O SEU LAR </span><br />\r\n<br />\r\nCom brach&aacute; direta e em honra ao anivers&aacute;rio de 90 anos do Rebe, o artista Michel Schwartz produziu este belo quadro que traz refer&ecirc;ncias diretas &agrave; vinda de Mashiach e de como ser&atilde;o as maravilhas do mundo. A partir de 387 mil letras em hebraico, que descrevem as refer&ecirc;ncias da Tor&aacute; sobre a nova Era, a obra de arte &eacute; pe&ccedil;a que decora e inspira todo lar judaico.</p>\r\n<p>Com o <span class="e_conteudo2">Plano Arte da InterA&Ccedil;&Atilde;O</span>, voc&ecirc; contribui para a escola e concorre a este belo quadro. Que mere&ccedil;amos esta &eacute;poca breve em nossos dias!<br />\r\n<br />\r\n<span class="e_conteudo3">caracter&iacute;sticas do plano arte </span><br />\r\n<br />\r\n<a href="http://www.chabad.org/therebbe/article_cdo/aid/375089/jewish/The-Rebbe-and-the-Artist.htm" target="_blank"><span class="e_conteudo2">Litografia original do quadro &quot;Quando Mashiach chegar - When Moshiach comes&quot; por Michel Schwartz, a &uacute;nica obra de arte encomendada pelo Rebe de Lubavitch.</span></a><br />\r\n&bull; Edi&ccedil;&atilde;o limitada, assinada e numerada pelo artista e item de colecionador.<br />\r\n<br />\r\n<span class="e_conteudo2">&bull; Valor de s&oacute;cio: R$ 54,00 mensais - Plano de 12 meses.<br />\r\n&bull; Data do Sorteio: Quinta-feira, 26 de Janeiro de 2017.</span><br />\r\n<br />\r\n<span class="e_conteudo3">BENEF&Iacute;CIO DO FUNDO ANGARIADO PARA AS Escolas Lubavitch e Gani</span><br />\r\n<br />\r\n&bull; Custear uniformes e itens de higiene para alunos menos favorecidos.</p>\r\n<p>&nbsp;<span class="e_conteudo3"><br />\r\n</span></p>', 'Um belo quadro que decora e inspira todo lar judaico.', 'Quando Mashiach chegar', 'plano-arte-1.jpg', NULL, 'ft-pl-arte52420ae27f47a.jpg', 'ft-pl-arte52420ae277ae2.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `cod_status` int(10) NOT NULL AUTO_INCREMENT,
  `status` varchar(100) DEFAULT NULL,
  `tipo` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`cod_status`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `status`
--

INSERT INTO `status` (`cod_status`, `status`, `tipo`) VALUES
(1, 'Ativo', 'cliente'),
(2, 'Inativo', 'cliente'),
(3, 'Suspenso', 'cliente'),
(4, 'A pagar', 'parcela'),
(5, 'Atrasado', 'parcela'),
(6, 'Pago', 'parcela');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
