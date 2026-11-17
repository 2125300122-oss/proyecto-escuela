<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CarritoController extends Controller
{
    private function getApiUrl($endpoint)
    {
        $baseUrl = env('API_BASE_URL', 'http://127.0.0.1:8000/api');
        return rtrim($baseUrl, '/') . '/' . ltrim($endpoint, '/');
    }

    /**
     * 🛒 Mostrar el Carrito de Compras (GET /carrito)
     */
    public function index()
    {
        $carrito = session()->get('carrito', []);

        $total = 0;
        foreach ($carrito as $item) {
            $total += ($item['precio'] * $item['cantidad']);
        }

        return view('carrito.index', compact('carrito', 'total'));
    }

    /**
     * ➕ Agregar Producto al Carrito (POST /carrito/agregar/{id})
     * Restricción: Requiere haber iniciado sesión previamente.
     */
    public function agregar(Request $request, $id)
    {
        // VERIFICAR QUE EL USUARIO HAYA INICIADO SESIÓN
        if (!session()->has('userToken')) {
            return redirect('/usuario/login')->with('error', 'Necesitas iniciar sesión para agregar cosas al carrito de compras.');
        }

        // 1. Consultar información del producto desde la API REST
        $response = Http::get($this->getApiUrl('/productos/' . $id));
        $data = $response->json();
        $producto = $data['data'] ?? null;

        if (!$producto) {
            return redirect('/catalogo')->with('error', 'El producto no está disponible en la API.');
        }

        $producto = (object)$producto;
        $cantidad = max(1, (int)$request->input('cantidad', 1));

        // 2. Obtener el carrito desde la sesión del cliente
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad'] += $cantidad;
            $carrito[$id]['subtotal'] = $carrito[$id]['precio'] * $carrito[$id]['cantidad'];
        } else {
            $carrito[$id] = [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'precio' => (float)$producto->precio,
                'cantidad' => $cantidad,
                'imagen' => $producto->imagen1 ?? 'https://ui-avatars.com/api/?name=' . urlencode($producto->nombre),
                'subtotal' => (float)$producto->precio * $cantidad,
            ];
        }

        // 3. Guardar en la sesión del cliente
        session()->put('carrito', $carrito);

        return redirect('/carrito')->with('exito', 'Producto "' . $producto->nombre . '" agregado al carrito de compras.');
    }

    /**
     * 🔄 Actualizar Cantidad en el Carrito (POST /carrito/actualizar/{id})
     */
    public function actualizar(Request $request, $id)
    {
        $cantidad = max(1, (int)$request->input('cantidad', 1));
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad'] = $cantidad;
            $carrito[$id]['subtotal'] = $carrito[$id]['precio'] * $cantidad;
            session()->put('carrito', $carrito);

            return redirect('/carrito')->with('exito', 'Cantidad actualizada correctamente.');
        }

        return redirect('/carrito')->with('error', 'El producto no se encuentra en el carrito.');
    }

    /**
     * 🗑️ Eliminar un Producto del Carrito (GET o POST /carrito/eliminar/{id})
     */
    public function eliminar($id)
    {
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$id])) {
            $nombre = $carrito[$id]['nombre'];
            unset($carrito[$id]);
            session()->put('carrito', $carrito);

            return redirect('/carrito')->with('exito', 'Producto "' . $nombre . '" eliminado del carrito.');
        }

        return redirect('/carrito');
    }

    /**
     * 🧹 Vaciar Completamente el Carrito (GET o POST /carrito/vaciar)
     */
    public function vaciar()
    {
        session()->forget('carrito');
        return redirect('/carrito')->with('exito', 'Carrito de compras vaciado completamente.');
    }
}
