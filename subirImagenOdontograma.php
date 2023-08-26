<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Access-Control-Allow-Origin: *');
// Incluir la función para subir archivos a la base de datos
include 'procesarImagenOdontograma.php';

// Manejar la solicitud POST enviada desde el formulario de Angular
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Verificar que se envió un archivo
  if(isset($_FILES['imageFile'])) {
    // Llamar a la función para subir el archivo a la base de datos
    $resultado = upload_file($_FILES['imageFile']);

    // Devolver la respuesta en formato JSON
    header('Content-Type: application/json');
    echo json_encode($resultado);
  } else {
    // Devolver un error si no se envió un archivo
    header('HTTP/1.1 400 Bad Request');
    echo json_encode('No se envió ningún archivo.');
  }
}
?>