<?php
include "conexion.php";

$id = $_GET['id'];
// Obtener datos actuales
$sql = $conexion->query("SELECT * FROM usuarios WHERE id=$id");
$user = $sql->fetch_assoc(); // convertir en diccionario

// envio del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rol = $_POST['rol'];

    $conexion->query("UPDATE usuarios SET name='$nombre', email='$email', passUser='$password', rol='$rol' WHERE id=$id");
    header("Location: ../panelesUsuarios/panelCoordinador.php");
    exit();
}
?>

<h2>Editar Usuario</h2>
<form method="post">
    Nombre:<br>
    <input type="text" name="nombre" value="<?php echo $user['name']; ?>" required><br>
    Email:<br>
    <input type="email" name="email" value="<?php echo $user['email']; ?>" required><br>
    Contraseña:<br>
    <input type="text" name="password" value="<?php echo $user['passUser']; ?>" required><br>
    Rol:<br>
    <select name="rol" required>
        <option value="Tutor" <?php if($user['rol']=="Tutor") echo "selected"; ?>>Tutor</option>
        <option value="Estudiante" <?php if($user['rol']=="Estudiante") echo "selected"; ?>>Estudiante</option>
    </select><br><br>
    <input type="submit" value="Actualizar">
</form>
