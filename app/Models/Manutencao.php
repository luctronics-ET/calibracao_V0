<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Manutencao extends Model {
    protected $table = 'manutencoes';
    public $timestamps = false;
    protected $fillable = ['equipamento_id', 'tipo', 'descricao', 'data_manutencao', 'responsavel', 'arquivo_relatorio_pdf', 'arquivo_sha256'];
}
