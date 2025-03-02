<?php

namespace App\Controllers;

use App\Models\ConsultasModel;


class ConsultasController extends BaseController
{
    protected $consultas;
    public function __construct()
    {
        helper(['url', 'form']);
        $this->consultas = new ConsultasModel();
    }
    public function recibirConsulta()
    {
        $validaciones = $this->validate([
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "El campo nombre es obligatorio"
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => "El campo email es obligatorio",
                    'valid_email' => "Ingrese un correo valido"
                ]
            ],
            'tipoConsulta' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "El campo tipo contacto es obligatorio"
                ]
            ],
            'consulta' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "El campo consulta es obligatorio"
                ]
            ]
        ]);
        if (!$validaciones) {
            $data = [
                'titulo' => 'Contacto',
                'validacion' => $this->validator
            ];
            $this->cargarVista('contacto', $data);
        } else {
            $data = [
                'nombre' => $this->request->getPost('nombre'),
                'email' => $this->request->getPost('email'),
                'tipo_consulta' => $this->request->getPost('tipoConsulta'),
                'mensaje' => $this->request->getPost('consulta')
            ];
            $this->consultas->insert($data);
            return redirect()->back();
        }
    }
    public function listarConsultas()
    {
        $data = [
            'titulo' => 'Consultas',
            'consultas' => $this->consultas->obtenerTodasLasConsultas()
        ];
        $this->cargarVistaAdmin('consultas/listado-consultas', $data);
    }
    public function verDetalleConsulta($id)
    {
        $data = [
            'titulo' => 'Consultas',
            'consulta' => $this->consultas->obtenerConsultaPorID($id)
        ];
        $this->cargarVistaAdmin('consultas/detalle-consulta', $data);
    }
    public function resolverConsulta()
    {
        $idConsulta = $this->request->getPost('id');
        $estaResuelto = $this->request->getPost('isResolved');
        if ($this->consultas->update($idConsulta, ['resuelto' => $estaResuelto])) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error']);
        }
    }
}
