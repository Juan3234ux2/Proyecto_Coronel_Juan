<?php

namespace App\Controllers;

use App\Models\DetallePedidoModel;
use App\Models\PedidosModel;
use App\Models\usuariosModel;
use App\Models\ProductosModel;
use App\Libraries\Hash;


class UsuariosController extends BaseController
{
    protected $usuarios;
    protected $pedidos;
    protected $productos;
    protected $detallePedidos;
    public function __construct()
    {
        $this->usuarios = new usuariosModel();
        $this->pedidos = new PedidosModel();
        $this->productos = new ProductosModel();
        $this->detallePedidos = new DetallePedidoModel();
        helper(['url', 'form']);
    }
    public function index()
    {
        $usuarios = $this->usuarios->findAll();
        $data = ['titulo' => 'Usuarios', 'usuarios' => $usuarios];
        $this->cargarVistaAdmin('usuarios', $data);
    }
    public function cambiarAdmin()
    {
        $idUsuario = $this->request->getPost('id');
        $esAdmin = $this->request->getPost('esAdmin');
        if ($this->usuarios->update($idUsuario, ['esAdmin' => $esAdmin])) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error']);
        }
    }
    public function cuenta()
    {
        $idUsuario = session()->get('loggedUser');
        $data = [
            'titulo' => 'Mi Cuenta',
            'pedidos' => $this->pedidos->obtenerPedidosPorUsuario($idUsuario)
        ];
        $this->cargarVista('cuenta', $data);
    }
    public function detallePedido($idPedido)
    {
        $productosDelPedido = $this->detallePedidos->where('id_pedido', $idPedido)->findAll();
        $productosInfo = [];
        foreach ($productosDelPedido as $detalle) {
            $producto = $this->productos->obtenerProductoPorID($detalle['id_producto']);
            $productosInfo[] = $producto;
        }
        $data = [
            'titulo' => 'Detalle Compra',
            'productos' => $productosInfo,
            'detalles' => $productosDelPedido,
            'nroPedido' => $idPedido
        ];
        $this->cargarVista('pedido-cliente', $data);
    }
    public function editarDatos()
    {
        $data = [
            'titulo' => 'Editar Datos',
        ];
        $this->cargarVista('editar-datos', $data);
    }
    public function actualizarDatos()
    {
        $validaciones = $this->validate([
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo nombre es obligatorio.'
                ],

            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[usuarios.email]',
                'errors' => [
                    'required' => 'El campo email es obligatorio.',
                    'valid_email' => 'Ingrese un email válido.',
                    'is_unique' => 'Este correo ya está en uso.'
                ],
            ]
        ]);
        if (!$validaciones) {
            $this->cargarVista('editar-datos', ['titulo' => 'Editar Datos', 'validacion' => $this->validator]);
        }
        $idUsuario = session()->get('loggedUser');
        $nombre = $this->request->getPost('nombre');
        $email = $this->request->getPost('email');
        $data = [
            'nombre' => $nombre,
            'email' => $email,
        ];
        $this->usuarios->update($idUsuario, $data);
        return redirect()->to('cuenta')->with('success', 'Datos modificados exitosamente');
    }
    public function editarContraseña()
    {
        $data = [
            'titulo' => 'Editar Contraseña',
        ];
        $this->cargarVista('editar-contraseña', $data);
    }
    public function actualizarContraseña()
    {
        $validaciones = $this->validate([
            'contraseña' => [
                'rules' => 'required|min_length[6]|max_length[20]',
                'errors' => [
                    'required' => 'El campo contraseña es obligatorio',
                    'min_length' => 'La contraseña debe ser de al menos 6 caracteres',
                    'max_length' => 'La contraseña supera los 20 caracteres',
                ]
            ],
            'nuevaContraseña' => [
                'rules' => 'required|min_length[6]|max_length[20]',
                'errors' => [
                    'required' => 'El campo contraseña es obligatorio',
                    'min_length' => 'La contraseña debe ser de al menos 6 caracteres',
                    'max_length' => 'La contraseña supera los 20 caracteres',
                ]
            ],
        ]);
        if (!$validaciones) {
            $this->cargarVista('editar-contraseña', ['titulo' => 'Editar Datos', 'validacion' => $this->validator]);
        }
        $idUsuario = session()->get('loggedUser');
        $usuarioInfo = $this->usuarios->obtenerUsuarioPorId($idUsuario);
        $contraseña = $this->request->getPost('contraseña');
        $contraseñaVerificada = Hash::verificar($contraseña, $usuarioInfo['contraseña']);
        if ($contraseñaVerificada) {
            $nuevaContraseña = $this->request->getPost('nuevaContraseña');
            $nuevaContraseña = Hash::encriptar($nuevaContraseña);
            $this->usuarios->update($idUsuario, ['contraseña' => $nuevaContraseña]);
            return redirect()->to('cuenta')->with('success', 'Contraseña modificada exitosamente');
        } else {
            return redirect()->back()->with('fail', 'La contraseña actual no es correcta');
        }
    }
}
