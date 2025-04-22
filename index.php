<?php
require 'conexion.php';

$query = "SELECT * FROM productos";
$resultado = mysqli_query($conn, $query);

$titulo = "Inicio";
ob_start();
?>

<!-- Estilos -->
<link rel="stylesheet" href="./media/img/styles/index.css">


<section class="text-center py-5 bg-black text-white">
    <h2 class="display-5 fw-bold mb-4"> New Arrivals</h2>
</section>

<div class="container-fluid slider-container px-4">
    <!-- Botones -->
    <button class="scroll-btn scroll-left" onclick="scrollSlider(-1)">
        <i class="bi bi-chevron-left"></i>
    </button>
    <button class="scroll-btn scroll-right" onclick="scrollSlider(1)">
        <i class="bi bi-chevron-right"></i>
    </button>

    <!-- Slider -->
    <div id="productSlider" class="scrolling-wrapper">
        <?php while ($producto = mysqli_fetch_assoc($resultado)): ?>
            <div class="card product-card">
                <img src="<?= htmlspecialchars($producto['imagen']) ?>" class="card-img-top product-image" alt="<?= htmlspecialchars($producto['nombre']) ?>">
                <div class="card-body text-center bg-dark">
                    <h6 class="text-uppercase fw-bold mb-1 text-white"><?= htmlspecialchars($producto['nombre']) ?></h6>
                    <p class="mb-2 text-white">$<?= number_format($producto['precio'], 2) ?></p>
                    <a href="producto.php?id=<?= $producto['id'] ?>" class="btn btn-dark btn-sm w-100">Ver Producto</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>


<section class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold display-6">Complementos que marcan la diferencia.</h2>
        <p class="text-muted">Relojes, gafas y pulseras pensados para destacar en cada ocasión.</p>
    </div>

    <div class="row g-4">
        <!-- Sunglasses -->
        <div class="col-md-6">
            <div class="category-card position-relative text-white" style="background-image: url('./media/img/1.png');">
                <div class="overlay"></div>
                <div class="category-content text-center position-relative">
                    <h3 class="fw-bold">Sunglasses</h3>
                    <a href="productos.php?categoria=sunglasses" class="btn btn-outline-light mt-3">View Collection</a>
                </div>
            </div>
        </div>

        <!-- Watches -->
        <div class="col-md-6">
            <div class="category-card position-relative text-white" style="background-image: url('./media/img/2.png');">
                <div class="overlay"></div>
                <div class="category-content text-center position-relative">
                    <h3 class="fw-bold">Watches</h3>
                    <a href="productos.php?categoria=watches" class="btn btn-outline-light mt-3">View Collection</a>
                </div>
            </div>
        </div>

        <!-- Bracelets -->
        <div class="col-md-12">
            <div class="category-card position-relative text-white" style="background-image: url('./media/img/3.png');">
                <div class="overlay"></div>
                <div class="category-content text-center position-relative">
                    <h3 class="fw-bold">Bracelets</h3>
                    <a href="productos.php?categoria=bracelets" class="btn btn-outline-light mt-3">View Collection</a>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Script -->
<script>
    function scrollSlider(direction) {
        const slider = document.getElementById('productSlider');
        const scrollAmount = 320; // ancho de cada card + margen
        slider.scrollBy({
            left: direction * scrollAmount,
            behavior: 'smooth'
        });
    }
</script>

<?php
mysqli_close($conn);
$contenido = ob_get_clean();
require 'layout.php';
