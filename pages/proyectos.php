<?php
session_start();
include './conexion.php';

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta para obtener los proyectos con los nombres de las relaciones
$query = "
    SELECT 
        p.id_proyecto, 
        e.id_empresa, 
        e.nombre AS empresa, 
        p.nombre AS proyecto, 
        p.fecha, 
        p.suma_total, 
        p.hidraulica, 
        p.termica, 
        p.nuclear, 
        p.renovable, 
        r.nombre AS region, 
        es.nombre AS estado
    FROM proyectos p
    JOIN empresas e ON p.id_empresa = e.id_empresa
    JOIN regiones r ON p.region = r.id_regiones
    JOIN estados es ON p.estado = es.id_estados
    ORDER BY p.id_proyecto ASC
";
$result = $conn->query($query);

// Almacenar los datos en un array para la tabla y el gráfico
$proyectos = [];
while ($row = $result->fetch_assoc()) {
    $proyectos[] = $row;
}
// Cerrar conexión
$conn->close();

// Mostrar mensajes si existen
$message = "";
if (isset($_SESSION['message'])) {
    $message = "<div class='my-2 alert alert-" . ($_SESSION['message_type'] === "success" ? "success" : "danger") . "'>" 
            . $_SESSION['message'] . 
            "</div>";
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Proyectos</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container Fondo-principal">
        <?php include '../drivers/menuPages.php'; ?>
        <h1 class="mb-4 mt-3">Listado de Proyectos</h1>
        <!-- Mostrar mensaje -->
        <?php echo $message; ?>
        <!-- Tabla -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Proyecto</th>
                        <th>Empresa</th>
                        <th>Nombre del Proyecto</th>
                        <th>Suma Total (MW)</th>
                        <th>Hidráulica (MW)</th>
                        <th>Térmica (MW)</th>
                        <th>Nuclear (MW)</th>
                        <th>Renovable (MW)</th>
                        <th>Región</th>
                        <th>Estado</th>
                        <!-- Columna "Acciones" visible solo para empresas -->
                        <?php if (isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'empresa'): ?>
                            <th>Acciones</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($proyectos as $proyecto): ?>
                        <tr>
                            <td><?= $proyecto['id_proyecto'] ?></td>
                            <td><?= $proyecto['empresa'] ?></td>
                            <td><?= $proyecto['proyecto'] ?></td>
                            <td><?= $proyecto['suma_total'] ?></td>
                            <td><?= $proyecto['hidraulica'] ?></td>
                            <td><?= $proyecto['termica'] ?></td>
                            <td><?= $proyecto['nuclear'] ?></td>
                            <td><?= $proyecto['renovable'] ?></td>
                            <td><?= $proyecto['region'] ?></td>
                            <td><?= $proyecto['estado'] ?></td>
                                                        <!-- Botón "Editar" solo visible para empresas -->
                                                        <?php if (isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'empresa'): ?>
                                <td>
                                    <a href="editar_proyecto.php?id=<?= $proyecto['id_proyecto'] ?>" 
                                       class="btn btn-sm <?= ($proyecto['id_empresa'] == $_SESSION['id_usuario']) ? 'btn-warning' : 'btn-secondary disabled' ?>">
                                        Editar
                                    </a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Botón agregar proyecto (visible solo para empresas) -->
        <?php if (isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'empresa'): ?>
            <a href="agregar_proyecto.php" class="btn btn-primary my-3">Agregar Proyecto</a>
        <?php endif; ?>

        <!-- Gráfico -->
        <h2 class="my-4">Gráfico de Proyectos por Tipo de Energía</h2>
        <canvas id="chartProyectos" width="400" height="200"></canvas>
    </div>

    <script src="../js/bootstrap.bundle.min.js"></script>
    <script>
        // Preparar los datos para el gráfico
        const proyectos = <?= json_encode($proyectos) ?>;
        const nombres = proyectos.map(p => p.proyecto);
        const hidraulica = proyectos.map(p => parseFloat(p.hidraulica));
        const termica = proyectos.map(p => parseFloat(p.termica));
        const nuclear = proyectos.map(p => parseFloat(p.nuclear));
        const renovable = proyectos.map(p => parseFloat(p.renovable));

        // Crear el gráfico
        const ctx = document.getElementById('chartProyectos').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: nombres,
                datasets: [
                    { label: 'Hidráulica', data: hidraulica, backgroundColor: 'rgba(54, 162, 235, 0.7)' },
                    { label: 'Térmica', data: termica, backgroundColor: 'rgba(255, 99, 132, 0.7)' },
                    { label: 'Nuclear', data: nuclear, backgroundColor: 'rgba(75, 192, 192, 0.7)' },
                    { label: 'Renovable', data: renovable, backgroundColor: 'rgba(153, 102, 255, 0.7)' }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' }
                },
                scales: {
                    x: { title: { display: true, text: 'Proyectos' } },
                    y: { title: { display: true, text: 'Energía (MW)' }, beginAtZero: true }
                }
            }
        });
    </script>
</body>
</html>
