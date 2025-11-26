<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['id_usuario']) || !isset($_POST['total_compra'])) {
    header("Location: index.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];
$total = $_POST['total_compra'];
$fecha = date('Y-m-d H:i:s');

$conn->begin_transaction();

try {
    $conn->query("INSERT INTO pedidos (id_usuario, fecha_pedido, total, estado) VALUES ($id_usuario, '$fecha', $total, 'Completado')");
    $id_pedido = $conn->insert_id;

    $carrito_items = $conn->query("SELECT id_producto, cantidad FROM carrito WHERE id_usuario = $id_usuario");

    while ($item = $carrito_items->fetch_assoc()) {
        $prod_id = $item['id_producto'];
        $cant = $item['cantidad'];
        
        $producto_info = $conn->query("SELECT precio FROM productos WHERE id_producto = $prod_id")->fetch_assoc();
        $precio_unitario = $producto_info['precio'];

        $conn->query("INSERT INTO detalle_pedido (id_pedido, id_producto, cantidad, precio_unitario) VALUES ($id_pedido, $prod_id, $cant, $precio_unitario)");
        
        $conn->query("UPDATE productos SET stock = stock - $cant WHERE id_producto = $prod_id");
    }

    $conn->query("DELETE FROM carrito WHERE id_usuario = $id_usuario");

    $conn->commit();
    
    echo "<script>alert('¡Compra realizada con éxito! Gracias por tu preferencia.'); window.location.href='../index.php';</script>";

} catch (Exception $e) {
    $conn->rollback();
    echo "Error al procesar la compra: " . $e->getMessage();
}
?>