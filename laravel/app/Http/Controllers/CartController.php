<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function addItem(Request $request)
    {
        $cart = session('cart', []);
        $productId = $request->producto_id;
        $cantidad = $request->cantidad ?? 1;

        if (isset($cart[$productId])) {
            $cart[$productId]['cantidad'] += $cantidad;
        } else {
            // Fetch product from API
            try {
                $res = Http::timeout(5)->get("http://api:8000/api/products/{$productId}");
                if ($res->successful()) {
                    $p = $res->json();
                    $cart[$productId] = [
                        'producto_id' => $p['id'],
                        'nombre' => $p['nombre'],
                        'precio' => $p['precio'],
                        'cantidad' => $cantidad,
                    ];
                }
            } catch (\Exception $e) {}
        }
        session(['cart' => $cart]);
        return redirect()->route('cart.index')->with('success', 'Producto agregado al carrito.');
    }

    public function removeItem(Request $request)
    {
        $cart = session('cart', []);
        unset($cart[$request->producto_id]);
        session(['cart' => $cart]);
        return redirect()->route('cart.index');
    }

    public function checkout(Request $request)
    {
        $user = session('user');
        if (!$user) return redirect()->route('login');

        $cart = session('cart', []);
        if (empty($cart)) return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');

        $productos = array_values(array_map(fn($item) => [
            'producto_id' => $item['producto_id'],
            'cantidad' => $item['cantidad'],
        ], $cart));

        try {
            $response = Http::timeout(10)->post('http://api:8000/api/orders/', [
                'usuario_id' => $user['id'],
                'tipo_cliente' => 'Externo',
                'direccion_envio' => $request->direccion,
                'notas' => $request->notas,
                'productos' => $productos,
            ]);

            if ($response->successful()) {
                session()->forget('cart');
                return redirect()->route('orders.index')->with('success', '¡Pedido confirmado exitosamente!');
            }
            return back()->with('error', 'Error al procesar pedido: ' . $response->json('detail', 'Error desconocido'));
        } catch (\Exception $e) {
            return back()->with('error', 'No se pudo conectar con el servidor.');
        }
    }
}
