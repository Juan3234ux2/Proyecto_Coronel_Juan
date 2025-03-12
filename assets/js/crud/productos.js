
    const d = document;
    const tableBody = d.querySelector('tbody');
    const loader = d.getElementById('table-loading');
    const loaderBtn = d.querySelector('.loader-btn');
    const modalDelete = d.querySelector('#modalEliminar');
    const searchInput = d.getElementById('buscador');
    const perPageInput = d.getElementById('porPagina');
    const btnSave = d.getElementById('btn-guardar');
    let inputCaracteristicas;
    let inputDescripcion;
    let idProducto;
    const API = {
        base: `http://localhost/Proyecto_Coronel_Juan/dashboard/productos`,
        list: '/listar',
        add: '/insertar',
        update: '/actualizar',
        delete: '/eliminar'
    };
    const mostrarFeedback = (mensaje) => {
        alert(mensaje); 
    };


    const validarFormulario = () => {
        const nombre = inputNombre.value.trim();
        if (!nombre) {
            mostrarFeedback('El nombre de la categoría es requerido', true);
            return false;
        }
        return true;
    };

    const onSubmit = async (formData) => {
        try {
            loaderBtn.classList.remove('d-none');
            btnSave.setAttribute('disabled', true); 
            const response = await fetch(`${API.base}${API.add}`, {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            
            if (data.status === 'success') {
                localStorage.setItem('toastMessage', JSON.stringify({ tipo: 'exito', titulo: 'Éxito', descripcion: 'Operación realizada con éxito', autoCierre: true }));
                location.href = data.redirect;
            } 
            
        } catch (error) {
            console.log(error);
        }finally{
            loaderBtn.classList.add('d-none');
            btnSave.removeAttribute('disabled');
        }
    };

    d.getElementById('form-producto')?.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        formData.append('descripcion', inputDescripcion.root.innerHTML);
        formData.append('caracteristicas', inputCaracteristicas.root.innerHTML);
        onSubmit(formData)
    });
    const deleteProduct = async () => {
        try {
            const response = await fetch(`${API.base}${API.delete}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ 'id': idProducto })
            });
            
            const data = await response.json();
            
            if (data.status === 'success') {           
                fetchProducts();
                bootstrap.Modal.getInstance(modalDelete).hide();
                agregarToast({ tipo: 'exito', titulo: 'Éxito', descripcion: 'Operación realizada con éxito', autoCierre: true });
            } else {
                agregarToast({ tipo: 'error', titulo: 'Error', descripcion: 'Intente nuevamente', autoCierre: true });
            }
        } catch (error) {
            agregarToast({ tipo: 'error', titulo: 'Error', descripcion: 'Intente nuevamente', autoCierre: true });
        }
    };

    const fetchProducts = (pagina = 1,busqueda = "") => {
        loader.classList.remove('d-none');
        const porPagina = perPageInput.value;
        setTimeout(async() => {
            try {
                const response = await fetch(`${API.base}${API.list}?search=${busqueda}&page=${pagina}&perPage=${porPagina}`);
                const data = await response.json();
                renderizarPaginacion(data.pagination, fetchProducts);
                renderProducts(data.items);
            } catch (error) {
                console.log(error);
                agregarToast({ tipo: 'error', titulo: 'Error', descripcion: 'Error al cargar los productos', autoCierre: true });
                tableBody.innerHTML = `<tr><td colspan="6">Error al cargar los productos .</td></tr>`;
            } finally {
                loader.classList.add('d-none');
            }
        },200)
    }

    const renderProducts = (coleccion) => {
        if (coleccion.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="6">No hay productos disponibles.</td></tr>`;
            return;
        }
        
        const html = coleccion.map(product => `
            <tr id="${product.id}">
                    <td>${product.nombre}</td>
                    <td>${product.nombre_categoria} </td>
                    <td>${product.nombre_marca} </td>
                    <td>
                        <div class="d-flex align-products-center gap-2 justify-content-end">
                            <a class="rounded-btn"
                                href="${API.base}/editar/${product.id}">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <button type="button" class="rounded-btn open-delete-modal" data-bs-toggle="modal" data-bs-target="#modalEliminar" data-id="${product.id}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>`
        ).join('');
        tableBody.innerHTML = html;
        document.querySelectorAll('.open-delete-modal').forEach(btn => {
            btn.addEventListener('click', () => {
                idProducto = btn.getAttribute('data-id');
            });
        })
    };
    
    const init = () => {
        if(btnSave)
        {
            inputDescripcion = new Quill('#descripcion-producto', {
                theme: 'snow',
                modules: {
                    toolbar: toolbarOptions
                },
                placeholder: "Ingrese la descripción del producto"
            });
            inputCaracteristicas = new Quill('#caracteristicas-producto', {
                theme: 'snow',
                placeholder: "Ingrese las caracteristicas del producto",
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'list': 'bullet' }],
                        [{ 'script': 'super' }],
                    ]
                }
            });
            
        }else{
            fetchProducts();
            perPageInput.addEventListener('change', () => {
                searchInput.value = '';
                fetchProducts(1);
            })
            searchInput.addEventListener('input', debounce(() => {
                const busqueda = searchInput.value.trim();
                fetchProducts(1,busqueda);
            }, 300));
        }
    };

    d.addEventListener('DOMContentLoaded', init);
