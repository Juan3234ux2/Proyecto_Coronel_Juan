<section class="card-dashboard">
    <h1 class="fs-2 fw-bold mt-3 mb-4 px-4">Detalle Pedido #<?php echo $numero_pedido ?></h1>
    <a class="btn-crud mx-4" href="<?php echo base_url('dashboard/pedidos') ?>"><i class="bi bi-arrow-left "></i>
        Regresar</a>
    <table id="tablaDatos" class="table-dashboard">
        <thead>
            <tr>
                <th scope="col">Producto</th>
                <th scope="col">Precio Unitario</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Precio total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($detalles as $producto) { ?>
                <tr id="<?= $producto['id']; ?>">
                    <td><?php echo $producto['nombre_producto']; ?> </td>
                    <td>$ <?php echo number_format($producto['precio_unitario'], 2, ',', '.'); ?> </td>
                    <td><?php echo $producto['cantidad']; ?> </td>
                    <td>$ <?php echo number_format($producto['precio_total'], 2, ',', '.'); ?> </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</section>