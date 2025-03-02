<?php

namespace App\Models;

use CodeIgniter\Model;

class ConsultasModel extends Model
{
    protected $table      = 'consultas';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre', 'email', 'tipo_consulta', 'mensaje', 'resuelto'];

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
    public function obtenerConsultasSinResponder()
    {
        return $this->where('resuelto', 0)->findAll();
    }
    public function obtenerTodasLasConsultas()
    {
        return $this->findAll();
    }
    public function obtenerConsultaPorID($id)
    {
        return $this->find($id);
    }
    public function actualizarConsultas($id, $data)
    {
        return $this->update($id, $data);
    }
    public function obtenerConsultasRespondidas()
    {
        return $this->where('resueltos', 1)->findAll();
    }
}
