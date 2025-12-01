<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ContratoServico extends Model {
    protected $table = 'contratos_servico';
    public $timestamps = false;
    protected $fillable = ['fornecedor', 'numero_contrato', 'vigencia_inicio', 'vigencia_fim', 'descricao'];
    protected $casts = ['vigencia_inicio' => 'date', 'vigencia_fim' => 'date'];
}
