<?php
session_start();
require 'conexion.php';

// Verificar login
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];
// Consultar pedidos del usuario ordenados por fecha
$sql_pedidos = "SELECT * FROM pedidos WHERE id_usuario = $id_usuario ORDER BY fecha_pedido DESC";
$res_pedidos = $conn->query($sql_pedidos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Perfil - GameStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold" href="../index.php">🎮 GameStore</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item"><a class="nav-link" href="../index.php">Inicio</a></li>
                        <li class="nav-item"><a class="nav-link" href="catalogo.php">Catálogo</a></li>
                        <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                            <li class="nav-item"><a class="nav-link" href="admin.php">Administración</a></li>
                        <?php endif; ?>
                    </ul>
                    <div class="d-flex align-items-center">
                        <a href="carrito.php" class="btn btn-outline-light me-3">🛒 Carrito</a>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Hola, <?php echo $_SESSION['nombre']; ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="perfil.php">Mi Historial</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="logout.php">Cerrar Sesión</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div class="container my-5">
        <h2 class="mb-4">Mi Historial de Compras</h2>

        <?php if ($res_pedidos->num_rows > 0): ?>
            <div class="accordion" id="accordionPedidos">
                <?php while($pedido = $res_pedidos->fetch_assoc()): 
                    $id_pedido = $pedido['id_pedido'];
                    // Consultar el detalle (productos) de cada pedido
                    $sql_detalle = "SELECT d.*, p.nombre, p.imagen_url 
                                    FROM detalle_pedido d 
                                    JOIN productos p ON d.id_producto = p.id_producto 
                                    WHERE d.id_pedido = $id_pedido";
                    $res_detalle = $conn->query($sql_detalle);
                ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading<?php echo $id_pedido; ?>">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $id_pedido; ?>">
                            Pedido #<?php echo $id_pedido; ?> - Fecha: <?php echo $pedido['fecha_pedido']; ?> - Total: $<?php echo number_format($pedido['total'], 2); ?>
                        </button>
                    </h2>
                    <div id="collapse<?php echo $id_pedido; ?>" class="accordion-collapse collapse" data-bs-parent="#accordionPedidos">
                        <div class="accordion-body">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cant.</th>
                                        <th>Precio Unit.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($detalle = $res_detalle->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $detalle['nombre']; ?></td>
                                        <td><?php echo $detalle['cantidad']; ?></td>
                                        <td>$<?php echo number_format($detalle['precio_unitario'], 2); ?></td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                            <div class="text-end">
                                <span class="badge bg-success"><?php echo $pedido['estado']; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info">Aún no has realizado ninguna compra.</div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>