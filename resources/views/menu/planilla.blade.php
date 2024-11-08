{{-- resources/views/menu.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto Análisis Financiero</title>
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
        <h3 style="text-align: center">Emitir planilla de empleado</h3>
        <br>
        <div style="display: flex; justify-content: center; align-items: center; gap: 10px;">
            <select id="selectedPeriodo"
                style="width: 225px; padding: 8px; font-size: 16px; border-radius: 5px; border: 1px solid #ccc; background-color: #f9f9f9; cursor: pointer;">
                <option value="0">Seleccione un periodo</option>
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

            <button id="btnCrear"
                onclick="handleCrearPlanilla()"
                style="padding: 8px 12px; font-size: 16px; border-radius: 5px; background-color: #4CAF50; color: white; border: none; cursor: pointer;">
                Crear nueva planilla
            </button>
        </div>
        <br><br>

        <table id="puestosTable" class="table table-striped table-bordered table-hover table-condensed table-responsive"
            style="width:70%; font-size: 13px">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Periodo</th>
                    <th>Fecha de ingreso</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Salario</th>
                    <th>Pago adicional</th>
                    <th>Monto Vacaciones</th>
                    <th>Dias</th>
                    <th>Horas</th>
                    <th>Dias vacaciones</th>
                    <th>Observaciones</th>
                    <th>Observaciones</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Los empleados se llenarán dinámicamente con la llamada a la API -->
            </tbody>
        </table>
        <br>
        <button id="btnAdd" onclick="guardarPlanilla()"
            style="display: block; margin: 0 auto; border: 1px solid black">Guardar planilla</button>
    </section>

    <!-- Modal para Modificar los pagos adicionales -->
    <div id="editModal" class="modal">
        <div class="modal-content" style="height: 400px; width: 750px">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2>Modificar Planilla</h2>
            <input type="hidden" id="id" name="id">

            <label for="salario">Salario:</label>
            <input type="number" id="salario" name="salario" readonly><br><br>

            <label for="horasDiurnas">Horas extras diurnas:</label>
            <input type="number" id="horasDiurnas" name="horasDiurnas">

            <label for="montoHorasDiurnas">Total:</label>
            <input type="number" id="montoHorasDiurnas" name="montoHorasDiurnas" readonly><br><br>

            <label for="horasNocturnas">Horas extras nocturnas:</label>
            <input type="number" id="horasNocturnas" name="horasNocturnas">

            <label for="montoHorasNocturnas">Total:</label>
            <input type="number" id="montoHorasNocturnas" name="montoHorasNocturnas" readonly><br><br>

            <label for="vacacionesCheck">Incluir Vacaciones:</label>
            <input type="checkbox" id="vacacionesCheck" name="vacacionesCheck">


            <label for="vacaciones">Total:</label>
            <input type="number" id="vacaciones" name="vacaciones"><br><br>

            <label for="indemnizacionCheck">Incluir Indemnizacion:</label>
            <input type="checkbox" id="indemnizacionCheck" name="indemnizacionCheck">

            <label for="indemnizacion">Total:</label>
            <input type="number" id="indemnizacion" name="indemnizacion"><br><br>


            <label for="totalPagoAdicional">Total Pago Adicional:</label>
            <input type="number" id="totalPagoAdicional" name="totalPagoAdicional" readonly><br><br>


            <label for="observacion1">Observación 1:</label>
            <select id="observacion1" name="observacion1">

            </select><br><br>

            <label for="observacion2">Observación 2:</label>
            <select id="observacion2" name="observacion2">
            </select><br><br>

            <button id="btnAdd" onclick="onSave()">Guardar</button>
        </div>
    </div>


    <script>
        // Variables globales para el modal de edición de planilla
        let currentPlanillaId = null;
        let salarioC;
        let montoHorasDiurnas;
        let montoHorasNocturnas;
        let horasDiurnas;
        let horasNocturnas;
        let vacacionesT;
        let indemnizacionT;
        let totalT;
        let observacion11;
        let observacion22;
        let fechaIngreso;

        function openModal(id, salario, horasDia, horasNoche, totalDia, totalNoche, vacaciones, indemnizacion, total,
            observacion1, observacion2, fecha) {
            currentPlanillaId = id;

            // Asignar valores a los elementos de entrada y almacenar referencias globales
            salarioC = document.getElementById('salario');
            montoHorasDiurnas = document.getElementById('montoHorasDiurnas');
            montoHorasNocturnas = document.getElementById('montoHorasNocturnas');
            horasDiurnas = document.getElementById('horasDiurnas');
            horasNocturnas = document.getElementById('horasNocturnas');
            vacacionesT = document.getElementById('vacaciones');
            indemnizacionT = document.getElementById('indemnizacion');
            totalT = document.getElementById('totalPagoAdicional');
            observacion11 = document.getElementById('observacion1');
            observacion22 = document.getElementById('observacion2');

            // Asignar valores a cada campo
            salarioC.value = salario;
            montoHorasDiurnas.value = totalDia;
            montoHorasNocturnas.value = totalNoche;
            horasDiurnas.value = horasDia;
            horasNocturnas.value = horasNoche;
            vacacionesT.value = vacaciones;
            indemnizacionT.value = indemnizacion;
            totalT.value = total;
            observacion11.value = observacion1;
            observacion22.value = observacion2;

            // Guardar la fecha de ingreso como valor global
            fechaIngreso = fecha;

            // Mostrar el modal
            document.getElementById('editModal').style.display = 'flex';

            // Llamar a calcularHoras para iniciar el cálculo
            calcularHoras();
        }

        function calcularHoras() {
            const precioHora = parseFloat(salarioC.value) / 240;
            const hdiurnas = parseFloat(document.getElementById('horasDiurnas').value) || 0;
            const hnocturnas = parseFloat(document.getElementById('horasNocturnas').value) || 0;


            // Verificar si el checkbox de vacaciones está activado
            const vacacionesCheck = document.getElementById('vacacionesCheck').checked;
            let vacaciones = 0;

            if (vacacionesCheck) {
                vacaciones = parseFloat(salarioC.value / 2) * 0.3;
            }

            //verificar si el checkbox de indemnización está activado
            const indemnizacionCheck = document.getElementById('indemnizacionCheck').checked;
            let indemnizacion = 0;
            if (indemnizacionCheck) {
                // Calcula la indemnización
                const fechaActual = new Date();
                const fechaIngresoDate = new Date(fechaIngreso);

                // Calcula la diferencia en años
                const diferenciaAnios = ((fechaActual - fechaIngresoDate) / (1000 * 3600 * 24 * 365)).toFixed(10);

                // Calcula la indemnización
                indemnizacion = (salarioC.value * 1);
            }


            const montoHorasDiurnas = document.getElementById('montoHorasDiurnas');
            const montoHorasNocturnas = document.getElementById('montoHorasNocturnas');
            const total = document.getElementById('totalPagoAdicional');
            const totalVacaciones = document.getElementById('vacaciones');
            const totalIndemnizacion = document.getElementById('indemnizacion');

            // Calcular monto de horas diurnas y nocturnas
            montoHorasDiurnas.value = (hdiurnas * 2 * precioHora).toFixed(2);
            montoHorasNocturnas.value = (hnocturnas * 2.25 * precioHora).toFixed(2);
            totalVacaciones.value = vacaciones.toFixed(2);
            totalIndemnizacion.value = indemnizacion.toFixed(2);

            // Sumar el total de horas diurnas, nocturnas, vacaciones e indemnización
            const totalPago = parseFloat(montoHorasDiurnas.value) + parseFloat(montoHorasNocturnas.value) + vacaciones +
                indemnizacion;

            // Mostrar el total en el input
            total.value = totalPago.toFixed(2);
        }

        // Mostrar en el input
        document.getElementById('horasDiurnas').addEventListener('input', calcularHoras);
        document.getElementById('horasNocturnas').addEventListener('input', calcularHoras);
        document.getElementById('vacacionesCheck').addEventListener('change',
            calcularHoras);
        document.getElementById('indemnizacionCheck').addEventListener('change', calcularHoras);

        // Cerrar modal
        function closeModal() {
            document.getElementById('editModal').style.display = 'none';
        }


        // FUNCIÓN PARA EDITAR LA PLANILLA DE UN EMPLEADO ESPECÍFICO
        function onSave() {
            const accessToken = localStorage.getItem('access_token');

            // Recoger los datos actualizados del formulario
            const data = {
                cantidad_hora_diurna: horasDiurnas.value,
                monto_hora_diurna: montoHorasDiurnas.value,
                cantidad_hora_nocturna: horasNocturnas.value,
                monto_hora_nocturna: montoHorasNocturnas.value,
                vacaciones: vacacionesT.value,
                pago_adicional: totalT.value,
                aguinaldo: 0,
                indemnizacion: indemnizacionT.value,
                dias: 30,
                horas: 170,
                observacion1_id: observacion11.value,
                observacion2_id: observacion22.value,
            };
            console.log(data);

            axios.put(`/api/planilla/${currentPlanillaId}`, data, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(function(response) {
                    alert("Pago adicional agregado exitosamente.");
                    closeModal();
                    handleGetEmpleado();
                })
                .catch(function(error) {
                    console.error('Error:', error);
                    alert('Error al agregar el pago adicional.');
                });
        }






        //Mostrar los empleados en la tabla
        function handleGetEmpleado() {
            const periodoSelect = document.getElementById('selectedPeriodo');
            const btnAdd = document.getElementById('btnCrear');
            const accessToken = localStorage.getItem('access_token');


            //Petición GET a la API
            axios.get(`/api/planilla/listar`, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(function(response) {
                    if (response.data.data) {
                        // Hay registros en la planilla, deshabilitar botón y select
                        periodoSelect.disabled = true;
                        btnAdd.disabled = true;
                        //Setear el periodo en el select
                        periodoSelect.value = response.data.data[0].periodo;

                        const planillas = response.data.data;
                        const tbody = document.querySelector('tbody');
                        tbody.innerHTML = '';
                        planillas.forEach((plan, index) => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${plan.periodo}</td>
                    <td>${plan.empleado.fecha_ingreso}</td>
                    <td>${plan.empleado.nombre1 ?? ''} ${plan.empleado.nombre2 ?? ''}</td>
                    <td>${plan.empleado.apellido1 ?? ''} ${plan.empleado.apellido2 ?? ''} ${plan.empleado.apellido3 ?? ''}</td>
                    <td>${plan.salario}</td>
                    <td>${plan.monto_pago_adicional}</td>
                    <td>${plan.monto_vacaciones}</td>
                    <td>${plan.dias}</td>
                    <td>${plan.horas}</td>
                    <td>${plan.dias_vacaciones}</td>
                    <td>${plan.observacion1.codigo} - ${plan.observacion1.concepto}</td>
                    <td>${plan.observacion2.codigo} - ${plan.observacion2.concepto}</td>
                    <td>
                        <button id="btnAdd" onclick="openModal(
                        '${plan.id}', 
                        '${plan.salario}', 
                        '${plan.pago_adicional.cantidad_hora_diurna}', 
                        '${plan.pago_adicional.cantidad_hora_nocturna}',
                        '${plan.pago_adicional.monto_hora_diurna}', 
                        '${plan.pago_adicional.monto_hora_nocturna}',
                        '${plan.pago_adicional.vacaciones}', 
                        '${plan.pago_adicional.indemnizacion}', 
                        '${plan.monto_pago_adicional}',
                        '${plan.observacion1.id}',
                        '${plan.observacion2.id}',
                        '${plan.empleado.fecha_ingreso}')">Modificar</button>
                    </td>
                `;
                            tbody.appendChild(tr);
                        });
                    } else {}
                })
                .catch(function(error) {
                    console.error('Error al obtener la planilla:', error);
                });
        }
        handleGetEmpleado();



        // FUNCION PARA GUARDAR LA PLANILLA
        function guardarPlanilla() {
            const accessToken = localStorage.getItem('access_token');

            // GET para finalizar la planilla
            axios.get(`/api/planilla/`, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(function(response) {
                    if(response.data){
                        console.log(response.data.data);
                        alert('Planilla guardada exitosamente.');
                        window.location.reload();
                        handleGetEmpleado();
                    }else{
                    alert('Planilla guardada exitosamente.');
                    handleGetEmpleado();
                    window.location.reload()
                    }
                })
                .catch(function(error) {
                    // Manejo de errores
                    console.error('Error:', error);
                    alert('Error al guardar la planilla.');
                })
        }
    </script>

    <!-- API para iniciar una planilla nueva-->
    <script>
        function handleCrearPlanilla() {
            const accessToken = localStorage.getItem('access_token');
            const select = document.getElementById('selectedPeriodo').value;

            axios.post(`/api/planilla/${select}`, {}, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(function(response) {
                    if(response.data.message == `Ya existe una planilla para el periodo ${select}`){
                        alert(`Ya existe una planilla para el periodo ${select}`);
                    }else{
                    alert('Planilla iniciada, a continuacion modifique los empleados que desee o proceda a guardar la planilla.');
                    handleGetEmpleado();
                    }
                })
                .catch(function(error) {
                    console.error('Error:', error);
                    alert('Error al crear la planilla.');
                });
            }
    </script>

    <!-- API para obtener las observaciones -->
    <script>
        function handleGetObservaciones() {
            const accessToken = localStorage.getItem('access_token');

            axios.get('/api/observaciones/', {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(function(response) {
                    if (response.data.data) {
                        const observaciones = response.data.data;
                        const observacion1 = document.getElementById('observacion1');
                        const observacion2 = document.getElementById('observacion2');

                        observacion1.innerHTML = '';
                        observacion2.innerHTML = '';

                        observaciones.forEach(observacion => {
                            const option1 = document.createElement('option');
                            option1.value = observacion.id;
                            option1.textContent = `${observacion.codigo} - ${observacion.concepto}`;
                            observacion1.appendChild(option1);

                            const option2 = document.createElement('option');
                            option2.value = observacion.id;
                            option2.textContent = `${observacion.codigo} - ${observacion.concepto}`;
                            observacion2.appendChild(option2);
                        });
                    } else {
                        alert('No se encontraron observaciones');
                    }
                })
                .catch(function(error) {
                    console.error('Error al obtener las observaciones:', error);
                });
        }
        handleGetObservaciones();
    </script>

</body>

</html>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("checkMenu").checked = true;
    });
</script>
