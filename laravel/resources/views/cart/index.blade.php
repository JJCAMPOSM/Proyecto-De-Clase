@extends('layouts.app')

@section('title', 'Nueva Solicitud')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Carrito de Compras / Nueva Solicitud</h1>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Lista de Productos -->
            <div class="flex-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
                    <ul role="list" class="divide-y divide-gray-200">
                        <!-- Item 1 -->
                        <li class="p-6 flex items-center">
                            <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-md border border-gray-200 bg-gray-100 flex items-center justify-center">
                                <span class="text-xs text-gray-400 text-center">IMG<br>Amort.</span>
                            </div>
                            <div class="ml-4 flex flex-1 flex-col">
                                <div>
                                    <div class="flex justify-between text-base font-medium text-gray-900">
                                        <h3><a href="#">Amortiguador Delantero Gas Nissan Versa 12-19</a></h3>
                                        <p class="ml-4 tabular-nums">$1,700.00</p>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500 font-mono">SKU: MC-AM001</p>
                                </div>
                                <div class="flex flex-1 items-end justify-between text-sm mt-4">
                                    <div class="flex items-center border border-gray-300 rounded-md">
                                        <button class="px-3 py-1 text-gray-600 hover:bg-gray-100 rounded-l-md">-</button>
                                        <input type="number" value="2" class="w-12 text-center border-0 p-1 text-gray-900 focus:ring-0 sm:text-sm" readonly>
                                        <button class="px-3 py-1 text-gray-600 hover:bg-gray-100 rounded-r-md">+</button>
                                    </div>
                                    <div class="flex">
                                        <button type="button" class="font-medium text-brand hover:text-brand-dark flex items-center">
                                            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            Eliminar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                        
                        <!-- Item 2 -->
                        <li class="p-6 flex items-center">
                            <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-md border border-gray-200 bg-gray-100 flex items-center justify-center">
                                <span class="text-xs text-gray-400 text-center">IMG<br>Bujías</span>
                            </div>
                            <div class="ml-4 flex flex-1 flex-col">
                                <div>
                                    <div class="flex justify-between text-base font-medium text-gray-900">
                                        <h3><a href="#">Bujías Iridium NGK Jetta A4 2.0 (Juego 4)</a></h3>
                                        <p class="ml-4 tabular-nums">$650.00</p>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500 font-mono">SKU: MC-BJ105</p>
                                </div>
                                <div class="flex flex-1 items-end justify-between text-sm mt-4">
                                    <div class="flex items-center border border-gray-300 rounded-md">
                                        <button class="px-3 py-1 text-gray-600 hover:bg-gray-100 rounded-l-md">-</button>
                                        <input type="number" value="1" class="w-12 text-center border-0 p-1 text-gray-900 focus:ring-0 sm:text-sm" readonly>
                                        <button class="px-3 py-1 text-gray-600 hover:bg-gray-100 rounded-r-md">+</button>
                                    </div>
                                    <div class="flex">
                                        <button type="button" class="font-medium text-brand hover:text-brand-dark flex items-center">
                                            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            Eliminar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Formularios adicionales -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Detalles de Envío y Notas</h3>
                    <div class="space-y-4">
                        <div>
                            <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección de Envío Completa</label>
                            <textarea id="direccion" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-brand focus:border-brand sm:text-sm" placeholder="Calle, Número, Colonia, Ciudad, Estado, C.P."></textarea>
                        </div>
                        <div>
                            <label for="notas" class="block text-sm font-medium text-gray-700">Notas Adicionales (Opcional)</label>
                            <textarea id="notas" rows="2" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-brand focus:border-brand sm:text-sm" placeholder="Instrucciones para la entrega o referencias..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resumen de Pedido -->
            <div class="w-full lg:w-96">
                <div class="bg-gray-50 rounded-xl shadow-sm border border-gray-200 p-6 sticky top-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Resumen de Solicitud</h2>
                    
                    <dl class="space-y-4 text-sm text-gray-600">
                        <div class="flex justify-between">
                            <dt>Subtotal</dt>
                            <dd class="font-medium text-gray-900 tabular-nums">Subtotal: $2,350.00</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt>Impuestos (IVA 16%)</dt>
                            <dd class="font-medium text-gray-900 tabular-nums">$376.00</dd>
                        </div>
                        <div class="flex justify-between items-center border-t border-gray-200 pt-4">
                            <dt class="text-lg font-bold text-gray-900">Total</dt>
                            <dd class="text-2xl font-extrabold text-brand tabular-nums tracking-tight">$2,726.00</dd>
                        </div>
                    </dl>

                    <div class="mt-6">
                        <a href="{{ route('orders.index') }}" class="w-full flex items-center justify-center rounded-lg border border-transparent bg-brand px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-brand-dark focus:outline-none focus:ring-2 focus:ring-brand focus:ring-offset-2 transition-transform transform hover:scale-105">
                            Confirmar Solicitud
                        </a>
                    </div>
                    
                    <div class="mt-4 text-center">
                        <a href="{{ route('catalog.index') }}" class="text-sm font-medium text-gray-500 hover:text-brand">
                            &larr; Continuar Comprando
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
