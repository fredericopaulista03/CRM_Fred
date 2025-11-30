@extends('layouts.app')

@section('title', 'Configurações')

@section('content')
<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    @include('admin.partials.sidebar', ['active' => 'settings'])

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto bg-dark-900">
        <div class="p-8">
            <h2 class="text-3xl font-bold mb-8">Configurações</h2>

            @if(session('success'))
            <div class="mb-6 p-4 bg-green-900/30 border border-green-900/50 rounded-lg text-green-200">
                {{ session('success') }}
            </div>
            @endif

            <form action="{{ route('admin.settings.update') }}" method="POST" class="max-w-4xl">
                @csrf
                
                <!-- AI Configuration -->
                <div class="bg-dark-800 p-6 rounded-xl border border-dark-700 mb-6">
                    <h3 class="text-xl font-bold mb-4 flex items-center gap-2">
                        <span>✨</span> Configuração da IA (Gemini)
                    </h3>
                    <div>
                        <label class="block text-sm font-medium mb-2">Chave da API (Gemini API Key)</label>
                        <div class="flex gap-2">
                            <input type="password" name="gemini_api_key" value="{{ $settings['gemini_api_key'] }}" class="flex-1 p-3 bg-dark-700 border border-dark-600 rounded-lg focus:border-blue-500 outline-none font-mono text-sm" placeholder="AIzaSy...">
                        </div>
                        <p class="text-xs text-gray-500 mt-2">
                            A chave será usada para analisar os leads. Se deixar em branco, o sistema tentará usar a chave do arquivo .env.
                            <a href="https://aistudio.google.com/app/apikey" target="_blank" class="text-blue-400 hover:underline">Gerar chave aqui</a>.
                        </p>
                    </div>
                </div>

                <!-- Google Analytics -->
                <div class="bg-dark-800 p-6 rounded-xl border border-dark-700 mb-6">
                    <h3 class="text-xl font-bold mb-4">Google Analytics</h3>
                    <div>
                        <label class="block text-sm font-medium mb-2">Measurement ID (G-XXXXXXXXXX)</label>
                        <input type="text" name="google_analytics" value="{{ $settings['google_analytics'] }}" class="w-full p-3 bg-dark-700 border border-dark-600 rounded-lg focus:border-blue-500 outline-none font-mono text-sm" placeholder="G-XXXXXXXXXX">
                        <p class="text-xs text-gray-500 mt-2">Cole aqui o ID de medição do Google Analytics 4</p>
                    </div>
                </div>

                <!-- Google Tag Manager -->
                <div class="bg-dark-800 p-6 rounded-xl border border-dark-700 mb-6">
                    <h3 class="text-xl font-bold mb-4">Google Tag Manager</h3>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-2">Script para &lt;head&gt;</label>
                        <textarea name="gtm_head" rows="6" class="w-full p-3 bg-dark-700 border border-dark-600 rounded-lg focus:border-blue-500 outline-none font-mono text-xs" placeholder="<!-- Google Tag Manager -->&#10;<script>...</script>">{{ $settings['gtm_head'] }}</textarea>
                        <p class="text-xs text-gray-500 mt-2">Cole o código GTM que deve ser inserido no &lt;head&gt;</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Script para &lt;body&gt;</label>
                        <textarea name="gtm_body" rows="4" class="w-full p-3 bg-dark-700 border border-dark-600 rounded-lg focus:border-blue-500 outline-none font-mono text-xs" placeholder="<!-- Google Tag Manager (noscript) -->&#10;<noscript>...</noscript>">{{ $settings['gtm_body'] }}</textarea>
                        <p class="text-xs text-gray-500 mt-2">Cole o código GTM que deve ser inserido logo após a tag &lt;body&gt;</p>
                    </div>
                </div>

                <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-500 rounded-lg font-bold transition-colors">
                    Salvar Configurações
                </button>
            </form>
        </div>
    </main>
</div>
@endsection
