<?php
// Conexión a la base de datos
try {
    $mbd = new PDO('mysql:dbname=desarrollo_web;host=localhost', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}

try {
    
    $id=$_GET['id'];

    $statement=$mbd->prepare("SELECT * FROM tabla1 WHERE id_tabla1 = :id");
    $statement->bindParam(':id',$id);
    $statement->execute();
  
    // Retornamos resultados
    header('Content-type:application/json;charset=utf-8');    
    echo json_encode($statement->fetchAll(PDO::FETCH_ASSOC)[0]);

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