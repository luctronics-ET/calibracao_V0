<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class LoteEnvio extends Model
{
    use Auditable;

    protected $table = 'lotes_envio';
    protected $fillable = ['codigo_lote', 'data_envio', 'data_retorno', 'responsavel_envio', 'transportadora', 'observacoes'];
    public function itens()
    {
        return $this->hasMany(LoteItem::class, 'lote_id');
    }
    public function equipamentos()
    {
        return $this->belongsToMany(Equipamento::class, 'lote_itens');
    }
}
