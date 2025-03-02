<section style="width: 95%; margin: 0 auto;">
    <form method="post" action="<?php echo base_url('dashboard/productos/insertar'); ?>" enctype="multipart/form-data"
        autocomplete="off">
        <div class="mt-5">
            <div class="d-flex justify-content-between mt-3 ">
                <h1 class="fs-2 fw-bold ">Agregar Producto</h1>
                <div class="d-flex gap-3 mt-3">
                    <a class="btn-crud px-3" href="<?php echo base_url('dashboard/productos'); ?>"
                        style="background-color: transparent; color:rgb(44, 44, 44); border:1px solid rgb(200,200,200); font-size: 12px;">Descartar</a>
                    <button class="btn-crud" style="min-width: fit-content;font-size: 12px;">Agregar producto</button>
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                    <div>
                        <label class="fs-6 fw-semibold mb-2" for="nombre">Nombre</label>
                        <input class="w-100 form-input-dashboard" autocomplete="off" required name="nombre" id="nombre"
                            required type="text" placeholder="Ingresa el nombre del producto">
                        <span style="font-size: .9rem; display:inline-block">
                            <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'nombre') : ' ' ?>
                        </span>
                    </div>
                    <div>
                        <label class="fs-6 fw-semibold mb-2" for="descripcion">Descripción</label>
                        <div id="descripcion-producto"></div>
                    </div>
                    <div class="d-flex gap-4 mt-4">
                        <div class="flex-grow-1">
                            <label class="fs-6 fw-semibold mb-2" for="precio_compra">Precio de Compra</label>
                            <input class="w-100 form-input-dashboard" autocomplete="off" required name="precio_compra"
                                id="precio_compra" required type="text" placeholder="Ingresa el precio de compra">
                            <span style="font-size: .9rem; display:inline-block">
                                <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'precio_compra') : ' ' ?>
                            </span>
                        </div>
                        <div class="flex-grow-1">
                            <label class="fs-6 fw-semibold mb-2" for="precio_venta">Precio de Venta</label>
                            <input class="w-100 form-input-dashboard" autocomplete="off" required name="precio_venta"
                                id="precio_venta" required placeholder="Ingresa el precio de venta">
                            <span style="font-size: .9rem; display:inline-block">
                                <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'precio_venta') : ' ' ?>
                            </span>
                        </div>
                    </div>

                </div>
                <div class="col-4 card-dashboard pt-4 px-4">
                    <div>
                        <label class="fs-6 fw-semibold mb-2" for="marca">Marca</label>
                        <select class="w-100 form-select-dashboard" name="marca" id="marca" required>
                            <?php foreach ($marcas as $marca) { ?>
                                <option value="<?php echo $marca['id']; ?>"><?php echo $marca['nombre']; ?></option>
                            <?php } ?>
                        </select>
                        <span style="font-size: .9rem; display:inline-block">
                            <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'marca') : ' ' ?>
                        </span>
                    </div>
                    <div>
                        <label class="fs-6 fw-semibold mb-2" for="categoria">Categoria</label>
                        <select class="w-100 form-select-dashboard" name="categoria" id="categoria" required>
                            <?php foreach ($categorias as $categoria) { ?>
                                <option value="<?php echo $categoria['id']; ?>"><?php echo $categoria['nombre']; ?></option>
                            <?php } ?>
                        </select>
                        <span style="font-size: .9rem; display:inline-block">
                            <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'categoria') : ' ' ?>
                        </span>
                    </div>

                </div>
            </div>

        </div>
    </form>
</section>