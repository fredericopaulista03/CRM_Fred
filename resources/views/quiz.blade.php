@extends('layouts.app')

@section('title', 'Qualificação de Lead')

@section('content')
<div class="flex-grow flex items-center justify-center p-4" x-data="quiz()">
    <div class="w-full max-w-md">
        <!-- Progress Bar -->
        <div class="mb-8 h-1 w-full bg-dark-700 rounded-full overflow-hidden">
            <div class="h-full bg-white transition-all duration-500 ease-out" :style="'width: ' + progress + '%'"></div>
        </div>

        <!-- Form Container -->
        <form @submit.prevent="submit" class="relative min-h-[400px]">
            
            <!-- Step 1: Faturamento -->
            <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-10" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-10" class="absolute inset-0">
                <h2 class="text-3xl font-bold mb-6">Qual é o faturamento atual da sua empresa?</h2>
                <div class="space-y-3">
                    <button type="button" @click="selectOption('revenue_raw', '0-10k')" class="w-full p-4 text-left rounded-xl bg-dark-800 hover:bg-dark-700 border border-dark-700 transition-all">Até R$ 10.000</button>
                    <button type="button" @click="selectOption('revenue_raw', '10-50k')" class="w-full p-4 text-left rounded-xl bg-dark-800 hover:bg-dark-700 border border-dark-700 transition-all">R$ 10.000 - R$ 50.000</button>
                    <button type="button" @click="selectOption('revenue_raw', '50-200k')" class="w-full p-4 text-left rounded-xl bg-dark-800 hover:bg-dark-700 border border-dark-700 transition-all">R$ 50.000 - R$ 200.000</button>
                    <button type="button" @click="selectOption('revenue_raw', '200k+')" class="w-full p-4 text-left rounded-xl bg-dark-800 hover:bg-dark-700 border border-dark-700 transition-all">Acima de R$ 200.000</button>
                </div>
            </div>

            <!-- Step 2: Investimento -->
            <div x-show="step === 2" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-10" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-10" class="absolute inset-0">
                <h2 class="text-3xl font-bold mb-6">Quanto pretende investir em tráfego pago?</h2>
                <div class="space-y-3">
                    <button type="button" @click="selectOption('investment_raw', '1k')" class="w-full p-4 text-left rounded-xl bg-dark-800 hover:bg-dark-700 border border-dark-700 transition-all">Até R$ 1.000</button>
                    <button type="button" @click="selectOption('investment_raw', '3k')" class="w-full p-4 text-left rounded-xl bg-dark-800 hover:bg-dark-700 border border-dark-700 transition-all">Até R$ 3.000</button>
                    <button type="button" @click="selectOption('investment_raw', '5k')" class="w-full p-4 text-left rounded-xl bg-dark-800 hover:bg-dark-700 border border-dark-700 transition-all">Até R$ 5.000</button>
                    <button type="button" @click="selectOption('investment_raw', '10k+')" class="w-full p-4 text-left rounded-xl bg-dark-800 hover:bg-dark-700 border border-dark-700 transition-all">Acima de R$ 10.000</button>
                </div>
            </div>

             <!-- Step 3: Instagram -->
             <div x-show="step === 3" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-10" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-10" class="absolute inset-0">
                <h2 class="text-3xl font-bold mb-6">Qual o Instagram da sua empresa?</h2>
                <input type="text" x-model="form.instagram" @keydown.enter.prevent="nextStep" class="w-full p-4 bg-transparent border-b-2 border-dark-600 focus:border-white outline-none text-2xl placeholder-dark-600 transition-colors" placeholder="@seuinstagram" autofocus>
                <button type="button" @click="nextStep" class="mt-8 px-8 py-3 bg-white text-black font-bold rounded-full hover:bg-gray-200 transition-colors">Próximo</button>
            </div>

            <!-- Step 4: Ramo -->
            <div x-show="step === 4" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-10" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-10" class="absolute inset-0">
                <h2 class="text-3xl font-bold mb-6">Qual é o ramo da sua empresa?</h2>
                <input type="text" x-model="form.branch" @keydown.enter.prevent="nextStep" class="w-full p-4 bg-transparent border-b-2 border-dark-600 focus:border-white outline-none text-2xl placeholder-dark-600 transition-colors" placeholder="Ex: Odontologia, E-commerce..." autofocus>
                <button type="button" @click="nextStep" class="mt-8 px-8 py-3 bg-white text-black font-bold rounded-full hover:bg-gray-200 transition-colors">Próximo</button>
            </div>

            <!-- Step 5: Já faz tráfego? -->
            <div x-show="step === 5" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-10" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-10" class="absolute inset-0">
                <h2 class="text-3xl font-bold mb-6">Você já faz tráfego pago atualmente?</h2>
                <div class="space-y-3">
                    <button type="button" @click="selectOption('has_traffic', 'Sim')" class="w-full p-4 text-left rounded-xl bg-dark-800 hover:bg-dark-700 border border-dark-700 transition-all">Sim</button>
                    <button type="button" @click="selectOption('has_traffic', 'Não')" class="w-full p-4 text-left rounded-xl bg-dark-800 hover:bg-dark-700 border border-dark-700 transition-all">Não</button>
                </div>
            </div>

            <!-- Step 6: Objetivo -->
            <div x-show="step === 6" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-10" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-10" class="absolute inset-0">
                <h2 class="text-3xl font-bold mb-6">Qual seu objetivo principal?</h2>
                <input type="text" x-model="form.objective" @keydown.enter.prevent="nextStep" class="w-full p-4 bg-transparent border-b-2 border-dark-600 focus:border-white outline-none text-2xl placeholder-dark-600 transition-colors" placeholder="Ex: Vender mais, Leads..." autofocus>
                <button type="button" @click="nextStep" class="mt-8 px-8 py-3 bg-white text-black font-bold rounded-full hover:bg-gray-200 transition-colors">Próximo</button>
            </div>

            <!-- Step 7: Contato -->
            <div x-show="step === 7" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-10" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-10" class="absolute inset-0">
                <h2 class="text-3xl font-bold mb-6">Quase lá! Seus dados para contato:</h2>
                <div class="space-y-6">
                    <input type="text" x-model="form.name" class="w-full p-4 bg-transparent border-b-2 border-dark-600 focus:border-white outline-none text-xl placeholder-dark-600 transition-colors" placeholder="Seu nome" required>
                    <input type="email" x-model="form.email" class="w-full p-4 bg-transparent border-b-2 border-dark-600 focus:border-white outline-none text-xl placeholder-dark-600 transition-colors" placeholder="Seu email" required>
                    <input type="tel" x-model="form.phone" class="w-full p-4 bg-transparent border-b-2 border-dark-600 focus:border-white outline-none text-xl placeholder-dark-600 transition-colors" placeholder="Seu telefone (WhatsApp)" required>
                </div>
                <button type="submit" class="mt-8 w-full px-8 py-4 bg-white text-black font-bold rounded-full hover:bg-gray-200 transition-colors text-lg" :disabled="loading">
                    <span x-show="!loading">Finalizar e Receber Análise</span>
                    <span x-show="loading">Analisando com IA...</span>
                </button>
            </div>

            <!-- Success Message -->
            <div x-show="step === 8" x-cloak class="absolute inset-0 flex flex-col items-center justify-center text-center">
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
            totalSteps: 7,
            loading: false,
            form: {
                revenue_raw: '',
                investment_raw: '',
                instagram: '',
                branch: '',
                has_traffic: '',
                objective: '',
                name: '',
                email: '',
                phone: ''
            },
            get progress() {
                return (this.step / this.totalSteps) * 100;
            },
            selectOption(field, value) {
                this.form[field] = value;
                this.nextStep();
            },
            nextStep() {
                if (this.step < this.totalSteps) {
                    this.step++;
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
                        this.step = 8;
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
