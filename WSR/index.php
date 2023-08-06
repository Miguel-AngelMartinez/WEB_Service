<?php
    include "conectar.php";
	$pdo = new conectar();

	if($_SERVER["REQUEST_METHOD"] == "GET")
	{
		if(isset($_GET['matricula']))
		{
	    $sql = $pdo->prepare("SELECT * FROM datos WHERE matricula=:matricula");
	    $sql->bindValue(':matricula', $_GET['matricula']);
		$sql->execute();
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		header("HTTP/1.1 200 Correcto");
		echo json_encode($sql->fetchAll());
		exit();
		}
		
		else
		{
		$sql = $pdo->prepare("SELECT * FROM datos");
		$sql->execute();
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		header("HTTP/1.1 200 Correcto");
		echo json_encode($sql->fetchAll());
		exit();		
		}
    } 


    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
       	$sql= "INSERT INTO datos (MATRICULA, NOMBRE, A_PATERNO, A_MATERNO, CORREO, ID, NUMERO_TELEFONICO, GRADO, ESTATUS, TURNO) VALUES (:matricula, :nombre, :a_paterno, :a_materno, :correo, :id, :numero_telefonico, :grado, :estatus, :turno)";
       	$insertar = $pdo->prepare($sql);
       	$insertar->bindValue(':matricula',$_POST['matricula']);
       	$insertar->bindValue(':nombre',$_POST['nombre']);
       	$insertar->bindValue(':a_paterno',$_POST['a_paterno']);
       	$insertar->bindValue(':a_materno',$_POST['a_materno']);
        $insertar->bindValue(':correo',$_POST['correo']);
       	$insertar->bindValue(':id',$_POST['id']);
       	$insertar->bindValue(':numero_telefonico',$_POST['numero_telefonico']);
       	$insertar->bindValue(':grado',$_POST['grado']);
        $insertar->bindValue(':estatus',$_POST['estatus']);
       	$insertar->bindValue(':turno',$_POST['turno']);
        $insertar->execute();
        exit();
    }

	if($_SERVER["REQUEST_METHOD"] == "PUT")
    {

		$putData = file_get_contents("php://input");
		parse_str($putData, $params);

		$sql= "UPDATE datos SET matricula=:matricula, nombre=:nombre, a_paterno=:a_paterno, a_materno=:a_materno, correo=:correo, id=:id,
		numero_telefonico=:numero_telefonico,estatus=:estatus, turno=:turno, grado=:grado
		 WHERE matricula=:matricula";

		$actualizar = $pdo->prepare($sql);
       	$actualizar->bindValue(':matricula',$params['matricula']);
       	$actualizar->bindValue(':nombre',$params['nombre']);
       	$actualizar->bindValue(':a_paterno',$params['a_paterno']);
       	$actualizar->bindValue(':a_materno',$params['a_materno']);
       	$actualizar->bindValue(':correo',$params['correo']);
       	$actualizar->bindValue(':id',$params['id']);
       	$actualizar->bindValue(':numero_telefonico',$params['numero_telefonico']);
       	$actualizar->bindValue(':grado',$params['grado']);
       	$actualizar->bindValue(':estatus',$params['estatus']);
       	$actualizar->bindValue(':turno',$params['turno']);

        $actualizar->execute();
    }

    if($_SERVER["REQUEST_METHOD"] == "DELETE")
    {
       	$sql= "DELETE FROM datos WHERE matricula=:matricula";
       	$actualizar = $pdo->prepare($sql);
       	$actualizar->bindValue(':matricula',$_GET['matricula']);
       	$actualizar->execute();
    }




?>  
