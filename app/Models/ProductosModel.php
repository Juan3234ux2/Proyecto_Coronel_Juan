<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductosModel extends Model
{
    protected $table      = 'productos';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre', 'precio_venta', 'precio_compra', 'stock', 'contenido', 'id_categoria', 'id_unidad', 'id_marca', 'activo', 'imagen'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'fecha_alta';
    protected $updatedField  = 'fecha_edit';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;

    protected function agregarJoins()
    {
        return $this
            ->select('productos.*, 
        CASE WHEN categorias.activo = 0 THEN "No posee" ELSE IFNULL(categorias.nombre, "No posee") END AS nombre_categoria, 
        CASE WHEN marcas.activo = 0 THEN "No posee" ELSE IFNULL(marcas.nombre, "No posee") END AS nombre_marca,
        CASE WHEN unidades.activo = 0 THEN "No posee" ELSE IFNULL(unidades.nombre_corto, "No posee") END AS nombre_unidad,')
            ->join('categorias', 'productos.id_categoria = categorias.id', 'left')
            ->join('marcas', 'productos.id_marca = marcas.id', 'left')
            ->join('unidades', 'productos.id_unidad = unidades.id', 'left');
    }
    public function buscar($busqueda)
    {
        return $this
            ->agregarJoins()
            ->like('productos.nombre', $busqueda)
            ->where('productos.activo = 1')
            ->findAll();
    }
    public function obtenerProductosActivos()
    {
        return $this->where('activo', 1)->findAll();
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
    public function obtenerProductosPorCategoria($idCategoria)
    {
        return $this
            ->agregarJoins()
            ->where('productos.activo = 1')
            ->where('productos.id_categoria', $idCategoria)
            ->findAll();
    }
    public function obtenerProductosPorMarca($marca)
    {
        return $this->where('marca', $marca)->findAll();
    }
    public function obtenerProductosConDetalles()
    {
        return $this
            ->agregarJoins()
            ->where('productos.activo = 1')
            ->findAll();
    }
    public function obtenerProductoPorID($id)
    {
        return $this
            ->agregarJoins()
            ->find($id);
    }
}
