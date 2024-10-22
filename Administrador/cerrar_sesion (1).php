<?php
// Inicia la sesión
session_start();

// Destruye la sesión
session_destroy();

// Redirige a la página de bienvenida
header("Location: bienvenido.php");
exit(); // Asegúrate de terminar el script después de redirigir
?>
