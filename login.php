<?php


/**
 * Para realizar el logueo del usuario se debe enviar una peticion POST
 * se hara la verificacion de las credenciales y se creara la sesion
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
    if (isset($data->codigo) && isset($data->contrasena)) {
        $codigo = $data->codigo;
        $contrasena = $data->contrasena;

        // Conectarse a la base de datos utilizando PDO
        require_once 'pdo.db.php';
        
        // Buscar el usuario en la tabla de usuarios por código
        $sql = 'SELECT * FROM usuarios WHERE codigo = :codigo';
        $statement = $con->prepare($sql);
        $statement->execute(['codigo' => $codigo]);
        $user = $statement->fetch();

        // Verificar si se encontró un usuario y la contraseña coincide
        if ($user['codigo']===$codigo && hash('sha256', $contrasena) === $user['contrasena']) {
            // Usuario autenticado correctamente
            

            
            
            $key = 'odontech';
            $payload = [
                'roluser' => $user['id_rol'],
                'iduser' => $user['id']
            ];
                
           
            
            http_response_code(201);
            echo json_encode(["mensaje"=> "Inicio de sesion exitodo", "token" => "hola"]);
        } else {
            // Usuario no encontrado o contraseña incorrecta
            http_response_code(401);
            echo json_encode(['mensaje' => 'Credenciales inválidas']);
        }
    } else {
        // Los datos no se enviaron correctamente, devuelve un error
        http_response_code(400);
        echo json_encode(['mensaje' => 'Error al procesar la solicitud']);
    }

   

    $con = null;
}
?>