<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Transporte extends Model {
    protected $table = 'transportes';
    public $timestamps = false;
    protected $fillable = ['transportadora', 'motorista', 'documento_transporte', 'veiculo', 'contato', 'observacoes'];
}
