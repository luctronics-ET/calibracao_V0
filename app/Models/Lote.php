<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    protected $table = 'lotes_envio';
    public $timestamps = false;
    protected $fillable = ['contrato_servico_id', 'laboratorio_id', 'transporte_id', 'descricao', 'data_envio_lote', 'data_recebimento_laboratorio', 'data_retorno_prevista', 'data_retorno_recebida', 'relatorio_envio', 'relatorio_recebimento', 'observacoes'];
    protected $casts = ['data_envio_lote' => 'date', 'data_recebimento_laboratorio' => 'date', 'data_retorno_prevista' => 'date', 'data_retorno_recebida' => 'date'];

    public function contratoServico()
    {
        return $this->belongsTo(ContratoServico::class);
    }
    public function laboratorio()
    {
        return $this->belongsTo(Laboratorio::class);
    }
    public function transporte()
    {
        return $this->belongsTo(Transporte::class);
    }
    public function equipamentos()
    {
        return $this->belongsToMany(Equipamento::class, 'lote_equipamentos');
    }
}
