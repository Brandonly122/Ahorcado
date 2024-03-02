<?php
$conexion = mysqli_connect("localhost", "root", "", "quizz");

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
    } else {
        // Validar la fortaleza de la contraseña si es necesario
        // por ejemplo, verificar longitud, caracteres especiales, etc.
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    }

    if (empty($errores)) {
        $sql = "INSERT INTO Usuario (name, password) VALUES ('$name', '$hashed_password')";
        $crear = mysqli_query($conexion, $sql);

        if ($crear) {
            echo "Usuario creado exitosamente.";
        } else {
            echo "Error al crear el usuario: " . mysqli_error($conexion);
        }
    } else {
        foreach ($errores as $val) {
            echo $val . '<br>';
        }
    }
}

mysqli_close($conexion);
?>
