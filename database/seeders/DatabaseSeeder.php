<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder {
    public function run() {
        DB::table('laboratorios')->insert([
            ['nome'=>'Lab Exemplo A','cnpj'=>'00.000.000/0001-00','acreditado'=>1,'escopo'=>'Eletricos e Eletrônicos','contato'=>'contato@labexemplo.com','endereco'=>'Rua A, 100'],
            ['nome'=>'Lab Exemplo B','cnpj'=>'11.111.111/0001-11','acreditado'=>0,'escopo'=>'Mecânicos','contato'=>'contato@labb.com','endereco'=>'Av B, 200']
        ]);
        DB::table('equipamentos')->insert([
            ['divisao_origem'=>'CMASM','tipo'=>'Multimetro','categoria'=>'Eletrico','fabricante'=>'Fluke','modelo'=>'87V','serie'=>'MT-0001','codigo_interno'=>'EQ-0001','descricao'=>'Multimetro de bancada','local_fisico_atual'=>'Oficina A','ciclo_meses'=>12],
            ['divisao_origem'=>'MSMI','tipo'=>'Paquimetro','categoria'=>'Mecanico','fabricante'=>'Mitutoyo','modelo'=>'500-196','serie'=>'PAQ-100','codigo_interno'=>'EQ-0002','descricao'=>'Paquimetro digital','local_fisico_atual'=>'Oficina B','ciclo_meses'=>12]
        ]);
    }
}
