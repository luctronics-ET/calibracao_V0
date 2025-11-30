<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoteItem extends Model
{
    protected $table = 'lote_itens';

    protected $fillable = ['lote_id', 'equipamento_id', 'situacao'];

    public function loteEnvio()
    {
        return $this->belongsTo(LoteEnvio::class, 'lote_id');
    }

    public function equipamento()
    {
        return $this->belongsTo(Equipamento::class);
    }
}
