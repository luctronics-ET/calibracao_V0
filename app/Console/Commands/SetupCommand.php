<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup
                            {--fresh : Drop all tables and migrate fresh}
                            {--seed : Seed the database with sample data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup inicial do sistema de calibração';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔧 Iniciando setup do Sistema de Calibração...');
        $this->newLine();

        // Limpar caches
        $this->info('🧹 Limpando caches...');
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        $this->info('✅ Caches limpos');
        $this->newLine();

        // Migrations
        if ($this->option('fresh')) {
            $this->warn('⚠️  Modo FRESH ativado - todas as tabelas serão recriadas!');
            if ($this->confirm('Deseja continuar?', true)) {
                $this->info('📊 Executando migrate:fresh...');
                Artisan::call('migrate:fresh', ['--force' => true]);
                $this->info('✅ Banco de dados recriado');
            } else {
                $this->error('❌ Operação cancelada');
                return 1;
            }
        } else {
            $this->info('📊 Executando migrations...');
            Artisan::call('migrate', ['--force' => true]);
            $this->info('✅ Migrations executadas');
        }
        $this->newLine();

        // Seeders
        if ($this->option('seed')) {
            $this->info('🌱 Populando banco de dados...');
            Artisan::call('db:seed', ['--force' => true]);
            $this->info('✅ Dados de exemplo criados');
            $this->newLine();
        }

        // Otimizações
        $this->info('⚡ Otimizando aplicação...');
        Artisan::call('config:cache');
        Artisan::call('route:cache');
        Artisan::call('view:cache');
        $this->info('✅ Caches otimizados');
        $this->newLine();

        // Storage link
        if (!file_exists(public_path('storage'))) {
            $this->info('🔗 Criando link simbólico para storage...');
            Artisan::call('storage:link');
            $this->info('✅ Link criado');
            $this->newLine();
        }

        $this->info('✅ Setup concluído com sucesso!');
        $this->newLine();

        $this->table(
            ['Componente', 'Status'],
            [
                ['Database', '✅ Configurado'],
                ['Migrations', '✅ Executadas'],
                ['Cache', '✅ Otimizado'],
                ['Storage', '✅ Linkado'],
                ['Seeders', $this->option('seed') ? '✅ Executado' : '⏭️  Pulado'],
            ]
        );

        return 0;
    }
}
