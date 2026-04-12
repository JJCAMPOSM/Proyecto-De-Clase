@extends('layouts.app')

@section('title', 'Mis Pedidos')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Historial de Pedidos</h1>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">{{ session('success') }}</div>
        @endif

        <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">ID Pedido</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Cliente</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Fecha</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Estatus</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($orders as $order)
                        <tr class="hover:bg-gray-50 transition-colors">
                            @php
                                $clienteNombre = $order['cliente_nombre'] ?? null;
                                if (!$clienteNombre) {
                                    $user = session('user');
                                    $clienteNombre = trim((string) ($user['nombre'] ?? '') . ' ' . ($user['apellidos'] ?? ''));
                                }
                                if (!$clienteNombre) {
                                    $clienteNombre = 'Cliente';
                                }
                            @endphp
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 font-mono">
                                #ORD-{{ str_pad($order['id'], 6, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $clienteNombre }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ isset($order['creado_en']) ? date('d M Y, H:i', strtotime($order['creado_en'])) : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $estado = $order['estado'] ?? 'Pendiente';
                                    $colors = ['Pendiente' => 'yellow', 'En Proceso' => 'blue', 'Entregado' => 'green', 'Cancelado' => 'red'];
                                    $c = $colors[$estado] ?? 'gray';
                                @endphp
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $c }}-100 text-{{ $c }}-800 border border-{{ $c }}-200">
                                    {{ $estado }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 text-right tabular-nums">
                                ${{ number_format($order['total'], 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center space-y-2">
                                <a href="/orders/{{ $order['id'] }}/pdf" 
                                   class="inline-block text-gray-600 hover:text-gray-900 px-2 py-1 rounded border border-gray-200 hover:bg-gray-100 transition-colors">
                                    Descargar PDF
                                </a>
                                @if(!empty($order['detalles']))
                                    <button type="button" onclick="document.getElementById('order-details-{{ $order['id'] }}').classList.toggle('hidden')"
                                        class="inline-block text-brand hover:text-brand-dark px-2 py-1 rounded border border-brand hover:bg-brand-light transition-colors">
                                        Ver detalle
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @if(!empty($order['detalles']))
                        <tr id="order-details-{{ $order['id'] }}" class="hidden bg-gray-50">
                            <td colspan="6" class="px-6 py-4">
                                <div class="text-sm font-semibold text-gray-700 mb-2">Productos del pedido</div>
                                <div class="grid grid-cols-1 gap-2">
                                    @foreach($order['detalles'] as $item)
                                        <div class="rounded-lg border border-gray-200 p-3 bg-white shadow-sm">
                                            <div class="flex justify-between items-center gap-4">
                                                <div>
                                                    <p class="font-semibold text-gray-900">{{ $item['producto_nombre'] ?? 'Producto #' . $item['producto_id'] }}</p>
                                                    <p class="text-xs text-gray-500">Cantidad: {{ $item['cantidad'] }}</p>
                                                </div>
                                                <div class="text-right">
                                                    <p class="text-sm font-bold text-gray-900">${{ number_format($item['subtotal'], 2) }}</p>
                                                    <p class="text-xs text-gray-500">Precio unitario: ${{ number_format($item['precio_unitario'], 2) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                        @endif
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                <p class="font-semibold">No tienes pedidos aún.</p>
                                <a href="{{ route('catalog.index') }}" class="mt-2 inline-block text-brand hover:underline text-sm">Ir al catálogo</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
                <p class="text-sm text-gray-700">
                    Mostrando <span class="font-medium">{{ count($orders) }}</span> pedido(s)
                </p>
            </div>
        </div>
    </div>
</div>
@endsection