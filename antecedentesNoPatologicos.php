<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Access-Control-Allow-Origin");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    if(isset($data->id_hc) 
    && isset($data->np1) 
    && isset($data->np2) 
    && isset($data->np3) 
    && isset($data->np4) 
    && isset($data->np5) 
    && isset($data->np6)){
        
        $id_hc = $data->id_hc;
        $np1 = $data->np1;
        $np2 = $data->np2;
        $np3 = $data->np3;
        $np4 = $data->np4;
        $np5 = $data->np5;
        $np6 = $data->np6;

        require_once 'pdo.db.php';

        try {
            $sql ='INSERT INTO `ant_nopatologicos` (`id_hc`, `np1`, `np2`, `np3`, `np4`, `np5`, `np6`) VALUES (:id_hc,:np1, :np2, :np3, :np4, :np5, :np6)';
            
            
            $statement = $con->prepare($sql);
            $statement->execute([
                ':id_hc' => $id_hc,
                ':np1' => $np1,
                ':np2' => $np2,
                ':np3' => $np3,
                ':np4' => $np4,
                ':np5' => $np5,
                ':np6' => $np6,  
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