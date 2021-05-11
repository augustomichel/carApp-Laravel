-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 23-Abr-2021 às 12:44
-- Versão do servidor: 10.4.17-MariaDB
-- versão do PHP: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `prime_carapp`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `acao`
--

CREATE TABLE `acao` (
  `aca_codigo` int(10) UNSIGNED NOT NULL,
  `usuario_usu_codigo` int(10) UNSIGNED NOT NULL,
  `cliente_cli_codigo` int(10) UNSIGNED NOT NULL,
  `cli_codigo` int(10) UNSIGNED DEFAULT NULL,
  `usu_codigo` int(10) UNSIGNED DEFAULT NULL,
  `aca_descricao` varchar(150) DEFAULT NULL,
  `aca_status` char(1) DEFAULT NULL,
  `aca_qtd_pontos` int(10) UNSIGNED DEFAULT NULL,
  `aca_datetime` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `acao_produto`
--

CREATE TABLE `acao_produto` (
  `acp_codigo` int(10) UNSIGNED NOT NULL,
  `produto_pro_codigo` int(10) UNSIGNED NOT NULL,
  `acao_aca_codigo` int(10) UNSIGNED NOT NULL,
  `aca_codigo` int(10) UNSIGNED DEFAULT NULL,
  `pro_codigo` int(10) UNSIGNED DEFAULT NULL,
  `acp_datetime` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE `cliente` (
  `cli_codigo` int(10) UNSIGNED NOT NULL,
  `cli_nome` varchar(150) DEFAULT NULL,
  `cli_cnp` varchar(30) DEFAULT NULL,
  `cli_status` char(1) DEFAULT '1',
  `cli_datetime` datetime DEFAULT NULL,
  `cli_matriz` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `marca`
--

CREATE TABLE `marca` (
  `mac_codigo` int(10) UNSIGNED NOT NULL,
  `mac_nome` varchar(40) NOT NULL,
  `mac_status` char(1) NOT NULL DEFAULT 'S',
  `mac_datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `modelo`
--

CREATE TABLE `modelo` (
  `mod_codigo` int(10) UNSIGNED NOT NULL,
  `mod_marca` int(10) UNSIGNED NOT NULL,
  `mod_nome` varchar(40) NOT NULL,
  `mod_status` char(1) NOT NULL DEFAULT 'S',
  `mod_datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `modelo_versao`
--

CREATE TABLE `modelo_versao` (
  `mvs_codigo` int(10) UNSIGNED NOT NULL,
  `mvs_modelo` int(10) UNSIGNED NOT NULL,
  `mvs_nome` varchar(20) NOT NULL,
  `mvs_status` char(1) NOT NULL DEFAULT 'S',
  `mvs_datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

CREATE TABLE `produto` (
  `pro_codigo` int(10) UNSIGNED NOT NULL,
  `pro_cliente` int(10) UNSIGNED NOT NULL,
  `pro_nome` varchar(150) NOT NULL,
  `pro_status` char(1) NOT NULL,
  `pro_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto_campo`
--

CREATE TABLE `produto_campo` (
  `prc_codigo` int(10) UNSIGNED NOT NULL,
  `produto_pro_codigo` int(10) UNSIGNED NOT NULL,
  `produto_campo_tipo_pct_codigo` int(10) UNSIGNED NOT NULL,
  `pro_codigo` int(10) UNSIGNED DEFAULT NULL,
  `pct_codigo` int(10) UNSIGNED DEFAULT NULL,
  `prc_nome` varchar(50) DEFAULT NULL,
  `prc_status` char(1) DEFAULT NULL,
  `prc_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto_campo_tipo`
--

CREATE TABLE `produto_campo_tipo` (
  `pct_codigo` int(10) UNSIGNED NOT NULL,
  `pct_descricao` varchar(30) DEFAULT NULL,
  `pct_tamanho` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `servico`
--

CREATE TABLE `servico` (
  `ser_codigo` int(10) UNSIGNED NOT NULL,
  `ser_cliente` int(10) UNSIGNED NOT NULL,
  `ser_descricao` varchar(255) NOT NULL,
  `ser_tipo_servico` int(10) UNSIGNED NOT NULL,
  `ser_time_execucao` int(10) NOT NULL,
  `ser_status` char(1) NOT NULL DEFAULT 'A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `usu_codigo` int(10) UNSIGNED NOT NULL COMMENT 'Código de Identificação do Usuário',
  `usu_nivel` int(10) UNSIGNED NOT NULL COMMENT 'Código do Nivel do Usuário',
  `usu_cliente` int(10) UNSIGNED NOT NULL COMMENT 'Código do Cliente',
  `usu_nome` varchar(150) NOT NULL COMMENT 'Nome do Usuário',
  `usu_email` varchar(150) NOT NULL COMMENT 'Email do Usuário',
  `usu_senha` varchar(255) NOT NULL COMMENT 'Senha do Usuário',
  `usu_status` char(1) NOT NULL COMMENT 'Status do Usuário',
  `usu_datetime` datetime NOT NULL COMMENT 'Data de Inclusão do Usuário'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario_acao`
--

CREATE TABLE `usuario_acao` (
  `usa_codigo` int(10) UNSIGNED NOT NULL,
  `usuario_usu_codigo` int(10) UNSIGNED NOT NULL,
  `acao_aca_codigo` int(10) UNSIGNED NOT NULL,
  `usu_codigo` int(10) UNSIGNED DEFAULT NULL,
  `aca_codigo` int(10) UNSIGNED DEFAULT NULL,
  `usa_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario_conta`
--

CREATE TABLE `usuario_conta` (
  `usc_codigo` int(10) UNSIGNED NOT NULL,
  `usuario_usu_codigo` int(10) UNSIGNED NOT NULL,
  `usu_codigo` int(10) UNSIGNED DEFAULT NULL,
  `usc_saldo` int(10) UNSIGNED DEFAULT 0,
  `usc_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario_extrato`
--

CREATE TABLE `usuario_extrato` (
  `use_codigo` int(10) UNSIGNED NOT NULL,
  `usuario_conta_usc_codigo` int(10) UNSIGNED NOT NULL,
  `usc_codigo` int(10) UNSIGNED DEFAULT NULL,
  `use_tipo` char(1) DEFAULT '1',
  `use_descricao` varchar(150) DEFAULT NULL,
  `use_valor` int(10) UNSIGNED DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario_nivel`
--

CREATE TABLE `usuario_nivel` (
  `usn_codigo` int(10) UNSIGNED NOT NULL,
  `usn_descricao` varchar(150) DEFAULT NULL,
  `usn_status` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario_produto`
--

CREATE TABLE `usuario_produto` (
  `usp_codigo` int(10) UNSIGNED NOT NULL,
  `produto_campo_prc_codigo` int(10) UNSIGNED NOT NULL,
  `usuario_usu_codigo` int(10) UNSIGNED NOT NULL,
  `produto_pro_codigo` int(10) UNSIGNED NOT NULL,
  `pro_codigo` int(10) UNSIGNED DEFAULT NULL,
  `usu_codigo` int(10) UNSIGNED DEFAULT NULL,
  `prc_codigo` int(10) UNSIGNED DEFAULT NULL,
  `usp_valor` double(10,2) DEFAULT NULL,
  `usp_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario_servico`
--

CREATE TABLE `usuario_servico` (
  `uss_codigo` int(10) UNSIGNED NOT NULL,
  `usuario_usu_codigo` int(10) UNSIGNED NOT NULL,
  `cliente_cli_codigo` int(10) UNSIGNED NOT NULL,
  `cli_codigo` int(10) UNSIGNED DEFAULT NULL,
  `usv_codigo` int(10) NOT NULL,
  `uss_ser_codigo` int(10) NOT NULL,
  `usu_codigo_solicitante` int(10) UNSIGNED DEFAULT NULL,
  `usu_codigo_executor` int(10) UNSIGNED DEFAULT NULL,
  `pro_codigo` int(10) UNSIGNED DEFAULT NULL,
  `uss_observacao` text DEFAULT NULL,
  `uss_status` int(10) UNSIGNED DEFAULT 1,
  `uss_datetime_entrega` datetime DEFAULT NULL,
  `uss_datetime_inicio` datetime DEFAULT NULL,
  `uss_datetime_finalizacao` datetime DEFAULT NULL,
  `uss_descricao_avaliacao` text DEFAULT NULL,
  `uss_datetime_avaliacao` datetime DEFAULT NULL,
  `uss_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario_servico_file`
--

CREATE TABLE `usuario_servico_file` (
  `usf_codigo` int(10) UNSIGNED NOT NULL,
  `usuario_servico_uss_codigo` int(10) UNSIGNED NOT NULL,
  `uss_codigo` int(10) UNSIGNED DEFAULT NULL,
  `usf_blob` blob DEFAULT NULL,
  `usf_type` varchar(255) DEFAULT NULL,
  `usf_deletado` char(1) DEFAULT '0',
  `usf_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario_servico_info`
--

CREATE TABLE `usuario_servico_info` (
  `usi_codigo` int(10) UNSIGNED NOT NULL,
  `usuario_servico_uss_codigo` int(10) UNSIGNED NOT NULL,
  `uss_codigo` int(10) UNSIGNED DEFAULT NULL,
  `usi_descricao` text DEFAULT NULL,
  `usu_codigo` int(10) UNSIGNED DEFAULT NULL,
  `usi_deletado` char(1) DEFAULT '0',
  `usi_datetime` datetime DEFAULT NULL,
  `usi_datetime_fim` datetime DEFAULT NULL,
  `usi_status_checkin` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario_veiculo`
--

CREATE TABLE `usuario_veiculo` (
  `usv_codigo` int(10) UNSIGNED NOT NULL,
  `usv_usuario` int(10) UNSIGNED NOT NULL,
  `usv_placa` varchar(15) DEFAULT NULL,
  `usv_marca` int(10) UNSIGNED NOT NULL,
  `usv_modelo` int(10) UNSIGNED NOT NULL,
  `usv_versao` int(10) UNSIGNED DEFAULT NULL,
  `km_atual` int(10) NOT NULL,
  `usv_status` char(1) NOT NULL DEFAULT 'S',
  `usv_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `acao`
--
ALTER TABLE `acao`
  ADD PRIMARY KEY (`aca_codigo`),
  ADD KEY `acao_FKIndex1` (`cliente_cli_codigo`),
  ADD KEY `acao_FKIndex2` (`usuario_usu_codigo`);

--
-- Índices para tabela `acao_produto`
--
ALTER TABLE `acao_produto`
  ADD PRIMARY KEY (`acp_codigo`),
  ADD KEY `acao_prodtuto_FKIndex1` (`acao_aca_codigo`),
  ADD KEY `acao_prodtuto_FKIndex2` (`produto_pro_codigo`);

--
-- Índices para tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`cli_codigo`);

--
-- Índices para tabela `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`mac_codigo`);

--
-- Índices para tabela `modelo`
--
ALTER TABLE `modelo`
  ADD PRIMARY KEY (`mod_codigo`),
  ADD KEY `modelo_marca_FK` (`mod_marca`);

--
-- Índices para tabela `modelo_versao`
--
ALTER TABLE `modelo_versao`
  ADD PRIMARY KEY (`mvs_codigo`),
  ADD KEY `modelo_versao_modelo_FK` (`mvs_modelo`);

--
-- Índices para tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`pro_codigo`),
  ADD KEY `produto_cliente_FK` (`pro_cliente`);

--
-- Índices para tabela `produto_campo`
--
ALTER TABLE `produto_campo`
  ADD PRIMARY KEY (`prc_codigo`),
  ADD KEY `produto_campo_FKIndex1` (`produto_campo_tipo_pct_codigo`),
  ADD KEY `produto_campo_FKIndex2` (`produto_pro_codigo`);

--
-- Índices para tabela `produto_campo_tipo`
--
ALTER TABLE `produto_campo_tipo`
  ADD PRIMARY KEY (`pct_codigo`);

--
-- Índices para tabela `servico`
--
ALTER TABLE `servico`
  ADD PRIMARY KEY (`ser_codigo`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usu_codigo`),
  ADD KEY `usuario_FKIndex1` (`usu_cliente`),
  ADD KEY `usuario_FKIndex2` (`usu_nivel`);

--
-- Índices para tabela `usuario_acao`
--
ALTER TABLE `usuario_acao`
  ADD PRIMARY KEY (`usa_codigo`),
  ADD KEY `usuario_acao_FKIndex1` (`acao_aca_codigo`),
  ADD KEY `usuario_acao_FKIndex2` (`usuario_usu_codigo`);

--
-- Índices para tabela `usuario_conta`
--
ALTER TABLE `usuario_conta`
  ADD PRIMARY KEY (`usc_codigo`),
  ADD KEY `usuario_conta_FKIndex1` (`usuario_usu_codigo`);

--
-- Índices para tabela `usuario_extrato`
--
ALTER TABLE `usuario_extrato`
  ADD PRIMARY KEY (`use_codigo`),
  ADD KEY `usuario_extrato_FKIndex1` (`usuario_conta_usc_codigo`);

--
-- Índices para tabela `usuario_nivel`
--
ALTER TABLE `usuario_nivel`
  ADD PRIMARY KEY (`usn_codigo`);

--
-- Índices para tabela `usuario_produto`
--
ALTER TABLE `usuario_produto`
  ADD PRIMARY KEY (`usp_codigo`),
  ADD KEY `usuario_produto_FKIndex1` (`produto_pro_codigo`),
  ADD KEY `usuario_produto_FKIndex2` (`usuario_usu_codigo`),
  ADD KEY `usuario_produto_FKIndex3` (`produto_campo_prc_codigo`);

--
-- Índices para tabela `usuario_servico`
--
ALTER TABLE `usuario_servico`
  ADD PRIMARY KEY (`uss_codigo`),
  ADD KEY `usuario_servico_FKIndex1` (`cliente_cli_codigo`),
  ADD KEY `usuario_servico_FKIndex2` (`usuario_usu_codigo`),
  ADD KEY `usuario_servico_FKIndex3` (`usuario_usu_codigo`);

--
-- Índices para tabela `usuario_servico_file`
--
ALTER TABLE `usuario_servico_file`
  ADD PRIMARY KEY (`usf_codigo`),
  ADD KEY `usuario_servico_file_FKIndex1` (`usuario_servico_uss_codigo`);

--
-- Índices para tabela `usuario_servico_info`
--
ALTER TABLE `usuario_servico_info`
  ADD PRIMARY KEY (`usi_codigo`),
  ADD KEY `usuario_servico_info_FKIndex1` (`usuario_servico_uss_codigo`);

--
-- Índices para tabela `usuario_veiculo`
--
ALTER TABLE `usuario_veiculo`
  ADD PRIMARY KEY (`usv_codigo`),
  ADD UNIQUE KEY `usuario_veiculo_UN` (`usv_marca`,`usv_modelo`,`usv_placa`),
  ADD KEY `usuario_veiculo_modelo_versao_FK` (`usv_versao`),
  ADD KEY `usuario_veiculo_usuario_FK` (`usv_usuario`),
  ADD KEY `usuario_veiculo_modelo_FK` (`usv_modelo`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `acao`
--
ALTER TABLE `acao`
  MODIFY `aca_codigo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `acao_produto`
--
ALTER TABLE `acao_produto`
  MODIFY `acp_codigo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `cli_codigo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `marca`
--
ALTER TABLE `marca`
  MODIFY `mac_codigo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `modelo`
--
ALTER TABLE `modelo`
  MODIFY `mod_codigo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `modelo_versao`
--
ALTER TABLE `modelo_versao`
  MODIFY `mvs_codigo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `pro_codigo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `produto_campo`
--
ALTER TABLE `produto_campo`
  MODIFY `prc_codigo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `produto_campo_tipo`
--
ALTER TABLE `produto_campo_tipo`
  MODIFY `pct_codigo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `servico`
--
ALTER TABLE `servico`
  MODIFY `ser_codigo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usu_codigo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Código de Identificação do Usuário';

--
-- AUTO_INCREMENT de tabela `usuario_acao`
--
ALTER TABLE `usuario_acao`
  MODIFY `usa_codigo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario_conta`
--
ALTER TABLE `usuario_conta`
  MODIFY `usc_codigo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario_extrato`
--
ALTER TABLE `usuario_extrato`
  MODIFY `use_codigo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario_nivel`
--
ALTER TABLE `usuario_nivel`
  MODIFY `usn_codigo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario_produto`
--
ALTER TABLE `usuario_produto`
  MODIFY `usp_codigo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario_servico`
--
ALTER TABLE `usuario_servico`
  MODIFY `uss_codigo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario_servico_file`
--
ALTER TABLE `usuario_servico_file`
  MODIFY `usf_codigo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario_servico_info`
--
ALTER TABLE `usuario_servico_info`
  MODIFY `usi_codigo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario_veiculo`
--
ALTER TABLE `usuario_veiculo`
  MODIFY `usv_codigo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `acao`
--
ALTER TABLE `acao`
  ADD CONSTRAINT `acao_ibfk_1` FOREIGN KEY (`cliente_cli_codigo`) REFERENCES `cliente` (`cli_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `acao_ibfk_2` FOREIGN KEY (`usuario_usu_codigo`) REFERENCES `usuario` (`usu_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `acao_produto`
--
ALTER TABLE `acao_produto`
  ADD CONSTRAINT `acao_produto_ibfk_1` FOREIGN KEY (`acao_aca_codigo`) REFERENCES `acao` (`aca_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `acao_produto_ibfk_2` FOREIGN KEY (`produto_pro_codigo`) REFERENCES `produto` (`pro_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `modelo`
--
ALTER TABLE `modelo`
  ADD CONSTRAINT `modelo_marca_FK` FOREIGN KEY (`mod_marca`) REFERENCES `marca` (`mac_codigo`);

--
-- Limitadores para a tabela `modelo_versao`
--
ALTER TABLE `modelo_versao`
  ADD CONSTRAINT `modelo_versao_modelo_FK` FOREIGN KEY (`mvs_modelo`) REFERENCES `modelo` (`mod_codigo`);

--
-- Limitadores para a tabela `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `produto_cliente_FK` FOREIGN KEY (`pro_cliente`) REFERENCES `cliente` (`cli_codigo`);

--
-- Limitadores para a tabela `produto_campo`
--
ALTER TABLE `produto_campo`
  ADD CONSTRAINT `produto_campo_ibfk_1` FOREIGN KEY (`produto_campo_tipo_pct_codigo`) REFERENCES `produto_campo_tipo` (`pct_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `produto_campo_ibfk_2` FOREIGN KEY (`produto_pro_codigo`) REFERENCES `produto` (`pro_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_cliente_FK` FOREIGN KEY (`usu_cliente`) REFERENCES `cliente` (`cli_codigo`),
  ADD CONSTRAINT `usuario_usuario_nivel_FK` FOREIGN KEY (`usu_nivel`) REFERENCES `usuario_nivel` (`usn_codigo`);

--
-- Limitadores para a tabela `usuario_acao`
--
ALTER TABLE `usuario_acao`
  ADD CONSTRAINT `usuario_acao_ibfk_1` FOREIGN KEY (`acao_aca_codigo`) REFERENCES `acao` (`aca_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `usuario_acao_ibfk_2` FOREIGN KEY (`usuario_usu_codigo`) REFERENCES `usuario` (`usu_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `usuario_conta`
--
ALTER TABLE `usuario_conta`
  ADD CONSTRAINT `usuario_conta_ibfk_1` FOREIGN KEY (`usuario_usu_codigo`) REFERENCES `usuario` (`usu_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `usuario_extrato`
--
ALTER TABLE `usuario_extrato`
  ADD CONSTRAINT `usuario_extrato_ibfk_1` FOREIGN KEY (`usuario_conta_usc_codigo`) REFERENCES `usuario_conta` (`usc_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `usuario_produto`
--
ALTER TABLE `usuario_produto`
  ADD CONSTRAINT `usuario_produto_ibfk_1` FOREIGN KEY (`produto_pro_codigo`) REFERENCES `produto` (`pro_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `usuario_produto_ibfk_2` FOREIGN KEY (`usuario_usu_codigo`) REFERENCES `usuario` (`usu_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `usuario_produto_ibfk_3` FOREIGN KEY (`produto_campo_prc_codigo`) REFERENCES `produto_campo` (`prc_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `usuario_servico`
--
ALTER TABLE `usuario_servico`
  ADD CONSTRAINT `usuario_servico_ibfk_1` FOREIGN KEY (`cliente_cli_codigo`) REFERENCES `cliente` (`cli_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `usuario_servico_ibfk_2` FOREIGN KEY (`usuario_usu_codigo`) REFERENCES `usuario` (`usu_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `usuario_servico_ibfk_3` FOREIGN KEY (`usuario_usu_codigo`) REFERENCES `usuario` (`usu_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `usuario_servico_file`
--
ALTER TABLE `usuario_servico_file`
  ADD CONSTRAINT `usuario_servico_file_ibfk_1` FOREIGN KEY (`usuario_servico_uss_codigo`) REFERENCES `usuario_servico` (`uss_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `usuario_servico_info`
--
ALTER TABLE `usuario_servico_info`
  ADD CONSTRAINT `usuario_servico_info_ibfk_1` FOREIGN KEY (`usuario_servico_uss_codigo`) REFERENCES `usuario_servico` (`uss_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `usuario_veiculo`
--
ALTER TABLE `usuario_veiculo`
  ADD CONSTRAINT `usuario_veiculo_marca_FK` FOREIGN KEY (`usv_marca`) REFERENCES `marca` (`mac_codigo`),
  ADD CONSTRAINT `usuario_veiculo_modelo_FK` FOREIGN KEY (`usv_modelo`) REFERENCES `modelo` (`mod_codigo`),
  ADD CONSTRAINT `usuario_veiculo_modelo_versao_FK` FOREIGN KEY (`usv_versao`) REFERENCES `modelo_versao` (`mvs_codigo`),
  ADD CONSTRAINT `usuario_veiculo_usuario_FK` FOREIGN KEY (`usv_usuario`) REFERENCES `usuario` (`usu_codigo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
