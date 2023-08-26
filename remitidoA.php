<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Access-Control-Allow-Origin");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    if(isset($data->num_expediente) 
    && isset($data->nombres) 
    && isset($data->primer_apellido) 
    && isset($data->segundo_apellido) 
    && isset($data->fecha_nacimiento) 
    && isset($data->sexo) 
    && isset($data->estado_civil)
    && isset($data->ocupacion) 
    && isset($data->lugar_origen)
    && isset($data->domicilio) 
    && isset($data->telefono) 
    && isset($data->remitido)){
        
        $num_expediente = $data->num_expediente;
        $nombres = $data->nombres;
        $primer_apellido = $data->primer_apellido;
        $segundo_apellido = $data->segundo_apellido;
        $fecha_nacimiento = $data->fecha_nacimiento;
        $sexo = $data->sexo;
        $estado_civil = $data->estado_civil;
        $ocupacion = $data->ocupacion;
        $lugar_origen = $data->lugar_origen;
        $domicilio = $data->domicilio;
        $telefono = $data->telefono;
        $remitido = $data->remitido;




        require_once 'pdo.db.php';

        try {
            $sql = 'INSERT INTO `pacientes` (`num_expediente`,`nombres`, `primer_apellido`, `segundo_apellido`, `fecha_nacimiento`, `sexo`, `estado_civil`, `ocupacion`, `lugar_origen`, `domicilio`, `telefono`, `remitido`) VALUES (:num_expediente, :nombres, :primer_apellido, :segundo_apellido, :fecha_nacimiento, :sexo, :estado_civil, :ocupacion, :lugar_origen, :domicilio, :telefono, :remitido)';
            $statement = $con->prepare($sql);
            $statement->execute([
                ':num_expediente' => 'EXP01',
                ':nombres' => $nombres,
                ':primer_apellido' => $primer_apellido,
                ':segundo_apellido' => $segundo_apellido,
                ':fecha_nacimiento' => $fecha_nacimiento,
                ':sexo' => $sexo,
                ':estado_civil' => $estado_civil,
                ':ocupacion' => $ocupacion,
                ':lugar_origen' => $lugar_origen,
                ':domicilio' => $domicilio,
                ':telefono' => $telefono,
                ':remitido' => 1
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