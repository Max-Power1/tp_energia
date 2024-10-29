<?php
// registrar_persona.php

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recibir y limpiar los datos enviados
    $nombre = isset($_POST['nombre']) ? htmlspecialchars(trim($_POST['nombre'])) : '';
    $apellido = isset($_POST['apellido']) ? htmlspecialchars(trim($_POST['apellido'])) : '';
    $dni = isset($_POST['dni']) ? htmlspecialchars(trim($_POST['dni'])) : '';
    $correo = isset($_POST['correo']) ? htmlspecialchars(trim($_POST['correo'])) : '';

    // Verificación básica de que todos los campos están completos
    if (!empty($nombre) && !empty($apellido) && !empty($dni) && !empty($correo)) {
        // Aquí puedes realizar operaciones como guardar los datos en una base de datos
        // o enviar un correo electrónico de confirmación, etc.

        // Abro la conexion a la BBDD
        include "../model/conexion.php";

        // Preparar la consulta usando 'mysqli' en lugar de 'PDO'
        $query = $conn->prepare("INSERT INTO persona (nombre, apellido, dni, correo) VALUES (?, ?, ?, ?)");

        // Bind de los parámetros
        $query->bind_param("ssss", $nombre, $apellido, $dni, $correo);

        // Ejecutar la consulta
        $query->execute();

        // Redirigir a iniciar_sesion.php con un parámetro de éxito
        header("Location: ../pages/iniciar_sesion.php?registro=exitoso");
        exit();

    } else {
        // Mensaje de error si faltan campos
        echo "<p>Error: Por favor completa todos los campos.</p>";
    }
} else {
    // Si no se accedió al archivo mediante POST, redirigir o mostrar mensaje
    echo "<p>Error: Acceso no permitido.</p>";
}
?>
