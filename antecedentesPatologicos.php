<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Access-Control-Allow-Origin");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    if(isset($data->id_hc) 
    && isset($data->p1) 
    && isset($data->p2) 
    && isset($data->p3) 
    && isset($data->p4) 
    && isset($data->p5a) 
    && isset($data->p5b) 
    && isset($data->p5c)
    && isset($data->p6) 
    && isset($data->p7)){

        
        $id_hc = $data->id_hc;
        $p1 = $data->p1;
        $p2 = $data->p2;
        $p3 = $data->p3;
        $p4 = $data->p4;
        $p5a = $data->p5a;
        $p5b = $data->p5b;
        $p5c = $data->p5c;
        $p6 = $data->p6;
        $p7 = $data->p7;


        require_once 'pdo.db.php';

        try {
            $sql = 'INSERT INTO `ant_patologicos` (`id_hc`, `p1`, `p2`, `p3`, `p4`, `p5a`, `p5b`, `p5c`, `p6`, `p7`) VALUES (:id_hc, :p1, :p2, :p3, :p4, :p5a, :p5b, :p5c, :p6, :p7)';
            $statement = $con->prepare($sql);
            $statement->execute([
                ':id_hc' => $id_hc,
                ':p1' => $p1,
                ':p2' => $p2,
                ':p3' => $p3,
                ':p4' => $p4,
                ':p5a' => $p5a,
                ':p5b' => $p5b,
                ':p5c' => $p5c,
                ':p6' => $p6,
                ':p7' => $p7
            ]);


            $filas_afectadas = $statement->rowCount();

            echo json_encode(['mensaje' => 'Se guardaron los datos con éxito', $data, http_response_code(200)]);
        } catch (PDOException $e) {
           
            http_response_code(500);
            echo json_encode(['mensaje' => 'Error en la inserción de datos: ' . $e->getMessage()]);



        }


        
    }

    $con = null;
}