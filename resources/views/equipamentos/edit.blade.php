@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Editar Equipamento</h1>
                <a href="{{ route('equipamentos.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                    Voltar
                </a>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('equipamentos.update', $equipamento) }}" method="POST" enctype="multipart/form-data"
                class="bg-white shadow-md rounded px-8 pt-6 pb-8">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Informações Básicas -->
                    <div class="col-span-2">
                        <h2 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">Informações Básicas</h2>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="tipo">
                            Tipo <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="tipo" id="tipo" value="{{ old('tipo', $equipamento->tipo) }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('tipo') border-red-500 @enderror"
                            required>
                        @error('tipo')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="codigo_interno">
                            Código Interno <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="codigo_interno" id="codigo_interno"
                            value="{{ old('codigo_interno', $equipamento->codigo_interno) }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('codigo_interno') border-red-500 @enderror"
                            required>
                        @error('codigo_interno')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="divisao_origem">
                            Divisão de Origem
                        </label>
                        <input type="text" name="divisao_origem" id="divisao_origem"
                            value="{{ old('divisao_origem', $equipamento->divisao_origem) }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="categoria">
                            Categoria
                        </label>
                        <input type="text" name="categoria" id="categoria"
                            value="{{ old('categoria', $equipamento->categoria) }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="fabricante">
                            Fabricante
                        </label>
                        <input type="text" name="fabricante" id="fabricante"
                            value="{{ old('fabricante', $equipamento->fabricante) }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="modelo">
                            Modelo
                        </label>
                        <input type="text" name="modelo" id="modelo" value="{{ old('modelo', $equipamento->modelo) }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="serie">
                            Número de Série
                        </label>
                        <input type="text" name="serie" id="serie" value="{{ old('serie', $equipamento->serie) }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="local_fisico_atual">
                            Local Físico Atual
                        </label>
                        <input type="text" name="local_fisico_atual" id="local_fisico_atual"
                            value="{{ old('local_fisico_atual', $equipamento->local_fisico_atual) }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div class="col-span-2">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="descricao">
                            Descrição
                        </label>
                        <textarea name="descricao" id="descricao" rows="3"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('descricao', $equipamento->descricao) }}</textarea>
                    </div>

                    <!-- Dados de Calibração -->
                    <div class="col-span-2 mt-4">
                        <h2 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">Dados de Calibração</h2>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="ciclo_meses">
                            Ciclo de Calibração (meses)
                        </label>
                        <input type="number" name="ciclo_meses" id="ciclo_meses"
                            value="{{ old('ciclo_meses', $equipamento->ciclo_meses) }}" min="1" max="120"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="criticidade">
                            Criticidade
                        </label>
                        <select name="criticidade" id="criticidade"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="baixa" {{ old('criticidade', $equipamento->criticidade) == 'baixa' ? 'selected' : '' }}>Baixa</option>
                            <option value="media" {{ old('criticidade', $equipamento->criticidade) == 'media' ? 'selected' : '' }}>Média</option>
                            <option value="alta" {{ old('criticidade', $equipamento->criticidade) == 'alta' ? 'selected' : '' }}>Alta</option>
                            <option value="critica" {{ old('criticidade', $equipamento->criticidade) == 'critica' ? 'selected' : '' }}>Crítica</option>
                        </select>
                    </div>

                    <!-- Dados Metrológicos -->
                    <div class="col-span-2 mt-4">
                        <h2 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">Dados Metrológicos</h2>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="classe_metrologica">
                            Classe Metrológica
                        </label>
                        <input type="text" name="classe_metrologica" id="classe_metrologica"
                            value="{{ old('classe_metrologica', $equipamento->classe_metrologica) }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="resolucao">
                            Resolução
                        </label>
                        <input type="text" name="resolucao" id="resolucao"
                            value="{{ old('resolucao', $equipamento->resolucao) }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="faixa_medicao">
                            Faixa de Medição
                        </label>
                        <input type="text" name="faixa_medicao" id="faixa_medicao"
                            value="{{ old('faixa_medicao', $equipamento->faixa_medicao) }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="mpe">
                            MPE (Máximo Erro Permitido)
                        </label>
                        <input type="text" name="mpe" id="mpe" value="{{ old('mpe', $equipamento->mpe) }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div class="col-span-2">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="norma_aplicavel">
                            Norma Aplicável
                        </label>
                        <input type="text" name="norma_aplicavel" id="norma_aplicavel"
                            value="{{ old('norma_aplicavel', $equipamento->norma_aplicavel) }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div class="col-span-2">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="foto">
                            📷 Foto do Equipamento
                        </label>
                        @if($equipamento->foto)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $equipamento->foto) }}" alt="Foto atual" class="h-32 rounded">
                                <p class="text-sm text-gray-600 mt-1">Foto atual</p>
                            </div>
                        @endif
                        <input type="file" name="foto" id="foto" accept="image/*"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <p class="text-gray-500 text-xs mt-1">Formatos aceitos: JPG, PNG, GIF (máx. 2MB)</p>
                    </div>
                </div>

                <div class="flex items-center justify-end mt-8 gap-4">
                    <a href="{{ route('equipamentos.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Atualizar Equipamento
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection