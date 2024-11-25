<?php
    session_start();
    include './conexion.php';

    // Verificar si el usuario está logueado como empresa
    if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] != 'empresa') {
        header('Location: login.php'); // Redirigir a login si no es empresa
        exit();
    }

    // Verificar si se recibieron todos los datos
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id_empresa = $_POST['id_empresa'];
        $nombre = $_POST['nombre'];
        $fecha = date('Y-m-d H:i:s'); // Fecha actual
        $suma_total = $_POST['suma_total'];
        $hidraulica = $_POST['hidraulica'];
        $termica = $_POST['termica'];
        $nuclear = $_POST['nuclear'];
        $renovable = $_POST['renovable'];
        $region = $_POST['region'];
        $estado = $_POST['estado'];

        // Validar que la suma_total coincida con la suma de las energías
        if (abs($suma_total - ($hidraulica + $termica + $nuclear + $renovable)) > 0.01) {
            $_SESSION['message'] = "La suma total no coincide con el total de energías.";
            $_SESSION['message_type'] = "danger";
            header("Location: agregar_proyecto.php");
            exit();
        }

        // Insertar el proyecto en la base de datos
        $stmt = $conn->prepare("
            INSERT INTO proyectos (id_empresa, nombre, fecha, suma_total, hidraulica, termica, nuclear, renovable, region, estado)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param('issddddiii', $id_empresa, $nombre, $fecha, $suma_total, $hidraulica, $termica, $nuclear, $renovable, $region, $estado);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Proyecto agregado exitosamente.";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Error al agregar el proyecto: " . $stmt->error;
            $_SESSION['message_type'] = "danger";
        }
        $stmt->close();

        // Redirigir al formulario con un mensaje
        header("Location: proyectos.php");
        exit();
    } else {
        header("Location: agregar_proyecto.php"); // Redirigir al formulario si no es POST
        exit();
    }
?>
