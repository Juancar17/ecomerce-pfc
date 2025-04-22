<?php
session_start();
session_unset();  // Destruir todas las variables de sesión
session_destroy(); // Destruir la sesión

// Redirigir al inicio o a login
header('Location: index.php');
exit();
?>
