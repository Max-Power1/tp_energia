<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generacion</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container bg-primary-subtle">
        <?php include '../drivers/menuPages.php'; ?>

        <h1 class="text-center text-primary">Generacion</h1>

        <div class="row">
            <div class="col"><?php include("../drivers/tabla_generacion.php"); ?></div>
            <div class="col text-center">
                <img src="../assets/mapa_camesa.png" alt="">
            </div>
        </div>

    </div>
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
