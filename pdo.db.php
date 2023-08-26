<?php
//Conexion para la base de datos reutilizable mediante PDO
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Content-Type: application/json; charset=UTF-8");
require_once 'configDB.php';

try {
    $con = new PDO("mysql:host=$server;port=$port;dbname=$db",$user,$pass);
} catch(PDOException $e) {
    echo json_encode("Conexion fallida: " . $e->getMessage());
}
?>