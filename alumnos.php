<?php
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
        $stmt = $pdo->prepare('INSERT INTO alumnos (nombre, a_paterno, a_materno, matricula, asistencia, Clase_ID, Padres_ID) 
                               VALUES (:nombre, :a_paterno, :a_materno, :matricula, :asistencia, :Clase_ID, :Padres_ID)');

        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':a_paterno', $data['a_paterno']);
        $stmt->bindParam(':a_materno', $data['a_materno']);
        $stmt->bindParam(':matricula', $data['matricula']);
        $stmt->bindParam(':asistencia', $data['asistencia']);
        $stmt->bindParam(':Clase_ID', $data['Clase_ID']);
        $stmt->bindParam(':Padres_ID', $data['Padres_ID']);

        $stmt->execute();

        // Enviar la respuesta exitosa al cliente
        echo "Enviado exitosamente";
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
    $sql = $pdo->prepare("SELECT * FROM alumnos WHERE id =:id");
    $sql->bindValue(':id', $_GET['id']);
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    header("HTTP/1.1 200 Correcto");
    echo json_encode($sql->fetchAll());
    exit();
    }
    
    else
    {
    $sql = $pdo->prepare("SELECT * FROM alumnos");
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    header("HTTP/1.1 200 Correcto");
    echo json_encode($sql->fetchAll());
    exit();		
    }
}
//metodo put
if($_SERVER["REQUEST_METHOD"] == "PUT"){
    $sql = "UPDATE alumnos SET nombre=:nombre, a_paterno=:a_paterno, a_materno=:a_materno, matricula=:matricula, asistencia=:asistencia, Clase_ID=:Clase_ID, Padres_ID=:Padres_ID WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $_GET['id']);
    $stmt->bindParam(':nombre', $_GET['nombre']);
    $stmt->bindParam(':a_paterno', $_GET['a_paterno']);
    $stmt->bindParam(':a_materno', $_GET['a_materno']);
    $stmt->bindParam(':matricula', $_GET['matricula']);
    $stmt->bindParam(':asistencia', $_GET['asistencia']);
    $stmt->bindParam(':Clase_ID', $_GET['Clase_ID']);
    $stmt->bindParam(':Padres_ID', $_GET['Padres_ID']);
    $stmt->execute();
    header("HTTP/1.1 200 Correcto");
    exit();
}
//metodo delete
if($_SERVER["REQUEST_METHOD"] == "DELETE"){
    $sql = "DELETE FROM alumnos WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $_GET['id']);
    $stmt->execute();
    header("HTTP/1.1 200 Correcto");
    exit();
}
 else {
    http_response_code(405); // Método no permitido
    echo "Error: Esta API solo admite solicitudes POST en formato JSON.";
}

?>
