<?php
session_start();
include './conexion.php';

// Verificar si el usuario está logueado como empresa
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] != 'empresa') {
    header('Location: login.php'); // Redirigir a login si no es empresa
    exit();
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

// Obtener regiones para la lista seleccionable
$queryRegiones = "SELECT id_regiones, nombre FROM regiones";
$resultRegiones = $conn->query($queryRegiones);
$regiones = [];
if ($resultRegiones->num_rows > 0) {
    while ($row = $resultRegiones->fetch_assoc()) {
        $regiones[] = $row;
    }
}
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
        <h1 class="text-center text-primary">Describa su proyecto nuevo</h1>
        
        <!-- Mostrar mensaje -->
        <?php echo $message; ?>

        <section class="text-start text-dark">
            <!-- Formulario para agregar proyecto -->
            <form method="POST" action="insertando_proyecto.php">
                <!-- Campo oculto con el ID de la empresa -->
                <input type="hidden" name="id_empresa" value="<?php echo $_SESSION['id_usuario']; ?>">

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre del Proyecto</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>

                <div class="mb-3">
                    <label for="suma_total" class="form-label">Suma Total (MW)</label>
                    <input type="number" step="0.01" class="form-control" id="suma_total" name="suma_total" required>
                </div>

                <div class="mb-3">
                    <label for="hidraulica" class="form-label">Hidráulica (MW)</label>
                    <input type="number" step="0.01" class="form-control" id="hidraulica" name="hidraulica" required>
                </div>

                <div class="mb-3">
                    <label for="termica" class="form-label">Térmica (MW)</label>
                    <input type="number" step="0.01" class="form-control" id="termica" name="termica" required>
                </div>

                <div class="mb-3">
                    <label for="nuclear" class="form-label">Nuclear (MW)</label>
                    <input type="number" step="0.01" class="form-control" id="nuclear" name="nuclear" required>
                </div>

                <div class="mb-3">
                    <label for="renovable" class="form-label">Renovable (MW)</label>
                    <input type="number" step="0.01" class="form-control" id="renovable" name="renovable" required>
                </div>

                <div class="mb-3">
                    <label for="region" class="form-label">Región</label>
                    <select class="form-select" id="region" name="region" required>
                        <option value="" disabled selected>Seleccione una región</option>
                        <?php foreach ($regiones as $region): ?>
                            <option value="<?php echo $region['id_regiones']; ?>"><?php echo $region['nombre']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Estado predeterminado (oculto) -->
                <input type="hidden" name="estado" value="4">
                <div class="mb-3 text-end">           
                    <button type="submit" class="btn btn-primary">Guardar Proyecto</button>
                </div>
            </form>
        </section>
    </div>
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
