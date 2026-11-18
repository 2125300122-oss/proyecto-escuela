<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller
{
    private function getApiUrl($endpoint)
    {
        $baseUrl = env('API_BASE_URL', 'http://127.0.0.1:8000/api');
        return rtrim($baseUrl, '/') . '/' . ltrim($endpoint, '/');
    }

    public function listar()
    {
        $response = Http::get($this->getApiUrl('/categorias'));
        $categorias = $response->json()['data'] ?? [];

        return view("categorias/listado", compact("categorias"));
    }

    public function vistaFormulario()
    {
        return view("categorias/formulario");
    }

    public function registrar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = ['nombre' => $request->nombre];

        if ($request->hasFile('imagen')) {
            $response = Http::attach(
                'imagen',
                file_get_contents($request->file('imagen')->path()),
                $request->file('imagen')->getClientOriginalName()
            )->post($this->getApiUrl('/categorias'), $data);
        } else {
            $response = Http::asForm()->post($this->getApiUrl('/categorias'), $data);
        }

        if ($response->successful()) {
            return redirect('/categorias/listado')->with('exito', 'Categoría registrada con éxito vía API HttpClient');
        }

        return redirect()->back()->with('error', 'Error al registrar categoría vía API')->withInput();
    }

    public function vistaEdicion($id)
    {
        $response = Http::get($this->getApiUrl('/categorias/' . $id));
        $categoria = $response->json()['data'] ?? null;

        if (!$categoria) {
            return redirect('/categorias/listado')->with('error', 'La categoría especificada no existe.');
        }

        return view("categorias/edicion", compact("categoria"));
    }

    public function actualizar(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = ['nombre' => $request->nombre];
        $response = Http::asForm()->put($this->getApiUrl('/categorias/' . $id), $data);

        if ($response->successful()) {
            return redirect('/categorias/listado')->with('exito', 'Categoría #' . $id . ' actualizada correctamente vía API HttpClient');
        }

        return redirect()->back()->with('error', 'Error al actualizar categoría vía API')->withInput();
    }

    public function vistaMostrar($id)
    {
        $response = Http::get($this->getApiUrl('/categorias/' . $id));
        $categoria = $response->json()['data'] ?? null;

        if (!$categoria) {
            return redirect('/categorias/listado')->with('error', 'La categoría solicitada no existe.');
        }

        return view("categorias/mostrar", compact("categoria"));
    }

    public function borrar($id)
    {
        $response = Http::delete($this->getApiUrl('/categorias/' . $id));

        if ($response->successful()) {
            return redirect('/categorias/listado')->with('exito', 'Categoría #' . $id . ' eliminada con éxito vía API HttpClient.');
        }

        return redirect('/categorias/listado')->with('error', 'Error al eliminar categoría vía API.');
    }
}
