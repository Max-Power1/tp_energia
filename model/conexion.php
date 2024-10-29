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

// Seleccionar la base de datos y establecer la codificación en UTF-8
$conn->select_db($dbname);
$conn->set_charset("utf8");

// Crear las tablas en el orden correcto si no existen
$tables = [
    "roles" => "CREATE TABLE IF NOT EXISTS roles (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    tipoRol VARCHAR(50)
                )",
                
    "estado" => "CREATE TABLE IF NOT EXISTS estado (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    tipo_estado VARCHAR(50)
                )",
                
    "regiones" => "CREATE TABLE IF NOT EXISTS regiones (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    idElemento INT,
                    nombre VARCHAR(100),
                    idPadre INT
                )",
                
    "energia" => "CREATE TABLE IF NOT EXISTS energia (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    tipo_energia VARCHAR(100)
                )",
                
    "empresa" => "CREATE TABLE IF NOT EXISTS empresa (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    nombre VARCHAR(100),
                    proyecto INT,
                    apellido VARCHAR(100),
                    razon_social VARCHAR(100),
                    cuit VARCHAR(11),
                    correo VARCHAR(100),
                    rol INT,
                    FOREIGN KEY (rol) REFERENCES roles(id)
                )",
                
    "persona" => "CREATE TABLE IF NOT EXISTS persona (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    nombre VARCHAR(100),
                    apellido VARCHAR(100),
                    dni VARCHAR(8),
                    correo VARCHAR(100),
                    rol INT,
                    FOREIGN KEY (rol) REFERENCES roles(id)
                )",
                
    "proyecto" => "CREATE TABLE IF NOT EXISTS proyecto (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    empresa INT,
                    region INT,
                    potencia FLOAT,
                    tipo_energia INT,
                    estado INT,
                    FOREIGN KEY (empresa) REFERENCES empresa(id),
                    FOREIGN KEY (region) REFERENCES regiones(id),
                    FOREIGN KEY (tipo_energia) REFERENCES energia(id),
                    FOREIGN KEY (estado) REFERENCES estado(id)
                )",
                
    "demanda" => "CREATE TABLE IF NOT EXISTS demanda (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    dem FLOAT,
                    fecha DATE
                )",
                
    "generacion" => "CREATE TABLE IF NOT EXISTS generacion (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    fecha DATE,
                    sumTotal FLOAT,
                    hidraulico FLOAT,
                    termico FLOAT,
                    nuclear FLOAT,
                    renovable FLOAT
                )",
                
    "ofertaEnergetica" => "CREATE TABLE IF NOT EXISTS ofertaEnergetica (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    fecha DATE,
                    sumTotal FLOAT,
                    hidraulico FLOAT,
                    termico FLOAT,
                    nuclear FLOAT,
                    renovable FLOAT
                )",
                
    "proyeccion" => "CREATE TABLE IF NOT EXISTS proyeccion (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    fecha DATE,
                    sumGeneral FLOAT,
                    sumaHidraulico FLOAT,
                    sumaTermico FLOAT,
                    sumaNuclear FLOAT,
                    sumaRenovable FLOAT
                )"
];

// Ejecutar cada consulta para crear las tablas
foreach ($tables as $table_name => $create_query) {
    if ($conn->query($create_query) === TRUE) {
        echo "Tabla '$table_name' creada o ya existía.<br>";
    } else {
        echo "Error al crear la tabla '$table_name': " . $conn->error . "<br>";
    }
}

// Cerrar la conexión
// $conn->close();
?>
