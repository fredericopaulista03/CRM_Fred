@extends('layouts.app')

@section('title', 'Kanban CRM')

@section('content')
<div class="flex flex-col h-screen overflow-hidden">
    <!-- Header -->
    <header class="h-16 border-b border-dark-700 flex items-center justify-between px-6 bg-dark-800">
        <div class="font-bold text-xl">CRM Dashboard</div>
        <div class="flex items-center gap-4">
            <span class="text-sm text-gray-400">Admin</span>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-sm text-red-400 hover:text-red-300">Sair</button>
            </form>
        </div>
    </header>

    <!-- Kanban Board -->
    <div class="flex-grow overflow-x-auto overflow-y-hidden p-6">
        <div class="flex h-full gap-6 min-w-[1200px]">
            
            @foreach(['Frio' => 'blue', 'Morno' => 'yellow', 'Quente' => 'orange', 'Ultra Quente' => 'red'] as $status => $color)
            <div class="flex-1 flex flex-col min-w-[300px] bg-dark-800 rounded-xl border border-dark-700">
                <!-- Column Header -->
                <div class="p-4 border-b border-dark-700 flex justify-between items-center">
                    <h3 class="font-bold text-lg">{{ $status }}</h3>
                    <span class="bg-dark-700 text-xs px-2 py-1 rounded-full text-gray-400">
                        {{ $leads[$status]->count() ?? 0 }}
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
