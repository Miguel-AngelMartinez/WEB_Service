<?php
// Definir el punto de entrada para crear la base de datos y las tablas
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    createDatabaseAndTables();
}

// Función para crear la base de datos y las tablas
function createDatabaseAndTables()
{
    $host = 'jhdjjtqo9w5bzq2t.cbetxkdyhwsb.us-east-1.rds.amazonaws.com'; // Por ejemplo, 'localhost'
    $dbname = 'n4ri2lcee1wd01m1';
    $username = 'n26pgrpxnjyg2980';
    $password = 'dtxl5943hu6hd1e9';

    try {
        $pdo = new PDO("mysql:host=$host", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Crear la base de datos pase_de_lista
        $pdo->exec('CREATE DATABASE IF NOT EXISTS n4ri2lcee1wd01m1');
        $pdo->exec('USE pase_de_lista');

      

        // Crear la tabla "padres"
        $pdo->exec('CREATE TABLE IF NOT EXISTS padres (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(50) NOT NULL,
            a_paterno VARCHAR(50) NOT NULL,
            a_materno VARCHAR(50),
            direccion VARCHAR(100),
            telefono VARCHAR(20)
        )');

          // Crear la tabla "tutor"
          $pdo->exec('CREATE TABLE IF NOT EXISTS tutor (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(50) NOT NULL,
            a_paterno VARCHAR(50) NOT NULL,
            a_materno VARCHAR(50),
            cedula VARCHAR(20),
            edad INT,
            direccion VARCHAR(100),
            telefono VARCHAR(20)
        )');


        // Crear la tabla "clases"
        $pdo->exec('CREATE TABLE IF NOT EXISTS clases (
            id INT AUTO_INCREMENT PRIMARY KEY,
            grado VARCHAR(10) NOT NULL,
            grupo VARCHAR(5) NOT NULL,
            Tutor_ID INT,
            FOREIGN KEY (Tutor_ID) REFERENCES tutor(id)
        )');

        // Crear la tabla "alumnos"
        $pdo->exec('CREATE TABLE IF NOT EXISTS alumnos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(50) NOT NULL,
            a_paterno VARCHAR(50) NOT NULL,
            a_materno VARCHAR(50),
            matricula VARCHAR(20),
            asistencia INT,
            Clase_ID INT,
            Padres_ID INT,
            FOREIGN KEY (Clase_ID) REFERENCES clases(id),
            FOREIGN KEY (Padres_ID) REFERENCES padres(id)
        )');

      
        // Crear la tabla "notificacion"
        $pdo->exec('CREATE TABLE IF NOT EXISTS notificacion (
            id INT AUTO_INCREMENT PRIMARY KEY,
            Token VARCHAR(100),
            Padres_ID INT,
            FOREIGN KEY (Padres_ID) REFERENCES padres(id)
        )');

        echo "Base de datos y tablas creadas exitosamente.";
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>
