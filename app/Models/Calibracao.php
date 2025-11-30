<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Calibracao extends Model
{
    use Auditable;

    protected $table = 'calibracoes';
    
    protected $fillable = [
        'equipamento_id', 
        'laboratorio_id', 
        'lote_id', 
        'data_envio', 
        'data_recebimento_lab', 
        'data_calibracao', 
        'data_retorno', 
        'data_aceitacao_et',
        'data_proxima_calibracao',
        'status', 
        'resultado', 
        'certificado_num',
        'numero_certificado',
        'arquivo_certificado', 
        'custo', 
        'responsavel_et',
        'observacoes'
    ];

    protected $casts = [
        'data_envio' => 'datetime',
        'data_recebimento_lab' => 'datetime',
        'data_calibracao' => 'datetime',
        'data_retorno' => 'datetime',
        'data_aceitacao_et' => 'datetime',
        'data_proxima_calibracao' => 'datetime',
        'data_validade' => 'datetime',
        'custo' => 'decimal:2',
    ];
    
    public function equipamento()
    {
        return $this->belongsTo(Equipamento::class);
    }
    
    public function laboratorio()
    {
        return $this->belongsTo(Laboratorio::class);
    }
    
    public function lote()
    {
        return $this->belongsTo(LoteEnvio::class);
    }
}
