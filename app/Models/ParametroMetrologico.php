<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ParametroMetrologico extends Model {
    protected $fillable = ['equipamento_id','descricao','valor_nominal','tolerancia','unidade','metodo'];
    public function equipamento(){ return $this->belongsTo(Equipamento::class); }
}
