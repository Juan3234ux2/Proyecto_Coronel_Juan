<!--Carrusel de suplementos-->
<div id="carouselSuplementos" class="carousel slide carousel-fade position-relative" style="margin-top: 120px"
  data-bs-ride="carousel" data-aos="zoom-in" data-aos-duration="700" data-aos-once="true">
  <div class="carousel-indicators my-0 position-absolute right-0 bottom-0">
    <button type="button" data-bs-target="#carouselSuplementos" data-bs-slide-to="0" class="active mx-1"
      aria-current="true" aria-label="Slide 1"></button>
    <button type="button" class="mx-1" data-bs-target="#carouselSuplementos" data-bs-slide-to="1"
      aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselSuplementos" data-bs-slide-to="2" class="mx-1"
      aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner mx-auto w-md-100 w-lg-50">
    <?php
    $directorio = "./assets/img/carrusel/";
    $images = glob($directorio . '*.jpg');
    $primera = true;
    foreach ($images as $image) {
      echo '<div class="carousel-item' . ($primera ? ' active' : '') . '"data-bs-interval="4000">';
      echo '<img src="' . $image . '" class="d-block w-100" alt="..." />';
      echo '</div>';
      $primera = false;
    }
    ?>
  </div>
</div>
<!--Contenedor de las categorias-->
<div class="container-lg mt-4" data-aos="fade-up" data-aos-duration="800" data-aos-once="true">
  <div class="d-flex justify-content-between align-items-center mb-2 mb-sm-4">
    <h2 class="text-dark fw-bold mt-4">Categorías</h2>
    <a href="<?php echo base_url('colecciones/todos-los-productos') ?>"
      class="text-decoration-none fw-medium text-dark login-text">Ver todas</a>
  </div>
  <div class="categories-container row" style="margin-bottom: 5rem;">
    <div class="category-box col-12 col-sm-6 gap-2 py-3 py-sm-0">
      <div class="w-100">
        <a href="colecciones/proteinas" class="px-0"><img src="assets/img/categorias/1.png"
            class="category-img w-100  h-auto" /></a>
      </div>
    </div>
    <div class="category-box col-12 col-sm-6 gap-2 py-3 py-sm-0">
      <div class="w-100">
        <a href="colecciones/creatinas" class="px-0"><img src="assets/img/categorias/2.png"
            class="category-img w-100  h-auto" /></a>
      </div>
    </div>
  </div>
</div>
<!--Productos-->
<section class="container-fluid" style="background-color: #f5f5f5; padding-bottom: 6rem">
  <div class="container-lg  pt-5" data-aos="fade-up" data-aos-duration="600" data-aos-once="true">
    <span class="fw-bold" style="font-size: 14px">¡Inspirate y alcanzá tus objetivos!</span>
    <h2 class="fw-bolder text-black mb-4 pt-3 fs-1">Nuestros Productos</h2>
    <section class="splide pt-3">
      <div class="splide__arrows">
        <button class="splide__arrow splide__arrow--prev">
          <span class="iconify icon" data-icon="tabler:arrow-right" data-inline="false"></span>
        </button>
        <button class="splide__arrow splide__arrow--next">
          <span class="iconify icon" data-icon="tabler:arrow-right" data-inline="false"></span>
        </button>
      </div>
      <div class="splide__track">
        <ul class="splide__list">
          <?php

          foreach ($productosPopulares as $index => $producto) {
            $nombre = devolverNombreProducto($producto);
            $url = strtolower(str_replace(" ", "-", $nombre . '?variant=' . $producto['id_presentacion']));
            ?>

            <li class=" splide__slide bg-white" data-aos="fade-in-up" style="border-radius: 10px;">
              <a class="h-100 position-relative" href="<?php echo base_url('productos/' . $url) ?>"
                style="color:inherit; text-decoration:none;">
                <img src=" <?php echo base_url('assets/uploads/' . $producto['nombre_imagen']); ?> "
                  class="card-img-top mt-3" alt="...">
                <div class="card-body py-4 mb-3 px-3">
                  <p class="text-start fw-bold pb-2" style="font-size: 14px"><?php echo $nombre ?></p>
                  <span class="fw-semibold fs-6 position-absolute" style="bottom:15px; color:rgb(53, 53, 53)">Desde
                    $
                    <?php
                    echo number_format($producto['precio_desde'], 2, ',', '.') ?>
                  </span>
                </div>
              </a>
            </li>
            <?php
            if ($index > 6) {
              break;
            }
          }
          ?>
        </ul>
      </div>
    </section>
  </div>
