<section class="container-xl col-7 text-center mt-4">
    <form method="post" action="<?php echo base_url('dashboard/categorias/insertar'); ?>" autocomplete="off">
        <h1 class="fs-2">Agregar Categoria</h1>
        <div class="form__container d-flex justify-content-center align-items-center my-4">
            <div class="form__group col-7">
                <div class="position-relative" style="flex-grow:1;">
                    <input class="mx-0 position w-100 form-input" autocomplete="off" name="nombre" id="nombre" require type="text" placeholder=" ">
                    <label class="form-label" for="nombre">Nombre</label>
                    <span style="font-size: .9rem; display:inline-block">
                        <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'nombre') : ' ' ?>
                    </span>
                </div>
                <button class="btn-enviar-datos mb-3 text-uppercase w-100">Agregar Categoria</button>
                <a class="text-black" href="<?php echo base_url('dashboard/categorias'); ?>" style="font-size: 15px; font-weight:500">Regresar</a>
            </div>
        </div>
    </form>
</section>