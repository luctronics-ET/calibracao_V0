<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class LogisticaEt extends Model {
    protected $table = 'logistica_et';
    public $timestamps = false;
    protected $fillable = ['lote_id', 'equipamento_id', 'calibracao_id', 'solicitacao_id', 'transporte_id', 'data_recebimento_et', 'relatorio_recebimento_et', 'responsavel_et', 'data_recebimento_transporte', 'relatorio_recebimento_transporte', 'data_recebimento_concluido_et', 'relatorio_recebimento_concluido_et', 'data_recebimento_divisao', 'relatorio_recebimento_divisao', 'responsavel_divisao', 'observacoes'];
}
