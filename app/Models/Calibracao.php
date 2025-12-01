<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Calibracao extends Model {
    protected $table = 'calibracoes';
    public $timestamps = false;
    protected $fillable = [
        'equipamento_id', 'data_calibracao', 'laboratorio_id', 'rbc_codigo_laboratorio',
        'rbc_metodo_calibracao', 'rbc_incerteza_prevista', 'rbc_capacidade_medicao',
        'conformidade_ilac_p14', 'status', 'estagio_cronograma_id', 'localizacao_atual_id',
        'observacoes', 'solicitacao_id', 'logistica_et_id', 'contrato_servico_id', 'lote_id',
        'arquivo_certificado_pdf', 'arquivo_sha256', 'proxima_calibracao_sugerida', 'data_registro'
    ];
    protected $casts = [
        'data_calibracao' => 'date',
        'conformidade_ilac_p14' => 'boolean',
        'data_registro' => 'datetime',
        'proxima_calibracao_sugerida' => 'date'
    ];
    
    public function equipamento() { return $this->belongsTo(Equipamento::class); }
    public function laboratorio() { return $this->belongsTo(Laboratorio::class); }
    public function estagioCronograma() { return $this->belongsTo(CronogramaEstagio::class); }
    public function localizacaoAtual() { return $this->belongsTo(Local::class); }
    public function solicitacao() { return $this->belongsTo(Solicitacao::class); }
    public function logisticaEt() { return $this->belongsTo(LogisticaEt::class); }
    public function contratoServico() { return $this->belongsTo(ContratoServico::class); }
    public function lote() { return $this->belongsTo(Lote::class); }
    public function logisticaEventos() { return $this->hasMany(LogisticaEvento::class); }
}
