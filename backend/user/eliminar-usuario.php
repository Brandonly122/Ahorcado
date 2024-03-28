<?php
$conexion = mysqli_connect("localhost", "root", "", "ahorcado");

if (!$conexion) {
    die("La conexión a la base de datos falló: " . mysqli_connect_error());
}

$errores = array();

// Verificar si se recibió el nombre del usuario a eliminar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["name"])) {
    $name = mysqli_real_escape_string($conexion, $_POST["name"]);

    // Verificar si el nombre de usuario es válido
    if (empty($name)) {
        $errores['name'] = "El nombre de usuario no puede estar vacío";
    }

    // Si no hay errores, proceder con la eliminación del usuario
    if (empty($errores)) {
        $sql = "DELETE FROM Usuario WHERE name = '$name'";
        $eliminar = mysqli_query($conexion, $sql);

        if ($eliminar) {
            if (mysqli_affected_rows($conexion) > 0) {
                echo "¡Usuario eliminado exitosamente!";
            } else {
                echo "Usuario no encontrado";
            }
        } else {
            echo "Error al eliminar el usuario: " . mysqli_error($conexion);
        }
    } else {
        foreach ($errores as $val) {
            echo $val . '<br>';
        }
    }
}

mysqli_close($conexion);
?>
