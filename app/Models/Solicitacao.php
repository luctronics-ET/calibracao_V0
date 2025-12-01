<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Solicitacao extends Model {
    protected $table = 'solicitacoes';
    public $timestamps = false;
    protected $fillable = ['solicitante', 'tipo_servico', 'data_solicitacao', 'descricao', 'status'];
    protected $casts = ['data_solicitacao' => 'date'];
}
