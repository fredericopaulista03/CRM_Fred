@extends('layouts.app')

@section('title', 'Login Admin')

@section('content')
<div class="flex-grow flex items-center justify-center p-4">
    <div class="w-full max-w-md glass p-8 rounded-2xl">
        <h1 class="text-2xl font-bold mb-6 text-center">Acesso Administrativo</h1>
        
        @if($errors->any())
            <div class="mb-4 p-3 bg-red-500/20 border border-red-500/50 rounded-lg text-red-200 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.authenticate') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm text-gray-400 mb-1">Email</label>
                <input type="email" name="email" class="w-full p-3 bg-dark-800 border border-dark-700 rounded-lg focus:border-white outline-none transition-colors" required>
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-1">Senha</label>
                <input type="password" name="password" class="w-full p-3 bg-dark-800 border border-dark-700 rounded-lg focus:border-white outline-none transition-colors" required>
            </div>
            <button type="submit" class="w-full py-3 bg-white text-black font-bold rounded-lg hover:bg-gray-200 transition-colors">
                Entrar
            </button>
        </form>
    </div>
</div>
@endsection
