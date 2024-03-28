<?php
$con = mysqli_connect("localhost", "root", "", "ahorcado");

// Verificar errores de conexión
if (mysqli_connect_errno()) {
    echo "Error al conectar a la base de datos: " . mysqli_connect_error();
} else {
    echo "";
}

// Establecer juego de caracteres a utf8
mysqli_query($con, "SET NAMES 'utf8'");
?>
