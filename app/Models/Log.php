<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Log extends Model {
    protected $fillable = ['usuario_id','tabela','referencia_id','acao','detalhe'];
    public function usuario(){ return $this->belongsTo(Usuario::class); }
}
