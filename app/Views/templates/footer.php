<footer class="container-fuid bg-primary pt-3 pb-3 mt-3 mt-sm-5">
  <div class="container-lg pt-4 pt-sm-5 px-0">
    <div class="row justify-content-center align-items-start">
      <div class="footer-content col-md-4 text-center d-none d-md-block">
        <img src="<?php echo base_url('assets/img/general/logo-footer.png'); ?>" alt="Logo" style="height: 130px;">
      </div>
      <div class="footer-content col-12 col-sm-6 col-md-4 text-center">
        <h3>Menú</h3>
        <ul class="footer-links px-0 pb-1 m-3 m-sm-0">
          <li class="mb-1"><a class="fw-semibold" href="<?php echo base_url('preguntas-frecuentes'); ?>">Preguntas
              Frecuentes</a></li>
          <li class="mb-1"><a class="fw-semibold" href="<?php echo base_url('terminos-y-condiciones'); ?>">Términos y
              Condiciones</a></li>
          <li class="mb-1"><a class="fw-semibold" href="<?php echo base_url('contacto'); ?>">Contacto</a>
          </li>
        </ul>
      </div>
      <div class="footer-content col-12 col-sm-6 col-md-4 text-center">
        <h3>Nuestras Redes</h3>
        <div class="social-links m-3">
          <a href="https://m.facebook.com/profile.php?id=100007259949998&locale=es_LA" target="_blank"><i
              class="bi bi-facebook"></i></a>
          <a href="https://instagram.com/juancoronel323?igsh=M3VwNTQxb3ExdTZt" target="_blank"><i
              class="bi bi-instagram"></i></a>
          <a href="https://x.com/JuanC323?t=dVgnJzDjZAMZjJKJyQuWwg&s=09" target="_blank"><i
              class="bi bi-twitter"></i></a>
        </div>
      </div>
      <img class="medios-pagos col-10 mt-3" src="<?php echo base_url('assets/img/general/mediosDePago.png'); ?>"
        alt="medios-de-pago">
    </div>
  </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="<?php echo base_url('assets/js/scripts.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/fslightbox.js'); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
<script src="<?php echo base_url('assets/js/popper.min.js'); ?>"></script>
<script>
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })
</script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    AOS.init();
    const marquee = document.querySelector('.marquee');
    const scrollWrapper = document.querySelector('.scroll-wrapper');

    const totalWidth = marquee.scrollWidth / 2;
    const speed = totalWidth * 0.01;

    marquee.style.animationDuration = speed + 's';

  });

</script>

</body>

</html>