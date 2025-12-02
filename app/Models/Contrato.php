<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    use HasFactory;

    protected $table = 'contratos';

    protected $fillable = [
        'laboratorio_id',
        'numero_contrato',
        'descricao',
        'data_inicio',
        'data_fim',
        'valor_contrato',
        'observacoes',
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'data_fim' => 'date',
        'valor_contrato' => 'decimal:2',
    ];

    public function laboratorio()
    {
        return $this->belongsTo(Laboratorio::class);
    }

    public function calibracoes()
    {
        return $this->hasMany(Calibracao::class, 'contrato_servico_id');
    }

    public function lotes()
    {
        return $this->hasMany(Lote::class, 'contrato_servico_id');
    }
}
