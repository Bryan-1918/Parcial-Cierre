<?php
session_start();
include "../php/conexion.php";

// Validar rol coordinador
if ($_SESSION['rol'] != 'Coordinador') {
    echo "Acceso denegado";
    exit();
}

// Eliminar usuario
if (isset($_GET['delete'])) {
    $idToDelete = $_GET['delete'];
    $conexion->query("DELETE FROM usuarios WHERE id=$idToDelete");
    header("Location: panelCoordinador.php");
    exit();
}

$result = $conexion->query("SELECT * FROM usuarios WHERE rol IN ('Tutor', 'Estudiante')");
$rows = $result->fetch_all(MYSQLI_ASSOC);
?>
<h2>Gestión de Usuarios (Coordinador)</h2>

<!--Gestionar usuarios-->
<button> <a href="../php/registrarTutores.php">Registrar un nuevo tutor</a></button>
<button> <a href="../php/registrarEstudiantes.php">Registrar un nuevo estudiante</a></button>

<!--Gestionar proyectos-->
<button> <a href="../php/proyectosCoordinador.php">Gestionar proyectos</a></button>


<br></br>

<table border="1">
    <tr>
        <th>Nombre</th>
        <th>Email</th>
        <th>Rol</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($rows as $row) { ?>
    <tr>
        <td><?= $row['name'] ?></td>
        <td><?= $row['email'] ?></td>
        <td><?= $row['rol'] ?></td>
        <td>
            <a href="../php/editarUsuarios.php?id=<?= $row['id'] ?>">Editar</a> 
            <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Eliminar usuario?')">Eliminar</a>
        </td>
    </tr>
    <?php } ?>
</table>
