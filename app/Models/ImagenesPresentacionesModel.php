<?php

namespace App\Models;

use CodeIgniter\Model;

class ImagenesPresentacionesModel extends Model
{
    protected $table = 'imagenes_presentaciones';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_presentacion', 'nombre', 'nombre_imagen'];

    protected bool $allowEmptyInserts = false;


    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    public function obtenerImagenesPorPresentacion($idPresentacion)
    {
        return $this->select("imagenes_presentaciones.nombre_imagen")->where("imagenes_presentaciones.id_presentacion", $idPresentacion)->findAll();
    }
}
