@extends('layouts.app')

@section('title', 'Configurar Quiz')

@section('content')
<div class="flex h-screen overflow-hidden" x-data="quizConfig()">
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
            <a href="{{ route('admin.kanban') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-dark-700 text-gray-400 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/>
                </svg>
                Kanban
            </a>
            <a href="{{ route('admin.quiz-config') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-dark-700 text-white font-medium">
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
    <main class="flex-1 overflow-y-auto bg-dark-900">
        <div class="p-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold">Configurar Perguntas do Quiz</h2>
                <button @click="openModal()" class="px-6 py-3 bg-blue-600 hover:bg-blue-500 rounded-lg font-bold transition-colors">
                    + Nova Pergunta
                </button>
            </div>

            @if(session('success'))
            <div class="mb-6 p-4 bg-green-900/30 border border-green-900/50 rounded-lg text-green-200">
                {{ session('success') }}
            </div>
            @endif

            <!-- Questions List -->
            <div class="bg-dark-800 rounded-xl border border-dark-700 overflow-hidden">
                <table class="w-full">
                    <thead class="bg-dark-700">
                        <tr>
                            <th class="text-left py-4 px-6 text-sm font-medium text-gray-400">Ordem</th>
                            <th class="text-left py-4 px-6 text-sm font-medium text-gray-400">Pergunta</th>
                            <th class="text-left py-4 px-6 text-sm font-medium text-gray-400">Campo</th>
                            <th class="text-left py-4 px-6 text-sm font-medium text-gray-400">Tipo</th>
                            <th class="text-left py-4 px-6 text-sm font-medium text-gray-400">Status</th>
                            <th class="text-left py-4 px-6 text-sm font-medium text-gray-400">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($questions as $question)
                        <tr class="border-t border-dark-700 hover:bg-dark-700/30 transition-colors">
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-dark-600 text-sm font-bold">
                                    {{ $question->order }}
                                </span>
                            </td>
                            <td class="py-4 px-6">{{ $question->question_text }}</td>
                            <td class="py-4 px-6 text-gray-400 font-mono text-sm">{{ $question->field_name }}</td>
                            <td class="py-4 px-6">
                                <span class="px-2 py-1 text-xs rounded bg-dark-600 border border-dark-500">
                                    {{ $question->input_type }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                @if($question->is_active)
                                    <span class="px-2 py-1 text-xs rounded bg-green-900/30 text-green-400 border border-green-900/50">Ativa</span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded bg-gray-900/30 text-gray-400 border border-gray-900/50">Inativa</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex gap-2">
                                    <button @click="editQuestion({{ $question }})" class="px-3 py-1 text-sm bg-blue-600 hover:bg-blue-500 rounded transition-colors">
                                        Editar
                                    </button>
                                    <form action="{{ route('admin.quiz-config.destroy', $question->id) }}" method="POST" onsubmit="return confirm('Tem certeza?')">
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
                            <td colspan="6" class="py-12 text-center text-gray-400">
                                Nenhuma pergunta cadastrada. Clique em "Nova Pergunta" para começar.
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
                <h3 class="text-xl font-bold" x-text="editingId ? 'Editar Pergunta' : 'Nova Pergunta'"></h3>
                <button @click="closeModal()" class="text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form :action="editingId ? `/admin/quiz-config/${editingId}` : '{{ route('admin.quiz-config.store') }}'" method="POST" class="p-6 space-y-4">
                @csrf
                <template x-if="editingId">
                    @method('PUT')
                </template>

                <div>
                    <label class="block text-sm font-medium mb-2">Texto da Pergunta</label>
                    <input type="text" name="question_text" x-model="form.question_text" class="w-full p-3 bg-dark-700 border border-dark-600 rounded-lg focus:border-blue-500 outline-none" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Nome do Campo (ex: revenue_raw)</label>
                    <input type="text" name="field_name" x-model="form.field_name" class="w-full p-3 bg-dark-700 border border-dark-600 rounded-lg focus:border-blue-500 outline-none font-mono text-sm" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Tipo de Input</label>
                        <select name="input_type" x-model="form.input_type" class="w-full p-3 bg-dark-700 border border-dark-600 rounded-lg focus:border-blue-500 outline-none">
                            <option value="text">Texto</option>
                            <option value="email">Email</option>
                            <option value="tel">Telefone</option>
                            <option value="select">Select (Dropdown)</option>
                            <option value="radio">Radio (Botões)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Ordem</label>
                        <input type="number" name="order" x-model="form.order" class="w-full p-3 bg-dark-700 border border-dark-600 rounded-lg focus:border-blue-500 outline-none" required>
                    </div>
                </div>

                <div x-show="form.input_type === 'select' || form.input_type === 'radio'">
                    <label class="block text-sm font-medium mb-2">Opções (uma por linha)</label>
                    <textarea name="options_text" x-model="optionsText" rows="4" class="w-full p-3 bg-dark-700 border border-dark-600 rounded-lg focus:border-blue-500 outline-none" placeholder="Opção 1&#10;Opção 2&#10;Opção 3"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Placeholder (opcional)</label>
                    <input type="text" name="placeholder" x-model="form.placeholder" class="w-full p-3 bg-dark-700 border border-dark-600 rounded-lg focus:border-blue-500 outline-none">
                </div>

                <div class="flex gap-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" x-model="form.is_active" value="1" class="w-5 h-5 rounded bg-dark-700 border-dark-600">
                        <span class="text-sm">Pergunta Ativa</span>
                    </label>

                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_required" x-model="form.is_required" value="1" class="w-5 h-5 rounded bg-dark-700 border-dark-600">
                        <span class="text-sm">Campo Obrigatório</span>
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
    function quizConfig() {
        return {
            showModal: false,
            editingId: null,
            optionsText: '',
            form: {
                question_text: '',
                field_name: '',
                input_type: 'text',
                order: {{ $questions->count() + 1 }},
                placeholder: '',
                is_active: true,
                is_required: true
            },
            openModal() {
                this.showModal = true;
            },
            closeModal() {
                this.showModal = false;
                this.editingId = null;
                this.resetForm();
            },
            editQuestion(question) {
                this.editingId = question.id;
                this.form = {
                    question_text: question.question_text,
                    field_name: question.field_name,
                    input_type: question.input_type,
                    order: question.order,
                    placeholder: question.placeholder || '',
                    is_active: question.is_active,
                    is_required: question.is_required
                };
                this.optionsText = question.options ? question.options.join('\n') : '';
                this.showModal = true;
            },
            resetForm() {
                this.form = {
                    question_text: '',
                    field_name: '',
                    input_type: 'text',
                    order: {{ $questions->count() + 1 }},
                    placeholder: '',
                    is_active: true,
                    is_required: true
                };
                this.optionsText = '';
            }
        }
    }
</script>

<style>
    [x-cloak] { display: none !important; }
</style>
@endsection
