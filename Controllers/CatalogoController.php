<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CatalogoController extends Controller
{
    private function getApiUrl($endpoint)
    {
        $baseUrl = env('API_BASE_URL', 'http://127.0.0.1:8000/api');
        return rtrim($baseUrl, '/') . '/' . ltrim($endpoint, '/');
    }

    /**
     * 🛍️ Catálogo de Productos
     * Consume la API (GET /api/productos) mediante HttpClient (Http::get).
     * Muestra: Nombre del producto, Descripción, Precio, Imagen principal (imagen1) y enlace a detalle.
     */
    public function index()
    {
        $response = Http::get($this->getApiUrl('/productos'));
        $data = $response->json();
        $productos = $data['data'] ?? [];

        return view('catalogo.index', compact('productos'));
    }

    /**
     * 📦 Detalle del Producto
     * Consume la API (GET /api/productos/{id}) mediante HttpClient (Http::get).
     * Muestra: Nombre, Descripción, Precio, Existencia (stock) y LAS 3 IMÁGENES almacenadas en la API (imagen1, imagen2, imagen3).
     */
    public function show($id)
    {
        $response = Http::get($this->getApiUrl('/productos/' . $id));
        $data = $response->json();
        $producto = $data['data'] ?? null;

        if (!$producto) {
            return redirect('/catalogo')->with('error', 'El producto solicitado no está disponible en la API.');
        }

        return view('catalogo.detalle', compact('producto'));
    }
}
