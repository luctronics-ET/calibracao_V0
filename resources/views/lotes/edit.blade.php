@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Editar Lote de Envio</h1>
                <a href="{{ route('lotes.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
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

            <form action="{{ route('lotes.update', $lote) }}" method="POST"
                class="bg-white shadow-md rounded px-8 pt-6 pb-8">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="laboratorio_id">
                            Laboratório <span class="text-red-500">*</span>
                        </label>
                        <select name="laboratorio_id" id="laboratorio_id"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('laboratorio_id') border-red-500 @enderror"
                            required>
                            <option value="">Selecione um laboratório</option>
                            @foreach($laboratorios as $laboratorio)
                                <option value="{{ $laboratorio->id }}" {{ old('laboratorio_id', $lote->laboratorio_id) == $laboratorio->id ? 'selected' : '' }}>
                                    {{ $laboratorio->nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('laboratorio_id')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="data_envio">
                            Data de Envio <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="data_envio" id="data_envio"
                            value="{{ old('data_envio', $lote->data_envio) }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('data_envio') border-red-500 @enderror"
                            required>
                        @error('data_envio')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="data_prev_retorno">
                            Previsão de Retorno
                        </label>
                        <input type="date" name="data_prev_retorno" id="data_prev_retorno"
                            value="{{ old('data_prev_retorno', $lote->data_prev_retorno) }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="data_retorno">
                            Data de Retorno
                        </label>
                        <input type="date" name="data_retorno" id="data_retorno"
                            value="{{ old('data_retorno', $lote->data_retorno) }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="status">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" id="status"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('status') border-red-500 @enderror"
                            required>
                            <option value="preparacao" {{ old('status', $lote->status) == 'preparacao' ? 'selected' : '' }}>Em
                                Preparação</option>
                            <option value="enviado" {{ old('status', $lote->status) == 'enviado' ? 'selected' : '' }}>Enviado
                            </option>
                            <option value="em_calibracao" {{ old('status', $lote->status) == 'em_calibracao' ? 'selected' : '' }}>Em Calibração</option>
                            <option value="concluido" {{ old('status', $lote->status) == 'concluido' ? 'selected' : '' }}>
                                Concluído</option>
                            <option value="cancelado" {{ old('status', $lote->status) == 'cancelado' ? 'selected' : '' }}>
                                Cancelado</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-2">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="observacoes">
                            Observações
                        </label>
                        <textarea name="observacoes" id="observacoes" rows="4"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('observacoes', $lote->observacoes) }}</textarea>
                    </div>
                </div>

                <div class="flex items-center justify-end mt-8 gap-4">
                    <a href="{{ route('lotes.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Atualizar Lote
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection