CREATE TABLE cle_cliente
(
    cle_id             SMALLINT unsigned PRIMARY KEY auto_increment,
    cle_nome           VARCHAR(100) NOT NULL,
    cle_cpf            INT          NULL,
    cle_logradouro     VARCHAR(100) NULL,
    cle_bairro         VARCHAR(50)  NULL,
    cle_cidade         VARCHAR(50)  NULL,
    cle_estado         VARCHAR(50)  NULL,
    cle_complemento    VARCHAR(100) NULL,
    cle_telefone       INT          NULL,
    cle_email          VARCHAR(50)  NULL,
    cle_indicado       TINYINT(1) DEFAULT 2,
    cle_nome_indicador VARCHAR(50)  NULL
);

CREATE TABLE emo_emprestimo
(
    emo_id                  SMALLINT unsigned PRIMARY KEY auto_increment,
    emo_valor               FLOAT      NOT NULL,
    emo_valor_pago          FLOAT      NULL,
    emo_valor_devido        FLOAT      NULL,
    emo_taxa_juros          FLOAT      NULL,
    emo_data_emprestimo     DATE       NOT NULL,
    emo_pagamento_parcelado TINYINT(1) DEFAULT 2,
    emo_data_pagamento      DATE       NULL,
    emo_situacao            TINYINT(4) NOT NULL
);

CREATE TABLE clo_cliente_empresimo
(
    clo_id SMALLINT unsigned PRIMARY KEY auto_increment,
    cle_id SMALLINT unsigned NOT NULL,
    emo_id SMALLINT unsigned NOT NULL
);

ALTER TABLE clo_cliente_empresimo
    ADD CONSTRAINT fk_clo_cle1 FOREIGN KEY (cle_id) REFERENCES cle_cliente (cle_id);
ALTER TABLE clo_cliente_empresimo
    ADD CONSTRAINT fk_clo_emo1 FOREIGN KEY (emo_id) REFERENCES emo_emprestimo (emo_id);

CREATE TABLE rco_recibo
(
    rco_id                  SMALLINT unsigned PRIMARY KEY auto_increment,
    cle_id                  SMALLINT unsigned NOT NULL,
    emo_id                  SMALLINT unsigned NOT NULL,
    rco_data_geracao_recibo date              NOT NULL
);

ALTER TABLE rco_recibo
    ADD CONSTRAINT fk_rco_cle1 FOREIGN KEY (cle_id) REFERENCES cle_cliente (cle_id);
ALTER TABLE rco_recibo
    ADD CONSTRAINT fk_rco_emo1 FOREIGN KEY (emo_id) REFERENCES emo_emprestimo (emo_id);

CREATE TABLE pra_parcela
(
    pra_id            SMALLINT unsigned PRIMARY KEY auto_increment,
    emo_id            SMALLINT unsigned NOT NULL,
    pra_valor         FLOAT             NOT NULL,
    pra_valor_pago    FLOAT             NULL,
    pra_valor_devido  FLOAT             NULL,
    pra_data_cadastro DATE              NOT NULL,
    pra_siuacao       TINYINT(4)        NOT NULL
);

ALTER TABLE pra_parcela
    ADD CONSTRAINT fk_pra_emo1 FOREIGN KEY (emo_id) REFERENCES emo_emprestimo (emo_id);

CREATE TABLE pgo_pagamento
(
    pgo_id             SMALLINT unsigned PRIMARY KEY auto_increment,
    pgo_valor          FLOAT   NOT NULL,
    pgo_data_pagamento DATE    NOT NULL,
    pgo_forma_pagamento tinyint NOT NULL
);

CREATE TABLE pgm_pagamento_emprestimo
(
    pgm_id SMALLINT unsigned PRIMARY KEY auto_increment,
    pgo_id SMALLINT unsigned NOT NULL,
    emo_id SMALLINT unsigned NOT NULL,
    pra_id SMALLINT unsigned NOT NULL
);

ALTER TABLE pgm_pagamento_emprestimo
    ADD CONSTRAINT fk_pgm_pgo1 FOREIGN KEY (pgo_id) REFERENCES pgo_pagamento (pgo_id);
ALTER TABLE pgm_pagamento_emprestimo
    ADD CONSTRAINT fk_pgm_emo1 FOREIGN KEY (emo_id) REFERENCES emo_emprestimo (emo_id);
ALTER TABLE pgm_pagamento_emprestimo
    ADD CONSTRAINT fk_pgm_pra1 FOREIGN KEY (pra_id) REFERENCES pra_parcela (pra_id);