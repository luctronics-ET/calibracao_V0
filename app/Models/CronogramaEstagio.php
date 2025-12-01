<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CronogramaEstagio extends Model {
    protected $table = 'cronograma_estagios';
    public $timestamps = false;
    protected $fillable = ['equipamento_id', 'nome_estagio', 'data_inicio', 'data_fim', 'responsavel_id', 'observacoes'];
    protected $casts = ['data_inicio' => 'date', 'data_fim' => 'date'];
    
    public function equipamento() { return $this->belongsTo(Equipamento::class); }
}
