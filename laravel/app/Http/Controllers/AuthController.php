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
                $user = $data['user'] ?? null;
                $token = $data['access_token'] ?? null;

                if (! $user || ! $token) {
                    return back()->withErrors(['email' => 'La API respondió sin datos completos de usuario.']);
                }

                session(['user' => $user, 'jwt_token' => $token]);

                if (in_array($user['rol_id'], [1, 3])) {
                    return redirect()->away('http://localhost:5000/dashboard');
                }

                if ($user['rol_id'] === 2) {
                    return redirect()->route('catalog.index')->with('success', 'Ingreso exitoso. Redirigiendo al catálogo de clientes.');
                }

                return back()->withErrors(['email' => 'Tu cuenta ha iniciado sesión, pero no tiene permiso para este portal.']);
            }

            $errorMessage = $response->json()['detail'] ?? 'Credenciales inválidas o error en el servicio.';
            return back()->withErrors(['email' => $errorMessage]);
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
