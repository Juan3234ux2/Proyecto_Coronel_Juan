<section class="container-lg mt-2">
    <form method="post" action="<?php echo base_url('dashboard/productos/actualizar'); ?>" enctype="multipart/form-data" autocomplete="off">
        <h1 class="fs-2 text-center ">Editar Producto</h1>
        <div class="form__container d-flex justify-content-center align-items-center my-4">
            <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
            <div class="form__group col-12 col-sm-10 col-md-8 col-lg-6">
                <?php if (!empty(session()->getFlashdata('fail'))) { ?>
                    <span class="mb-2" style="background-color: rgba(255, 0, 0, 0.2); display:block; padding:12px; color:red; font-weight:500; border-radius:2px">
                        <?= session()->getFlashdata('fail'); ?>
                    </span>
                <?php
                } ?>
                <div class="position-relative" style="flex-grow:1;">
                    <input class="mx-0 w-100 form-input" autocomplete="off" required name="nombre" id="nombre" value="<?php echo $producto['nombre']; ?>" required type="text" placeholder=" ">
                    <label class="form-label" for="nombre">Nombre</label>
                    <span style="font-size: .9rem; display:inline-block">
                        <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'nombre') : ' ' ?>
                    </span>
                </div>
                <div class="position-relative" style="flex-grow:1;">
                    <select class="w-100 select tiene-contenido" name="marca" id="marca">
                        <?php foreach ($marcas as $marca) { ?>
                            <option value="<?php echo $marca['id']; ?>" <?php if ($marca['id'] == $producto['id_marca']) {
                                                                            echo 'selected';
                                                                        } ?>> <?php echo $marca['nombre']; ?> </option>
                        <?php } ?>
                    </select>
                    <label class="form-label" for="marca">Marca</label>
                    <span style="font-size: .9rem; display:inline-block">
                        <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'marca') : ' ' ?>
                    </span>
                </div>
                <div class="position-relative" style="flex-grow:1;">
                    <select class="w-100 select tiene-contenido" name="categoria" id="categoria">
                        <?php foreach ($categorias as $categoria) { ?>
                            <option value="<?php echo $categoria['id']; ?>" <?php if ($categoria['id'] == $producto['id_categoria']) {
                                                                                echo 'selected';
                                                                            } ?>> <?php echo $categoria['nombre']; ?> </option>
                        <?php } ?>
                    </select>
                    <label class=" form-label" for="categoria">Categoria</label>
                    <span style="font-size: .9rem; display:inline-block">
                        <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'categoria') : ' ' ?>
                    </span>
                </div>
                <div class="position-relative" style="flex-grow:1;">
                    <input class="mx-0 w-100 form-input" autocomplete="off" required name="precioCompra" value="<?php echo $producto['precio_compra']; ?>" id="precioCompra" required type="number" placeholder=" ">
                    <label class="form-label" for="precioCompra">Precio Compra</label>
                    <span style="font-size: .9rem; display:inline-block">
                        <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'precioCompra') : ' ' ?>
                    </span>
                </div>
                <div class="position-relative" style="flex-grow:1;">
                    <input class="mx-0 w-100 form-input" autocomplete="off" required name="precioVenta" id="precioVenta" value="<?php echo $producto['precio_venta']; ?>" required type="number" placeholder=" ">
                    <label class="form-label" for="precioVenta">Precio Venta</label>
                    <span style="font-size: .9rem; display:inline-block">
                        <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'precioVenta') : ' ' ?>
                    </span>
                </div>
                <div class="position-relative" style="flex-grow:1;">
                    <input class="mx-0 w-100 form-input" autocomplete="off" value="<?php echo $producto['stock']; ?>" required name="stock" id="stock" required type="number" placeholder=" ">
                    <label class="form-label" for="stock">Stock</label>
                    <span style="font-size: .9rem; display:inline-block">
                        <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'stock') : ' ' ?>
                    </span>
                </div>
                <div class="w-75 d-flex gap-2">
                    <div class="position-relative">
                        <input class="mx-0 form-input" autocomplete="off" required name="contenido" value="<?php echo $producto['contenido']; ?>" id="contenido" required type="number" placeholder=" ">
                        <label class="form-label" for="contenido">Contenido</label>
                        <span style="font-size: .9rem; display:inline-block">
                            <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'contenido') : ' ' ?>
                        </span>
                    </div>
                    <div class="position-relative" style="flex-grow:1;">
                        <select class="w-100 select tiene-contenido" name="unidad" id="unidad">
                            <?php foreach ($unidades as $unidad) { ?>
                                <option value="<?php echo $unidad['id']; ?>" <?php if ($unidad['id'] == $producto['id_unidad']) {
                                                                                    echo 'selected';
                                                                                } ?>> <?php echo $unidad['nombre_corto']; ?> </option>
                            <?php } ?>
                        </select>
                        <label class="form-label" for="unidad">Unidad</label>
                        <span style="font-size: .9rem; display:inline-block">
                            <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'unidad') : ' ' ?>
                        </span>
                    </div>
                </div>
                <div class="select-image d-flex flex-column mb-3">
                    <div id="vista-previa">
                        <img class="w-50" src="<?php echo base_url('assets/uploads/' . $producto['imagen']); ?>" alt="Imagen producto">
                    </div>
                    <input name="imagen" id="imagen" onchange="actualizarImagenProducto(this)" type="file">
                    <label for="imagen" style="top:15px;font-size:16px; font-weight:500"><i class="bi bi-cloud-arrow-up"></i>Seleccionar Imagen</label>
                    <span style="font-size: .9rem; display:inline-block">
                        <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'imagen') : ' ' ?>
                    </span>
                </div>
                <button class="btn-enviar-datos mb-2 text-uppercase w-100">Editar Producto</button>
                <a class="text-black w-100 d-inline-block text-center" href="<?php echo base_url('dashboard/productos'); ?>" style="font-size: 15px; font-weight:500">Regresar</a>
            </div>
        </div>
    </form>
</section>