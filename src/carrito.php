<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tu Carrito - GameStore</title>
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

    <main class="container my-5 text-center">
        <h1 class="mb-4">Carrito de Compras</h1>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm py-5">
                    <div class="card-body">
                        <div class="mb-3" style="font-size: 4rem;">🛒</div>
                        <h3 class="card-title text-muted">Tu carrito está vacío</h3>
                        <p class="card-text mb-4">Parece que aún no has agregado ningún videojuego o consola.</p>
                        <a href="catalogo.php" class="btn btn-primary btn-lg">Explorar Catálogo</a>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>