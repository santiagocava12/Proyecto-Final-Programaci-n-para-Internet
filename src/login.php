<?php
session_start();
require 'conexion.php';

$mensaje = "";

// LÓGICA DE REGISTRO
if (isset($_POST['btn_registro'])) {
    // Escapar caracteres para seguridad
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $apellido = $conn->real_escape_string($_POST['apellido']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    // Encriptar contraseña
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // Verificar si el correo ya existe
    $check = $conn->query("SELECT id_usuario FROM usuarios WHERE email = '$email'");
    if ($check->num_rows > 0) {
        $mensaje = "<div class='alert alert-danger'>Correo ya registrado.</div>";
    } else {
        // Insertar nuevo usuario en la BD
        $sql = "INSERT INTO usuarios (nombre, apellido, email, password, rol) VALUES ('$nombre', '$apellido', '$email', '$password_hash', 'cliente')";
        if ($conn->query($sql)) {
            $mensaje = "<div class='alert alert-success'>Registro exitoso. Inicia sesión.</div>";
        } else {
            $mensaje = "<div class='alert alert-danger'>Error.</div>";
        }
    }
}

// LÓGICA DE LOGIN
if (isset($_POST['btn_login'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Buscar usuario por email
    $resultado = $conn->query("SELECT id_usuario, nombre, password, rol FROM usuarios WHERE email = '$email'");

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        // Verificar la contraseña encriptada
        if (password_verify($password, $fila['password'])) {
            // Guardar datos en sesión
            $_SESSION['id_usuario'] = $fila['id_usuario'];
            $_SESSION['nombre'] = $fila['nombre'];
            $_SESSION['rol'] = $fila['rol'];
            
            // Redirigir al index principal
            header("Location: ../index.php"); 
            exit();
        } else {
            $mensaje = "<div class='alert alert-danger'>Contraseña incorrecta.</div>";
        }
    } else {
        $mensaje = "<div class='alert alert-danger'>Usuario no encontrado.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark mb-5">
        <div class="container">
            <a class="navbar-brand" href="../index.php">⬅ Volver a GameStore</a>
        </div>
    </nav>
    <div class="container">
        <?php echo $mensaje; ?>
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">Iniciar Sesión</div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
                            <input type="password" name="password" class="form-control mb-3" placeholder="Contraseña" required>
                            <button type="submit" name="btn_login" class="btn btn-primary w-100">Entrar</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card shadow">
                    <div class="card-header bg-success text-white">Registro</div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="text" name="nombre" class="form-control mb-2" placeholder="Nombre" required>
                            <input type="text" name="apellido" class="form-control mb-2" placeholder="Apellido" required>
                            <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
                            <input type="password" name="password" class="form-control mb-3" placeholder="Contraseña" required>
                            <button type="submit" name="btn_registro" class="btn btn-success w-100">Registrarse</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>