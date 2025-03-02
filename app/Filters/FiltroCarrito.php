<?php

namespace App\Filters;

use App\Models\UsuariosModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class FiltroCarrito implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $usuarios = new UsuariosModel();
        if (session()->has('loggedUser')) {
            $usuarioID = session()->get('loggedUser');
            $carrito = $usuarios->obtenerCarrito($usuarioID);
            if (count($carrito) < 1) {
                return redirect()->to('/');
            }
        } else {
            return redirect()->to('/');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
