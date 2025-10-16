<?php
session_start();
include "../php/conexion.php";

// Validar rol coordinador
if ($_SESSION['rol'] != 'Coordinador') {
    echo "Acceso denegado";
    exit();
}

// aprobar proyecto 
if (isset($_GET['aprobar'])) {
    $id = $_GET['aprobar'];
    $conexion->query("UPDATE proyectos SET approved = 1 WHERE id=$id");
    // regresar y refrescar la lista
    header("Location: proyectosCoordinador.php");
    exit();
}

$result = $conexion->query("SELECT 
    proyectos.id, 
    proyectos.titulo, 
    proyectos.studentId,
    proyectos.descrip, 
    proyectos.approved, 
    GROUP_CONCAT(DISTINCT comentarios.comentario SEPARATOR ' <br></br> ') AS comentarios,
    GROUP_CONCAT(DISTINCT avances.avance SEPARATOR ' <br></br> ') AS avances,
    GROUP_CONCAT(DISTINCT entregables.entregable SEPARATOR ' <br></br> ') AS entregables
    FROM proyectos
    LEFT JOIN comentarios ON proyectos.id = comentarios.project
    LEFT JOIN avances ON proyectos.id = avances.project
    LEFT JOIN entregables ON proyectos.id = entregables.project
    GROUP BY proyectos.id, proyectos.titulo, proyectos.descrip, proyectos.approved, proyectos.studentId
");
$rows = $result->fetch_all(MYSQLI_ASSOC);
?>
<h2>Gestión de Proyectos</h2>

<table border="1">
    <tr>
        <th>Titulo</th>
        <th>Descripcion</th>
        <th>Entregables</th>
        <th>Id Estudiante</th>
        <th>Avances</th>
        <th>Comentarios</th>
        <th>Estado</th>
    </tr>
    <?php foreach ($rows as $row) { ?>
    <tr>
        <td><?= $row['titulo'] ?></td>
        <td><?= $row['descrip'] ?></td>
        <td><?= $row['entregables'] ?></td>
        <td><?= $row['studentId'] ?></td>
        <td><?= $row['avances'] ?> </td>
        <td><?= $row['comentarios'] ?></td>
        <td><?= $row['approved'] == 1 ? 'Aprobado' : 'No aprobado' ?></td>
        <td>
            <a href="?aprobar=<?= $row['id'] ?>" onclick="return confirm('Aprobar proyecto?')">Aprobar</a>
        </td>
    </tr>
    <?php } ?>
</table>