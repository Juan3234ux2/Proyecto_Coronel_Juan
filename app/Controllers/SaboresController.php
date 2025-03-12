<?php

namespace App\Controllers;

use App\Models\SaboresModel;

class SaboresController extends BaseController
{
    protected $sabores;
    public function __construct()
    {
        $this->sabores = new SaboresModel();
        helper('form');
    }
    public function index()
    {
        $data = ['titulo' => 'Sabores', 'entidad' => 'sabores'];
        $this->cargarVistaAdmin('cruds', $data);
    }
    public function listarSabores()
    {
        $perPage = $this->request->getGet('perPage') ?? 10;
        $page = $this->request->getGet('page') ?? 1;
        $search = $this->request->getGet('search') ?? '';

        if (!empty($search)) {
            $this->sabores->like('nombre', $search);
        }

        $totalSabores = $this->sabores->where('activo', 1)->countAllResults(false);
        $sabores = $this->sabores
            ->where('activo', 1)
            ->findAll($perPage, ($page - 1) * $perPage);

        return $this->response->setJSON([
            'items' => $sabores,
            'pagination' => [
                'total' => $totalSabores,
                'perPage' => $perPage,
                'page' => (int) $page,
                'totalPages' => ceil($totalSabores / $perPage)
            ]
        ]);
    }
    public function insertarSabor()
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
            $this->cargarVistaAdmin('sabores/agregar_sabor', ['validacion' => $this->validator, 'titulo' => 'Agregar Producto']);
        } else {
            $data = [
                'nombre' => $this->request->getPost('nombre'),
                'nombre_corto' => $this->request->getPost('nombreCorto')
            ];
            $this->sabores->insert($data);
            return $this->response->setJSON(['status' => 'success']);
        }
    }
    public function actualizarSabor()
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
            $sabor = $this->sabores->obtenerSaboresPorId($id);
            $this->cargarVistaAdmin('sabores/editar_sabor', ['validacion' => $this->validator, 'titulo' => 'Editar Sabor', 'sabor' => $sabor]);
        } else {
            $data = [
                'nombre' => $dataRequest['nombre'],
            ];
            $this->sabores->actualizarSabor($id, $data);
            return $this->response->setJSON(['status' => 'success']);
        }
    }
    public function activarSabor()
    {
        $dataRequest = $this->request->getRawInput();
        $id = $dataRequest['id'];
        $data = [
            'activo' => 1,
        ];
        $this->sabores->actualizarSabor($id, $data);
        return $this->response->setJSON(['status' => 'success', 'redirect' => base_url('dashboard/sabores')]);
    }
    public function eliminarSabor()
    {
        $dataRequest = $this->request->getRawInput();
        $id = $dataRequest['id'];
        $data = [
            'activo' => 0,
        ];
        $this->sabores->actualizarSabor($id, $data);
        return $this->response->setJSON(['status' => 'success']);
    }
    public function saboresEliminados()
    {
        $sabores = $this->sabores->obtenerSaboresInactivos();
        $data = ['titulo' => 'Sabores Eliminados', 'items' => $sabores, 'entidad' => 'sabores'];
        $this->cargarVistaAdmin('lista_eliminados', $data);
    }
}
