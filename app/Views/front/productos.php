<section class="container-lg px-0 px-sm-2 mx-auto px-lg" style="margin-top: 180px;">
  <span class="text-center d-block d-lg-none text-medium fw-bold"><?php echo count($productos); ?> productos</span>
  <div class="d-lg-flex justify-content-end align-items-center d-none position-relative" style="font-size: 14px;">
    <span class="fw-bold">Ordenar Por:</span>
    <button class="filter-btn" style="background: none; ">
      <span class="border-text">Menor Precio</span>
      <i class="iconify" data-icon="material-symbols:keyboard-arrow-down" data-inline="false"></i>
    </button>
    <div class="options-container">
      <div class="options-wrapper">
        <a href="#" class="border-text">Caracteristicas</a>
        <a href="#" class="border-text">Mas Vendidos</a>
        <a href="#" class="border-text">Alfabeticamente A-Z</a>
        <a href="#" class="border-text">Alfabeticamente Z-A</a>
        <a href="#" class="border-text">Precio, Menor a Mayor</a>
        <a href="#" class="border-text">Precio, Mayor a Menor</a>
      </div>
    </div>
  </div>
  <div class="d-flex gap-4">
    <div class="d-lg-flex d-none flex-column gap-4" style="min-width: 250px;">
      <div class="d-flex align-items-center gap-2">
        <span class="iconify" data-icon="tabler:adjustments-horizontal" style="font-size: 25px;"
          data-inline="false"></span>
        <span class="fw-semibold">Filtros</span>
      </div>
      <div class="accordion accordion-flush" id="acordeon-filtros" style="max-width: 250px;">
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed fw-bold" style="font-size: 14px;" type="button"
              data-bs-toggle="collapse" data-bs-target="#flush-filtrosOne" aria-expanded="false"
              aria-controls="flush-filtrosOne">
              Precio
            </button>
          </h2>
          <div id="flush-filtrosOne" class="accordion-collapse collapse" data-bs-parent="#acordeon-filtros">
            <div class="accordion-body">
              <div class="slider">
                <div class="progress"></div>
              </div>
              <div class="range-input">
                <input type="range" class="range-min" min="0" max="100000" value="0">
                <input type="range" class="range-max" min="0" max="100000" value="100000">
              </div>
            </div>
            <div class="d-flex gap-4 mb-3 mt-2 align-items-center price-input" style="font-size: 13px;">
              <div class="w-50 position-relative">
                <i class="bi bi-currency-dollar text-secondary position-absolute" style="top: 13px; left: 6px;"></i>
                <input type="number"
                  style="padding: 12px; border-radius: 6px; border: 1px solid rgba(0, 0, 0, 0.35); text-align:right; font-size: 13px; line-height: 20px;"
                  class="input-min w-100 fw-semibold" value="2500">
              </div>
              <span class="fw-semibold text-secondary">a</span>
              <div class="w-50 position-relative">
                <i class="bi bi-currency-dollar text-secondary position-absolute" style="top: 13px; left: 6px;"></i>
                <input type="number"
                  style="padding: 12px; border-radius: 6px; border: 1px solid rgba(0, 0, 0, 0.35); text-align:right; font-size: 13px; line-height: 20px;"
                  class="input-max w-100 fw-bold d-flex" value="7500">
              </div>
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse"
              data-bs-target="#flush-filtrosTwo" aria-expanded="false" style="font-size: 14px;"
              aria-controls="flush-filtrosTwo">
              Tipo de Producto
            </button>
          </h2>
          <div id="flush-filtrosTwo" class="accordion-collapse collapse" data-bs-parent="#acordeon-filtros">
            <div class="accordion-body d-flex flex-column gap-2">
              <?php
              $categorias = ['Proteinas', 'Creatinas', 'Pre Entreno'];
              for ($i = 0; $i < count($categorias); $i++) { ?>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="<?php echo 'categoria' . $i ?>" value="">
                  <label class="form-check-label" for="<?php echo 'categoria' . $i ?>">
                    <?php echo $categorias[$i] . '    (5)'; ?>
                  </label>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse"
              data-bs-target="#flush-filtrosThree" aria-expanded="false" style="font-size: 14px;"
              aria-controls="flush-filtrosThree">
              Sabor
            </button>
          </h2>
          <div id="flush-filtrosThree" class="accordion-collapse collapse" data-bs-parent="#acordeon-filtros">
            <div class="accordion-body d-flex flex-column gap-2">
              <?php
              $sabores = ['Chocolate', 'Sin Sabor', 'Vainilla', 'Banana'];
              for ($i = 0; $i < count($sabores); $i++) { ?>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="<?php echo 'sabor' . $i ?>" value="">
                  <label class="form-check-label" for="<?php echo 'sabor' . $i ?>">
                    <?php echo $sabores[$i] . '    (5)'; ?>
                  </label>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="products-cards px-0 row">
      <?php
      foreach ($productos as $producto) {
        $nombre = $producto['nombre'] . ' ' . $producto['contenido'] . $producto['nombre_unidad'] . ' ' . $producto['nombre_marca'];
        $url = strtolower(str_replace(" ", "-", $nombre . ' ' . $producto['id']));
        ?>

        <div class="col-xl-3 col-lg-4 col-6">
          <a class="h-100 position-relative" href="<?php echo base_url('productos/' . $url) ?>"
            style="color:inherit; text-decoration:none;">
            <img src=" <?php echo base_url('assets/uploads/' . $producto['imagen']); ?> " class="card-img-top mt-3"
              alt="...">
            <div class="card-body py-4 mb-3 px-3">
              <p class="fw-bold text-start pb-2" style="font-size: 14px"><?php echo $nombre ?></p>
              <span class="fw-semibold fs-6 position-absolute"
                style="bottom:15px; color:rgb(53, 53, 53)">$<?php echo number_format($producto['precio_venta'], 2, ',', '.') ?></span>
            </div>
          </a>
        </div>
      <?php }
      ?>
    </div>
  </div>
</section>