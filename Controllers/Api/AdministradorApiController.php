<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdministradorApiController extends Controller
{
    private function getApiUrl($endpoint)
    {
        $baseUrl = env('API_BASE_URL', 'http://127.0.0.1:8000/api');
        return rtrim($baseUrl, '/') . '/' . ltrim($endpoint, '/');
    }

    public function index()
    {
        $response = Http::get($this->getApiUrl('/administradores'));
        return response()->json($response->json(), $response->status());
    }

    public function show($id)
    {
        $response = Http::get($this->getApiUrl('/administradores/' . $id));
        return response()->json($response->json(), $response->status());
    }

    public function store(Request $request)
    {
        $response = Http::post($this->getApiUrl('/administradores'), $request->all());
        return response()->json($response->json(), $response->status());
    }

    public function update(Request $request, $id)
    {
        $response = Http::put($this->getApiUrl('/administradores/' . $id), $request->all());
        return response()->json($response->json(), $response->status());
    }

    public function destroy($id)
    {
        $response = Http::delete($this->getApiUrl('/administradores/' . $id));
        return response()->json($response->json(), $response->status());
    }
}
