<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container bg-primary-subtle">
        <?php include './drivers/menuIndex.php'; ?>

        <h1>Demanda en tiempo real en la Republica Argentina</h1>
        <h3>Demanda Real (MW) - Temp. Promedio de GBA y Litoral °C</h3>

        <!-- Formulario de Selección -->
        <?php include("./components/form_filtros.php"); ?>

        <!-- Contenedor para el Gráfico -->
        <div>
            <canvas id="energyChart"></canvas>
        </div>

    </div>
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="./js/script.js"></script>
</body>
</html>
