<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Auditable;

class Equipamento extends Model
{
    use HasFactory, Auditable;

    protected $fillable = ['divisao_origem', 'tipo', 'categoria', 'fabricante', 'modelo', 'serie', 'codigo_interno', 'descricao', 'local_fisico_atual', 'ciclo_meses', 'criticidade', 'classe_metrologica', 'resolucao', 'faixa_medicao', 'mpe', 'norma_aplicavel', 'data_proxima_calibracao', 'status_calibracao', 'foto'];

    protected $casts = [
        'data_proxima_calibracao' => 'datetime',
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
