@extends('layouts.app')

@section('title', 'Catálogo de Autopartes')

@section('content')
<div class="py-6 bg-gray-50 min-h-screen" x-data="productCatalog()">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row gap-6">
        
        <aside class="w-full md:w-64 flex-shrink-0">
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                <h2 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Filtros</h2>
                
                <div class="mb-5">
                    <h3 class="text-sm font-semibold text-gray-700 mb-2">Categoría</h3>
                    <div class="space-y-2">
                        @foreach(['Frenos', 'Suspensión', 'Motor', 'Eléctrico'] as $cat)
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" class="rounded border-gray-300 text-red-600 focus:ring-red-500" {{ $cat == 'Suspensión' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-600">{{ $cat }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="mb-5">
                    <h3 class="text-sm font-semibold text-gray-700 mb-2">Marca de Vehículo</h3>
                    <select class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm p-2 border bg-gray-50">
                        <option>Todas las marcas</option>
                        <option>Nissan</option>
                        <option>Chevrolet</option>
                    </select>
                </div>

                <div class="mb-5">
                    <h3 class="text-sm font-semibold text-gray-700 mb-2">Año (Modelo)</h3>
                    <div class="flex items-center space-x-2">
                        <input type="number" placeholder="De" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm p-2 border">
                        <span class="text-gray-500">-</span>
                        <input type="number" placeholder="A" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm p-2 border">
                    </div>
                </div>

                <button class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded-md transition-colors text-sm">
                    Limpiar Filtros
                </button>
            </div>
        </aside>

        <div class="flex-1">
            <div class="mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
                <h1 class="text-2xl font-bold text-gray-900">Catálogo de Autopartes</h1>
                
                <div class="relative w-full sm:w-80">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" placeholder="Buscar por nombre o SKU..." 
                        class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all shadow-sm">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow flex flex-col">
                    <div class="h-48 bg-gray-200 flex items-center justify-center relative">
                        <span class="text-gray-400 text-xs italic">Imagen Producto</span>
                        <div class="absolute top-2 right-2 bg-green-100 text-green-800 text-[10px] font-bold px-2 py-1 rounded-full border border-green-200">En Stock</div>
                    </div>
                    <div class="p-4 flex-1 flex flex-col">
                        <p class="text-[10px] text-gray-400 mb-1 font-mono">SKU: MC-AM001</p>
                        <h3 class="font-bold text-gray-900 leading-tight mb-2 flex-1">Amortiguador Delantero Gas Nissan Versa 12-19</h3>
                        
                        <div class="mt-auto">
                            <p class="text-2xl font-black text-red-600 mb-4">$850.00</p>
                            <button @click="fetchProductDetail(1)" class="w-full bg-white text-red-600 border-2 border-red-600 hover:bg-red-600 hover:text-white font-bold py-2 px-4 rounded-lg transition-all text-sm uppercase tracking-tight">
                                Ver Detalles
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <template x-if="showModal">
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
            <div class="bg-gray-100 w-full max-w-4xl rounded-[2rem] overflow-hidden shadow-2xl relative animate-modal-up">
                
                <div class="bg-red-600 p-4 flex items-center justify-between text-white">
                    <button @click="showModal = false" class="flex items-center font-bold text-sm hover:opacity-80">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        VOLVER
                    </button>
                    <span class="font-black italic tracking-tighter">MACUIN</span>
                </div>

                <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-2 gap-8 overflow-y-auto max-h-[80vh]">
                    <div class="space-y-4">
                        <div class="bg-white rounded-3xl overflow-hidden aspect-square border border-gray-200 shadow-sm">
                            <img :src="product.image" class="w-full h-full object-cover">
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="bg-white p-3 rounded-2xl border border-gray-100 flex items-center space-x-2">
                                <span class="text-red-500">🛡️</span>
                                <div><p class="text-[9px] text-gray-400 font-bold uppercase">Garantía</p><p class="text-xs font-bold">12 Meses</p></div>
                            </div>
                            <div class="bg-white p-3 rounded-2xl border border-gray-100 flex items-center space-x-2">
                                <span class="text-red-500">🚚</span>
                                <div><p class="text-[9px] text-gray-400 font-bold uppercase">Envío</p><p class="text-xs font-bold">3-5 Días</p></div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 h-fit">
                        <span class="bg-gray-100 text-gray-500 text-[10px] font-bold px-2 py-1 rounded-md" x-text="product.category">CATEGORÍA</span>
                        <h2 class="text-2xl font-extrabold text-gray-900 mt-3" x-text="product.name">Nombre de Autoparte</h2>
                        <p class="text-xs text-gray-400 mt-1">Marca: <span class="text-gray-900 font-bold" x-text="product.brand">Brembo</span></p>

                        <div class="my-4 flex items-center text-green-600 text-[10px] font-bold bg-green-50 px-2 py-1 rounded-full w-fit">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-2"></span>
                            <span x-text="product.stock + ' unidades disponibles'"></span>
                        </div>

                        <div class="mb-6">
                            <span class="text-4xl font-black text-red-600" x-text="'$' + product.price"></span>
                            <span class="text-xs text-gray-400 font-bold ml-1">MXN + IVA</span>
                        </div>

                        <button @click="addToCart(product.id)" class="w-full bg-red-600 text-white font-bold py-3 rounded-xl shadow-lg hover:bg-red-700 transition-all uppercase text-sm tracking-widest">
                            Agregar al Carrito
                        </button>

                        <div class="mt-6 pt-6 border-t border-gray-50">
                            <h4 class="text-red-600 font-bold text-xs uppercase mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"/></svg>
                                Descripción Técnica
                            </h4>
                            <p class="text-xs text-gray-600 leading-relaxed" x-text="product.description"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>

<script>
function productCatalog() {
    return {
        showModal: false,
        product: {},
        async fetchProductDetail(id) {
            // Aquí iría tu llamada AJAX real: fetch(`/api/products/${id}`)
            this.product = {
                id: id,
                name: 'Pastillas de Freno Brembo Premium',
                price: '850.00',
                brand: 'Brembo',
                category: 'FRENOS',
                stock: 25,
                image: 'https://via.placeholder.com/500',
                description: 'Pastillas de cerámica de alta fricción para un frenado suave y sin ruido.'
            };
            this.showModal = true;
        },
        addToCart(id) {
            // Lógica para agregar al carrito
            alert('Producto ' + id + ' agregado!');
            this.showModal = false;
        }
    }
}
</script>

<style>
.animate-modal-up {
    animation: slideUp 0.3s ease-out;
}
@keyframes slideUp {
    from { transform: translateY(20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}
</style>
@endsection