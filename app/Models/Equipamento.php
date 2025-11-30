<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Auditable;

class Equipamento extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'divisao_origem',
        'tipo',
        'categoria',
        'fabricante',
        'modelo',
        'serie',
        'codigo_interno',
        'descricao',
        'local_fisico_atual',
        'ciclo_meses',
        'criticidade',
        'classe_metrologica',
        'resolucao',
        'faixa_medicao',
        'mpe',
        'norma_aplicavel',
        'data_proxima_calibracao',
        'status_calibracao',
        'foto',
        // Campos adicionados do CSV
        'classe',
        'especificacoes',
        'patrimonio',
        'status',
        'setor',
        // Dimensões físicas
        'altura',
        'largura',
        'comprimento',
        'tensao',
        'potencia',
        // Documentação
        'manual_pdf',
        'link_fabricante',
        'instrucao_uso',
        'instrucao_operacao',
        'instrucao_seguranca',
        // Metrologia avançada
        'incerteza_nominal',
        'categoria_metrologica',
        // Financeiro
        'valor_aquisicao',
        'data_aquisicao',
        'custo_estimado',
        'responsavel',
        // Matriz IGP
        'frequencia_uso',
        'necessidade_critica',
        'abundancia',
        'criticidade_metrologica',
        'custo_indisponibilidade',
        'igp',
        'classificacao',
    ];

    protected $casts = [
        'data_proxima_calibracao' => 'datetime',
        'data_aquisicao' => 'date',
        'altura' => 'decimal:2',
        'largura' => 'decimal:2',
        'comprimento' => 'decimal:2',
        'valor_aquisicao' => 'decimal:2',
        'custo_estimado' => 'decimal:2',
        'frequencia_uso' => 'integer',
        'necessidade_critica' => 'integer',
        'abundancia' => 'integer',
        'criticidade_metrologica' => 'integer',
        'custo_indisponibilidade' => 'integer',
        'igp' => 'integer',
    ];

    public function calibracoes()
    {
        return $this->hasMany(Calibracao::class);
    }

    public function parametros()
    {
        return $this->hasMany(ParametroMetrologico::class);
    }

    public function lotes()
    {
        return $this->belongsToMany(LoteEnvio::class, 'lote_itens');
    }

    public function loteItens()
    {
        return $this->hasMany(LoteItem::class);
    }
}
