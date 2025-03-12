<?php

namespace App\Controllers;

use App\Models\ProductosModel;
use App\Models\UsuariosModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }
    public function cargarVista($view, $data)
    {
        /*
        $productosModel = new ProductosModel();
        $infoProductos = $productosModel->obtenerProductosConDetalles();
        $data['productosCarrito'] = $infoProductos;
        if (session()->has('loggedUser')) {
            $usuarioId = session()->get('loggedUser');
            $usuariosModel = new UsuariosModel();
            $infoUsuario = $usuariosModel->find($usuarioId);
            $carrito = $usuariosModel->obtenerCarrito($usuarioId);
            $data += ['usuario' => $infoUsuario, 'carrito' => $carrito];
        }*/
        echo view('templates/header', $data);
        echo view('front/' . $view, $data);
        echo view('templates/footer');
    }
    public function cargarVistaAdmin($view, $data)
    {
        $usuariosModel = new UsuariosModel();
        $infoUsuario = $usuariosModel->find(session()->get('loggedUser'));
        $data += ['usuario' => $infoUsuario];
        echo view('templates/header_admin', $data);

        echo '<div class="d-flex">';

        echo view('templates/sidebar_admin');

        echo '<div style="flex: 1;">';

        echo view('templates/navbar_admin', $data);

        echo '<div style="margin-left: 280px; max-width: 100%">';

        echo view('admin/' . $view, $data);

        echo '</div>';

        echo '</div>';

        echo '</div>';
        echo view('templates/footer_admin', $data);
    }
}
