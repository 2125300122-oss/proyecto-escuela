<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
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
        $response = $this->client()->get($this->getApiUrl('/productos'));
        $data = $response->json();
        $productos = $data['data'] ?? [];

        return view("productos/listado", compact("productos"));
    }

    public function vistaFormulario()
    {
        $catRes = $this->client()->get($this->getApiUrl('/categorias'))->json();
        $tipRes = $this->client()->get($this->getApiUrl('/tipos'))->json();
        $marRes = $this->client()->get($this->getApiUrl('/marcas'))->json();

        $categorias = $catRes['data'] ?? [];
        $tipos = $tipRes['data'] ?? [];
        $marcas = $marRes['data'] ?? [];

        return view("productos/formulario", compact("categorias", "tipos", "marcas"));
    }

    public function registrar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'categoria_id' => 'required',
            'tipo_id' => 'required',
            'marca_id' => 'required',
            'precio' => 'required|numeric',
            'existencia' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = [
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'categoria_id' => $request->categoria_id,
            'tipo_id' => $request->tipo_id,
            'marca_id' => $request->marca_id,
            'precio' => $request->precio,
            'existencia' => $request->existencia,
            'descuento' => $request->descuento ?? 0,
        ];

        if ($request->hasFile('imagen1')) {
            $token = session('adminToken');
            $req = $token ? Http::withToken($token) : Http::asForm();
            $response = $req->attach(
                'imagen1',
                file_get_contents($request->file('imagen1')->path()),
                $request->file('imagen1')->getClientOriginalName()
            )->post($this->getApiUrl('/productos'), $data);
        } else {
            $response = $this->client()->asForm()->post($this->getApiUrl('/productos'), $data);
        }

        if ($response->successful()) {
            return redirect('/productos/listado')->with('exito', 'Producto registrado con éxito vía API');
        }

        return redirect()->back()->with('error', 'Error al registrar producto vía API')->withInput();
    }

    public function vistaEdicion($id)
    {
        $prodRes = $this->client()->get($this->getApiUrl('/productos/' . $id))->json();
        $producto = $prodRes['data'] ?? null;

        if (!$producto) {
            return redirect('/productos/listado')->with('error', 'El producto especificado no existe en la API.');
        }

        $categorias = $this->client()->get($this->getApiUrl('/categorias'))->json()['data'] ?? [];
        $tipos = $this->client()->get($this->getApiUrl('/tipos'))->json()['data'] ?? [];
        $marcas = $this->client()->get($this->getApiUrl('/marcas'))->json()['data'] ?? [];

        return view("productos/edicion", compact("producto", "categorias", "tipos", "marcas"));
    }

    public function actualizar(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'categoria_id' => 'required',
            'tipo_id' => 'required',
            'marca_id' => 'required',
            'precio' => 'required|numeric',
            'existencia' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = [
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'categoria_id' => $request->categoria_id,
            'tipo_id' => $request->tipo_id,
            'marca_id' => $request->marca_id,
            'precio' => $request->precio,
            'existencia' => $request->existencia,
            'descuento' => $request->descuento ?? 0,
        ];

        $response = $this->client()->asForm()->put($this->getApiUrl('/productos/' . $id), $data);

        if ($response->successful()) {
            return redirect('/productos/listado')->with('exito', 'Producto #' . $id . ' actualizado correctamente vía API');
        }

        return redirect()->back()->with('error', 'Error al actualizar producto vía API')->withInput();
    }

    public function vistaMostrar($id)
    {
        $prodRes = $this->client()->get($this->getApiUrl('/productos/' . $id))->json();
        $producto = $prodRes['data'] ?? null;

        if (!$producto) {
            return redirect('/productos/listado')->with('error', 'El producto solicitado no existe en la API.');
        }

        return view("productos/mostrar", compact("producto"));
    }

    public function borrar($id)
    {
        $response = $this->client()->delete($this->getApiUrl('/productos/' . $id));

        if ($response->successful()) {
            return redirect('/productos/listado')->with('exito', 'Producto #' . $id . ' eliminado con éxito vía API.');
        }

        return redirect('/productos/listado')->with('error', 'Error al eliminar producto vía API.');
    }
}
