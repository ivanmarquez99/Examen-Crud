<?php 
require_once 'pdoconfig.php';
 
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $pe) {
    die("Could not connect to the database $dbname :" . $pe->getMessage());
}

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
$nombre = isset($_REQUEST['nom']) ? $_REQUEST['nom'] : null;
$apellido = isset($_REQUEST['ape']) ? $_REQUEST['ape'] : null;
$direccion = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : null;

// Prepara SELECT
$miConsulta = $conn->prepare('SELECT * FROM crud_table WHERE id = :id');
// Ejecuta consulta
$miConsulta->execute(
    [
        'id' => $id
    ]
);

// Comprobamso si recibimos datos por POST
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // Prepara UPDATE
  $miUpdate = $conn->prepare('UPDATE crud_table SET nombre = :nombre, apellido = :apellido, direccion = :direccion WHERE id = :id');
  // Ejecuta UPDATE con los datos
  $miUpdate->execute(
    [
      'id' => $id,
      'nombre' => $nombre,
      'apellido' => $apellido,
      'direccion' => $direccion
    ]
  );
  // Redireccionamos a Leer
  header('Location: indexInicial.php');
  
}

// Obtiene un resultado
$valor = $miConsulta->fetch();

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
<link rel="stylesheet" type="text/css" href="hoja.css">
</head>

<body>

<h1>ACTUALIZAR</h1>

<p>
 
</p>
<p>&nbsp;</p>
<form name="form1" method="get">
  <table width="25%" border="0" align="center">
    <tr>
      <td></td>
      <td><label for="id"></label>
      <input type="hidden" name="id" id="id" value="<?= $valor['id'] ?>"></td>
    </tr>
    <tr>
      <td>Nombre</td>
      <td><label for="nom"></label>
      <input type="text" name="nom" id="nom" value="<?= $valor['nombre'] ?>"></td>
    </tr>
    <tr>
      <td>Apellido</td>
      <td><label for="ape"></label>
      <input type="text" name="ape" id="ape" value="<?= $valor['apellido'] ?>"></td>
    </tr>
    <tr>
      <td>Dirección</td>
      <td><label for="dir"></label>
      <input type="text" name="dir" id="dir" value="<?= $valor['direccion'] ?>"></td>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" name="bot_actualizar" id="bot_actualizar" value="Actualizar"></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>