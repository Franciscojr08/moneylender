CREATE TABLE psa_pessoa
(
    psa_id               SMALLINT unsigned PRIMARY KEY auto_increment,
    psa_nome             VARCHAR(100) NOT NULL,
    psa_cpf              varchar(11)  NULL,
    psa_logradouro       VARCHAR(100) NULL,
    psa_bairro           VARCHAR(50)  NULL,
    psa_cidade           VARCHAR(50)  NULL,
    psa_estado           VARCHAR(50)  NULL,
    psa_complemento      VARCHAR(100) NULL,
    psa_telefone         varchar(11)  NULL,
    psa_email            VARCHAR(50)  NULL,
    psa_indicado         TINYINT(1) DEFAULT 2,
    psa_nome_indicador   VARCHAR(50)  NULL,
    psa_tipo             TINYINT(1) DEFAULT 1,
    psa_data_cadastro    DATE         NOT NULL,
    psa_data_atualizacao DATE         NULL
);

CREATE TABLE emo_emprestimo
(
    emo_id                      SMALLINT unsigned PRIMARY KEY auto_increment,
    psa_id                      SMALLINT unsigned not null,
    emo_valor                   DECIMAL(11, 2)    NOT NULL,
    emo_valor_pago              DECIMAL(11, 2)    NULL,
    emo_valor_devido            DECIMAL(11, 2)    NULL,
    emo_taxa_juros              DECIMAL(11, 2)    NULL,
    emo_valor_juros             DECIMAL(11, 2)    NULL,
    emo_data_emprestimo         DATE              NOT NULL,
    emo_pagamento_parcelado     TINYINT(1) DEFAULT 2,
    emo_data_previsao_pagamento DATE              NULL,
    emo_data_pagamento          DATE              NULL,
    emo_situacao                TINYINT(4)        NOT NULL,
    emo_data_cadastro           DATE              NOT NULL,
    emo_data_atualizacao        DATE              NULL,
    emo_cancelado               TINYINT(1) DEFAULT 2
);

ALTER TABLE emo_emprestimo
    add constraint fk_emo_psa1 foreign key (psa_id) references psa_pessoa (psa_id) ON DELETE CASCADE;

CREATE TABLE pra_parcela
(
    pra_id                      SMALLINT unsigned PRIMARY KEY auto_increment,
    emo_id                      SMALLINT unsigned NOT NULL,
    pra_valor                   DECIMAL(11, 2)    NOT NULL,
    pra_valor_pago              DECIMAL(11, 2)    NULL,
    pra_valor_devido            DECIMAL(11, 2)    NULL,
    pra_data_previsao_pagamento DATE              NOT NULL,
    pra_situacao                TINYINT(1)        NOT NULL,
    pra_sequencia_parcela       SMALLINT unsigned NOT NULL,
    pra_data_cadastro           DATE              NOT NULL,
    pra_data_atualizacao        DATE              NULL
);

ALTER TABLE pra_parcela
    ADD CONSTRAINT fk_pra_emo1 FOREIGN KEY (emo_id) REFERENCES emo_emprestimo (emo_id);

CREATE TABLE pgo_pagamento
(
    pgo_id              SMALLINT unsigned PRIMARY KEY auto_increment,
    pgo_valor           DECIMAL(11, 2) NOT NULL,
    pgo_forma_pagamento tinyint(1)     NOT NULL,
    pgo_data_pagamento  DATE           NOT NULL
);

CREATE TABLE pgm_pagamento_emprestimo
(
    pgm_id SMALLINT unsigned PRIMARY KEY auto_increment,
    pgo_id SMALLINT unsigned NOT NULL,
    emo_id SMALLINT unsigned NOT NULL,
    pra_id SMALLINT unsigned NULL
);

ALTER TABLE pgm_pagamento_emprestimo
    ADD CONSTRAINT fk_pgm_pgo1 FOREIGN KEY (pgo_id) REFERENCES pgo_pagamento (pgo_id);
ALTER TABLE pgm_pagamento_emprestimo
    ADD CONSTRAINT fk_pgm_emo1 FOREIGN KEY (emo_id) REFERENCES emo_emprestimo (emo_id);
ALTER TABLE pgm_pagamento_emprestimo
    ADD CONSTRAINT fk_pgm_pra1 FOREIGN KEY (pra_id) REFERENCES pra_parcela (pra_id);