<?php

namespace App\Controllers;

use App\Models\CategoriasModel;
use App\Models\ImagenesPresentacionesModel;
use App\Models\MarcasModel;
use App\Models\PresentacionesModel;
use App\Models\ProductosModel;
use App\Models\SaboresModel;
use App\Models\UnidadesModel;

class Productos extends BaseController
{
    protected $productos;
    protected $categorias;
    protected $sabores;
    protected $unidades;
    protected $marcas;
    protected $presentaciones;
    protected $imagenesPresentaciones;
    public function __construct()
    {
        $this->productos = new ProductosModel();
        $this->categorias = new CategoriasModel();
        $this->unidades = new UnidadesModel();
        $this->marcas = new MarcasModel();
        $this->sabores = new SaboresModel();
        $this->presentaciones = new PresentacionesModel();
        $this->imagenesPresentaciones = new ImagenesPresentacionesModel();
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
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'caracteristicas' => $this->request->getPost('caracteristicas'),
            'id_marca' => $this->request->getPost('marca'),
            'id_categoria' => $this->request->getPost('categoria'),
        ];
        $insertedID = $this->productos->insert($data);
        $presentaciones = $this->request->getPost('presentaciones');
        foreach ($presentaciones as $index => $presentacion) {
            $data = [
                'id_producto' => $insertedID,
                'id_sabor' => $presentacion['sabor'],
                'id_unidad' => $presentacion['unidad'],
                'stock' => $presentacion['stock'],
                'precio_compra' => $presentacion['precio_compra'],
                'precio_venta' => $presentacion['precio_venta'],
                'contenido' => $presentacion['tamanio'],
            ];
            $idPresentacion = $this->presentaciones->insert($data);
            if ($this->request->getFiles()) {
                $imagenes = $this->request->getFiles()['imagenes'][$index];
                foreach ($imagenes as $imagen) {
                    $nombreImagen = $imagen->getRandomName();
                    $imagen->move(ROOTPATH . 'assets/uploads', $nombreImagen);
                    $data = [
                        'id_presentacion' => $idPresentacion,
                        'nombre_imagenes' => $nombreImagen
                    ];
                    $this->imagenesPresentaciones->insert($data);
                }
            }
        }
        return $this->response->setJSON(['status' => 'success', 'message' => 'Producto Agregado Correctamente', 'redirect' => base_url('dashboard/productos')]);
    }
    public function listarProductos()
    {
        $perPage = $this->request->getGet('perPage') ?? 10;
        $page = $this->request->getGet('page') ?? 1;
        $search = $this->request->getGet('search') ?? '';
        $items = $this->productos->filtrarProductos($search, $perPage, $page);
        $totalProductos = $this->productos->where('activo', 1)->countAllResults(false);
        return $this->response->setJSON([
            'items' => $items,
            'pagination' => [
                'total' => $totalProductos,
                'perPage' => $perPage,
                'page' => (int) $page,
                'totalPages' => ceil($totalProductos / $perPage),
            ]
        ]);
    }
    public function activarProducto($id)
    {
        $data['activo'] = 1;
        $this->productos->actualizarProducto($id, $data);
        return redirect()->to('dashboard/productos')->with('success', "Producto Activado Correctamente");
    }
    public function eliminarProducto()
    {
        $dataRequest = $this->request->getRawInput();
        $idProducto = $dataRequest['id'];
        $data['activo'] = 0;
        if ($this->productos->actualizarProducto($idProducto, $data)) {
            $presentaciones = $this->presentaciones->where('id_producto', $idProducto)->findAll();
            foreach ($presentaciones as $presentacion) {
                $this->presentaciones->update($presentacion['id'], $data);
            }
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
        $sabores = $this->sabores->obtenerSaboresActivos();
        if (isset($id)) {
            $producto = $this->productos->obtenerProductoPorID($id);
            return [
                'validacion' => $this->validator,
                'titulo' => $titulo,
                'categorias' => $categorias,
                'unidades' => $unidades,
                'marcas' => $marcas,
                'producto' => $producto,
                'sabores' => $sabores
            ];
        } else {
            return [
                'validacion' => $this->validator,
                'titulo' => $titulo,
                'categorias' => $categorias,
                'unidades' => $unidades,
                'marcas' => $marcas,
                'sabores' => $sabores
            ];
        }
    }
}
