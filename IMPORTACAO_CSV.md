# Importação de Dados do CSV de Calibração

## Resumo

Análise e importação de dados do arquivo `calibracao.csv` contendo 484 equipamentos com 67 colunas.

## Dados do CSV

### Estrutura Identificada

- **Total de registros**: 484 equipamentos
- **Total de colunas**: 67
- **Headers**: Linha 3 (primeiras 2 linhas são cabeçalhos agrupados)

### Mapeamento de Colunas

| Coluna | Campo                      | Descrição                             |
| ------ | -------------------------- | ------------------------------------- |
| 0      | equipamento_classe         | Classe do equipamento (ELE, MEC, etc) |
| 1      | equipamento_tipo           | Tipo (FONTE DC, TORQUÍMETRO, etc)     |
| 2      | equipamento_fabricante     | Fabricante                            |
| 3      | equipamento_modelo         | Modelo                                |
| 4      | equipamento_serial         | Número de série                       |
| 14     | equipamento_especificacoes | Especificações técnicas               |
| 27     | equipamento_ciclo_meses    | Ciclo de calibração (meses)           |
| 28     | equipamento_codigo_interno | Código interno único                  |
| 32     | equipamento_patrimonio     | Número de patrimônio                  |
| 50     | data_ultima_calibracao     | Data da última calibração             |
| 51     | data_validade_certificado  | Validade do certificado               |
| 53     | data_proxima_calibracao    | Próxima calibração                    |
| 56     | custo_calibracao           | Custo da calibração                   |
| 58     | status_equipamento         | Status (CALIBRADO, DESCALIBRADO)      |
| 59     | certificado_numero         | Número do certificado                 |
| 60     | laboratorio_nome           | Nome do laboratório                   |
| 63     | orcamento_valor            | Valor orçado                          |
| 66     | setor                      | Setor responsável                     |

### Exemplos de Dados

**Primeiro equipamento (linha 4)**:

```json
{
  "equipamento_classe": "ELE",
  "equipamento_tipo": "FONTE DC",
  "equipamento_fabricante": "TDK-LAMBDA",
  "equipamento_modelo": "Z1020 LAN",
  "equipamento_especificacoes": "10 V / 20 A",
  "equipamento_ciclo_meses": "12",
  "equipamento_codigo_interno": "F-21",
  "equipamento_patrimonio": "PS-CMS-2025-004",
  "data_ultima_calibracao": "03/05/23",
  "status_equipamento": "DESCALIBRADO",
  "certificado_numero": "certificado nº 2142033/2023",
  "laboratorio_nome": "CMASM",
  "setor": "CMS"
}
```

**Último equipamento (linha 583)**:

```json
{
  "equipamento_classe": "MEC",
  "equipamento_tipo": "TORQUÍMETRO",
  "equipamento_fabricante": "SNAP-ON",
  "equipamento_modelo": "45 – 265 Nm",
  "equipamento_especificacoes": "265",
  "equipamento_codigo_interno": "SEASKUA",
  "data_ultima_calibracao": "15/07/24",
  "status_equipamento": "DESCALIBRADO",
  "certificado_numero": "222175/24",
  "laboratorio_nome": "CMASM",
  "setor": "EMPRESA MV"
}
```

## Implementação

### 1. Migration - Campos Adicionados

**Arquivo**: `database/migrations/2025_11_30_000001_add_csv_fields_to_equipamentos.php`

Campos adicionados à tabela `equipamentos`:

**Dados do CSV**:

- `classe` - Classificação (ELE, MEC, etc)
- `especificacoes` - Especificações técnicas
- `patrimonio` - Número de patrimônio
- `status` - Status do equipamento
- `setor` - Setor responsável

**Dimensões Físicas**:

- `altura`, `largura`, `comprimento` (decimal)
- `tensao`, `potencia` (string)

**Documentação**:

- `manual_pdf` - Caminho do manual
- `link_fabricante` - Link do fabricante
- `instrucao_uso`, `instrucao_operacao`, `instrucao_seguranca` (text)

**Metrologia Avançada**:

- `incerteza_nominal` - Incerteza nominal
- `categoria_metrologica` - Categoria metrológica

**Financeiro**:

- `valor_aquisicao` - Valor de aquisição
- `data_aquisicao` - Data de aquisição
- `custo_estimado` - Custo estimado de calibração
- `responsavel` - Responsável pelo equipamento

**Matriz IGP (Índice de Grau de Prioridade)**:

- `frequencia_uso` (tinyint 1-3)
- `necessidade_critica` (tinyint 1-3)
- `abundancia` (tinyint 1-3)
- `criticidade_metrologica` (tinyint 1-3)
- `custo_indisponibilidade` (tinyint 1-3)
- `igp` (int) - Calculado automaticamente
- `classificacao` (enum: alta, media, baixa)

