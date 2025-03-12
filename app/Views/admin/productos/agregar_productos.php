<section style="width: 95%; margin: 0 auto;">
    <form id="form-producto" class="mb-2" enctype="multipart/form-data" autocomplete="off">
        <div class="d-flex justify-content-between align-items-center my-4">
            <h1 class="fs-3 fw-bold mb-0">Agregar Producto</h1>
            <a class="btn-crud px-3 mb-0 d-flex align-items-center gap-2"
                href="<?php echo base_url('dashboard/productos'); ?>"
                style="background-color: transparent; color:rgb(44, 44, 44); border:1px solid rgb(200,200,200); font-size: 12px;"><i
                    class="bi bi-arrow-left fs-6"></i> Descartar</a>
        </div>
        <div class="card-dashboard py-3 px-4">
            <h2 class="fw-bold fs-6 d-flex gap-2 mb-3"><i class="bi bi-info-circle" style="color:
                        orange"></i>Información del
                producto</h2>
            <div>
                <label style="font-size: 13px;" class="fw-semibold mb-2" for="nombre">Nombre</label>
                <input class="form-input-dashboard" autocomplete="off" name="nombre" id="nombre" type="text"
                    placeholder="Ingresa el nombre del producto">
                <span style="font-size: .9rem; display:inline-block">
                    <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'nombre') : ' ' ?>
                </span>
            </div>
            <div class="d-flex gap-4">
                <div class="flex-grow-1">
                    <label style="font-size: 13px;" class="fw-semibold mb-2" for="marca">Marca</label>
                    <select class="form-select-dashboard" name="marca" id="marca">
                        <?php if (empty($marcas)) {
                            echo '<option disabled seleted>No hay marcas disponibles.</option>';
                        } else {
                            foreach ($marcas as $marca) { ?>
                                <option value="<?php echo $marca['id']; ?>"><?php echo $marca['nombre']; ?></option>
                            <?php }
                        } ?>
                    </select>
                    <span style="font-size: .9rem; display:inline-block">
                        <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'marca') : ' ' ?>
                    </span>
                </div>
                <div class="flex-grow-1">
                    <label style="font-size: 13px;" class="fw-semibold mb-2" for="categoria">Categoria</label>
                    <select class="form-select-dashboard" name="categoria" id="categoria">
                        <?php if (empty($categorias)) {
                            echo '<option disabled selected>No hay categorias disponibles.</option>';
                        } else {
                            foreach ($categorias as $categoria) { ?>
                                <option value="<?php echo $categoria['id']; ?>"><?php echo $categoria['nombre']; ?></option>
                            <?php }
                        } ?>
                    </select>
                    <span style="font-size: .9rem; display:inline-block">
                        <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'categoria') : ' ' ?>
                    </span>
                </div>
            </div>
            <div class="mb-3">
                <label style="font-size: 13px;" class="fw-semibold mb-2" for="caracteristicas">Características</label>
                <div id="caracteristicas-producto"></div>
            </div>
            <div>
                <label style="font-size: 13px;" class="fw-semibold mb-2" for="descripcion">Descripción</label>
                <div id="descripcion-producto"></div>
            </div>
        </div>
        <div class="card-dashboard py-3 mt-4 px-4">
            <h2 class="fw-bold fs-6 d-flex gap-2 mb-3"><i class="bi bi-life-preserver" style="color:
                        orange"></i>Presentaciones</h2>
            <div id="contenedor-presentaciones" class="d-flex flex-column gap-4"></div>
            <div class="d-flex justify-content-end mt-3">
                <button id="agregar-presentacion" style="background-color: darkgreen;" type="button"
                    class="btn-crud my-0"><i class="bi bi-plus-circle"></i>
                    Agregar
                    Presentacion</button>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-4 gap-3">
            <a href="<?php echo base_url('dashboard/productos'); ?>"
                style="background-color: transparent; color:rgb(44, 44, 44); border: 1px solid rgb(210,210,210)"
                class="btn-crud">
                Cancelar
            </a>
            <button type="submit" id="btn-guardar" class="btn-crud">
                <span class="loader-btn d-none"></span>
                Guardar Producto
            </button>
        </div>
    </form>
</section>

