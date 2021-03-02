CREATE TABLE servico (
  ser_codigo int(10) unsigned NOT NULL AUTO_INCREMENT,
  ser_descricao varchar(255) NOT NULL,
  ser_tipo_servico int(10) unsigned NOT NULL,
  ser_time_execucao int(10) NOT NULL,
  ser_status char(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (ser_codigo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4

ALTER TABLE servico ADD ser_cliente int(10) unsigned NOT NULL;
ALTER TABLE servico CHANGE ser_cliente ser_cliente int(10) unsigned NOT NULL AFTER ser_codigo;
