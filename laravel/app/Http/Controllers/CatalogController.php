<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CatalogController extends Controller
{
    public function index()
    {
        try {
            $response = Http::timeout(5)->get('http://api:8000/api/products');
            $products = $response->successful() ? $response->json() : [];
        } catch (\Exception $e) {
            $products = [];
        }
        return view('catalog.index', compact('products'));
    }
}
