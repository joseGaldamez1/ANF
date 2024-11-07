{{-- resources/views/menu.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @vite(['resources/css/custom/menu.css'])
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
        <h1 style="text-align: center">Reportes</h1>

        <p style="text-align: center; width: 80%; margin: 0 auto">Estimado Administrador, en esta Sección usted puede
            imprimir la planilla por periodo determinado, porfavor seleccione un periodo y de click en "Imprimir
            Planilla"</p><br><br>
        <div style="display: flex; justify-content: center; align-items: center; gap: 10px;">
            <select id="selectedPeriodo"
                style="width: 225px; padding: 8px; font-size: 16px; border-radius: 5px; border: 1px solid #ccc; background-color: #f9f9f9; cursor: pointer;">
                <option value="0">Seleccione...</option>
                <option value="012024">012024</option>
                <option value="022024">022024</option>
                <option value="032024">032024</option>
                <option value="042024">042024</option>
                <option value="052024">052024</option>
                <option value="062024">062024</option>
                <option value="072024">072024</option>
                <option value="082024">082024</option>
                <option value="092024">092024</option>
                <option value="102024">102024</option>
                <option value="112024">112024</option>
                <option value="122024">122024</option>
            </select>

            <button id="btnCrear" onclick="getPDF()"
                style="padding: 8px 12px; font-size: 16px; border-radius: 5px; background-color: #4CAF50; color: white; border: none; cursor: pointer;">
                Imprimir Planilla

            </button>
        </div>
        <br><br>
        <h1 style="text-align: center; margin: 0 auto">Imprimir planilla por empleado</h1>
        <p style="text-align: center; width: 80%; margin: 0 auto">Si desea imprimir la planilla para un empleado
            especifico puedo hacerlo seleccionadolo y eligiendo el periodo deseado</p><br><br>
        <div style="display: flex; justify-content: center; align-items: center; gap: 10px;">
            <select id="selectedPeriod"
                style="width: 225px; padding: 8px; font-size: 16px; border-radius: 5px; border: 1px solid #ccc; background-color: #f9f9f9; cursor: pointer;">
                <option value="0">Seleccione...</option>
                <option value="012024">012024</option>
                <option value="022024">022024</option>
                <option value="032024">032024</option>
                <option value="042024">042024</option>
                <option value="052024">052024</option>
                <option value="062024">062024</option>
                <option value="072024">072024</option>
                <option value="082024">082024</option>
                <option value="092024">092024</option>
                <option value="102024">102024</option>
                <option value="112024">112024</option>
                <option value="122024">122024</option>
            </select>
            <select id="selectedEmpleado"
                style="width: 225px; padding: 8px; font-size: 16px; border-radius: 5px; border: 1px solid #ccc; background-color: #f9f9f9; cursor: pointer;">
            </select>

            <button id="btnCrear" onclick="getPDFEmpleado()"
                style="padding: 8px 12px; font-size: 16px; border-radius: 5px; background-color: #4CAF50; color: white; border: none; cursor: pointer;">
                Imprimir Planilla
            </button>
        </div>
        <br><br>
        <h1 style="text-align: center; margin: 0 auto">Descargar Planilla Unica</h1>
        <p style="text-align: center; width: 80%; margin: 0 auto">Si desea descargar la planilla unica para realizar el
            informe porfavor seleccione el periodo y de clic al boton "Descargar"</p><br><br>
        <div style="display: flex; justify-content: center; align-items: center; gap: 10px;">
            <select id="selectedPe"
                style="width: 225px; padding: 8px; font-size: 16px; border-radius: 5px; border: 1px solid #ccc; background-color: #f9f9f9; cursor: pointer;">
                <option value="0">Seleccione...</option>
                <option value="012024">012024</option>
                <option value="022024">022024</option>
                <option value="032024">032024</option>
                <option value="042024">042024</option>
                <option value="052024">052024</option>
                <option value="062024">062024</option>
                <option value="072024">072024</option>
                <option value="082024">082024</option>
                <option value="092024">092024</option>
                <option value="102024">102024</option>
                <option value="112024">112024</option>
                <option value="122024">122024</option>
            </select>

            <button id="btnCrear" onclick="descargar()"
                style="padding: 8px 12px; font-size: 16px; border-radius: 5px; background-color: #4CAF50; color: white; border: none; cursor: pointer;">
                Descargar Planilla

            </button>
        </div>




    </section>

    <script>
        function getPDF() {
            const accessToken = localStorage.getItem('access_token');
            const periodo = document.getElementById('selectedPeriodo').value;

            axios.get(`/api/reportes/reportes/${periodo}`, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    },
                    responseType: 'blob'
                })
                .then(function(response) {
                    // Crear una URL de objeto a partir del blob
                    const fileURL = window.URL.createObjectURL(new Blob([response.data], {
                        type: 'application/pdf'
                    }));
                    // Abrir el PDF en una nueva pestaña
                    window.open(fileURL);
                })
                .catch(function(error) {
                    console.error('Error al obtener el PDF:', error);
                });

        }



        function getPDFEmpleado() {
            const accessToken = localStorage.getItem('access_token');
            const periodo = document.getElementById('selectedPeriod').value;
            const empleado = document.getElementById('selectedEmpleado').value;

            axios.get(`/api/reportes/empleado/${periodo}/${empleado}`, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    },
                    responseType: 'blob'
                })
                .then(function(response) {
                    const contentType = response.headers['content-type'];
                    if (contentType !== 'application/pdf') {
                        response.data.text().then((text) => {
                            const jsonResponse = JSON.parse(
                                text);
                            console.log(jsonResponse);
                            console.log(periodo, empleado);
                            if (jsonResponse.message === 'No se encontró registro') {
                                alert('No hay planilla para el empleado en el periodo seleccionado');
                            } else {
                                alert('Error desconocido');
                            }
                        });
                        return;
                    }

                    const fileURL = window.URL.createObjectURL(new Blob([response.data], {
                        type: 'application/pdf'
                    }));
                    window.open(fileURL);
                })
                .catch(function(error) {
                    console.error('Error al obtener el PDF:', error);
                    alert('Hubo un error al obtener el PDF.');
                });
        }
    </script>

    <script>
        function handleGetEmpleado() {
            const accessToken = localStorage.getItem('access_token');

            // Petición GET a la API
            axios.get('/api/empleados/empleados', {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(function(response) {
                    if (response.data && Array.isArray(response.data.data)) {
                        const empleados = response.data.data;
                        const selectedEmpleado = document.getElementById('selectedEmpleado');

                        // Limpiar el contenido previo del select
                        selectedEmpleado.innerHTML = '';

                        // Iterar sobre los empleados y agregar opciones al select
                        empleados.forEach((empleado) => {
                            const option = document.createElement('option');
                            option.value = empleado.id;
                            option.textContent =
                                `${empleado.nombre1} ${empleado.nombre2 || ''} ${empleado.apellido1 || ''} ${empleado.apellido2 || ''} ${empleado.apellido_casada || ''}`;
                            selectedEmpleado.appendChild(option);
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


        // Función para descargar la planilla única en CSV
        function descargar() {
            const accessToken = localStorage.getItem('access_token');
            const periodo = document.getElementById('selectedPe').value;

            axios.get(`/api/reportes/descargar/${periodo}`, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    },
                    responseType: 'blob'
                })
                .then(function(response) {
                    const contentType = response.headers['content-type'] || response.headers['Content-Type'];

                    // Crear URL de objeto y descargar el archivo CSV
                    const fileURL = window.URL.createObjectURL(new Blob([response.data], {
                        type: 'text/csv'
                    }));
                    const a = document.createElement('a');
                    a.href = fileURL;
                    a.download = `planilla_${periodo}.csv`;
                    a.click();

                    // Liberar el objeto URL después de usarlo
                    window.URL.revokeObjectURL(fileURL);
                })
                .catch(function(error) {
                    console.error('Error al obtener el archivo:', error);
                    alert('Hubo un error al obtener el archivo.');
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
