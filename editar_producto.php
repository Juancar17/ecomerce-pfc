<?php
require 'conexion.php';
require 'header.php';
require 'navbar.php';

// Verificamos que el usuario sea admin
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Acceso denegado.</div></div>";
    require 'footer.php';
    exit();
}

// Obtener el producto por ID
if (!isset($_GET['id'])) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>ID de producto no proporcionado.</div></div>";
    require 'footer.php';
    exit();
}

$id = $_GET['id'];
$resultado = mysqli_query($conn, "SELECT * FROM productos WHERE id = $id");
$producto = mysqli_fetch_assoc($resultado);

if (!$producto) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Producto no encontrado.</div></div>";
    require 'footer.php';
    exit();
}

// Procesar edición
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar_producto'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    // Manejar imagen
    $nuevaImagen = $producto['imagen']; // Por defecto se queda la misma

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
        $nombreArchivo = $_FILES['imagen']['name'];
        $tmpName = $_FILES['imagen']['tmp_name'];
        $extension = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));
        $permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($extension, $permitidas)) {
            $nuevoNombre = uniqid() . '.' . $extension;
            $ruta = "media/img/productos/$nuevoNombre";

            if (!is_dir('media/img/productos')) {
                mkdir('media/img/productos', 0755, true);
            }

            // Borrar la imagen anterior si existe
            if ($producto['imagen'] && file_exists($producto['imagen'])) {
                unlink($producto['imagen']);
            }

            move_uploaded_file($tmpName, $ruta);
            $nuevaImagen = $ruta;
        } else {
            echo "<div class='alert alert-danger'>Formato de imagen no válido.</div>";
        }
    }

    // Actualizar en la base de datos
    $stmt = $conn->prepare("UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, imagen = ?, stock = ? WHERE id = ?");
    $stmt->bind_param("ssdssi", $nombre, $descripcion, $precio, $nuevaImagen, $stock, $id);

    if ($stmt->execute()) {
        echo "<div class='container mt-5'><div class='alert alert-success'>Producto actualizado correctamente.</div></div>";
        $producto['nombre'] = $nombre;
        $producto['descripcion'] = $descripcion;
        $producto['precio'] = $precio;
        $producto['imagen'] = $nuevaImagen;
        $producto['stock'] = $stock;
    } else {
        echo "<div class='container mt-5'><div class='alert alert-danger'>Error al actualizar: " . $stmt->error . "</div></div>";
    }
}
?>

<div class="container mt-5">
    <h2>Editar Producto</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="editar_producto" value="1">
        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($producto['nombre']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" required><?= htmlspecialchars($producto['descripcion']) ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Precio</label>
            <input type="number" step="0.01" name="precio" class="form-control" value="<?= $producto['precio'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Stock</label>
            <input type="number" name="stock" class="form-control" value="<?= $producto['stock'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Imagen actual</label><br>
            <img src="<?= $producto['imagen'] ?>" width="100"><br><br>
            <label class="form-label">Cambiar imagen</label>
            <input type="file" name="imagen" class="form-control">
        </div>
        <div class="text-end">
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
            <a href="gestionar_productos.php" class="btn btn-secondary">Volver</a>
        </div>
    </form>
</div>

<?php require 'footer.php'; ?>