<template id="template-presentaciones">
    <div class="card-variants">
        <div class="d-flex justify-content-between mb-2">
            <h3 class="fs-6 fw-bold">Presentacion <span class="variant-number"></span></h3>
            <button onclick="eliminarPresentacion(this)" style="background-color: transparent;" type="button"
                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Eliminar Presentacion.">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <input type="hidden" name="presentacion_index[]" class="presentacion-index" value="">
        <div class="d-flex gap-4">
            <div class="w-50">
                <label style="font-size: 13px;" class="fw-semibold mb-2" for="sabor">Sabor</label>
                <select class="form-select-dashboard" name="presentaciones[0][sabor]">
                    <?php if (empty($sabores)) {
                        echo '<option disabled selected>No hay sabores disponibles.</option>';
                    } else {
                        foreach ($sabores as $sabor) { ?>
                            <option value="<?php echo $sabor['id']; ?>"><?php echo $sabor['nombre']; ?></option>
                        <?php }
                    } ?>
                </select>
                <span style="font-size: .9rem; display:inline-block">
                    <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'sabor') : ' ' ?>
                </span>
            </div>
            <div class="w-50">
                <label style="font-size: 13px;" class="fw-semibold mb-2" for="stock">Stock</label>
                <input class="form-input-dashboard" autocomplete="off" name="presentaciones[0][stock]" type="number"
                    placeholder="Ingresa el stock de producto">
                <span style="font-size: .9rem; display:inline-block">
                    <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'stock') : ' ' ?>
                </span>
            </div>
        </div>
        <div class="d-flex gap-4">
            <div class="w-50">
                <label style="font-size: 13px;" class="fw-semibold mb-2" for="precio_compra">Precio
                    Compra</label>
                <input class="form-input-dashboard" autocomplete="off" name="presentaciones[0][precio_compra]"
                    type="number" placeholder="Ingresa el precio de compra">
                <span style="font-size: .9rem; display:inline-block">
                    <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'precio_compra') : ' ' ?>
                </span>
            </div>
            <div class="w-50">
                <label style="font-size: 13px;" class="fw-semibold mb-2" for="precio_venta">Precio Venta</label>
                <input class="form-input-dashboard" autocomplete="off" name="presentaciones[0][precio_venta]"
                    type="number" placeholder="Ingresa el precio de venta">
                <span style="font-size: .9rem; display:inline-block">
                    <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'precio_venta') : ' ' ?>
                </span>
            </div>
        </div>
        <div class="d-flex gap-4">
            <div class="w-75">
                <label style="font-size: 13px;" class="fw-semibold mb-2" for="tamanio">Tamaño</label>
                <input class="form-input-dashboard" autocomplete="off" name="presentaciones[0][tamanio]" type="number"
                    placeholder="Ingresa el tamaño de la presentación">
                <span style="font-size: .9rem; display:inline-block">
                    <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'tamanio') : ' ' ?>
                </span>
            </div>
            <div class="w-25">
                <label style="font-size: 13px;" class="fw-semibold mb-2" for="unidad">Unidad</label>
                <select class="form-select-dashboard" id="unidad" name="presentaciones[0][unidad]">
                    <?php foreach ($unidades as $unidad) { ?>
                        <option value="<?php echo $unidad['id']; ?>"><?php echo $unidad['nombre_corto']; ?></option>
                    <?php } ?>
                </select>
                <span style="font-size: .9rem; display:inline-block">
                    <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'unidad') : ' ' ?>
                </span>
            </div>
        </div>
        <span style="font-size: 13px; cursor: default;" class="fw-semibold mb-2">Imágenes</span>
        <div class="d-flex gap-3 align-items-center mt-2">
            <input class="d-none imagen-input" accept="image/*" max="5" name="imagenes[0][]"
                oninput="actualizarImagenProducto(this)" multiple type="file">
            <label class="form-img-dashboard imagen-label"><i class="bi bi-plus-circle"></i> Agregar
                Imagen</label>
            <div class="vista-previa-imagenes d-flex gap-3"></div>
        </div>
    </div>
    </div>
</template>

<script>
    let variantIndex = 0;
    const container = document.getElementById('contenedor-presentaciones');
    document.getElementById('agregar-presentacion').addEventListener('click', function () {
        variantIndex++;
        const template = document.getElementById('template-presentaciones');
        const clone = document.importNode(template.content, true);
        clone.querySelectorAll('select, input').forEach(element => {
            const name = element.getAttribute('name');
            if (name && name.includes('presentaciones[0]')) {
                element.setAttribute('name', name.replace('presentaciones[0]', `presentaciones[${variantIndex}]`));
            }
        });

        clone.querySelector('.variant-number').textContent = variantIndex;

        clone.querySelector('.presentacion-index').value = variantIndex;

        const fileInput = clone.querySelector('.imagen-input');
        const fileLabel = clone.querySelector('.imagen-label');
        const uniqueId = `imagen-${variantIndex}`;
        fileInput.id = uniqueId;
        fileLabel.setAttribute('for', uniqueId);
        fileInput.name = `imagenes[${variantIndex}][]`;
        container.appendChild(clone);

        const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltips.forEach(tooltip => new bootstrap.Tooltip(tooltip));
    });

    function eliminarPresentacion(button) {
        if (container.childElementCount > 1) {
            button.closest('.card-variants').remove();
            variantIndex--;
            container.querySelectorAll('.variant-number').forEach((element, index) => {
                element.textContent = index + 1;
            })
            container.querySelectorAll('.presentacion-index').forEach((element, index) => {
                element.value = index;
            })
        }
    }
    function actualizarImagenProducto(input) {
        const previewContainer = input.closest('.d-flex').querySelector('.vista-previa-imagenes');
        previewContainer.innerHTML = '';

        if (input.files && input.files.length > 0) {
            const filesArray = Array.from(input.files);
            const newFileList = new DataTransfer();

            filesArray.forEach((file, index) => {
                const reader = new FileReader();
                const imageContainer = document.createElement('div');
                imageContainer.classList.add('image-container');

                reader.onload = function (e) {
                    const image = new Image();
                    image.classList.add('preview-image');
                    image.src = e.target.result;

                    const btnDelete = document.createElement("button");
                    btnDelete.innerHTML = "×";
                    btnDelete.classList.add("delete-img-btn");

                    btnDelete.addEventListener("click", function () {
                        imageContainer.remove();
                        filesArray.splice(index, 1);
                        newFileList.items.clear();
                        filesArray.forEach(f => newFileList.items.add(f));
                        input.files = newFileList.files;
                    });

                    imageContainer.appendChild(btnDelete);
                    imageContainer.appendChild(image);
                    previewContainer.appendChild(imageContainer);
                };

                reader.readAsDataURL(file);
                newFileList.items.add(file);
            });

            input.files = newFileList.files;
        }
    }


    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('agregar-presentacion').click();
    });

</script>
<script src="<?php echo base_url('assets/js/crud/productos.js'); ?>"></script>