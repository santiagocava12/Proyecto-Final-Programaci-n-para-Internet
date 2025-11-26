<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];
$sql = "SELECT c.id_carrito, c.cantidad, p.nombre, p.precio, p.imagen_url 
        FROM carrito c 
        JOIN productos p ON c.id_producto = p.id_producto 
        WHERE c.id_usuario = $id_usuario";
$resultado = $conn->query($sql);
$total = 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito - GameStore</title>
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
                        <a href="carrito.php" class="btn btn-light me-3 active">🛒 Carrito</a>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Hola, <?php echo $_SESSION['nombre']; ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="logout.php">Cerrar Sesión</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="container my-5">
        <h1 class="mb-4">Tu Carrito de Compras</h1>

        <?php if (isset($_SESSION['mensaje_exito'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>✅ ¡Excelente!</strong> <?php echo $_SESSION['mensaje_exito']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['mensaje_exito']); ?>
        <?php endif; ?>

        <?php if ($resultado->num_rows > 0): ?>
            <div class="row">
                <div class="col-md-9">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle bg-white shadow-sm rounded">
                            <thead class="table-dark">
                                <tr>
                                    <th>Producto</th>
                                    <th>Precio</th>
                                    <th style="width: 15%;">Cantidad</th>
                                    <th>Subtotal</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($item = $resultado->fetch_assoc()): 
                                    $subtotal = $item['precio'] * $item['cantidad'];
                                    $total += $subtotal;
                                ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="<?php echo $item['imagen_url']; ?>" width="50" class="me-3 rounded">
                                            <span><?php echo $item['nombre']; ?></span>
                                        </div>
                                    </td>
                                    <td>$<?php echo number_format($item['precio'], 2); ?></td>
                                    <td>
                                        <form action="carrito_acciones.php" method="POST">
                                            <input type="hidden" name="accion" value="actualizar">
                                            <input type="hidden" name="id_carrito" value="<?php echo $item['id_carrito']; ?>">
                                            <input type="number" name="cantidad" value="<?php echo $item['cantidad']; ?>" min="1" class="form-control" onchange="this.form.submit()">
                                        </form>
                                    </td>
                                    <td class="fw-bold">$<?php echo number_format($subtotal, 2); ?></td>
                                    <td>
                                        <form action="carrito_acciones.php" method="POST">
                                            <input type="hidden" name="accion" value="eliminar">
                                            <input type="hidden" name="id_carrito" value="<?php echo $item['id_carrito']; ?>">
                                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">Resumen</div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3 fw-bold fs-5">
                                <span>Total:</span>
                                <span class="text-success">$<?php echo number_format($total, 2); ?></span>
                            </div>
                            <hr>
                            <form action="checkout.php" method="POST">
                                <input type="hidden" name="total_compra" value="<?php echo $total; ?>">
                                <button type="submit" class="btn btn-success w-100 btn-lg">Finalizar Compra</button>
                            </form>
                            <a href="catalogo.php" class="btn btn-outline-secondary w-100 mt-2">Seguir comprando</a>
                        </div>
                    </div>
                </div>
            </div>
        
        <?php else: ?>
            <div class="alert alert-info text-center py-5 shadow-sm">
                <div style="font-size: 4rem;">🛒</div>
                <h3 class="mt-3">Tu carrito está vacío</h3>
                <p>¿No sabes qué jugar? ¡Revisa nuestras ofertas!</p>
                <a href="catalogo.php" class="btn btn-primary mt-3">Ir al Catálogo</a>
            </div>
        <?php endif; ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>