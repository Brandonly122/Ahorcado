<?php
include('../conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $palabra = mysqli_real_escape_string($con, $_POST["palabra"]);

    $errores = array();

    if (empty($palabra)) {
        $errores['palabra'] = "La palabra no puede estar vacía";
    }
  
    if (empty($errores)) {
        // Llamada al procedimiento almacenado para insertar la palabra en la tabla PalabrasAhorcado
        $sql = "CALL proc_insertar_palabra('$palabra')";

        if ($con->query($sql) === TRUE) {
            echo "Palabra creada exitosamente";
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    } else {
        echo "Por favor, proporcione una palabra.";
    }
}
$con->close();
?>
