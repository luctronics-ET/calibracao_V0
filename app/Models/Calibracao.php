<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Calibracao extends Model {
    protected $fillable = ['equipamento_id','laboratorio_id','lote_id','data_envio','data_recebimento_lab','data_calibracao','data_retorno','data_aceitacao_et','status','resultado','certificado_num','arquivo_certificado','custo','responsavel_et'];
    public function equipamento(){ return $this->belongsTo(Equipamento::class); }
    public function laboratorio(){ return $this->belongsTo(Laboratorio::class); }
    public function lote(){ return $this->belongsTo(LoteEnvio::class); }
}
