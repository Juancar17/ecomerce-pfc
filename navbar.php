<?php
session_start();
?>
<style>
    .nav-shadow {
        box-shadow: 0 4px 10px rgba(245, 197, 24, 0.2);
        transition: box-shadow 0.3s ease-in-out;
        background-color: rgba(0, 0, 0, 0.9) !important;
        backdrop-filter: blur(6px);
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark bg-transparent sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
            <img src="media/img/logo.png" alt="Logo" width="140" height="140" class="d-inline-block align-text-top rounded-circle">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <?php if (!isset($_SESSION['rol']) || $_SESSION['rol'] === 'usuario'): ?>
            <ul class="navbar-nav mx-auto">
                <li class="nav-item px-3">
                    <a class="nav-link text-light fw-semibold" href="categoria.php?cat=zapatos">Zapatos</a>
                </li>
                <li class="nav-item px-3">
                    <a class="nav-link text-light fw-semibold" href="categoria.php?cat=ropa">Ropa</a>
                </li>
                <li class="nav-item px-3">
                    <a class="nav-link text-light fw-semibold" href="categoria.php?cat=accesorios">Accesorios</a>
                </li>
                <li class="nav-item px-3">
                    <a class="nav-link text-light fw-semibold" href="categoria.php?cat=rebajas">Rebajas</a>
                </li>
                <li class="nav-item px-3">
                    <a class="nav-link text-light fw-semibold" href="categoria.php?cat=nuevo">Nuevo</a>
                </li>
                <li class="nav-item px-3">
                    <a class="nav-link text-light fw-semibold" href="categoria.php?cat=tendencias">Tendencias</a>
                </li>
            </ul>
            <?php endif; ?>

            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <?php if ($_SESSION['rol'] === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php"><i class="bi bi-house-door"></i> Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="gestionar_finanzas.php"><i class="bi bi-graph-up"></i> Gestionar Finanzas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="gestionar_productos.php"><i class="bi bi-box-seam"></i> Gestionar Productos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="gestionar_usuarios.php"><i class="bi bi-people"></i> Gestionar Usuarios</a>
                        </li>
                    <?php elseif ($_SESSION['rol'] === 'responsable'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="gestionar_productos.php"><i class="bi bi-box-seam"></i> Gestionar Productos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="gestionar_pedidos.php"><i class="bi bi-truck"></i> Gestionar Pedidos</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php"><i class="bi bi-house-door"></i> Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="carrito.php"><i class="bi bi-cart4"></i> Mi Carrito</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="mis_pedidos.php"><i class="bi bi-bag-check"></i> Mis Pedidos</a>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-1" href="#" id="perfilDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> <?= htmlspecialchars($_SESSION['nombre']) ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="perfilDropdown">
                            <li>
                                <form action="logout.php" method="POST" class="px-3">
                                    <button type="submit" class="btn btn-outline-danger w-100">
                                        <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="login.php">
                            <i class="bi bi-box-arrow-in-right"></i> Iniciar sesión
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="register.php">
                            <i class="bi bi-person-plus"></i> Registrarse
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<script>
    window.addEventListener('scroll', function () {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 10) {
            navbar.classList.add('nav-shadow');
        } else {
            navbar.classList.remove('nav-shadow');
        }
    });
</script>
