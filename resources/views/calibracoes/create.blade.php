@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Nova Calibração</h1>
                <a href="{{ route('calibracoes.index') }}"
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

            <form action="{{ route('calibracoes.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 pt-6 pb-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="equipamento_id">
                            Equipamento <span class="text-red-500">*</span>
                        </label>
                        <select name="equipamento_id" id="equipamento_id"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('equipamento_id') border-red-500 @enderror"
                            required>
                            <option value="">Selecione um equipamento</option>
                            @foreach($equipamentos as $equipamento)
                                <option value="{{ $equipamento->id }}" {{ old('equipamento_id') == $equipamento->id ? 'selected' : '' }}>
                                    {{ $equipamento->codigo_interno }} - {{ $equipamento->tipo }}
                                </option>
                            @endforeach
                        </select>
                        @error('equipamento_id')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="data_calibracao">
                            Data de Calibração <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="data_calibracao" id="data_calibracao" value="{{ old('data_calibracao') }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('data_calibracao') border-red-500 @enderror"
                            required>
                        @error('data_calibracao')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="data_validade">
                            Data de Validade <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="data_validade" id="data_validade" value="{{ old('data_validade') }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('data_validade') border-red-500 @enderror"
                            required>
                        @error('data_validade')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="certificado_num">
                            Número do Certificado
                        </label>
                        <input type="text" name="certificado_num" id="certificado_num" value="{{ old('certificado_num') }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="resultado">
                            Resultado
                        </label>
                        <select name="resultado" id="resultado"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Selecione</option>
                            <option value="aprovado" {{ old('resultado') == 'aprovado' ? 'selected' : '' }}>Aprovado</option>
                            <option value="reprovado" {{ old('resultado') == 'reprovado' ? 'selected' : '' }}>Reprovado
                            </option>
                            <option value="condicional" {{ old('resultado') == 'condicional' ? 'selected' : '' }}>Condicional
                            </option>
                        </select>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="laboratorio_nome">
                            Nome do Laboratório
                        </label>
                        <input type="text" name="laboratorio_nome" id="laboratorio_nome"
                            value="{{ old('laboratorio_nome') }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div class="col-span-2">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="observacoes">
                            Observações
                        </label>
                        <textarea name="observacoes" id="observacoes" rows="4"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('observacoes') }}</textarea>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="arquivo_certificado">
                            📄 Certificado de Calibração (PDF)
                        </label>
                        <input type="file" name="arquivo_certificado" id="arquivo_certificado" accept=".pdf"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <p class="text-gray-500 text-xs mt-1">Formato aceito: PDF (máx. 10MB)</p>
                    </div>
                </div>

                <div class="flex items-center justify-end mt-8 gap-4">
                    <a href="{{ route('calibracoes.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Salvar Calibração
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection