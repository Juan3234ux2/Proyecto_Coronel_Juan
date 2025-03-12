const crearCrud = (entidad) => {
    const d = document;
    const modalFormTitle = d.getElementById(`modal-${entidad}-form-label`);
    const tableBody = d.querySelector('tbody');
    const loader = d.getElementById('table-loading');
    const loaderBtn = d.querySelector('.loader-btn');
    const btnSave = d.querySelector('#btn-guardar');
    const modalForm = d.querySelector(`#modal-${entidad}-form`);
    const modalDelete = d.querySelector('#modalEliminar');
    const searchInput = d.getElementById('buscador');
    const perPageInput = d.getElementById('porPagina');
    const inputNombre = d.getElementById('nombre');
    let idEntidad;

    const API = {
        base: `http://localhost/Proyecto_Coronel_Juan/dashboard/${entidad}`,
        list: '/listar',
        add: '/insertar',
        update: '/actualizar',
        delete: '/eliminar',
        restore: '/activar'
    };

    const singular = entidad.slice(-2) == "es" ? entidad.slice(0, 1).toUpperCase() + entidad.slice(1, -2) : entidad.slice(0, 1).toUpperCase() + entidad.slice(1, -1);
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

    const onSubmit = async () => {
        try {
            loaderBtn.classList.remove('d-none');
            btnSave.setAttribute('disabled', true); 
            const nombre = inputNombre.value.trim();
            const esModoEditar = idEntidad ? true : false;
            const response = await fetch(`${API.base}${esModoEditar ? API.update : API.add}`, {
                method: esModoEditar ? 'PUT' : 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ 'nombre': nombre, 'id': idEntidad })
            });
            
            const data = await response.json();
            
            if (data.status === 'success') {
                bootstrap.Modal.getInstance(modalForm).hide();
                fetchItems();
                agregarToast({ tipo: 'exito', titulo: 'Éxito', descripcion: `Operación realizada con éxito`, autoCierre: true });
                searchInput.value = '';
            } else {
                agregarToast({ tipo: 'error', titulo: 'Error', descripcion: 'Intente nuevamente', autoCierre: true });
            }
        } catch (error) {
            agregarToast({ tipo: 'error', titulo: 'Error', descripcion: 'Intente nuevamente', autoCierre: true });
        }finally{
            loaderBtn.classList.add('d-none');
            btnSave.removeAttribute('disabled');
        }
    };


    const deleteItem = async () => {
        try {
            const response = await fetch(`${API.base}${API.delete}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ 'id': idEntidad })
            });
            
            const data = await response.json();
            
            if (data.status === 'success') {           
                fetchItems();
                bootstrap.Modal.getInstance(modalDelete).hide();
                agregarToast({ tipo: 'exito', titulo: 'Éxito', descripcion: 'Operación realizada con éxito', autoCierre: true });
            } else {
                agregarToast({ tipo: 'error', titulo: 'Error', descripcion: 'Intente nuevamente', autoCierre: true });
            }
        } catch (error) {
            agregarToast({ tipo: 'error', titulo: 'Error', descripcion: 'Intente nuevamente', autoCierre: true });
        }
    };
    const restoreItem = async (idItem) => {
        try {
            const response = await fetch(`${API.base}${API.restore}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ 'id': idItem })
            });
            
            const data = await response.json();
            
            if (data.status === 'success') {  
                localStorage.setItem('toastMessage', JSON.stringify({ tipo: 'exito', titulo: 'Éxito', descripcion: 'Operación realizada con éxito', autoCierre: true }));         
                location.href = data.redirect;
            } else {
                agregarToast({ tipo: 'error', titulo: 'Error', descripcion: 'Intente nuevamente', autoCierre: true });
            }
        } catch (error) {
            agregarToast({ tipo: 'error', titulo: 'Error', descripcion: 'Intente nuevamente', autoCierre: true });
        }
    };
    const fetchItems = (pagina = 1,busqueda = "") => {
        loader.classList.remove('d-none');
        const porPagina = perPageInput.value;
        setTimeout(async() => {
            try {
                const response = await fetch(`${API.base}${API.list}?search=${busqueda}&page=${pagina}&perPage=${porPagina}`);
                const data = await response.json();
                renderizarPaginacion(data.pagination, fetchItems);
                renderItems(data.items);
            } catch (error) {
                agregarToast({ tipo: 'error', titulo: 'Error', descripcion: 'Error al cargar los elementos', autoCierre: true });
                tableBody.innerHTML = `<tr><td colspan="2">Error al cargar ${entidad} .</td></tr>`;
            } finally {
                loader.classList.add('d-none');
            }
        },200)
    }
    
    const renderItems = (coleccion) => {
        if (coleccion.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="2">No hay ${entidad} disponibles.</td></tr>`;
            return;
        }
        
        const html = coleccion.map(item => `
            <tr>
                <td>${item.nombre}</td>
                <td class="text-end">
                    <div class="d-flex gap-2 align-items-center justify-content-end">
                        <button class="rounded-btn open-edit-modal" data-bs-toggle="modal" data-bs-target="#modal-${entidad}-form" data-id="${item.id}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#modalEliminar" class="rounded-btn open-delete-modal" data-id="${item.id}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>`
        ).join('');
        
        tableBody.innerHTML = html;
        addEventListeners();
    };
    

  const addEventListeners = () => {
      d.querySelectorAll('.open-delete-modal').forEach(btn => {
          btn.addEventListener('click', () => {
              idEntidad = btn.getAttribute('data-id');
          });
      });
      
      d.querySelectorAll('.open-edit-modal').forEach(btn => {
          btn.addEventListener('click', () => {
              modalFormTitle.textContent = `Editar ${singular}`;
              idEntidad = btn.getAttribute('data-id');
              const nombre = btn.closest('tr').querySelector('td:first-child').textContent;
              inputNombre.value = nombre;
          });
      });
}

    const init = () => {
        if(searchInput){
            fetchItems();
            
            // Resetear formulario al cerrar el modal
            modalForm.addEventListener('hidden.bs.modal', () => {
                inputNombre.value = '';
            });
            
            d.getElementById('btn-agregar').addEventListener('click', () => {
                modalFormTitle.textContent = `Agregar ${singular}`;
                idEntidad = null;
            });
            
            perPageInput.addEventListener('change', () => {
                searchInput.value = '';
                fetchItems();
            })
            searchInput.addEventListener('input', debounce(() => {
                const busqueda = searchInput.value.trim();
                fetchItems(1,busqueda);
            }, 300));
        }
        window.restoreItem = restoreItem;
        window.onSubmit = onSubmit;
        window.deleteItem = deleteItem;
    };

    d.addEventListener('DOMContentLoaded', init);
};