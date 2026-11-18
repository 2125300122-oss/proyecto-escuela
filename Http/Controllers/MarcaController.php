<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class MarcaController extends Controller
{
    private function getApiUrl($endpoint)
    {
        $baseUrl = env('API_BASE_URL', 'http://127.0.0.1:8000/api');
        return rtrim($baseUrl, '/') . '/' . ltrim($endpoint, '/');
    }

    public function listar()
    {
        $response = Http::get($this->getApiUrl('/marcas'));
        $marcas = $response->json()['data'] ?? [];

        return view("marcas/listado", compact("marcas"));
    }

    public function vistaFormulario()
    {
        return view("marcas/formulario");
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
            )->post($this->getApiUrl('/marcas'), $data);
        } else {
            $response = Http::asForm()->post($this->getApiUrl('/marcas'), $data);
        }

        if ($response->successful()) {
            return redirect('/marcas/listado')->with('exito', 'Marca / Proveedor registrado con éxito vía API HttpClient');
        }

        return redirect()->back()->with('error', 'Error al registrar marca vía API')->withInput();
    }

    public function vistaEdicion($id)
    {
        $response = Http::get($this->getApiUrl('/marcas/' . $id));
        $marca = $response->json()['data'] ?? null;

        if (!$marca) {
            return redirect('/marcas/listado')->with('error', 'La marca especificada no existe.');
        }

        return view("marcas/edicion", compact("marca"));
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
        $response = Http::asForm()->put($this->getApiUrl('/marcas/' . $id), $data);

        if ($response->successful()) {
            return redirect('/marcas/listado')->with('exito', 'Marca #' . $id . ' actualizada correctamente vía API HttpClient');
        }

        return redirect()->back()->with('error', 'Error al actualizar marca vía API')->withInput();
    }

    public function vistaMostrar($id)
    {
        $response = Http::get($this->getApiUrl('/marcas/' . $id));
        $marca = $response->json()['data'] ?? null;

        if (!$marca) {
            return redirect('/marcas/listado')->with('error', 'La marca solicitada no existe.');
        }

        return view("marcas/mostrar", compact("marca"));
    }

    public function borrar($id)
    {
        $response = Http::delete($this->getApiUrl('/marcas/' . $id));

        if ($response->successful()) {
            return redirect('/marcas/listado')->with('exito', 'Marca #' . $id . ' eliminada con éxito vía API HttpClient.');
        }

        return redirect('/marcas/listado')->with('error', 'Error al eliminar marca vía API.');
    }
}
