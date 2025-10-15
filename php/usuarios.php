<?php
session_start();
include "conexion.php";

// Validar rol coordinador
if ($_SESSION['rol'] != 'Coordinador') {
    echo "Acceso denegado";
    exit();
}

$result = $conexion->query("SELECT * FROM usuarios WHERE rol IN ('Tutor', 'Estudiante')");
?>
<h2>Gestión de Usuarios (Coordinador)</h2>

<table border="1">
    <tr>
        <th>Nombre</th>
        <th>Email</th>
        <th>Rol</th>
        <th>Acciones</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['rol']) ?></td>
        <td>
            <a href="?edit=<?= $row['id'] ?>">Editar</a> |
            <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Eliminar usuario?')">Eliminar</a>
        </td>
    </tr>
    <?php } ?>
</table>
