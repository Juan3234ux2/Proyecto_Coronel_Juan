<?php
$url = strtolower(str_replace(" ", "-", $nombreProducto . '?variant='))
    ?>
<script>
    const cambiarSabor = async (select) => {
        if (!select) return;
        const response = await fetch(`<?php echo base_url('productos/cambiar-sabor?sabor='); ?>${select.value}&producto=<?php echo $producto['id_producto'] ?>`)
        const data = await response.json()
        window.location = `<?php echo base_url('productos/' . $url); ?>${data.id}`;
    }
</script>
<section class="container-xl" style="margin-top: 130px;">
    <div class="row">
        <!--Imagen del producto-->
        <div class="col-12 col-lg-6">
            <section class="splide detalle-productos" id="main-carousel-product">
                <div class="splide__track">
                    <ul class="splide__list">
                        <?php foreach ($producto['imagenes'] as $imagen) { ?>
                            <li class="splide__slide">
                                <a data-fslightbox href="<?php echo base_url('assets/uploads/' . $imagen); ?>">
                                    <img src="<?php echo base_url('assets/uploads/' . $imagen); ?>" alt="imagen producto">
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </section>
            <section id="carousel-product" class="splide detalle-productos">
                <div class="splide__track">
                    <ul class="splide__list">
                        <?php foreach ($producto['imagenes'] as $imagen) { ?>
                            <li class="splide__slide">
                                <img src="<?php echo base_url('assets/uploads/' . $imagen); ?>" alt="imagen producto">
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </section>
        </div>
        <!--Descripcion del producto-->
        <div class="col-12 col-lg-6">
            <div class="mx-4 mt-5">
                <!--Titulo del producto-->
                <h3 class="mb-3" style="font-size:2.4rem; font-weight: 800"><?php echo $nombreProducto; ?></h3>
                <div class="mt-4">
                    <ul class="px-3 mb-4 d-flex flex-column fw-bold" style="font-size:13px; gap: 1px;">
                        <?php foreach ($producto['caracteristicas'] as $caracteristica) { ?>
                            <li><?php echo $caracteristica ?></li>
                        <?php } ?>
                    </ul>
                    <div class="d-flex flex-column gap-2">
                        <form action="<?php echo base_url('productos/agregarcarrito'); ?>" method="post">
                            <span class="fw-semibold my-1" style="font-size: 14px; color:rgb(95, 95, 95);">Sabor:
                                <span id="sabor-producto"
                                    class="text-black"><?php echo $producto['nombre_sabor']; ?></span>
                            </span>
                            <select onchange="cambiarSabor(this)" id="sabor" class="w-100 mt-2 mb-3" name="sabor"
                                style="padding: 13px; border-radius: 6px;">
                                <?php foreach ($sabores as $sabor) { ?>
                                    <option <?php echo ($sabor['id'] == $producto['id_sabor']) ? 'selected' : ''; ?>
                                        value="<?php echo $sabor['id']; ?>"><?php echo $sabor['nombre']; ?></option>
                                <?php } ?>
                            </select>
                            <div class="mb-3">
                                <span class="fw-semibold" style="font-size: 14px; color:rgb(95, 95, 95);">Tamaño: <span
                                        id="sabor-producto" class="text-black">
                                        <?php echo $producto['contenido'] . ' ' . $producto['nombre_unidad'] ?></span>
                                </span>
                                <div class="d-flex gap-2 mt-2">
                                    <?php foreach ($tamanios as $tamanio) {
                                        $urlTamanio = $url . $tamanio['id']
                                            ?>
                                        <a href="<?php echo base_url('productos/' . $urlTamanio); ?>"><img width="70px"
                                                style="border: <?php echo ($tamanio['id'] == $producto['id']) ?
                                                    '2px solid rgb(43, 43, 43)' : '1px solid #d3d3d3'; ?>; border-radius: 6px; cursor: pointer;"
                                                src="<?php echo base_url('assets/uploads/' . $tamanio['imagen']); ?>"
                                                alt="imagen producto"></a>
                                    <?php } ?>
                                </div>
                            </div>
                            <span class="fw-semibold" style="font-size: 14px; color:rgb(95, 95, 95);">Cantidad:
                            </span>
                            <div class="d-flex cantidad mt-2">
                                <input type="hidden" name="id" value="<?php echo $producto['id'] ?>">
                                <button type="button" onclick="cartFunctions.disminuirCantidad()"
                                    class="btn-cantidad mx-0 px-0"><i class="bi bi-dash"></i></button>
                                <input class="mx-0 input-cantidad" type="number" name="cantidad" value="1"
                                    id="cantidad-producto">
                                <button type="button" onclick="cartFunctions.aumentarCantidad()"
                                    class="btn-cantidad mx-0 px-0"><i class="bi bi-plus"></i></button>
                            </div>
                    </div>
                    <div class="mt-2">
                        <?php if (!empty(session()->getFlashdata('error'))) { ?>
                            <span class="mensaje-error mensaje mb-1">
                                <?= session()->getFlashdata('error'); ?>
                            </span>
                        <?php } else { ?>
                            <span style="height: 48px; visibility:hidden" class="d-block">
                                .
                            </span>
                        <?php } ?>
                        <span
                            class="fw-bolder fs-3 ">$<?php echo number_format($producto['precio_venta'], 2, ',', '.') ?></span>
                        <?php if ($producto['stock'] == 0) { ?>
                            <button disabled id="agregar-producto" style="background-color: rgb(228, 206, 8);"
                                class="btn-enviar-datos w-100 mt-4">Agotado</button>
                        <?php } else { ?>
                            <button type="submit" class="btn-enviar-datos w-100 mt-4">Agregar al
                                carrito</button>
                        <?php } ?>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5">
        <h2 class="fs-1 fw-bolder mb-1 mb-md-3">Descripción</h2>
        <div class="caracteristicas-producto">
            <?php echo $producto['descripcion']; ?>
        </div>
    </div>
    <?php
    if (count($productosRelacionados) > 1) { ?>
        <div class="mt-5">
            <h2 class="fs-1 fw-bolder mb-5 pt-3" data-aos="fade-up" data-aos-duration="600" data-aos-once="true">
                Productos
                Relacionados</h2>
            <section class="splide pt-3">
                <div class="splide__arrows">
                    <button class="splide__arrow splide__arrow--prev">
                        <span class="iconify icon" data-icon="tabler:arrow-right" data-inline="false"></span>
                    </button>
                    <button class="splide__arrow splide__arrow--next">
                        <span class="iconify icon" data-icon="tabler:arrow-right" data-inline="false"></span>
                    </button>
                </div>
                <div class="splide__track">
                    <ul class="splide__list">
                        <?php
                        foreach ($productosRelacionados as $productoRelacionado) {
                            if ($productoRelacionado['id'] == $producto['id'])
                                continue;
                            $nombre = devolverNombreProducto($productoRelacionado);
                            $url = strtolower(str_replace(" ", "-", $nombre . '?variant=' . $productoRelacionado['id_presentacion']));
                            ?>

                            <li class=" splide__slide bg-white" data-aos="fade-in-up" style="border-radius: 10px;">
                                <a class="h-100 position-relative" href="<?php echo base_url('productos/' . $url) ?>"
                                    style="color:inherit; text-decoration:none;">
                                    <img src=" <?php echo base_url('assets/uploads/' . $productoRelacionado['nombre_imagen']); ?> "
                                        class="card-img-top mt-3" alt="...">
                                    <div class="card-body py-4 mb-3 px-3">
                                        <p class="text-start fw-bold pb-2" style="font-size: 14px"><?php echo $nombre ?></p>
                                        <span class="fw-semibold fs-6 position-absolute"
                                            style="bottom:15px; color:rgb(53, 53, 53)">Desde
                                            $
                                            <?php
                                            echo number_format($produproductoRelacionadocto['precio_desde'], 2, ',', '.') ?>
                                        </span>
                                    </div>
                                </a>
                            </li>
                            <?php

                        }

                        ?>
                    </ul>
                </div> <?php }

    ?>
        </section>
    </div>
</section>