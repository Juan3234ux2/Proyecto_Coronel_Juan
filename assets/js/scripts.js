const btnSearch = document.querySelector(".btn-search");
const searchForm = document.querySelector(".search-form");
const searchInput = document.getElementById("query");
const btnCancelSearch = document.getElementById("cancel-search");
const btnDisminuirCantidad = document.querySelectorAll(".btn-cantidad-menos");
const btnAumentarCantidad = document.querySelectorAll(".btn-cantidad-mas");
const inputCantidad = document.querySelectorAll(".input-cantidad");
const consulta = document.getElementById("consulta");
const tipoConsulta = document.getElementById("tipoContacto");
const mostrarContraseña = document.querySelectorAll(".watch-password");
const inputContraseña = document.querySelectorAll('input[type="password"]');
const vistaPreviaProducto = document.getElementById("vista-previa");
const btnMenosCantidad = document.getElementById("btn-disminuir-cantidad");
const btnMasCantidad = document.getElementById("btn-aumentar-cantidad");
const cantidadProducto = document.getElementById("cantidad-producto");
const precioTotal = document.getElementById("precio-total");
const contenidoCarrito = document.getElementById("contenido-carrito");
const mensajeFlash = document.querySelector(".mensaje-flash");
const btnOrdenar = document.querySelector('.filter-btn'); 
const optionsContainer = document.querySelector('.options-container');
const popoverUserDashboard = document.getElementById('popover-user-container') 
const btnTogglePopoverDashboard = document.getElementById('btn-user-dashboard')

btnSearch?.addEventListener("click", function () {
  searchForm.classList.remove("d-none");
  searchInput.focus();
});
btnTogglePopoverDashboard?.addEventListener('click', function(event){
  toggleDropdown(popoverUserDashboard);
  event.stopPropagation()
});
btnCancelSearch?.addEventListener("click", function () {
  searchForm.classList.add("d-none");
});

btnOrdenar?.addEventListener("click", function (event) {
    btnOrdenar.classList.toggle("active");
    optionsContainer.classList.toggle("active");
    event.stopPropagation(); 
})
popoverUserDashboard?.addEventListener("click", function (event) {
  event.stopPropagation();
})
optionsContainer?.addEventListener("click", function (event) {
  event.stopPropagation();
})
document.addEventListener('click', function(event) {
  if(popoverUserDashboard){
    popoverUserDashboard.classList.add('d-none')
  }
  if(optionsContainer){
    optionsContainer.classList.remove('active');
    btnOrdenar.classList.remove('active');
  }
});
mostrarContraseña?.forEach(function (button, index) {
  button.addEventListener("click", function () {
    let inputContraseña2 = inputContraseña[index];
    if (inputContraseña2.type == "password") {
      inputContraseña2.type = "text";
      button.classList.remove("bi-eye");
      button.classList.add("bi-eye-slash");
    } else {
      inputContraseña2.type = "password";
      button.classList.remove("bi-eye-slash");
      button.classList.add("bi-eye");
    }
  });
});

btnMenosCantidad?.addEventListener("click", function () {
  let cantidadActual = parseInt(cantidadProducto.value);
  if (cantidadActual > 1) {
    cantidadProducto.value = manejarStock(cantidadActual, -1);
  }
});
btnMasCantidad?.addEventListener("click", function () {
  let cantidadActual = parseInt(cantidadProducto.value);
  cantidadProducto.value = manejarStock(cantidadActual, 1);
});

