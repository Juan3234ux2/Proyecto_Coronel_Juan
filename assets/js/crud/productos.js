import zod from 'https://cdn.jsdelivr.net/npm/zod@3.24.2/+esm'
    const d = document;
    const tableBody = d.querySelector('tbody');
    const loader = d.getElementById('table-loading');
    const loaderBtn = d.querySelector('.loader-btn');
    const modalDelete = d.querySelector('#modalEliminar');
    const searchInput = d.getElementById('buscador');
    const perPageInput = d.getElementById('porPagina');
    const btnSave = d.getElementById('btn-guardar');
    const btnAddVariant = d.getElementById('agregar-presentacion');
    const container = d.getElementById('contenedor-presentaciones');
    const inputIdProduct = d.getElementById('idProducto');
    let inputCaracteristicas;
    let inputDescripcion;
    let variantIndex = 0;
    let idProducto;
    const isUpdate = inputIdProduct ? true : false;
    const API = {
        base: `http://localhost/Proyecto_Coronel_Juan/dashboard/productos`,
        list: '/listar',
        add: '/insertar',
        update: '/actualizar',
        delete: '/eliminar',
    };

    const presentacionSchema = zod.object({
        stock: zod.preprocess((val) => Number(val), zod.number().min(0.01, 'El stock debe ser mayor que 0')),
        sabor: zod.string(
            {
                required_error: "El sabor es requerido",
                invalid_type_error: "El sabor es requerido",
            }
        ),
        precio_venta: zod.preprocess((val) => Number(val), zod.number().min(0.01, 'El precio de venta debe ser mayor a 0')),
        precio_compra: zod.preprocess((val) => Number(val), zod.number().min(0.01, 'El precio de compra debe ser mayor a 0')),
        tamanio: zod.preprocess((val) => Number(val), zod.number().min(0.01, 'El tamaño debe ser mayor que 0')),
        imagenes: zod.array(
            zod.custom((file) => {
                const formatosPermitidos = ["image/jpeg", "image/png", "image/jpg", "image/webp"];
                const maxSize = 2 * 1024 * 1024;
                return file instanceof File && formatosPermitidos.includes(file.type) && file.size <= maxSize;
            }, { message: "Cada imagen debe ser JPG/PNG y no superar 2MB." })
        ).min(1, "Debe subir al menos una imagen"),
    });

    const productoSchema = zod.object({
        nombre: zod.string().min(1, 'El nombre es requerido'),
        marca: zod.string(
            {
            required_error: "La marca es requerida",
            invalid_type_error: "La marca es requerida",
          }),
        categoria: zod.string({
            required_error: "La categoria es requerida",
            invalid_type_error: "La categoria es requerida",
          }),
        descripcion: zod.string().min(1, 'La descripción es requerida'),
        caracteristicas: zod.string().min(1, 'Las características son requeridas'),
        presentaciones: zod.array(presentacionSchema)
    });

    const mostrarErrores = (errors, name = null) => {
        errors.forEach(error => {
            let path;
            //Errores de los datos del producto
            if(error.path.length <= 1){
                path = name ? name : error.path[0];
            }else{
                path = `${error.path[0]}[${error.path[1] + 1}][${error.path[2]}]${error.path[2] == 'imagenes' ? `[]` : ''}`; // Errores de las presentaciones
            }
            const isRichText = path === 'descripcion' || path === 'caracteristicas';  
            let inputElement = isRichText ? d.getElementById(path) : d.querySelector(`[name="${path}"]`);
            if (inputElement) { 
                inputElement.parentElement.querySelector('.errorMessageValidation').textContent = error.message;
            }
        });
    }

    const validarCampo = (event, isPresentation = false) => {
        console.log(event);
        const fieldName = event.target.name;
        let value = event.target.value;
        if (event.target.type === "file") {
            value = Array.from(event.target.files);
        }
        const fieldSchema = isPresentation ? presentacionSchema.shape[fieldName.split('[')[2].replace(']', '')] : productoSchema.shape[fieldName];
        if (fieldSchema) {
            try {
                fieldSchema.parse(value);
                console.log(value)
                event.target.parentElement.querySelector('.errorMessageValidation').textContent = '';
            } catch (error) {
                mostrarErrores(error.errors, fieldName);
            }
        }
    }
    const validarRichText = (fieldName, value) => {
        const fieldSchema = productoSchema.shape[fieldName];
        value = value.replace('<p><br></p>', '');
        if (fieldSchema) {
            try {
                fieldSchema.parse(value);
                d.getElementById(fieldName).nextElementSibling.textContent = '';
            } catch (error) {
                mostrarErrores(error.errors, fieldName);
            }
        }
    }
    const obtenerPresentaciones = () => {
        const presentaciones = [];
        d.querySelectorAll('.presentacion-row').forEach((row, index) => {
            const stock = row.querySelector(`[name="presentaciones[${index + 1}][stock]"]`).value;
            const sabor = row.querySelector(`[name="presentaciones[${index + 1}][sabor]"]`).value;
            const precioVenta = row.querySelector(`[name="presentaciones[${index + 1}][precio_venta]"]`).value;
            const precioCompra = row.querySelector(`[name="presentaciones[${index + 1}][precio_compra]"]`).value;
            const tamaño = row.querySelector(`[name="presentaciones[${index + 1}][tamanio]"]`).value;
            const imagenes = Array.from(row.querySelectorAll(`[name="presentaciones[${index + 1}][imagenes][]"]`)[0].files);
            presentaciones.push({ 
                stock,
                sabor: sabor === 'No hay sabores disponibles.' ? null : sabor,
                precio_venta: precioVenta, 
                precio_compra: precioCompra, 
                tamanio: tamaño,
                imagenes
            });
        })
        return presentaciones;
    }
    const onSubmit = async (formData) => {
        try {
            loaderBtn.classList.remove('d-none');
            btnSave.setAttribute('disabled', true);

            const data = {
                nombre: formData.get('nombre'),
                marca: formData.get('marca'),
                categoria: formData.get('categoria'),
                descripcion: inputDescripcion.root.innerHTML.replace('<p><br></p>', ''),
                caracteristicas: inputCaracteristicas.root.innerHTML.replace('<p><br></p>', ''),
                presentaciones: obtenerPresentaciones(),
                id: isUpdate ? formData.get('id') : null
            };
            productoSchema.parse(data);
            data.caracteristicas = inputCaracteristicas.root.innerHTML.replace('<p><br></p>', '<br>');
            data.descripcion = inputDescripcion.root.innerHTML.replace('<p><br></p>', 'hola');
            
            const response = await fetch(`${API.base}${isUpdate ? API.update : API.add}`, {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.status === 'success') {
                localStorage.setItem('toastMessage', JSON.stringify({ tipo: 'exito', titulo: 'Éxito', descripcion: 'Operación realizada con éxito', autoCierre: true }));
                location.href = result.redirect;
            }

        } catch (error) {
            if (error.errors) {
                window.scrollTo(0, 0);
                mostrarErrores(error.errors);
            }
        } finally {
            loaderBtn.classList.add('d-none');
            btnSave.removeAttribute('disabled');
        }
    };

    d.getElementById('form-producto')?.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        formData.append('descripcion', inputDescripcion.root.innerHTML);
        formData.append('caracteristicas', inputCaracteristicas.root.innerHTML);
        onSubmit(formData);
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
                agregarToast({ tipo: 'exito', titulo: 'Éxito', descripcion: 'Operación realizada con éxito', autoCierre: true });
            } else {
                agregarToast({ tipo: 'error', titulo: 'Error', descripcion: 'Intente nuevamente', autoCierre: true });
            }
        } catch (error) {
            agregarToast({ tipo: 'error', titulo: 'Error', descripcion: 'Intente nuevamente', autoCierre: true });
        }
    };

    const fetchProducts = (pagina = 1, busqueda = "") => {
        loader.classList.remove('d-none');
        const porPagina = perPageInput.value;

        setTimeout(async () => {
            try {
                const response = await fetch(`${API.base}${API.list}?search=${busqueda}&page=${pagina}&perPage=${porPagina}`);
                const data = await response.json();
                renderizarPaginacion(data.pagination, fetchProducts);
                renderProducts(data.items);
            } catch (error) {
                agregarToast({ tipo: 'error', titulo: 'Error', descripcion: 'Error al cargar los productos', autoCierre: true });
                tableBody.innerHTML = `<tr><td colspan="6">Error al cargar los productos.</td></tr>`;
            } finally {
                loader.classList.add('d-none');
            }
        }, 200);
    };

    const renderProducts = (coleccion) => {
        if (coleccion.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="6">No hay productos disponibles.</td></tr>`;
            return;
        }

        tableBody.innerHTML = coleccion.map(product => `
            <tr id="${product.id}">
                <td>${product.nombre}</td>
                <td>${product.nombre_categoria}</td>
                <td>${product.nombre_marca}</td>
                <td>
                    <div class="d-flex align-products-center gap-2 justify-content-end">
                        <a class="rounded-btn" href="${API.base}/presentaciones/${product.id}">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a class="rounded-btn" href="${API.base}/editar/${product.id}">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button type="button" class="rounded-btn open-delete-modal" data-bs-toggle="modal" data-bs-target="#modalEliminar" data-id="${product.id}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `).join('');

        d.querySelectorAll('.open-delete-modal').forEach(btn => {
            btn.addEventListener('click', () => {
                idProducto = btn.getAttribute('data-id');
            });
        });
    };

    btnAddVariant?.addEventListener('click', function () {
        variantIndex++;
        const template = d.getElementById('template-presentaciones');
        const clone = d.importNode(template.content, true);
        clone.querySelectorAll('select, input').forEach(element => {
            const name = element.getAttribute('name');
            if (name && name.includes('presentaciones[0]')) {
                element.setAttribute('name', name.replace('presentaciones[0]', `presentaciones[${variantIndex}]`));
            }
        });
        clone.querySelector('.variant-number').textContent = variantIndex;
        
        clone.querySelector('.presentacion-index').value = variantIndex;
        
        clone.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', (e) => {
                validarCampo(e, true);
            });
        });
        const fileInput = clone.querySelector('.imagen-input');
        const fileLabel = clone.querySelector('.imagen-label');
        const uniqueId = `imagen-${variantIndex}`;
        fileInput.id = uniqueId;
        fileLabel.setAttribute('for', uniqueId);
        fileInput.name = `presentaciones[${variantIndex}][imagenes][]`;
        fileInput.addEventListener('change', (e) => {
            validarCampo(e, true);
        })
        container.appendChild(clone);
        const tooltips = d.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltips.forEach(tooltip => new bootstrap.Tooltip(tooltip));
    });

    const eliminarPresentacion = (button) => {
        if (container.childElementCount > 1) {
            button.closest('.card-variants').remove();
            variantIndex--;
            container.querySelectorAll('.variant-number').forEach((element, index) => {
                element.textContent = index + 1;
            })
            container.querySelectorAll('.presentacion-index').forEach((element, index) => {
                element.value = index;
            })
        }
    }
    

    const init = () => {
        if (btnSave) {
            d.querySelectorAll('input, select').forEach(el => el.addEventListener('input', validarCampo));
            window.eliminarPresentacion = eliminarPresentacion;
            window.actualizarImagenProducto = actualizarImagenProducto;
            const toolbarOptions = [
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'header': 1 }, { 'header': 2 }],
                [{ 'list': 'ordered' }, { 'list': 'bullet' }, { 'list': 'check' }],
                [{ 'script': 'sub' }, { 'script': 'super' }],
                [{ 'indent': '-1' }, { 'indent': '+1' }],
        
                [{ 'size': ['small', false, 'large', 'huge'] }],
        
                [{ 'color': [] }, { 'background': [] }],
                [{ 'font': [] }],
                [{ 'align': [] }],
        
                ['clean']
            ];
            inputDescripcion = new Quill('#descripcion', { theme: 'snow' , modules: { toolbar: toolbarOptions } });
            inputCaracteristicas = new Quill('#caracteristicas', { theme: 'snow' });
            inputCaracteristicas.on('text-change', () => {
                validarRichText('caracteristicas', inputCaracteristicas.root.innerHTML);
            })
            inputDescripcion.on('text-change', () => {
                validarRichText('descripcion', inputDescripcion.root.innerHTML);
            })
            if(isUpdate) {
                inputCaracteristicas.root.innerHTML = producto.caracteristicas;
                inputDescripcion.root.innerHTML = producto.descripcion;
                producto.presentaciones.forEach((presentacion, index) => {
                    console.log(presentacion);
                    d.getElementById('agregar-presentacion').click();
                    d.querySelector(`[name="presentaciones[${index + 1}][index]"]`).value = presentacion.id;
                    d.querySelector(`[name="presentaciones[${index + 1}][stock]"]`).value = presentacion.stock;
                    d.querySelector(`[name="presentaciones[${index + 1}][sabor]"]`).value = presentacion.id_sabor;
                    d.querySelector(`[name="presentaciones[${index + 1}][precio_venta]"]`).value = presentacion.precio_venta;
                    d.querySelector(`[name="presentaciones[${index + 1}][precio_compra]"]`).value = presentacion.precio_compra;
                    d.querySelector(`[name="presentaciones[${index + 1}][tamanio]"]`).value = presentacion.contenido;
                    cargarImagenesDesdeBD(d.querySelector(`[name="presentaciones[${index + 1}][imagenes][]"]`), presentacion.imagenes);
                });
            }else{
                d.getElementById('agregar-presentacion').click();
            }
            return;
        } 
        fetchProducts();
    };
    const cargarImagenesDesdeBD = async (input, nombresImagenes) => {
        const previewContainer = input.closest('.d-flex').querySelector('.vista-previa-imagenes');
        previewContainer.innerHTML = '';
        const dataTransfer = new DataTransfer();
        
        let filesArray = [];
        
        nombresImagenes.forEach((nombre) => {
            const file = new File([""], nombre, { type: "image/png" });
            dataTransfer.items.add(file);
            filesArray.push(file);
        });
        
        input.files = dataTransfer.files;
        
        const actualizarVisualizacion = () => {
            previewContainer.innerHTML = '';
            

            filesArray.forEach((file, index) => {
                const imageContainer = d.createElement('div');
                imageContainer.classList.add('image-container');
                
                const image = new Image();
                image.classList.add('preview-image');
                image.src = `${BASE_URL}/assets/uploads/${file.name}`;
          
                const btnDelete = d.createElement("button");
                btnDelete.innerHTML = "×";
                btnDelete.classList.add("delete-img-btn");
                btnDelete.addEventListener("click", function () {
                    filesArray.splice(index, 1);
                    
                    const nuevoDataTransfer = new DataTransfer();
                    filesArray.forEach(f => nuevoDataTransfer.items.add(f));
                    input.files = nuevoDataTransfer.files;
                    
                    input.dispatchEvent(new Event('change', { bubbles: true }));
                    
                    actualizarVisualizacion();
                });
                
                imageContainer.appendChild(btnDelete);
                imageContainer.appendChild(image);
                previewContainer.appendChild(imageContainer);
            });
        };
        
        actualizarVisualizacion();
    };
    const actualizarImagenProducto = (input) => {
        const previewContainer = input.closest('.d-flex').querySelector('.vista-previa-imagenes');
        previewContainer.innerHTML = '';

        if (input.files && input.files.length > 0) {
            const filesArray = Array.from(input.files);
            const newFileList = new DataTransfer();

            filesArray.forEach((file, index) => {
                const reader = new FileReader();
                const imageContainer = d.createElement('div');
                imageContainer.classList.add('image-container');

                reader.onload = function (e) {
                    const image = new Image();
                    image.classList.add('preview-image');
                    image.src = e.target.result;

                    const btnDelete = d.createElement("button");
                    btnDelete.innerHTML = "×";
                    btnDelete.classList.add("delete-img-btn");

                    btnDelete.addEventListener("click", function () {
                        imageContainer.remove();
                        filesArray.splice(index, 1);
                        newFileList.items.clear();
                        filesArray.forEach(f => newFileList.items.add(f));
                        input.files = newFileList.files;
                        input.dispatchEvent(new Event('change', { bubbles: true }));;
                    });

                    imageContainer.appendChild(btnDelete);
                    imageContainer.appendChild(image);
                    previewContainer.appendChild(imageContainer);
                };

                reader.readAsDataURL(file);
                newFileList.items.add(file);
            });

            input.files = newFileList.files;
        }
    }
    d.addEventListener('DOMContentLoaded', init);
    
    