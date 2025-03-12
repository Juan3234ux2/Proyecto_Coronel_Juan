<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCart" aria-labelledby="offcanvasCartLabel">
    <div class="offcanvas-header text-black align-items-center d-flex py-3" style="z-index:999">
        <h5 class="offcanvas-title fw-bold" id="offcanvasCartLabel">Carrito</h5>
        <button type="button" class="btn-close text-black" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-flex gap-2 flex-column position-relative" id="carrito" style="min-height: 100%;">
        <div class="estado"></div>
        <?php if (isset($carrito) && count($carrito) > 0): ?>
            <div class="lista-productos px-0">
                <?php foreach ($carrito as $item): ?>
                    <?php foreach ($productosCarrito as $producto) {
                        if ($producto['id'] == $item['producto_id']) {
                            $nombre = devolverNombreProducto($producto) ?>
                            <!--Contenedor Producto-->
                            <div class="contenedor-producto">
                                <!--Contenedor de imagen, nombre y cantidad-->
                                <div class="d-flex">
                                    <img style="width: 95px;" src="<?php echo base_url('assets/uploads/') . $producto['imagen']; ?>"
                                        alt="Imagen del Producto">
                                    <div class="d-flex flex-column justify-content-between">
                                        <h2 class="mt-2 fw-bold text-black" style="font-size: .8rem;"><?php echo $nombre ?></h2>
                                        <div class="cantidad d-flex mb-2">
                                            <button class="btn-cantidad mx-0" onclick="cartFunctions.actualizarCantidad(this, -1)"
                                                data-id="<?php echo $producto['id']; ?>"><i class="bi bi-dash"></i></button>
                                            <input disabled style="background-color: white;" class="mx-0 input-cantidad"
                                                id="input-producto-<?php echo $producto['id']; ?>" type="number"
                                                value="<?php echo $item['cantidad'] ?>">
                                            <button class="btn-cantidad mx-0" onclick="cartFunctions.actualizarCantidad(this, 1)"
                                                data-id="<?php echo $producto['id']; ?>"><i class="bi bi-plus"></i></button>
                                        </div>
                                    </div>
                                    <button onclick="cartFunctions.eliminarProducto('<?php echo $producto['id']; ?>')"
                                        class="position-absolute bg-white" style="right: 0; top:5px; cursor:pointer;"><i
                                            class="bi bi-x-lg"></i></button>
                                </div>
                                <!--Precio del producto-->
                                <div class="align-self-end fw-bold text-black" style="font-size:1rem"><span
                                        data-precio="<?php echo $producto['precio_venta']; ?>" class="precio-producto">$
                                        <?php echo number_format($producto['precio_venta'] * $item['cantidad'], 2, ',', '.') ?></span>
                                </div>
                            </div>
                        <?php } ?>

                    <?php }
                endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center d-flex flex-column my-auto h-100">
                <span data-icon="tabler:shopping-cart"
                    class="iconify position-relative mx-auto text-black fs-1 d-block mt-4 mb-3"></span>
                <span class="fw-semibold text-medium">El carrito está vacío</span>
                <a class="login-text mt-4 mx-auto" href=" <?php echo base_url('colecciones/todos-los-productos') ?>">Seguir
                    comprando</a>
            </div>
        <?php endif; ?>
        <div class="h-100 mb-4 d-flex align-items-end position-sticky" style="bottom: 18px;">
            <div class="bg-white w-100 pb-2 mx-auto mb-4">
                <div class="d-flex justify-content-between text-black align-items-center">
                    <span class="fs-6">Total:</span>
                    <span class="fs-4 fw-bold" id="precio-total">$ 0</span>
                </div>
                <a href="<?php echo base_url('confirmar-pedido'); ?>"
                    class="text-center d-inline-block btn-enviar-datos w-100 my-1">Comprar</a>
            </div>
        </div>
    </div>
</div>