# Importação de Equipamentos

## Comando de Importação

O sistema possui um comando artisan para importar equipamentos de planilhas Excel ou CSV.

### Uso

```bash
php artisan import:equipamentos <caminho-do-arquivo>
```

### Exemplo

```bash
php artisan import:equipamentos storage/app/exemplo_equipamentos.csv
```

### Formato da Planilha

A planilha deve conter as seguintes colunas (na primeira linha):

| Coluna             | Obrigatório | Descrição                                                |
| ------------------ | ----------- | -------------------------------------------------------- |
| divisao_origem     | Não         | Divisão de origem do equipamento                         |
| tipo               | Sim         | Tipo do equipamento (ex: Multímetro Digital)             |
| categoria          | Não         | Categoria (ex: Elétrica, Dimensional)                    |
| fabricante         | Não         | Nome do fabricante                                       |
| modelo             | Não         | Modelo do equipamento                                    |
| serie              | Não         | Número de série                                          |
| codigo_interno     | Sim         | Código único do equipamento                              |
| descricao          | Não         | Descrição detalhada                                      |
| local_fisico_atual | Não         | Local onde está armazenado                               |
| ciclo_meses        | Não         | Ciclo de calibração em meses (padrão: 12)                |
| criticidade        | Não         | Criticidade: baixa, media, alta, critica (padrão: media) |
| classe_metrologica | Não         | Classe metrológica                                       |
| resolucao          | Não         | Resolução do instrumento                                 |
| faixa_medicao      | Não         | Faixa de medição                                         |
| mpe                | Não         | Máximo Erro Permitido                                    |
| norma_aplicavel    | Não         | Norma técnica aplicável                                  |

### Arquivo de Exemplo

Um arquivo de exemplo está disponível em:

```
storage/app/exemplo_equipamentos.csv
```

### Formatos Suportados

- CSV (valores separados por vírgula)
- Excel (.xlsx, .xls)
- ODS (LibreOffice)

### Validações

O sistema valida:

- `tipo` é obrigatório
- `codigo_interno` é obrigatório e único
- `ciclo_meses` deve ser entre 1 e 120
- `criticidade` deve ser: baixa, media, alta ou critica

### Saída do Comando

O comando exibe:

- Total de equipamentos importados com sucesso
- Erros encontrados (se houver)
- Detalhes de cada erro (linha e mensagem)

### Exemplo de Saída

```
Importando equipamentos de: storage/app/exemplo_equipamentos.csv
✓ Importação concluída!
  - 5 equipamentos importados
```

### Tratamento de Erros

Se houver erros em linhas específicas:

```
Importando equipamentos de: minha_planilha.csv
Erro na linha 3: Código interno já existe
Erro na linha 7: Campo tipo é obrigatório
✓ Importação concluída!
  - 48 equipamentos importados
  - 2 erros encontrados
```

## Classe de Importação

A lógica de importação está em:

```
app/Console/Commands/ImportEquipamentosCommand.php
```

Utiliza a biblioteca `phpoffice/phpspreadsheet` para ler arquivos Excel/CSV.
