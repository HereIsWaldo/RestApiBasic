<?php

    


/***
 * 
 * Funcion para generar el numero de expediente se necesitan dos parametros numero de expediente
 * el primer parametro es el numero de expediente puede contener ("no" o el numero de expediente anterior)
 * retorna un numero de expediente nuevo para el paciente que se registre
 */
function generarNumExp($num_exp, $fecha_nacimiento){


if($num_exp == 'no'){
    
    return nuevoExp($fecha_nacimiento);

}else{
    return existenteToNuevoExp($num_exp);
}



}





/***
 * Funcion para generar un numero de expediente desde cero
 * se necesita la fecha de nacimiento del usuario para determinar si es menor o mayor de edad
 */
function nuevoExp($fecha_nacimiento){
    require_once 'pdo.db.php';
    $nuevo_Num_Exp = "D"; // El primer caracter del numero de expediente nuevo sera D referente a que se genero digitalmente desde cero

    if(intval(getEdad($fecha_nacimiento))>=18){
        $nuevo_Num_Exp = $nuevo_Num_Exp . 'A'; //Se le concatena la letra A en caso de tener la mayoria de edad
    }else{
        $nuevo_Num_Exp = $nuevo_Num_Exp . 'O'; //Si no tiene la mayoria de edad se le concatena la letra O
   }

   $nuevo_Num_Exp = $nuevo_Num_Exp . "-". substr(date('Y'),2,4); //Despues de la letra referente a la edad en que se registro, se concatena los ultimos dos digitos del año actual
   try {
    $query = "SELECT MAX(num_expediente) AS ultimo_num_exp_d FROM pacientes WHERE num_expediente LIKE 'D%'";//Se consulta en la base de datos el ultimo numero de expediente registrado con la inicial D 
    $resultado = $con->query($query);
    $fila = $resultado->fetch(PDO::FETCH_ASSOC);
    $ultimo_num_exp_d = $fila["ultimo_num_exp_d"];
    
    
    
   } catch (PDOException $e) {
    echo json_encode(['mensaje' => 'Error en la consulta' . $e->getMessage()]);
   }

   $num_consecuente = intval(substr($ultimo_num_exp_d,8,13))+1;//Se le suma 1 al numero de expediente anterior
   $nuevo_Num_Exp = $nuevo_Num_Exp . str_pad($num_consecuente, 6, "0", STR_PAD_LEFT);//Se le da el formato deseado completando el hasta tener 6 digitos despues del año
    
   
   $con = null;
   return $nuevo_Num_Exp; //La funcion retorna el nuevo numero de expediente
}


/***
 * Funcion para generar un nuevo numero de expediente basado en uno ya existente
 * En este caso el parametro es el numero de expediente que debe tener el siguiente formato S-A-000000 
 * lo importante es la posicion de la letra "A"
 */
function existenteToNuevoExp($num_expediente){
    require_once 'pdo.db.php';
    $nuevo_Num_Exp_F = "F"; //La primera letra sera F, dando a entender que proviene de un numero de expediente existente en fisico
    
    $nuevo_Num_Exp_F = $nuevo_Num_Exp_F . substr($num_expediente, 2,1);//Se toma la "A" o la letra "O" del expediente proporcionado
    
    $nuevo_Num_Exp_F = $nuevo_Num_Exp_F . "-". substr(date('Y'), 2, 4);// Se le concateta los ultimos dos digitos del año actual
    
    $ultimo_num_exp_f = "FA-000000"; 
    
    try {
        $query = "SELECT MAX(num_expediente) AS ultimo_num_exp_f FROM pacientes WHERE num_expediente LIKE 'F%'";//Se toma el ultimo numero de expediente que inicia con F
        $resultado = $con->query($query);
        $fila = $resultado->fetch(PDO::FETCH_ASSOC);
    
        if ($fila && isset($fila['ultimo_num_exp_f'])) {
            $ultimo_num_exp_f = $fila['ultimo_num_exp_f'];
        }
    } catch (PDOException $e) {
        echo json_encode(['mensaje' => 'Error en la inserción de datos: ' . $e->getMessage()]);
    }
    
    $num_consecuente = intval(substr($ultimo_num_exp_f, 4, 9)) + 1;
    $nuevo_Num_Exp_F = $nuevo_Num_Exp_F . str_pad($num_consecuente, 6, "0", STR_PAD_LEFT);//Se le agrega el numero consecutivo formateado en 6 digitos
    

    $con = null;
    return $nuevo_Num_Exp_F;//Retorna el nuevo numero de expediente
    
   



}


/**
 * Funcion para obtener la edad de un paciente mediante su fecha de nacimiento
 * 
 */
function getEdad($fecha_nacimiento){
    
$anio_actual = date("Y");
$mes_actual = date("m");
$dia_actual = date("d");

$anio_nacimiento = substr($fecha_nacimiento, 0, 4);
$mes_nacimiento = substr($fecha_nacimiento, 5, 2);
$dia_nacimiento = substr($fecha_nacimiento, 8, 2);

$edad = $anio_actual - $anio_nacimiento;

if ($mes_actual < $mes_nacimiento || ($mes_actual == $mes_nacimiento && $dia_actual < $dia_nacimiento)) {
    $edad--;
}

return $edad;


}



