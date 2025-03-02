<?php

namespace App\Controllers;

use App\Models\categoriasModel;

class CategoriasController extends BaseController
{
    protected $categorias;
    public function __construct()
    {
        $this->categorias = new categoriasModel();
        helper('form');
    }
    public function index()
    {
        $categorias = $this->categorias->obtenerCategoriasActivas();
        $data = ['titulo' => 'Categorias', 'categorias' => $categorias];
        $this->cargarVistaAdmin('categorias/categorias', $data);
    }
    public function agregarCategoria()
    {
        $data = ['titulo' => 'Agregar categoria'];
        $this->cargarVistaAdmin('categorias/agregar_categoria', $data);
    }
    public function editarCategoria($id)
    {
        $categoria = $this->categorias->obtenerCategoriaPorId($id);
        $data = ['titulo' => 'Editar categoria', 'categoria' => $categoria];
        $this->cargarVistaAdmin('categorias/editar_categoria', $data);
    }
    public function insertarCategoria()
    {
        $validacion = $this->validate([
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo nombre es obligatorio'
                ]
            ],
        ]);
        if (!$validacion) {
            $this->cargarVistaAdmin('categorias/agregar_categoria', ['validacion' => $this->validator, 'titulo' => 'Agregar Categoria']);
        } else {
            $data = [
                'nombre' => $this->request->getPost('nombre')
            ];
            $this->categorias->insert($data);
            return redirect()->to('dashboard/categorias');
        }
    }
    public function actualizarCategoria()
    {
        $id = $this->request->getPost('id');
        $validacion = $this->validate([
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo nombre es obligatorio'
                ]
            ],
        ]);
        if (!$validacion) {
            $categoria = $this->categorias->obtenerCategoriaPorId($id);
            $this->cargarVistaAdmin('categorias/editar_categoria', ['validacion' => $this->validator, 'titulo' => 'Editar Categoria', 'categoria' => $categoria]);
        } else {
            $data = [
                'nombre' => $this->request->getPost('nombre')
            ];
            $this->categorias->actualizarCategoria($id, $data);
            return redirect()->to('dashboard/categorias');
        }
    }
    public function activarCategoria($id)
    {
        $data['activo'] = 1;
        $this->categorias->actualizarCategoria($id, $data);
        return redirect()->to('dashboard/categorias');
    }
    public function eliminarCategoria()
    {
        $id = $this->request->getPost('id');
        $data['activo'] = 0;
        $this->categorias->actualizarCategoria($id, $data);
        return $this->response->setJSON(['status' => 'success']);
    }
    public function categoriasEliminadas()
    {
        $categorias = $this->categorias->obtenerCategoriasInactivas();
        $data = ['titulo' => 'Categorias', 'categorias' => $categorias];
        $this->cargarVistaAdmin('categorias/eliminados', $data);
    }
}
