<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CondicaoAmbiental extends Model {
    protected $table = 'condicoes_ambientais';
    public $timestamps = false;
    protected $fillable = ['equipamento_id', 'data_registro', 'temperatura', 'umidade', 'observacoes'];
}
