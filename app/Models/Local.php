<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Local extends Model {
    protected $table = 'locais';
    public $timestamps = false;
    protected $fillable = ['nome', 'tipo', 'referencia', 'descricao', 'contato', 'endereco'];
    
    public function equipamentosDotacao() { return $this->hasMany(Equipamento::class, 'local_dotacao_id'); }
    public function equipamentosLocalizados() { return $this->hasMany(Equipamento::class, 'localizacao_atual_id'); }
}
