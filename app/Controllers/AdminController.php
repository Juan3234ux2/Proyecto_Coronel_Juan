<?php

namespace App\Controllers;

use App\Models\CategoriasModel;
use App\Models\DetallePedidoModel;
use App\Models\PedidosModel;
use App\Models\ProductosModel;

class AdminController extends BaseController
{
    public function dashboard()
    {
        $pedidosModel = new PedidosModel();
        $categorias = new CategoriasModel();
        $estadisticaVentas = $pedidosModel->obtenerEstadisticasVentas();
        $datosPorcentaje = $this->obtenerPorcentajeVentas();
        $cantidadProductos = $datosPorcentaje['cantidadProductos'];
        $cantidadPorCategoria = $datosPorcentaje['cantidadPorCategoria'];
        $recaudado = 0;
        $porcentajePorCategoria = [];
        $fechas = [];
        $montos = [];
        foreach ($cantidadPorCategoria as $index => $cantidad) {
            $categoria = $categorias->find($index);
            $nombreCategoria = $categoria['nombre'];
            $porcentaje = round(100 * $cantidad / $cantidadProductos, 2);
            $porcentajePorCategoria[$nombreCategoria] = ['porcentaje' => $porcentaje];
        }
        foreach ($estadisticaVentas as $dia) {
            $montos = $dia['total_recaudado'];
            $fechas = $dia['fecha_compra'];
            $recaudado += $dia['total_recaudado'];
        }

        $categorias = array_keys($porcentajePorCategoria);
        $porcentajes = array_column($porcentajePorCategoria, 'porcentaje');
        $data = [
            'titulo' => "Panel Administrador Juancho's Lab",
            'fechas' => json_encode($fechas),
            'montos' => json_encode($montos),
            'recaudado' => number_format($recaudado, 2, ',', '.'),
            'cantidad_ventas' => count($pedidosModel->obtenerPedidosUltimaSemana()),
            'categorias' => json_encode($categorias),
            'porcentajes' => json_encode($porcentajes),
        ];
        $this->cargarVistaAdmin("dashboard", $data);
    }
    public function obtenerPorcentajeVentas()
    {
        $pedidosModel = new PedidosModel();
        $productosModel = new ProductosModel();
        $detallePedidosModel = new DetallePedidoModel();

        $pedidosUltimaSemana = $pedidosModel->obtenerPedidosUltimaSemana();
        $pedidosDetalles = [];
        $productos = [];
        $cantidadPorCategoria = [];

        foreach ($pedidosUltimaSemana as $pedido) {
            $pedidosDetalles[] = $detallePedidosModel->where('id_pedido', $pedido['id'])->findAll();
        }

        foreach ($pedidosDetalles as $detalle) {
            foreach ($detalle as $item) {
                $productos[] = $productosModel->find($item['id_producto']);
            }
        }
        foreach ($productos as $producto) {
            $categoriaId = $producto['id_categoria'];
            if (!isset($cantidadPorCategoria[$categoriaId])) {
                $cantidadPorCategoria[$categoriaId] = 0;
            }
            $cantidadPorCategoria[$categoriaId]++;
        }

        return [
            'cantidadProductos' => count($productos),
            'cantidadPorCategoria' => $cantidadPorCategoria
        ];
    }
}
