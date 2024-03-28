-- Delimitador personalizado para definir el procedimiento almacenado
DELIMITER //

-- Crear el procedimiento para insertar palabras del ahorcado
CREATE PROCEDURE proc_insertar_palabra(
    IN palabra_a_insertar VARCHAR(50)
)
BEGIN
    -- Insertar la palabra en la tabla PalabrasAhorcado
    INSERT INTO PalabrasAhorcado (palabra) VALUES (palabra_a_insertar);
END //

-- Restaurar el delimitador predeterminado
DELIMITER ;
