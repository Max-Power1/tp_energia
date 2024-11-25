<?php
session_start();
include './conexion.php';

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Mostrar mensajes si existen
$message = "";
if (isset($_SESSION['message'])) {
    $message = "<div class='my-2 alert alert-" . ($_SESSION['message_type'] === "success" ? "success" : "danger") . "'>" 
            . $_SESSION['message'] . 
            "</div>";
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}

// Consulta para obtener proyectos con estado distinto a "Completado" o "Terminado"
$query = "
    SELECT 
        p.id_proyecto, 
        p.nombre AS proyecto, 
        p.fecha, 
        p.suma_total, 
        p.hidraulica, 
        p.termica, 
        p.nuclear, 
        p.renovable, 
        r.nombre AS region, 
        r.id_api AS id_region, -- Cambiamos a id_api y usamos el alias id_region
        es.nombre AS estado
    FROM proyectos p
    JOIN regiones r ON p.region = r.id_regiones
    JOIN estados es ON p.estado = es.id_estados
    WHERE es.nombre NOT IN ('Completado', 'Terminado', 'Inactivo', 'Sin Estado')
    ORDER BY p.id_proyecto ASC
";
$result = $conn->query($query);

// Almacenar los datos en un array para la tabla
$proyectos = [];
while ($row = $result->fetch_assoc()) {
    $proyectos[] = $row;
}