btnDisminuirCantidad?.forEach(function (button, index) {
  button.addEventListener("click", function () {
    let inputCantidad2 = inputCantidad[index];
    let cantidadActual = parseInt(inputCantidad2.value);
    if (cantidadActual > 1) {
      inputCantidad2.value = manejarStock(cantidadActual, -1);
      actualizarPreciosCarrito(index);
    }
  });
});
btnAumentarCantidad?.forEach(function (button, index) {
  button.addEventListener("click", function () {
    let inputCantidad2 = inputCantidad[index];
    let cantidadActual = parseInt(inputCantidad2.value);
    inputCantidad2.value = manejarStock(cantidadActual, 1);
    actualizarPreciosCarrito(index);
  });
});
function formatCurrency(amount) {
  return new Intl.NumberFormat('es-AR', {
      style: 'currency',
      currency: 'ARS',
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
  }).format(amount);
}
function actualizarPreciosCarrito(index) {
  let inputCantidad2 = inputCantidad[index];
  const preciosProductos = document.querySelectorAll(".precio-producto");
  let etiquetaPrecio = preciosProductos[index];
  const precio = etiquetaPrecio.getAttribute("data-precio");
  cambiarPrecio(etiquetaPrecio, precio, inputCantidad2);
  actualizarTotal();
}

function actualizarTotal() {
  let total = 0;
  const preciosProductos = document.querySelectorAll(".precio-producto");
  preciosProductos.forEach((producto) => {
    total += parseCurrency(producto.innerHTML)
  });
  precioTotal.innerHTML = formatCurrency(total);
}
function parseCurrency(currencyString) {
  return parseFloat(currencyString.replace('$', '').replace(/\./g, '').replace(',', '.').replace('&nbsp;', ''));
}
function cambiarPrecio(etiqueta, precio, input) {
  etiqueta.innerHTML = formatCurrency(precio * input.value);
}

consulta?.addEventListener("input", function () {
  if (consulta.value !== "") {
    consulta.classList.add("tiene-contenido");
  } else {
    consulta.classList.remove("tiene-contenido");
  }
});

function animarLabelSelect(input) {
  if (input.value !== "") {
    input.classList.add("tiene-contenido");
  } else {
    input.classList.remove("tiene-contenido");
  }
}
function actualizarImagenProducto(input) {
  const label = input.nextElementSibling;
  const contenidoLabel = document.createElement("span");
  contenidoLabel.innerHTML = `
    <i class = "bi bi-cloud-arrow-up"></i>
    Seleccionar Imagen
    `;
  if (input.files.length == 0) {
    vistaPreviaProducto.innerHTML = "No se ha seleccionado ninguna imágen";
    label.innerHTML = "";
    label.appendChild(contenidoLabel);
  } else {
    const archivo = input.files[0];
    if (archivo && archivo.type.startsWith("image/")) {
      const lector = new FileReader();
      lector.onload = (evento) => {
        const imagen = new Image();
        imagen.classList.add("w-50");
        vistaPreviaProducto.innerHTML = " ";
        imagen.src = evento.target.result;
        vistaPreviaProducto.appendChild(imagen);
        label.innerHTML = archivo.name;
      };
      lector.readAsDataURL(archivo);
    } else {
      vistaPreviaProducto.innerHTML = "Archivo Inválido";
      label.innerHTML = "";
      label.appendChild(contenidoLabel);
    }
  }
}
const manejarStock = (stockAct, cant) =>
  stockAct >= 1 ? (stockAct += cant) : stockAct;

document.addEventListener("DOMContentLoaded", function () {
  if (mensajeFlash) {
    setTimeout(function () {
      mensajeFlash.style.animation = "desvanecer 3s";
    }, 2000);
    mensajeFlash.addEventListener("animationend", function () {
      mensajeFlash.remove();
    });
  }
  //Inicia Carruseles
  var elms = document.getElementsByClassName("splide");
  for (var i = 0; i < elms.length; i++) {
    let settings = elms[i].classList.contains("embajadores")
      ? { perPage: 3, arrows: false, gap: "2rem" }
      : { perPage: 4 };
    if (elms[i].classList.contains("detalle-productos")) {
      continue;
    }
    new Splide(elms[i], {
      type: "slide",
      arrow: false,
      perMove: 1,
      gap: "1rem",
      pagination: false,
      breakpoints: {
        500: {
          perPage: 1,
        },
        640: {
          perPage: 2,
        },
        992: {
          perPage: 3,
        },
      },
      ...settings,
    }).mount();
  }

  var main = new Splide("#main-carousel-product", {
    type: "slide",
    rewind: true,
    pagination: false,
    arrows: false,
  });

  var thumbnails = new Splide("#carousel-product", {
    fixedWidth: 80,
    fixedHeight: 90,
    gap: 10,
    rewind: true,
    pagination: false,
    isNavigation: true,
    arrows: false,
  });

  main.sync(thumbnails);
  main.mount();
  thumbnails.mount();
});

