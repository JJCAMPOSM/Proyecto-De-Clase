@extends('layouts.app', ['hideNav' => true])

@section('title', 'Registro de Cliente')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-extrabold text-brand tracking-tighter">MACUIN</h1>
            <p class="text-gray-500 mt-2 text-sm uppercase tracking-wider font-semibold">Registro de Nuevo Cliente</p>
        </div>

        <div class="bg-white py-8 px-6 shadow-xl rounded-xl border border-gray-100 sm:px-10">
            <form class="space-y-5" action="{{ route('login') }}" method="GET">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input id="nombre" name="nombre" type="text" required class="mt-1 appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-brand focus:border-brand sm:text-sm">
                    </div>
                    <div>
                        <label for="apellidos" class="block text-sm font-medium text-gray-700">Apellidos</label>
                        <input id="apellidos" name="apellidos" type="text" required class="mt-1 appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-brand focus:border-brand sm:text-sm">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                    <input id="email" name="email" type="email" autocomplete="email" required class="mt-1 appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-brand focus:border-brand sm:text-sm">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <input id="password" name="password" type="password" required class="mt-1 appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-brand focus:border-brand sm:text-sm">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required class="mt-1 appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-brand focus:border-brand sm:text-sm">
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-brand hover:bg-brand-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand transition-colors">
                        Registrarme
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    ¿Ya tienes una cuenta? 
                    <a href="{{ route('login') }}" class="font-medium text-brand hover:text-brand-dark">
                        Inicia sesión aquí
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
