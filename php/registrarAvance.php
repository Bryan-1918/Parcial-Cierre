<?php
include "conexion.php";
session_start();

$idProyecto = $_GET['idProyecto'];

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $detalle = $_POST['detalle'];
    $sql = "INSERT INTO avances (project, tutorId, avance) VALUES ($idProyecto, $tutorId, '$detalle')";
    $conexion->query($sql);
    header("Location: ../panelesUsuarios/panelTutor.php");
    exit();
}
?>

<h2>Registrar Avance</h2>
<form method="post">
    <label>Detalle del Avance:</label><br>
    <textarea name="detalle" rows="8" cols="60" maxlength="1000" required></textarea><br><br>
    <input type="submit" value="Guardar Avance">
    <a href="../panelesUsuarios/panelTutor.php">Cancelar</a>
</form>
