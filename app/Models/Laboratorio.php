<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Laboratorio extends Model {
    protected $table = 'laboratorios';
    public $timestamps = false;
    protected $fillable = ['nome', 'rbc_codigo', 'contato', 'endereco', 'acreditacao'];
    
    public function calibracoes() { return $this->hasMany(Calibracao::class); }
    public function lotes() { return $this->hasMany(Lote::class); }
}
