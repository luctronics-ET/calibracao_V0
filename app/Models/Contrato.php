<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Contrato extends Model {
    protected $fillable = ['laboratorio_id','edital_num','vigencia_ini','vigencia_fim','preco_unitario','anexos'];
    public function laboratorio(){ return $this->belongsTo(Laboratorio::class); }
}
