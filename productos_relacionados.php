<style>
.related-products-container {
    max-width: 800px; 
    margin: 0 auto; 
}

.related-products h3 {
    text-align: center;
    font-family: 'Playfair Display', serif;
    font-size: 2rem;
    color: #f5c518;
    margin-bottom: 15px;
}

.related-products .card {
    background-color: transparent;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.related-products .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 16px rgba(245, 197, 24, 0.3);
}

.related-products .card-img-top {
    height: 220px;
    object-fit: cover;
}

.related-products .card-body {
    padding: 1rem;
}

.related-products .card-title {
    font-size: 1rem;
    font-weight: 600;
    color: white;
    margin-bottom: 0.25rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.related-products .card-text {
    font-size: 0.9rem;
    color: #555;
}

.related-products .btn-ver {
    margin-top: 0.5rem;
    border: 1px solid #000;
    color: #000;
    font-weight: 600;
    transition: all 0.3s ease;
    background-color: transparent;
}

.related-products .btn-ver:hover {
    background-color: #f5c518;
    border-color: #f5c518;
    color: #000;
}
</style>

<?php
$relacionados = mysqli_query($conn, "SELECT * FROM productos WHERE id != $id ORDER BY fecha_agregado DESC LIMIT 4");
?>

<section class="related-products mt-5 pt-5">
    <div class="related-products-container">
        <h3 class="text-uppercase ">Productos Relacionados</h3>
        <div class="row justify-content-center gx-4">
            <?php while ($rel = mysqli_fetch_assoc($relacionados)): ?>
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card h-100">
                        <img src="<?= htmlspecialchars($rel['imagen']) ?>" class="card-img-top" alt="<?= htmlspecialchars($rel['nombre']) ?>">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= htmlspecialchars($rel['nombre']) ?></h5>
                            <p class="card-text"><?= number_format($rel['precio'], 2) ?>€</p>
                            <form action="producto.php" method="GET">
                                <input type="hidden" name="id" value="<?= $rel['id'] ?>">
                                <button class="btn btn-add">Ver producto</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>
