<?php
if (!isset($titulo)) $titulo = "Tienda Online";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($titulo) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Tipografía elegante (opcional) -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Open+Sans&display=swap" rel="stylesheet">

     <!-- Estilos personalizados -->
    <link rel="stylesheet" href="./media/styles/layout.css">

</head>
<body>

    <!-- Navbar flotante -->
    <?php require './navbar.php'; ?>

    <!-- Hero section si es index -->
    <?php if ($titulo === "Inicio"): ?>
        <div class="hero-section text-white">
            <div class="overlay"></div>
            <div class="hero-text position-relative z-1">
                <h1>La Habana SHOP.</h1>
                <p>Una tienda online diseñada para elevar tu estilo con elegancia y distinción.</p>
                <a href="index.php#productos" class="btn btn-outline-light mt-3">Ver productos</a>
            </div>
        </div>
    <?php endif; ?>

    <!-- Contenido general -->
    <main class="container <?= $titulo === "Inicio" ? '' : 'my-5' ?>" id="productos">
        <?= $contenido ?>
    </main>

    <?php require 'about_us.php'; ?>
    <?php require './footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
