<?php

namespace App\Controllers;

use App\Models\DetallePedidoModel;
use App\Models\PedidosModel;
use App\Models\ProductosModel;
use App\Models\UsuariosModel;

class PedidosController extends BaseController
{
    protected $pedidos;
    protected $productos;
    protected $detallePedidos;
    protected $usuarios;
    public function __construct()
    {
        $this->pedidos = new PedidosModel();
        $this->productos = new ProductosModel();
        $this->detallePedidos = new DetallePedidoModel();
        $this->usuarios = new UsuariosModel();
        helper('form');
    }
    public function index()
    {
        $data['productosCarrito'] = $this->productos->obtenerProductosConDetalles();
        $data['carrito'] = $this->usuarios->obtenerCarrito(session()->get('loggedUser'));
        echo view('templates/header_checkout', );
        echo view('front/pedido', $data);
        echo view('templates/footer_admin');
    }
    public function listarPedidos()
    {
        $data = [
            'titulo' => 'Pedidos',
            'pedidos' => $this->pedidos->obtenerPedidos()
        ];
        $this->cargarVistaAdmin('pedidos/lista-pedidos', $data);
    }
    public function detallesPedido($id)
    {
        $data = [
            'titulo' => 'Detalle Pedido',
            'numero_pedido' => $id,
            'detalles' => $this->detallePedidos->obtenerDetallesPedido($id)
        ];
        $this->cargarVistaAdmin('pedidos/detalles-pedido', $data);
    }
    public function nuevoPedido()
    {
        $usuarioID = session()->get('loggedUser');
        $carrito = $this->usuarios->obtenerCarrito($usuarioID);
        $total = 0;
        foreach ($carrito as $producto) {
            $productoObtenido = $this->productos->find($producto['producto_id']);
            $total += (float) $productoObtenido['precio_venta'] * $producto['cantidad'];
        }
        $data = [
            'id_usuario' => $usuarioID,
            'precio_total' => $total,
            'estado' => 'En Preparación',
            'medio_pago' => $this->request->getPost('medio_de_pago'),
        ];
        $this->pedidos->insert($data);
        $pedidoID = $this->pedidos->getInsertID();
        foreach ($carrito as $producto) {
            $productoObtenido = $this->productos->find($producto['producto_id']);
            $data = [
                'id_producto' => $producto['producto_id'],
                'id_pedido' => $pedidoID,
                'precio_unitario' => (float) $productoObtenido['precio_venta'],
                'cantidad' => $producto['cantidad'],
                'precio_total' => (float) ($productoObtenido['precio_venta'] * $producto['cantidad']),
            ];
            $stock = ($productoObtenido['stock'] - $producto['cantidad']);
            $this->productos->actualizarProducto($producto['producto_id'], ['stock' => $stock]);
            $this->detallePedidos->insert($data);
        }
        $this->usuarios->actualizarCarrito($usuarioID, []);
        return redirect()->to('cuenta')->with('success', 'Compra concretada exitosamente');
    }
}
