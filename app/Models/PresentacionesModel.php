<?php

namespace App\Models;

use CodeIgniter\Model;

class PresentacionesModel extends Model
{
    protected $table = 'presentaciones';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_sabor', 'id_producto', 'stock', 'precio_compra', 'precio_venta', 'id_unidad', 'contenido', 'activo', 'imagenes'];

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

    public function obtenerPresentaciones($idProducto)
    {
        return $this->select("presentaciones.*, 
                      sabores.nombre AS nombre_sabor, 
                      unidades.nombre_corto AS nombre_unidad, 
                      GROUP_CONCAT(imagenes_presentaciones.nombre_imagen) as imagenes")
            ->where("presentaciones.id_producto", $idProducto)
            ->join("imagenes_presentaciones", "presentaciones.id = imagenes_presentaciones.id_presentacion", "left")
            ->join("sabores", "presentaciones.id_sabor = sabores.id", "left")
            ->join("unidades", "presentaciones.id_unidad = unidades.id", "left")
            ->groupBy("presentaciones.id")
            ->findAll();
    }
    public function obtenerPresentacion($idPresentacion)
    {
        return $this->select("presentaciones.*, 
                      productos.nombre AS nombre_producto,
                      productos.descripcion,
                      productos.caracteristicas,
                      productos.id_categoria,
                      categorias.nombre AS nombre_categoria,
                      marcas.nombre AS nombre_marca,
                      sabores.nombre AS nombre_sabor, 
                      unidades.nombre_corto AS nombre_unidad, 
                      GROUP_CONCAT(imagenes_presentaciones.nombre_imagen) as imagenes")
            ->join("imagenes_presentaciones", "presentaciones.id = imagenes_presentaciones.id_presentacion", "left")
            ->join("productos", "presentaciones.id_producto = productos.id", "left")
            ->join("categorias", "productos.id_categoria = categorias.id", "left")
            ->join("marcas", "productos.id_marca = marcas.id", "left")
            ->join("sabores", "presentaciones.id_sabor = sabores.id", "left")
            ->join("unidades", "presentaciones.id_unidad = unidades.id", "left")
            ->groupBy("presentaciones.id")
            ->find($idPresentacion);
    }
    public function obtenerPresentacionesPorSabor($idSabor, $idProducto)
    {
        return $this->select("presentaciones.*, 
                      unidades.nombre_corto AS nombre_unidad, 
                      imagenes_presentaciones.nombre_imagen as imagen")
            ->join("imagenes_presentaciones", "presentaciones.id = imagenes_presentaciones.id_presentacion", "left")
            ->join("unidades", "presentaciones.id_unidad = unidades.id", "left")
            ->where("presentaciones.id_sabor", $idSabor)
            ->where("presentaciones.id_producto", $idProducto)
            ->groupBy("presentaciones.id")
            ->findAll();
    }
}
