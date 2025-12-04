<?php
// Configuración de la base de datos
$host = "db"; // Nombre del servicio en Docker Compose
$usuario = "root"; 
$contrasena = "root_password"; 
$base_datos = "tienda_videojuegos";

// Crear conexión usando MySQLi
$conn = new mysqli($host, $usuario, $contrasena, $base_datos);

// Verificar si hubo error en la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>