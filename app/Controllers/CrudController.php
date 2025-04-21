<?php

namespace App\Controllers;

class CrudController extends BaseController
{
    protected $entityModel;
    protected $entityName;
    public function __construct($entityModel, $entityName)
    {
        $this->entityModel = $entityModel;
        $this->entityName = $entityName;
        helper('form');
    }
    public function index()
    {
        $data = ['titulo' => $this->entityName];
        $this->cargarVistaAdmin('cruds', $data);
    }
    public function list()
    {
        try {
            $perPage = $this->request->getGet('perPage') ?? 10;
            $page = $this->request->getGet('page') ?? 1;
            $search = $this->request->getGet('search') ?? '';

            if (!empty($search)) {
                $this->entityModel->like('nombre', $search);
            }

            $totalItems = $this->entityModel->where('activo', 1)->countAllResults(false);
            $items = $this->entityModel
                ->where('activo', 1)
                ->findAll($perPage, ($page - 1) * $perPage);

            return $this->response->setJSON([
                'items' => $items,
                'pagination' => [
                    'total' => $totalItems,
                    'perPage' => $perPage,
                    'page' => (int) $page,
                    'totalPages' => ceil($totalItems / $perPage)
                ]
            ])->setStatusCode(200);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500);
        }
    }

    public function create()
    {
        try {
            $validacion = $this->validate([
                'nombre' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo nombre es obligatorio'
                    ]
                ],
            ]);
            if (!$validacion) {
                return $this->response->setJSON(['status' => 'error', 'errors' => $this->validator->getErrors()]);
            }
            $data = [
                'nombre' => $this->request->getPost('nombre')
            ];
            $insertedID = $this->entityModel->insert($data);
            return $this->response->setJSON(['status' => 'success', 'data' => $this->entityModel->find($insertedID)]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500);
        }
    }
    public function update()
    {
        try {
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
                return $this->response->setJSON(['status' => 'error', 'errors' => $this->validator->getErrors()]);
            }
            $data = [
                'nombre' => $dataRequest['nombre'],
            ];
            $this->entityModel->update($id, $data);
            $item = $this->entityModel->find($id);
            return $this->response->setJSON(['status' => 'success', 'data ' => $item]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500);
        }
    }
    public function restore()
    {
        try {
            $dataRequest = $this->request->getRawInput();
            $id = $dataRequest['id'];
            $data = [
                'activo' => 1,
            ];
            $this->entityModel->update($id, $data);
            return $this->response->setJSON(['status' => 'success', 'redirect' => base_url('dashboard/' . strtolower($this->entityName))]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500);
        }
    }
    public function delete()
    {
        try {
            $dataRequest = $this->request->getRawInput();
            $id = $dataRequest['id'];
            $data['activo'] = 0;
            $this->entityModel->update($id, $data);
            return $this->response->setJSON(['status' => 'success']);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500);
        }
    }
    public function listDeleted()
    {
        $items = $this->entityModel->where('activo', 0)->findAll();
        $genero = substr($this->entityName, -2) == "as" ? 'Eliminadas' : 'Eliminados';
        $data = ['titulo' => "$this->entityName $genero", 'items' => $items, 'entidad' => strtolower($this->entityName)];
        $this->cargarVistaAdmin('lista_eliminados', $data);
    }
}
