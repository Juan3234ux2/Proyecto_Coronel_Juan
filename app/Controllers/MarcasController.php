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
        $marcas = $this->marcas->obtenerMarcasActivas();
        $data = ['titulo' => 'Marcas', 'marcas' => $marcas];
        $this->cargarVistaAdmin('marcas/marcas', $data);
    }
    public function agregarMarca()
    {
        $data = ['titulo' => 'Agregar marca'];
        $this->cargarVistaAdmin('marcas/agregar_marca', $data);
    }
    public function editarMarca($id)
    {
        $marca = $this->marcas->obtenerMarcasPorId($id);
        $data = ['titulo' => 'Editar marca', 'marca' => $marca];
        $this->cargarVistaAdmin('marcas/editar_marca', $data);
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
            return redirect()->to('dashboard/marcas');
        }
    }
    public function actualizarMarca()
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
            $marca = $this->marcas->obtenerMarcasPorId($id);
            $this->cargarVistaAdmin('marcas/editar_marca', ['validacion' => $this->validator, 'titulo' => 'Editar Marca', 'marca' => $marca]);
        } else {
            $data = [
                'nombre' => $this->request->getPost('nombre'),
            ];
            $this->marcas->actualizarMarca($id, $data);
            return redirect()->to('dashboard/marcas');
        }
    }
    public function activarMarca($id)
    {
        $data = [
            'activo' => 1,
        ];
        $this->marcas->actualizarMarca($id, $data);
        return redirect()->to('dashboard/marcas');
    }
    public function eliminarMarca()
    {
        $id = $this->request->getPost('id');
        $data['activo'] = 0;
        $this->marcas->actualizarMarca($id, $data);
        return $this->response->setJSON(['status' => 'success']);
    }
    public function marcasEliminadas()
    {
        $marcas = $this->marcas->obtenerMarcasInactivas();
        $data = ['titulo' => 'Marcas', 'marcas' => $marcas];
        $this->cargarVistaAdmin('marcas/eliminados', $data);
    }
}
