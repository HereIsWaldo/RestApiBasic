<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Access-Control-Allow-Origin");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    if(isset($data->id_hc) 
    && isset($data->apt_digestivo) 
    && isset($data->apt_respiratorio) 
    && isset($data->apt_cardiovascular) 
    && isset($data->sis_nervioso) 
    && isset($data->sis_endocrino) 
    && isset($data->apt_genito_urinario)
    && isset($data->sis_hematico_linfatico) 
    && isset($data->frec_respiratoria)
    && isset($data->temp_corporal) 
    && isset($data->presion_arterial) 
    && isset($data->pulso)){
        
        $id_hc = $data->id_hc;
        $apt_digestivo = $data->apt_digestivo;
        $apt_respiratorio = $data->apt_respiratorio;
        $apt_cardiovascular = $data->apt_cardiovascular;
        $sis_nervioso = $data->sis_nervioso;
        $sis_endocrino = $data->sis_endocrino;
        $apt_genito_urinario = $data->apt_genito_urinario;
        $sis_hematico_linfatico = $data->sis_hematico_linfatico;
        $frec_respiratoria = $data->frec_respiratoria;
        $temp_corporal = $data->temp_corporal;
        $presion_arterial = $data->presion_arterial;
        $pulso = $data->pulso;




        require_once 'pdo.db.php';

        try {
            $sql = 'INSERT INTO `assv` (`id_hc`, `apt_digestivo`, `apt_respiratorio`, `apt_cardiovascular`, `sis_nervioso`, `sis_endocrino`, `apt_genito_urinario`, `sis_hematico_linfatico`, `frec_respiratoria`, `temp_corporal`, `presion_arterial`, `pulso`) VALUES (:id_hc, :apt_digestivo, :apt_respiratorio, :apt_cardiovascular, :sis_nervioso, :sis_endocrino, :apt_genito_urinario, :sis_hematico_linfatico, :frec_respiratoria, :temp_corporal, :presion_arterial, :pulso)';
            $statement = $con->prepare($sql);
            $statement->execute([
                ':id_hc' => $id_hc,
                ':apt_digestivo' => $apt_digestivo,
                ':apt_respiratorio' => $apt_respiratorio,
                ':apt_cardiovascular' => $apt_cardiovascular,
                ':sis_nervioso' => $sis_nervioso,
                ':sis_endocrino' => $sis_endocrino,
                ':apt_genito_urinario' => $apt_genito_urinario,
                ':sis_hematico_linfatico' => $sis_hematico_linfatico,
                ':frec_respiratoria' => $frec_respiratoria,
                ':temp_corporal' => $temp_corporal,
                ':presion_arterial' => $presion_arterial,
                ':pulso' => $pulso
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