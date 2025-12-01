<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Padrao extends Model {
    protected $table = 'padroes';
    public $timestamps = false;
    protected $fillable = ['nome', 'modelo', 'fabricante', 'numero_serie', 'rbc_codigo_laboratorio', 'validade_certificado', 'arquivo_certificado_pdf', 'arquivo_sha256'];
    protected $casts = ['validade_certificado' => 'date'];
}
