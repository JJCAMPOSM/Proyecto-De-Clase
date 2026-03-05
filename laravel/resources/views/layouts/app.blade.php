<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MACUIN - @yield('title', 'Portal')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            DEFAULT: '#E20613',
                            dark: '#c10510',
                            light: '#f7404a'
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 text-gray-800 antialiased font-sans flex flex-col min-h-screen">
    
    @if (!isset($hideNav) || !$hideNav)
    <!-- Navbar Corporativo -->
    <nav class="bg-white shadow border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Branding -->
                <div class="flex items-center">
                    <a href="{{ route('catalog.index') }}" class="flex-shrink-0 flex items-center font-bold text-2xl text-brand tracking-tighter">
                        MACUIN<span class="text-gray-800 tracking-normal text-lg ml-1">Autopartes</span>
                    </a>
                    <div class="hidden sm:ml-8 sm:flex sm:space-x-6">
                        <a href="{{ route('catalog.index') }}" class="{{ request()->routeIs('catalog.*') ? 'border-brand text-gray-900 border-b-2' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors">
                            Catálogo
                        </a>
                        <a href="{{ route('orders.index') }}" class="{{ request()->routeIs('orders.*') ? 'border-brand text-gray-900 border-b-2' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors">
                            Mis Pedidos
                        </a>
                    </div>
                </div>
                <!-- Right Nav -->
                <div class="flex items-center space-x-6">
                    <a href="{{ route('cart.index') }}" class="text-gray-500 hover:text-brand relative transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="absolute -top-1.5 -right-2 bg-brand text-white text-[10px] font-bold rounded-full h-4 w-4 flex items-center justify-center">2</span>
                    </a>
                    <div class="flex items-center space-x-3 border-l border-gray-200 pl-4">
                        <span class="text-sm text-gray-700 font-medium">Juan Pérez</span>
                        <a href="{{ route('login') }}" class="text-sm text-brand hover:text-brand-dark font-medium transition-colors">Salir</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    @endif

    <!-- Contenido Principal -->
    <main class="flex-grow w-full">
        @yield('content')
    </main>

    <footer class="bg-white border-t border-gray-200 mt-12 py-6">
        <div class="max-w-7xl mx-auto px-4 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} MACUIN Autopartes. Todos los derechos reservados.
        </div>
    </footer>
</body>
</html>
