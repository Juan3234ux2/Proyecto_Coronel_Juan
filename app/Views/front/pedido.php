<section class="d-flex flex-column flex-lg-row" id="container-checkout">
    <div class="d-flex justify-content-center justify-content-lg-end px-3 container-info-checkout order-2 order-1">
        <form class="d-flex mx-5 col-12 col-sm-10 col-md-8 col-lg-10 col-xl-8 flex-column gap-3 mt-5" method="post"
            action="<?php echo base_url('realizar-compra'); ?>">
            <h2 class="fs-3 fw-bold">Entrega</h2>
            <div class="position-relative w-100">
                <input class="mx-0 w-100 form-input" id="direccion" name="direccion" placeholder=" ">
                <label class="form-label" for="direccion">Dirección</label>
            </div>
            <div class="position-relative w-100">
                <input class="mx-0 w-100 form-input" id="tipoVivienda" name="tipoVivienda" placeholder=" ">
                <label class="form-label" for="tipoVivienda">Casa, apartamento, etc</label>
            </div>
            <div class="d-flex w-100 d-flex gap-3">
                <div class="position-relative">
                    <input class="mx-0 w-100 form-input" type="number" id="codidoPostal" name="codidoPostal"
                        placeholder=" ">
                    <label class="form-label" for="codidoPostal">Código Postal</label>
                </div>
                <div class="position-relative">
                    <input class="mx-0 w-100 form-input" id="ciudad" name="ciudad" placeholder=" ">
                    <label class="form-label" for="ciudad">Ciudad</label>
                </div>
                <div class="position-relative">
                    <input class="mx-0 w-100 form-input" id="provincia" name="provincia" placeholder=" ">
                    <label class="form-label" for="provincia">Provincia</label>
                </div>
            </div>
            <div class="position-relative">
                <input class="mx-0 w-100 form-input" type="number" id="telefono" name="telefono" placeholder=" ">
                <label class="form-label" for="telefono">Teléfono</label>
            </div>
            <h2 class="fs-3 fw-bold mt-4">Pago</h2>
            <select style="padding: 13px; border-radius: 6px;" name="medio_de_pago">
                <option value="Efectivo">Efectivo</option>
                <option value="Mercado Pago">Mercado Pago</option>
                <option value="Tarjeta Débito/Credito">Tarjeta Débito/Credito</option>
            </select>
            <button type="submit" class="btn-enviar-datos">Comprar</button>
        </form>
    </div>
    <div class="order-1 order-lg-2 container-products-checkout"
        style="background-color: rgb(248, 248, 248); height: 100vh; flex-grow: 1; border-left: 1px solid rgb(210, 210, 210);">
        <div class="d-flex d-lg-none justify-content-between align-items-center p-4"
            style="border-bottom: 1px solid rgb(210, 210, 210); background-color: rgb(242, 242, 242);">
            <button id="btn-resumen" style="font-size: 13px;">Resumen del pedido <i class="iconify"
                    data-icon="material-symbols:keyboard-arrow-down" data-inline="false"></i></button>
            <span class="total fw-bold fs-5 "></span>
        </div>
        <div class="d-none d-lg-block" id="container-products">
            <div class="lista-productos m-4 col-lg-12 col-xl-8 mb-4 px-0 ">
                <?php foreach ($carrito as $item): ?>
                    <?php foreach ($productosCarrito as $producto) {
                        if ($producto['id'] == $item['producto_id']) {
                            $nombre = devolverNombreProducto($producto) ?>

                            <!--Contenedor Producto-->
                            <div class="d-flex justify-content-between mb-3 position-relative">
                                <!--Contenedor de imagen, nombre y cantidad-->
                                <div class="d-flex gap-3">
                                    <img style="width: 70px; border:1px solid rgb(210, 210, 210); border-radius: 6px;"
                                        src="<?php echo base_url('assets/uploads/') . $producto['imagen']; ?>" alt="">
                                    <div class="d-flex flex-column justify-content-between">
                                        <h2 class="mt-2 fw-bold text-black" style="font-size: .8rem;"><?php echo $nombre ?></h2>

                                    </div>
                                </div>
                                <!--Precio del producto-->
                                <span class="align-self-end fw-medium text-black" style="font-size:.9rem">$
                                    <?php echo number_format($producto['precio_venta'] * $item['cantidad'], 2, ',', '.'); ?></span>
                            </div>
                        <?php } ?>

                    <?php }
                endforeach; ?>
            </div>
            <div class="d-flex justify-content-between m-4 col-lg-12 col-xl-8 pt-4 fw-bold fs-5">
                <span>Total</span>
                <span class="total"></span>
            </div>
        </div>
    </div>
</section>
<script>
    const btnResumen = document.getElementById('btn-resumen');
    btnResumen.addEventListener('click', function () {
        const containerProducts = document.getElementById('container-products');
        btnResumen.classList.toggle('active');
        toggleDropdown(containerProducts);
    });
    document.addEventListener('DOMContentLoaded', function () {
        const total = document.querySelectorAll('.total');
        const carrito = document.querySelectorAll('.lista-productos > div > span');
        let precioTotal = 0;
        carrito.forEach(item => {
            precioTotal += parseCurrency(item.innerHTML);
        });
        total.forEach(item => {
            item.innerHTML = formatCurrency(precioTotal);
        })
    })
</script>