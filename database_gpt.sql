PRAGMA foreign_keys = ON;

-- =========================
-- TABELAS AUXILIARES BÁSICAS
-- =========================

CREATE TABLE IF NOT EXISTS locais (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT NOT NULL,
    tipo TEXT,          -- laboratorio, divisao, transporte, almoxarifado, etc.
    referencia TEXT,    -- código interno
    descricao TEXT,
    contato TEXT,
    endereco TEXT
);
CREATE INDEX IF NOT EXISTS idx_locais_nome ON locais(nome);

CREATE TABLE IF NOT EXISTS laboratorios (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT NOT NULL,
    rbc_codigo TEXT,
    endereco TEXT,
    contato TEXT,
    observacoes TEXT
);
CREATE INDEX IF NOT EXISTS idx_laboratorios_nome ON laboratorios(nome);

CREATE TABLE IF NOT EXISTS contratos_servico (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    fornecedor TEXT,
    numero_contrato TEXT,
    vigencia_inicio DATE,
    vigencia_fim DATE,
    descricao TEXT
);

CREATE TABLE IF NOT EXISTS solicitacoes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    solicitante TEXT,
    tipo_servico TEXT,
    data_solicitacao DATE,
    descricao TEXT,
    status TEXT
);

-- tabela de transportes (informações de empresas/motoristas/cte)
CREATE TABLE IF NOT EXISTS transportes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    transportadora TEXT,
    motorista TEXT,
    documento_transporte TEXT,   -- CTE, nota, referência
    veiculo TEXT,
    contato TEXT,
    observacoes TEXT
);
CREATE INDEX IF NOT EXISTS idx_transportes_transportadora ON transportes(transportadora);

-- =========================
-- TABELAS PRINCIPAIS
-- =========================

CREATE TABLE IF NOT EXISTS equipamentos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    categoria_metrologica TEXT,
    tipo TEXT,
    fabricante TEXT,
    modelo TEXT,
    numero_serie TEXT,
    codigo_interno TEXT NOT NULL UNIQUE,
    descricao TEXT,
    local_dotacao_id INTEGER,        -- FK -> locais(id)
    localizacao_atual_id INTEGER,    -- FK -> locais(id)
    classe_exatidao TEXT,
    resolucao TEXT,
    intervalo_medicao_min REAL,
    intervalo_medicao_max REAL,
    cond_temp_operacao TEXT,
    cond_umidade_operacao TEXT,
    cond_ambiente_restricoes TEXT,
    criticidade_equipamento TEXT,
    intervalo_calibracao_meses INTEGER,
    justificativa_intervalo TEXT,
    proxima_calibracao_prevista DATE,
    custo_previsto_calibracao REAL,  -- valores monetários: REAL (ou NUMERIC se preferir)
    bloqueado_para_uso INTEGER DEFAULT 0,
    motivo_bloqueio TEXT,
    responsavel_tecnico TEXT,
    responsavel_cadastramento TEXT,
    observacoes_auditoria TEXT,
    data_cadastro DATE DEFAULT (DATE('now')),
    ultima_atualizacao DATE,
    FOREIGN KEY (local_dotacao_id) REFERENCES locais(id),
    FOREIGN KEY (localizacao_atual_id) REFERENCES locais(id)
);
CREATE INDEX IF NOT EXISTS idx_equip_codint ON equipamentos(codigo_interno);

CREATE TABLE IF NOT EXISTS padroes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT NOT NULL,
    modelo TEXT,
    fabricante TEXT,
    numero_serie TEXT,
    rbc_codigo_laboratorio TEXT,
    validade_certificado DATE,
    arquivo_certificado_pdf TEXT,
    arquivo_sha256 TEXT
);

CREATE TABLE IF NOT EXISTS equipamento_padroes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    equipamento_id INTEGER NOT NULL,
    padrao_id INTEGER NOT NULL,
    observacoes TEXT,
    FOREIGN KEY (equipamento_id) REFERENCES equipamentos(id),
    FOREIGN KEY (padrao_id) REFERENCES padroes(id)
);
CREATE INDEX IF NOT EXISTS idx_equip_padroes ON equipamento_padroes(equipamento_id);

CREATE TABLE IF NOT EXISTS equipamento_documentos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    equipamento_id INTEGER NOT NULL,
    tipo_documento TEXT NOT NULL,
    arquivo_path TEXT NOT NULL,
    arquivo_sha256 TEXT,
    doc_versao TEXT,
    doc_data_emissao DATE,
    doc_data_revisao DATE,
    doc_emissor TEXT,
    doc_revisador TEXT,
    doc_status TEXT,
    doc_referencia_interna TEXT,
    doc_vinculo_normativo TEXT,
    data_upload DATE DEFAULT (DATE('now')),
    FOREIGN KEY (equipamento_id) REFERENCES equipamentos(id)
);
CREATE INDEX IF NOT EXISTS idx_documentos_equip ON equipamento_documentos(equipamento_id);

