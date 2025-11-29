@extends('layouts.app')

@section('title', 'Kanban CRM')

@section('content')
<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-64 bg-dark-800 border-r border-dark-700 flex flex-col">
        <div class="p-6 border-b border-dark-700">
            <h1 class="text-xl font-bold">CRM Premium</h1>
            <p class="text-xs text-gray-400 mt-1">Painel Administrativo</p>
        </div>
        
        <nav class="flex-1 p-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-dark-700 text-gray-400 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>
            <a href="{{ route('admin.kanban') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-dark-700 text-white font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/>
                </svg>
                Kanban
            </a>
            <a href="{{ route('admin.quiz-config') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-dark-700 text-gray-400 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Configurar Quiz
            </a>
        </nav>

        <div class="p-4 border-t border-dark-700">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-full bg-dark-700 flex items-center justify-center">
                    <span class="text-sm font-bold">A</span>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium">Admin</p>
                    <p class="text-xs text-gray-400">admin@example.com</p>
                </div>
            </div>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full px-4 py-2 text-sm text-red-400 hover:bg-dark-700 rounded-lg transition-colors">
                    Sair
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col overflow-hidden bg-dark-900">
        <!-- Header -->
        <header class="h-16 border-b border-dark-700 flex items-center justify-between px-6 bg-dark-800">
            <h2 class="font-bold text-xl">Kanban Board</h2>
        </header>

        <!-- Kanban Board -->
        <div class="flex-1 overflow-x-auto overflow-y-hidden p-6">
            <div class="flex h-full gap-6 min-w-[1200px]">
                
                @foreach(['Frio' => 'blue', 'Morno' => 'yellow', 'Quente' => 'orange', 'Ultra Quente' => 'red'] as $status => $color)
                <div class="flex-1 flex flex-col min-w-[300px] bg-dark-800 rounded-xl border border-dark-700">
                    <!-- Column Header -->
                    <div class="p-4 border-b border-dark-700 flex justify-between items-center">
                        <h3 class="font-bold text-lg">{{ $status }}</h3>
                        <span class="bg-dark-700 text-xs px-2 py-1 rounded-full text-gray-400">
                            {{ isset($leads[$status]) ? $leads[$status]->count() : 0 }}
                        </span>
                    </div>

                    <!-- Cards Container -->
                    <div class="flex-1 overflow-y-auto p-3 space-y-3 kanban-column" data-status="{{ $status }}">
                        @if(isset($leads[$status]))
                            @foreach($leads[$status] as $lead)
                            <div class="bg-dark-700 p-4 rounded-lg border border-dark-600 hover:border-dark-500 cursor-move group transition-all" data-id="{{ $lead->id }}">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-bold text-white">{{ $lead->name }}</h4>
                                    <span class="text-xs px-2 py-0.5 rounded bg-dark-900 text-{{ $color }}-400 border border-{{ $color }}-900/50">
                                        {{ $lead->score }} pts
                                    </span>
                                </div>
                                <div class="text-sm text-gray-400 mb-2">
                                    {{ $lead->branch ?? 'Sem ramo' }}
                                </div>
                                <div class="flex flex-wrap gap-1 mb-3">
                                    @if($lead->ai_tags)
                                        @foreach(array_slice($lead->ai_tags, 0, 2) as $tag)
                                        <span class="text-[10px] px-1.5 py-0.5 bg-dark-600 rounded text-gray-300">{{ $tag }}</span>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="flex justify-between items-center mt-2 pt-2 border-t border-dark-600">
                                    <span class="text-xs text-gray-500">{{ $lead->created_at->format('d/m H:i') }}</span>
                                    <a href="{{ route('admin.show', $lead->id) }}" class="text-xs text-blue-400 hover:text-blue-300 opacity-0 group-hover:opacity-100 transition-opacity">Ver detalhes →</a>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    document.querySelectorAll('.kanban-column').forEach(column => {
        new Sortable(column, {
            group: 'kanban',
            animation: 150,
            ghostClass: 'opacity-50',
            onEnd: function (evt) {
                const leadId = evt.item.getAttribute('data-id');
                const newStatus = evt.to.getAttribute('data-status');
                
                // Update status via API
                fetch(`/admin/leads/${leadId}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ status: newStatus })
                });
            }
        });
    });
</script>
@endsection
