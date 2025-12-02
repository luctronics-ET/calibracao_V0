<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipamento extends Model
{
    use HasFactory;

    protected $table = 'equipamentos';
    public $timestamps = false;

    protected $fillable = [
        // Campos básicos
        'categoria_metrologica',
        'tipo',
        'fabricante',
        'modelo',
        'numero_serie',
        'codigo_interno',
        'descricao',
        'local_dotacao_id',
        'localizacao_atual_id',
        'classe_exatidao',
        'resolucao',
        'intervalo_medicao_min',
        'intervalo_medicao_max',
        'cond_temp_operacao',
        'cond_umidade_operacao',
        'cond_ambiente_restricoes',
        'criticidade_equipamento',
        'intervalo_calibracao_meses',
        'justificativa_intervalo',
        'proxima_calibracao_prevista',
        'custo_previsto_calibracao',
        'bloqueado_para_uso',
        'motivo_bloqueio',
        'responsavel_tecnico',
        'responsavel_cadastramento',
        'observacoes_auditoria',
        'data_cadastro',
        'ultima_atualizacao',
        'divisao',

        // Campos com prefixo equipamento_
        'equipamento_tipo',
        'equipamento_fabricante',
        'equipamento_modelo',
        'equipamento_serial',
        'equipamento_codigo_interno',
        'equipamento_resolucao',
        'equipamento_faixa_medicao',
        'equipamento_foto',
        'equipamento_classe',
        'equipamento_altura_mm',
        'equipamento_largura_mm',
        'equipamento_comprimento_mm',
        'equipamento_tensao_v',
        'equipamento_potencia_w',
        'equipamento_incerteza_nominal',
        'equipamento_data_ultima_calibracao',
        'equipamento_data_proxima_calibracao',
        'equipamento_periodicidade_meses',
        'equipamento_status',
        'equipamento_localizacao',
        'equipamento_setor',
        'equipamento_manual_pdf',
        'equipamento_link_fabricante',
        'equipamento_instrucao_uso',
        'equipamento_instrucao_operacao',
        'equipamento_instrucao_seguranca',
        'equipamento_comentarios',
        'equipamento_custo_estimado',
        'equipamento_certificado_pdf',
        'equipamento_certificado_status',
        'equipamento_local_calibracao',
        'equipamento_frequencia_uso',
        'equipamento_necessidade_critica',
        'equipamento_abundancia',
        'equipamento_custo_indisponibilidade',
        'equipamento_criticidade_metrologica',
        'equipamento_igp',
        'equipamento_classificacao',

        // Campos adicionais
        'classe',
        'especificacoes',
        'patrimonio',
        'status',
        'setor',
        'altura',
        'largura',
        'comprimento',
        'tensao',
        'potencia',
        'manual_pdf',
        'link_fabricante',
        'instrucao_uso',
        'instrucao_operacao',
        'instrucao_seguranca',
        'incerteza_nominal',
        'valor_aquisicao',
        'data_aquisicao',
        'custo_estimado',
        'responsavel',
        'frequencia_uso',
        'necessidade_critica',
        'abundancia',
        'criticidade_metrologica',
        'custo_indisponibilidade',
        'igp',
        'classificacao',
        'data_ultima_calibracao',
        'periodicidade_meses',
        'localizacao',
        'comentarios',
        'certificado_pdf',
        'certificado_status',
        'local_calibracao',
        'classificacao_igp',

        // Campos de logística (novos)
        'numero_ordem_servico',
        'data_recebimento_et',
        'data_saida_calibracao',
        'data_recebimento_calibracao',
        'data_entrega_divisao',
        'observacoes_logistica',
        'status_logistica',
        'relatorio_recebimento_et',
        'responsavel_divisao',
        'responsavel_et',
        'calibracao_id',
        'contrato_servico_id',
        'laboratorio_id',
        'logistica_et_id',
        'lote_id',
        'solicitacao_id',
        'transporte_id',
    ];

    protected $casts = [
        'intervalo_medicao_min' => 'float',
        'intervalo_medicao_max' => 'float',
        'custo_previsto_calibracao' => 'decimal:2',
        'bloqueado_para_uso' => 'boolean',
        'proxima_calibracao_prevista' => 'date',
        'data_cadastro' => 'date',
        'ultima_atualizacao' => 'date',
    ];

    public function localDotacao()
    {
        return $this->belongsTo(Local::class, 'local_dotacao_id');
    }
    public function localizacaoAtual()
    {
        return $this->belongsTo(Local::class, 'localizacao_atual_id');
    }
    public function calibracoes()
    {
        return $this->hasMany(Calibracao::class);
    }
    public function padroes()
    {
        return $this->belongsToMany(Padrao::class, 'equipamento_padroes');
    }
    public function documentos()
    {
        return $this->hasMany(EquipamentoDocumento::class);
    }
    public function manutencoes()
    {
        return $this->hasMany(Manutencao::class);
    }
    public function condicoesAmbientais()
    {
        return $this->hasMany(CondicaoAmbiental::class);
    }
    public function cronogramaEstagios()
    {
        return $this->hasMany(CronogramaEstagio::class);
    }
    public function lotes()
    {
        return $this->belongsToMany(Lote::class, 'lote_equipamentos');
    }
    public function logisticaEventos()
    {
        return $this->hasMany(LogisticaEvento::class);
    }

    public function scopeBuscar($query, $termo)
    {
        return $query->where(function ($q) use ($termo) {
            $q->where('codigo_interno', 'like', "%{$termo}%")
                ->orWhere('numero_serie', 'like', "%{$termo}%")
                ->orWhere('tipo', 'like', "%{$termo}%");
        });
    }
}
