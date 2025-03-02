<section class="container-lg" style="margin-top: 12rem;margin-bottom: 5rem">
    <div>
        <h1 class="p-2 mb-4 fs-2 text-center" style="font-weight: 600">Detalle Pedido # <?= $nroPedido ?></h1>
        <table class="table">
            <thead>
                <tr class="header-pedido">
                    <th scope="col">Producto</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Precio Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $index => $producto) { ?>
                    <tr class="align-middle">
                        <td class="d-flex nombre-pedido gap-2">
                            <img style="max-width: 140px;" src="<?= base_url('assets/uploads/') . $producto['imagen'] ?> "
                                alt=""><?php ?>
                            <div class="d-flex flex-column gap-1 p-2">
                                <span><?php echo $producto['nombre']; ?> <span class="hidden"> x
                                        <?php echo $detalles[$index]['cantidad']; ?> </span> </span>
                                <span class="hidden fw-bold fs-6">$ <?php echo $detalles[$index]['precio_total']; ?> </span>
                            </div>

                        </td>
                        <td class="fw-medium d-none tablecell"><?php echo $detalles[$index]['cantidad']; ?> </td>
                        <td class="fw-medium d-none tablecell">$ <?php echo $detalles[$index]['precio_total']; ?> </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>