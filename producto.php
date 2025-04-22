<?php
require 'conexion.php';
require 'header.php';
require 'navbar.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Producto no válido.</div></div>";
    require 'footer.php';
    exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM productos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    echo "<div class='container mt-5'><div class='alert alert-warning'>Producto no encontrado.</div></div>";
    require 'footer.php';
    exit();
}

$producto = $resultado->fetch_assoc();
?>

<style>
    body {
        background-color: #000;
        font-family: 'Open Sans', sans-serif;
        color: #f8f9fa;
    }

    .product-image {
        border-radius: 12px;
        object-fit: cover;
        width: 100%;
        max-height: 500px;
        box-shadow: 0 4px 12px rgba(245, 197, 24, 0.2);
    }

    .product-details {
        border: 1px solid #222;
        padding: 30px;
        border-radius: 10px;
        background-color: #111;
    }

    .product-details h2 {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        color: #f5c518;
        margin-bottom: 15px;
    }

    .product-details p {
        color: #ccc;
    }

    .price {
        font-weight: bold;
        font-size: 1.5rem;
        color: #f5c518;
        margin-bottom: 15px;
    }

    .btn-add {
        background-color: #f5c518;
        color: #000;
        font-weight: bold;
        border: none;
        padding: 10px 20px;
        transition: 0.3s;
    }

    .btn-add:hover {
        background-color: #e6b800;
        color: #fff;
    }

    .input-group .btn-outline-secondary {
        background-color: #222;
        color: #f5c518;
        border-color: #333;
    }

    .input-group .btn-outline-secondary:hover {
        background-color: #f5c518;
        color: #000;
    }

    .form-control {
        background-color: #000;
        border: 1px solid #444;
        color: #f5c518;
    }

    .tabs {
        margin-top: 50px;
    }

    .nav-tabs .nav-link {
        border: none;
        border-bottom: 2px solid transparent;
        color: #aaa;
        font-weight: bold;
        background-color: transparent;
    }

    .nav-tabs .nav-link.active {
        border-bottom: 2px solid #f5c518;
        color: #f5c518;
    }

    .tab-content {
        background-color: #111;
        padding: 20px;
        border-radius: 8px;
        color: #ccc;
        border: 1px solid #222;
    }

    .text-muted {
        color: #888 !important;
    }


</style>
<div class="container py-5">
    <div class="row gx-5">
        <div class="col-md-6">
            <img src="<?= htmlspecialchars($producto['imagen']) ?>" class="product-image" alt="<?= htmlspecialchars($producto['nombre']) ?>">
        </div>

        <div class="col-md-6">
            <div class="product-details">
                <p class="text-uppercase text-muted mb-1">Producto | <?= ucfirst($producto['nombre']) ?></p>
                <h2><?= htmlspecialchars($producto['nombre']) ?></h2>
                <p class="text-muted"><?= htmlspecialchars($producto['descripcion']) ?></p>
                <div class="price"><?= number_format($producto['precio'], 2) ?>€</div>

                <form action="agregar_al_carrito.php" method="POST">
                    <input type="hidden" name="id_producto" value="<?= $producto['id'] ?>">
                    <div class="input-group mb-3" style="max-width: 160px;">
                        <button class="btn btn-outline-secondary" type="button" onclick="cambiarCantidad(-1)">-</button>
                        <input type="number" name="cantidad" id="cantidad" class="form-control text-center" value="1" min="1" max="<?= $producto['stock'] ?>">
                        <button class="btn btn-outline-secondary" type="button" onclick="cambiarCantidad(1)">+</button>
                    </div>
                    <button type="submit" class="btn btn-add">Añadir al carrito</button>
                </form>

                <p class="mt-3 text-muted"><small>Stock: <?= $producto['stock'] ?> unidades disponibles</small></p>
            </div>
        </div>
    </div>

    <div class="tabs mt-5">
        <ul class="nav nav-tabs" id="productoTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" id="descripcion-tab" data-bs-toggle="tab" data-bs-target="#descripcion" type="button" role="tab">Descripción</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="opiniones-tab" data-bs-toggle="tab" data-bs-target="#opiniones" type="button" role="tab">Opiniones (0)</button>
            </li>
        </ul>
        <div class="tab-content" id="productoTabsContent">
            <div class="tab-pane fade show active" id="descripcion" role="tabpanel">
                <p class="mt-3"><?= nl2br(htmlspecialchars($producto['descripcion'])) ?></p>
            </div>
            <div class="tab-pane fade" id="opiniones" role="tabpanel">
                <p class="mt-3 text-muted">Aún no hay opiniones para este producto.</p>
            </div>
        </div>
    </div>
</div>

<script>
    function cambiarCantidad(valor) {
        let input = document.getElementById("cantidad");
        let nuevaCantidad = parseInt(input.value) + valor;
        if (nuevaCantidad >= 1 && nuevaCantidad <= <?= $producto['stock'] ?>) {
            input.value = nuevaCantidad;
        }
    }
</script>


<?php require_once 'productos_relacionados.php'; ?>

<?php require 'footer.php'; ?>
