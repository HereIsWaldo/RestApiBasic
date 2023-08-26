<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Access-Control-Allow-Origin");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    if(isset($data->id_hc) 
    && isset($data->pe1) 
    && isset($data->pe2) 
    && isset($data->pe3) 
    && isset($data->pe4a) 
    && isset($data->pe4b) 
    && isset($data->pe4c)
    && isset($data->pe4d) 
    && isset($data->pe4e)){
        
        $id_hc = $data->id_hc;
        $pe1 = $data->pe1;
        $pe2 = $data->pe2;
        $pe3 = $data->pe3;
        $pe4a = $data->pe4a;
        $pe4b = $data->pe4b;
        $pe4c = $data->pe4c;
        $pe4d = $data->pe4d;
        $pe4e = $data->pe4e;




        require_once 'pdo.db.php';

        try {
            $sql = 'INSERT INTO `ex_extraoral` (`id_hc`, `pe1`, `pe2`, `pe3`, `pe4a`, `pe4b`, `pe4c`, `pe4d`, `pe4e`) VALUES (:id_hc, :pe1, :pe2, :pe3, :pe4a, :pe4b, :pe4c, :pe4d, :pe4e)';
            $statement = $con->prepare($sql);
            $statement->execute([
                ':id_hc' => $id_hc,
                ':pe1' => $pe1,
                ':pe2' => $pe2,
                ':pe3' => $pe3,
                ':pe4a' => $pe4a,
                ':pe4b' => $pe4b,
                ':pe4c' => $pe4c,
                ':pe4d' => $pe4d,
                ':pe4e' => $pe4e
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