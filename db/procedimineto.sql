<<<<<<< HEAD
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
=======
Delimiter//
create procedure `proc_insertar_respuestas`
(in idQuestion int, 
in respuesta1 varchar(255), 
in respuesta2 varchar(255), 
in respuesta3 varchar(255), 
in opcionRespuesta int)
begin
    if opcionRespuesta=1 then
        insert into respuestas (idQuestion, descripcionRespuesta, opcionRespuesta) values (idQuestion, respuesta1, 'V');
    else
        insert into respuestas (idQuestion, descripcionRespuesta, opcionRespuesta) values (idQuestion, respuesta1, 'F');
    end if;
    if opcionRespuesta=2 then
        insert into respuestas (idQuestion, descripcionRespuesta, opcionRespuesta) values (idQuestion, respuesta2, 'V');
    else
        insert into respuestas (idQuestion, descripcionRespuesta, opcionRespuesta) values (idQuestion, respuesta2, 'F');
   end if;
    if opcionRespuesta=3 then
        insert into respuestas (idQuestion, descripcionRespuesta, opcionRespuesta) values (idQuestion, respuesta3, 'V');
    else
        insert into respuestas (idQuestion, descripcionRespuesta, opcionRespuesta) values (idQuestion, respuesta3, 'F');
    end if;
end //
Delimiter ;
 
>>>>>>> 811bd2143fb44befd3386cef22227daa7dd119f2
