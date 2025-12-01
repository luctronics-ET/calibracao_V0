<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class LogisticaEvento extends Model {
    protected $table = 'logistica_eventos';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;
    protected $fillable = ['lote_id', 'equipamento_id', 'calibracao_id', 'tipo_evento', 'data_evento', 'responsavel_id', 'transporte_id', 'relatorio', 'observacoes'];
}
