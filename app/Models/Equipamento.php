<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Equipamento extends Model {
    protected $fillable = ['divisao_origem','tipo','categoria','fabricante','modelo','serie','codigo_interno','descricao','local_fisico_atual','ciclo_meses','criticidade','classe_metrologica','resolucao','faixa_medicao','mpe','norma_aplicavel'];
    public function calibracoes(){ return $this->hasMany(Calibracao::class); }
    public function parametros(){ return $this->hasMany(ParametroMetrologico::class); }
    public function lotes(){ return $this->belongsToMany(LoteEnvio::class, 'lote_itens'); }
}
