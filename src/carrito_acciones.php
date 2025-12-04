<?php
// Iniciar sesión para acceder a las variables del usuario
session_start();
require 'conexion.php'; // Conexión a la base de datos

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

// Verificar si se recibió una acción por POST
if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];

    // CASO 1: AGREGAR PRODUCTO AL CARRITO
    if ($accion == 'agregar') {
        $id_producto = $_POST['id_producto'];
        $cantidad = 1;

        // Consultar si el producto ya existe en el carrito del usuario
        $check = $conn->query("SELECT * FROM carrito WHERE id_usuario = $id_usuario AND id_producto = $id_producto");
        
        if ($check->num_rows > 0) {
            // Si existe, solo actualizamos la cantidad sumándole 1
            $conn->query("UPDATE carrito SET cantidad = cantidad + 1 WHERE id_usuario = $id_usuario AND id_producto = $id_producto");
        } else {
            // Si no existe, insertamos un nuevo registro
            $conn->query("INSERT INTO carrito (id_usuario, id_producto, cantidad) VALUES ($id_usuario, $id_producto, $cantidad)");
        }
        // Redirigir al carrito para ver los cambios
        header("Location: carrito.php");

    // CASO 2: ELIMINAR PRODUCTO DEL CARRITO
    } elseif ($accion == 'eliminar') {
        $id_carrito = $_POST['id_carrito'];
        // Borrar la fila específica del carrito
        $conn->query("DELETE FROM carrito WHERE id_carrito = $id_carrito AND id_usuario = $id_usuario");
        header("Location: carrito.php");

    // CASO 3: ACTUALIZAR CANTIDAD MANUALMENTE
    } elseif ($accion == 'actualizar') {
        $id_carrito = $_POST['id_carrito'];
        $cantidad = $_POST['cantidad'];
        
        // Solo actualizar si la cantidad es positiva
        if ($cantidad > 0) {
            $conn->query("UPDATE carrito SET cantidad = $cantidad WHERE id_carrito = $id_carrito AND id_usuario = $id_usuario");
        }
        header("Location: carrito.php");
    }
}
?>