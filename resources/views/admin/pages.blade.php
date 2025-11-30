@extends('layouts.app')

@section('title', 'Gerenciar Páginas')

@section('content')
<div class="flex h-screen overflow-hidden" x-data="pagesManager()">
    <!-- Sidebar -->
    @include('admin.partials.sidebar', ['active' => 'pages'])

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto bg-dark-900">
        <div class="p-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold">Páginas de Quiz</h2>
                <button @click="openModal()" class="px-6 py-3 bg-blue-600 hover:bg-blue-500 rounded-lg font-bold transition-colors">
                    + Nova Página
                </button>
            </div>

            @if(session('success'))
            <div class="mb-6 p-4 bg-green-900/30 border border-green-900/50 rounded-lg text-green-200">
                {{ session('success') }}
            </div>
            @endif

            <!-- Pages List -->
            <div class="bg-dark-800 rounded-xl border border-dark-700 overflow-hidden">
                <table class="w-full">
                    <thead class="bg-dark-700">
                        <tr>
                            <th class="text-left py-4 px-6 text-sm font-medium text-gray-400">Título</th>
                            <th class="text-left py-4 px-6 text-sm font-medium text-gray-400">Slug (URL)</th>
                            <th class="text-left py-4 px-6 text-sm font-medium text-gray-400">Status</th>
                            <th class="text-left py-4 px-6 text-sm font-medium text-gray-400">Criado em</th>
                            <th class="text-left py-4 px-6 text-sm font-medium text-gray-400">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pages as $page)
                        <tr class="border-t border-dark-700 hover:bg-dark-700/30 transition-colors">
                            <td class="py-4 px-6 font-medium">{{ $page->title }}</td>
                            <td class="py-4 px-6">
                                <code class="text-sm text-blue-400">/quiz/{{ $page->slug }}</code>
                                <a href="/quiz/{{ $page->slug }}" target="_blank" class="ml-2 text-gray-400 hover:text-white">
                                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                </a>
                            </td>
                            <td class="py-4 px-6">
                                @if($page->is_active)
                                    <span class="px-2 py-1 text-xs rounded bg-green-900/30 text-green-400 border border-green-900/50">Ativa</span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded bg-gray-900/30 text-gray-400 border border-gray-900/50">Inativa</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-gray-400 text-sm">{{ $page->created_at->format('d/m/Y H:i') }}</td>
                            <td class="py-4 px-6">
                                <div class="flex gap-2">
                                    <button @click="editPage({{ $page }})" class="px-3 py-1 text-sm bg-blue-600 hover:bg-blue-500 rounded transition-colors">
                                        Editar
                                    </button>
                                    <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" onsubmit="return confirm('Tem certeza?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 text-sm bg-red-600 hover:bg-red-500 rounded transition-colors">
                                            Excluir
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-gray-400">
                                Nenhuma página cadastrada. Clique em "Nova Página" para começar.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Modal -->
    <div x-show="showModal" x-cloak class="fixed inset-0 bg-black/80 flex items-center justify-center z-50" @click.self="closeModal()">
        <div class="bg-dark-800 rounded-xl border border-dark-700 w-full max-w-2xl max-h-[90vh] overflow-y-auto m-4">
            <div class="p-6 border-b border-dark-700 flex justify-between items-center">
                <h3 class="text-xl font-bold" x-text="editingId ? 'Editar Página' : 'Nova Página'"></h3>
                <button @click="closeModal()" class="text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form :action="editingId ? `/admin/pages/${editingId}` : '{{ route('admin.pages.store') }}'" method="POST" class="p-6 space-y-4">
                @csrf
                <template x-if="editingId">
                    @method('PUT')
                </template>

                <div>
                    <label class="block text-sm font-medium mb-2">Título da Página</label>
                    <input type="text" name="title" x-model="form.title" class="w-full p-3 bg-dark-700 border border-dark-600 rounded-lg focus:border-blue-500 outline-none" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Slug (URL amigável)</label>
                    <div class="flex items-center gap-2">
                        <span class="text-gray-400 text-sm">/quiz/</span>
                        <input type="text" name="slug" x-model="form.slug" class="flex-1 p-3 bg-dark-700 border border-dark-600 rounded-lg focus:border-blue-500 outline-none font-mono text-sm" placeholder="deixe vazio para gerar automaticamente">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Ex: vendas, marketing, atendimento</p>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Descrição (opcional)</label>
                    <textarea name="description" x-model="form.description" rows="3" class="w-full p-3 bg-dark-700 border border-dark-600 rounded-lg focus:border-blue-500 outline-none"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Perguntas do Quiz</label>
                    <div class="space-y-2 max-h-60 overflow-y-auto p-3 bg-dark-700 rounded-lg border border-dark-600">
                        @foreach($allQuestions as $question)
                        <label class="flex items-center gap-3 p-2 hover:bg-dark-600 rounded cursor-pointer">
                            <input type="checkbox" name="questions[]" value="{{ $question->id }}" x-model="form.questions" class="w-5 h-5 rounded bg-dark-800 border-dark-500 text-blue-600 focus:ring-blue-500">
                            <span class="text-sm">{{ $question->order }}. {{ $question->question_text }}</span>
                        </label>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Selecione as perguntas que aparecerão nesta página.</p>
                </div>

                <div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" x-model="form.is_active" value="1" class="w-5 h-5 rounded bg-dark-700 border-dark-600">
                        <span class="text-sm">Página Ativa (visível publicamente)</span>
                    </label>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" class="flex-1 py-3 bg-blue-600 hover:bg-blue-500 rounded-lg font-bold transition-colors">
                        Salvar
                    </button>
                    <button type="button" @click="closeModal()" class="px-6 py-3 bg-dark-700 hover:bg-dark-600 rounded-lg font-medium transition-colors">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function pagesManager() {
        return {
            showModal: false,
            editingId: null,
            form: {
                title: '',
                slug: '',
                description: '',
                is_active: true,
                questions: []
            },
            openModal() {
                this.showModal = true;
            },
            closeModal() {
                this.showModal = false;
                this.editingId = null;
                this.resetForm();
            },
            editPage(page) {
                this.editingId = page.id;
                this.form = {
                    title: page.title,
                    slug: page.slug,
                    description: page.description || '',
                    is_active: page.is_active,
                    questions: page.questions ? page.questions.map(q => q.id.toString()) : []
                };
                this.showModal = true;
            },
            resetForm() {
                this.form = {
                    title: '',
                    slug: '',
                    description: '',
                    is_active: true,
                    questions: []
                };
            }
        }
    }
</script>

<style>
    [x-cloak] { display: none !important; }
</style>
@endsection
