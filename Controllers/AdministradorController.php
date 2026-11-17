<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class AdministradorController extends Controller
{
    private function getApiUrl($endpoint)
    {
        $baseUrl = env('API_BASE_URL', 'http://127.0.0.1:8000/api');
        return rtrim($baseUrl, '/') . '/' . ltrim($endpoint, '/');
    }

    private function client()
    {
        $token = session('adminToken');
        if ($token) {
            return Http::withToken($token)->acceptJson();
        }
        return Http::acceptJson();
    }

    public function listar()
    {
        $response = $this->client()->get($this->getApiUrl('/administradores'));
        $data = $response->json();
        $admins = $data['data'] ?? [];

        return view("administradores/listado", compact("admins"));
    }

    public function vistaFormulario()
    {
        return view("administradores/formulario");
    }

    public function registrar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo' => 'required|email',
            'usuario' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = [
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'usuario' => $request->usuario,
            'contraseña' => $request->contraseña ?? '123456',
            'rol' => $request->rol ?? 'Administrador',
        ];

        if ($request->hasFile('imagen')) {
            $token = session('adminToken');
            $req = $token ? Http::withToken($token) : Http::asForm();
            $response = $req->attach(
                'imagen',
                file_get_contents($request->file('imagen')->path()),
                $request->file('imagen')->getClientOriginalName()
            )->post($this->getApiUrl('/administradores'), $data);
        } else {
            $response = $this->client()->asForm()->post($this->getApiUrl('/administradores'), $data);
        }

        if ($response->successful()) {
            return redirect('/administradores/listado')->with('exito', 'Administrador registrado con éxito vía API con Token');
        }

        return redirect()->back()->with('error', 'Error al registrar administrador vía API')->withInput();
    }

    public function vistaEdicion($id = null)
    {
        $response = $this->client()->get($this->getApiUrl('/administradores/' . $id));
        $data = $response->json();
        $admin = $data['data'] ?? null;

        if (!$admin) {
            return redirect('/administradores/listado')->with('error', 'El administrador especificado no existe en la API.');
        }

        return view("administradores/edicion", compact("admin"));
    }

    public function actualizar(Request $request, $id = null)
    {
        $validator = Validator::make($request->all(), [
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo' => 'required|email',
            'usuario' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = [
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'usuario' => $request->usuario,
        ];

        $response = $this->client()->asForm()->put($this->getApiUrl('/administradores/' . $id), $data);

        if ($response->successful()) {
            return redirect('/administradores/listado')->with('exito', 'Administrador #' . $id . ' actualizado correctamente vía API');
        }

        return redirect()->back()->with('error', 'Error al actualizar vía API')->withInput();
    }

    public function vistaMostrar($id = null)
    {
        $response = $this->client()->get($this->getApiUrl('/administradores/' . $id));
        $data = $response->json();
        $admin = $data['data'] ?? null;

        if (!$admin) {
            return redirect('/administradores/listado')->with('error', 'El administrador solicitado no existe.');
        }

        return view("administradores/mostrar", compact("admin"));
    }

    public function borrar($id = null)
    {
        $response = $this->client()->delete($this->getApiUrl('/administradores/' . $id));

        if ($response->successful()) {
            return redirect('/administradores/listado')->with('exito', 'Administrador #' . $id . ' eliminado con éxito vía API.');
        }

        return redirect('/administradores/listado')->with('error', 'Error al eliminar administrador vía API.');
    }
}