function actualizarCantidad(idProducto, cantidad) {
  $.ajax({
    url: "http://localhost/Proyecto_Coronel_Juan/productos/agregarcarrito",
    type: "POST",
    data: {
      id: idProducto,
      cantidad: cantidad,
    },
    success: function (response) {
      if (response.status === "success") {
        actualizarTotal();
      }
    },
  });
}
const rangeInputs = document.querySelectorAll(".range-input input");
const priceInputs = document.querySelectorAll(".price-input input");
const progress = document.querySelector(".slider .progress");

if(rangeInputs.length > 0){
  const minRange = parseInt(rangeInputs[0].min);
  const maxRange = parseInt(rangeInputs[0].max);
  let priceGap = 150;

  function updateSlider() {
    let minValue = parseInt(rangeInputs[0].value);
    let maxValue = parseInt(rangeInputs[1].value);

    progress.style.left =
      ((minValue - minRange) / (maxRange - minRange)) * 100 + "%";
    progress.style.right =
      100 - ((maxValue - minRange) / (maxRange - minRange)) * 100 + "%";

    priceInputs[0].value = minValue;
    priceInputs[1].value = maxValue;
  }

  rangeInputs?.forEach((input) => {
    input.addEventListener("input", (e) => {
      let minValue = parseInt(rangeInputs[0].value);
      let maxValue = parseInt(rangeInputs[1].value);

      if (maxValue - minValue < priceGap) {
        if (e.target.classList.contains("range-min")) {
          rangeInputs[0].value = maxValue - priceGap;
        } else {
          rangeInputs[1].value = minValue + priceGap;
        }
      }
      updateSlider();
    });
  });

  priceInputs?.forEach((input) => {
    input.addEventListener("input", (e) => {
      let minValue = parseInt(priceInputs[0].value) || minRange;
      let maxValue = parseInt(priceInputs[1].value) || maxRange;

      if (
        maxValue - minValue >= priceGap &&
        maxValue <= maxRange &&
        minValue >= minRange
      ) {
        if (e.target.classList.contains("input-min")) {
          rangeInputs[0].value = minValue;
        } else {
          rangeInputs[1].value = maxValue;
        }
        updateSlider();
      }
    });
  });

  updateSlider();
}
const cambiarSabor = (select) => {
  const saborProducto = document.getElementById("sabor-producto");
  saborProducto.innerHTML = select.value;
};

const toggleDropdown = (container) => {
  if (container.classList.contains('d-none')) {
    container.style.display = 'block';
    container.style.maxHeight = '0';
    container.style.opacity = '0';
    container.style.overflow = 'hidden';
    container.style.transition = 'max-height 0.4s ease-in-out, opacity 0.3s ease-in-out';
    container.classList.remove('d-none');
    const altura = container.scrollHeight;
    setTimeout(() => {
        container.style.maxHeight = altura + 'px';
        container.style.opacity = '1';

        setTimeout(() => {
            container.style.maxHeight = '';
            container.style.overflow = '';
        }, 400);
    }, 10);
} else {
    const altura = container.scrollHeight;
    container.style.maxHeight = altura + 'px';
    container.style.overflow = 'hidden';
    container.style.transition = 'max-height 0.4s ease-in-out, opacity 0.3s ease-in-out';
    void container.offsetHeight;
    container.style.maxHeight = '0';
    container.style.opacity = '0';

    setTimeout(() => {
        container.classList.add('d-none');
        container.style.display = '';
        container.style.maxHeight = '';
        container.style.opacity = '';
        container.style.overflow = '';
    }, 600);
}
}