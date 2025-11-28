<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Equipamento;

class EquipamentoController extends Controller {
    public function index(){
        return response()->json(Equipamento::with('calibracoes')->paginate(20));
    }
    public function show($id){
        return response()->json(Equipamento::with('calibracoes','parametros')->findOrFail($id));
    }
}
