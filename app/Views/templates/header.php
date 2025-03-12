<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo ucwords(str_replace("-", " ", $titulo)); ?></title>
  <link rel="stylesheet" href="<?php echo base_url('assets/css/custom.css'); ?>" />
  <link rel="stylesheet" href="<?php echo base_url('assets/css/styles.css'); ?>" />
  <link rel="icon" href="<?php echo base_url('assets/img/logo.jpg'); ?>">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <script type="module" src="<?php echo base_url('assets/js/cart.js'); ?>"></script>
</head>

<body class="bg-primary">
  <header class="fixed-top">
    <div class="scroll-container">
      <div class="marquee">
        <div class="scroll-wrapper">
          <div class="text-item">Envío gratis en compras superiores a $500.000</div>
          <div class="text-item">3 Cuotas sin interés en compras superiores a $95.000</div>
        </div>
        <div class="scroll-wrapper">
          <div class="text-item">Envío gratis en compras superiores a $500.000</div>
          <div class="text-item">3 Cuotas sin interés en compras superiores a $95.000</div>
        </div>
        <div class="scroll-wrapper">
          <div class="text-item">Envío gratis en compras superiores a $500.000</div>
          <div class="text-item">3 Cuotas sin interés en compras superiores a $95.000</div>
        </div>
        <div class="scroll-wrapper">
          <div class="text-item">Envío gratis en compras superiores a $500.000</div>
          <div class="text-item">3 Cuotas sin interés en compras superiores a $95.000</div>
        </div>
      </div>
    </div>
    <nav class="navbar navbar-expand-md bg-primary d-flex mb-5">
      <div class="container-lg position-relative px-4 px-lg-0">
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
          aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="<?php echo base_url(''); ?>"><img
            src="<?php echo base_url('assets/img/logo.jpg'); ?>" alt="logo" class="logo"></a>
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"
          aria-labelledby="offcanvasNavbarLabel">
          <div class="offcanvas-header">
            <a href="#" class="offcanvas-title" id="offcanvasNavbarLabel"><img
                src="<?php echo base_url('assets/img/logo.jpg'); ?>" alt="logo" class="logo"></a>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body mx-3 mx-md-auto">
            <!--Enlaces barra de navegacion-->
            <ul class="navbar-nav ml-auto">
              <li class="nav-item ">
                <a class="nav-link" href="<?php echo base_url('colecciones/todos-los-productos'); ?>">Productos</a>
              </li>
              <li class="nav-item ">
                <a class="nav-link" href="<?php echo base_url('contacto'); ?>">Contacto</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('quienes-somos'); ?>">Acerca De</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('comercializacion'); ?>">Comercialización</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="d-flex align-items-center gap-3">
          <button class="px-0 btn-search" id="btn-search" type="submit">
            <span class="iconify icon" data-icon="tabler:search" data-inline="false"></span>
          </button>
          <?php if (session()->has('loggedUser')) {
            echo '<a style="text-decoration:none" href="' . base_url('cuenta') . '"><span class="iconify icon" data-icon="tabler:user" data-inline="false"></span><span class="d-none fw-semibold d-lg-inline-block text-black"style="font-size:.9rem; margin-left: 4px">' . $usuario['nombre'] . '</span></a>';
          } else {
            echo '<a href="' . base_url('iniciar-sesion') . '"><span class="iconify icon" data-icon="tabler:user" data-inline="false"></span></a>';
          } ?>
          <div class="position-relative carrito-icono">
            <a class="" data-bs-toggle="offcanvas" href="#offcanvasCart" role="button"
              aria-controls="offcanvasCart"><span class="iconify icon" data-icon="tabler:shopping-cart"
                data-inline="false"></span></i></a>
            <?php if (isset($carrito)) { ?>
              <span class="position-absolute" id="contenido-carrito"
                style="top: -5px;"><?php echo count($carrito) ?></span>
            <?php } ?>
          </div>
        </div>
        <!--Formulario de busqueda-->
        <form class="bg-primary search-form d-none px-4 px-lg-0" action="<?php echo base_url('search') ?>" method="get">
          <input type="text" id="query" name="q" class="bg-primary text-secondary fw-medium fs-5"
            placeholder="Ingresa tu búsqueda..." />
          <div class="search-form__icons text-secondary">
            <button type="submit" class="btn ">
              <span class="iconify icon" data-icon="tabler:search" data-inline="false"></span>
            </button>
            <button type="button" class="btn" id="cancel-search">
              <span class="iconify icon" data-icon="tabler:x" data-inline="false"></span>
            </button>
          </div>
        </form>
      </div>
      </div>
    </nav>

  </header>
  <!--Carrito offcanvas-->
  <?php include 'carrito.php' ?>