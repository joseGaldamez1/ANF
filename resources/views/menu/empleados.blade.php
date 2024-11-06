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
<?php
/*<style>
    .fondoMenu {
        background-image: url('@php echo asset("img/fondoMenu.jpg"); @endphp');
        background-size: cover;
    }
</style>*/
?>
<section class="container fondoMenu">
    <!-- Contenido principal aquí -->
    <h1 style="text-align: center">Empleados</h1>
    <br>
    <button id="btnAdd" style="display: block; margin: 0 auto">Agregar empleado</button>
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

<script>
    //Mostrar los empleados en la tabla
    function handleGetEmpleado(){
        const accessToken = localStorage.getItem('access_token');

        //Petición GET a la API
        axios.get('/api/empleados/empleados', {
            headers: {
                'Authorization': `Bearer ${accessToken}`
            }
        })
        .then(function (response) {
         if(response.data.data){
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
                        <button id="btnDel" onclick="openDeleteModal(${empleado.id})">Eliminar</button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
         }else{
                alert('No se encontraron empleados');
         }        
    })
    .catch(function (error) {
        console.error('Error al obtener los empleados:', error);
        alert('Error al obtener los empleados.');
    });
    }
    handleGetEmpleado();

</script>

</body>
</html>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("checkMenu").checked = true;
    });
</script>
