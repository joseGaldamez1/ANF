{{-- resources/views/menu.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleados</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @vite(['resources/css/custom/menu.css'])
    @vite(['resources/css/custom/tablas.css'])
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>

<body>
    <input type="checkbox" name="checkMenu" id="checkMenu">
    <label for="checkMenu" class="labelBotonMenu">
        <i class="fa fa-navicon" id="btnMostrar"></i>
    </label>

    <section class="sidebar">
        <header>
            <div class="logo">
                <img src="{{ asset('img/logo.png') }}" alt="logo2">
            </div>
            <div class="titulo">Análisis financiero</div>

        </header>
        <ul>
            <li><a href="/inicio"><i class="fa fa-home"></i>Inicio</a></li>
            <li><a href="/puestosTrabajo"><i class="fa fa-shopping-bag"></i>Puestos de trabajo</a></li>
            <li><a href="/empleados"><i class="fa fa-calendar"></i>Empleados</a></li>
            <li><a href="/planilla"><i class="fa fa-link"></i>Planilla</a></li>
            <li><a href="/reportes"><i class="fa fa-cog"></i>Reportes</a></li>
            <li><a href="/ayuda"><i class="fa fa-question-circle-o"></i>Ayuda</a></li>
        </ul>
    </section>
    <?php
    /*<style>
    .fondoMenu {
        background-image: url('@php echo asset("img/fondoMenu.jpg"); @endphp');
        background-size: cover;
    }
</style>*/
    ?>
    <section class="container fondoMenu">
        <h1 style="text-align: center">Empleados</h1>
        <br>
        <button id="btnAdd" style="display: block; margin: 0 auto" onclick="openAddModal()">Agregar empleado</button>
        <br><br>
        <table
            id="puestosTable"
            class="table table-striped table-bordered table-hover table-condensed table-responsive"
            style="width:80%; font-size: 13px">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Nombres</th>
                    <th>Correo</th>
                    <th>Telefono</th>
                    <th>Dirección</th>
                    <th>Puesto de trabajo</th>
                    <th>Fecha de ingreso</th>
                    <th>Salario</th>
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </section>

    <div id="addEmpleadoModal" class="modal" style="display: none;">
        <div class="modal-content">
            <h2>Agregar Empleado</h2>
            <input type="hidden" id="modalEmpleadoId">
            <input type="text" id="modalNombre1" placeholder="Ingrese el primer nombre" required>
            <input type="text" id="modalNombre2" placeholder="Ingrese el segundo nombre">
            <input type="text" id="modalApellido1" placeholder="Ingrese el primer apellido" required>
            <input type="text" id="modalApellido2" placeholder="Ingrese el segundo apellido">
            <input type="text" id="modalApellidoCasada" placeholder="Apellido de casada (opcional)">
            <input type="text" id="modalNumeroDocumento" placeholder="Ingrese el número de documento" required>
            <input type="text" id="modalNumeroAfiliado" placeholder="Ingrese el número de afiliado">
            <input type="text" id="modalDireccion" placeholder="Ingrese la dirección">
            <input type="text" id="modalTelefono" placeholder="Ingrese el teléfono">
            <input type="email" id="modalCorreo" placeholder="Ingrese el correo electrónico" required>
            <input type="number" id="modalSalario" placeholder="Ingrese el salario" required>
            <input type="date" id="modalFechaIngreso" placeholder="Selecciomne una fecha" required>
            <select id="modalTipoDocumento" required>
                <option value="" disabled selected>Seleccione tipo de documento</option>
            </select>
            <select id="modalInstitucion" required>
                <option value="" disabled selected>Seleccione institución</option>
            </select>
            <select id="modalPuestoTrabajo" required>
                <option value="" disabled selected>Seleccione puesto de trabajo</option>
            </select>
            <button class="register-btn" onclick="addEmpleadoFromModal()">Guardar</button>
            <button class="cancel-btn" onclick="closeAddModal()">Cancelar</button>
        </div>
    </div>

    <script>
        function getAuthHeaders() {
            const accessToken = localStorage.getItem('access_token');
            return {
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                }
            };
        }

        function handleGetEmpleado() {
            axios.get('/api/empleados', getAuthHeaders())
                .then(function(response) {
                    if (response.data.data) {
                        const empleados = response.data.data;
                        const tbody = document.querySelector('tbody');
                        tbody.innerHTML = '';
                        empleados.forEach((empleado, index) => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${empleado.nombre1} ${empleado.nombre2 ?? ''} ${empleado.apellido1 ?? ''} ${empleado.apellido2 ?? ''} ${empleado.apellido_casada ?? ''}</td>
                        <td>${empleado.correo}</td>
                        <td>${empleado.telefono}</td>
                        <td>${empleado.direccion}</td>
                        <td>${empleado.puesto_trabajo.nombre}</td>
                        <td>${empleado.fecha_ingreso}</td>
                        <td>$ ${empleado.salario}</td>
                        <td>
                            <button id="btnEdit" onclick="openEditModal(${empleado.id})">Editar</button>
                        </td>
                        <td>
                            <button id="btnDel" onclick="deleteEmpleado(${empleado.id})">Eliminar</button>
                        </td>
                    `;
                            tbody.appendChild(tr);
                        });
                    } else {
                        alert('No se encontraron empleados');
                    }
                })
                .catch(function(error) {
                    console.error('Error al obtener los empleados:', error);
                    alert('Error al obtener los empleados.');
                });
        }

        handleGetEmpleado();

        function openAddModal() {
            document.getElementById('addEmpleadoModal').style.display = 'block';
        }

        function closeAddModal() {
            document.getElementById('addEmpleadoModal').style.display = 'none';
        }

        function deleteEmpleado(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este empleado?')) {
                axios.delete(`/api/empleados/${id}`, getAuthHeaders())
                    .then(response => {
                        alert('Empleado eliminado exitosamente');
                        handleGetEmpleado(); 
                    })
                    .catch(error => {
                        console.error('Error al eliminar el empleado:', error);
                        alert('Error al eliminar el empleado');
                    });
            }
        }

        function addEmpleadoFromModal() {
            const empleadoId = document.getElementById('modalEmpleadoId').value;
            const nuevoEmpleado = {
                nombre1: document.getElementById('modalNombre1').value,
                nombre2: document.getElementById('modalNombre2').value,
                apellido1: document.getElementById('modalApellido1').value,
                apellido2: document.getElementById('modalApellido2').value,
                apellido_casada: document.getElementById('modalApellidoCasada').value,
                tipo_documento_id: document.getElementById('modalTipoDocumento').value,
                numero_documento: document.getElementById('modalNumeroDocumento').value,
                numero_afiliado: document.getElementById('modalNumeroAfiliado').value,
                direccion: document.getElementById('modalDireccion').value,
                telefono: document.getElementById('modalTelefono').value,
                correo: document.getElementById('modalCorreo').value,
                salario: document.getElementById('modalSalario').value,
                fecha_ingreso: document.getElementById('modalFechaIngreso').value,
                institucion_id: document.getElementById('modalInstitucion').value,
                puesto_trabajo_id: document.getElementById('modalPuestoTrabajo').value
            };

            if (empleadoId) {
                axios.put(`/api/empleados/${empleadoId}`, nuevoEmpleado, getAuthHeaders())
                    .then(response => {
                        alert('Empleado actualizado exitosamente');
                        closeAddModal();
                        handleGetEmpleado();
                    })
                    .catch(error => {
                        console.error('Error al actualizar el empleado:', error);
                        alert('Error al actualizar el empleado');
                    });
            } else {
                axios.post('/api/empleados', nuevoEmpleado, getAuthHeaders())
                    .then(response => {
                        alert('Empleado agregado exitosamente');
                        closeAddModal();
                        handleGetEmpleado();
                    })
                    .catch(error => {
                        console.error('Error al agregar el empleado:', error);
                        alert('Error al agregar el empleado');
                    });
            }
        }

        // function closeAddModal() {
        //     document.getElementById('addEmpleadoModal').style.display = 'none';
        //     document.getElementById('modalEmpleadoId').value = '';
        // }

        function loadOptions() {
            axios.get('/api/tipoDocumentos', getAuthHeaders())
                .then(response => {
                    if (response.data && Array.isArray(response.data.data)) {
                        const select = document.getElementById('modalTipoDocumento');
                        select.innerHTML = '<option value="" disabled selected>Seleccione tipo de documento</option>';
                        response.data.data.forEach(tipoDocumento => {
                            const option = document.createElement('option');
                            option.value = tipoDocumento.id;
                            option.text = tipoDocumento.nombre;
                            select.appendChild(option);
                        });
                    } else {
                        alert('Error: formato de datos inesperado.');
                    }
                })
                .catch(error => {
                    alert('Error al cargar los tipos de documento.');
                });

            axios.get('/api/instituciones', getAuthHeaders())
                .then(response => {
                    if (response.data && Array.isArray(response.data.data)) {
                        const select = document.getElementById('modalInstitucion');
                        select.innerHTML = '<option value="" disabled selected>Seleccione institución</option>';
                        response.data.data.forEach(institucion => {
                            const option = document.createElement('option');
                            option.value = institucion.id;
                            option.text = institucion.nombre;
                            select.appendChild(option);
                        });
                    } else {
                        alert('Error: formato de datos inesperado.');
                    }
                })
                .catch(error => {
                    alert('Error al cargar las instituciones.');
                });

            axios.get('/api/puestos/puestos', getAuthHeaders())
                .then(response => {
                    if (response.data && Array.isArray(response.data.data)) {
                        const select = document.getElementById('modalPuestoTrabajo');
                        select.innerHTML = '<option value="" disabled selected>Seleccione puesto de trabajo</option>';
                        response.data.data.forEach(puesto => {
                            const option = document.createElement('option');
                            option.value = puesto.id;
                            option.text = puesto.nombre;
                            select.appendChild(option);
                        });
                    } else {
                        alert('Error: formato de datos inesperado.');
                    }
                })
                .catch(error => {
                    alert('Error al cargar los puestos de trabajo.');
                });
        }
        document.addEventListener("DOMContentLoaded", loadOptions);

        function openEditModal(id) {
            axios.get(`/api/empleados/${id}`, getAuthHeaders())
                .then(response => {
                    const empleado = response.data.data;
                    document.getElementById('modalEmpleadoId').value = empleado.id;
                    document.getElementById('modalNombre1').value = empleado.nombre1 || '';
                    document.getElementById('modalNombre2').value = empleado.nombre2 || '';
                    document.getElementById('modalApellido1').value = empleado.apellido1 || '';
                    document.getElementById('modalApellido2').value = empleado.apellido2 || '';
                    document.getElementById('modalApellidoCasada').value = empleado.apellido_casada || '';
                    document.getElementById('modalNumeroDocumento').value = empleado.numero_documento || '';
                    document.getElementById('modalNumeroAfiliado').value = empleado.numero_afiliado || '';
                    document.getElementById('modalDireccion').value = empleado.direccion || '';
                    document.getElementById('modalTelefono').value = empleado.telefono || '';
                    document.getElementById('modalCorreo').value = empleado.correo || '';
                    document.getElementById('modalSalario').value = empleado.salario || '';
                    document.getElementById('modalFechaIngreso').value = empleado.fecha_ingreso || '';
                    document.getElementById('modalTipoDocumento').value = empleado.tipo_documento_id || '';
                    document.getElementById('modalInstitucion').value = empleado.institucion_id || '';
                    document.getElementById('modalPuestoTrabajo').value = empleado.puesto_trabajo_id || '';
                    document.getElementById('addEmpleadoModal').style.display = 'block';
                    document.getElementById('addEmpleadoModal').querySelector('h2').textContent = 'Editar Empleado';
                })
                .catch(error => {
                    console.error('Error al obtener los datos del empleado:', error);
                    alert('No se pudo cargar la información del empleado.');
                });
        }
    </script>
</body>

</html>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("checkMenu").checked = true;
    });
</script>