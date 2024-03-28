<?php
session_start(); // Iniciar sesión para mantener el estado del juego

include('../conexion.php');

// Verificar si se envió el botón de reinicio
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["reiniciar"])) {
    unset($_SESSION['palabra_ahorcado']); // Eliminar la palabra actual de la sesión
    unset($_SESSION['palabra_oculta']); // Eliminar el estado actual del juego de la sesión
    unset($_SESSION['intentos_fallidos']); // Reiniciar el contador de intentos fallidos
    header("Location: " . $_SERVER['PHP_SELF']); // Redireccionar para reiniciar el juego
    exit();
}

// Verificar si ya se seleccionó una palabra aleatoria
if (!isset($_SESSION['palabra_ahorcado'])) {
    // Obtener una palabra aleatoria de la base de datos
    $sql = "SELECT palabra FROM PalabrasAhorcado ORDER BY RAND() LIMIT 1";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['palabra_ahorcado'] = $row['palabra'];
    } else {
        echo "No se encontraron palabras.";
    }
}

// Obtener la palabra desde la sesión
$palabra = $_SESSION['palabra_ahorcado'];

// Inicializar el estado de la palabra oculta si no está definido
if (!isset($_SESSION['palabra_oculta'])) {
    $_SESSION['palabra_oculta'] = str_repeat('_', strlen($palabra));
}

// Inicializar el contador de intentos fallidos si no está definido
if (!isset($_SESSION['intentos_fallidos'])) {
    $_SESSION['intentos_fallidos'] = 0;
}

// Inicializar el mensaje de error
$error = "";

// Definir las partes del muñeco del ahorcado utilizando caracteres ASCII
$partes = array(
    " O", // Cabeza
    "/|\\", // Cuerpo
    "/ \\", // Piernas
    "___" // Base
);

// Verificar si se envió una letra
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["letra"])) {
    // Obtener la letra introducida por el usuario
    $letra = strtoupper(mysqli_real_escape_string($con, $_POST["letra"]));
    
    // Verificar si la letra está en la palabra
    if (strpos($palabra, $letra) !== false) {
        // Actualizar la palabra oculta con la letra adivinada
        for ($i = 0; $i < strlen($palabra); $i++) {
            if ($palabra[$i] === $letra) {
                $_SESSION['palabra_oculta'][$i] = $letra;
            }
        }

        // Verificar si la palabra oculta ya no tiene guiones bajos
        if (!strpos($_SESSION['palabra_oculta'], '_')) {
            $felicidades = true; // Establecer la bandera de felicitaciones
        }
    } else {
        // La letra no está en la palabra, incrementar el contador de intentos fallidos
        $_SESSION['intentos_fallidos']++;

        // Mostrar mensaje de error
        $error = "MAL";

        // Verificar si se han agotado los intentos
        if ($_SESSION['intentos_fallidos'] >= count($partes)) {
            $game_over = true; // Establecer la bandera de fin de juego
        }
    }
}

// Verificar si es el fin del juego
if (isset($game_over) && $game_over) {
    // Reiniciar el juego
    unset($_SESSION['palabra_ahorcado']);
    unset($_SESSION['palabra_oculta']);
    unset($_SESSION['intentos_fallidos']);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../frontend/css/palabra.css">
    <title>Ahorcado - Palabras</title>
</head>
<body>
    
<div class="palabra-container">
    <h2>Palabra:</h2>
    <div class="palabra">
        <?php
        // Verificar si la clave palabra_oculta está definida antes de intentar acceder a ella
        if (isset($_SESSION['palabra_oculta'])) {
            // Mostrar la palabra oculta con las letras adivinadas
            for ($i = 0; $i < strlen($_SESSION['palabra_oculta']); $i++) {
                echo "<span class='letra'>" . $_SESSION['palabra_oculta'][$i] . "</span>";
            }
        }
        ?>
    </div>
           
    <div class="formulario">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="hidden" name="palabra" value="<?php echo $palabra; ?>">
            <label for="letra">Introduce una letra:</label>
            <input type="text" id="letra" name="letra" maxlength="1" required>
            <button type="submit">Enviar</button>
            <button type="submit" name="reiniciar">Reiniciar Palabra</button>
        </form>
        <?php
        // Mostrar el mensaje de error si existe
        if (!empty($error)) {
            echo "<div class='error'>$error</div>";
        }

        // Mostrar "GAME OVER" si es el fin del juego
        if (isset($game_over) && $game_over) {
            echo "<div class='error'>GAME OVER!</div>";
            echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'>";
            echo "<button type='submit' name='reiniciar'>Volver a comenzar</button>";
            echo "</form>";
        }

        // Mostrar el mensaje de felicitaciones si se descifra la palabra
        if (isset($felicidades) && $felicidades) {
            echo "<div style='color: green;'>¡FELICITACIONES! HAS DESCUBIERTO LA PALABRA :D </div>";
        }
        ?>
    </div>
    
    <div class="muñeco">
        <?php
        // Mostrar las partes del muñeco según el número de intentos fallidos
        $intentosFallidos = isset($_SESSION['intentos_fallidos']) ? $_SESSION['intentos_fallidos'] : 0;

        // Mostrar cada parte del muñeco según el número de intentos fallidos
        for ($i = 0; $i < $intentosFallidos; $i++) {
            echo "<pre>" . $partes[$i] . "</pre>"; // Utilizamos pre para mantener el formato de los caracteres
        }
        ?>
    </div>
</div>

</body>
</html>
