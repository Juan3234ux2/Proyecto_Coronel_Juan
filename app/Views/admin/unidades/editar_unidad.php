<section class="container-xl col-7 text-center mt-4">
    <form method="post" action="<?php echo base_url('dashboard/unidades/actualizar'); ?>" autocomplete="off">
        <h1 class="fs-2">Editar Unidad</h1>
        <div class="form__container d-flex justify-content-center align-items-center my-4">
            <div class="form__group col-7">
                <input type="hidden" name="id" value="<?php echo $unidad['id']; ?>">
                <div class="position-relative" style="flex-grow:1;">
                    <input class="mx-0 position w-100 form-input" autocomplete="off" name="nombre" id="nombre" value="<?php echo $unidad['nombre']; ?>" require type="text" placeholder=" ">
                    <label class="form-label" for="nombre">Tu nombre</label>
                    <span style="font-size: .9rem; display:inline-block">
                        <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'nombre') : ' ' ?>
                    </span>
                </div>
                <div class="position-relative" style="flex-grow:1;">
                    <input class="mx-0 position w-100 form-input" autocomplete="off" name="nombreCorto" id="nombreCorto" value="<?php echo $unidad['nombre_corto']; ?>" require type="text" placeholder=" ">
                    <label class="form-label" for="nombreCorto">Nombre Corto</label>
                    <span style="font-size: .9rem; display:inline-block">
                        <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'nombreCorto') : ' ' ?>
                    </span>
                </div>
                <button class="btn-enviar-datos mb-3 text-uppercase w-100">Guardar</button>
                <a class="text-black" href="<?php echo base_url('dashboard/unidades'); ?>" style="font-size: 15px; font-weight:500">Regresar</a>
            </div>
        </div>
    </form>
</section>