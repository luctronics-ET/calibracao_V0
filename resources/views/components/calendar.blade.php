@props([
    'id' => 'calendar-' . uniqid(),
    'title' => 'Calendário',
    'events' => [],
    'height' => '600px',
])

<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    @if($title)
    <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-800 sm:px-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">{{ $title }}</h3>
    </div>
    @endif

    <div class="p-5 sm:p-6">
        <div id="{{ $id }}" style="min-height: {{ $height }};"></div>
    </div>
</div>

<!-- Modal para criar/editar eventos -->
<div
    id="modal-{{ $id }}"
    class="fixed inset-0 items-center justify-center hidden p-5 overflow-y-auto z-99999"
    x-data="{ open: false }"
    x-show="open"
    x-cloak
    @modal-open.window="open = true"
    @modal-close.window="open = false"
>
    <div
        @click="open = false"
        class="fixed inset-0 h-full w-full bg-gray-900/50 backdrop-blur-sm"
    ></div>

    <div class="relative flex w-full max-w-[600px] flex-col overflow-y-auto rounded-2xl bg-white p-6 dark:bg-gray-900 lg:p-8 mx-auto mt-10">
        <!-- Botão Fechar -->
        <button
            @click="open = false"
            class="absolute right-5 top-5 flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200 hover:text-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
        >
            <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.29289 5.29289C5.68342 4.90237 6.31658 4.90237 6.70711 5.29289L10 8.58579L13.2929 5.29289C13.6834 4.90237 14.3166 4.90237 14.7071 5.29289C15.0976 5.68342 15.0976 6.31658 14.7071 6.70711L11.4142 10L14.7071 13.2929C15.0976 13.6834 15.0976 14.3166 14.7071 14.7071C14.3166 15.0976 13.6834 15.0976 13.2929 14.7071L10 11.4142L6.70711 14.7071C6.31658 15.0976 5.68342 15.0976 5.29289 14.7071C4.90237 14.3166 4.90237 13.6834 5.29289 13.2929L8.58579 10L5.29289 6.70711C4.90237 6.31658 4.90237 5.68342 5.29289 5.29289Z"/>
            </svg>
        </button>

        <form id="form-{{ $id }}" action="#" method="POST">
            @csrf
            <h5 class="mb-2 text-xl font-semibold text-gray-800 dark:text-white/90">
                Adicionar/Editar Evento
            </h5>
            <p class="mb-6 text-sm text-gray-500 dark:text-gray-400">
                Agende ou edite um evento no calendário
            </p>

            <!-- Título do Evento -->
            <div class="mb-4">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Título do Evento
                </label>
                <input
                    id="event-title-{{ $id }}"
                    type="text"
                    name="title"
                    required
                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-blue-600"
                    placeholder="Digite o título do evento"
                />
            </div>

            <!-- Data Início -->
            <div class="mb-4">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Data de Início
                </label>
                <input
                    id="event-start-{{ $id }}"
                    type="datetime-local"
                    name="start"
                    required
                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-blue-600"
                />
            </div>

            <!-- Data Fim -->
            <div class="mb-4">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Data de Término
                </label>
                <input
                    id="event-end-{{ $id }}"
                    type="datetime-local"
                    name="end"
                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-blue-600"
                />
            </div>

            <!-- Cor do Evento -->
            <div class="mb-6">
                <label class="mb-3 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Cor do Evento
                </label>
                <div class="flex flex-wrap gap-3">
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="color" value="#3B82F6" class="sr-only" checked>
                        <span class="flex h-8 w-8 rounded-full bg-blue-500 ring-2 ring-offset-2 ring-blue-500"></span>
                    </label>
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="color" value="#10B981" class="sr-only">
                        <span class="flex h-8 w-8 rounded-full bg-green-500 hover:ring-2 hover:ring-offset-2 hover:ring-green-500"></span>
                    </label>
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="color" value="#F59E0B" class="sr-only">
                        <span class="flex h-8 w-8 rounded-full bg-amber-500 hover:ring-2 hover:ring-offset-2 hover:ring-amber-500"></span>
                    </label>
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="color" value="#EF4444" class="sr-only">
                        <span class="flex h-8 w-8 rounded-full bg-red-500 hover:ring-2 hover:ring-offset-2 hover:ring-red-500"></span>
                    </label>
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="color" value="#8B5CF6" class="sr-only">
                        <span class="flex h-8 w-8 rounded-full bg-purple-500 hover:ring-2 hover:ring-offset-2 hover:ring-purple-500"></span>
                    </label>
                </div>
            </div>

            <!-- Botões -->
            <div class="flex gap-3">
                <button
                    type="submit"
                    class="flex-1 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    Salvar Evento
                </button>
                <button
                    type="button"
                    @click="open = false"
                    class="flex-1 rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800"
                >
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/locales/pt-br.global.min.js'></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('{{ $id }}');

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'pt-br',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        buttonText: {
            today: 'Hoje',
            month: 'Mês',
            week: 'Semana',
            day: 'Dia',
            list: 'Lista'
        },
        events: @json($events),
        editable: true,
        selectable: true,
        selectMirror: true,
        dayMaxEvents: true,

        // Ao clicar em uma data
        select: function(info) {
            document.getElementById('event-title-{{ $id }}').value = '';
            document.getElementById('event-start-{{ $id }}').value = info.startStr.slice(0, 16);
            document.getElementById('event-end-{{ $id }}').value = info.endStr ? info.endStr.slice(0, 16) : '';
            window.dispatchEvent(new CustomEvent('modal-open'));
        },

        // Ao clicar em um evento
        eventClick: function(info) {
            document.getElementById('event-title-{{ $id }}').value = info.event.title;
            document.getElementById('event-start-{{ $id }}').value = info.event.startStr.slice(0, 16);
            document.getElementById('event-end-{{ $id }}').value = info.event.endStr ? info.event.endStr.slice(0, 16) : '';
            window.dispatchEvent(new CustomEvent('modal-open'));
        }
    });

    calendar.render();

    // Salvar evento
    document.getElementById('form-{{ $id }}').addEventListener('submit', function(e) {
        e.preventDefault();

        const title = document.getElementById('event-title-{{ $id }}').value;
        const start = document.getElementById('event-start-{{ $id }}').value;
        const end = document.getElementById('event-end-{{ $id }}').value;
        const color = document.querySelector('input[name="color"]:checked').value;

        calendar.addEvent({
            title: title,
            start: start,
            end: end || start,
            backgroundColor: color,
            borderColor: color
        });

        window.dispatchEvent(new CustomEvent('modal-close'));
        this.reset();
    });
});
</script>
@endpush
