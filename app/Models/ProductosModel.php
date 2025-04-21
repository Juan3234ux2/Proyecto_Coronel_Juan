<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductosModel extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre', 'id_categoria', 'id_marca', 'activo', 'descripcion', 'caracteristicas'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'fecha_alta';
    protected $updatedField = 'fecha_edit';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    protected function agregarJoins()
    {
        return $this
            ->select('productos.*, 
        MIN(presentaciones.precio_venta) as precio_desde, 
        (SELECT id FROM presentaciones 
         WHERE presentaciones.id_producto = productos.id 
         ORDER BY presentaciones.precio_venta ASC 
         LIMIT 1) as id_presentacion, 
        (SELECT nombre_imagen FROM imagenes_presentaciones 
         WHERE imagenes_presentaciones.id_presentacion = 
             (SELECT id FROM presentaciones 
              WHERE presentaciones.id_producto = productos.id 
              ORDER BY presentaciones.precio_venta ASC 
              LIMIT 1)
         LIMIT 1) as nombre_imagen, 
        categorias.nombre AS nombre_categoria, 
        GROUP_CONCAT(presentaciones.id_sabor) as sabores,
        marcas.nombre AS nombre_marca')
            ->join('presentaciones', 'presentaciones.id_producto = productos.id', 'left')
            ->join('imagenes_presentaciones', 'imagenes_presentaciones.id_presentacion = presentaciones.id', 'left')
            ->join('categorias', 'productos.id_categoria = categorias.id', 'left')
            ->join('marcas', 'productos.id_marca = marcas.id', 'left')
            ->groupBy('productos.id');
    }
    public function filtrarProductos($busqueda, $porPagina, $pagina)
    {
        if (empty($busqueda)) {
            return $this->agregarJoins()->where('productos.activo = 1')->findAll($porPagina, ($pagina - 1) * $porPagina);
        } else {
            return $this
                ->agregarJoins()
                ->like('productos.nombre', $busqueda)
                ->orLike('marcas.nombre', $busqueda)
                ->orLike('categorias.nombre', $busqueda)
                ->where('productos.activo = 1')
                ->findAll($porPagina, ($pagina - 1) * $porPagina);
        }
    }
    public function productosPopulares()
    {
        return $this->select('detalle_pedidos.id_producto, count(detalle_pedidos.id_producto) as cantidad')
            ->join('detalle_pedidos', 'detalle_pedidos.id_producto = productos.id')
            ->groupBy('detalle_pedidos.id_producto')
            ->orderBy('cantidad', 'DESC')
            ->findAll();
    }
    public function productosRelacionados($idCategoria)
    {
        return $this->agregarJoins()
            ->where('productos.id_categoria', $idCategoria, )->limit(6)->findAll();
    }
    public function actualizarProducto($id, $data)
    {
        return $this->update($id, $data);
    }
    public function obtenerProductosInactivos()
    {
        return $this
            ->agregarJoins()
            ->where('productos.activo = 0')
            ->findAll();
    }
    public function obtenerProductosPorMarca($marca)
    {
        return $this->where('marca', $marca)->findAll();
    }
    public function obtenerProductosClientes($orden = null, $precioDesde = 0, $precioHasta = null, $sabores = null, $categoria = null)
    {
        $productos = $this->agregarJoins();
        if (isset($sabores) && is_array($sabores) && count($sabores) > 0) {
            $productos = $productos->whereIn("presentaciones.id_sabor", $sabores);
        }
        if (isset($categoria) && is_array($categoria) && count($categoria) > 0) {
            $productos = $productos->whereIn('productos.id_categoria', $categoria);
        }
        if (isset($orden)) {
            switch ($orden) {
                case 'price-ascending':
                    $productos = $productos->orderBy('precio_desde', 'ASC');
                    break;
                case 'price-descending':
                    $productos = $productos->orderBy('precio_desde', 'DESC');
                    break;
                case 'name-ascending':
                    $productos = $productos->orderBy('productos.nombre', 'ASC');
                    break;
                case 'name-descending':
                    $productos = $productos->orderBy('productos.nombre', 'DESC');
                    break;
            }
        } else {
            $productos = $productos->orderBy('productos.nombre', 'ASC');
        }
        $productos = $productos->where('presentaciones.precio_venta >=', (string) $precioDesde);
        if (isset($precioHasta)) {
            $productos = $productos->where('presentaciones.precio_venta <=', (string) $precioHasta);
        }
        return $productos->findAll();
    }
    public function obtenerProductoPorID($id)
    {
        return $this->select('productos.*, 
          categorias.nombre AS nombre_categoria, 
          marcas.nombre AS nombre_marca')
            ->join('categorias', 'productos.id_categoria = categorias.id', 'left')
            ->join('marcas', 'productos.id_marca = marcas.id', 'left')
            ->find($id);
    }
}
