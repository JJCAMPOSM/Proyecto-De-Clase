<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function index()
    {
        $user = session('user');
        if (!$user) return redirect()->route('login');

        try {
            $response = Http::timeout(5)->get("http://api:8000/api/orders/user/{$user['id']}");
            $orders = $response->successful() ? $response->json() : [];
        } catch (\Exception $e) {
            $orders = [];
        }
        return view('orders.index', compact('orders'));
    }

    public function downloadPdf($orderId)
    {
        try {
            $response = Http::timeout(10)->get("http://api:8000/api/reports/pdf/ordenes_pendientes");
            if ($response->successful()) {
                return response($response->body(), 200, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => "attachment; filename=\"pedido_{$orderId}.pdf\"",
                ]);
            }
        } catch (\Exception $e) {}
        return redirect()->back()->with('error', 'No se pudo generar el PDF.');
    }
}
