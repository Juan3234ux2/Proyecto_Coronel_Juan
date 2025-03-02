<section class="text-center container-lg mt-3">
    <form>
        <h2 class="fw-bold pt-2">Detalle consulta # <?= $consulta['id'] ?></h2>
        <div class="form__container d-flex justify-content-center align-items-center my-4">
            <div class="form__group col-11 col-sm-9 col-md-8 col-lg-7">
                <div class="mb-3 d-flex gap-0 gap-sm-2 flex-column flex-sm-row">
                    <div class="position-relative" style="flex-grow:1;">
                        <input class="mx-0 w-100 form-input" disabled value="<?= $consulta['nombre']; ?>" placeholder=" ">
                        <label class="form-label" for="Nombre">Nombre</label>
                    </div>
                    <div class="position-relative" style="flex-grow:1;">
                        <input id="Email" class="mx-0 w-100 form-input" disabled value="<?= $consulta['email']; ?>" placeholder=" ">
                        <label class="form-label" for="Email">Email</label>
                    </div>
                </div>
                <div class=" position-relative">
                    <select id="tipoContacto" disabled class="mb-3 w-100 tiene-contenido">
                        <option value="" selected disabled><?= $consulta['tipo_consulta']; ?></option>
                    </select>
                    <label class="form-label" for="tipoContacto" style="cursor: pointer">Tipo de consulta</label </div>
                    <div class="mb-3 position-relative">
                        <textarea class="w-100 tiene-contenido" disabled style="resize: none; height:250px"><?= $consulta['mensaje']; ?></textarea>
                        <label class="form-label" for="consulta">Mensaje</label>
                    </div>
                </div>
                <a class="btn-regresar" href="<?php echo base_url('dashboard/consultas') ?>">Regresar</a>

            </div>

    </form>
</section>