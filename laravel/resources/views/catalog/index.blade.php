@extends('layouts.app')

@section('title', 'Catálogo de Autopartes')

@section('content')
<div class="py-6 bg-gray-50 min-h-screen" x-data="productCatalog()">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row gap-6">
        
        <aside class="w-full md:w-64 flex-shrink-0">
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                <h2 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Filtros</h2>
                <div class="mb-5">
                    <h3 class="text-sm font-semibold text-gray-700 mb-2">Buscar</h3>
                    <input type="text" x-model="search" placeholder="Nombre o SKU..."
                        class="w-full border-gray-300 rounded-md shadow-sm text-sm p-2 border focus:ring-red-500 focus:border-red-500">
                </div>
                <div class="mb-5">
                    <h3 class="text-sm font-semibold text-gray-700 mb-2">Categoría</h3>
                    <select x-model="filterCategory" class="w-full border-gray-300 rounded-md shadow-sm text-sm p-2 border bg-gray-50">
                        <option value="">Todas las categorías</option>
                        <template x-for="cat in categories" :key="cat">
                            <option :value="cat" x-text="cat"></option>
                        </template>
                    </select>
                </div>
                <button @click="search=''; filterCategory=''" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded-md transition-colors text-sm">
                    Limpiar Filtros
                </button>
            </div>
        </aside>

        <div class="flex-1">
            <div class="mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
                <h1 class="text-2xl font-bold text-gray-900">Catálogo de Autopartes</h1>
                <span class="text-sm text-gray-500" x-text="filteredProducts.length + ' productos encontrados'"></span>
            </div>

            <div x-show="loading" class="text-center py-12 text-gray-400">Cargando productos...</div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <template x-for="p in filteredProducts" :key="p.id">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow flex flex-col">
                        <div class="h-48 bg-gray-200 flex items-center justify-center relative">
                            <span class="text-gray-400 text-xs italic" x-text="p.categoria"></span>
                            <div class="absolute top-2 right-2 text-[10px] font-bold px-2 py-1 rounded-full border"
                                :class="p.stock > 0 ? 'bg-green-100 text-green-800 border-green-200' : 'bg-red-100 text-red-800 border-red-200'"
                                x-text="p.stock > 0 ? 'En Stock' : 'Agotado'">
                            </div>
                        </div>
                        <div class="p-4 flex-1 flex flex-col">
                            <p class="text-[10px] text-gray-400 mb-1 font-mono" x-text="'SKU: ' + p.sku"></p>
                            <h3 class="font-bold text-gray-900 leading-tight mb-2 flex-1" x-text="p.nombre"></h3>
                            <div class="mt-auto">
                                <p class="text-2xl font-black text-red-600 mb-4" x-text="'$' + p.precio.toFixed(2)"></p>
                                <button @click="fetchProductDetail(p)" :disabled="p.stock == 0"
                                    class="w-full bg-white text-red-600 border-2 border-red-600 hover:bg-red-600 hover:text-white font-bold py-2 px-4 rounded-lg transition-all text-sm uppercase tracking-tight disabled:opacity-50 disabled:cursor-not-allowed">
                                    Ver Detalles
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            
            <div x-show="!loading && filteredProducts.length === 0" class="text-center py-16 text-gray-400">
                <p class="text-lg font-semibold">No se encontraron productos.</p>
            </div>
        </div>
    </div>

    <!-- Modal de detalle -->
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
                        <div class="bg-white rounded-3xl p-12 border border-gray-200 shadow-sm flex items-center justify-center">
                            <span class="text-6xl">🔧</span>
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
                        <span class="bg-gray-100 text-gray-500 text-[10px] font-bold px-2 py-1 rounded-md" x-text="product.categoria"></span>
                        <h2 class="text-2xl font-extrabold text-gray-900 mt-3" x-text="product.nombre"></h2>
                        <p class="text-xs text-gray-400 mt-1">Marca: <span class="text-gray-900 font-bold" x-text="product.marca"></span></p>

                        <div class="my-4 flex items-center text-green-600 text-[10px] font-bold bg-green-50 px-2 py-1 rounded-full w-fit">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-2"></span>
                            <span x-text="product.stock + ' unidades disponibles'"></span>
                        </div>

                        <div class="mb-4">
                            <label class="text-xs font-bold text-gray-600 mb-1 block">Cantidad</label>
                            <input type="number" x-model="cantidad" min="1" :max="product.stock"
                                class="w-24 border border-gray-300 rounded-lg p-2 text-sm text-center">
                        </div>

                        <div class="mb-6">
                            <span class="text-4xl font-black text-red-600" x-text="'$' + (product.precio * cantidad).toFixed(2)"></span>
                            <span class="text-xs text-gray-400 font-bold ml-1">MXN + IVA</span>
                        </div>

                        <form method="POST" action="/cart/add">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="producto_id" :value="product.id">
                            <input type="hidden" name="cantidad" :value="cantidad">
                            <button type="submit" class="w-full bg-red-600 text-white font-bold py-3 rounded-xl shadow-lg hover:bg-red-700 transition-all uppercase text-sm tracking-widest">
                                Agregar al Carrito
                            </button>
                        </form>

                        <div class="mt-6 pt-6 border-t border-gray-50">
                            <h4 class="text-red-600 font-bold text-xs uppercase mb-2">Descripción Técnica</h4>
                            <p class="text-xs text-gray-600 leading-relaxed" x-text="product.descripcion"></p>
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
        loading: true,
        product: {},
        cantidad: 1,
        search: '',
        filterCategory: '',
        allProducts: @json($products ?? []),
        get categories() {
            return [...new Set(this.allProducts.map(p => p.categoria))];
        },
        get filteredProducts() {
            return this.allProducts.filter(p => {
                const matchSearch = !this.search || 
                    p.nombre.toLowerCase().includes(this.search.toLowerCase()) ||
                    p.sku.toLowerCase().includes(this.search.toLowerCase());
                const matchCat = !this.filterCategory || p.categoria === this.filterCategory;
                return matchSearch && matchCat;
            });
        },
        init() {
            this.loading = false;
        },
        fetchProductDetail(p) {
            this.product = p;
            this.cantidad = 1;
            this.showModal = true;
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