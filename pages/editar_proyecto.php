<?php
session_start();
include './conexion.php';

// Verificar si se recibió el ID por URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['message'] = "ID de proyecto no especificado.";
    $_SESSION['message_type'] = "danger";
    header("Location: proyectos.php");
    exit();
}

$id_proyecto = intval($_GET['id']);

// Obtener información del proyecto
$query_proyecto = "
    SELECT 
        p.id_proyecto, 
        p.nombre AS proyecto, 
        p.fecha, 
        p.suma_total, 
        p.hidraulica, 
        p.termica, 
        p.nuclear, 
        p.renovable, 
        p.region, 
        p.estado 
    FROM proyectos p
    WHERE p.id_proyecto = ?
";
$stmt = $conn->prepare($query_proyecto);
$stmt->bind_param("i", $id_proyecto);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['message'] = "Proyecto no encontrado.";
    $_SESSION['message_type'] = "danger";
    header("Location: proyectos.php");
    exit();
}

$proyecto = $result->fetch_assoc();
$stmt->close();

// Obtener lista de regiones
$query_regiones = "SELECT id_regiones, nombre FROM regiones";
$regiones_result = $conn->query($query_regiones);
$regiones = $regiones_result->fetch_all(MYSQLI_ASSOC);

// Obtener lista de estados
$query_estados = "SELECT id_estados, nombre FROM estados";
$estados_result = $conn->query($query_estados);
$estados = $estados_result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Proyecto</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container Fondo-principal">
        <?php include '../drivers/menuPages.php'; ?>
        <h1 class="mb-4">Editar Proyecto</h1>

        <!-- Mostrar mensajes -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?= $_SESSION['message_type']; ?>">
                <?= $_SESSION['message']; ?>
            </div>
            <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
        <?php endif; ?>
        <section class="text-start text-dark">
            <!-- Formulario de edición -->
            <form action="procesar_edicion.php" method="POST">
                <input type="hidden" name="id_proyecto" value="<?= $proyecto['id_proyecto']; ?>">

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre del Proyecto</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $proyecto['proyecto']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input type="date" class="form-control" id="fecha" name="fecha" value="<?= $proyecto['fecha']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="suma_total" class="form-label">Suma Total (MW)</label>
                    <input type="number" step="0.01" class="form-control" id="suma_total" name="suma_total" value="<?= $proyecto['suma_total']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="hidraulica" class="form-label">Hidráulica (MW)</label>
                    <input type="number" step="0.01" class="form-control" id="hidraulica" name="hidraulica" value="<?= $proyecto['hidraulica']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="termica" class="form-label">Térmica (MW)</label>
                    <input type="number" step="0.01" class="form-control" id="termica" name="termica" value="<?= $proyecto['termica']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="nuclear" class="form-label">Nuclear (MW)</label>
                    <input type="number" step="0.01" class="form-control" id="nuclear" name="nuclear" value="<?= $proyecto['nuclear']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="renovable" class="form-label">Renovable (MW)</label>
                    <input type="number" step="0.01" class="form-control" id="renovable" name="renovable" value="<?= $proyecto['renovable']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="region" class="form-label">Región</label>
                    <select class="form-select" id="region" name="region" required>
                        <?php foreach ($regiones as $region): ?>
                            <option value="<?= $region['id_regiones']; ?>" <?= $region['id_regiones'] == $proyecto['region'] ? 'selected' : ''; ?>>
                                <?= $region['nombre']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="estado" class="form-label">Estado</label>
                    <select class="form-select" id="estado" name="estado" required>
                        <?php foreach ($estados as $estado): ?>
                            <option value="<?= $estado['id_estados']; ?>" <?= $estado['id_estados'] == $proyecto['estado'] ? 'selected' : ''; ?>>
                                <?= $estado['nombre']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="proyectos.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </section>

    </div>
</body>
</html>
