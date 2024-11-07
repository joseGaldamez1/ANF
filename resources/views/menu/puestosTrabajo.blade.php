{{-- resources/views/puestos.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Puestos de trabajo</title>
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

    <section class="container fondoMenu">
        <h1 style="text-align: center">Puestos de trabajo</h1>
        <br>
        <button id="btnAdd" style="display: block; margin: 0 auto" onclick="openAddModal()">Agregar puesto de trabajo</button>
        <br><br>
        <table id="puestosTable" class="table table-striped table-bordered table-hover table-condensed table-responsive" style="width:80%; font-size: 13px">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Nombre del puesto</th>
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </section>

    <div id="addPuestoModal" class="modal" style="display: none;">
        <div class="modal-content">
            <h2 id="modalTitle">Agregar puesto de trabajo</h2>
            <input type="hidden" id="modalPuestoId">
            <input type="text" id="modalNombre" placeholder="Ingrese el nombre del puesto" required>
            <button class="register-btn" onclick="addOrEditPuesto()">Guardar</button>
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

        function handleGetPuestos() {
            axios.get('/api/puestos', getAuthHeaders())
                .then(function(response) {
                    if (response.data.data) {
                        const tbody = document.querySelector('#puestosTable tbody');
                        tbody.innerHTML = '';
                        response.data.data.forEach((puesto, index) => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${puesto.nombre}</td>
                        <td>
                            <button id="btnEdit" onclick="openEditModal(${puesto.id}, '${puesto.nombre}')">Editar</button>
                        </td>
                        <td>
                            <button id="btnDel" onclick="deletePuesto(${puesto.id})">Eliminar</button>
                        </td>
                    `;
                            tbody.appendChild(row);
                        });
                    } else {
                        alert('No se encontraron puestos de trabajo.');
                    }
                })
                .catch(function(error) {
                    console.error('Error al obtener los puestos:', error);
                    alert('Error al obtener los puestos de trabajo.');
                });
        }
        handleGetPuestos();

        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Agregar puesto de trabajo';
            document.getElementById('modalPuestoId').value = '';
            document.getElementById('modalNombre').value = '';
            document.getElementById('addPuestoModal').style.display = 'block';
        }


        function openEditModal(puestoId, nombreActual) {
            document.getElementById('modalTitle').textContent = 'Editar puesto de trabajo';
            document.getElementById('modalPuestoId').value = puestoId;
            document.getElementById('modalNombre').value = nombreActual;
            document.getElementById('addPuestoModal').style.display = 'block';
        }

        function closeAddModal() {
            document.getElementById('addPuestoModal').style.display = 'none';
        }

        function addOrEditPuesto() {
            const puestoId = document.getElementById('modalPuestoId').value;
            const nuevoPuesto = {
                nombre: document.getElementById('modalNombre').value,
            };

            if (puestoId) {
                axios.put(`/api/puestos/${puestoId}`, nuevoPuesto, getAuthHeaders())
                    .then(response => {
                        alert('Puesto actualizado exitosamente');
                        closeAddModal();
                        handleGetPuestos();
                    })
                    .catch(error => {
                        console.error('Error al actualizar el puesto:', error);
                        alert('Error al actualizar el puesto');
                    });
            } else {
                axios.post('/api/puestos', nuevoPuesto, getAuthHeaders())
                    .then(response => {
                        alert('Puesto agregado exitosamente');
                        closeAddModal();
                        handleGetPuestos();
                    })
                    .catch(error => {
                        console.error('Error al agregar el puesto:', error);
                        alert('Error al agregar el puesto');
                    });
            }
        }

        function deletePuesto(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este puesto de trabajo?')) {
                axios.delete(`/api/puestos/${id}`, getAuthHeaders())
                    .then(response => {
                        alert('Puesto eliminado exitosamente');
                        handleGetPuestos();
                    })
                    .catch(error => {
                        console.error('Error al eliminar el puesto:', error);
                        alert('Error al eliminar el puesto');
                    });
            }
        }
    </script>
</body>

</html>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("checkMenu").checked = true;
    });
</script>