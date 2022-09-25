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
    $id=$_POST['id_tabla1'];
    $descripcion=$_POST['descripcion'];
    $nombre_producto=$_POST['nombre_producto'];
    $cantidad=$_POST['cantidad'];

    

    $statement=$mbd->prepare("UPDATE tabla1 SET descripcion = :descripcion, nombre_producto= :nombre_producto, cantidad= :cantidad WHERE id_tabla1 = :id_tabla1");
    $statement->bindParam(':id_tabla1', $id);
    $statement->bindParam(':descripcion', $descripcion);
    $statement->bindParam(':nombre_producto', $nombre_producto);
    $statement->bindParam(':cantidad', $cantidad); 

    
    $statement->execute();
  
    // Retornamos resultados
    header('Content-type:application/json;charset=utf-8');    
    echo json_encode([
        "mensaje"=> "Registro actualizado satisfactoriamente",
        'data' => $_POST
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