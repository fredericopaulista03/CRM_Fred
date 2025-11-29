<aside class="w-64 bg-dark-800 border-r border-dark-700 flex flex-col">
    <div class="p-6 border-b border-dark-700">
        <h1 class="text-xl font-bold">CRM Premium</h1>
        <p class="text-xs text-gray-400 mt-1">Painel Administrativo</p>
    </div>
    
    <nav class="flex-1 p-4 space-y-2">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ $active === 'dashboard' ? 'bg-dark-700 text-white font-medium' : 'hover:bg-dark-700 text-gray-400 hover:text-white transition-colors' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Dashboard
        </a>
        <a href="{{ route('admin.kanban') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ $active === 'kanban' ? 'bg-dark-700 text-white font-medium' : 'hover:bg-dark-700 text-gray-400 hover:text-white transition-colors' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/>
            </svg>
            Kanban
        </a>
        <a href="{{ route('admin.pages') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ $active === 'pages' ? 'bg-dark-700 text-white font-medium' : 'hover:bg-dark-700 text-gray-400 hover:text-white transition-colors' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Páginas
        </a>
        <a href="{{ route('admin.quiz-config') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ $active === 'quiz-config' ? 'bg-dark-700 text-white font-medium' : 'hover:bg-dark-700 text-gray-400 hover:text-white transition-colors' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Configurar Quiz
        </a>
        <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ $active === 'settings' ? 'bg-dark-700 text-white font-medium' : 'hover:bg-dark-700 text-gray-400 hover:text-white transition-colors' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Configurações
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
