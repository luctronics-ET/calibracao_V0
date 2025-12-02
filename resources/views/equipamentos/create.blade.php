@extends('layouts.app')

@section('title', 'Novo Equipamento - Sistema de Calibração')

@section('breadcrumb')
<nav class="flex mb-6" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                <i class="fas fa-home mr-2"></i>
                Dashboard
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                <a href="{{ route('equipamentos.index') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">Equipamentos</a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Novo</span>
            </div>
        </li>
    </ol>
</nav>
@endsection

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
        <i class="fas fa-plus-circle text-blue-600 mr-2"></i>
        Cadastrar Novo Equipamento
    </h2>
</div>

<form action="{{ route('equipamentos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf

    <!-- Informações Básicas -->
    <div class="rounded-lg bg-white dark:bg-gray-800 shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
            <i class="fas fa-info-circle text-blue-600 mr-2"></i>
            Informações Básicas
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <x-input
                label="Classe do Equipamento"
                name="equipamento_classe"
                placeholder="Ex: Instrumento de Medição"
                :value="old('equipamento_classe')"
                :error="$errors->first('equipamento_classe')"
            />

            <x-input
                label="Tipo"
                name="equipamento_tipo"
                placeholder="Ex: Paquímetro Digital"
                :value="old('equipamento_tipo')"
                :error="$errors->first('equipamento_tipo')"
                required
            />

            <x-input
                label="Código Interno"
                name="equipamento_codigo_interno"
                placeholder="Ex: EQ-001"
                :value="old('equipamento_codigo_interno')"
                :error="$errors->first('equipamento_codigo_interno')"
            />

            <x-input
                label="Fabricante"
                name="equipamento_fabricante"
                placeholder="Ex: Mitutoyo"
                :value="old('equipamento_fabricante')"
                :error="$errors->first('equipamento_fabricante')"
                required
            />

            <x-input
                label="Modelo"
                name="equipamento_modelo"
                placeholder="Ex: CD-6 CSX"
                :value="old('equipamento_modelo')"
                :error="$errors->first('equipamento_modelo')"
                required
            />

            <x-input
                label="Número de Série"
                name="equipamento_serial"
                placeholder="Ex: 123456789"
                :value="old('equipamento_serial')"
                :error="$errors->first('equipamento_serial')"
            />
        </div>
    </div>

    <!-- Características Técnicas -->
    <div class="rounded-lg bg-white dark:bg-gray-800 shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
            <i class="fas fa-cogs text-blue-600 mr-2"></i>
            Características Técnicas
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <x-input
                label="Resolução"
                name="equipamento_resolucao"
                placeholder="Ex: 0.01 mm"
                :value="old('equipamento_resolucao')"
                :error="$errors->first('equipamento_resolucao')"
            />

            <x-input
                label="Faixa de Medição"
                name="equipamento_faixa_medicao"
                placeholder="Ex: 0-150 mm"
                :value="old('equipamento_faixa_medicao')"
                :error="$errors->first('equipamento_faixa_medicao')"
            />

            <x-input
                label="Incerteza Nominal"
                name="equipamento_incerteza_nominal"
                placeholder="Ex: ± 0.02 mm"
                :value="old('equipamento_incerteza_nominal')"
                :error="$errors->first('equipamento_incerteza_nominal')"
            />
        </div>
    </div>

    <!-- Dimensões Físicas -->
    <div class="rounded-lg bg-white dark:bg-gray-800 shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
            <i class="fas fa-ruler-combined text-blue-600 mr-2"></i>
            Dimensões Físicas e Elétricas
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <x-input
                type="number"
                label="Altura (mm)"
                name="equipamento_altura_mm"
                placeholder="Ex: 200"
                :value="old('equipamento_altura_mm')"
                :error="$errors->first('equipamento_altura_mm')"
            />

            <x-input
                type="number"
                label="Largura (mm)"
                name="equipamento_largura_mm"
                placeholder="Ex: 100"
                :value="old('equipamento_largura_mm')"
                :error="$errors->first('equipamento_largura_mm')"
            />

            <x-input
                type="number"
                label="Comprimento (mm)"
                name="equipamento_comprimento_mm"
                placeholder="Ex: 300"
                :value="old('equipamento_comprimento_mm')"
                :error="$errors->first('equipamento_comprimento_mm')"
            />

            <x-input
                type="number"
                label="Tensão (V)"
                name="equipamento_tensao_v"
                placeholder="Ex: 110"
                :value="old('equipamento_tensao_v')"
                :error="$errors->first('equipamento_tensao_v')"
            />

            <x-input
                type="number"
                label="Potência (W)"
                name="equipamento_potencia_w"
                placeholder="Ex: 60"
                :value="old('equipamento_potencia_w')"
                :error="$errors->first('equipamento_potencia_w')"
            />
        </div>
    </div>

    <!-- Dados de Calibração -->
    <div class="rounded-lg bg-white dark:bg-gray-800 shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
            <i class="fas fa-calendar-check text-blue-600 mr-2"></i>
            Dados de Calibração
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <x-input
                type="date"
                label="Última Calibração"
                name="equipamento_data_ultima_calibracao"
                :value="old('equipamento_data_ultima_calibracao')"
                :error="$errors->first('equipamento_data_ultima_calibracao')"
            />

            <x-input
                type="date"
                label="Próxima Calibração"
                name="equipamento_data_proxima_calibracao"
                :value="old('equipamento_data_proxima_calibracao')"
                :error="$errors->first('equipamento_data_proxima_calibracao')"
            />

            <x-input
                type="number"
                label="Periodicidade (meses)"
                name="equipamento_periodicidade_meses"
                placeholder="Ex: 12"
                :value="old('equipamento_periodicidade_meses')"
                :error="$errors->first('equipamento_periodicidade_meses')"
            />

            <x-input
                label="Local de Calibração"
                name="equipamento_local_calibracao"
                placeholder="Ex: Lab. Interno"
                :value="old('equipamento_local_calibracao')"
                :error="$errors->first('equipamento_local_calibracao')"
            />
        </div>
    </div>

    <!-- Status e Localização -->
    <div class="rounded-lg bg-white dark:bg-gray-800 shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
            <i class="fas fa-map-marker-alt text-blue-600 mr-2"></i>
            Status e Localização
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <x-select
                label="Status"
                name="equipamento_status"
                :options="[
                    'ativo' => 'Ativo',
                    'inativo' => 'Inativo',
                    'manutencao' => 'Em Manutenção',
                    'descartado' => 'Descartado'
                ]"
                :selected="old('equipamento_status', 'ativo')"
                :error="$errors->first('equipamento_status')"
                required
            />

            <x-input
                label="Localização"
                name="equipamento_localizacao"
                placeholder="Ex: Sala 102"
                :value="old('equipamento_localizacao')"
                :error="$errors->first('equipamento_localizacao')"
            />

            <x-input
                label="Setor"
                name="equipamento_setor"
                placeholder="Ex: Metrologia"
                :value="old('equipamento_setor')"
                :error="$errors->first('equipamento_setor')"
            />
        </div>
    </div>

    <!-- Matriz IGP (Índice de Grau de Prioridade) -->
    <div class="rounded-lg bg-white dark:bg-gray-800 shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
            <i class="fas fa-chart-line text-blue-600 mr-2"></i>
            Matriz IGP - Índice de Grau de Prioridade
        </h3>

        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
            Avalie cada fator de 1 a 3. O IGP será calculado automaticamente (soma 5-15). Classificação: Baixa (&lt;7), Média (7-11), Alta (≥12).
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <x-select
                label="Frequência de Uso"
                name="equipamento_frequencia_uso"
                :options="[
                    1 => '1 - Pouco usado',
                    2 => '2 - Uso moderado',
                    3 => '3 - Uso frequente'
                ]"
                :selected="old('equipamento_frequencia_uso')"
                :error="$errors->first('equipamento_frequencia_uso')"
                help="Com que frequência o equipamento é utilizado?"
            />

            <x-select
                label="Necessidade Crítica"
                name="equipamento_necessidade_critica"
                :options="[
                    1 => '1 - Não crítico',
                    2 => '2 - Moderadamente crítico',
                    3 => '3 - Crítico'
                ]"
                :selected="old('equipamento_necessidade_critica')"
                :error="$errors->first('equipamento_necessidade_critica')"
                help="Qual o impacto se o equipamento estiver indisponível?"
            />

            <x-select
                label="Abundância"
                name="equipamento_abundancia"
                :options="[
                    1 => '1 - Abundante (facilmente substituível)',
                    2 => '2 - Disponibilidade média',
                    3 => '3 - Escasso (único/raro)'
                ]"
                :selected="old('equipamento_abundancia')"
                :error="$errors->first('equipamento_abundancia')"
                help="Existem equipamentos similares disponíveis?"
            />

            <x-select
                label="Custo de Indisponibilidade"
                name="equipamento_custo_indisponibilidade"
                :options="[
                    1 => '1 - Baixo custo',
                    2 => '2 - Custo médio',
                    3 => '3 - Alto custo'
                ]"
                :selected="old('equipamento_custo_indisponibilidade')"
                :error="$errors->first('equipamento_custo_indisponibilidade')"
                help="Qual o custo se o equipamento parar?"
            />

            <x-select
                label="Criticidade Metrológica"
                name="equipamento_criticidade_metrologica"
                :options="[
                    1 => '1 - Baixa criticidade',
                    2 => '2 - Média criticidade',
                    3 => '3 - Alta criticidade'
                ]"
                :selected="old('equipamento_criticidade_metrologica')"
                :error="$errors->first('equipamento_criticidade_metrologica')"
                help="Qual a importância metrológica do equipamento?"
            />
        </div>
    </div>

    <!-- Dados Financeiros -->
    <div class="rounded-lg bg-white dark:bg-gray-800 shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
            <i class="fas fa-dollar-sign text-blue-600 mr-2"></i>
            Dados Financeiros
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <x-input
                type="number"
                step="0.01"
                label="Valor de Aquisição (R$)"
                name="valor_aquisicao"
                placeholder="Ex: 1500.00"
                :value="old('valor_aquisicao')"
                :error="$errors->first('valor_aquisicao')"
            />

            <x-input
                type="number"
                step="0.01"
                label="Custo Estimado de Calibração (R$)"
                name="equipamento_custo_estimado"
                placeholder="Ex: 250.00"
                :value="old('equipamento_custo_estimado')"
                :error="$errors->first('equipamento_custo_estimado')"
            />

            <x-input
                type="date"
                label="Data de Aquisição"
                name="data_aquisicao"
                :value="old('data_aquisicao')"
                :error="$errors->first('data_aquisicao')"
            />
        </div>
    </div>

    <!-- Documentação -->
    <div class="rounded-lg bg-white dark:bg-gray-800 shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
            <i class="fas fa-file-alt text-blue-600 mr-2"></i>
            Documentação e Instruções
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <x-input
                label="Link do Fabricante"
                name="equipamento_link_fabricante"
                type="url"
                placeholder="https://..."
                :value="old('equipamento_link_fabricante')"
                :error="$errors->first('equipamento_link_fabricante')"
            />

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Manual PDF
                </label>
                <input
                    type="file"
                    name="equipamento_manual_pdf"
                    accept=".pdf"
                    class="w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 px-4 py-2.5 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                @if($errors->has('equipamento_manual_pdf'))
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $errors->first('equipamento_manual_pdf') }}</p>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4">
            <x-textarea
                label="Instruções de Uso"
                name="equipamento_instrucao_uso"
                rows="3"
                placeholder="Descreva as instruções de uso do equipamento..."
                :value="old('equipamento_instrucao_uso')"
                :error="$errors->first('equipamento_instrucao_uso')"
            />

            <x-textarea
                label="Instruções de Operação"
                name="equipamento_instrucao_operacao"
                rows="3"
                placeholder="Descreva as instruções de operação..."
                :value="old('equipamento_instrucao_operacao')"
                :error="$errors->first('equipamento_instrucao_operacao')"
            />

            <x-textarea
                label="Instruções de Segurança"
                name="equipamento_instrucao_seguranca"
                rows="3"
                placeholder="Descreva as instruções de segurança..."
                :value="old('equipamento_instrucao_seguranca')"
                :error="$errors->first('equipamento_instrucao_seguranca')"
            />

            <x-textarea
                label="Comentários Adicionais"
                name="equipamento_comentarios"
                rows="3"
                placeholder="Observações e comentários gerais..."
                :value="old('equipamento_comentarios')"
                :error="$errors->first('equipamento_comentarios')"
            />
        </div>
    </div>

    <!-- Foto do Equipamento -->
    <div class="rounded-lg bg-white dark:bg-gray-800 shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
            <i class="fas fa-camera text-blue-600 mr-2"></i>
            Foto do Equipamento
        </h3>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Foto
            </label>
            <input
                type="file"
                name="equipamento_foto"
                accept="image/*"
                class="w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 px-4 py-2.5 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
            @if($errors->has('equipamento_foto'))
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $errors->first('equipamento_foto') }}</p>
            @endif
        </div>
    </div>

    <!-- Botões de Ação -->
    <div class="flex items-center justify-end gap-3">
        <a href="{{ route('equipamentos.index') }}"
           class="inline-flex items-center gap-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-6 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
            <i class="fas fa-times"></i>
            Cancelar
        </a>

        <button type="submit"
                class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-6 py-2.5 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
            <i class="fas fa-save"></i>
            Salvar Equipamento
        </button>
    </div>
</form>
@endsection

@push('scripts')
<script>
// Calcular IGP automaticamente quando os valores mudarem
document.addEventListener('DOMContentLoaded', function() {
    const igpInputs = [
        'equipamento_frequencia_uso',
        'equipamento_necessidade_critica',
        'equipamento_abundancia',
        'equipamento_custo_indisponibilidade',
        'equipamento_criticidade_metrologica'
    ];

    igpInputs.forEach(inputName => {
        const input = document.querySelector(`select[name="${inputName}"]`);
        if(input) {
            input.addEventListener('change', calculateIGP);
        }
    });

    function calculateIGP() {
        let sum = 0;
        let allFilled = true;

        igpInputs.forEach(inputName => {
            const input = document.querySelector(`select[name="${inputName}"]`);
            if(input && input.value) {
                sum += parseInt(input.value);
            } else {
                allFilled = false;
            }
        });

        if(allFilled) {
            let classification = 'baixa';
            if(sum >= 12) classification = 'alta';
            else if(sum >= 7) classification = 'media';

            console.log(`IGP calculado: ${sum} - Classificação: ${classification}`);
        }
    }
});
</script>
@endpush
