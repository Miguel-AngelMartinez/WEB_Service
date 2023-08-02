<?php
// 1. Establecer la conexión PDO
  // Datos de conexión a la base de datos
  $host = 'jhdjjtqo9w5bzq2t.cbetxkdyhwsb.us-east-1.rds.amazonaws.com'; // Por ejemplo, 'localhost'
  $dbname = 'n4ri2lcee1wd01m1';
  $username = 'n26pgrpxnjyg2980';
  $password = 'dtxl5943hu6hd1e9';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión a la base de datos: " . $e->getMessage());
}
?>