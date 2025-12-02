# Componentes Reutilizáveis - Sistema de Calibração

Este documento descreve os componentes reutilizáveis criados para o sistema de calibração, inspirados no template TailAdmin.

## 📦 Componentes Criados

### 1. Calendar (Calendário)

**Arquivo:** `resources/views/components/calendar.blade.php`

Componente de calendário interativo usando FullCalendar.js com suporte a eventos, drag-and-drop e localização em PT-BR.

#### Uso Básico:

```blade
<x-calendar
    title="Agenda de Calibrações"
    :events="[
        [
            'title' => 'Calibração Balança',
            'start' => '2025-12-10',
            'backgroundColor' => '#3B82F6'
        ]
    ]"
/>
```

#### Props Disponíveis:

-   `id` - ID único do calendário (gerado automaticamente)
-   `title` - Título do calendário
-   `events` - Array de eventos (formato FullCalendar)
-   `height` - Altura mínima do calendário (padrão: 600px)

#### Estrutura de Evento:

```php
[
    'title' => 'Nome do Evento',
    'start' => '2025-12-10',           // Data início (YYYY-MM-DD ou ISO 8601)
    'end' => '2025-12-10T15:00:00',    // Data fim (opcional)
    'backgroundColor' => '#3B82F6',     // Cor de fundo
    'borderColor' => '#3B82F6'          // Cor da borda
]
```

#### Cores Sugeridas:

-   Azul: `#3B82F6` (Padrão)
-   Verde: `#10B981` (Sucesso)
-   Amarelo: `#F59E0B` (Atenção)
-   Vermelho: `#EF4444` (Urgente)
-   Roxo: `#8B5CF6` (Revisão)

---

### 2. TaskList (Lista de Tarefas)

**Arquivos:**

-   `resources/views/components/tasklist.blade.php`
-   `resources/views/components/task-item.blade.php`

Componente de lista de tarefas com busca, filtros por prioridade/status e checkbox de conclusão.

#### Uso Básico:

```blade
<x-tasklist
    title="Atividades Pendentes"
    :tasks="[
        [
            'id' => 1,
            'title' => 'Calibração Balança',
            'description' => 'Descrição detalhada',
            'priority' => 'alta',
            'status' => 'pendente',
            'due_date' => '2025-12-10',
            'assignee' => 'João Silva',
            'tags' => 'balança,urgente'
        ]
    ]"
/>
```

#### Props Disponíveis:

-   `id` - ID único da lista (gerado automaticamente)
-   `title` - Título da lista
-   `tasks` - Array de tarefas
-   `showSearch` - Mostrar campo de busca (padrão: true)
-   `showFilters` - Mostrar filtros (padrão: true)

#### Estrutura de Tarefa:

```php
[
    'id' => 1,                          // ID único
    'title' => 'Título da Tarefa',     // Obrigatório
    'description' => 'Descrição',       // Opcional
    'priority' => 'alta',               // alta|media|baixa
    'status' => 'pendente',             // pendente|em_andamento|concluida
    'due_date' => '2025-12-10',        // Data de entrega (YYYY-MM-DD)
    'assignee' => 'Nome Responsável',   // Opcional
    'tags' => 'tag1,tag2,tag3'         // Tags separadas por vírgula
]
```

#### Prioridades:

-   `alta` - Badge vermelho
-   `media` - Badge amarelo
-   `baixa` - Badge verde

#### Status:

-   `pendente` - Borda cinza
-   `em_andamento` - Borda/fundo azul
-   `concluida` - Borda/fundo verde (com risco no título)

---

### 3. Kanban (Quadro Kanban)

**Arquivos:**

-   `resources/views/components/kanban.blade.php`
-   `resources/views/components/kanban-card.blade.php`

Quadro Kanban com drag-and-drop entre colunas, cards personalizáveis e contadores automáticos.

#### Uso Básico:

```blade
<x-kanban
    title="Fluxo de Calibração"
    :columns="[
        'backlog' => 'Backlog',
        'todo' => 'A Fazer',
        'in_progress' => 'Em Andamento',
        'review' => 'Em Revisão',
        'done' => 'Concluído'
    ]"
    :tasks="[
        [
            'id' => 1,
            'title' => 'Calibração Balança',
            'description' => 'Descrição',
            'column' => 'in_progress',
            'priority' => 'alta',
            'due_date' => '2025-12-10',
            'assignee' => 'João Silva',
            'tags' => 'balança,urgente',
            'checklist_done' => 3,
            'checklist_total' => 5
        ]
    ]"
/>
```

