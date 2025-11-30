@extends('layouts.app')

@section('title', $page->title)

@section('content')
<div class="flex-grow flex items-center justify-center p-4" x-data="quiz()">
    <div class="w-full max-w-md">
        <!-- Progress Bar -->
        <div class="mb-8 h-1 w-full bg-dark-700 rounded-full overflow-hidden">
            <div class="h-full bg-white transition-all duration-500 ease-out" :style="'width: ' + progress + '%'"></div>
        </div>

        <!-- Form Container -->
        <form @submit.prevent="submit" class="relative min-h-[400px]">
            
            <template x-for="(question, index) in questions" :key="question.id">
                <div x-show="step === index + 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-10" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-10" class="absolute inset-0">
                    <h2 class="text-3xl font-bold mb-6" x-text="question.question_text"></h2>
                    
                    <!-- Text/Email/Tel Input -->
                    <template x-if="['text', 'email', 'tel'].includes(question.input_type)">
                        <div>
                            <input :type="question.input_type" x-model="form[question.field_name]" @keydown.enter.prevent="nextStep" class="w-full p-4 bg-transparent border-b-2 border-dark-600 focus:border-white outline-none text-2xl placeholder-dark-600 transition-colors" :placeholder="question.placeholder || ''" :required="question.is_required" autofocus>
                            <button type="button" @click="nextStep" class="mt-8 px-8 py-3 bg-white text-black font-bold rounded-full hover:bg-gray-200 transition-colors">Próximo</button>
                        </div>
                    </template>

                    <!-- Radio Buttons -->
                    <template x-if="question.input_type === 'radio'">
                        <div class="space-y-3">
                            <template x-for="option in question.options" :key="option">
                                <button type="button" @click="selectOption(question.field_name, option)" class="w-full p-4 text-left rounded-xl bg-dark-800 hover:bg-dark-700 border border-dark-700 transition-all" x-text="option"></button>
                            </template>
                        </div>
                    </template>

                    <!-- Select Dropdown -->
                    <template x-if="question.input_type === 'select'">
                        <div>
                            <select x-model="form[question.field_name]" @change="nextStep" class="w-full p-4 bg-dark-800 border border-dark-700 rounded-xl text-lg outline-none focus:border-white transition-colors" :required="question.is_required">
                                <option value="">Selecione uma opção</option>
                                <template x-for="option in question.options" :key="option">
                                    <option :value="option" x-text="option"></option>
                                </template>
                            </select>
                        </div>
                    </template>
                </div>
            </template>

            <!-- Success Message -->
            <div x-show="step === totalSteps + 1" x-cloak class="absolute inset-0 flex flex-col items-center justify-center text-center">
                <div class="text-5xl mb-4">✨</div>
                <h2 class="text-3xl font-bold mb-4">Recebemos seus dados!</h2>
                <p class="text-gray-400">Nossa IA está analisando seu perfil e entraremos em contato em breve.</p>
            </div>

        </form>
    </div>
</div>

<script>
    function quiz() {
        return {
            step: 1,
            totalSteps: 0,
            loading: false,
            questions: [],
            form: {},
            get progress() {
                return (this.step / this.totalSteps) * 100;
            },
            async init() {
                // Load questions from API
                const response = await fetch('/api/quiz/{{ $page->slug }}/questions');
                this.questions = await response.json();
                this.totalSteps = this.questions.length;
                
                // Initialize form fields
                this.questions.forEach(q => {
                    this.form[q.field_name] = '';
                });
            },
            selectOption(field, value) {
                this.form[field] = value;
                this.nextStep();
            },
            nextStep() {
                if (this.step < this.totalSteps) {
                    this.step++;
                } else if (this.step === this.totalSteps) {
                    this.submit();
                }
            },
            async submit() {
                this.loading = true;
                try {
                    const response = await fetch('/api/new-lead', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(this.form)
                    });
                    
                    if (response.ok) {
                        this.step = this.totalSteps + 1;
                    } else {
                        alert('Ocorreu um erro. Tente novamente.');
                    }
                } catch (error) {
                    console.error(error);
                    alert('Erro de conexão.');
                } finally {
                    this.loading = false;
                }
            }
        }
    }
</script>
@endsection
