<?php
session_start();
include "../php/conexion.php";

// Validar rol coordinador
if ($_SESSION['rol'] != 'Estudiante') {
    echo "Acceso denegado";
    exit();
}

$idEstudiante = $_GET['idEstudiante'];
$tutorId = $_SESSION['id']; // Asegúrate de que la sesión esté activa

$result = $conexion->query("SELECT 
    proyectos.id, 
    proyectos.titulo, 
    proyectos.studentId,
    proyectos.descrip, 
    proyectos.approved, 
    GROUP_CONCAT(DISTINCT comentarios.comentario SEPARATOR ' <br></br> ') AS comentarios,
    GROUP_CONCAT(DISTINCT entregables.entregable SEPARATOR ' <br></br> ') AS entregables
    FROM proyectos
    LEFT JOIN comentarios ON proyectos.id = comentarios.project
    LEFT JOIN entregables ON proyectos.id = entregables.project
    WHERE proyectos.studentId = $idEstudiante   
    GROUP BY proyectos.id, proyectos.titulo, proyectos.descrip, proyectos.approved, proyectos.studentId
");
$rows = $result->fetch_all(MYSQLI_ASSOC);
?>
<h2>Mis proyectos</h2>

<table border="1">
    <tr>
        <th>Titulo</th>
        <th>Descripcion</th>
        <th>Entregables</th>
        <th>Retroalimentación tutor</th>
        <th>Estado</th>
    </tr>
    <?php foreach ($rows as $row) { ?>
    <tr>
        <td><?= $row['titulo'] ?></td>
        <td><?= $row['descrip'] ?></td>
        <td><?= $row['entregables'] ?> </td>
        <td><?= $row['comentarios'] ?></td>
        <td><?= $row['approved'] == 1 ? 'Aprobado' : 'No aprobado' ?></td>
        <td>
            <a href="../php/adjuntarEntregables.php?idProyecto=<?= (int)$row['id'] ?>&idEstudiante=<?= (int)$idEstudiante ?>">Adjuntar entregables</a>
        </td>
    </tr>
    <?php } ?>
</table>
<br></br>
<button> <a href="../php/registrarNuevoProyecto.php">Registrar un nuevo proyecto</a></button>
