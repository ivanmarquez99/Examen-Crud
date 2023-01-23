<?php 
require_once 'pdoconfig.php';
 
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $pe) {
    die("Could not connect to the database $dbname :" . $pe->getMessage());
}

$sql= $conn->prepare('SELECT * FROM crud_table;');
$sql->execute();

// Comprobamso si recibimos datos por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  // Recogemos las variables
  $nombre = isset($_REQUEST['Nom']) ? $_REQUEST['Nom'] : null;
  $apellido = isset($_REQUEST['Ape']) ? $_REQUEST['Ape'] : null;
  $direccion = isset($_REQUEST['Dir']) ? $_REQUEST['Dir'] : null;
  $miInsert = $conn->prepare('INSERT INTO crud_table (nombre, apellido, direccion) VALUES (:nombre, :apellido, :direccion)');
  // Ejecuta INSERT con los datos
  $miInsert->execute(
      array(
          'nombre' => $nombre,
          'apellido' => $apellido,
          'direccion' => $direccion
      )
  );
  // Redireccionamos a indexInicial
  header('Location: indexInicial.php');
} 

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>CRUD</title>
<link rel="stylesheet" type="text/css" href="hoja.css">


</head>

<body>


<h1>CRUD<span class="subtitulo">Create Read Update Delete</span></h1>

<form method="post">
  <table width="50%" border="0" align="center">
    <tr >
      <td class="primera_fila">Id</td>
      <td class="primera_fila">Nombre</td>
      <td class="primera_fila">Apellido</td>
      <td class="primera_fila">Dirección</td>
      <td class="sin">&nbsp;</td>
      <td class="sin">&nbsp;</td>
      <td class="sin">&nbsp;</td>
    </tr> 
    <?php foreach ($sql as $clave => $valor): ?> 
    <tr>
      <td><?= $valor['id']; ?></td>
      <td><?= $valor['nombre']; ?></td>
      <td><?= $valor['apellido']; ?></td>
      <td><?= $valor['direccion']; ?></td>
      <td class="bot"><input type='submit' name='del' id='del' value='Borrar' formaction="borrar.php?id=<?= $valor['id'] ?>"></td>
      <td class='bot'><input type='submit' name='up' id='up' value='Actualizar' formaction="editarInicial.php?id=<?= $valor['id'] ?>"></td>
    </tr>
    <?php endforeach; ?>     
	<tr>
	    <td></td>
      <td><input type='text' name='Nom' id='Nom' size='10' class='centrado'></td>
      <td><input type='text' name='Ape' id='Ape' size='10' class='centrado'></td>
      <td><input type='text' name='Dir' id='Dir' size='10' class='centrado'></td>
      <td class='bot'><input type='submit' name='cr' id='cr' value='Insertar'></td>
    </tr>    
  </table>
    </form>

<p>&nbsp;</p>
</body>
</html>