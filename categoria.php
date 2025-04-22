
<?php
require 'conexion.php';
require 'header.php';
require 'navbar.php';

$cat = isset($_GET['cat']) ? htmlspecialchars($_GET['cat']) : null;
$categorias_validas = ['zapatos', 'ropa', 'accesorios', 'rebajas', 'nuevo', 'tendencias'];

function mostrarProductosPorCategoria($conn, $categoria) {
    $stmt = $conn->prepare("SELECT * FROM productos WHERE categoria = ?");
    $stmt->bind_param("s", $categoria);
    $stmt->execute();
    $resultado = $stmt->get_result();

    echo "<h3 class='text-light mb-4 mt-5 text-uppercase border-bottom border-warning pb-2'>" . ucfirst($categoria) . "</h3>";
    echo "<div class='row g-4'>";
    if ($resultado->num_rows > 0) {
        while ($producto = $resultado->fetch_assoc()) {
            ?>
            <div class="col-md-3">
                <div class="card bg-dark text-light h-100 border-0 shadow-sm">
                    <img src="<?= htmlspecialchars($producto['imagen']) ?>" class="card-img-top" alt="<?= htmlspecialchars($producto['nombre']) ?>" style="height: 250px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h5 class="card-title text-warning"><?= htmlspecialchars($producto['nombre']) ?></h5>
                        <p class="card-text">$<?= number_format($producto['precio'], 2) ?></p>
                        <form action="producto.php" method="GET">
                            <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                            <button class="btn btn-outline-light btn-sm w-100">Ver producto</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        echo "<div class='col-12 text-center'><div class='alert alert-secondary'>No hay productos en esta categoría.</div></div>";
    }
    echo "</div>";
}
?>
<link rel="stylesheet" href="./media/styles/categorias.css">
<div class="container mt-5">

    <?php if ($cat): ?>
        <?php if (in_array($cat, $categorias_validas)): ?>
            <h2 class="text-center text-light mb-4 text-uppercase"><?= ucfirst($cat) ?></h2>
            <?php mostrarProductosPorCategoria($conn, $cat); ?>
        <?php else: ?>
            <div class="alert alert-danger text-center">Categoría no válida.</div>
        <?php endif; ?>
    <?php else: ?>
        <h2 class="text-center text-light mb-5 text-uppercase">Todas las Categorías</h2>
        <?php foreach ($categorias_validas as $categoria): ?>
            <?php mostrarProductosPorCategoria($conn, $categoria); ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php require 'footer.php'; ?>
