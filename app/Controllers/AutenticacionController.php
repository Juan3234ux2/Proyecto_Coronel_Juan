<?php

namespace App\Controllers;

use App\Models\UsuariosModel;
use App\Libraries\Hash;
use BackedEnum;

class AutenticacionController extends BaseController
{
    protected $usuarios;
    public function __construct()
    {
        helper(['url', 'form']);
        $this->usuarios = new UsuariosModel();
    }
    public function registro()
    {
        $data['titulo'] = "Registrarse";
        $this->cargarVista('registrarse', $data);
    }
    public function login()
    {
        $data['titulo'] = "Iniciar Sesión";
        $this->cargarVista('login', $data);
    }
    public function registrar()
    {
        $validado = $this->validate([
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo nombre es obligatorio'
                ]
            ],
            'apellido' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo apellido es obligatorio'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[usuarios.email]',
                'errors' => [
                    'required' => 'El campo email es obligatorio',
                    'valid_email' => 'Ingrese un correo valido',
                    'is_unique' => 'Este correo ya está registrado'
                ]
            ],
            'contraseña' => [
                'rules' => 'required|min_length[6]|max_length[20]',
                'errors' => [
                    'required' => 'El campo contraseña es obligatorio',
                    'min_length' => 'La contraseña debe ser de al menos 6 caracteres',
                    'max_length' => 'La contraseña supera los 20 caracteres',
                ]
            ],
            'confContraseña' => [
                'rules' => 'required|min_length[6]|max_length[20]|matches[contraseña]',
                'errors' => [
                    'required' => 'El campo confirmar contraseña es obligatorio',
                    'min_length' => 'La contraseña debe ser de al menos 6 caracteres',
                    'max_length' => 'La contraseña supera los 20 caracteres',
                    'matches' => 'Las contraseñas no coinciden'
                ]
            ],
        ]);

        if (!$validado) {
            $this->cargarVista('registrarse', ['validacion' => $this->validator, 'titulo' => 'Registrarse']);
        } else {
            $nombre = $this->request->getPost('nombre');
            $apellido = $this->request->getPost('apellido');
            $email = $this->request->getPost('email');
            $contraseña = $this->request->getPost('contraseña');

            $nombreCompleto = $nombre . ' ' . $apellido;
            $contraseña = Hash::encriptar($contraseña);
            $data = [
                'nombre' => $nombreCompleto,
                'email' => $email,
                'contraseña' => $contraseña
            ];
            $query = $this->usuarios->insert($data);
            if (!$query) {
                return redirect()->back()->with('fail', 'Algo salió mal');
            } else {
                $ultimoId = $this->usuarios->getInsertID();
                session()->set('loggedUser', $ultimoId);
                return redirect()->to('/');
            }
        }
    }
    public function iniciarSesion()
    {
        $validado = $this->validate([
            'email' => [
                'rules' => 'required|valid_email|is_not_unique[usuarios.email]',
                'errors' => [
                    'required' => 'El campo email es obligatorio',
                    'valid_email' => 'Ingrese un correo valido',
                    'is_not_unique' => 'Este correo no posee ninguna cuenta'
                ]
            ],
            'contraseña' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo contraseña es obligatorio',
                ]
            ],
        ]);
        if (!$validado) {
            $this->cargarVista('login', ['validacion' => $this->validator, 'titulo' => 'Iniciar Sesion']);
        } else {
            $email = $this->request->getPost('email');
            $contraseña = $this->request->getPost('contraseña');
            $usuarioInfo = $this->usuarios->where('email', $email)->first();
            $contraseñaVerificada = Hash::verificar($contraseña, $usuarioInfo['contraseña']);
            if (!$contraseñaVerificada) {
                session()->setFlashdata('fail', 'La contraseña es incorrecta');
                return redirect()->to('/iniciar-sesion')->withInput();
            } else {
                $usuarioId = $usuarioInfo['id'];
                session()->set('loggedUser', $usuarioId);
                if ($usuarioInfo['esAdmin']) {
                    return redirect()->to('/dashboard');
                } else {
                    return redirect()->to('/cuenta');
                }
            }
        }
    }
    public function cerrarSesion()
    {
        if (session()->has('loggedUser')) {
            session()->remove('loggedUser');
            session()->destroy();
            return redirect()->to('/');
        }
    }
}
