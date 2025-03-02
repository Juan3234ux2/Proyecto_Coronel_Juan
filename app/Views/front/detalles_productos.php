<section class="container-xl" style="margin-top: 180px;">
    <div class="row">
        <!--Imagen del producto-->
        <div class="col-12 col-lg-6">
            <section class="splide detalle-productos" id="main-carousel-product">
                <div class="splide__track">
                    <ul class="splide__list">
                        <li class="splide__slide">
                            <a data-fslightbox
                                href="<?php echo base_url('assets/uploads/1715796692_162fe85c4818153c2043.webp'); ?>">
                                <img src="<?php echo base_url('assets/uploads/1715796692_162fe85c4818153c2043.webp'); ?>"
                                    alt="imagen producto">
                            </a>
                        </li>
                        <li class="splide__slide">
                            <a data-fslightbox href="<?php echo base_url('assets/uploads/' . $producto['imagen']); ?>">
                                <img src="<?php echo base_url('assets/uploads/' . $producto['imagen']); ?>"
                                    alt="imagen producto">
                            </a>
                        </li>
                        <li class="splide__slide">
                            <a data-fslightbox href="<?php echo base_url('assets/uploads/' . $producto['imagen']); ?>">
                                <img src="<?php echo base_url('assets/uploads/' . $producto['imagen']); ?>"
                                    alt="imagen producto">
                            </a>
                        </li>
                    </ul>
                </div>
            </section>
            <section id="carousel-product" class="splide detalle-productos">
                <div class="splide__track">
                    <ul class="splide__list">
                        <li class="splide__slide">
                            <img src="<?php echo base_url('assets/uploads/1715796692_162fe85c4818153c2043.webp'); ?>"
                                alt="imagen producto">
                        </li>
                        <li class="splide__slide">
                            <img src="<?php echo base_url('assets/uploads/' . $producto['imagen']); ?>"
                                alt="imagen producto">
                        </li>
                        <li class="splide__slide">
                            <img src="<?php echo base_url('assets/uploads/' . $producto['imagen']); ?>"
                                alt="imagen producto">
                        </li>
                    </ul>
                </div>
            </section>
        </div>
        <!--Descripcion del producto-->
        <div class="col-12 col-lg-6">
            <div class="mx-4 mt-3">
                <!--Titulo del producto-->
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class=" my-3" style="font-size:2.4rem; font-weight: 800"><?php echo $nombreProducto; ?></h3>
                </div>
                <div class="mt-4">
                    <ul class="px-3 mb-4" style="font-size:13px; line-height: 22px;">
                        <li class="py-1 fw-bolder"><?php echo $producto['nombre_categoria']; ?> de maxima pureza.</li>
                        <li class="py-1 fw-bolder">Contenido:
                            <?php echo $producto['contenido'] . ' ' . $producto['nombre_unidad']; ?>
                        </li>
                        <li class="py-1 fw-bolder">Marca: <?php echo $producto['nombre_marca']; ?> </li>
                        <li class="py-1 fw-bolder">Mejora el rendimiento físico.</li>
                    </ul>
                    <div class="d-flex flex-column gap-2">
                        <form action="<?php echo base_url('productos/agregarcarrito'); ?>" method="post">
                            <span class="fw-semibold my-1" style="font-size: 14px; color:rgb(95, 95, 95);">Sabor:
                                <span id="sabor-producto" class="text-black">Banana</span>
                            </span>
                            <select onchange="cambiarSabor(this)" id="sabor" class="w-100 mt-2 mb-3" name="sabor"
                                style="padding: 13px; border-radius: 6px;">
                                <option value="Banana" selected>Banana</option>
                                <option value="Manzana">Manzana</option>
                                <option value="Chocolate">Chocolate</option>
                            </select>
                            <div class="mb-3">
                                <span class="fw-semibold" style="font-size: 14px; color:rgb(95, 95, 95);">Tamaño: <span
                                        id="sabor-producto" class="text-black">
                                        1 Lb (453 Gr) 14 Servicios</span>
                                </span>
                                <div class="d-flex gap-2 mt-2">
                                    <?php for ($i = 0; $i < 3; $i++) { ?>
                                        <img width="70px"
                                            style="border: <?php echo ($i == 0) ?
                                                '2px solid rgb(43, 43, 43)' : '1px solid #d3d3d3'; ?>; border-radius: 6px; cursor: pointer;"
                                            src="<?php echo base_url('assets/uploads/' . $producto['imagen']); ?>" alt="">
                                    <?php } ?>
                                </div>
                            </div>
                            <span class="fw-semibold" style="font-size: 14px; color:rgb(95, 95, 95);">Cantidad:
                            </span>
                            <div class="d-flex cantidad mt-2">
                                <input type="hidden" name="id" value="<?php echo $producto['id'] ?>">
                                <button type="button" id="btn-disminuir-cantidad" class="btn-cantidad mx-0 px-0"><i
                                        class="bi bi-dash"></i></button>
                                <input class="mx-0 input-cantidad-detalles" type="number" name="cantidad" value="1"
                                    id="cantidad-producto">
                                <button type="button" id="btn-aumentar-cantidad" class="btn-cantidad mx-0 px-0"><i
                                        class="bi bi-plus"></i></button>
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
                            <button type="submit" id="agregar-producto" class="btn-enviar-datos w-100 mt-4">Agregar al
                                carrito</button>
                        <?php } ?>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5">
        <h2 class="fs-1 fw-bolder mb-4 mb-md-5">Descripción</h2>
        <span class="fw-bold d-block mb-4">
            TRUEMADE - WHEY PROTEIN
        </span>
        <p class="text-black fw-semibold" style="font-size: 14px;">
            Whey Protein Isolate (WPI) es la forma más pura de proteína de suero que existe actualmente. Al sumarla a
            nuestra fórmula clásica (WPC + WPI) elevamos el estándar de calidad, asegurándote un mejor producto en cada
            scoop para que logres la performance que buscas.
            <br><br>
            TRUEMADE contiene un blend de máxima pureza con una rápida absorción y una excelente calidad, garantizando
            una
            efectiva y rápida recuperación del tejido muscular:
            <br><br>
            - Whey protein concentrate (WPC): perfil completo de aminoácidos esenciales, brindando la mejor calidad de
            proteínas para aumentar la energía durante el entrenamiento.
            <br><br>
            - Whey Protein Isolate (WPI): máxima pureza. Bajo en carbohidratos, grasas y fácil de digerir logrando una
            mayor
            absorción de la proteína.
        </p>
    </div>
    <div class="mt-5">
        <h2 class="fs-1 fw-bolder mb-5 pt-3" data-aos="fade-up" data-aos-duration="600" data-aos-once="true">Productos
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
                    foreach ($productosCarrito as $index => $producto) {
                        $nombre = devolverNombreProducto($producto);
                        $url = strtolower(str_replace(" ", "-", $nombre . ' ' . $producto['id']));
                        ?>

                        <li class=" splide__slide bg-white" data-aos="fade-in-up" style="border-radius: 10px;">
                            <a class="h-100 position-relative" href="<?php echo base_url('productos/' . $url) ?>"
                                style="color:inherit; text-decoration:none;">
                                <img src=" <?php echo base_url('assets/uploads/' . $producto['imagen']); ?> "
                                    class="card-img-top mt-3" alt="...">
                                <div class="card-body py-4 mb-3 px-3">
                                    <p class="text-start fw-bold pb-2" style="font-size: 14px"><?php echo $nombre ?></p>
                                    <span class="fw-semibold fs-6 position-absolute"
                                        style="bottom:15px; color:rgb(53, 53, 53)">$<?php echo $producto['precio_venta']; ?></span>
                                </div>
                            </a>
                        </li>
                        <?php
                        if ($index > 6) {
                            break;
                        }
                    }
                    ?>
                </ul>
            </div>
        </section>
    </div>
</section>