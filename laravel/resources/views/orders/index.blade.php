@extends('layouts.app')

@section('title', 'Mis Pedidos')

@section('content')
<div class="py-6" x-data="{ openModal: false, selectedOrder: null }">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Historial de Pedidos</h1>

        <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">ID Pedido / Folio</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Fecha</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Estatus</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Fila 1 -->
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 font-mono">
                                #ORD-2023-0098
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                28 Oct 2023, 14:30
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                                    En Proceso
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 text-right tabular-nums">
                                $2,726.00
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center space-x-2">
                                <button @click="openModal = true; selectedOrder = '#ORD-2023-0098'" class="text-brand hover:text-brand-dark px-2 py-1 rounded bg-red-50 hover:bg-red-100 border border-red-100 transition-colors">
                                    Ver Detalles
                                </button>
                                <a href="#" class="text-gray-600 hover:text-gray-900 px-2 py-1 rounded border border-gray-200 hover:bg-gray-100 transition-colors">
                                    Descargar PDF
                                </a>
                            </td>
                        </tr>

                        <!-- Fila 2 -->
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 font-mono">
                                #ORD-2023-0045
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                15 Sep 2023, 09:15
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 border border-green-200">
                                    Entregado
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 text-right tabular-nums">
                                $1,850.50
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center space-x-2">
                                <button @click="openModal = true; selectedOrder = '#ORD-2023-0045'" class="text-brand hover:text-brand-dark px-2 py-1 rounded bg-red-50 hover:bg-red-100 border border-red-100 transition-colors">
                                    Ver Detalles
                                </button>
                                <a href="#" class="text-gray-600 hover:text-gray-900 px-2 py-1 rounded border border-gray-200 hover:bg-gray-100 transition-colors">
                                    Descargar PDF
                                </a>
                            </td>
                        </tr>

                        <!-- Fila 3 -->
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 font-mono">
                                #ORD-2023-0012
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                02 Ago 2023, 11:20
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 border border-red-200">
                                    Cancelado
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 text-right tabular-nums">
                                $420.00
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center space-x-2">
                                <button @click="openModal = true; selectedOrder = '#ORD-2023-0012'" class="text-brand hover:text-brand-dark px-2 py-1 rounded bg-red-50 hover:bg-red-100 border border-red-100 transition-colors">
                                    Ver Detalles
                                </button>
                                <a href="#" class="text-gray-600 hover:text-gray-900 px-2 py-1 rounded border border-gray-200 hover:bg-gray-100 transition-colors">
                                    Descargar PDF
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination (Dummy) -->
            <div class="bg-gray-50 px-6 py-3 border-t border-gray-200 flex items-center justify-between sm:px-6">
                <div class="sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Mostrando <span class="font-medium">1</span> a <span class="font-medium">3</span> de <span class="font-medium">12</span> resultados
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alpine.js Modal for Order Details -->
    <div x-show="openModal" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            
            <div x-show="openModal" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100" 
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                 @click="openModal = false"
                 aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="openModal" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-gray-100">
                
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-xl leading-6 font-extrabold text-gray-900 mb-4" id="modal-title">
                                Detalles de Pedido <span x-text="selectedOrder" class="text-brand"></span>
                            </h3>
                            
                            <div class="mt-2 text-sm text-gray-600">
                                <p class="mb-2"><strong>Fecha de Solicitud:</strong> 28 Oct 2023</p>
                                <p class="mb-4"><strong>Dirección:</strong> Calle Ejemplo 123, Ciudad, C.P. 12345</p>

                                <div class="border rounded-md overflow-hidden">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Producto</th>
                                                <th scope="col" class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Cant</th>
                                                <th scope="col" class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr>
                                                <td class="px-4 py-2">Amortiguador Delantero Gas...</td>
                                                <td class="px-4 py-2 text-center">2</td>
                                                <td class="px-4 py-2 text-right">$1,700.00</td>
                                            </tr>
                                            <tr>
                                                <td class="px-4 py-2">Bujías Iridium NGK...</td>
                                                <td class="px-4 py-2 text-center">1</td>
                                                <td class="px-4 py-2 text-right">$650.00</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100">
                    <button type="button" @click="openModal = false" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-brand text-base font-medium text-white hover:bg-brand-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand sm:ml-3 sm:w-auto sm:text-sm">
                        Cerrar
                    </button>
                    <button type="button" @click="openModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Descargar PDF
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
