@extends('layouts.app')

@section('title', 'Detalhes do Lead')

@section('content')
<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    @include('admin.partials.sidebar', ['active' => 'kanban'])

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto bg-dark-900">
        <div class="p-8 max-w-5xl mx-auto w-full">
            <a href="{{ route('admin.kanban') }}" class="text-gray-400 hover:text-white mb-6 inline-block">← Voltar para Kanban</a>
            
            @if(session('success'))
            <div class="mb-6 p-4 bg-green-900/30 border border-green-900/50 rounded-lg text-green-200">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="mb-6 p-4 bg-red-900/30 border border-red-900/50 rounded-lg text-red-200">
                {{ session('error') }}
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Main Info -->
                <div class="md:col-span-2 space-y-6">
                    <div class="bg-dark-800 p-6 rounded-xl border border-dark-700">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h1 class="text-3xl font-bold text-white mb-1">{{ $lead->name }}</h1>
                                <p class="text-gray-400">{{ $lead->email }} • {{ $lead->phone }}</p>
                            </div>
                            <span class="px-3 py-1 rounded-full bg-blue-900/30 text-blue-400 border border-blue-900/50 text-sm font-medium">
                                {{ $lead->kanban_status }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label class="text-xs text-gray-500 uppercase tracking-wider">Faturamento</label>
                                <p class="text-lg font-medium">{{ $lead->revenue_raw }}</p>
                                <p class="text-xs text-gray-400">{{ $lead->revenue_category }}</p>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500 uppercase tracking-wider">Investimento</label>
                                <p class="text-lg font-medium">{{ $lead->investment_raw }}</p>
                                <p class="text-xs text-gray-400">{{ $lead->investment_category }}</p>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500 uppercase tracking-wider">Ramo</label>
                                <p class="text-lg font-medium">{{ $lead->branch ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500 uppercase tracking-wider">Instagram</label>
                                <p class="text-lg font-medium">{{ $lead->instagram ?? '-' }}</p>
                            </div>
                            <div class="col-span-2">
                                <label class="text-xs text-gray-500 uppercase tracking-wider">Objetivo</label>
                                <p class="text-lg font-medium">{{ $lead->objective ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- AI Insights -->
                    <div class="bg-dark-800 p-6 rounded-xl border border-dark-700 relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-4 opacity-10">
                            <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"/><path d="M12 6a1 1 0 0 0-1 1v4.59l-3.29-3.3a1 1 0 0 0-1.42 1.42l5 5a1 1 0 0 0 1.42 0l5-5a1 1 0 0 0-1.42-1.42L13 11.59V7a1 1 0 0 0-1-1z"/></svg>
                        </div>
                        <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
                            <span>✨</span> Análise da IA
                        </h2>
                        
                        <div class="mb-6">
                            <div class="flex items-center gap-4 mb-2">
                                <div class="flex-1 h-2 bg-dark-600 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-blue-500 to-purple-500" style="width: {{ $lead->score }}%"></div>
                                </div>
                                <span class="font-bold text-xl">{{ $lead->score }}/100</span>
                            </div>
                            <p class="text-sm text-gray-400">Potencial do Lead</p>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-sm font-bold text-gray-300 mb-2">Tags Identificadas</h3>
                            <div class="flex flex-wrap gap-2">
                                @if($lead->ai_tags)
                                    @foreach($lead->ai_tags as $tag)
                                    <span class="px-3 py-1 bg-dark-600 rounded-lg text-sm border border-dark-500">{{ $tag }}</span>
                                    @endforeach
                                @else
                                    <span class="text-gray-500 italic">Nenhuma tag gerada.</span>
                                @endif
                            </div>
                        </div>

                        <div>
                            <h3 class="text-sm font-bold text-gray-300 mb-2">Urgência</h3>
                            <span class="px-3 py-1 rounded bg-{{ $lead->urgency === 'alta' ? 'red' : ($lead->urgency === 'média' ? 'yellow' : 'green') }}-900/30 text-{{ $lead->urgency === 'alta' ? 'red' : ($lead->urgency === 'média' ? 'yellow' : 'green') }}-400 border border-{{ $lead->urgency === 'alta' ? 'red' : ($lead->urgency === 'média' ? 'yellow' : 'green') }}-900/50 uppercase text-xs font-bold">
                                {{ $lead->urgency ?? 'N/A' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="space-y-6">
                    <div class="bg-dark-800 p-6 rounded-xl border border-dark-700">
                        <h3 class="font-bold mb-4">Ações</h3>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $lead->phone) }}" target="_blank" class="block w-full py-3 bg-green-600 hover:bg-green-500 text-white text-center rounded-lg font-bold transition-colors mb-3">
                            Chamar no WhatsApp
                        </a>
                        <a href="mailto:{{ $lead->email }}" class="block w-full py-3 bg-dark-700 hover:bg-dark-600 text-white text-center rounded-lg font-bold transition-colors">
                            Enviar Email
                        </a>
                    </div>
                    
                    <div class="bg-dark-800 p-6 rounded-xl border border-dark-700">
                        <h3 class="font-bold mb-4">Reanalisar</h3>
                        <p class="text-sm text-gray-400 mb-4">Se achar que a classificação está incorreta, você pode pedir para a IA analisar novamente.</p>
                        <form action="{{ route('admin.reanalyze', $lead->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="block w-full py-3 border border-dark-600 hover:bg-dark-700 text-gray-300 text-center rounded-lg font-medium transition-colors">
                                Reanalisar com IA
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
