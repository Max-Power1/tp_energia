<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = ""; // Cambia según tu configuración
$dbname = "sinergia";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset('utf8mb4');
?>