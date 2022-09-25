<?php
// Conexión a la base de datos
try {
    $mbd = new PDO('mysql:dbname=desarrollo_web;host=localhost', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}

try {
    // Asignamos los datos de las variables
    $descripcion=$_POST['descripcion'];
    $nombre_producto=$_POST['nombre_producto'];
    $cantidad=$_POST['cantidad'];

    

    $statement=$mbd->prepare("INSERT INTO tabla1(descripcion, nombre_producto, cantidad) VALUES (:descripcion, :nombre_producto, :cantidad)");
    
    $statement->bindParam(':descripcion', $descripcion);
    $statement->bindParam(':nombre_producto', $nombre_producto);
    $statement->bindParam(':cantidad', $cantidad); 

    
    $statement->execute();
  
    // Retornamos resultados
    header('Content-type:application/json;charset=utf-8');    
    echo json_encode([
        'id' => $mbd->lastInsertId(),
        'descripcion' => $descripcion,
        'nombre_producto' => $nombre_producto,
        'cantidad' => $cantidad
    ]);

} catch (PDOException $e) {
    header('Content-type:application/json;charset=utf-8');    
    echo json_encode([
        'error' => [
            'codigo' =>$e->getCode() ,
            'mensaje' => $e->getMessage()
        ]
    ]);
}


?>