// Cerrar conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyección de Proyectos</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container Fondo-principal">
        <?php include '../drivers/menuPages.php'; ?>
        <h1 class="mb-4">Proyección de Proyectos</h1>
        
        <!-- Mostrar mensaje -->
        <?php echo $message; ?>

        <!-- Tabla -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Proyecto</th>
                        <th>Nombre del Proyecto</th>
                        <th>Fecha</th>
                        <th>Suma Total (MW)</th>
                        <th>Hidráulica (MW)</th>
                        <th>Térmica (MW)</th>
                        <th>Nuclear (MW)</th>
                        <th>Renovable (MW)</th>
                        <th>Región</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($proyectos as $proyecto): ?>
                        <tr>
                            <td><?= $proyecto['id_proyecto'] ?></td>
                            <td class="nombreProyecto"><?= $proyecto['proyecto'] ?></td>
                            <td><?= $proyecto['fecha'] ?></td>
                            <td><?= $proyecto['suma_total'] ?></td>
                            <td><?= $proyecto['hidraulica'] ?></td>
                            <td><?= $proyecto['termica'] ?></td>
                            <td><?= $proyecto['nuclear'] ?></td>
                            <td><?= $proyecto['renovable'] ?></td>
                            <td><?= $proyecto['region'] ?></td>
                            <td><?= $proyecto['estado'] ?></td>
                            <td>
                                <button class="btn btn-info btn-visualizar" data-id="<?= $proyecto['id_region'] ?>">Visualizar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Sección para mostrar el gráfico detallado -->
        <div id="grafico-detallado" class="mt-5" style="display: none;">
            <h2 id="tituloGrafico">Gráfico Detallado del Proyecto</h2>
            <canvas id="graficoProyecto" width="400" height="200"></canvas>
        </div>
    </div>

    <script src="../js/bootstrap.bundle.min.js"></script>

    <script>
        // const nombreProyecto = document.querySelector(".nombreProyecto").textContent;
        // const tituloGrafico = document.querySelector("#tituloGrafico");
        // console.log(nombreProyecto);
        
        // Event listener para alternar la visibilidad del gráfico detallado
        document.querySelectorAll('.btn-visualizar').forEach(button => {
            button.addEventListener('click', function () {
                const nombreProyecto = this.closest('tr').querySelector('.nombreProyecto').textContent;
                const tituloGrafico = document.querySelector("#tituloGrafico");
                const idRegion = this.dataset.id; // Obtener el ID de la región del botón
                const graficoSeccion = document.getElementById('grafico-detallado'); // Seleccionar la sección del gráfico
                
                // Alternar visibilidad
                if (graficoSeccion.style.display === 'none' || graficoSeccion.style.display === '') {
                    graficoSeccion.style.display = 'block'; // Mostrar gráfico
                    tituloGrafico.textContent = `Gráfico Detallado del Proyecto: ${nombreProyecto}`
                    graficar(idRegion);

                    console.log("Proyecto seleccionado: " + idRegion);

                } else {
                    graficoSeccion.style.display = 'none'; // Ocultar gráfico

                    console.log("Ocultando gráfico para el proyecto: " + idRegion);
                }
            });
        });

        function graficar(idRegion) {
            // Calcular la fecha del día anterior
            const fechaActual = new Date();
            fechaActual.setDate(fechaActual.getDate() - 1);
            const fechaAyer = fechaActual.toISOString().split('T')[0]; // Formato YYYY-MM-DD

            // URLs de ambas APIs
            const urlDemanda = `https://api.cammesa.com/demanda-svc/demanda/ObtieneDemandaYTemperaturaRegionByFecha?fecha=${fechaAyer}&id_region=${idRegion}`;
            const urlGeneracion = `https://api.cammesa.com/demanda-svc/generacion/ObtieneGeneracioEnergiaPorRegion?id_region=${idRegion}`;

            // Hacer la solicitud a ambas APIs
            Promise.all([
                fetch(urlDemanda).then(response => response.json()),
                fetch(urlGeneracion).then(response => response.json())
            ])
            .then(([dataDemanda, dataGeneracion]) => {
                // Procesar datos de la API de Demanda y Temperatura
                const etiquetas = dataDemanda.map(entry => new Date(entry.fecha).toLocaleTimeString('es-AR', { hour: '2-digit', minute: '2-digit' }));
                const demanda = dataDemanda.map(entry => entry.dem);
                const temperatura = dataDemanda.map(entry => entry.temp || null);

                // Procesar datos de la API de Generación de Energía
                const generacionHidraulico = dataGeneracion.map(entry => entry.hidraulico);
                const generacionTermico = dataGeneracion.map(entry => entry.termico);
                const generacionNuclear = dataGeneracion.map(entry => entry.nuclear);
                const generacionRenovable = dataGeneracion.map(entry => entry.renovable);
                const generacionImportacion = dataGeneracion.map(entry => entry.importacion);

                // Mostrar el gráfico
                renderizarGrafico(etiquetas, demanda, temperatura, generacionHidraulico, generacionTermico, generacionNuclear, generacionRenovable, generacionImportacion);
            })
            .catch(error => {
                console.error('Error al obtener datos de las APIs:', error);
            });
        }

        function renderizarGrafico(labels, demanda, temperatura, generacionHidraulico, generacionTermico, generacionNuclear, generacionRenovable, generacionImportacion) {
            // Selecciono el canvas
            const ctx = document.getElementById('graficoProyecto').getContext('2d');

            if (window.miGrafico) {
                window.miGrafico.destroy(); // Destruir gráfico previo si existe
            }

            window.miGrafico = new Chart(ctx, {
                type: 'line', // Tipo de gráfico general
                data: {
                    labels: labels,
                    datasets: [
                        // Los datasets de generación con apilamiento
                        {
                            label: 'Generación Hidráulica (MW)',
                            data: generacionHidraulico,
                            borderColor: 'green',
                            backgroundColor: 'rgba(0, 255, 0, 0.3)',
                            borderWidth: 2,
                            fill: 'origin',
                            tension: 0.3,
                            yAxisID: 'yGeneracion', // Usar el eje Y para generación
                        },
                        {
                            label: 'Generación Térmica (MW)',
                            data: generacionTermico,
                            borderColor: 'red',
                            backgroundColor: 'rgba(255, 0, 0, 0.3)',
                            borderWidth: 2,
                            fill: 'origin',
                            tension: 0.3,
                            yAxisID: 'yGeneracion', // Usar el eje Y para generación
                        },
                        {
                            label: 'Generación Nuclear (MW)',
                            data: generacionNuclear,
                            borderColor: 'purple',
                            backgroundColor: 'rgba(128, 0, 128, 0.3)',
                            borderWidth: 2,
                            fill: 'origin',
                            tension: 0.3,
                            yAxisID: 'yGeneracion', // Usar el eje Y para generación
                        },
                        {
                            label: 'Generación Renovable (MW)',
                            data: generacionRenovable,
                            borderColor: 'yellow',
                            backgroundColor: 'rgba(255, 255, 0, 0.3)',
                            borderWidth: 2,
                            fill: 'origin',
                            tension: 0.3,
                            yAxisID: 'yGeneracion', // Usar el eje Y para generación
                        },
                        {
                            label: 'Generación por Importación (MW)',
                            data: generacionImportacion,
                            borderColor: 'gray',
                            backgroundColor: 'rgba(169, 169, 169, 0.3)',
                            borderWidth: 2,
                            fill: 'origin',
                            tension: 0.3,
                            yAxisID: 'yGeneracion', // Usar el eje Y para generación
                        },
                        // Los datasets de demanda y temperatura (no apilados)
                        {
                            label: 'Demanda (MW)',
                            data: demanda,
                            borderColor: 'blue',
                            backgroundColor: 'rgba(0, 0, 255, 0.3)',
                            borderWidth: 2,
                            fill: false,
                            tension: 0.3,
                            yAxisID: 'yDemanda', // Usar el eje Y para demanda
                        },
                        {
                            label: 'Temperatura (°C)',
                            data: temperatura,
                            borderColor: 'orange',
                            backgroundColor: 'rgba(255, 165, 0, 0.3)',
                            borderWidth: 2,
                            fill: false,
                            tension: 0.3,
                            yAxisID: 'yTemperatura', // Usar el eje Y para temperatura
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        yGeneracion: {
                            position: 'left',
                            beginAtZero: true,
                            stacked: true, // Para apilar las barras
                            title: {
                                display: true,
                                text: 'Generación de Energía (MW)'
                            }
                        },
                        yDemanda: {
                            position: 'right',
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Demanda (MW)'
                            }
                        },
                        yTemperatura: {
                            position: 'right',
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Temperatura (°C)'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                    }
                }
            });
        }
    </script>
</body>
</html>
