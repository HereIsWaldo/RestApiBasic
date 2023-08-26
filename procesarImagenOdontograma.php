<?php
require_once 'ConfigDB.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
function upload_file($archivo) {
  $nombre = $archivo['name'];
  $ruta_temporal = $archivo['tmp_name'];

  // Validar que el archivo subido sea una imagen
  $extensiones_permitidas = array('jpg', 'jpeg', 'png', 'gif');
  $extension_archivo = strtolower(pathinfo($nombre, PATHINFO_EXTENSION));
  $es_imagen = getimagesize($ruta_temporal) !== false;

  if(!in_array($extension_archivo, $extensiones_permitidas) || !$es_imagen) {
    return array('success' => false, 'message' => 'El archivo subido no es una imagen válida.');
  }

  // Obtener el último ID insertado en la tabla de imágenes
  global $server, $port, $db, $user, $pass;
  try {
    $con = new PDO("mysql:host=$server;port=$port;dbname=$db",$user,$pass);

    $sql = 'SELECT MAX(id) AS max_id FROM odontograma';
    $statement = $con->prepare($sql);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    $last_id = $row['max_id'];

    $new_id = $last_id + 1;
    $nombre_archivo = "odontograma-$new_id.$extension_archivo";
    $ruta_destino = 'D:\Appserv\www\Uploads\\' . $nombre_archivo;//IMPORTANTE, ESTA ES LA RUTA EN LA QUE SE GUARDARA LA IMAGEN

    if(move_uploaded_file($ruta_temporal, $ruta_destino)) {
      // Insertar la ruta en la tabla de imágenes
      $sql = 'INSERT INTO odontograma (id_hc, imagen, ex_clinicos,inter_radiografica,diagnostico, observaciones) VALUES (:id_hc, :imagen, :ex_clinicos,:inter_radiografica, :diagnostico, :observaciones)';
      $statement = $con->prepare($sql);
      $statement->execute([
        'id_hc' => 2 ,
        'imagen' => $ruta_destino,
        'ex_clinicos'=> 'ex_clinicos',
        'inter_radiografica'=>'inter_radiografica',
        'diagnostico' => 'diagnostico',
        'observaciones' => 'observaciones'
        
      ]);

      $con = null;

      return array('success' => true, 'message' => 'La imagen se ha subido correctamente.');
    } else {
      return array('success' => false, 'message' => 'Se ha producido un error al subir la imagen.');
    }
  } catch(PDOException $e) {
    return array('success' => false, 'message' => 'Error al conectar con la base de datos: ' . $e->getMessage());
  }
}
?>
