<section style="margin-top: 12rem;margin-bottom: 5rem">

    <?php if (!empty(session()->getFlashdata('success'))) { ?>
        <div class="text-center">
            <span class="mb-2 mensaje-exitoso mensaje-flash mx-auto col-12 col-md-11">
                <?= session()->getFlashdata('success'); ?>
            </span>
        </div>
        <?php
    } ?>
    <div class="hidden-desktop d-none mb-3">
        <div class="dropdown-mobile-panel" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom"
            aria-controls="offcanvasBottom">
            <h4 class="mb-0">
                Mi cuenta
            </h4>
            <i class="bi bi-chevron-up"></i>
        </div>

        <div class="offcanvas offcanvas-bottom" style="max-width: 100vw;" tabindex="-1" id="offcanvasBottom"
            aria-labelledby="offcanvasBottomLabel">
            <div class="offcanvas-header py-4">
                <h5 class="offcanvas-title text-black" id="offcanvasBottomLabel">Mi cuenta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body d-flex flex-column px-1" style="line-height:1.6">
                <div class="d-flex justify-content-between">
                    <a class="text-black item-panel-movil" href="<?php echo base_url('cuenta'); ?>">Mis pedidos</a>
                    <i class="bi bi-check px-3 text-black" style="font-size: 20px"></i>
                </div>
                <div class="dropdown">
                    <button class="nav-link dropdown-toggle text-secondary item-panel-movil"
                        style="border: none; background-color:transparent;" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Mis datos
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item py-0 link-cuenta"
                                href="<?php echo base_url('cuenta/modificar-datos') ?>"> Editar datos</a></li>
                        <li><a class="dropdown-item py-0 link-cuenta"
                                href="<?php echo base_url('cuenta/modificar-contrasenia') ?>">Editar Contraseña</a></li>
                    </ul>
                </div>
                <a class="item-panel-movil" href="<?php echo base_url('cerrar-sesion'); ?>">Cerrar sesión</a>
            </div>
        </div>
    </div>
    <div class="d-flex gap-5 justify-content-center flex-column flex-lg-row">
        <div class="panel-cuenta text-medium col-3 d-lg-flex d-none">
            <a class="text-black px-4 pt-4" href="<?php echo base_url('cuenta'); ?>">Mis pedidos</a>
            <div class="dropdown px-4">
                <button class="nav-link dropdown-toggle text-secondary"
                    style="border: none; background-color:transparent;" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Mis datos
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item py-0 link-cuenta"
                            href="<?php echo base_url('cuenta/modificar-datos') ?>"> Editar datos</a></li>
                    <li><a class="dropdown-item py-0 link-cuenta"
                            href="<?php echo base_url('cuenta/modificar-contrasenia') ?>">Editar Contraseña</a></li>
                </ul>
            </div>
            <?php if ($usuario['esAdmin']) { ?>
                <a class="px-4" href="<?php echo base_url('dashboard'); ?>">Ir al dashboard</a>
            <?php } ?>
            <a class="px-4" href="<?php echo base_url('cerrar-sesion'); ?>">Cerrar sesión</a>
        </div>
        <div class="col-12 col-md-11 col-lg-8 mx-auto mx-lg-0" style="border: 1px solid #d3d3d3">
            <h1 class="p-4 fs-3" style="border-bottom: 1px solid #d3d3d3;font-weight: 600">Mis pedidos</h1>
            <?php if (count($pedidos) == 0) { ?>
                <div class="text-center d-flex flex-column my-4">
                    <i class="position-relative bi bi-box fs-1 d-block mt-4"><span class="position-absolute"
                            id="contenido-carrito" style="top:-2px; left:51%">0</span></i>
                    <span class="text-medium">Ningún pedido</span>
                    <a class="btn-enviar-datos mt-4 mx-auto" style="width: 200px;"
                        href="<?php echo base_url('colecciones/todos-los-productos') ?>">Haz tu primer pedido</a>
                </div>
            <?php } else { ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" class="px-4">Fecha Compra</th>
                            <th class="d-none d-md-block" scope="col">Medio de pago</th>
                            <th scope="col">Monto</th>
                            <th scope="col" class="text-center">Detalles</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pedidos as $pedido) {
                            $fecha = $pedido['fecha_compra'];
                            $fechaSinHora = new DateTime($fecha);
                            $fechaSinHora->setTime(0, 0, 0);
                            $fechaCompra = $fechaSinHora->format('Y-m-d');
                            ?>
                            <tr class="align-middle">
                                <td class="px-4"><?php echo $fechaCompra ?> </td>
                                <td class="medio_pago"><?php echo $pedido['medio_pago']; ?> </td>
                                <td>$ <?php echo $pedido['precio_total']; ?> </td>
                                <td class="d-flex justify-content-center">
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Ver Detalle."
                                        class="btn-editar" style="background-color: rgb(33, 53, 53)"
                                        href="<?php echo base_url('cuenta/detalle-pedido/') . $pedido['id']; ?>"><i
                                            class="bi bi-plus fs-5"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php }
            ?>
        </div>
    </div>
</section>