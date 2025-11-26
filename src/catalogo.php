<?php
session_start();
require 'conexion.php';

$filtro = "";
if (isset($_GET['cat'])) {
    $cat_id = $_GET['cat'];
    $filtro = "WHERE categoria_id = $cat_id";
}

$sql = "SELECT * FROM productos $filtro";
$resultado = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo - GameStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-img-top {
            height: 200px;
            object-fit: contain;
            padding: 10px;
            background-color: #fff;
        }
    </style>
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
                        <li class="nav-item"><a class="nav-link active" href="catalogo.php">Catálogo</a></li>
                        <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                            <li class="nav-item"><a class="nav-link" href="admin.php">Administración</a></li>
                        <?php endif; ?>
                    </ul>
                    <div class="d-flex align-items-center">
                        <a href="carrito.php" class="btn btn-outline-light me-3">🛒 Carrito</a>
                        <?php if (isset($_SESSION['nombre'])): ?>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    Hola, <?php echo $_SESSION['nombre']; ?>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="logout.php">Cerrar Sesión</a></li>
                                </ul>
                            </div>
                        <?php else: ?>
                            <a href="login.php" class="btn btn-primary">Ingresar</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div class="container my-5">
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white fw-bold">Categorías</div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="catalogo.php" class="text-decoration-none text-dark fw-bold">Ver Todo</a></li>
                        <li class="list-group-item"><a href="catalogo.php?cat=1" class="text-decoration-none text-dark">Consolas</a></li>
                        <li class="list-group-item"><a href="catalogo.php?cat=2" class="text-decoration-none text-dark">Videojuegos</a></li>
                        <li class="list-group-item"><a href="catalogo.php?cat=3" class="text-decoration-none text-dark">Accesorios</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-9">
                <h2 class="mb-4 fw-bold">Catálogo Disponible</h2>
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    
                    <?php while($row = $resultado->fetch_assoc()): ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="<?php echo $row['imagen_url']; ?>" class="card-img-top" alt="<?php echo $row['nombre']; ?>">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?php echo $row['nombre']; ?></h5>
                                <p class="card-text text-muted small"><?php echo substr($row['descripcion'], 0, 60); ?>...</p>
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h4 class="text-primary mb-0">$<?php echo number_format($row['precio'], 2); ?></h4>
                                        <span class="badge bg-secondary">Stock: <?php echo $row['stock']; ?></span>
                                    </div>
                                    
                                    <?php if(isset($_SESSION['id_usuario'])): ?>
                                        <form action="carrito_acciones.php" method="POST">
                                            <input type="hidden" name="accion" value="agregar">
                                            <input type="hidden" name="id_producto" value="<?php echo $row['id_producto']; ?>">
                                            <button type="submit" class="btn btn-success w-100" <?php echo ($row['stock'] < 1) ? 'disabled' : ''; ?>>
                                                <?php echo ($row['stock'] < 1) ? 'Agotado' : 'Agregar al Carrito'; ?>
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <a href="login.php" class="btn btn-outline-primary w-100">Inicia sesión para comprar</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>