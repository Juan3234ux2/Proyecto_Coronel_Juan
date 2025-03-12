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

}
