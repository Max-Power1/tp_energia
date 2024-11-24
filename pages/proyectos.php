<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demanda</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container bg-primary-subtle">
        <?php include '../drivers/menuPages.php'; ?>
        <h1 class="text-center Titulo">PROYECTOS</h1>

        <?php include("../drivers/tabla_proyectos.php") ?>

    </div>
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
