<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class TipoController extends Controller
{
    private function getApiUrl($endpoint)
    {
        $baseUrl = env('API_BASE_URL', 'http://127.0.0.1:8000/api');
        return rtrim($baseUrl, '/') . '/' . ltrim($endpoint, '/');
    }

    public function listar()
    {
        $response = Http::get($this->getApiUrl('/tipos'));
        $tipos = $response->json()['data'] ?? [];

        return view("tipos/listado", compact("tipos"));
    }

    public function vistaFormulario()
    {
        return view("tipos/formulario");
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
            )->post($this->getApiUrl('/tipos'), $data);
        } else {
            $response = Http::asForm()->post($this->getApiUrl('/tipos'), $data);
        }

        if ($response->successful()) {
            return redirect('/tipos/listado')->with('exito', 'Tipo registrado con éxito vía API HttpClient');
        }

        return redirect()->back()->with('error', 'Error al registrar tipo vía API')->withInput();
    }

    public function vistaEdicion($id)
    {
        $response = Http::get($this->getApiUrl('/tipos/' . $id));
        $tipo = $response->json()['data'] ?? null;

        if (!$tipo) {
            return redirect('/tipos/listado')->with('error', 'El tipo especificado no existe.');
        }

        return view("tipos/edicion", compact("tipo"));
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
        $response = Http::asForm()->put($this->getApiUrl('/tipos/' . $id), $data);

        if ($response->successful()) {
            return redirect('/tipos/listado')->with('exito', 'Tipo #' . $id . ' actualizado correctamente vía API HttpClient');
        }

        return redirect()->back()->with('error', 'Error al actualizar tipo vía API')->withInput();
    }

    public function vistaMostrar($id)
    {
        $response = Http::get($this->getApiUrl('/tipos/' . $id));
        $tipo = $response->json()['data'] ?? null;

        if (!$tipo) {
            return redirect('/tipos/listado')->with('error', 'El tipo solicitado no existe.');
        }

        return view("tipos/mostrar", compact("tipo"));
    }

    public function borrar($id)
    {
        $response = Http::delete($this->getApiUrl('/tipos/' . $id));

        if ($response->successful()) {
            return redirect('/tipos/listado')->with('exito', 'Tipo #' . $id . ' eliminado con éxito vía API HttpClient.');
        }

        return redirect('/tipos/listado')->with('error', 'Error al eliminar tipo vía API.');
    }
}
