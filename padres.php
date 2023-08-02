<?php
//llamar conection.php
require_once 'conection.php';

// 2. Recibir y procesar los datos JSON del cliente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['CONTENT_TYPE'] === 'application/json') {
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);

    // Verificar que se recibieron los datos correctamente
    if (empty($data)) {
        http_response_code(400);
        echo "Error: No se recibieron datos JSON válidos.";
        exit;
    }

    // Procesar los datos y almacenarlos en la base de datos
    try {
        $stmt = $pdo->prepare('INSERT INTO padres (nombre, a_paterno, a_materno, direccion, telefono) 
                               VALUES (:nombre, :a_paterno, :a_materno, :direccion, :telefono)');

        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':a_paterno', $data['a_paterno']);
        $stmt->bindParam(':a_materno', $data['a_materno']);
        $stmt->bindParam(':direccion', $data['direccion']);
        $stmt->bindParam(':telefono', $data['telefono']);

        $stmt->execute();

        // Obtener el ID del nuevo registro insertado
        $nuevo_id = $pdo->lastInsertId();

        // Enviar la respuesta exitosa al cliente
        echo "Enviado exitosamente. ID del nuevo registro: " . $nuevo_id;
        return  json_decode($json_data, true);
    } catch (PDOException $e) {
        http_response_code(500);
        echo "Error en la inserción de datos: " . $e->getMessage();
    }
}
//metodo get
if($_SERVER["REQUEST_METHOD"] == "GET")
{
    if(isset($_GET['id']))
    {
    $sql = $pdo->prepare("SELECT * FROM padres WHERE id =:id");
    $sql->bindValue(':id', $_GET['id']);
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    header("HTTP/1.1 200 Correcto");
    echo json_encode($sql->fetchAll());
    exit();
    }
    
    else
    {
    $sql = $pdo->prepare("SELECT * FROM padres");
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    header("HTTP/1.1 200 Correcto");
    echo json_encode($sql->fetchAll());
    exit();		
    }
}
//metodo put
if($_SERVER["REQUEST_METHOD"] == "PUT")
{
	$sql= "UPDATE padres SET nombre=:nombre, a_paterno=:a_paterno, a_materno=:a_materno, direccion=:direccion, telefono=:telefono WHERE id=:id";
       	$actualizar = $pdo->prepare($sql);
       	$actualizar->bindValue(':id',$_GET['id']);
       	$actualizar->bindValue(':nombre',$_GET['nombre']);
       	$actualizar->bindValue(':a_paterno',$_GET['a_paterno']);
       	$actualizar->bindValue(':a_materno',$_GET['a_materno']);
        $actualizar->bindValue(':direccion',$_GET['direccion']);
        $actualizar->bindValue(':telefono',$_GET['telefono']);
        $actualizar->execute();
       
        if ($actualizar->rowCount() > 0) {
            echo json_encode(array('message' => 'Actualización exitosa'));
        } else {
            echo json_encode(array('message' => 'No se encontraron registros para actualizar'));
        }
        exit();
            
    
        exit();	
}
//metodo delete
if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $sql = "DELETE FROM padres WHERE id=:id";
    $actualizar = $pdo->prepare($sql);
    $actualizar->bindValue(':id', $_GET['id']);
    $actualizar->execute();
    
    if ($actualizar->rowCount() > 0) {
        echo json_encode(array('message' => 'Elemento borrado exitosamente'));
    } else {
        echo json_encode(array('message' => 'El elemento no existe o ya ha sido eliminado'));
    }
}

 else {
    http_response_code(405); // Método no permitido
    echo "Error: Esta API solo admite solicitudes POST en formato JSON.";
}
?>

