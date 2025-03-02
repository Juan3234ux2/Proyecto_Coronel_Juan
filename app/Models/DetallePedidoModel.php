<?php

namespace App\Models;

use CodeIgniter\Model;

class DetallePedidoModel extends Model
{
    protected $table      = 'detalle_pedidos';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_producto', 'id_pedido', 'precio_unitario', 'cantidad', 'precio_total'];

    protected bool $allowEmptyInserts = false;

    public function obtenerDetallesPedido($idPedido)
    {
        return $this->select('detalle_pedidos.*, productos.nombre AS nombre_producto')
            ->join('productos', 'productos.id = detalle_pedidos.id_producto')
            ->where('id_pedido', $idPedido)
            ->findAll();
    }
}
