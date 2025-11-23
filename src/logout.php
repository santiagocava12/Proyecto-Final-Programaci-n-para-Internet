<?php
session_start();
session_destroy();
// Salir de carpeta src e ir al index
header("Location: ../index.php");
exit();
?>