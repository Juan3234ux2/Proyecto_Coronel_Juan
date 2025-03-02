<?php

namespace App\Controllers;

use App\Models\UnidadesModel;

class UnidadesController extends BaseController
{
    protected $unidades;
    public function __construct()
    {
        $this->unidades = new UnidadesModel();
        helper('form');
    }
    public function index()
    {
        $unidades = $this->unidades->obtenerUnidadesActivas();
        $data = ['titulo' => 'Unidades', 'unidades' => $unidades];
        $this->cargarVistaAdmin('unidades/unidades', $data);
    }
    public function agregarUnidad()
    {
        $data = ['titulo' => 'Agregar Unidad'];
        $this->cargarVistaAdmin('unidades/agregar_unidad', $data);
    }
    public function editarUnidad($id)
    {
        $unidad = $this->unidades->obtenerUnidadesPorId($id);
        $data = ['titulo' => 'Editar Unidad', 'unidad' => $unidad];
        $this->cargarVistaAdmin('unidades/editar_unidad', $data);
    }
    public function insertarUnidad()
    {
        $validacion = $this->validate([
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo nombre es obligatorio'
                ]
            ],
            'nombreCorto' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo nombre corto es obligatorio'
                ]
            ]
        ]);
        if (!$validacion) {
            $this->cargarVistaAdmin('unidades/agregar_unidad', ['validacion' => $this->validator, 'titulo' => 'Agregar Producto']);
        } else {
            $data = [
                'nombre' => $this->request->getPost('nombre'),
                'nombre_corto' => $this->request->getPost('nombreCorto')
            ];
            $this->unidades->insert($data);
            return redirect()->to('dashboard/unidades');
        }
    }
    public function actualizarUnidad()
    {
        $id = $this->request->getPost('id');
        $validacion = $this->validate([
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo nombre es obligatorio'
                ]
            ],
            'nombreCorto' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo nombre corto es obligatorio'
                ]
            ]
        ]);
        if (!$validacion) {
            $unidad = $this->unidades->obtenerUnidadesPorId($id);
            $this->cargarVistaAdmin('unidades/editar_unidad', ['validacion' => $this->validator, 'titulo' => 'Editar Unidad', 'unidad' => $unidad]);
        } else {
            $data = [
                'nombre' => $this->request->getPost('nombre'),
                'nombre_corto' => $this->request->getPost('nombreCorto')
            ];
            $this->unidades->actualizarUnidad($id, $data);
            return redirect()->to('dashboard/unidades');
        }
    }
    public function activarUnidad($id)
    {
        $data = [
            'activo' => 1,
        ];
        $this->unidades->actualizarUnidad($id, $data);
        return redirect()->to('dashboard/unidades');
    }
    public function eliminarUnidad()
    {
        $id = $this->request->getPost('id');
        $data['activo'] = 0;
        $this->unidades->actualizarUnidad($id, $data);
        return $this->response->setJSON(['status' => 'success']);
    }
    public function unidadesEliminadas()
    {
        $unidades = $this->unidades->obtenerUnidadesInactivas();
        $data = ['titulo' => 'Unidades', 'unidades' => $unidades];
        $this->cargarVistaAdmin('unidades/eliminados', $data);
    }
}
