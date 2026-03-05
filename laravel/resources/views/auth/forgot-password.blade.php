@extends('layouts.app', ['hideNav' => true])

@section('title', 'Recuperar Contraseña')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-extrabold text-brand tracking-tighter">MACUIN</h1>
            <p class="text-gray-500 mt-2 text-sm uppercase tracking-wider font-semibold">Recuperación de Contraseña</p>
        </div>

        <div class="bg-white py-8 px-6 shadow-xl rounded-xl border border-gray-100 sm:px-10">
            <p class="text-sm text-gray-600 mb-6 text-center">
                Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
            </p>
            <form class="space-y-6" action="{{ route('login') }}" method="GET">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-brand focus:border-brand sm:text-sm">
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-brand hover:bg-brand-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand transition-colors">
                        Enviar Enlace
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="font-medium text-sm text-brand hover:text-brand-dark flex justify-center items-center">
                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver al login
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