CREATE TABLE IF NOT EXISTS manutencoes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    equipamento_id INTEGER NOT NULL,
    tipo TEXT,
    descricao TEXT,
    data_manutencao DATE,
    responsavel TEXT,
    arquivo_relatorio_pdf TEXT,
    arquivo_sha256 TEXT,
    FOREIGN KEY (equipamento_id) REFERENCES equipamentos(id)
);
CREATE INDEX IF NOT EXISTS idx_manutencoes_equip ON manutencoes(equipamento_id);

CREATE TABLE IF NOT EXISTS condicoes_ambientais (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    equipamento_id INTEGER NOT NULL,
    data_registro DATE,
    temperatura REAL,
    umidade REAL,
    observacoes TEXT,
    FOREIGN KEY (equipamento_id) REFERENCES equipamentos(id)
);

CREATE TABLE IF NOT EXISTS auditoria (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    usuario TEXT,
    acao TEXT,
    entidade TEXT,
    entidade_id INTEGER,
    data_evento DATETIME DEFAULT (datetime('now')),
    detalhes TEXT
);

-- =========================
-- CRONOGRAMA / ESTÁGIOS
-- =========================

CREATE TABLE IF NOT EXISTS cronograma_estagios (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    equipamento_id INTEGER NOT NULL,
    nome_estagio TEXT NOT NULL,
    data_inicio DATE,
    data_fim DATE,
    responsavel_id INTEGER,
    observacoes TEXT,
    FOREIGN KEY (equipamento_id) REFERENCES equipamentos(id)
);
CREATE INDEX IF NOT EXISTS idx_cronograma_equip ON cronograma_estagios(equipamento_id);

-- =========================
-- LOTES
-- =========================

CREATE TABLE IF NOT EXISTS lotes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    contrato_servico_id INTEGER,
    laboratorio_id INTEGER,
    transporte_id INTEGER,            -- FK -> transportes.id (opcional para todo o lote)
    descricao TEXT,
    data_envio_lote DATE,
    data_recebimento_laboratorio DATE,
    data_retorno_prevista DATE,
    data_retorno_recebida DATE,
    relatorio_envio TEXT,
    relatorio_recebimento TEXT,
    observacoes TEXT,
    FOREIGN KEY (contrato_servico_id) REFERENCES contratos_servico(id),
    FOREIGN KEY (laboratorio_id) REFERENCES laboratorios(id),
    FOREIGN KEY (transporte_id) REFERENCES transportes(id)
);
CREATE INDEX IF NOT EXISTS idx_lotes_contrato ON lotes(contrato_servico_id);
CREATE INDEX IF NOT EXISTS idx_lotes_lab ON lotes(laboratorio_id);

CREATE TABLE IF NOT EXISTS lote_equipamentos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    lote_id INTEGER NOT NULL,
    equipamento_id INTEGER NOT NULL,
    observacoes TEXT,
    FOREIGN KEY (lote_id) REFERENCES lotes(id),
    FOREIGN KEY (equipamento_id) REFERENCES equipamentos(id)
);
CREATE INDEX IF NOT EXISTS idx_lote_equipamentos_lote ON lote_equipamentos(lote_id);
CREATE INDEX IF NOT EXISTS idx_lote_equipamentos_equip ON lote_equipamentos(equipamento_id);

-- =========================
-- LOGÍSTICA: tabelas e eventos
-- =========================

-- logistica_et: tabela resumida/operacional (mantida para compatibilidade e resumos)
CREATE TABLE IF NOT EXISTS logistica_et (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    lote_id INTEGER,                   -- vincula ao lote se aplicável
    equipamento_id INTEGER,            -- vincula a equipamento se for logistica individual
    calibracao_id INTEGER,             -- opcional: vincula a uma calibracao específica
    solicitacao_id INTEGER,
    transporte_id INTEGER,
    data_recebimento_et DATE,
    relatorio_recebimento_et TEXT,
    responsavel_et INTEGER,
    data_recebimento_transporte DATE,      -- padrão herdado do lote, pode ser sobrescrito
    relatorio_recebimento_transporte TEXT,
    data_recebimento_concluido_et DATE,
    relatorio_recebimento_concluido_et TEXT,
    data_recebimento_divisao DATE,
    relatorio_recebimento_divisao TEXT,
    responsavel_divisao INTEGER,
    observacoes TEXT,
    FOREIGN KEY (lote_id) REFERENCES lotes(id),
    FOREIGN KEY (equipamento_id) REFERENCES equipamentos(id),
    FOREIGN KEY (calibracao_id) REFERENCES calibracoes(id),
    FOREIGN KEY (solicitacao_id) REFERENCES solicitacoes(id),
    FOREIGN KEY (transporte_id) REFERENCES transportes(id)
);
CREATE INDEX IF NOT EXISTS idx_logisticaet_lote ON logistica_et(lote_id);
CREATE INDEX IF NOT EXISTS idx_logisticaet_equip ON logistica_et(equipamento_id);

