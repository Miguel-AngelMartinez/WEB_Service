<?php
require_once 'conection.php';
//metodo get
if($_SERVER["REQUEST_METHOD"] == "GET")
{
    if(isset($_GET['id']))
    {
    $sql = $pdo->prepare("SELECT * FROM clases WHERE id =:id");
    $sql->bindValue(':id', $_GET['id']);
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    header("HTTP/1.1 200 Correcto");
    echo json_encode($sql->fetchAll());
    exit();
    }
    
    else
    {
    $sql = $pdo->prepare("SELECT * FROM clases");
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
        $stmt = $pdo->prepare('INSERT INTO clases (grado, grupo, Tutor_ID) 
                               VALUES (:grado, :grupo, :Tutor_ID)');

        $stmt->bindParam(':grado', $data['grado']);
        $stmt->bindParam(':grupo', $data['grupo']);
        $stmt->bindParam(':Tutor_ID', $data['Tutor_ID']);

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
        try {
            $stmt = $pdo->prepare("UPDATE clases SET grado=:grado, grupo=:grupo, Tutor_ID=:Tutor_ID WHERE id=:id");
            $stmt->bindValue(':id', $_GET['id']);
            $stmt->bindParam(':grado', $data['grado']);
            $stmt->bindParam(':grupo', $data['grupo']);
            $stmt->bindParam(':Tutor_ID', $data['Tutor_ID']);
            $stmt->execute();
            echo "Actualizado exitosamente";
        } catch (PDOException $e) {
            http_response_code(500);
            echo "Error en la actualización de datos: " . $e->getMessage();
        }
    }
    else
    {
        http_response_code(400);
        echo "Error: Se debe especificar un ID";
    }
}
//metodo delete
if($_SERVER["REQUEST_METHOD"] == "DELETE")
{
    if(isset($_GET['id']))
    {
        try {
            $stmt = $pdo->prepare("DELETE FROM clases WHERE id=:id");
            $stmt->bindValue(':id', $_GET['id']);
            $stmt->execute();
            echo "Eliminado exitosamente";
        } catch (PDOException $e) {
            http_response_code(500);
            echo "Error en la eliminación de datos: " . $e->getMessage();
        }
    }
    else
    {
        http_response_code(400);
        echo "Error: Se debe especificar un ID";
    }
}
?>