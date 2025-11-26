<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];

    if ($accion == 'agregar') {
        $id_producto = $_POST['id_producto'];
        $cantidad = 1;

        $check = $conn->query("SELECT * FROM carrito WHERE id_usuario = $id_usuario AND id_producto = $id_producto");
        
        if ($check->num_rows > 0) {
            $conn->query("UPDATE carrito SET cantidad = cantidad + 1 WHERE id_usuario = $id_usuario AND id_producto = $id_producto");
        } else {
            $conn->query("INSERT INTO carrito (id_usuario, id_producto, cantidad) VALUES ($id_usuario, $id_producto, $cantidad)");
        }
        header("Location: carrito.php");

    } elseif ($accion == 'eliminar') {
        $id_carrito = $_POST['id_carrito'];
        $conn->query("DELETE FROM carrito WHERE id_carrito = $id_carrito AND id_usuario = $id_usuario");
        header("Location: carrito.php");

    } elseif ($accion == 'actualizar') {
        $id_carrito = $_POST['id_carrito'];
        $cantidad = $_POST['cantidad'];
        
        if ($cantidad > 0) {
            $conn->query("UPDATE carrito SET cantidad = $cantidad WHERE id_carrito = $id_carrito AND id_usuario = $id_usuario");
        }
        header("Location: carrito.php");
    }
}
?>