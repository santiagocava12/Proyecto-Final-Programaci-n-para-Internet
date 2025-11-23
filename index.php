<?php
session_start(); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - GameStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">🎮 GameStore</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link active" href="index.php">Inicio</a></li>
                        <li class="nav-item"><a class="nav-link" href="src/catalogo.php">Catálogo</a></li>
                        
                        <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                            <li class="nav-item"><a class="nav-link" href="src/admin.php">Administración</a></li>
                        <?php endif; ?>
                    </ul>

                    <div class="d-flex align-items-center">
                        <a href="src/carrito.php" class="btn btn-outline-light me-3">🛒 Carrito</a>

                        <?php if (isset($_SESSION['nombre'])): ?>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    Hola, <?php echo $_SESSION['nombre']; ?>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="src/logout.php">Cerrar Sesión</a></li>
                                </ul>
                            </div>
                        <?php else: ?>
                            <a href="src/login.php" class="btn btn-primary">Ingresar / Registro</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="container my-5">
        <div class="text-center">
            <h1>Bienvenido a GameStore</h1>
            <p class="lead">Tu tienda favorita de videojuegos y consolas.</p>
            <a href="src/catalogo.php" class="btn btn-lg btn-success mt-3">Ver Productos</a>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>