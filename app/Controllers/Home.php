<?php

namespace App\Controllers;

use App\Models\ProductosModel;

class Home extends BaseController
{
    public function index()
    {
        $data['titulo'] = 'Juancho\'s Lab';
        $this->cargarVista('index', $data);
    }
    public function quienesSomos()
    {
        $data['titulo'] = 'Nosotros';
        $this->cargarVista('quienes_somos', $data);
    }
    public function contacto()
    {
        $data['titulo'] = 'Contacto';
        $this->cargarVista('contacto', $data);
    }
    public function preguntasFrecuentes()
    {
        $data['titulo'] = 'Preguntas Frecuentes';
        $this->cargarVista('preguntas-frecuentes', $data);
    }
    public function terminosYCondiciones()
    {
        $data['titulo'] = 'Terminos y Condiciones';
        $this->cargarVista('terminos-condiciones', $data);
    }
    public function comercializacion()
    {
        $data['titulo'] = 'Comercializacion';
        $this->cargarVista('comercializacion', $data);
    }
    public function show404()
    {
        $data['titulo'] = "Página no encontrada";
        $this->cargarVista('404', $data);
    }
    public function buscar()
    {
        $productosModel = new ProductosModel();
        $request = service('request');
        $busqueda = $request->getGet('q');
        $productosEncontrados = $productosModel->buscar($busqueda);
        $data = [
            'titulo' => 'Resultados para \'' . $busqueda . ' \'',
            'productos' => $productosEncontrados,
            'busqueda' => $busqueda
        ];
        if (count($productosEncontrados) > 0) {
            $this->cargarVista('productos', $data);
        } else {
            $this->cargarVista('no-results', $data);
        }
    }
}
