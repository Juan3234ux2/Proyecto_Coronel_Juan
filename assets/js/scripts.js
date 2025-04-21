  const elements = {
      btnSearch: document.querySelector(".btn-search"),
      searchForm: document.querySelector(".search-form"),
      searchInput: document.getElementById("query"),
      btnCancelSearch: document.getElementById("cancel-search"),
    
      consulta: document.getElementById("consulta"),
      tipoConsulta: document.getElementById("tipoContacto"),

      mostrarContraseña: document.querySelectorAll(".watch-password"),
      inputContraseña: document.querySelectorAll('input[type="password"]'),
      
      mensajeFlash: document.querySelector(".mensaje-flash"),
      
      popoverTriggers: document.querySelectorAll(".popover-trigger"),
      popovers: document.querySelectorAll(".popover"),
      contenedorToast: document.getElementById('contenedor-toast'),
      rangeInputs: document.querySelectorAll(".range-input input"),
      priceInputs: document.querySelectorAll(".price-input input"),
      progress: document.querySelector(".slider .progress")
  };

  const rangeSliderFunctions = {
      initRangeSlider: function() {
          if (!elements.rangeInputs || elements.rangeInputs.length === 0) return;
          
          const minRange = parseInt(elements.rangeInputs[0].min);
          const maxRange = parseInt(elements.rangeInputs[0].max);
          const priceGap = 150;

          const updateSlider = function() {
              let minValue = parseInt(elements.rangeInputs[0].value);
              let maxValue = parseInt(elements.rangeInputs[1].value);

              if (elements.progress) {
                  elements.progress.style.left = ((minValue - minRange) / (maxRange - minRange)) * 100 + "%";
                  elements.progress.style.right = 100 - ((maxValue - minRange) / (maxRange - minRange)) * 100 + "%";
              }

              if (elements.priceInputs && elements.priceInputs.length > 1) {
                  elements.priceInputs[0].value = minValue;
                  elements.priceInputs[1].value = maxValue;
              }
          };

          elements.rangeInputs.forEach((input) => {
              input.addEventListener("input", (e) => {
                  let minValue = parseInt(elements.rangeInputs[0].value);
                  let maxValue = parseInt(elements.rangeInputs[1].value);

                  if (maxValue - minValue < priceGap) {
                      if (e.target.classList.contains("range-min")) {
                          elements.rangeInputs[0].value = maxValue - priceGap;
                      } else {
                          elements.rangeInputs[1].value = minValue + priceGap;
                      }
                  }
                  updateSlider();
              });
          });

          if (elements.priceInputs) {
              elements.priceInputs.forEach((input) => {
                  input.addEventListener("input", (e) => {
                      let minValue = parseInt(elements.priceInputs[0].value) || minRange;
                      let maxValue = parseInt(elements.priceInputs[1].value) || maxRange;

                      if (
                          maxValue - minValue >= priceGap &&
                          maxValue <= maxRange &&
                          minValue >= minRange
                      ) {
                          if (e.target.classList.contains("input-min")) {
                              elements.rangeInputs[0].value = minValue;
                          } else {
                              elements.rangeInputs[1].value = maxValue;
                          }
                          updateSlider();
                      }
                  });
              });
          }

          updateSlider();
      }
  };

  const initCarousels = function() {
      const elms = document.getElementsByClassName("splide");
      
      for (let i = 0; i < elms.length; i++) {
          if (elms[i].classList.contains("detalle-productos")) {
              continue;
          }
          
          let settings = elms[i].classList.contains("embajadores")
              ? { perPage: 3, arrows: false, gap: "2rem" }
              : { perPage: 4 };
              
          try {
              new Splide(elms[i], {
                  type: "slide",
                  arrow: false,
                  perMove: 1,
                  gap: "1rem",
                  pagination: false,
                  breakpoints: {
                      500: { perPage: 1 },
                      640: { perPage: 2 },
                      992: { perPage: 3 },
                  },
                  ...settings,
              }).mount();
          } catch (error) {
              console.error(`Error al inicializar carrusel ${i}:`, error);
          }
      }

      const mainCarousel = document.getElementById("main-carousel-product");
      const thumbnailsCarousel = document.getElementById("carousel-product");
      
      if (mainCarousel && thumbnailsCarousel) {
          try {
              const main = new Splide("#main-carousel-product", {
                  type: "slide",
                  rewind: true,
                  pagination: false,
                  arrows: false,
              });

              const thumbnails = new Splide("#carousel-product", {
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
          } catch (error) {
              console.error("Error al inicializar carruseles de producto:", error);
          }
      }
  };

  const setupEventListeners = function() {
      if (elements.btnSearch) {
          elements.btnSearch.addEventListener("click", () => {
              if (elements.searchForm) {
                  elements.searchForm.classList.remove("d-none");
                  if (elements.searchInput) elements.searchInput.focus();
              }
          });
      }

      if (elements.btnCancelSearch) {
          elements.btnCancelSearch.addEventListener("click", () => {
              if (elements.searchForm) {
                  elements.searchForm.classList.add("d-none");
              }
          });
      }

      if(elements.popoverTriggers) {
          elements.popoverTriggers.forEach((button) => {
            button.addEventListener("click", function (event) {
                button.classList.toggle("active");
                event.stopPropagation(); 
            });
        });
      }
      if(elements.popovers) {
          elements.popovers.forEach((popover) => {
              popover.addEventListener("click", function (event) {
                  event.stopPropagation(); 
              });
          })
      }
      if (elements.mostrarContraseña) {
          elements.mostrarContraseña.forEach((button, index) => {
              button.addEventListener("click", () => {
                  if (elements.inputContraseña && elements.inputContraseña[index]) {
                      let inputContraseña2 = elements.inputContraseña[index];
                      if (inputContraseña2.type === "password") {
                          inputContraseña2.type = "text";
                          button.classList.remove("bi-eye");
                          button.classList.add("bi-eye-slash");
                      } else {
                          inputContraseña2.type = "password";
                          button.classList.remove("bi-eye-slash");
                          button.classList.add("bi-eye");
                      }
                  }
              });
          });
      }
      if (elements.consulta) {
          elements.consulta.addEventListener("input", () => {
              if (elements.consulta.value !== "") {
                  elements.consulta.classList.add("tiene-contenido");
              } else {
                  elements.consulta.classList.remove("tiene-contenido");
              }
          });
      }
  };
  const formatCurrency = function(amount) {
    return new Intl.NumberFormat('es-AR', {
        style: 'currency',
        currency: 'ARS',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(amount);
};

  const initFlashMessage = function() {
      if (elements.mensajeFlash) {
          setTimeout(() => {
              elements.mensajeFlash.style.animation = "desvanecer 3s";
          }, 2000);
          
          elements.mensajeFlash.addEventListener("animationend", () => {
              elements.mensajeFlash.remove();
          });
      }
  };
document.addEventListener("click", function (event) {
    if(elements.popovers) {
        elements.popovers.forEach((popover) => {
            if (!popover.contains(event.target)) {
                popover.classList.add("d-none");
                popover.previousElementSibling.classList.remove("active");
            }
        });
    }
});
  document.addEventListener("DOMContentLoaded", () => {
    const toastMessage = localStorage.getItem('toastMessage');
        if(toastMessage){
            agregarToast(JSON.parse(toastMessage));
            localStorage.removeItem('toastMessage');
        }
      initFlashMessage();
      initCarousels();
      rangeSliderFunctions.initRangeSlider();
  });
  const debounce = (callback, wait) => {
    let timerId;
    return (...args) => {
      clearTimeout(timerId);
      timerId = setTimeout(() => {
        callback(...args);
      }, wait);
    };
  }

  const renderizarPaginacion = (paginacion, callback) => {
    const paginationContainer = document.querySelector('#indicadoresPaginacion');
        let html = `<button data-page="1" class="btn-indicador-paginacion mb-0" ${paginacion.page == 1 ? 'disabled': ''}>
                        <i class="bi bi-chevron-double-left"></i>
                    </button>
                    <button data-page="${paginacion.page - 1}" class="btn-indicador-paginacion mb-0" ${paginacion.page == 1 ? 'disabled': ''}>
                        <i class="bi bi-chevron-left"></i>
                    </button>`
        for (let i = 1; i <= paginacion.totalPages; i++) {
            html += `<button class="btn-indicador-paginacion mb-0 ${i == paginacion.page ? 'active' : ''}" data-page="${i}">
                    ${i}
                </button>`;
        }

        html += `<button data-page="${paginacion.page + 1}" class="btn-indicador-paginacion mb-0" ${paginacion.page == paginacion.totalPages ? 'disabled': ''}>
                    <i class="bi bi-chevron-right"></i>
                </button>
                <button data-page="${paginacion.totalPages}" class="btn-indicador-paginacion mb-0" ${paginacion.page == paginacion.totalPages ? 'disabled': ''}>
                    <i class="bi bi-chevron-double-right"></i>
                </button>`
        paginationContainer.innerHTML = html;

        document.querySelectorAll('#indicadoresPaginacion button').forEach(btn => {
            btn.addEventListener('click', () => {
                callback(btn.getAttribute('data-page'));
            });
        });
  }
  setupEventListeners();
  
  const animarLabelSelect = (input) => {
      if (!input) return;
      
      if (input.value !== "") {
          input.classList.add("tiene-contenido");
      } else {
          input.classList.remove("tiene-contenido");
      }
  };



// Event listener para detectar click en los toasts
elements.contenedorToast?.addEventListener('click', (e) => {
    if(elements.contenedorToast){
        const toastId = e.target.closest('div.toastp').id;
    
        if (e.target.closest('button.btn-cerrar')) {
            cerrarToast(toastId);
        }
    }
});

// Función para cerrar el toast
const cerrarToast = (id) => {
	document.getElementById(id)?.classList.add('cerrando');
};

// Función para agregar la clase de cerrando al toast.
const agregarToast = ({ tipo, titulo, descripcion, autoCierre }) => {
	// Crear el nuevo toast
	const nuevoToast = document.createElement('div');

	// Agregar clases correspondientes
	nuevoToast.classList.add('toastp');
	nuevoToast.classList.add(tipo);
	if (autoCierre) nuevoToast.classList.add('autoCierre');

	// Agregar id del toast
	const numeroAlAzar = Math.floor(Math.random() * 100);
	const fecha = Date.now();
	const toastId = fecha + numeroAlAzar;
	nuevoToast.id = toastId;

	// Iconos
	const iconos = {
		exito: `<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
					<path
						d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z"
					/>
				</svg>`,
		error: `<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
								<path
									d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zM8 4c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995A.905.905 0 0 1 8 4zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"
								/>
							</svg>`,
		info: `<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
								<path
									d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"
								/>
							</svg>`,
		warning: `<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
								<path
									d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"
								/>
							</svg>`,
	};

	// Plantilla del toast
	const toast = `
		<div class="contenido">
			<div class="icono">
				${iconos[tipo]}
			</div>
			<div class="texto">
				<p class="titulo">${titulo}</p>
				<p class="descripcion">${descripcion}</p>
			</div>
		</div>
		<button class="btn-cerrar">
			<div class="icono">
				<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
					<path
						d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"
					/>
				</svg>
			</div>
		</button>
	`;

	// Agregar la plantilla al nuevo toast
	nuevoToast.innerHTML = toast;

	// Agregamos el nuevo toast al contenedor
	elements.contenedorToast.appendChild(nuevoToast);

	// Función para menajera el cierre del toast
	const handleAnimacionCierre = (e) => {
		if (e.animationName === 'cierre') {
			nuevoToast.removeEventListener('animationend', handleAnimacionCierre);
			nuevoToast.remove();
		}
	};

	if (autoCierre) {
		setTimeout(() => cerrarToast(toastId), 5000);
	}

	// Agregamos event listener para detectar cuando termine la animación
	nuevoToast.addEventListener('animationend', handleAnimacionCierre);
};