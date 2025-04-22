<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <!-- Bootstrap 5 + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Tipografía -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Open+Sans&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #000;
            color: #f8f9fa;
            font-family: 'Open Sans', sans-serif;
        }

        .form-container {
            max-width: 550px;
            margin: auto;
            margin-top: 80px;
            padding: 40px;
            background-color: #111;
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(245, 197, 24, 0.2);
        }

        h2 {
            font-family: 'Playfair Display', serif;
            text-align: center;
            color: #f5c518;
            margin-bottom: 30px;
        }

        .form-label {
            color: #f5c518;
        }

        .form-control {
            background-color: #000;
            border: 1px solid #333;
            color: #f5c518;
        }

        .form-control::placeholder {
            color: #888;
        }

        .btn-primary {
            background-color: #f5c518;
            border: none;
            color: #000;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #e6b800;
            color: #fff;
        }

        .alert {
            border-radius: 8px;
        }

        a {
            color: #f5c518;
        }

        a:hover {
            color: #e6b800;
        }
    </style>
</head>
<body>
<?php require 'navbar.php';?>
<div class="form-container">
    <h2><i class="bi bi-person-plus-fill me-2"></i>Registro de Usuario</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php elseif (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <form action="register.php" method="POST" class="mt-3">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Tu nombre completo" required>
        </div>
        <div class="mb-3">
            <label for="correo" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" id="correo" name="correo" placeholder="ejemplo@correo.com" required>
        </div>
        <div class="mb-3">
            <label for="contrasena" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="contrasena" name="contrasena" required>
        </div>
        <div class="mb-3">
            <label for="contrasena_confirmada" class="form-label">Confirmar contraseña</label>
            <input type="password" class="form-control" id="contrasena_confirmada" name="contrasena_confirmada" required>
        </div>
        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion" required>
        </div>
        <div class="mb-3">
            <label for="pais" class="form-label">País</label>
            <input type="text" class="form-control" id="pais" name="pais" required>
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" required>
        </div>
        <div class="mb-3">
            <label for="ciudad" class="form-label">Ciudad</label>
            <input type="text" class="form-control" id="ciudad" name="ciudad" required>
        </div>
        <div class="mb-4">
            <label for="codigo_postal" class="form-label">Código Postal</label>
            <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Registrarse</button>
    </form>

    <div class="mt-4 text-center">
        ¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
