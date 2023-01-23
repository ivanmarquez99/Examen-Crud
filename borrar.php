<?php

require_once 'pdoconfig.php';
 
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $pe) {
    die("Could not connect to the database $dbname :" . $pe->getMessage());
}


$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
// Prepara DELETE
$miConsulta = $conn->prepare('DELETE FROM crud_table WHERE id = :id');
// Ejecuta la sentencia SQL
$miConsulta->execute([
    'id' => $id
]);
// Redireccionamos al PHP con todos los datos
header('Location: indexInicial.php');
?>