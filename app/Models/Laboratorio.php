<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Laboratorio extends Model {
    protected $fillable = ['nome','cnpj','acreditado','escopo','contato','endereco'];
    public function contratos(){ return $this->hasMany(Contrato::class); }
}
