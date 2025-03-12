import { formatCurrency, parseCurrency } from './utils.js';

const elements = {
    precioTotal: document.getElementById("precio-total"),
    inputCantidad: document.getElementById("cantidad-producto"),
    contenidoCarrito: document.getElementById("contenido-carrito"),
};

export const cartFunctions = {
    cambiarPrecio: function(etiqueta, precio, input) {
        if (!etiqueta || !precio || !input) return;
        etiqueta.textContent = formatCurrency(precio * input.value);
    },

    actualizarPreciosCarrito: function(inputProducto) {
        const contenedorProducto = inputProducto.closest(".contenedor-producto");
        const etiquetaPrecio = contenedorProducto.querySelector(".precio-producto");
        const precio = etiquetaPrecio.getAttribute("data-precio");
        this.cambiarPrecio(etiquetaPrecio, precio, inputProducto);
        this.actualizarTotal();
    },
    disminuirCantidad: function() {
        if(elements.inputCantidad.value > 1){
            elements.inputCantidad.value = parseInt(elements.inputCantidad.value) - 1;
        }
    },
    aumentarCantidad: function() {
        elements.inputCantidad.value = parseInt(elements.inputCantidad.value) + 1;
    },
    actualizarTotal: function() {
        if (!elements.precioTotal) return;
        let total = 0;
        const preciosProductos = document.querySelectorAll(".precio-producto");

        preciosProductos.forEach((producto) => {
            if(producto.textContent.includes("$")){
                total += parseCurrency(producto.textContent);
            }else{
                total += parseFloat(producto.textContent);
            }
        });
        elements.precioTotal.textContent = formatCurrency(total);
    },
    actualizarCantidad: function(buttonProduct, cantidad) {
        const idProducto = parseInt(buttonProduct.getAttribute("data-id"));
        const inputElement = document.getElementById(`input-producto-${idProducto}`);
        if(cantidad < 1 && parseInt(inputElement.value) <= 1) return;
        fetch('http://localhost/Proyecto_Coronel_Juan/productos/agregarcarrito', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest',
              },
              body: `id=${encodeURIComponent(idProducto)}&cantidad=${encodeURIComponent(cantidad)}`
          })
            .then(response => response.json())
            .then(data => {
              if(data.status === 'success') {
                inputElement.value = parseInt(inputElement.value) + cantidad;
                cartFunctions.actualizarPreciosCarrito(inputElement);          
              }
            })
    },
    eliminarProducto: function(idProducto) {
        const inputElement = document.getElementById(`input-producto-${idProducto}`);
        fetch('http://localhost/Proyecto_Coronel_Juan/eliminar-producto-carrito', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest',
              },
              body: `id=${encodeURIComponent(idProducto)}`
          })
            .then(response => response.json())
            .then(data => {
              if(data.status === 'success') {
                inputElement.closest(".contenedor-producto").remove();
                elements.contenidoCarrito.textContent = parseInt(elements.contenidoCarrito.textContent) - 1;
                cartFunctions.actualizarTotal();
                const listaProductos = document.querySelector('.lista-productos');
                if(listaProductos.childElementCount === 0){
                    listaProductos.innerHTML =`
                   <div class="text-center d-flex flex-column my-auto h-100">
                      <span data-icon="tabler:shopping-cart"
                      class="iconify position-relative mx-auto text-black fs-1 d-block mt-4 mb-3"></span>
                      <span class="fw-semibold text-medium">El carrito está vacío</span>
                      <a class="login-text mt-4 mx-auto" href=" <?php echo base_url('colecciones/todos-los-productos') ?>">Seguir comprando</a>
                  </div>
                `;
                }
              }
            })
    }
};

window.cartFunctions = cartFunctions;
document.addEventListener("DOMContentLoaded", () => {
    cartFunctions.actualizarTotal();
});