</section>
<!--Pre footer-->
<section>
  <img src="https://www.enasport.com/cdn/shop/files/BANNER_WEB_PRINCIPAL_DSK_2160_x_720.png?v=1737126351&width=2000"
    class="img-drink" alt="BANNER PRINCIPAL">
  <section class="container-fluid" style="background-color: #f5f5f5; padding-bottom: 5rem; padding-top: 2rem	">
    <div class="container-lg pt-5">
      <h2 class="fw-bolder text-black mb-4 pt-3 fs-1">Nuestros Embajadores</h2>
      <section class="splide embajadores">
        <div class="splide__track">
          <ul class="splide__list">
            <li class="splide__slide">
              <div class="d-flex flex-column gap-3">
                <img
                  src="https://www.enasport.com/cdn/shop/files/Franco_Florio_40c4e1a1-a74c-467b-916e-d0e6c6769404.png?v=1736180385&width=600"
                  style="border-radius:10px" alt="Franco Florio">
                <span class="fw-bold fs-2">Franco Florio</span>
                <span class="fw-semibold" style="font-size: 14px">Velocista, mantiene récord actual nacional de los 100
                  metros llanos</span>
              </div>
            </li>
            <li class="splide__slide">
              <div class="d-flex flex-column gap-3">
                <img src="https://www.enasport.com/cdn/shop/files/Maca_Ceballos.png?v=1736180387&width=600"
                  style="border-radius:10px" alt="Maca Ceballos">
                <span class="fw-bold fs-2">Maca Ceballos</span>
                <span class="fw-semibold" style="font-size: 14px">Nadadora olímpica</span>
              </div>
            </li>
            <li class="splide__slide">
              <div class="d-flex flex-column gap-3">
                <img
                  src="https://www.enasport.com/cdn/shop/files/Tute_Osadczuk_cc40e2bc-09a3-434c-ab1d-3b36eae84334.png?v=1736180385&width=600"
                  style="border-radius:10px" alt="Tute Osadczuk">
                <span class="fw-bold fs-2">Tute Osadczuk</span>
                <span class="fw-semibold" style="font-size: 14px">Medallista olímpico de los pumas 7´s</span>
              </div>
            </li>
          </ul>
        </div>
      </section>
    </div>
  </section>
  <section class="container-lg pt-5">
    <h2 class="fw-bolder text-start text-black mb-4 pt-3 fs-1">Voces de nuestra comunidad</h2>
    <div class="row pt-4">
      <div class="col-12 col-sm-6">
        <img class="w-100"
          src="https://www.enasport.com/cdn/shop/files/Banners_Cuadrados_Influes_2.gif?v=1737139254&width=800"
          style="border-radius:15px" alt="Gif Proteina">
      </div>
      <div class="col-12 col-sm-6 d-flex flex-column gap-4 mt-3 mt-sm-0">
        <div class="influencer-box col-12 position-relative" style="border-radius:10px; ">
          <div class="w-100">
            <img class="flex-grow-1 influencer-img w-100 h-auto"
              src="https://www.enasport.com/cdn/shop/files/Banner_Horizontal_Influes.png?v=1737134015&width=800"
              alt="Jovalicenti">
          </div>
          <span class="text-white fs-4 fw-bold position-absolute bottom-0 pb-2" style="left: 20px;">@Jovalicenti</span>
        </div>
        <div class="row">
          <div class="influencer-box col-6 position-relative">
            <div class="w-100" style="border-radius:10px; ">
              <img class="influencer-img w-100 h-auto"
                src="https://www.enasport.com/cdn/shop/files/Stefi_Starli_Banner_Cuadrado_Pequeno.png?v=1737134016&width=500"
                alt="Estefaniaestarli">
            </div>
            <span class="text-white fs-5 fw-bold position-absolute bottom-0 pb-3"
              style="left: 20px;">@Estefaniaestarli</span>
          </div>
          <div class="influencer-box col-6 position-relative">
            <div class="w-100" style="border-radius:10px; ">
              <img class="influencer-img w-100 h-auto"
                src="https://www.enasport.com/cdn/shop/files/Zuca_Conti_Banner_Cuadrado_Pequeno.png?v=1737140264&width=500"
                alt="Zuca Conti">
            </div>
            <span class="text-white fs-5 fw-bold position-absolute bottom-0 pb-2" style="left: 20px;">@Zucaconti</span>
          </div>
        </div>
      </div>
      <video class="w-100 mt-5 d-block d-sm-none" style="border-radius:20px"
        src="https://www.enasport.com/cdn/shop/videos/c/vp/4ee2cbb597244aa2bd7aa4e2f50263dc/4ee2cbb597244aa2bd7aa4e2f50263dc.HD-1080p-7.2Mbps-41098899.mp4?v=0"
        autoplay loop muted></video>
      <video class="w-100 mt-5 d-none d-sm-block" style="border-radius:20px"
        src="https://www.enasport.com/cdn/shop/videos/c/vp/b2b46c5bf8dd439896957191e5e26343/b2b46c5bf8dd439896957191e5e26343.HD-1080p-4.8Mbps-41158157.mp4?v=0"
        autoplay loop muted></video>
  </section>
  </div>
</section>