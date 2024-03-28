<?php
$conexion = mysqli_connect("localhost", "root", "", "ahorcado");

if (!$conexion) {
    die("La conexión a la base de datos falló: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conexion, $_POST["name"]);
    $password = mysqli_real_escape_string($conexion, $_POST["password"]);

    $errores = array();

    if (empty($name)) {
        $errores['name'] = "El nombre no puede estar vacío";
    }

    if (empty($password)) {
        $errores['password'] = "La contraseña no puede estar vacía";
    }

    if (empty($errores)) {
        // Buscar el usuario en la base de datos
        $sql = "SELECT * FROM Usuario WHERE name = '$name'";
        $resultado = mysqli_query($conexion, $sql);

        if ($resultado && mysqli_num_rows($resultado) > 0) {
            $usuario = mysqli_fetch_assoc($resultado);
            // Verificar la contraseña
            if (password_verify($password, $usuario['password'])) {
                // Redirigir al usuario a la página de juego
                header("Location: ../../frontend/html/juego/juego.html");
                exit; // Asegúrate de salir del script después de redirigir
            } else {
                echo "Contraseña incorrecta.";
            }
        } else {
            echo "Usuario no encontrado.";
        }
    } else {
        foreach ($errores as $val) {
            echo $val . '<br>';
        }
    }
}

mysqli_close($conexion);
?>
