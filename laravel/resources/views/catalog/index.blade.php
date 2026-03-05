@extends('layouts.app')

@section('title', 'Catálogo de Autopartes')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row gap-6">
        <!-- Sidebar Filtros -->
        <aside class="w-full md:w-64 flex-shrink-0">
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                <h2 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Filtros</h2>
                
                <!-- Categoría -->
                <div class="mb-5">
                    <h3 class="text-sm font-semibold text-gray-700 mb-2">Categoría</h3>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-brand focus:ring-brand">
                            <span class="ml-2 text-sm text-gray-600">Frenos</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-brand focus:ring-brand" checked>
                            <span class="ml-2 text-sm text-gray-600">Suspensión</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-brand focus:ring-brand">
                            <span class="ml-2 text-sm text-gray-600">Motor</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-brand focus:ring-brand">
                            <span class="ml-2 text-sm text-gray-600">Eléctrico</span>
                        </label>
                    </div>
                </div>

                <!-- Marca -->
                <div class="mb-5">
                    <h3 class="text-sm font-semibold text-gray-700 mb-2">Marca de Vehículo</h3>
                    <select class="w-full border-gray-300 rounded-md shadow-sm focus:ring-brand focus:border-brand sm:text-sm p-2 border">
                        <option>Todas las marcas</option>
                        <option>Nissan</option>
                        <option>Chevrolet</option>
                        <option>Volkswagen</option>
                        <option>Toyota</option>
                    </select>
                </div>

                <!-- Modelo (Año) -->
                <div class="mb-5">
                    <h3 class="text-sm font-semibold text-gray-700 mb-2">Año (Modelo)</h3>
                    <div class="flex items-center space-x-2">
                        <input type="number" placeholder="De" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-brand focus:border-brand sm:text-sm p-2 border">
                        <span class="text-gray-500">-</span>
                        <input type="number" placeholder="A" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-brand focus:border-brand sm:text-sm p-2 border">
                    </div>
                </div>

                <button class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded-md transition-colors text-sm">
                    Limpiar Filtros
                </button>
            </div>
        </aside>

        <!-- Product Grid -->
        <div class="flex-1">
            <div class="mb-4 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Catálogo de Autopartes</h1>
                <span class="text-sm text-gray-500">Mostrando 4 resultados</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Producto 1 -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow flex flex-col">
                    <div class="h-48 bg-gray-200 flex items-center justify-center relative">
                        <!-- Dummy Image -->
                        <span class="text-gray-400 text-xs text-center px-4">IMG<br>Amortiguador</span>
                        <div class="absolute top-2 right-2 bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded-full border border-green-200">
                            En Stock
                        </div>
                    </div>
                    <div class="p-4 flex-1 flex flex-col">
                        <p class="text-xs text-gray-500 mb-1 font-mono">SKU: MC-AM001</p>
                        <h3 class="font-bold text-gray-900 leading-tight mb-2 flex-1">Amortiguador Delantero Gas Nissan Versa 12-19</h3>
                        <div class="mt-auto">
                            <p class="text-2xl font-extrabold text-brand mb-4">$850.00</p>
                            <button class="w-full bg-white text-brand border border-brand hover:bg-brand hover:text-white font-medium py-2.5 px-4 rounded-lg transition-colors flex justify-center items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                Agregar al Carrito
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Producto 2 -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow flex flex-col">
                    <div class="h-48 bg-gray-200 flex items-center justify-center relative">
                        <span class="text-gray-400 text-xs text-center px-4">IMG<br>Balatas</span>
                        <div class="absolute top-2 right-2 bg-red-100 text-red-800 text-xs font-semibold px-2 py-1 rounded-full border border-red-200">
                            Agotado
                        </div>
                    </div>
                    <div class="p-4 flex-1 flex flex-col">
                        <p class="text-xs text-gray-500 mb-1 font-mono">SKU: MC-BL042</p>
                        <h3 class="font-bold text-gray-900 leading-tight mb-2 flex-1">Juego de Balatas Delanteras Chevrolet Aveo 18-22</h3>
                        <div class="mt-auto">
                            <p class="text-2xl font-extrabold text-gray-900 mb-4">$420.00</p>
                            <button class="w-full bg-gray-100 text-gray-400 cursor-not-allowed font-medium py-2.5 px-4 rounded-lg flex justify-center items-center" disabled>
                                Sin inventario
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Producto 3 -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow flex flex-col">
                    <div class="h-48 bg-gray-200 flex items-center justify-center relative">
                        <span class="text-gray-400 text-xs text-center px-4">IMG<br>Bujías</span>
                        <div class="absolute top-2 right-2 bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded-full border border-green-200">
                            En Stock
                        </div>
                    </div>
                    <div class="p-4 flex-1 flex flex-col">
                        <p class="text-xs text-gray-500 mb-1 font-mono">SKU: MC-BJ105</p>
                        <h3 class="font-bold text-gray-900 leading-tight mb-2 flex-1">Bujías Iridium NGK Jetta A4 2.0 (Juego 4)</h3>
                        <div class="mt-auto">
                            <p class="text-2xl font-extrabold text-brand mb-4">$650.00</p>
                            <button class="w-full bg-white text-brand border border-brand hover:bg-brand hover:text-white font-medium py-2.5 px-4 rounded-lg transition-colors flex justify-center items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                Agregar al Carrito
                            </button>
                        </div>
                    </div>
                </div>
                
                 <!-- Producto 4 -->
                 <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow flex flex-col">
                    <div class="h-48 bg-gray-200 flex items-center justify-center relative">
                        <span class="text-gray-400 text-xs text-center px-4">IMG<br>Filtro Aceite</span>
                        <div class="absolute top-2 right-2 bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded-full border border-green-200">
                            Poco Stock
                        </div>
                    </div>
                    <div class="p-4 flex-1 flex flex-col">
                        <p class="text-xs text-gray-500 mb-1 font-mono">SKU: MC-FA999</p>
                        <h3 class="font-bold text-gray-900 leading-tight mb-2 flex-1">Filtro de Aceite Sintético FRAM Toyota Hilux 16-21</h3>
                        <div class="mt-auto">
                            <p class="text-2xl font-extrabold text-brand mb-4">$180.00</p>
                            <button class="w-full bg-white text-brand border border-brand hover:bg-brand hover:text-white font-medium py-2.5 px-4 rounded-lg transition-colors flex justify-center items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                Agregar al Carrito
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Pagination (Dummy) -->
            <div class="mt-8 flex justify-center">
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                    <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <span class="sr-only">Anterior</span>
                        &laquo;
                    </a>
                    <a href="#" aria-current="page" class="z-10 bg-brand border-brand text-white relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                        1
                    </a>
                    <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                        2
                    </a>
                    <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <span class="sr-only">Siguiente</span>
                        &raquo;
                    </a>
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection
