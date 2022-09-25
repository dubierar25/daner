<?php
// Conexión a la base de datos
try {
    $mbd = new PDO('mysql:dbname=desarrollo_web;host=localhost', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}

try {

    $id = $_POST['id'];
    
    $stmt = $mbd->prepare("SELECT * FROM tabla2 WHERE id_tabla2 = :id");
    $stmt->bindParam(':id',$id);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($data != null) {
        $statement=$mbd->prepare("DELETE FROM tabla2 WHERE id_tabla2 = :id");
        $statement->bindParam(':id',$id);
        $statement->execute();

        $id = $data[0]['id_tabla1'];
        $stmt = $mbd->prepare("SELECT * FROM tabla1 WHERE id_tabla1 = :id");
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        $data_fk = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $data[0]["data_fk"] = $data_fk[0];
        
        header('Content-type:application/json;charset=utf-8');    
        echo json_encode(["mensaje" => "Registro eliminado satisfactoriamente",
    "data"=>$data[0]]);
    }else{
        header('Content-type:application/json;charset=utf-8');    
        echo json_encode(["mensaje" => "El id ingresado no pertenece a ningun registro"]);
    }
    

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