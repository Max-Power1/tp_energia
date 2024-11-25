<?php
session_start();
include './conexion.php';

// Verificar si se recibieron todos los datos requeridos
if (
    !isset($_POST['id_proyecto'], $_POST['nombre'], $_POST['fecha'], $_POST['suma_total'], 
          $_POST['hidraulica'], $_POST['termica'], $_POST['nuclear'], $_POST['renovable'], 
          $_POST['region'], $_POST['estado']) ||
    empty($_POST['id_proyecto'])
) {
    $_SESSION['message'] = "Datos incompletos para la edición del proyecto.";
    $_SESSION['message_type'] = "danger";
    header("Location: proyectos.php");
    exit();
}

// Escapar los valores recibidos para evitar inyecciones SQL
$id_proyecto = intval($_POST['id_proyecto']);
$nombre = $conn->real_escape_string(trim($_POST['nombre']));
$fecha = $conn->real_escape_string(trim($_POST['fecha']));
$suma_total = floatval($_POST['suma_total']);
$hidraulica = floatval($_POST['hidraulica']);
$termica = floatval($_POST['termica']);
$nuclear = floatval($_POST['nuclear']);
$renovable = floatval($_POST['renovable']);
$region = intval($_POST['region']);
$estado = intval($_POST['estado']);

// Preparar la consulta SQL para actualizar los datos del proyecto
$query = "
    UPDATE proyectos 
    SET 
        nombre = ?, 
        fecha = ?, 
        suma_total = ?, 
        hidraulica = ?, 
        termica = ?, 
        nuclear = ?, 
        renovable = ?, 
        region = ?, 
        estado = ?
    WHERE id_proyecto = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param(
    "ssddddiiii", 
    $nombre, $fecha, $suma_total, $hidraulica, $termica, $nuclear, $renovable, $region, $estado, $id_proyecto
);

// Ejecutar la consulta y manejar el resultado
if ($stmt->execute()) {
    $_SESSION['message'] = "Proyecto editado exitosamente.";
    $_SESSION['message_type'] = "success";
} else {
    $_SESSION['message'] = "Falla en la edición del proyecto.";
    $_SESSION['message_type'] = "danger";
}

$stmt->close();
$conn->close();

// Redirigir de vuelta a proyectos.php
header("Location: proyectos.php");
exit();