#### Props Disponíveis:

-   `id` - ID único do kanban (gerado automaticamente)
-   `title` - Título do quadro
-   `columns` - Array de colunas (key => label)
-   `tasks` - Array de cards/tarefas

#### Estrutura de Card:

```php
[
    'id' => 1,                          // ID único
    'title' => 'Título do Card',       // Obrigatório
    'description' => 'Descrição',       // Opcional
    'column' => 'in_progress',          // ID da coluna (obrigatório)
    'priority' => 'alta',               // alta|media|baixa
    'due_date' => '2025-12-10',        // Data (YYYY-MM-DD)
    'assignee' => 'Nome Responsável',   // Opcional
    'tags' => 'tag1,tag2',             // Tags separadas por vírgula
    'checklist_done' => 3,              // Itens concluídos (opcional)
    'checklist_total' => 5              // Total de itens (opcional)
]
```

#### Colunas Padrão:

```php
[
    'backlog' => 'Backlog',
    'todo' => 'A Fazer',
    'in_progress' => 'Em Andamento',
    'review' => 'Em Revisão',
    'done' => 'Concluído'
]
```

Você pode personalizar as colunas conforme necessário:

```php
[
    'solicitado' => 'Solicitado',
    'aguardando_equipamento' => 'Aguardando Equipamento',
    'calibrando' => 'Em Calibração',
    'emitindo_certificado' => 'Emitindo Certificado',
    'finalizado' => 'Finalizado'
]
```

---

## 🎨 Exemplos de Uso

### Página de Calendário Completa

Ver: `resources/views/examples/calendar-example.blade.php`

### Página de Lista de Tarefas Completa

Ver: `resources/views/examples/tasklist-example.blade.php`

### Página de Quadro Kanban Completa

Ver: `resources/views/examples/kanban-example.blade.php`

---

## 🚀 Como Usar nos Controllers

### Exemplo: CalendarioController

```php
<?php

namespace App\Http\Controllers;

use App\Models\Calibracao;
use Illuminate\Http\Request;

class CalendarioController extends Controller
{
    public function index()
    {
        // Buscar calibrações programadas
        $calibracoes = Calibracao::with('equipamento')
            ->whereNotNull('data_programada')
            ->get();

        // Formatar para eventos do calendário
        $events = $calibracoes->map(function($cal) {
            return [
                'id' => $cal->id,
                'title' => $cal->equipamento->equipamento_fabricante . ' ' .
                          $cal->equipamento->equipamento_modelo,
                'start' => $cal->data_programada,
                'backgroundColor' => $this->getPriorityColor($cal->prioridade),
                'borderColor' => $this->getPriorityColor($cal->prioridade),
                'extendedProps' => [
                    'equipamento_id' => $cal->equipamento_id,
                    'laboratorio_id' => $cal->laboratorio_id,
                ]
            ];
        })->toArray();

        return view('calendario.index', compact('events'));
    }

    private function getPriorityColor($prioridade)
    {
        return match($prioridade) {
            'alta' => '#EF4444',
            'media' => '#F59E0B',
            'baixa' => '#10B981',
            default => '#3B82F6'
        };
    }
}
```

### Exemplo: TarefasController

```php
<?php

namespace App\Http\Controllers;

use App\Models\Tarefa;
use Illuminate\Http\Request;

class TarefasController extends Controller
{
    public function index()
    {
        $tasks = Tarefa::with('responsavel')
            ->orderBy('priority', 'desc')
            ->orderBy('due_date', 'asc')
            ->get()
            ->map(function($task) {
                return [
                    'id' => $task->id,
                    'title' => $task->titulo,
                    'description' => $task->descricao,
                    'priority' => $task->prioridade,
                    'status' => $task->status,
                    'due_date' => $task->data_entrega,
                    'assignee' => $task->responsavel->name ?? null,
                    'tags' => $task->tags
                ];
            })->toArray();

        return view('tarefas.index', compact('tasks'));
    }
}
```

