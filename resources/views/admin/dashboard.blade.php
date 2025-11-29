@extends('layouts.app')

@section('title', 'Dashboard CRM')

@section('content')
<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    @include('admin.partials.sidebar', ['active' => 'dashboard'])

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto bg-dark-900">
        <div class="p-8">
            <h2 class="text-3xl font-bold mb-8">Dashboard</h2>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-dark-800 p-6 rounded-xl border border-dark-700">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-gray-400 text-sm">Total de Leads</span>
                        <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <p class="text-4xl font-bold">{{ $totalLeads }}</p>
                </div>

                <div class="bg-dark-800 p-6 rounded-xl border border-dark-700">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-gray-400 text-sm">Frios</span>
                        <div class="w-3 h-3 rounded-full bg-blue-400"></div>
                    </div>
                    <p class="text-4xl font-bold">{{ $leadsByStatus['Frio'] ?? 0 }}</p>
                </div>

                <div class="bg-dark-800 p-6 rounded-xl border border-dark-700">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-gray-400 text-sm">Quentes</span>
                        <div class="w-3 h-3 rounded-full bg-orange-400"></div>
                    </div>
                    <p class="text-4xl font-bold">{{ ($leadsByStatus['Quente'] ?? 0) + ($leadsByStatus['Ultra Quente'] ?? 0) }}</p>
                </div>

                <div class="bg-dark-800 p-6 rounded-xl border border-dark-700">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-gray-400 text-sm">Score Médio</span>
                        <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <p class="text-4xl font-bold">{{ number_format($avgScore ?? 0, 0) }}</p>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Leads por Estágio -->
                <div class="bg-dark-800 p-6 rounded-xl border border-dark-700">
                    <h3 class="text-xl font-bold mb-4">Leads por Estágio</h3>
                    <div style="height: 250px; position: relative;">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>

                <!-- Distribuição de Score -->
                <div class="bg-dark-800 p-6 rounded-xl border border-dark-700">
                    <h3 class="text-xl font-bold mb-6">Distribuição de Potencial</h3>
                    <div class="space-y-4">
                        @php
                            $statuses = ['Frio' => 'blue', 'Morno' => 'yellow', 'Quente' => 'orange', 'Ultra Quente' => 'red'];
                        @endphp
                        @foreach($statuses as $status => $color)
                            @php
                                $count = $leadsByStatus[$status] ?? 0;
                                $percentage = $totalLeads > 0 ? ($count / $totalLeads) * 100 : 0;
                            @endphp
                            <div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-sm font-medium">{{ $status }}</span>
                                    <span class="text-sm text-gray-400">{{ $count }} ({{ number_format($percentage, 1) }}%)</span>
                                </div>
                                <div class="h-3 bg-dark-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-{{ $color }}-400 transition-all duration-500" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Recent Leads -->
            <div class="bg-dark-800 p-6 rounded-xl border border-dark-700">
                <h3 class="text-xl font-bold mb-6">Leads Recentes</h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-dark-700">
                                <th class="text-left py-3 px-4 text-sm font-medium text-gray-400">Nome</th>
                                <th class="text-left py-3 px-4 text-sm font-medium text-gray-400">Email</th>
                                <th class="text-left py-3 px-4 text-sm font-medium text-gray-400">Status</th>
                                <th class="text-left py-3 px-4 text-sm font-medium text-gray-400">Score</th>
                                <th class="text-left py-3 px-4 text-sm font-medium text-gray-400">Data</th>
                                <th class="text-left py-3 px-4 text-sm font-medium text-gray-400">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentLeads as $lead)
                            <tr class="border-b border-dark-700/50 hover:bg-dark-700/30 transition-colors">
                                <td class="py-3 px-4">{{ $lead->name }}</td>
                                <td class="py-3 px-4 text-gray-400">{{ $lead->email }}</td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 text-xs rounded-full bg-dark-700 border border-dark-600">
                                        {{ $lead->kanban_status }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 font-bold">{{ $lead->score }}</td>
                                <td class="py-3 px-4 text-gray-400 text-sm">{{ $lead->created_at->format('d/m/Y H:i') }}</td>
                                <td class="py-3 px-4">
                                    <a href="{{ route('admin.show', $lead->id) }}" class="text-blue-400 hover:text-blue-300 text-sm">
                                        Ver detalhes →
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-400">Nenhum lead cadastrado ainda.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Status Chart
    const ctx = document.getElementById('statusChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Frio', 'Morno', 'Quente', 'Ultra Quente'],
            datasets: [{
                data: [
                    {{ $leadsByStatus['Frio'] ?? 0 }},
                    {{ $leadsByStatus['Morno'] ?? 0 }},
                    {{ $leadsByStatus['Quente'] ?? 0 }},
                    {{ $leadsByStatus['Ultra Quente'] ?? 0 }}
                ],
                backgroundColor: [
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(234, 179, 8, 0.8)',
                    'rgba(249, 115, 22, 0.8)',
                    'rgba(239, 68, 68, 0.8)'
                ],
                borderColor: [
                    'rgba(59, 130, 246, 1)',
                    'rgba(234, 179, 8, 1)',
                    'rgba(249, 115, 22, 1)',
                    'rgba(239, 68, 68, 1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#9ca3af',
                        padding: 20,
                        font: {
                            size: 12
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
