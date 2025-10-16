<?php
include "conexion.php";
session_start();

$idProyecto = $_GET['idProyecto'];
$idEstudiante = $_GET['idEstudiante'];

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $entregable = $_POST['entregable'];
    $sql = "INSERT INTO entregables (project, studentId, entregable) VALUES ($idProyecto, $idEstudiante, '$entregable')";
    $conexion->query($sql);

    header("Location: ../panelesUsuarios/panelEstudiante.php?idEstudiante=" . (int)$idEstudiante);

    exit();
}
?>

<h2>Adjuntar entregable</h2>
<form method="POST">
    <input type="hidden" name="idEstudiante" value="<?php echo $_SESSION['id']; ?>">
    <label>Añadir enlaces a entregable:</label><br>
    <textarea name="entregable" rows="8" cols="60" maxlength="1000" required></textarea><br><br>
    <input type="submit" value="Enviar entregable">
</form>
