<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CatalogoApiController extends Controller
{
    private function getApiUrl($endpoint)
    {
        $baseUrl = env('API_BASE_URL', 'http://127.0.0.1:8000/api');
        return rtrim($baseUrl, '/') . '/' . ltrim($endpoint, '/');
    }

    /**
     * Muestra la vista del Catálogo/Galería de Productos consumiendo la API mediante Http::get().
     */
    public function index()
    {
        $response = Http::get($this->getApiUrl('/productos'));
        $data = $response->json();
        $productos = $data['data'] ?? [];

        return view('catalogo/index', compact('productos'));
    }

    /**
     * Muestra la vista a detalle de un producto específico consumiendo la API por ID mediante Http::get().
     */
    public function show($id)
    {
        $response = Http::get($this->getApiUrl('/productos/' . $id));
        $data = $response->json();
        $producto = $data['data'] ?? null;

        if (!$producto) {
            return redirect('/catalogo')->with('error', 'El producto seleccionado no está disponible.');
        }

        return view('catalogo/detalle', compact('producto'));
    }
}
