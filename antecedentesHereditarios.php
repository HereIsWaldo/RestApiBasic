<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Access-Control-Allow-Origin");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    if(isset($data->id_hc) 
    && isset($data->ph1) 
    && isset($data->ph2) 
    && isset($data->ph3) 
    ){
        
        $id_hc = $data->id_hc;
        $ph1 = $data->ph1;
        $ph2 = $data->ph2;
        $ph3 = $data->ph3;
       




        require_once 'pdo.db.php';

        try {
            $sql = 'INSERT INTO `ant_hereditarios` (`id_hc`, `ph1`, `ph2`, `ph3`) VALUES (:id_hc,:ph1, :ph2, :ph3)';
            $statement = $con->prepare($sql);
            $statement->execute([
                ':id_hc' => $id_hc,
                ':ph1' => $ph1,
                ':ph2' => $ph2,
                ':ph3' => $ph3     
            ]);


            $filas_afectadas = $statement->rowCount();

            echo json_encode(['mensaje' => 'Se guardaron los datos con éxito', $data,'Filas afectadas:' + $filas_afectadas]);
        } catch (PDOException $e) {
           
            http_response_code(500);
            echo json_encode(['mensaje' => 'Error en la inserción de datos: ' . $e->getMessage()]);



        }


        
    }

    $con = null;
}