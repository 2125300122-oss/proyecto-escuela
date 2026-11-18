<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class EmpleadoController extends Controller
{
    private function getApiUrl($endpoint)
    {
        $baseUrl = env('API_BASE_URL', 'http://127.0.0.1:8000/api');
        return rtrim($baseUrl, '/') . '/' . ltrim($endpoint, '/');
    }

    public function listar()
    {
        $response = Http::get($this->getApiUrl('/empleados'));
        $empleados = $response->json()['data'] ?? [];

        return view("empleados/listado", compact("empleados"));
    }

    public function vistaFormulario()
    {
        return view("empleados/formulario");
    }

    public function registrar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo' => 'required|email',
            'usuario' => 'required|string',
            'puesto' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = [
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'usuario' => $request->usuario,
            'contraseña' => $request->contraseña ?? 'emp123',
            'puesto' => $request->puesto,
        ];

        if ($request->hasFile('imagen')) {
            $response = Http::attach(
                'imagen',
                file_get_contents($request->file('imagen')->path()),
                $request->file('imagen')->getClientOriginalName()
            )->post($this->getApiUrl('/empleados'), $data);
        } else {
            $response = Http::asForm()->post($this->getApiUrl('/empleados'), $data);
        }

        if ($response->successful()) {
            return redirect('/empleados/listado')->with('exito', 'Empleado registrado con éxito vía API HttpClient');
        }

        return redirect()->back()->with('error', 'Error al registrar empleado vía API')->withInput();
    }

    public function vistaEdicion($id)
    {
        $response = Http::get($this->getApiUrl('/empleados/' . $id));
        $empleado = $response->json()['data'] ?? null;

        if (!$empleado) {
            return redirect('/empleados/listado')->with('error', 'El empleado especificado no existe.');
        }

        return view("empleados/edicion", compact("empleado"));
    }

    public function actualizar(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo' => 'required|email',
            'usuario' => 'required|string',
            'puesto' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = [
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'usuario' => $request->usuario,
            'puesto' => $request->puesto,
        ];

        $response = Http::asForm()->put($this->getApiUrl('/empleados/' . $id), $data);

        if ($response->successful()) {
            return redirect('/empleados/listado')->with('exito', 'Empleado #' . $id . ' actualizado correctamente vía API HttpClient');
        }

        return redirect()->back()->with('error', 'Error al actualizar empleado vía API')->withInput();
    }

    public function vistaMostrar($id)
    {
        $response = Http::get($this->getApiUrl('/empleados/' . $id));
        $empleado = $response->json()['data'] ?? null;

        if (!$empleado) {
            return redirect('/empleados/listado')->with('error', 'El empleado solicitado no existe.');
        }

        return view("empleados/mostrar", compact("empleado"));
    }

    public function borrar($id)
    {
        $response = Http::delete($this->getApiUrl('/empleados/' . $id));

        if ($response->successful()) {
            return redirect('/empleados/listado')->with('exito', 'Empleado #' . $id . ' eliminado con éxito vía API HttpClient.');
        }

        return redirect('/empleados/listado')->with('error', 'Error al eliminar empleado vía API.');
    }
}
