<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PageController extends Controller
{
    private function getApiUrl($endpoint)
    {
        $baseUrl = env('API_BASE_URL', 'http://127.0.0.1:8000/api');
        return rtrim($baseUrl, '/') . '/' . ltrim($endpoint, '/');
    }

    public function inicio()
    {
        $response = Http::get($this->getApiUrl('/productos'));
        $data = $response->json();
        $productosDestacados = array_slice($data['data'] ?? [], 0, 4);

        return view('paginas/inicio', compact('productosDestacados'));
    }

    public function nosotros()
    {
        return view('paginas/nosotros');
    }

    public function contacto()
    {
        return view('paginas/contacto');
    }
}
