<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
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
        $response = $this->client()->get($this->getApiUrl('/clientes'));
        $clientes = $response->json()['data'] ?? [];

        return view("clientes/listado", compact("clientes"));
    }

    public function vistaFormulario()
    {
        return view("clientes/formulario");
    }

    public function registrar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo' => 'required|email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = [
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'direccion' => $request->direccion ?? 'Dirección registrada',
        ];

        if ($request->hasFile('imagen')) {
            $token = session('adminToken');
            $req = $token ? Http::withToken($token) : Http::asForm();
            $response = $req->attach(
                'imagen',
                file_get_contents($request->file('imagen')->path()),
                $request->file('imagen')->getClientOriginalName()
            )->post($this->getApiUrl('/clientes'), $data);
        } else {
            $response = $this->client()->asForm()->post($this->getApiUrl('/clientes'), $data);
        }

        if ($response->successful()) {
            return redirect('/clientes/listado')->with('exito', 'Cliente registrado con éxito vía API');
        }

        return redirect()->back()->with('error', 'Error al registrar cliente vía API')->withInput();
    }

    public function vistaEdicion($id)
    {
        $response = $this->client()->get($this->getApiUrl('/clientes/' . $id));
        $cliente = $response->json()['data'] ?? null;

        if (!$cliente) {
            return redirect('/clientes/listado')->with('error', 'El cliente especificado no existe.');
        }

        return view("clientes/edicion", compact("cliente"));
    }

    public function actualizar(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo' => 'required|email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = [
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'direccion' => $request->direccion ?? 'Dirección actualizada',
        ];

        $response = $this->client()->asForm()->put($this->getApiUrl('/clientes/' . $id), $data);

        if ($response->successful()) {
            return redirect('/clientes/listado')->with('exito', 'Cliente #' . $id . ' actualizado con éxito vía API');
        }

        return redirect()->back()->with('error', 'Error al actualizar cliente vía API')->withInput();
    }

    public function vistaMostrar($id)
    {
        $response = $this->client()->get($this->getApiUrl('/clientes/' . $id));
        $cliente = $response->json()['data'] ?? null;

        if (!$cliente) {
            return redirect('/clientes/listado')->with('error', 'El cliente solicitado no existe.');
        }

        return view("clientes/mostrar", compact("cliente"));
    }

    public function borrar($id)
    {
        $response = $this->client()->delete($this->getApiUrl('/clientes/' . $id));

        if ($response->successful()) {
            return redirect('/clientes/listado')->with('exito', 'Cliente #' . $id . ' eliminado con éxito vía API.');
        }

        return redirect('/clientes/listado')->with('error', 'Error al eliminar cliente vía API.');
    }
}
