<?php
// Datos de conexión a la base de datos
$host = 'localhost';  // Cambiar a tu servidor
$user = 'root';            // Nombre de usuario
$pass = '';                       // Agrega tu contraseña aquí
$db   = 'tienda-online';            // Base de datos

// Crear la conexión
$conn = mysqli_connect($host, $user, $pass, $db);

// Verificar si la conexión fue exitosa
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>
