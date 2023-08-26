<?php
/**
 * Para registrar un nuevo usuario este modulo de la api debe recibir una peticion de tipo POST
 * el body de la peticion debe ser de tipo JSON y debe tener la siguiente estructura de claves
 *  { 
 *   nombres : "", 
 *   primer_apellido : "",
 *   segundo_apellido : "",
 *   correo : "",
 *   contraseña : "",
 *   codigo: "",
 *   }
 * De preferencia la contraseña debe haber sido enviada "hasheada" desde el lado del cliente
 * 
 */

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Access-Control-Allow-Origin");
header("Content-Type: application/json; charset=UTF-8");

// Obtiene los datos del cuerpo de la solicitud
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    // Verifica que los datos se hayan enviado correctamente
    if (isset($data->nombres) && isset($data->primer_apellido) && isset($data->segundo_apellido) && isset($data->correo) && isset($data->contraseña) && isset($data->codigo)) {
        $nombres = $data->nombres;
        $primer_apellido = $data->primer_apellido;
        $segundo_apellido = $data->segundo_apellido;
        $correo = $data->correo;
        $contraseña = $data->contraseña;
        $codigo = $data->codigo;

        // Realizar el hashing de la contraseña utilizando SHA-256
        $contraseña_encriptada = hash('sha256', $contraseña);

        // Conectarse a la base de datos utilizando PDO
        require_once 'pdo.db.php';

        // Insertar los datos en la tabla de usuarios
        try {
            
            $sql = 'INSERT INTO `usuarios` (`nombres`, `primer_apellido`, `segundo_apellido`, `correo`, `contrasena`, `codigo`, `id_rol`) VALUES (:nombres, :primer_apellido, :segundo_apellido, :correo, :contrasena, :codigo, :id_rol)';
            $statement = $con->prepare($sql);
            $statement->execute([
                ':nombres' => $nombres,
                ':primer_apellido' => $primer_apellido,
                ':segundo_apellido' => $segundo_apellido,
                ':correo' => $correo,
                ':contrasena' => $contraseña_encriptada,
                ':codigo' => $codigo,
                ':id_rol' => 1,
            ]);

            $filas_afectadas = $statement->rowCount();
            
            echo json_encode(['mensaje' => 'Usuario registrado con éxito']);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['mensaje' => 'Error en la inserción de datos: ' . $e->getMessage()]);
        }
    } else {
        // Los datos no se enviaron correctamente, devuelve un error
        http_response_code(400);
        echo json_encode(['mensaje' => 'Error al procesar la solicitud']); //Respuesta insatisfactoria
    }
    
    $con = null;
}
?>
