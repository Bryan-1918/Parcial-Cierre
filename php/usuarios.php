<?php
session_start();
include "conexion.php";

// Validar que el usuario es Coordinador
if ($_SESSION['rol'] != 'Coordinador') {
    echo "Acceso denegado";
    exit();
}

// Crear o editar usuario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? null;
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $rol = $_POST['rol'];
    $password = $_POST['password'];

    if ($id) {
        // Editar usuario, si se provee contraseña se actualiza
        if (!empty($password)) {
            $passHashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE usuarios SET name=?, email=?, rol=?, passUser=? WHERE id=?");
            $stmt->bind_param("ssssi", $nombre, $email, $rol, $passHashed, $id);
        } else {
            $stmt = $conn->prepare("UPDATE usuarios SET name=?, email=?, rol=? WHERE id=?");
            $stmt->bind_param("sssi", $nombre, $email, $rol, $id);
        }
        $stmt->execute();
    } else {
        // Crear nuevo usuario
        $passHashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO usuarios (name, email, passUser, rol) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombre, $email, $passHashed, $rol);
        $stmt->execute();
    }
}

// Eliminación de usuario
if (isset($_GET['delete'])) {
    $del_id = $_GET['delete'];
    $conn->query("DELETE FROM usuarios WHERE id = $del_id");
}

// Obtener lista de tutores y estudiantes
$result = $conn->query("SELECT * FROM usuarios WHERE rol IN ('Tutor', 'Estudiante')");

?>

<h2>Gestión de Usuarios (Coordinador)</h2>

<table border="1">
    <tr><th>Nombre</th><th>Email</th><th>Rol</th><th>Acciones</th></tr>
<?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['rol']) ?></td>
        <td>
            <a href="?edit=<?= $row['id'] ?>">Editar</a> | 
            <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('¿Eliminar usuario?')">Eliminar</a>
        </td>
    </tr>
<?php } ?>
</table>

<?php
// Formulario para crear o editar usuarios
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $row = $conn->query("SELECT * FROM usuarios WHERE id = $edit_id")->fetch_assoc();
} else {
    $row = ['id'=>'', 'name'=>'', 'email'=>'', 'rol'=>'', 'passUser'=>''];
}
?>

<h3><?= isset($_GET['edit']) ? "Editar Usuario" : "Crear Usuario" ?></h3>
<form method="post" action="">
    <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
    Nombre:<br><input type="text" name="nombre" required value="<?= htmlspecialchars($row['name']) ?>"><br>
    Email:<br><input type="email" name="email" required value="<?= htmlspecialchars($row['email']) ?>"><br>
    Contraseña:<br><input type="password" name="password" <?= isset($_GET['edit']) ? '' : 'required' ?>><br>
    Rol:<br>
    <select name="rol" required>
        <option value="">--Seleccione--</option>
        <option value="Tutor" <?= $row['rol']=='Tutor' ? 'selected' : '' ?>>Tutor</option>
        <option value="Estudiante" <?= $row['rol']=='Estudiante' ? 'selected' : '' ?>>Estudiante</option>
    </select><br><br>
    <input type="submit" value="<?= isset($_GET['edit']) ? 'Actualizar' : 'Crear' ?>">
</form>
