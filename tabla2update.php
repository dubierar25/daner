<?php
// Conexión a la base de datos
try {
    $mbd = new PDO('mysql:dbname=desarrollo_web;host=localhost', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}

try {
    /*id_tabla2 = 6
    id_tabla1 = 4
empresa_proveedor = empresa_proveedor
nombre_proveedor = nombre_proveedor
fecha_hora_registro = 2022-10-23 11:21:51
vencimiento_lote = 2024-10-23
num_lotes = 11
precio_unitario = 10010000
email = correo@correo.com*/
    // Asignamos los datos de las variables
    $id_tabla2=$_POST['id_tabla2'];
    $id_tabla1=$_POST['id_tabla1'];
    $empresa_proveedor=$_POST['empresa_proveedor'];
    $nombre_proveedor=$_POST['nombre_proveedor'];
    $fecha_hora_registro=$_POST['fecha_hora_registro'];
    $vencimiento_lote=$_POST['vencimiento_lote'];
    $num_lotes=$_POST['num_lotes'];
    $precio_unitario=$_POST['precio_unitario'];
    $email=$_POST['email'];

    

    $statement=$mbd->prepare("UPDATE tabla2 SET id_tabla1 = :id_tabla1, empresa_proveedor= :empresa_proveedor, nombre_proveedor= :nombre_proveedor, fecha_hora_registro = :fecha_hora_registro, vencimiento_lote = :vencimiento_lote, num_lotes= :num_lotes, precio_unitario = :precio_unitario, email = :email WHERE id_tabla2 = :id_tabla2");
    
    $statement->bindParam(':id_tabla1', $id_tabla1);
    $statement->bindParam(':empresa_proveedor', $empresa_proveedor);
    $statement->bindParam(':nombre_proveedor', $nombre_proveedor); 
    $statement->bindParam(':fecha_hora_registro', $fecha_hora_registro); 
    $statement->bindParam(':vencimiento_lote', $vencimiento_lote); 
    $statement->bindParam(':num_lotes', $num_lotes); 
    $statement->bindParam(':precio_unitario', $precio_unitario); 
    $statement->bindParam(':email', $email); 
    $statement->bindParam(':id_tabla2', $id_tabla2);

    
    $statement->execute();

    $stmt = $mbd->prepare("SELECT * FROM tabla1 WHERE id_tabla1 = :id");
    $stmt->bindParam(':id', $id_tabla1);
    $stmt->execute();

    $data_fk = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
    $_POST["data_fk"] = $data_fk[0];
    // Retornamos resultados
    header('Content-type:application/json;charset=utf-8');    
    echo json_encode(["mensaje" => "Registro actualizado satisfactoriamente",
    "data"=> $_POST
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