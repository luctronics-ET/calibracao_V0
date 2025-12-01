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
