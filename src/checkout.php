<?php
session_start();
require 'conexion.php';

// Validar que hay datos para procesar
if (!isset($_SESSION['id_usuario']) || !isset($_POST['total_compra'])) {
    header("Location: ../index.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];
$total = $_POST['total_compra'];
$fecha = date('Y-m-d H:i:s');

// Iniciar transacción (asegura que todo se guarde o nada)
$conn->begin_transaction();

try {
    // 1. Crear el Pedido en la tabla Pedidos
    $conn->query("INSERT INTO pedidos (id_usuario, fecha_pedido, total, estado) VALUES ($id_usuario, '$fecha', $total, 'Completado')");
    $id_pedido = $conn->insert_id; // Obtener ID generado

    // 2. Obtener productos del carrito
    $carrito_items = $conn->query("SELECT id_producto, cantidad FROM carrito WHERE id_usuario = $id_usuario");

    while ($item = $carrito_items->fetch_assoc()) {
        $prod_id = $item['id_producto'];
        $cant = $item['cantidad'];
        
        // Obtener precio actual
        $producto_info = $conn->query("SELECT precio FROM productos WHERE id_producto = $prod_id")->fetch_assoc();
        $precio_unitario = $producto_info['precio'];

        // Guardar detalle
        $conn->query("INSERT INTO detalle_pedido (id_pedido, id_producto, cantidad, precio_unitario) VALUES ($id_pedido, $prod_id, $cant, $precio_unitario)");
        
        // Restar inventario (Stock)
        $conn->query("UPDATE productos SET stock = stock - $cant WHERE id_producto = $prod_id");
    }

    // 3. Vaciar carrito
    $conn->query("DELETE FROM carrito WHERE id_usuario = $id_usuario");

    // Confirmar transacción
    $conn->commit();
    
    // Mensaje de éxito y redirección
    $_SESSION['mensaje_exito'] = "¡Compra realizada con éxito! Gracias por tu preferencia.";
    header("Location: carrito.php");
    exit();

} catch (Exception $e) {
    // Si hay error, deshacer cambios
    $conn->rollback();
    echo "Error al procesar la compra: " . $e->getMessage();
}
?>