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
            es.nombre AS estado
        FROM proyectos p
        JOIN regiones r ON p.region = r.id_regiones
        JOIN estados es ON p.estado = es.id_estados
        WHERE es.nombre NOT IN ('Completado', 'Terminado')
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
    <title>Proveedores</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container Fondo-principal">
        <?php include '../drivers/menuPages.php'; ?>
        <h1 class="text-center text-primary">PROYECCION</h1>

        <?php include("../drivers/tabla_proyeccion.php") ?>

    </div>
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