### Exemplo: KanbanController

```php
<?php

namespace App\Http\Controllers;

use App\Models\Calibracao;
use Illuminate\Http\Request;

class KanbanController extends Controller
{
    public function index()
    {
        $calibracoes = Calibracao::with('equipamento', 'responsavel')
            ->whereIn('status', ['solicitado', 'em_calibracao', 'revisao', 'concluido'])
            ->get();

        $tasks = $calibracoes->map(function($cal) {
            return [
                'id' => $cal->id,
                'title' => $cal->equipamento->equipamento_tipo . ' - ' .
                          $cal->equipamento->equipamento_modelo,
                'description' => $cal->observacoes,
                'column' => $this->mapStatus($cal->status),
                'priority' => $cal->prioridade,
                'due_date' => $cal->data_programada,
                'assignee' => $cal->responsavel->name ?? null,
                'tags' => $cal->equipamento->equipamento_tipo . ',' . $cal->laboratorio->nome
            ];
        })->toArray();

        $columns = [
            'solicitado' => 'Solicitado',
            'em_calibracao' => 'Em Calibração',
            'revisao' => 'Em Revisão',
            'concluido' => 'Concluído'
        ];

        return view('kanban.index', compact('tasks', 'columns'));
    }

    private function mapStatus($status)
    {
        return match($status) {
            'pendente' => 'solicitado',
            'em_andamento' => 'em_calibracao',
            'aguardando_aprovacao' => 'revisao',
            'concluida' => 'concluido',
            default => 'solicitado'
        };
    }
}
```

---

## 📝 Blade Views de Exemplo

### calendario/index.blade.php

```blade
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <x-calendar
        title="Agenda de Calibrações"
        :events="$events"
    />
</div>
@endsection
```

### tarefas/index.blade.php

```blade
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <x-tasklist
        title="Minhas Tarefas"
        :tasks="$tasks"
    />
</div>
@endsection
```

### kanban/index.blade.php

```blade
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <x-kanban
        title="Fluxo de Calibração"
        :columns="$columns"
        :tasks="$tasks"
    />
</div>
@endsection
```

---

## 🎯 Recursos dos Componentes

### Calendar

✅ Visualizações: Mês, Semana, Dia, Lista  
✅ Drag-and-drop de eventos  
✅ Modal para criar/editar eventos  
✅ Cores personalizáveis por evento  
✅ Localização PT-BR  
✅ Responsivo

### TaskList

✅ Busca em tempo real  
✅ Filtros por prioridade e status  
✅ Checkbox para marcar como concluída  
✅ Badges de prioridade coloridos  
✅ Ações de editar/excluir  
✅ Tags visuais  
✅ Responsivo

### Kanban

✅ Drag-and-drop entre colunas  
✅ Colunas customizáveis  
✅ Contadores automáticos por coluna  
✅ Cards com prioridade visual  
✅ Checklist progress  
✅ Ações de editar/excluir  
✅ Scroll horizontal para muitas colunas

---

## 🔧 Customização

### Alterar Cores do Tema

Edite as classes Tailwind nos componentes:

```blade
<!-- Alterar cor primária de azul para verde -->
bg-blue-600 → bg-green-600
text-blue-600 → text-green-600
border-blue-500 → border-green-500
```

### Adicionar Novos Campos

Edite a estrutura de dados e os componentes para incluir novos campos conforme necessário.

---

## 📦 Dependências

### Calendar

-   FullCalendar 6.1.10
-   Alpine.js 3.x (para modais)

### TaskList e Kanban

-   Tailwind CSS 3.x
-   Alpine.js 3.x

Todas as dependências são carregadas via CDN nos exemplos.

---

## 🚀 Próximos Passos

1. Integrar com banco de dados real
2. Adicionar rotas para CRUD de tarefas/eventos
3. Implementar API para drag-and-drop
4. Adicionar notificações em tempo real
5. Criar filtros avançados
6. Adicionar exportação de dados

---

## 📞 Suporte

Para dúvidas sobre os componentes, consulte os arquivos de exemplo em:

-   `resources/views/examples/calendar-example.blade.php`
-   `resources/views/examples/tasklist-example.blade.php`
-   `resources/views/examples/kanban-example.blade.php`
