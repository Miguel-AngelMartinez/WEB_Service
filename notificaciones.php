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
        $stmt = $pdo->prepare('INSERT INTO notificaciones (token, padres_id) 
                               VALUES (:token, :padres_id)');

        $stmt->bindParam(':token', $data['token']);
        $stmt->bindParam(':padres_id', $data['padres_id']);
        

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
        $sql = $pdo->prepare("UPDATE notificaciones SET token = :token, padres_id=:padres_id  WHERE id = :id");
        $sql->bindValue(':id', $_GET['id']);
        $sql->bindParam(':token', $data['token']);
        $sql->bindParam(':padres_id', $data['padres_id']);
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