**Status**: ✅ Migration executada com sucesso

### 2. Comando de Importação

**Arquivo**: `app/Console/Commands/ImportCalibracaoCsvCommand.php`

**Assinatura**: `php artisan import:calibracao-csv {file=calibracao.csv}`

**Funcionalidades**:

- Lê arquivo CSV com 67 colunas
- Pula primeiras 3 linhas (headers)
- Mapeia dados para modelo normalizado
- Cria/atualiza equipamentos
- Cria/atualiza laboratórios
- Cria histórico de calibrações
- Vincula certificados

**Validações**:

- Tipo de equipamento obrigatório
- Limpeza de valores (#VALOR!, NULL, vazios)
- Parse de datas (DD/MM/YY e DD/MM/YYYY)
- Parse de valores decimais (vírgula → ponto)

**Tratamento de Erros**:

- Transação DB (rollback em caso de erro)
- Log de erros por linha
- Estatísticas detalhadas ao final

**Status**: 🔄 Aguardando rebuild do Docker para sincronização

### 3. Estatísticas Esperadas

Após importação completa:

- **Equipamentos**: ~484 registros
- **Laboratórios**: ~5-10 únicos (CMASM e outros)
- **Calibrações**: ~484 registros históricos
- **Classes**: ELE (elétrico), MEC (mecânico), etc

## Próximos Passos

### Imediato

1. ✅ Criar migration com campos do CSV
2. ✅ Criar comando de importação
3. 🔄 Rebuild Docker image
4. ⏳ Executar importação: `php artisan import:calibracao-csv`
5. ⏳ Validar dados importados

### Curto Prazo

1. Criar Observer para cálculo automático de IGP
2. Implementar Service para gestão de rastreabilidade
3. Expandir modelo de certificados (ISO/IEC 17025)
4. Criar dashboard com estatísticas por classe/IGP
5. Implementar filtros avançados por IGP/classificação

### Médio Prazo

1. Criar módulo Metrologia (UnidadeMedida, Grandeza, Procedimento)
2. Expandir modelo de Calibração (measurement_parameters, reference_standards)
3. Sistema de upload de certificados PDF
4. Geração de certificados conformes ISO/IEC 17025
5. Relatórios por criticidade IGP

## Cálculo do IGP

O Índice de Grau de Prioridade (IGP) será calculado automaticamente:

```php
IGP = (frequencia_uso * necessidade_critica * criticidade_metrologica) / (abundancia * custo_indisponibilidade)
```

**Classificação**:

- **Alta**: IGP >= 20 (equipamentos críticos, prioridade máxima)
- **Média**: IGP entre 10-19 (equipamentos importantes)
- **Baixa**: IGP < 10 (equipamentos de rotina)

**Exemplo**:

- Frequência: 3 (alta)
- Necessidade: 3 (crítica)
- Abundância: 1 (único)
- Criticidade Metrol: 3 (alta)
- Custo Indisp: 3 (alto)

IGP = (3 _ 3 _ 3) / (1 \* 3) = 27 / 3 = **9 → Classificação: MÉDIA**

## Integração com Sistema Atual

### Tabelas Afetadas

- ✅ `equipamentos` - 27 novos campos
- ⏳ `laboratorios` - normalização de dados
- ⏳ `calibracoes` - histórico importado
- ⏳ `parametros_metrologicos` - futura implementação

### Relacionamentos

```
equipamentos (1) → (N) calibracoes
calibracoes (N) → (1) laboratorios
equipamentos (N) → (N) lote_itens
```

### API Endpoints (futuros)

```
GET /api/v1/equipamentos?classe=ELE
GET /api/v1/equipamentos?igp_min=20
GET /api/v1/equipamentos?classificacao=alta
GET /api/v1/dashboard/por-igp
```

## Observações Técnicas

### Formato de Datas no CSV

- Formato encontrado: `DD/MM/YY` e `DD/MM/YYYY`
- Anos com 2 dígitos: assumir 20XX
- Parsing: Carbon `createFromFormat('d/m/Y')`

### Valores Inválidos

- `#VALOR!` - erro de fórmula Excel, tratado como NULL
- Campos vazios - NULL
- Vírgulas em decimais - convertidas para ponto

### Performance

- Processamento em lote (transação única)
- Progress output a cada 50 linhas
- Tempo estimado: ~30-60 segundos para 484 registros

### Backup

Antes da importação:

```bash
docker compose exec app php artisan db:backup
```

---

**Documento gerado em**: 30/11/2025  
**Autor**: Sistema de Importação Automatizado  
**Versão**: 1.0
