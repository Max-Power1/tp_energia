<?php
// Iniciar sesión para poder almacenar los datos
session_start();

// Incluir el archivo de configuración para la conexión a la base de datos
include './conexion.php';

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Variables para el formulario de login
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$isEmpresa = ($_POST['userLogin'] === 'empresa');

print($email . " " . $password . " " . " " . $isEmpresa);

// Variables para el mensaje
$message = "";
$message_type = "";

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si el correo es de una persona o empresa (se podría hacer con un campo hidden o con la lógica de la aplicación)
    $user_type = $isEmpresa ? 'empresa' : 'persona';  // Definir el tipo de usuario

    // Consulta para la tabla correspondiente
    if ($user_type == 'persona') {
        // Buscar en la tabla "usuarios" (persona)
        $query = "SELECT id_usuario, nombre, correo, password FROM usuarios WHERE correo = ?";
    } else {
        // Buscar en la tabla "empresas" (empresa)
        $query = "SELECT id_empresa AS id_usuario, nombre, correo, password FROM empresas WHERE correo = ?";
    }

    // Preparar la consulta
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);  // Vincular el correo a la consulta

    // Ejecutar la consulta
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Verificar si se encontró el usuario
    if ($result->num_rows > 0) {
        // Si se encuentra el usuario
        $user = $result->fetch_assoc();

        // Verificar la contraseña (debe ser la misma que la almacenada en la base de datos)
        if (password_verify($password, $user['password'])) {
            // Si la contraseña es correcta, crear la sesión
            $_SESSION['id_usuario'] = $user['id_usuario'];
            $_SESSION['nombre'] = $user['nombre'];
            $_SESSION['correo'] = $user['correo'];
            $_SESSION['tipo'] = $user_type;  // "persona" o "empresa"

            // Redirigir al usuario a la página principal o dashboard
            header("Location: login.php");
            exit();
        } else {
            // Si la contraseña es incorrecta
            $_SESSION['message'] = "Contraseña incorrecta";
            $_SESSION['message_type'] = "danger";
        }
    } else {
        // Si el correo no se encuentra en ninguna tabla
        $_SESSION['message'] = "Usuario no registrado";
        $_SESSION['message_type'] = "danger";
    }

    // Redirigir de vuelta al formulario con el mensaje
    // comentados dos
    header("Location: login.php");
    exit();
}
?>
