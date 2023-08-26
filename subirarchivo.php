<?php

header('Access-Control-Allow-Origin: *');
// Incluir la función para subir archivos a la base de datos
include 'procesar.php';

// Manejar la solicitud POST enviada desde el formulario de Angular
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Verificar que se envió un archivo
  if(isset($_FILES['nombre_archivo'])) {
    // Llamar a la función para subir el archivo a la base de datos
    $resultado = upload_file($_FILES['nombre_archivo']);

    // Devolver la respuesta en formato JSON
    header('Content-Type: application/json');
    echo json_encode($resultado);
  } else {
    // Devolver un error si no se envió un archivo
    header('HTTP/1.1 400 Bad Request');
    echo 'No se envió ningún archivo.';
  }
}
?>
