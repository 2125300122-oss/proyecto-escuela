<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Administrador;
use App\Models\Cliente;
use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Tipo;
use App\Models\Empleado;
use App\Models\Producto;
use App\Models\Pedido;
use App\Models\ProductoPedido;

class FarmaciaSeeder extends Seeder
{
    public function run(): void
    {
        // Desactivar restricciones de llaves foráneas para reiniciar tablas si es necesario
        Schema::disableForeignKeyConstraints();
        ProductoPedido::truncate();
        Pedido::truncate();
        Producto::truncate();
        Empleado::truncate();
        Tipo::truncate();
        Marca::truncate();
        Categoria::truncate();
        Cliente::truncate();
        Administrador::truncate();
        Schema::enableForeignKeyConstraints();

        // 1. ADMINISTRADORES
        $admins = [
            ['id' => 1, 'nombres' => 'Carlos', 'apellidos' => 'Mendoza', 'correo' => 'carlos.admin@farmacia.com', 'usuario' => 'cmendoza', 'rol' => 'Gerente General'],
            ['id' => 2, 'nombres' => 'Ana', 'apellidos' => 'García', 'correo' => 'ana.garcia@farmacia.com', 'usuario' => 'agarcia', 'rol' => 'Administradora de Turno'],
            ['id' => 3, 'nombres' => 'Roberto', 'apellidos' => 'Martínez', 'correo' => 'roberto.m@farmacia.com', 'usuario' => 'rmartinez', 'rol' => 'Supervisora de Inventario'],
            ['id' => 4, 'nombres' => 'Sofía', 'apellidos' => 'Hernández', 'correo' => 'sofia.h@farmacia.com', 'usuario' => 'shernandez', 'rol' => 'Administradora de Sistema'],
            ['id' => 5, 'nombres' => 'Luis', 'apellidos' => 'Ramírez', 'correo' => 'luis.r@farmacia.com', 'usuario' => 'lramirez', 'rol' => 'Jefe de Compras'],
        ];

        foreach ($admins as $adm) {
            Administrador::create([
                'id' => $adm['id'],
                'nombres' => $adm['nombres'],
                'apellidos' => $adm['apellidos'],
                'correo' => $adm['correo'],
                'usuario' => $adm['usuario'],
                'contraseña' => bcrypt('123456'),
                'imagen' => 'imagenes/administradores/administrador_' . $adm['id'] . '.png',
                'rol' => $adm['rol'],
                'estado' => 1,
            ]);
        }

        // 2. CLIENTES
        $clientes = [
            ['id' => 1, 'nombres' => 'María', 'apellidos' => 'López Pérez', 'correo' => 'maria.lopez@gmail.com', 'direccion' => 'Av. Vallarta #4500, Guadalajara'],
            ['id' => 2, 'nombres' => 'Juan', 'apellidos' => 'González Silva', 'correo' => 'juan.gonzalez@hotmail.com', 'direccion' => 'Calle Hidalgo #120, Col. Centro'],
            ['id' => 3, 'nombres' => 'Laura', 'apellidos' => 'Torres Castro', 'correo' => 'laura.torres@outlook.com', 'direccion' => 'Av. Revolución #890, San Pedro'],
            ['id' => 4, 'nombres' => 'Jorge', 'apellidos' => 'Morales Díaz', 'correo' => 'jorge.morales@yahoo.com', 'direccion' => 'Calle Juárez #304, Zapopan'],
            ['id' => 5, 'nombres' => 'Elena', 'apellidos' => 'Vázquez Ruiz', 'correo' => 'elena.vazquez@gmail.com', 'direccion' => 'Av. América #50, Tlaquepaque'],
        ];

        foreach ($clientes as $cli) {
            Cliente::create([
                'id' => $cli['id'],
                'nombres' => $cli['nombres'],
                'apellidos' => $cli['apellidos'],
                'correo' => $cli['correo'],
                'contraseña' => bcrypt('cliente123'),
                'direccion' => $cli['direccion'],
                'imagen' => 'imagenes/clientes/cliente_' . $cli['id'] . '.png',
                'estado' => 1,
            ]);
        }

        // 3. CATEGORÍAS
        $categorias = [
            ['id' => 1, 'nombre' => 'Analgésicos y Antiinflamatorios'],
            ['id' => 2, 'nombre' => 'Antibióticos y Antivirales'],
            ['id' => 3, 'nombre' => 'Material de Curación y Antisépticos'],
            ['id' => 4, 'nombre' => 'Vitamins y Suplementos Alimenticios'],
            ['id' => 5, 'nombre' => 'Antihistamínicos y Salud Respiratoria'],
        ];

        foreach ($categorias as $cat) {
            Categoria::create([
                'id' => $cat['id'],
                'nombre' => $cat['nombre'],
                'imagen' => 'imagenes/categorias/categoria_' . $cat['id'] . '.png',
                'estado' => 1,
            ]);
        }

        // 4. MARCAS / LABORATORIOS
        $marcas = [
            ['id' => 1, 'nombre' => 'Bayer'],
            ['id' => 2, 'nombre' => 'Pfizer'],
            ['id' => 3, 'nombre' => 'Genomma Lab'],
            ['id' => 4, 'nombre' => 'Sanofi'],
            ['id' => 5, 'nombre' => 'Novartis'],
        ];

        foreach ($marcas as $mar) {
            Marca::create([
                'id' => $mar['id'],
                'nombre' => $mar['nombre'],
                'imagen' => 'imagenes/marcas/marca_' . $mar['id'] . '.png',
                'estado' => 1,
            ]);
        }

        // 5. TIPOS / FORMAS FARMACÉUTICAS
        $tipos = [
            ['id' => 1, 'nombre' => 'Tabletas y Comprimidos'],
            ['id' => 2, 'nombre' => 'Cápsulas'],
            ['id' => 3, 'nombre' => 'Jarabe y Solución Oral'],
            ['id' => 4, 'nombre' => 'Ungüento y Pomada Dermatológica'],
            ['id' => 5, 'nombre' => 'Inyectable y Ampolleta'],
        ];

        foreach ($tipos as $tip) {
            Tipo::create([
                'id' => $tip['id'],
                'nombre' => $tip['nombre'],
                'imagen' => 'imagenes/tipos/tipo_' . $tip['id'] . '.png',
                'estado' => 1,
            ]);
        }

        // 6. EMPLEADOS
        $empleados = [
            ['id' => 1, 'nombres' => 'Fernando', 'apellidos' => 'Ríos', 'correo' => 'fernando.rios@farmacia.com', 'usuario' => 'frios', 'puesto' => 'Farmacéutico Titular'],
            ['id' => 2, 'nombres' => 'Diana', 'apellidos' => 'Sánchez', 'correo' => 'diana.sanchez@farmacia.com', 'usuario' => 'dsanchez', 'puesto' => 'Cajera de Mostrador'],
            ['id' => 3, 'nombres' => 'Miguel', 'apellidos' => 'Angel Flores', 'correo' => 'miguel.flores@farmacia.com', 'usuario' => 'mflores', 'puesto' => 'Despachador de Medicamentos'],
            ['id' => 4, 'nombres' => 'Patricia', 'apellidos' => 'Ortega', 'correo' => 'patricia.ortega@farmacia.com', 'usuario' => 'portega', 'puesto' => 'Auxiliar de Farmacia'],
            ['id' => 5, 'nombres' => 'Gabriel', 'apellidos' => 'Campos', 'correo' => 'gabriel.campos@farmacia.com', 'usuario' => 'gcampos', 'puesto' => 'Encargado de Almacén'],
        ];

        foreach ($empleados as $emp) {
            Empleado::create([
                'id' => $emp['id'],
                'nombres' => $emp['nombres'],
                'apellidos' => $emp['apellidos'],
                'correo' => $emp['correo'],
                'usuario' => $emp['usuario'],
                'contraseña' => bcrypt('emp123'),
                'imagen' => 'imagenes/empleados/empleado_' . $emp['id'] . '.png',
                'puesto' => $emp['puesto'],
                'estado' => 1,
            ]);
        }

        // 7. PRODUCTOS / MEDICAMENTOS
        $productos = [
            ['id' => 1, 'nombre' => 'Aspirina 500mg', 'descripcion' => 'Alivio del dolor de cabeza, fiebre e inflamación ligera.', 'categoria_id' => 1, 'tipo_id' => 1, 'marca_id' => 1, 'precio' => 45.00, 'existencia' => 120, 'descuento' => 5.00],
            ['id' => 2, 'nombre' => 'Amoxicilina 500mg', 'descripcion' => 'Antibiótico de amplio espectro para infecciones bacterianas.', 'categoria_id' => 2, 'tipo_id' => 2, 'marca_id' => 2, 'precio' => 135.50, 'existencia' => 45, 'descuento' => 10.00],
            ['id' => 3, 'nombre' => 'Jarabe para la Tos Tussin 120ml', 'descripcion' => 'Jarabe alivio de la tos con flemas e irritación bronquial.', 'categoria_id' => 5, 'tipo_id' => 3, 'marca_id' => 4, 'precio' => 98.00, 'existencia' => 60, 'descuento' => 0.00],
            ['id' => 4, 'nombre' => 'Pomada Antiséptica Bephanten 30g', 'descripcion' => 'Ungüento regenerador de piel y cicatrizante antiséptico.', 'categoria_id' => 3, 'tipo_id' => 4, 'marca_id' => 1, 'precio' => 110.00, 'existencia' => 30, 'descuento' => 15.00],
            ['id' => 5, 'nombre' => 'Multivitamínico Pharmaton Cápsulas', 'descripcion' => 'Suplemento alimenticio con vitaminas, minerales y ginseng.', 'categoria_id' => 4, 'tipo_id' => 2, 'marca_id' => 5, 'precio' => 280.00, 'existencia' => 25, 'descuento' => 20.00],
        ];

        foreach ($productos as $prod) {
            Producto::create([
                'id' => $prod['id'],
                'nombre' => $prod['nombre'],
                'descripcion' => $prod['descripcion'],
                'categoria_id' => $prod['categoria_id'],
                'tipo_id' => $prod['tipo_id'],
                'marca_id' => $prod['marca_id'],
                'precio' => $prod['precio'],
                'existencia' => $prod['existencia'],
                'descuento' => $prod['descuento'],
                'imagen1' => 'imagenes/productos/producto_' . $prod['id'] . '.png',
                'imagen2' => 'imagenes/productos/producto_' . $prod['id'] . '_2.png',
                'imagen3' => 'imagenes/productos/producto_' . $prod['id'] . '_3.png',
                'estado' => 1,
            ]);
        }

        // 8. PEDIDOS
        $pedidos = [
            ['id' => 1, 'cliente_id' => 1, 'fecha' => '2026-09-25 10:30:00', 'iva' => 16.00, 'descuento' => 5.00, 'total' => 180.00, 'estado' => 'Pagado'],
            ['id' => 2, 'cliente_id' => 2, 'fecha' => '2026-09-26 14:15:00', 'iva' => 22.00, 'descuento' => 10.00, 'total' => 250.50, 'estado' => 'Entregado'],
            ['id' => 3, 'cliente_id' => 3, 'fecha' => '2026-09-27 09:45:00', 'iva' => 35.00, 'descuento' => 0.00, 'total' => 390.00, 'estado' => 'Pendiente'],
            ['id' => 4, 'cliente_id' => 4, 'fecha' => '2026-09-28 16:20:00', 'iva' => 12.00, 'descuento' => 15.00, 'total' => 135.00, 'estado' => 'Pagado'],
            ['id' => 5, 'cliente_id' => 5, 'fecha' => '2026-09-28 18:00:00', 'iva' => 40.00, 'descuento' => 20.00, 'total' => 440.00, 'estado' => 'En Camino'],
        ];

        foreach ($pedidos as $ped) {
            Pedido::create([
                'id' => $ped['id'],
                'cliente_id' => $ped['cliente_id'],
                'fecha' => $ped['fecha'],
                'iva' => $ped['iva'],
                'descuento' => $ped['descuento'],
                'total' => $ped['total'],
                'estado' => $ped['estado'],
            ]);
        }

        // 9. PRODUCTO_PEDIDO (DETALLES)
        $detalles = [
            ['id' => 1, 'pedido_id' => 1, 'producto_id' => 1, 'cantidad' => 2, 'precio' => 45.00, 'descuento' => 5.00],
            ['id' => 2, 'pedido_id' => 1, 'producto_id' => 3, 'cantidad' => 1, 'precio' => 98.00, 'descuento' => 0.00],
            ['id' => 3, 'pedido_id' => 2, 'producto_id' => 2, 'cantidad' => 2, 'precio' => 135.50, 'descuento' => 10.00],
            ['id' => 4, 'pedido_id' => 3, 'producto_id' => 5, 'cantidad' => 1, 'precio' => 280.00, 'descuento' => 20.00],
            ['id' => 5, 'pedido_id' => 4, 'producto_id' => 4, 'cantidad' => 1, 'precio' => 110.00, 'descuento' => 15.00],
        ];

        foreach ($detalles as $det) {
            ProductoPedido::create([
                'id' => $det['id'],
                'pedido_id' => $det['pedido_id'],
                'producto_id' => $det['producto_id'],
                'cantidad' => $det['cantidad'],
                'precio' => $det['precio'],
                'descuento' => $det['descuento'],
            ]);
        }
    }
}
