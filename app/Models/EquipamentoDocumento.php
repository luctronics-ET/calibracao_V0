<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class EquipamentoDocumento extends Model {
    protected $table = 'equipamento_documentos';
    public $timestamps = false;
    protected $fillable = ['equipamento_id', 'tipo_documento', 'arquivo_path', 'arquivo_sha256', 'doc_versao', 'doc_data_emissao', 'doc_data_revisao', 'doc_emissor', 'doc_revisador', 'doc_status', 'doc_referencia_interna', 'doc_vinculo_normativo', 'data_upload'];
}
