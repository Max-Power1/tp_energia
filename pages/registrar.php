<?php
    session_start();
    include("./conexion.php");

    // Verificar conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Leer datos del formulario
    $nombre = $_POST['name'];
    $correo = $_POST['register-email'];
    $dni_cuit = $_POST['dni-cuit'];
    $password = $_POST['register-password'];
    $descripcion = isset($_POST['description']) ? $_POST['description'] : null;
    $isEmpresa = ($_POST['userType'] === 'empresa');

    // Hashear la contraseña
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Verificar si el correo ya está registrado
    $checkQuery = "SELECT correo FROM " . ($isEmpresa ? "empresas" : "usuarios") . " WHERE correo = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['message'] = "Correo ya se encuentra registrado.";
        $_SESSION['message_type'] = "error";
        header("Location: login.php");
        exit;
    }

    $stmt->close();

    // Insertar en la tabla correspondiente
    if ($isEmpresa) {
        $insertQuery = "INSERT INTO empresas (nombre, correo, cuit, password, descripcion) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ssiss", $nombre, $correo, $dni_cuit, $hashedPassword, $descripcion);
    } else {
        $insertQuery = "INSERT INTO usuarios (nombre, correo, dni, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ssis", $nombre, $correo, $dni_cuit, $hashedPassword);
    }

    if ($stmt->execute()) {
        $_SESSION['message'] = "Registro exitoso. ¡Ahora puedes iniciar sesión!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Error al registrar: " . $stmt->error;
        $_SESSION['message_type'] = "error";
    }

    $stmt->close();
    $conn->close();
    header("Location: login.php");
    exit;
?>
