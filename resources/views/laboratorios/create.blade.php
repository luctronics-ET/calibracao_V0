@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Novo Laboratório</h1>
            <a href="{{ route('laboratorios.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
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

        <form action="{{ route('laboratorios.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nome">
                        Nome <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="nome" 
                        id="nome" 
                        value="{{ old('nome') }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('nome') border-red-500 @enderror"
                        required
                    >
                    @error('nome')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="cnpj">
                        CNPJ
                    </label>
                    <input 
                        type="text" 
                        name="cnpj" 
                        id="cnpj" 
                        value="{{ old('cnpj') }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        placeholder="00.000.000/0000-00"
                    >
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="contato">
                        Contato
                    </label>
                    <input 
                        type="text" 
                        name="contato" 
                        id="contato" 
                        value="{{ old('contato') }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        placeholder="Telefone/Email"
                    >
                </div>

                <div class="col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="endereco">
                        Endereço
                    </label>
                    <input 
                        type="text" 
                        name="endereco" 
                        id="endereco" 
                        value="{{ old('endereco') }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    >
                </div>

                <div class="col-span-2">
                    <label class="flex items-center">
                        <input 
                            type="checkbox" 
                            name="acreditado" 
                            id="acreditado" 
                            value="1"
                            {{ old('acreditado') ? 'checked' : '' }}
                            class="mr-2 leading-tight"
                        >
                        <span class="text-sm font-bold text-gray-700">
                            Laboratório Acreditado
                        </span>
                    </label>
                </div>

                <div class="col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="escopo">
                        Escopo de Acreditação
                    </label>
                    <textarea 
                        name="escopo" 
                        id="escopo" 
                        rows="4"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        placeholder="Descreva os serviços e calibrações realizadas..."
                    >{{ old('escopo') }}</textarea>
                </div>
            </div>

            <div class="flex items-center justify-end mt-8 gap-4">
                <a href="{{ route('laboratorios.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Salvar Laboratório
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
