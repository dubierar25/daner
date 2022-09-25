<?php
// Conexión a la base de datos
try {
    $mbd = new PDO('mysql:dbname=desarrollo_web;host=localhost', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}

try {
    $id = $_GET["id"];

    

    $statement=$mbd->prepare("SELECT * FROM tabla2 WHERE id_tabla2 = :id");
    $statement->bindParam(':id', $id); 
    $statement->execute();

    $data = $statement->fetchAll(PDO::FETCH_ASSOC);

    $statement=$mbd->prepare("SELECT * FROM tabla1 WHERE id_tabla1 = :id");
    $statement->bindParam(':id', $data[0]['id_tabla1']); 
    $statement->execute();

    $data_fk = $statement->fetchAll(PDO::FETCH_ASSOC);

    $data[0]["data_fk"] = $data_fk[0];
  
    // Retornamos resultados
    header('Content-type:application/json;charset=utf-8');    
    echo json_encode($data[0]);
    
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