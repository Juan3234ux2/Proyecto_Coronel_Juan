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
    public function index()
    {
        $orden = $this->request->getGet('orden') ?? null;
        $precioDesde = $this->request->getGet('precio_min') ?? null;
        $precioHasta = $this->request->getGet('precio_max') ?? null;
        $sabores = $this->request->getGet('sabores') ?? null;
        $categorias = $this->request->getGet('categorias') ?? null;
        $data = [
            'titulo' => 'Productos',
            'productos' => $this->productos->obtenerProductosClientes($orden)
        ];
        if (!$this->request->isAJAX()) {
            $this->cargarVista('productos', $data);
            return;
        }
        return $this->response->setJSON($data);
    }
    public function verProducto()
    {
        $id = $this->request->getGet("variant");
        $presentacion = $this->presentaciones->obtenerPresentacion($id);
        $presentacion["imagenes"] = explode(",", $presentacion["imagenes"]);
        $parrafos = explode('</p>', $presentacion['caracteristicas']);
        $presentacion['caracteristicas'] = array_filter($parrafos);
        $nombreProducto = $presentacion['nombre_producto'] . ' ' . $presentacion['nombre_marca'];
        $data = [
            'titulo' => $nombreProducto,
            'producto' => $presentacion,
            'nombreProducto' => $nombreProducto,
            'sabores' => $this->sabores->obtenerSaboresPorProducto($presentacion['id_producto']),
            'tamanios' => $this->presentaciones->obtenerPresentacionesPorSabor($presentacion['id_sabor'], $presentacion['id_producto']),
            'productosRelacionados' => $this->productos->productosRelacionados($presentacion['id_categoria']) ?? [],
        ];
        $this->cargarVista('detalles_productos', $data);
    }
    public function cambiarSabor()
    {
        $id = $this->request->getGet('sabor');
        $idProducto = $this->request->getGet('producto');
        $presentacion = $this->presentaciones->obtenerPresentacionesPorSabor($id, $idProducto)[0];
        return $this->response->setJSON(['id' => $presentacion['id']]);
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
        $data = [
            'titulo' => 'Productos',
        ];
        $this->cargarVistaAdmin('productos/listado_productos', $data);
    }
    public function listadoPresentaciones($idProducto)
    {
        $presentaciones = $this->presentaciones->obtenerPresentaciones($idProducto);
        $data = [
            'titulo' => 'Productos',
            'presentaciones' => $presentaciones,
            'producto' => $this->productos->obtenerProductoPorID($idProducto)
        ];
        $this->cargarVistaAdmin('productos/listado_presentaciones', $data);
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
                $imagenes = $this->request->getFiles()['presentaciones'][$index]['imagenes'];
                foreach ($imagenes as $imagen) {
                    $nombreImagen = $imagen->getRandomName();
                    $imagen->move(ROOTPATH . 'assets/uploads', $nombreImagen);
                    $data = [
                        'id_presentacion' => $idPresentacion,
                        'nombre_imagen' => $nombreImagen
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
        $idProducto = $this->request->getPost('id');
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'caracteristicas' => $this->request->getPost('caracteristicas'),
            'id_marca' => $this->request->getPost('marca'),
            'id_categoria' => $this->request->getPost('categoria'),
        ];
        $this->productos->actualizarProducto($idProducto, $data);
        $presentaciones = $this->request->getPost('presentaciones');
        foreach ($presentaciones as $index => $presentacion) {
            $data = [
                'id_sabor' => $presentacion['sabor'],
                'id_unidad' => $presentacion['unidad'],
                'stock' => $presentacion['stock'],
                'precio_compra' => $presentacion['precio_compra'],
                'precio_venta' => $presentacion['precio_venta'],
                'contenido' => $presentacion['tamanio'],
            ];
            $this->presentaciones->update($presentacion['index'], ($data));
            if ($this->request->getFiles()) {
                $imagenes = $this->request->getFiles()['presentaciones'][$index]['imagenes'];
                foreach ($imagenes as $imagen) {
                    $nombreImagen = $imagen->getRandomName();
                    $imagen->move(ROOTPATH . 'assets/uploads', $nombreImagen);
                    $data = [
                        'id_presentacion' => $presentacion['index'],
                        'nombre_imagen' => $nombreImagen
                    ];
                    $this->imagenesPresentaciones->insert($data);
                }
            }
        }
        return $this->response->setJSON(['status' => 'success', 'message' => 'Producto Agregado Correctamente', 'redirect' => base_url('dashboard/productos')]);
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
            $producto['presentaciones'] = $this->presentaciones->obtenerPresentaciones($id);
            foreach ($producto['presentaciones'] as $index => $presentacion) {
                $producto['presentaciones'][$index]['imagenes'] = explode(",", $presentacion["imagenes"]);
            }
            return [
                'validacion' => $this->validator,
                'titulo' => $titulo,
                'categorias' => $categorias,
                'unidades' => $unidades,
                'marcas' => $marcas,
                'producto' => $producto,
                'sabores' => $sabores,
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