-- eventos logísticos (modelo recomendado: herança e sobrescrita)
CREATE TABLE IF NOT EXISTS logistica_eventos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    lote_id INTEGER,           -- evento associado ao lote (padrão)
    equipamento_id INTEGER,    -- evento específico do equipamento (sobrescreve/compl.)
    calibracao_id INTEGER,     -- evento relativo a uma calibracao específica
    tipo_evento TEXT NOT NULL, -- ex: envio_transporte, recebimento_transporte, recebimento_et, entrega_divisao, retorno
    data_evento DATE,
    responsavel_id INTEGER,
    transporte_id INTEGER,     -- FK -> transportes.id (se relevante para o evento)
    relatorio TEXT,
    observacoes TEXT,
    created_at DATETIME DEFAULT (datetime('now')),
    FOREIGN KEY (lote_id) REFERENCES lotes(id),
    FOREIGN KEY (equipamento_id) REFERENCES equipamentos(id),
    FOREIGN KEY (calibracao_id) REFERENCES calibracoes(id),
    FOREIGN KEY (transporte_id) REFERENCES transportes(id)
);
CREATE INDEX IF NOT EXISTS idx_log_evt_lote ON logistica_eventos(lote_id);
CREATE INDEX IF NOT EXISTS idx_log_evt_equip ON logistica_eventos(equipamento_id);
CREATE INDEX IF NOT EXISTS idx_log_evt_calibr ON logistica_eventos(calibracao_id);

-- =========================
-- CALIBRAÇÕES (ajustada)
-- =========================

CREATE TABLE IF NOT EXISTS calibracoes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    equipamento_id INTEGER NOT NULL,
    data_calibracao DATE NOT NULL,
    laboratorio_id INTEGER,                 -- FK -> laboratorios(id)
    rbc_codigo_laboratorio TEXT,
    rbc_metodo_calibracao TEXT,
    rbc_incerteza_prevista TEXT,
    rbc_capacidade_medicao TEXT,
    conformidade_ilac_p14 INTEGER,          -- 0/1
    status TEXT,
    estagio_cronograma_id INTEGER,          -- FK -> cronograma_estagios(id)
    localizacao_atual_id INTEGER,           -- FK -> locais(id)
    observacoes TEXT,
    solicitacao_id INTEGER,                 -- FK -> solicitacoes(id)
    logistica_et_id INTEGER,                -- FK -> logistica_et(id) (resumo)
    contrato_servico_id INTEGER,            -- FK -> contratos_servico(id)
    lote_id INTEGER,                        -- FK -> lotes(id)  <-- solicitado: calibrações podem ter lote
    arquivo_certificado_pdf TEXT,
    arquivo_sha256 TEXT,
    proxima_calibracao_sugerida DATE,
    data_registro DATE DEFAULT (DATE('now')),
    FOREIGN KEY (equipamento_id) REFERENCES equipamentos(id),
    FOREIGN KEY (laboratorio_id) REFERENCES laboratorios(id),
    FOREIGN KEY (estagio_cronograma_id) REFERENCES cronograma_estagios(id),
    FOREIGN KEY (localizacao_atual_id) REFERENCES locais(id),
    FOREIGN KEY (solicitacao_id) REFERENCES solicitacoes(id),
    FOREIGN KEY (logistica_et_id) REFERENCES logistica_et(id),
    FOREIGN KEY (contrato_servico_id) REFERENCES contratos_servico(id),
    FOREIGN KEY (lote_id) REFERENCES lotes(id)
);
CREATE INDEX IF NOT EXISTS idx_calibracoes_equip ON calibracoes(equipamento_id);
CREATE INDEX IF NOT EXISTS idx_calibracoes_lab ON calibracoes(laboratorio_id);
CREATE INDEX IF NOT EXISTS idx_calibracoes_lote ON calibracoes(lote_id);

-- =========================
-- CONSTRAINTS / OBSERVAÇÕES
-- =========================

-- Nota: se estiver atualizando um DB existente, use ALTER TABLE para adicionar colunas.
-- SQLite permite: ALTER TABLE <table> ADD COLUMN <col-definition>;
-- Mas não suporta DROP COLUMN ou ADD FOREIGN KEY diretamente em todas versões.
-- Para mudanças complexas (remover/renomear colunas), siga procedimento de copiar para tabela nova.

