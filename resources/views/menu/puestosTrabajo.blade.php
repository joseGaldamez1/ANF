{{-- resources/views/menu.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Puestos de trabajo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @vite(['resources/css/custom/menu.css'])
    @vite('resources/css/custom/tablas.css')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> <!-- Incluir Axios -->
</head>
<body>

<!-- Checkbox y botón para abrir/cerrar el menú -->
<input type="checkbox" name="checkMenu" id="checkMenu">
<label for="checkMenu" class="labelBotonMenu">
    <i class="fa fa-navicon" id="btnMostrar"></i>
</label>

<!-- Barra lateral -->
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

<section class="container fondoMenu">
    <!-- Contenido principal aquí -->
    <h1 style="text-align: center; border: 1px solid black">Puestos de trabajo</h1>
    <br>
    <button id="btnAdd" style="display: block; margin: 0 auto">Agregar puesto</button>
    <br><br>
    <table id="puestosTable" style="width:60%; text-align:center; font-size: 13px">
        <thead>
            <tr>
                <th>N°</th>
                <th>Descripción</th>
                <th colspan="2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Los puestos se llenarán dinámicamente con la llamada a la API -->
        </tbody>
    </table>
</section>

<!-- Modal para edición de puesto -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h2>Editar Puesto</h2>
        <input  style="width: 300px; height: 30px" type="text" id="editNombre" placeholder="Nuevo nombre del puesto">
        <br><br>
        <button id="btnAdd" onclick="saveEdit()">Guardar cambios</button>
    </div>
</div>

<!-- Modal de Confirmación de Eliminación -->
<div id="deleteModal" class="modal-overlay">
    <div class="modal-content">
        <h2>¿Estás seguro de que deseas eliminar este puesto?</h2>
        <p>Esta acción no se puede deshacer.</p>
        
        <div class="modal-buttons">
            <button class="modal-cancel-btn" onclick="cerrarDeleteModal()">Cancelar</button>
            <button class="modal-delete-btn" onclick="confirmarEliminacion()">Eliminar</button>
        </div>
    </div>
</div>


<script>
        let currentPuestoId = null;

        // Función para abrir el modal de edición
        function openEditModal(puestoId, nombreActual) {
            currentPuestoId = puestoId;
            document.getElementById('editNombre').value = nombreActual;
            document.getElementById('editModal').style.display = 'flex';
        }

        // Función para cerrar el modal
        function closeModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        // Función para guardar los cambios del puesto
        function saveEdit() {
            const accessToken = localStorage.getItem('access_token');
            const nuevoNombre = document.getElementById('editNombre').value;

            if (!nuevoNombre) {
                alert('Por favor, ingrese un nuevo nombre.');
                return;
            }

            axios.put(`/api/puestos/update/${currentPuestoId}`, {
                nombre: nuevoNombre
            }, {
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                }
            })
            .then(function (response) {
                alert('Puesto actualizado exitosamente.');
                closeModal();
                handleGetPuestos();  
            })
            .catch(function (error) {
                console.error('Error al editar el puesto:', error);
                alert('Error al editar el puesto.');
            });
        }

        




    // Función para obtener los puestos de trabajo y mostrarlos en la tabla
    function handleGetPuestos() {
        const accessToken = localStorage.getItem('access_token'); 

        if (!accessToken) {
            alert('Por favor, inicie sesión.');
            return;
        }

        // Realizar la solicitud con Axios
        axios.get('/api/puestos/puestos', {
            headers: {
                'Authorization': `Bearer ${accessToken}` 
            }
        })
        .then(function (response) {
            if (response.data.data) {
                console.log('Puestos de trabajo:', response.data.data);

               
                const tbody = document.querySelector('#puestosTable tbody');
                tbody.innerHTML = '';

                response.data.data.forEach((puesto, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${puesto.nombre}</td>
                        <td>
                            <button id="btnDel" onclick="handleDeletePuesto(${puesto.id})">Eliminar</button>
                        </td>
                        <td>
                            <button id="btnEdit" onclick="openEditModal(${puesto.id}, '${puesto.nombre}')">Editar</button>
                        </td>
                    `;
                    tbody.appendChild(row); 
                });
            } else {
                alert('No se encontraron puestos de trabajo.');
            }
        })
        .catch(function (error) {
            console.error('Error al obtener los puestos:', error);
            alert('Error al obtener los puestos de trabajo.');
        });
    }
    handleGetPuestos();



    
     // Función para eliminar un puesto con confirmación
     function handleDeletePuesto(puestoId) {
        const accessToken = localStorage.getItem('access_token');

        if (!accessToken) {
            alert('Por favor, inicie sesión.');
            return;
        }

        // Mostrar mensaje de confirmación antes de eliminar
        if (confirm('¿Estás seguro de que deseas eliminar este puesto de trabajo? Esta acción no se puede deshacer.')) {
            axios.delete(`/api/puestos/puestos/${puestoId}`, {
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                }
            })
            .then(function (response) {
                alert('Puesto eliminado exitosamente.');
                handleGetPuestos();  // Actualizar la lista después de eliminar
            })
            .catch(function (error) {
                console.error('Error al eliminar el puesto:', error);
                alert('Error al eliminar el puesto.');
            });
        }
    }

</script>

</body>
</html>
