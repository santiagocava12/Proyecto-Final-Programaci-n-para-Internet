<?php
// src/conexion.php
$host = "db"; 
$usuario = "root"; 
$contrasena = "root_password"; 
$base_datos = "tienda_videojuegos";

$conn = new mysqli($host, $usuario, $contrasena, $base_datos);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>