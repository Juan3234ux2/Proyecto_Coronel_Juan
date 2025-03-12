<?php

namespace App\Controllers;

use App\Models\ProductosModel;
use CodeIgniter\Controller;
use App\Models\UsuariosModel;

class CarritoController extends Controller
{
    protected $usuarios;
    protected $productos;

    public function __construct()
    {
        session();
        $this->usuarios = new UsuariosModel();
        $this->productos = new ProductosModel();
    }

    public function agregarAlCarrito()
    {
        $productoID = $this->request->getPost('id');
        $cantidad = $this->request->getPost('cantidad');
        $usuarioId = session()->get('loggedUser');
        $url = 'productos/' . $this->obtenerURLProducto($productoID);
        if ($usuarioId) {
            $carrito = $this->usuarios->obtenerCarrito($usuarioId);
        }
        $productoObtenido = $this->productos->obtenerProductoPorID($productoID);
        if (isset($carrito[$productoID])) {
            if ($productoObtenido['stock'] >= ($carrito[$productoID]['cantidad'] + $cantidad)) {
                $carrito[$productoID]['cantidad'] += $cantidad;
            } else {
                $this->response->setJSON(['status' => 'error']);
                return redirect()->to($url)->with('error', 'No hay suficiente stock de este producto');
            }
        } else {
            if ($productoObtenido['stock'] >= $cantidad) {
                $carrito[$productoID] = ['producto_id' => $productoID, 'cantidad' => $cantidad];
            } else {
                return redirect()->to($url)->with('error', 'No hay suficiente stock de este producto');
            }
        }
        $this->usuarios->actualizarCarrito($usuarioId, $carrito);
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'success']);
        }
        return redirect()->to($url)->with('success', 'Producto agregado al carrito');
    }
    public function eliminarDelCarrito()
    {
        $productoID = $this->request->getPost('id');
        $usuarioId = session()->get('loggedUser');
        if ($usuarioId) {
            $carrito = $this->usuarios->obtenerCarrito($usuarioId);
        }
        if (isset($carrito[$productoID])) {
            unset($carrito[$productoID]);
        }
        $this->usuarios->actualizarCarrito($usuarioId, $carrito);
        return $this->response->setJSON(['status' => 'success']);
    }
    public function obtenerURLProducto($id)
    {
        $producto = $this->productos->obtenerProductoPorID($id);
        $nombre = $producto['nombre'] . ' ' . $producto['contenido'] . $producto['nombre_unidad'] . ' ' . $producto['nombre_marca'];
        $url = strtolower(str_replace(" ", "-", $nombre . ' ' . $producto['id']));
        return $url;
    }
}
