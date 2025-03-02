<?php

namespace App\Controllers;

use App\Models\CategoriasModel;
use App\Models\MarcasModel;
use App\Models\ProductosModel;
use App\Models\UnidadesModel;

class Productos extends BaseController
{
    protected $productos;
    protected $categorias;
    protected $unidades;
    protected $marcas;
    public function __construct()
    {
        $this->productos = new ProductosModel();
        $this->categorias = new CategoriasModel();
        $this->unidades = new UnidadesModel();
        $this->marcas = new MarcasModel();
        helper(['url', 'form', 'upload']);
    }
    public function index($categoria)
    {
        if ($categoria != "todos-los-productos") {
            $categoriaObtenida = $this->categorias->where('nombre', $categoria)->where('activo', 1)->first();
            if (!isset($categoriaObtenida)) {
                $data['titulo'] = 'Página no encontrada';
                $this->cargarVista('404', $data);
            } else {
                $idCategoria = $categoriaObtenida['id'];
                $data = [
                    'titulo' => $categoria,
                    'productos' => $this->productos->obtenerProductosPorCategoria($idCategoria)
                ];
                $this->cargarVista('productos', $data);
            }
        } else {
            $data = [
                'titulo' => $categoria,
                'productos' => $this->productos->obtenerProductosConDetalles()
            ];
            $this->cargarVista('productos', $data);
        }
    }
    public function verProducto($producto)
    {
        $parametro = explode("-", $producto);
        $id = end($parametro);
        $productoObtenido = $this->productos->obtenerProductoPorID($id);
        $nombreProducto = devolverNombreProducto($productoObtenido);
        $data = [
            'titulo' => $nombreProducto,
            'producto' => $productoObtenido,
            'nombreProducto' => $nombreProducto
        ];
        $this->cargarVista('detalles_productos', $data);
    }
    public function productosEliminados()
    {
        $productosEliminados = $this->productos->obtenerProductosInactivos();
        $data = [
            'titulo' => 'Productos Eliminados',
            'productos' => $productosEliminados
        ];
        $this->cargarVistaAdmin('productos/eliminados', $data);
    }
    public function listadoProductos()
    {
        $productos = $this->productos->obtenerProductosConDetalles();
        $data = [
            'titulo' => 'Productos',
            'productos' => $productos,
        ];
        $this->cargarVistaAdmin('productos/listado_productos', $data);
    }
    public function agregarProducto()
    {
        $data = $this->devolverDatos('Agregar Producto', null);
        $this->cargarVistaAdmin('productos/agregar_productos', $data);
    }
    public function insertarProducto()
    {
        $validacion = $this->validarFormulario(1);
        if (!$validacion) {
            $data = $this->devolverDatos('Agregar Producto', null);
            $this->cargarVistaAdmin('productos/agregar_productos', $data);
        } else {
            $imagen = $this->request->getFile('imagen');
            if ($imagen->isValid() && !$imagen->hasMoved()) {
                if ($imagen->isValid() && !$imagen->hasMoved()) {
                    $nombreImagen = $imagen->getRandomName();
                    $imagen->move(ROOTPATH . 'assets/uploads', $nombreImagen);
                    $data = [
                        'nombre' => $this->request->getPost('nombre'),
                        'id_marca' => $this->request->getPost('marca'),
                        'id_categoria' => $this->request->getPost('categoria'),
                        'precio_compra' => $this->request->getPost('precioCompra'),
                        'precio_venta' => $this->request->getPost('precioVenta'),
                        'stock' => $this->request->getPost('stock'),
                        'contenido' => $this->request->getPost('contenido'),
                        'id_unidad' => $this->request->getPost('unidad'),
                        'imagen' => $nombreImagen
                    ];
                    $this->productos->insert($data);
                    return redirect()->to('dashboard/productos')->with('success', 'Producto agregado correctamente!');
                } else {
                    return redirect()->back()->with('fail', 'Imagen no valida');
                }
            }
        }
    }
    public function activarProducto($id)
    {
        $data['activo'] = 1;
        $this->productos->actualizarProducto($id, $data);
        return redirect()->to('dashboard/productos')->with('success', "Producto Activado Correctamente");
    }
    public function eliminarProducto()
    {
        $idProducto = $this->request->getPost('id');
        $data['activo'] = 0;
        if ($this->productos->actualizarProducto($idProducto, $data)) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error']);
        }
    }
    public function editarProducto($id)
    {
        $data = $this->devolverDatos('Editar Producto', $id);
        $this->cargarVistaAdmin('productos/editar_producto', $data);
    }
    public function actualizarProducto()
    {
        $validacion = $this->validarFormulario(0);
        $id = $this->request->getPost('id');
        if (!$validacion) {
            $data = $this->devolverDatos('Editar Producto', $id);
            $this->cargarVistaAdmin('productos/editar_producto', $data);
        } else {
            $data = [
                'nombre' => $this->request->getPost('nombre'),
                'id_marca' => $this->request->getPost('marca'),
                'id_categoria' => $this->request->getPost('categoria'),
                'precio_compra' => $this->request->getPost('precioCompra'),
                'precio_venta' => $this->request->getPost('precioVenta'),
                'stock' => $this->request->getPost('stock'),
                'contenido' => $this->request->getPost('contenido'),
                'id_unidad' => $this->request->getPost('unidad'),
            ];
            $imagen = $this->request->getFile('imagen');
            if ($imagen->isValid()) {
                $nombreImagen = $imagen->getRandomName();
                $imagen->move(ROOTPATH . 'assets/uploads', $nombreImagen);
                $data['imagen'] = $nombreImagen;
            }
            $this->productos->actualizarProducto($id, $data);
            return redirect()->to('dashboard/productos')->with('success', 'Producto editado correctamente!');
            ;
        }
    }
    public function validarFormulario($esNuevo)
    {
        $reglas = [
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo nombre es obligatorio'
                ]
            ],
            'categoria' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo categoria es obligatorio'
                ]
            ],
            'marca' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo marca es obligatorio'
                ]
            ],
            'precioCompra' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'El campo precio compra es obligatorio',
                    'numeric' => 'El campo debe tener un valor numerico'
                ]
            ],
            'precioVenta' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'El campo precio venta es obligatorio',
                    'numeric' => 'El campo debe tener un valor numerico'
                ]
            ],
            'contenido' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'El campo contenido es obligatorio',
                    'numeric' => 'El campo debe tener un valor numerico'
                ]
            ],
            'unidad' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo unidad es obligatorio',
                ]

            ],
            'stock' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'El campo stock es obligatorio',
                    'numeric' => 'El campo debe tener un valor numerico'
                ]
            ],
        ];
        if ($esNuevo) {
            $reglas['imagen'] = [
                'rules' => 'uploaded[imagen]|is_image[imagen]',
                'errors' => [
                    'uploaded' => 'El campo imagen es obligatorio',
                    'is_image' => 'El archivo debe ser una imagen'
                ]
            ];
        }
        return $this->validate($reglas);
    }
    public function devolverDatos($titulo, $id)
    {
        $categorias = $this->categorias->obtenerCategoriasActivas();
        $unidades = $this->unidades->obtenerUnidadesActivas();
        $marcas = $this->marcas->obtenerMarcasActivas();
        if (isset($id)) {
            $producto = $this->productos->obtenerProductoPorID($id);
            return [
                'validacion' => $this->validator,
                'titulo' => $titulo,
                'categorias' => $categorias,
                'unidades' => $unidades,
                'marcas' => $marcas,
                'producto' => $producto
            ];
        } else {
            return [
                'validacion' => $this->validator,
                'titulo' => $titulo,
                'categorias' => $categorias,
                'unidades' => $unidades,
                'marcas' => $marcas,
            ];
        }
    }
}
