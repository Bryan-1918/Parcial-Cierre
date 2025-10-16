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
    // Redirige para refrescar la lista
    header("Location: proyectosCoordinador.php");
    exit();
}

$result = $conexion->query("SELECT * FROM proyectos");
$rows = $result->fetch_all(MYSQLI_ASSOC);
?>
<h2>Gestión de Proyectos</h2>

<table border="1">
    <tr>
        <th>Titulo</th>
        <th>Descripcion</th>
        <th>Id Estudiante</th>
        <th>Avances</th>
        <th>Estado</th>
    </tr>
    <?php foreach ($rows as $row) { ?>
    <tr>
        <td><?= $row['titulo'] ?></td>
        <td><?= $row['descrip'] ?></td>
        <td><?= $row['studentId'] ?></td>
        <td><?= $row['avance'] ?></td>
        <td><?= $row['approved'] ?></td>
        <td>
            <a href="?aprobar=<?= $row['id'] ?>" onclick="return confirm('Aprobar proyecto?')">Aprobar</a>
        </td>
    </tr>
    <?php } ?>
</table>