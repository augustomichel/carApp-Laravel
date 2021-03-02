CREATE TABLE produto_campo_tipo (
  pct_codigo INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  pct_descricao VARCHAR(30) NULL,
  pct_tamanho INTEGER UNSIGNED NULL,
  PRIMARY KEY(pct_codigo)
);

CREATE TABLE usuario_nivel (
  usn_codigo INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  usn_descricao VARCHAR(150) NULL,
  usn_status CHAR(1) NULL DEFAULT 1,
  PRIMARY KEY(usn_codigo)
);

CREATE TABLE cliente (
  cli_codigo INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  cli_nome VARCHAR(150) NULL,
  cli_cnp VARCHAR(30) NULL,
  cli_status CHAR(1) DEFAULT 1,
  cli_token VARCHAR(255) NULL,
  cli_datetime DATETIME NULL,
  PRIMARY KEY(cli_codigo)
);

CREATE TABLE usuario (
  usu_codigo INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  usuario_nivel_usn_codigo INTEGER UNSIGNED NOT NULL,
  cliente_cli_codigo INTEGER UNSIGNED NOT NULL,
  cli_codigo INTEGER UNSIGNED NOT NULL,
  usn_codigo INTEGER UNSIGNED NULL,
  usu_nome VARCHAR(150) NULL,
  usu_email VARCHAR(150) NULL,
  usu_senha VARCHAR(255) NULL,
  usu_status CHAR(1) NULL,
  usu_token VARCHAR(255) NULL,
  usu_datetime INTEGER UNSIGNED NULL,
  PRIMARY KEY(usu_codigo),
  INDEX usuario_FKIndex1(cliente_cli_codigo),
  INDEX usuario_FKIndex2(usuario_nivel_usn_codigo),
  FOREIGN KEY(cliente_cli_codigo)
    REFERENCES cliente(cli_codigo)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(usuario_nivel_usn_codigo)
    REFERENCES usuario_nivel(usn_codigo)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE acao (
  aca_codigo INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  usuario_usu_codigo INTEGER UNSIGNED NOT NULL,
  cliente_cli_codigo INTEGER UNSIGNED NOT NULL,
  cli_codigo INTEGER UNSIGNED NULL,
  usu_codigo INTEGER UNSIGNED NULL,
  aca_descricao VARCHAR(150) NULL,
  aca_status CHAR(1) NULL,
  aca_qtd_pontos INTEGER UNSIGNED NULL,
  aca_datetime INTEGER UNSIGNED NULL,
  PRIMARY KEY(aca_codigo),
  INDEX acao_FKIndex1(cliente_cli_codigo),
  INDEX acao_FKIndex2(usuario_usu_codigo),
  FOREIGN KEY(cliente_cli_codigo)
    REFERENCES cliente(cli_codigo)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(usuario_usu_codigo)
    REFERENCES usuario(usu_codigo)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE produto (
  pro_codigo INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  cliente_cli_codigo INTEGER UNSIGNED NOT NULL,
  cli_codigo INTEGER UNSIGNED NULL,
  pro_nome VARCHAR(150) NULL,
  pro_status CHAR(1) NULL,
  pro_datetime DATETIME NULL,
  PRIMARY KEY(pro_codigo),
  INDEX produto_FKIndex2(cliente_cli_codigo),
  FOREIGN KEY(cliente_cli_codigo)
    REFERENCES cliente(cli_codigo)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE acao_produto (
  acp_codigo INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  produto_pro_codigo INTEGER UNSIGNED NOT NULL,
  acao_aca_codigo INTEGER UNSIGNED NOT NULL,
  aca_codigo INTEGER UNSIGNED NULL,
  pro_codigo INTEGER UNSIGNED NULL,
  acp_datetime INTEGER UNSIGNED NULL,
  PRIMARY KEY(acp_codigo),
  INDEX acao_prodtuto_FKIndex1(acao_aca_codigo),
  INDEX acao_prodtuto_FKIndex2(produto_pro_codigo),
  FOREIGN KEY(acao_aca_codigo)
    REFERENCES acao(aca_codigo)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(produto_pro_codigo)
    REFERENCES produto(pro_codigo)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE produto_campo (
  prc_codigo INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  produto_pro_codigo INTEGER UNSIGNED NOT NULL,
  produto_campo_tipo_pct_codigo INTEGER UNSIGNED NOT NULL,
  pro_codigo INTEGER UNSIGNED NULL,
  pct_codigo INTEGER UNSIGNED NULL,
  prc_nome VARCHAR(50) NULL,
  prc_status CHAR(1) NULL,
  prc_datetime DATETIME NULL,
  PRIMARY KEY(prc_codigo),
  INDEX produto_campo_FKIndex1(produto_campo_tipo_pct_codigo),
  INDEX produto_campo_FKIndex2(produto_pro_codigo),
  FOREIGN KEY(produto_campo_tipo_pct_codigo)
    REFERENCES produto_campo_tipo(pct_codigo)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(produto_pro_codigo)
    REFERENCES produto(pro_codigo)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE usuario_acao (
  usa_codigo INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  usuario_usu_codigo INTEGER UNSIGNED NOT NULL,
  acao_aca_codigo INTEGER UNSIGNED NOT NULL,
  usu_codigo INTEGER UNSIGNED NULL,
  aca_codigo INTEGER UNSIGNED NULL,
  usa_datetime DATETIME NULL,
  PRIMARY KEY(usa_codigo),
  INDEX usuario_acao_FKIndex1(acao_aca_codigo),
  INDEX usuario_acao_FKIndex2(usuario_usu_codigo),
  FOREIGN KEY(acao_aca_codigo)
    REFERENCES acao(aca_codigo)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(usuario_usu_codigo)
    REFERENCES usuario(usu_codigo)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE usuario_conta (
  usc_codigo INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  usuario_usu_codigo INTEGER UNSIGNED NOT NULL,
  usu_codigo INTEGER UNSIGNED NULL,
  usc_saldo INTEGER UNSIGNED NULL DEFAULT 0,
  usc_datetime DATETIME NULL,
  PRIMARY KEY(usc_codigo),
  INDEX usuario_conta_FKIndex1(usuario_usu_codigo),
  FOREIGN KEY(usuario_usu_codigo)
    REFERENCES usuario(usu_codigo)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE usuario_extrato (
  use_codigo INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  usuario_conta_usc_codigo INTEGER UNSIGNED NOT NULL,
  usc_codigo INTEGER UNSIGNED NULL,
  use_tipo CHAR(1) DEFAULT 1,
  use_descricao VARCHAR(150) NULL,
  use_valor INTEGER UNSIGNED NULL DEFAULT 0,
  PRIMARY KEY(use_codigo),
  INDEX usuario_extrato_FKIndex1(usuario_conta_usc_codigo),
  FOREIGN KEY(usuario_conta_usc_codigo)
    REFERENCES usuario_conta(usc_codigo)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE usuario_servico (
  uss_codigo INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  usuario_usu_codigo INTEGER UNSIGNED NOT NULL,
  cliente_cli_codigo INTEGER UNSIGNED NOT NULL,
  cli_codigo INTEGER UNSIGNED NULL,
  usu_codigo_solicitante INTEGER UNSIGNED NULL,
  usu_codigo_executor INTEGER UNSIGNED NULL,
  pro_codigo INTEGER UNSIGNED NULL,
  uss_observacao TEXT NULL,
  uss_status INTEGER UNSIGNED NULL DEFAULT 1,
  uss_datetime_entrega DATETIME NULL,
  uss_datetime_inicio DATETIME NULL,
  uss_datetime_finalizacao DATETIME NULL,
  uss_descricao_avaliacao TEXT NULL,
  uss_datetime_avaliacao DATETIME NULL,
  uss_datetime DATETIME NULL,
  PRIMARY KEY(uss_codigo),
  INDEX usuario_servico_FKIndex1(cliente_cli_codigo),
  INDEX usuario_servico_FKIndex2(usuario_usu_codigo),
  INDEX usuario_servico_FKIndex3(usuario_usu_codigo),
  FOREIGN KEY(cliente_cli_codigo)
    REFERENCES cliente(cli_codigo)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(usuario_usu_codigo)
    REFERENCES usuario(usu_codigo)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(usuario_usu_codigo)
    REFERENCES usuario(usu_codigo)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE usuario_produto (
  usp_codigo INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  produto_campo_prc_codigo INTEGER UNSIGNED NOT NULL,
  usuario_usu_codigo INTEGER UNSIGNED NOT NULL,
  produto_pro_codigo INTEGER UNSIGNED NOT NULL,
  pro_codigo INTEGER UNSIGNED NULL,
  usu_codigo INTEGER UNSIGNED NULL,
  prc_codigo INTEGER UNSIGNED NULL,
  usp_valor DOUBLE(10,2) NULL,
  usp_datetime DATETIME NULL,
  PRIMARY KEY(usp_codigo),
  INDEX usuario_produto_FKIndex1(produto_pro_codigo),
  INDEX usuario_produto_FKIndex2(usuario_usu_codigo),
  INDEX usuario_produto_FKIndex3(produto_campo_prc_codigo),
  FOREIGN KEY(produto_pro_codigo)
    REFERENCES produto(pro_codigo)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(usuario_usu_codigo)
    REFERENCES usuario(usu_codigo)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(produto_campo_prc_codigo)
    REFERENCES produto_campo(prc_codigo)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE usuario_servico_file (
  usf_codigo INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  usuario_servico_uss_codigo INTEGER UNSIGNED NOT NULL,
  uss_codigo INTEGER UNSIGNED NULL,
  usf_blob BLOB NULL,
  usf_type VARCHAR(255) NULL,
  usf_deletado CHAR(1) NULL DEFAULT 0,
  usf_datetime DATETIME NULL,
  PRIMARY KEY(usf_codigo),
  INDEX usuario_servico_file_FKIndex1(usuario_servico_uss_codigo),
  FOREIGN KEY(usuario_servico_uss_codigo)
    REFERENCES usuario_servico(uss_codigo)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE usuario_servico_info (
  usi_codigo INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  usuario_servico_uss_codigo INTEGER UNSIGNED NOT NULL,
  uss_codigo INTEGER UNSIGNED NULL,
  usi_descricao TEXT NULL,
  usu_codigo INTEGER UNSIGNED NULL,
  usi_deletado CHAR(1) DEFAULT 0,
  usi_datetime DATETIME NULL,
  PRIMARY KEY(usi_codigo),
  INDEX usuario_servico_info_FKIndex1(usuario_servico_uss_codigo),
  FOREIGN KEY(usuario_servico_uss_codigo)
    REFERENCES usuario_servico(uss_codigo)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);
