<section class="container-lg text-center d-flex align-items-center flex-column" style="margin-top: 12rem;">
    <h1 class="fs-1 fw-bold mb-3">Buscar</h1>
    <p style="font-weight: 500; font-size: .9rem;" class="text-center">No se ha encontrada ningún resultado para
        '<?= $busqueda ?>'</p>
    <div class="col-12 col-sm-8 col-md-6 col-lg-4 mb-4">
        <form action="<?= base_url('search') ?>" method="get">
            <div class="d-flex align-items-center my-4 position-relative">
                <div class="position-relative" style="flex-grow: 1;">
                    <input autofocus class="mx-0 form-input w-100" id="query" name="q" required placeholder=" ">
                    <label class="form-label" for="query">Buscar...</label>
                </div>
                <button class="btn-enviar-datos my-0 position-absolute end-0"
                    style="height: 49px; aspect-ratio: 1; border-start-start-radius: 0 ; border-end-start-radius: 0;"
                    type="submit"><i class="bi bi-search"></i></button>
            </div>
        </form>
        <a class="text-black login-text" href="<?= base_url() ?>">o haz click
            aquí para
            volver a la página de inicio</a>
    </div>
</section>