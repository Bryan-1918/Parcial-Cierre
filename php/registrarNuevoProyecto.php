<?php
session_start();
include "conexion.php";

// Validar rol estudiante
if ($_SESSION['rol'] != 'Estudiante') {
    echo "Acceso denegado";
    exit();
}

$idEstudiante = $_GET['idEstudiante'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // añadir proyecto
    $idEstudiante = $_POST['idEstudiante'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $approved = 0; // Por defecto no aprobado

    $conexion->query("INSERT INTO proyectos (titulo, descrip, approved, studentId) VALUES ('$title', '$description', $approved, $idEstudiante)");
    header("Location: ../panelesUsuarios/panelEstudiante.php?idEstudiante=" . (int)$idEstudiante);
    exit();

}
?>

<!-- Formulario HTML simple -->
<h2>Crear nuevo proyecto</h2>

<form method="POST" action="">
    Titulo del Proyecto:<br>
    <input type="text" name="title" required><br>
    Descripción:<br>
    <input type="text" name="description" required><br><br>
    <input type="text" name="idEstudiante" value="<?= (int)$idEstudiante ?>" hidden>
    <input type="submit" value="Registrar Proyecto">
</form>

