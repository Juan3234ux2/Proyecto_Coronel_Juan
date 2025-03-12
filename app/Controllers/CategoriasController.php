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
        $data = ['titulo' => 'Categorías', 'entidad' => 'categorias'];
        $this->cargarVistaAdmin('cruds', $data);
    }
    public function listarCategorias()
    {
        $perPage = $this->request->getGet('perPage') ?? 10;
        $page = $this->request->getGet('page') ?? 1;
        $search = $this->request->getGet('search') ?? '';

        if (!empty($search)) {
            $this->categorias->like('nombre', $search);
        }

        $totalCategorias = $this->categorias->where('activo', 1)->countAllResults(false);
        $categorias = $this->categorias
            ->where('activo', 1)
            ->findAll($perPage, ($page - 1) * $perPage);

        return $this->response->setJSON([
            'items' => $categorias,
            'pagination' => [
                'total' => $totalCategorias,
                'perPage' => $perPage,
                'page' => (int) $page,
                'totalPages' => ceil($totalCategorias / $perPage)
            ]
        ]);
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
            return $this->response->setJSON(['status' => 'success']);
        }
    }
    public function actualizarCategoria()
    {
        $dataRequest = $this->request->getRawInput();
        $id = $dataRequest['id'];
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
                'nombre' => $dataRequest['nombre']
            ];
            $this->categorias->actualizarCategoria($id, $data);
            return $this->response->setJSON(['status' => 'success']);
        }
    }
    public function activarCategoria()
    {
        $dataRequest = $this->request->getRawInput();
        $id = $dataRequest['id'];
        $data['activo'] = 1;
        $this->categorias->actualizarCategoria($id, $data);
        return $this->response->setJSON(['status' => 'success', 'redirect' => base_url('dashboard/categorias')]);
    }
    public function eliminarCategoria()
    {
        $dataRequest = $this->request->getRawInput();
        $id = $dataRequest['id'];
        $data['activo'] = 0;
        $this->categorias->actualizarCategoria($id, $data);
        return $this->response->setJSON(['status' => 'success']);
    }
    public function categoriasEliminadas()
    {
        $categorias = $this->categorias->obtenerCategoriasInactivas();
        $data = ['titulo' => 'Categorías Eliminadas', 'items' => $categorias, 'entidad' => 'categorias'];
        $this->cargarVistaAdmin('lista_eliminados', $data);
    }
}
