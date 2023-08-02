<?php
require_once 'conection.php';
//metodo get
if($_SERVER["REQUEST_METHOD"] == "GET")
{
    if(isset($_GET['id']))
    {
    $sql = $pdo->prepare("SELECT * FROM notificaciones WHERE id =:id");
    $sql->bindValue(':id', $_GET['id']);
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    header("HTTP/1.1 200 Correcto");
    echo json_encode($sql->fetchAll());
    exit();
    }
    
    else
    {
    $sql = $pdo->prepare("SELECT * FROM notificaciones");
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
        $stmt = $pdo->prepare('INSERT INTO notificaciones (titulo, descripcion, fecha, Alumnos_ID) 
                               VALUES (:titulo, :descripcion, :fecha, :Alumnos_ID)');

        $stmt->bindParam(':titulo', $data['titulo']);
        $stmt->bindParam(':descripcion', $data['descripcion']);
        $stmt->bindParam(':fecha', $data['fecha']);
        $stmt->bindParam(':Alumnos_ID', $data['Alumnos_ID']);

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
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
        $sql = $pdo->prepare("UPDATE notificaciones SET titulo = :titulo, descripcion = :descripcion, fecha = :fecha, Alumnos_ID = :Alumnos_ID WHERE id = :id");
        $sql->bindValue(':id', $_GET['id']);
        $sql->bindParam(':titulo', $data['titulo']);
        $sql->bindParam(':descripcion', $data['descripcion']);
        $sql->bindParam(':fecha', $data['fecha']);
        $sql->bindParam(':Alumnos_ID', $data['Alumnos_ID']);
        $sql->execute();
        echo "Actualizado exitosamente";
        exit();
    }
}
//metodo delete
if($_SERVER["REQUEST_METHOD"] == "DELETE")
{
    if(isset($_GET['id']))
    {
        $sql = $pdo->prepare("DELETE FROM notificaciones WHERE id = :id");
        $sql->bindValue(':id', $_GET['id']);
        $sql->execute();
        echo "Eliminado exitosamente";
        exit();
    }
}

?>