<?php
session_start();
// Destruir todas las variables de sesión
$_SESSION = array();
// Destruir la sesión física
session_destroy();
// Redirigir al login
header("Location: login.php");
exit();
?>