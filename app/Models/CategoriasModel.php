<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriasModel extends Model
{
    protected $table = 'categorias';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre', 'activo'];

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
    public function cantidadProductosAsociados($idCategoria)
    {
        return $productos = $this->db->table('productos')
            ->where('id_categoria', $idCategoria)
            ->where('activo', 1)
            ->countAllResults();
    }
    public function obtenerCategoriasActivas()
    {
        return $this->where('activo', 1)->findAll();
    }
    public function obtenerCategoriaPorId($id)
    {
        return $this->find($id);
    }
    public function actualizarCategoria($id, $data)
    {
        return $this->update($id, $data);
    }
    public function obtenerCategoriasInactivas()
    {
        return $this->where('activo', 0)->findAll();
    }
}
