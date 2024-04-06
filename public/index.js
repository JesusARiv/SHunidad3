var table;

var listar = function () {
    table = $("#tablaProductos").DataTable({
        serverSide: true,
        processing: true,
        searching: true,
        ajax: {
            url: 'tabla_productos',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            },
        },
        columns: [
            { data: 'producto' },
            { data: 'descripcion' },
            { data: 'precio' },
            { data: 'cantidad' },
            {
                data: 'id',
                render: function (d) {
                    return `
                    <button class="btn btn-warning" onclick="editar(${d});" title="Editar"><i class="fa-solid fa-pen-to-square"></i></button>
                    <button class="btn btn-danger" onclick="eliminar(${d});" title="Eliminar"><i class="far fa-trash-can"></i></button>`;
                }
            }
        ]
    });
};

$(document).ready(function () {
    listar();
});

const editar = async (id) => {
    event.preventDefault();
    // spinner de esperar
    Swal.fire({
        title: 'Cargando datos',
        text: 'Espera un momento por favor...',
        allowOutsideClick: false,
        allosEscapeKey: false,
        allosEnterKey: false,
        didOpen: () => Swal.showLoading()
    });

    let url = 'cargar_producto';
    let formData = new FormData();
    formData.append('id', id);

    // Obtener el token CSRF del formulario
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    // Agregar el token CSRF al cuerpo de la solicitud
    formData.append('_token', csrfToken);
    try {
        const init = {
            method: 'POST',
            body: formData,
        };

        const req = await fetch(url, init);

        if (req.ok) {
            const responseData = await req.json();
            // Llenar los campos del formulario con los datos recibidos
            document.getElementById('producto_id').value = responseData.id;
            document.getElementById('producto').value = responseData.producto;
            document.getElementById('descripcion').value = responseData.descripcion;
            document.getElementById('precio').value = responseData.precio;
            document.getElementById('cantidad').value = responseData.cantidad;
            // Detener el spinner
            Swal.close();
        } else {
            // Capturar errores específicos del servidor, si los hay
            const responseData = await req.json();
            const errorMessage = responseData.message || 'Error en la solicitud';
            Swal.fire({
                icon: 'error',
                text: errorMessage
            });
        }
    } catch (error) {
        // Capturar errores de red u otros errores no esperados
        Swal.fire({
            icon: 'error',
            text: 'Error en la solicitud: ' + error.message
        });
    }
}

const eliminar = async (id) => {
    event.preventDefault();
    // spinner de esperar
    Swal.fire({
        title: 'Eliminando',
        text: 'Espera un momento por favor...',
        allowOutsideClick: false,
        allosEscapeKey: false,
        allosEnterKey: false,
        didOpen: () => Swal.showLoading()
    });

    let url = 'eliminar_producto';
    let formData = new FormData();
    formData.append('id', id);

    // Obtener el token CSRF del formulario
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    // Agregar el token CSRF al cuerpo de la solicitud
    formData.append('_token', csrfToken);
    try {
        const init = {
            method: 'POST',
            body: formData,
        };

        const req = await fetch(url, init);

        if (req.ok) {
            const responseData = await req.json();
            Swal.fire({
                icon: 'success',
                text: responseData.message,
                confirmButtonText: "Aceptar",
            }).then((result) => {
                if (result.isConfirmed) {
                    event.preventDefault();
                    productoForm.reset();
                    table.ajax.reload();
                }
            });
        } else {
            // Capturar errores específicos del servidor, si los hay
            const responseData = await req.json();
            const errorMessage = responseData.message || 'Error en la solicitud';
            Swal.fire({
                icon: 'error',
                text: errorMessage
            });
        }
    } catch (error) {
        // Capturar errores de red u otros errores no esperados
        Swal.fire({
            icon: 'error',
            text: 'Error en la solicitud: ' + error.message
        });
    }
}


// Agrega un evento de escucha al formulario para capturar la respuesta JSON
$('form').on('submit', async function (e) {
    e.preventDefault();
    // spinner de esperar
    Swal.fire({
        title: 'Registrando',
        text: 'Espera un momento por favor...',
        allowOutsideClick: false,
        allosEscapeKey: false,
        allosEnterKey: false,
        didOpen: () => Swal.showLoading()
    });

    let producto_id = document.getElementById('producto_id').value;
    // Info para realizar solicitud
    let url = 'registrar_producto';
    let form = document.getElementById('productoForm');
    let formData = new FormData(form);
    if (producto_id) {
        url = 'editar_producto';
        formData.append('id', producto_id)
    }
    try {
        const init = {
            method: 'POST',
            body: formData,
        };

        const req = await fetch(url, init);

        if (req.ok) {
            const responseData = await req.json();
            Swal.fire({
                icon: 'success',
                text: responseData.message,
                confirmButtonText: "Aceptar",
            }).then((result) => {
                if (result.isConfirmed) {
                    event.preventDefault();
                    productoForm.reset();
                    table.ajax.reload();
                }
            });
        } else {
            // Capturar errores específicos del servidor, si los hay
            const responseData = await req.json();
            const errorMessage = responseData.message || 'Error en la solicitud';
            Swal.fire({
                icon: 'error',
                text: errorMessage
            });
        }
    } catch (error) {
        // Capturar errores de red u otros errores no esperados
        Swal.fire({
            icon: 'error',
            text: 'Error en la solicitud: ' + error.message
        });
    }
});
