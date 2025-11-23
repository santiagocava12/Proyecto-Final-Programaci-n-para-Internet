<?php
session_start();
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
            object-fit: cover; 
            background-color: #dee2e6;
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
                        <a href="carrito.php" class="btn btn-outline-light me-3">
                            🛒 Carrito
                        </a>
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
                    <div class="card-header bg-primary text-white fw-bold">
                        Filtrar por
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="#" class="text-decoration-none text-dark fw-bold">Ver Todo</a></li>
                        <li class="list-group-item"><a href="#" class="text-decoration-none text-muted">Consolas</a></li>
                        <li class="list-group-item"><a href="#" class="text-decoration-none text-muted">Videojuegos</a></li>
                        <li class="list-group-item"><a href="#" class="text-decoration-none text-muted">Accesorios</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-9">
                <h2 class="mb-4 fw-bold">Nuestros Productos</h2>
                
                <div class="alert alert-info text-center py-5">
                    <h4>Estamos actualizando el inventario</h4>
                    <p class="mb-0">Pronto encontrarás los mejores productos aquí.</p>
                </div>

                <div class="row row-cols-1 row-cols-md-3 g-4">
                    </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>