<?php
session_start();
require 'conexion.php'; // Asegúrate de que la conexión a la base de datos esté incluida

// Verifica si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $contrasena_confirmada = $_POST['contrasena_confirmada'];
    $direccion = $_POST['direccion'];
    $pais = $_POST['pais'];
    $telefono = $_POST['telefono'];
    $ciudad = $_POST['ciudad'];
    $codigo_postal = $_POST['codigo_postal'];

    // Validar que los campos no estén vacíos
    if (empty($nombre) || empty($correo) || empty($contrasena) || empty($contrasena_confirmada) || empty($direccion) || empty($pais) || empty($telefono) || empty($ciudad) || empty($codigo_postal)) {
        $error = "Todos los campos son obligatorios.";
    }
    // Verificar que las contraseñas coincidan
    elseif ($contrasena !== $contrasena_confirmada) {
        $error = "Las contraseñas no coinciden.";
    }
    // Verificar la longitud de la contraseña
    elseif (strlen($contrasena) < 6) {
        $error = "La contraseña debe tener al menos 6 caracteres.";
    }
    // Verificar si el correo electrónico ya está registrado
    else {
        $query = "SELECT * FROM usuarios WHERE correo = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $correo); // Vincula el parámetro de la consulta
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows > 0) {
            $error = "El correo electrónico ya está registrado.";
        } else {
            // Cifrar la contraseña usando AES_ENCRYPT
            $clave_cifrado = 'almandrullos';  // La clave de cifrado
            $contrasena_cifrada = openssl_encrypt($contrasena, 'AES-128-ECB', $clave_cifrado, OPENSSL_RAW_DATA);

            // Insertar el nuevo usuario en la base de datos
            $query = "INSERT INTO usuarios (nombre, correo, contrasena, direccion, pais, telefono, ciudad, codigo_postal) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssssssss", $nombre, $correo, $contrasena_cifrada, $direccion, $pais, $telefono, $ciudad, $codigo_postal);
            $stmt->execute();

            // Redirigir a la página de inicio de sesión
            $_SESSION['success'] = "¡Te has registrado exitosamente! Ahora puedes iniciar sesión.";
            header("Location: login.php");
            exit();
        }

        // Cerrar la declaración
        $stmt->close();
    }

    // Cerrar la conexión
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Registro de Usuario</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php elseif (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <form action="register.php" method="POST">
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="correo">Correo electrónico</label>
            <input type="email" class="form-control" id="correo" name="correo" required>
        </div>
        <div class="form-group">
            <label for="contrasena">Contraseña</label>
            <input type="password" class="form-control" id="contrasena" name="contrasena" required>
        </div>
        <div class="form-group">
            <label for="contrasena_confirmada">Confirmar contraseña</label>
            <input type="password" class="form-control" id="contrasena_confirmada" name="contrasena_confirmada" required>
        </div>
        <div class="form-group">
            <label for="direccion">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion" required>
        </div>
        <div class="form-group">
            <label for="pais">País</label>
            <input type="text" class="form-control" id="pais" name="pais" required>
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" required>
        </div>
        <div class="form-group">
            <label for="ciudad">Ciudad</label>
            <input type="text" class="form-control" id="ciudad" name="ciudad" required>
        </div>
        <div class="form-group">
            <label for="codigo_postal">Código Postal</label>
            <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Registrarse</button>
    </form>

    <div class="mt-3 text-center">
        <a href="login.php">¿Ya tienes cuenta? Inicia sesión aquí</a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
