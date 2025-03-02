<section class="text-center container-lg" style="margin-top:130px">
    <form method="post" class="d-flex flex-column flex-lg-row" action="<?php echo base_url('enviar-consulta'); ?>">
        <div class="text-start contact-text">
            <span class="fw-bolder">Contactanos</span>
            <h2 class="fw-bolder fs-1 mt-3">¿Tenes alguna duda o consulta?</h2>
        </div>
        <div
            class="form__container d-flex justify-content-center align-items-center my-4 flex-grow-1 col-12 col-lg-6 col-xl-7">
            <div class="form__group contact-form w-100">
                <div class="d-flex gap-0 gap-sm-2 flex-column flex-sm-row">
                    <div class="position-relative" style="flex-grow:1;">
                        <input class="mx-0 w-100 form-input" id="Nombre" name="nombre" type="text" placeholder=" ">
                        <label class="form-label" for="Nombre">Tu nombre</label>
                        <span style="font-size: .9rem; display:inline-block">
                            <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'imagen') : ' ' ?>
                        </span>
                    </div>
                    <div class="position-relative" style="flex-grow:1;">
                        <input class="mx-0 w-100 form-input" id="Email" name="email" type="email" placeholder=" ">
                        <label class="form-label" for="Email">Tu email</label>
                        <span style="font-size: .9rem; display:inline-block">
                            <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'email') : ' ' ?>
                        </span>
                    </div>
                </div>
                <div class="position-relative">
                    <select id="tipoContacto" class="w-100" name="tipoConsulta" onchange="animarLabelSelect(this)">
                        <option value="" selected disabled></option>
                        <option value="Mayoristas">Mayoristas</option>
                        <option value="Atención al cliente">Atención al cliente</option>
                    </select>
                    <label class="form-label" for="tipoContacto" style="cursor: pointer">Tipo de consulta</label>
                    <span style="font-size: .9rem; display:inline-block">
                        <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'tipoConsulta') : ' ' ?>
                    </span>
                </div>
                <div class="position-relative">
                    <textarea class="w-100" name="consulta" id="consulta" style="resize: none; height:250px"></textarea>
                    <label class="form-label" for="consulta">Tu mensaje</label>
                    <span style="font-size: .9rem; display:inline-block">
                        <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'consulta') : ' ' ?>
                    </span>
                </div>
                <div class="d-flex justify-content-end">
                    <button class="btn-enviar-datos">Enviar Mensaje</button>
                </div>
            </div>
        </div>
    </form>
</section>