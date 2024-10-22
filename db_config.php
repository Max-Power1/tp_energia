<?php
    // Configuración de la conexión a la base de datos
    $host = 'localhost';
    $username = 'root'; // Nombre de usuario
    $password = '';     // Contraseña
    $dbname = 'tp_energia'; // Nombre de la base de datos

    $conn = new mysqli($host, $username, $password);

    // Comprobar si hay error de conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Crear la base de datos si no existe
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    if ($conn->query($sql) === TRUE) {
        echo "Base de datos '$dbname' creada o ya existía.<br>";
    } else {
        die("Error al crear la base de datos: " . $conn->error);
    }

    // Seleccionar la base de datos
    $conn->select_db($dbname);

    // Comprobar si la base de datos fue seleccionada correctamente
    if ($conn->error) {
        die("Error al seleccionar la base de datos: " . $conn->error);
    }

    // Aquí puedes continuar con la creación de tablas o cualquier otra operación
    echo "Conexión a la base de datos '$dbname' establecida correctamente.<br>";

    // Ejemplo: Creación de una tabla si no existe (opcional)
    $sql = "CREATE TABLE IF NOT EXISTS elementos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        idElemento INT NOT NULL,
        nombre VARCHAR(255) NOT NULL,
        minEscala INT NOT NULL,
        maxEscala INT NOT NULL,
        idPadre INT NOT NULL,
        id INT NOT NULL,
        idRge INT NOT NULL
    )";

    if ($conn->query($sql) === TRUE) {
        echo "Tabla 'elementos' creada o ya existía.";
    } else {
        die("Error al crear la tabla: " . $conn->error);
    }

    // Cerrar la conexión al final (opcional)
    $conn->close();
?>