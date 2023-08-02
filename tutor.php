<?php
require_once 'conection.php';
//metodo get
if($_SERVER["REQUEST_METHOD"] == "GET")
{
    if(isset($_GET['id']))
    {
    $sql = $pdo->prepare("SELECT * FROM tutor WHERE id =:id");
    $sql->bindValue(':id', $_GET['id']);
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    header("HTTP/1.1 200 Correcto");
    echo json_encode($sql->fetchAll());
    exit();
    }
    
    else
    {
    $sql = $pdo->prepare("SELECT * FROM tutor");
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    header("HTTP/1.1 200 Correcto");
    echo json_encode($sql->fetchAll());
    exit();		
    }
}
//metodo post
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
        $stmt = $pdo->prepare('INSERT INTO tutor (nombre, a_paterno, a_materno, cedula, edad, direccion, telefono) 
                               VALUES (:nombre, :a_paterno, :a_materno, :cedula, :edad, :direccion, :telefono)');

        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':a_paterno', $data['a_paterno']);
        $stmt->bindParam(':a_materno', $data['a_materno']);
        $stmt->bindParam(':cedula', $data['cedula']);
        $stmt->bindParam(':edad', $data['edad']);
        $stmt->bindParam(':direccion', $data['direccion']);
        $stmt->bindParam(':telefono', $data['telefono']);

        $stmt->execute();

        // Enviar la respuesta exitosa al cliente
        echo "Enviado exitosamente";
    } catch (PDOException $e) {
        http_response_code(500);
        echo "Error en la inserción de datos: " . $e->getMessage();
    }
}
//metodo put
if($_SERVER["REQUEST_METHOD"] == "PUT")
{
    if(isset($_GET['id']))
    {
        $id = $_GET['id'];
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
        $nombre = $data['nombre'];
        $a_paterno = $data['a_paterno'];
        $a_materno = $data['a_materno'];
        $cedula = $data['cedula'];
        $edad = $data['edad'];
        $direccion = $data['direccion'];
        $telefono = $data['telefono'];
        $sql = "UPDATE tutor SET nombre=:nombre, a_paterno=:a_paterno, a_materno=:a_materno, cedula=:cedula, edad=:edad, direccion=:direccion, telefono=:telefono WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':a_paterno', $a_paterno);
        $stmt->bindParam(':a_materno', $a_materno);
        $stmt->bindParam(':cedula', $cedula);
        $stmt->bindParam(':edad', $edad);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->execute();
        echo "Actualizado exitosamente";
    }
    else
    {
        echo "Error, no se recibio el id";
    }
}
//metodo delete
if($_SERVER["REQUEST_METHOD"] == "DELETE")
{
    if(isset($_GET['id']))
    {
        $id = $_GET['id'];
        $sql = "DELETE FROM tutor WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        echo "Eliminado exitosamente";
    }
    else
    {
        echo "Error, no se recibio el id";
    }
}
else {
    http_response_code(405); // Método no permitido
    echo "Error: Esta API solo admite solicitudes POST en formato JSON.";
}
?>