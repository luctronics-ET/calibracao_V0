# Sistema de Componentes - Calibração V0

## 📦 Componentes Disponíveis

### 1. Card (`<x-card>`)

Card reutilizável com título e ícone opcional.

```blade
<x-card
    title="Identificação"
    :icon="'<svg>...</svg>'"
    iconBg="bg-indigo-100"
    iconColor="text-indigo-600"
>
    Conteúdo do card
</x-card>
```

### 2. Table (`<x-table>`)

Tabela responsiva com striped e hover.

```blade
<x-table
    :headers="['Nome', 'Email', 'Status']"
    :rows="[
        ['João Silva', 'joao@email.com', '<x-badge variant=\'success\'>Ativo</x-badge>'],
        ['Maria Santos', 'maria@email.com', '<x-badge variant=\'danger\'>Inativo</x-badge>'],
    ]"
    striped
    hover
/>
```

### 3. Input (`<x-input>`)

Campo de formulário com label e validação.

```blade
<x-input
    label="Nome Completo"
    name="nome"
    type="text"
    placeholder="Digite seu nome"
    required
/>
```

### 4. Select (`<x-select>`)

Select dropdown com opções.

```blade
<x-select
    label="Criticidade"
    name="criticidade"
    :options="[
        'baixa' => 'Baixa',
        'media' => 'Média',
        'alta' => 'Alta',
        'critica' => 'Crítica'
    ]"
    selected="media"
    required
/>
```

### 5. Button (`<x-button>`)

Botão com variantes e tamanhos.

```blade
<x-button variant="primary" size="md" type="submit">
    Salvar
</x-button>

<x-button
    variant="danger"
    :icon="'<svg class=\'w-4 h-4\'>...</svg>'"
>
    Excluir
</x-button>
```

**Variantes:** `primary`, `secondary`, `success`, `danger`, `warning`, `outline`
**Tamanhos:** `sm`, `md`, `lg`

### 6. Badge (`<x-badge>`)

Badge para status e tags.

```blade
<x-badge variant="success">Aprovado</x-badge>
<x-badge variant="danger" size="sm">Reprovado</x-badge>
```

**Variantes:** `default`, `primary`, `success`, `danger`, `warning`, `info`

### 7. Alert (`<x-alert>`)

Alertas com ícones e dismiss.

```blade
<x-alert type="success" dismissible>
    Equipamento cadastrado com sucesso!
</x-alert>

<x-alert type="danger">
    Erro ao salvar os dados.
</x-alert>
```

**Tipos:** `info`, `success`, `warning`, `danger`

### 8. Stat Card (`<x-stat-card>`)

Card de estatística com tendência.

```blade
<x-stat-card
    title="Total de Equipamentos"
    value="1.234"
    trend="up"
    trendValue="+12%"
    :icon="'<svg>...</svg>'"
    iconBg="bg-indigo-100"
/>
```

---

## 🎨 Exemplo de Página Completa

```blade
@extends('layouts.tailadmin')

@section('content')
    {{-- Breadcrumbs --}}
    @php
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Equipamentos', 'url' => '']
        ];
    @endphp

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Equipamentos</h1>
        <x-button variant="primary" :icon="'<svg class=\'w-4 h-4\'>...</svg>'">
            Novo Equipamento
        </x-button>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <x-stat-card
            title="Total"
            value="1.234"
            trend="up"
            trendValue="+5%"
        />
        <x-stat-card
            title="Em Calibração"
            value="45"
        />
    </div>

    {{-- Alert --}}
    <x-alert type="info" dismissible class="mb-6">
        Próxima calibração em 15 dias.
    </x-alert>

    {{-- Content Card --}}
    <x-card title="Lista de Equipamentos">
        <x-table
            :headers="['Código', 'Tipo', 'Status', 'Ações']"
            :rows="$equipamentos"
        />
    </x-card>
@endsection
```

---

## 📝 Formulário Completo

```blade
<x-card title="Cadastro de Equipamento">
    <form action="{{ route('equipamentos.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-input
                label="Código Interno"
                name="codigo_interno"
                required
            />

            <x-select
                label="Tipo"
                name="tipo"
                :options="['Elétrica' => 'Elétrica', 'Mecânica' => 'Mecânica']"
                required
            />
        </div>

        <div class="flex gap-2 mt-6">
            <x-button variant="primary" type="submit">
                Salvar
            </x-button>
            <x-button variant="outline" type="button">
                Cancelar
            </x-button>
        </div>
    </form>
</x-card>
```

---

## 🌐 Layout Responsivo

### Grid System

```blade
{{-- 1 coluna em mobile, 2 em tablet, 3 em desktop --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <x-card>Card 1</x-card>
    <x-card>Card 2</x-card>
    <x-card>Card 3</x-card>
</div>

{{-- 1 coluna em mobile, 3 em desktop --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
    <div class="lg:col-span-2">Coluna principal</div>
    <div>Sidebar</div>
</div>
```

### Breakpoints Tailwind

- `sm:` - 640px
- `md:` - 768px
- `lg:` - 1024px
- `xl:` - 1280px
- `2xl:` - 1536px

---

## 🎨 Classes Utilitárias Comuns

### Espaçamento

- `p-4` - padding
- `m-4` - margin
- `gap-4` - gap em flex/grid
- `space-y-4` - espaço vertical entre elementos

### Cores

- `bg-{color}-{intensity}` - background
- `text-{color}-{intensity}` - texto
- `border-{color}-{intensity}` - borda

### Shadows & Borders

- `shadow-sm`, `shadow`, `shadow-lg`, `shadow-xl`
- `rounded-lg`, `rounded-xl`, `rounded-full`
- `border`, `border-2`

### Dark Mode

Adicione `dark:` antes de qualquer classe:

```blade
<div class="bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
    Conteúdo com dark mode
</div>
```

---

## 🚀 Próximos Componentes Sugeridos

1. **Modal** - Diálogos e pop-ups
2. **Tabs** - Navegação por abas
3. **Pagination** - Paginação de tabelas
4. **Dropdown** - Menus dropdown
5. **Calendar** - Seletor de datas
6. **Breadcrumbs** - Navegação em trilha
7. **Progress Bar** - Barra de progresso
8. **Toast** - Notificações temporárias
