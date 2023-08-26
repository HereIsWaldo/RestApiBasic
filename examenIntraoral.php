<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Access-Control-Allow-Origin");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    if(isset($data->id_hc) 
    && isset($data->pi1) 
    && isset($data->pi1a) 
    && isset($data->pi2) 
    && isset($data->pi3) 
    && isset($data->pi4) 
    && isset($data->pi5)
    && isset($data->pi6) 
    && isset($data->pi7)
    && isset($data->pi8) 
    && isset($data->pi9) 
    && isset($data->pi10)){
        
        $id_hc = $data->id_hc;
        $pi1 = $data->pi1;
        $pi1a = $data->pi1a;
        $pi2 = $data->pi2;
        $pi3 = $data->pi3;
        $pi4 = $data->pi4;
        $pi5 = $data->pi5;
        $pi6 = $data->pi6;
        $pi7 = $data->pi7;
        $pi8 = $data->pi8;
        $pi9 = $data->pi9;
        $pi10 = $data->pi10;
        $pi11 = $data->pi11;
        $pi12 = $data->pi12;
        $pi12a = $data->pi12a;
        $pi13 = $data->pi13;




        require_once 'pdo.db.php';

        try {
            $sql = 'INSERT INTO `ex_intraoral` (`id_hc`, `pi1`, `pi1a`, `pi2`, `pi3`, `pi4`, `pi5`, `pi6`, `pi7`, `pi8`, `pi9`, `pi10`, `pi11`, `pi12`, `pi12a`, `pi13`) VALUES (:id_hc, :pi1, :pi1a, :pi2, :pi3, :pi4, :pi5, :pi6, :pi7, :pi8, :pi9, :pi10, :pi11, :pi12, :pi12a, :pi13)';
            $statement = $con->prepare($sql);
            $statement->execute([
                ':id_hc' => $id_hc,
                ':pi1' => $pi1,
                ':pi1a' => $pi1a,
                ':pi2' => $pi2,
                ':pi3' => $pi3,
                ':pi4' => $pi4,
                ':pi5' => $pi5,
                ':pi6' => $pi6,
                ':pi7' => $pi7,
                ':pi8' => $pi8,
                ':pi9' => $pi9,
                ':pi10' => $pi10,
                ':pi11' => $pi11,
                ':pi12' => $pi12,
                ':pi12a' => $pi12a,
                ':pi13' => $pi13

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