<section class="card-dashboard">
    <h1 class="fs-2 fw-bold mt-3 px-4">Pedidos</h1>
    <table id="tablaDatos" class="table-dashboard">
        <thead>
            <tr>
                <th scope="col">Comprador</th>
                <th scope="col">Precio Total</th>
                <th scope="col">Fecha De Compra</th>
                <th scope="col">Estado</th>
                <th scope="col">Medio de Pago</th>
                <th scope="col" class="text-end">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos as $pedido) { ?>
                <tr id="<?= $pedido['id']; ?>">
                    <td><?php echo $pedido['nombre_usuario']; ?> </td>
                    <td>$ <?php echo number_format($pedido['precio_total'], 2, ',', '.'); ?> </td>
                    <td><?php echo date_format(date_create($pedido['fecha_compra']), 'd-m-Y'); ?>
                    <td><?php echo $pedido['estado']; ?> </td>
                    </td>
                    <td><?php echo $pedido['medio_pago']; ?> </td>
                    <td>
                        <div class="d-flex align-items-center justify-content-end px-1">
                            <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Ver Detalle."
                                class="rounded-btn"
                                href="<?php echo base_url('dashboard/pedidos/detalles/') . $pedido['id']; ?>"><i
                                    class="bi bi-eye"></i></a>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</section>