<?php

namespace App\Controllers;

use App\Models\marcasModel;

class MarcasController extends BaseController
{
    protected $marcas;
    public function __construct()
    {
        $this->marcas = new marcasModel();
        helper('form');
    }
    public function index()
    {
        $data = ['titulo' => 'Marcas'];
        $this->cargarVistaAdmin('cruds', $data);
    }
    public function listarMarcas()
    {
        $perPage = $this->request->getGet('perPage') ?? 10;
        $page = $this->request->getGet('page') ?? 1;
        $search = $this->request->getGet('search') ?? '';

        if (!empty($search)) {
            $this->marcas->like('nombre', $search);
        }

        $totalMarcas = $this->marcas->where('activo', 1)->countAllResults(false);
        $marcas = $this->marcas
            ->where('activo', 1)
            ->findAll($perPage, ($page - 1) * $perPage);

        return $this->response->setJSON([
            'items' => $marcas,
            'pagination' => [
                'total' => $totalMarcas,
                'perPage' => $perPage,
                'page' => (int) $page,
                'totalPages' => ceil($totalMarcas / $perPage)
            ]
        ]);
    }

    public function insertarMarca()
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
            $this->cargarVistaAdmin('marcas/agregar_marca', ['validacion' => $this->validator, 'titulo' => 'Agregar Marca']);
        } else {
            $data = [
                'nombre' => $this->request->getPost('nombre')
            ];
            $this->marcas->insert($data);
            return $this->response->setJSON(['status' => 'success']);
        }
    }
    public function actualizarMarca()
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
            $marca = $this->marcas->obtenerMarcasPorId($id);
            $this->cargarVistaAdmin('marcas/editar_marca', ['validacion' => $this->validator, 'titulo' => 'Editar Marca', 'marca' => $marca]);
        } else {
            $data = [
                'nombre' => $dataRequest['nombre'],
            ];
            $this->marcas->actualizarMarca($id, $data);
            return $this->response->setJSON(['status' => 'success']);
        }
    }
    public function activarMarca()
    {
        $dataRequest = $this->request->getRawInput();
        $id = $dataRequest['id'];
        $data = [
            'activo' => 1,
        ];
        $this->marcas->actualizarMarca($id, $data);
        return $this->response->setJSON(['status' => 'success', 'redirect' => base_url('dashboard/marcas')]);
    }
    public function eliminarMarca()
    {
        $dataRequest = $this->request->getRawInput();
        $id = $dataRequest['id'];
        $data['activo'] = 0;
        $this->marcas->actualizarMarca($id, $data);
        return $this->response->setJSON(['status' => 'success']);
    }
    public function marcasEliminadas()
    {
        $marcas = $this->marcas->obtenerMarcasInactivas();
        $data = ['titulo' => 'Marcas Eliminadas', 'items' => $marcas, 'entidad' => 'marcas'];
        $this->cargarVistaAdmin('lista_eliminados', $data);
    }
}
