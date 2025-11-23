<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catálogo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="../index.php">🎮 GameStore</a>
                
                <div class="collapse navbar-collapse">
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
                            <a href="login.php" class="btn btn-primary">Login</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div class="container my-5">
        <h1>Catálogo</h1>
        <p>Próximamente...</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>