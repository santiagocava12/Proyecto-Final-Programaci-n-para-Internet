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
    <style>
        .hero-section {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: white;
            padding: 100px 0;
        }
        .feature-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #0d6efd;
        }
        .category-card {
            transition: transform 0.3s;
            cursor: pointer;
            height: 100%;
        }
        .category-card:hover {
            transform: translateY(-5px);
        }
        .placeholder-box {
            height: 150px;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #6c757d;
        }
    </style>
</head>
<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold" href="index.php">🎮 GameStore</a>
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
                        <a href="src/carrito.php" class="btn btn-outline-light me-3 position-relative">
                            🛒 Carrito
                        </a>
                        <?php if (isset($_SESSION['nombre'])): ?>
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    Hola, <?php echo $_SESSION['nombre']; ?>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="src/logout.php">Cerrar Sesión</a></li>
                                </ul>
                            </div>
                        <?php else: ?>
                            <a href="src/login.php" class="btn btn-light">Ingresar / Registro</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <section class="hero-section text-center mb-5">
        <div class="container">
            <h1 class="display-3 fw-bold mb-3">Sube de Nivel tu Experiencia</h1>
            <p class="lead mb-4">Las mejores consolas, videojuegos y accesorios en un solo lugar.</p>
            <a href="src/catalogo.php" class="btn btn-primary btn-lg px-5">Ver Catálogo Completo</a>
        </div>
    </section>

    <section class="container mb-5">
        <div class="row text-center g-4">
            <div class="col-md-4">
                <div class="p-4 border rounded shadow-sm h-100 bg-white">
                    <div class="feature-icon">🚀</div>
                    <h3>Envíos Rápidos</h3>
                    <p class="text-muted">Recibe tus juegos al día siguiente.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 border rounded shadow-sm h-100 bg-white">
                    <div class="feature-icon">🔒</div>
                    <h3>Compra Segura</h3>
                    <p class="text-muted">Protección total en tus pagos.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 border rounded shadow-sm h-100 bg-white">
                    <div class="feature-icon">🎧</div>
                    <h3>Soporte Gamer</h3>
                    <p class="text-muted">Atención especializada 24/7.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-5 fw-bold">Categorías Destacadas</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card category-card shadow-sm border-0">
                        <div class="placeholder-box bg-dark text-white">CONSOLAS</div>
                        <div class="card-body text-center">
                            <h5 class="card-title">Next-Gen</h5>
                            <a href="src/catalogo.php" class="btn btn-outline-dark btn-sm mt-2">Ver Consolas</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card category-card shadow-sm border-0">
                        <div class="placeholder-box bg-primary text-white">VIDEOJUEGOS</div>
                        <div class="card-body text-center">
                            <h5 class="card-title">Lanzamientos</h5>
                            <a href="src/catalogo.php" class="btn btn-outline-primary btn-sm mt-2">Ver Juegos</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card category-card shadow-sm border-0">
                        <div class="placeholder-box bg-danger text-white">ACCESORIOS</div>
                        <div class="card-body text-center">
                            <h5 class="card-title">Periféricos</h5>
                            <a href="src/catalogo.php" class="btn btn-outline-danger btn-sm mt-2">Ver Accesorios</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-white text-center py-4 mt-auto">
        <div class="container">
            <p class="mb-0">&copy; 2025 GameStore. Proyecto Final.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>