<?php
$localhost = "localhost";
$loginDB = "root";
$passwordDB = "";
$nambreDB = "parcial";

$conexion = mysqli_connect($localhost, $loginDB, $passwordDB,$nambreDB);
if (!$conexion) {
  die("falla la conexión: " . mysqli_connect_error());
}
echo "Ok Conexion";
?>