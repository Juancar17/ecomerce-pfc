
<?php
require 'navbar.php';
require 'conexion.php';
require 'header.php';


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificamos que el usuario sea admin
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Acceso denegado.</div></div>";
    require 'footer.php';
    exit();
}

// Procesar formularios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Añadir nuevo producto
    if (isset($_POST['nuevo_producto'])) {
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $stock = $_POST['stock'];
        $categoria_id = isset($_POST['categoria_id']) && $_POST['categoria_id'] !== '' ? $_POST['categoria_id'] : NULL;

        $imagen = null;
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
            $nombreArchivo = $_FILES['imagen']['name'];
            $tmpName = $_FILES['imagen']['tmp_name'];
            $extension = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));
            $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            if (in_array($extension, $extensionesPermitidas)) {
                if (!is_dir('media/img/productos')) {
                    mkdir('media/img/productos', 0755, true);
                }

                $nuevoNombreArchivo = uniqid('img_', true) . '.' . $extension;
                $rutaDestino = "media/img/productos/$nuevoNombreArchivo";

                if (move_uploaded_file($tmpName, $rutaDestino)) {
                    $query = "INSERT INTO productos (nombre, descripcion, precio, imagen, categoria_id, fecha_agregado, stock) 
                              VALUES (?, ?, ?, ?, ?, NOW(), ?)";
                    $stmt = $conn->prepare($query);

                    if ($stmt === false) {
                        echo "<div class='alert alert-danger'>Error al preparar la consulta: " . $conn->error . "</div>";
                        exit();
                    }

                    $stmt->bind_param("ssdssi", $nombre, $descripcion, $precio, $rutaDestino, $categoria_id, $stock);

                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Producto añadido correctamente con imagen.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Error al insertar el producto: " . $stmt->error . "</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>Error al subir la imagen al servidor.</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Extensión de imagen no válida. Solo se permiten jpg, jpeg, png, gif y webp.</div>";
            }
        } else {
            // Sin imagen
            $query = "INSERT INTO productos (nombre, descripcion, precio, imagen, categoria_id, fecha_agregado, stock) 
                      VALUES (?, ?, ?, NULL, ?, NOW(), ?)";
            $stmt = $conn->prepare($query);

            if ($stmt === false) {
                echo "<div class='alert alert-danger'>Error al preparar la consulta: " . $conn->error . "</div>";
                exit();
            }

            $stmt->bind_param("ssdii", $nombre, $descripcion, $precio, $categoria_id, $stock);

            if ($stmt->execute()) {
                echo "<div class='alert alert-success'>Producto añadido correctamente sin imagen.</div>";
            } else {
                echo "<div class='alert alert-danger'>Error al insertar el producto: " . $stmt->error . "</div>";
            }
        }
    }

    // Agregar stock
    if (isset($_POST['agregar_stock'])) {
        $id = $_POST['producto_id'];
        $cantidad = $_POST['cantidad'];
        $updateStockQuery = "UPDATE productos SET stock = stock + ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateStockQuery);
        $updateStmt->bind_param("ii", $cantidad, $id);
        $updateStmt->execute();
    }

    // Eliminar producto
    if (isset($_POST['eliminar_producto'])) {
        $id = $_POST['producto_id'];
        $imgResult = mysqli_query($conn, "SELECT imagen FROM productos WHERE id = $id");
        if ($imgRow = mysqli_fetch_assoc($imgResult)) {
            $imgPath = $imgRow['imagen'];
            if ($imgPath && file_exists($imgPath)) {
                unlink($imgPath);
            }
        }
        $deleteQuery = "DELETE FROM productos WHERE id = ?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param("i", $id);
        $deleteStmt->execute();
    }
}

// Obtener productos
$resultado = mysqli_query($conn, "SELECT * FROM productos");

?>
<link rel="stylesheet" href="./media/img/styles/gestionProductos.css">
<div class="container mt-5">
    <h2 class="mb-4">Gestionar Productos</h2>

    <!-- Formulario para nuevo producto -->
    <div class="card mb-4">
        <div class="card-header bg-success text-white">Añadir nuevo producto</div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="nuevo_producto" value="1">
                <div class="row">
                    <div class="col-md-3">
                        <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="descripcion" class="form-control" placeholder="Descripción" required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" step="0.01" name="precio" class="form-control" placeholder="Precio" required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="stock" class="form-control" placeholder="Stock" required>
                    </div>
                    <div class="col-md-2">
                        <input type="file" name="imagen" class="form-control">
                    </div>
                </div>
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success">Añadir producto</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de productos -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Imagen</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($producto = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td><?= $producto['id'] ?></td>
                        <td><?= htmlspecialchars($producto['nombre']) ?></td>
                        <td><?= htmlspecialchars($producto['descripcion']) ?></td>
                        <td>$<?= number_format($producto['precio'], 2) ?></td>
                        <td>
                            <?php if ($producto['imagen']): ?>
                                <img src="<?= $producto['imagen'] ?>" width="60">
                            <?php else: ?>
                                <span class="text-muted">Sin imagen</span>
                            <?php endif; ?>
                        </td>
                        <td><?= $producto['stock'] ?></td>
                        <td>
                            <!-- Agregar stock -->
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">
                                <input type="hidden" name="agregar_stock" value="1">
                                <input type="number" name="cantidad" class="form-control d-inline w-50" min="1" placeholder="+stock" required>
                                <button type="submit" class="btn btn-sm btn-primary">+</button>
                            </form>

                            <!-- Botón editar -->
                            <form method="GET" action="editar_producto.php" class="d-inline">
                                <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-warning">Editar</button>
                            </form>

                            <!-- Eliminar producto -->
                            <form method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este producto?');">
                                <input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">
                                <input type="hidden" name="eliminar_producto" value="1">
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
require 'footer.php';
mysqli_close($conn);
?>
