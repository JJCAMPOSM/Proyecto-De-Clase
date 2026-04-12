<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // Carga vista Login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Procesa Login contra FastAPI
    public function processLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        try {
            // El contenedor laravel llama al contenedor api
            $response = Http::post('http://api:8000/api/auth/login', [
                'email' => $request->email,
                'password' => $request->password,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $user = $data['user'];
                $token = $data['access_token'];

                // Guardar en sesión
                session(['user' => $user, 'jwt_token' => $token]);

                // Si es Staff (Rol 1 o 3), redirigir directamente al Flask (Puerto 5000)
                if (in_array($user['rol_id'], [1, 3])) {
                    return redirect()->away('http://localhost:5000/dashboard');
                }

                // Si es Cliente (Rol 2), entra a la tienda general
                return redirect()->route('catalog.index');
            }

            return back()->withErrors(['email' => 'Credenciales inválidas.']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->withErrors(['email' => 'Error al conectar con la API central.']);
        }
    }

    // Carga vista Registro
    public function showRegister()
    {
        return view('auth.register');
    }

    // Procesa Registro contra FastAPI
    public function processRegister(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'apellidos' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            $response = Http::post('http://api:8000/api/users/external', [
                'nombre' => $request->nombre,
                'apellidos' => $request->apellidos,
                'telefono' => $request->telefono ?? '',
                'email' => $request->email,
                'password' => $request->password,
                'rol_id' => 2 // Default cliente
            ]);

            if ($response->successful()) {
                return redirect()->route('login')->with('success', 'Registro exitoso. Inicia sesión.');
            }

            return back()->withErrors(['email' => 'El correo podría ya estar registrado.']);
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Error al conectar al servicio de registro.']);
        }
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }
    
    public function logout()
    {
        session()->forget(['user', 'jwt_token']);
        return redirect()->route('login');
    }
}
