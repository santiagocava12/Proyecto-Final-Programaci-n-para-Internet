<?php
session_start();
require 'conexion.php';

// Verificar seguridad: solo admins pueden entrar
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$mensaje = "";

// Procesar formulario de admin
if (isset($_POST['accion'])) {
    
    // CASO AGREGAR PRODUCTO
    if ($_POST['accion'] == 'agregar') {
        $nombre = $conn->real_escape_string($_POST['nombre']);
        $descripcion = $conn->real_escape_string($_POST['descripcion']);
        $precio = $_POST['precio'];
        $stock = $_POST['stock'];
        $categoria = $_POST['categoria'];
        
        $imagen_url = "";
        
        // Manejo de subida de imagen local
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            $directorio = "uploads/";
            if (!file_exists($directorio)) {
                mkdir($directorio, 0777, true);
            }
            $nombre_archivo = time() . "_" . basename($_FILES["imagen"]["name"]);
            $ruta_completa = $directorio . $nombre_archivo;
            
            if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $ruta_completa)) {
                $imagen_url = "uploads/" . $nombre_archivo;
            }
        } else {
            // Si no sube imagen, usa la URL de texto
            $imagen_url = $conn->real_escape_string($_POST['imagen_url_texto']); 
        }

        // Insertar en BD
        $sql = "INSERT INTO productos (nombre, descripcion, precio, stock, imagen_url, categoria_id) 
                VALUES ('$nombre', '$descripcion', $precio, $stock, '$imagen_url', $categoria)";
        
        if ($conn->query($sql)) {
            $mensaje = "<div class='alert alert-success'>Producto agregado correctamente.</div>";
        } else {
            $mensaje = "<div class='alert alert-danger'>Error al agregar: " . $conn->error . "</div>";
        }
    }

    // CASO ELIMINAR PRODUCTO
    if ($_POST['accion'] == 'eliminar') {
        $id = $_POST['id_producto'];
        $conn->query("DELETE FROM productos WHERE id_producto = $id");
        $mensaje = "<div class='alert alert-warning'>Producto eliminado.</div>";
    }
}

// Consultar inventario para mostrar en tabla
$productos = $conn->query("SELECT * FROM productos ORDER BY id_producto DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administración - GameStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">🎮 GameStore Admin</a>
            <a href="../index.php" class="btn btn-outline-light">Volver a la Tienda</a>
        </div>
    </nav>

    <div class="container">
        <h1 class="mb-4">Panel de Administración</h1>
        <?php echo $mensaje; ?>

        <div class="card mb-5 shadow-sm">
            <div class="card-header bg-primary text-white">Agregar Nuevo Producto</div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="accion" value="agregar">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Nombre del Producto</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Precio</label>
                            <input type="number" step="0.01" name="precio" class="form-control" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Stock Inicial</label>
                            <input type="number" name="stock" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Categoría</label>
                            <select name="categoria" class="form-select">
                                <option value="1">Consolas</option>
                                <option value="2">Videojuegos</option>
                                <option value="3">Accesorios</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Subir Imagen (Local)</label>
                            <input type="file" name="imagen" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>O URL de Imagen (Web)</label>
                            <input type="text" name="imagen_url_texto" class="form-control" placeholder="https://...">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Guardar Producto</button>
                </form>
            </div>
        </div>

        <h3 class="mb-3">Inventario Actual</h3>
        <div class="table-responsive bg-white rounded shadow-sm p-3">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $productos->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id_producto']; ?></td>
                        <td>
                            <img src="<?php echo $row['imagen_url']; ?>" width="50" style="height: 50px; object-fit: contain;">
                        </td>
                        <td><?php echo $row['nombre']; ?></td>
                        <td>$<?php echo number_format($row['precio'], 2); ?></td>
                        <td>
                            <span class="badge <?php echo ($row['stock'] < 5) ? 'bg-danger' : 'bg-success'; ?>">
                                <?php echo $row['stock']; ?>
                            </span>
                        </td>
                        <td>
                            <form method="POST" onsubmit="return confirm('¿Eliminar este producto?');">
                                <input type="hidden" name="accion" value="eliminar">
                                <input type="hidden" name="id_producto" value="<?php echo $row['id_producto']; ?>">
                                <button class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>