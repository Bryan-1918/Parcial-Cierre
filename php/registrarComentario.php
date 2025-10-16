<?php
include "conexion.php";
session_start();

$idProyecto = $_GET['idProyecto'];

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $comentario = $_POST['comentario'];
    $sql = "INSERT INTO comentarios (project, tutorId, comentario) VALUES ($idProyecto, $tutorId, '$comentario')";
    $conexion->query($sql);
    header("Location: ../panelesUsuarios/panelTutor.php");
    exit();
}
?>

<h2>Añadir comentarios</h2>
<form method="post">
    <label>Comentar sobre este proyecto:</label><br>
    <textarea name="comentario" rows="8" cols="60" maxlength="1000" required></textarea><br><br>
    <input type="submit" value="Enviar comentario">
    <a href="../panelesUsuarios/panelTutor.php">Cancelar</a>
</form>
