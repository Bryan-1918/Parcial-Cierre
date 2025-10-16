<?php
session_start();
include "php/conexion.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Buscar usuario por correo (método directo)
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result); // convertir el resultado en un diccionario

        // Verificar contraseña encriptada
        if (password_verify($password, $user['passUser']) || $password == $user['passUser']) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['rol'] = $user['rol'];
            $_SESSION['nombre'] = $user['name'];

            // Redirigir según el rol
            if ($user['rol'] == 'Coordinador') {
                header("Location: panelesUsuarios/panelCoordinador.php");
            } elseif ($user['rol'] == 'Tutor') {
                header("Location: panelesUsuarios/panelTutor.php");
            } elseif ($user['rol'] == 'Estudiante') {
                header("Location: panelesUsuarios/panelEstudiante.php?idEstudiante=" . (int)$user['id']);
            } else {
                $error = "Rol no reconocido.";
            }
            exit();
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }
}
?>

<!-- Formulario HTML simple -->
<h2>Inicio de Sesión</h2>
<form method="post" action="">
    Correo:<br>
    <input type="email" name="email" required><br>
    Contraseña:<br>
    <input type="password" name="password" required><br><br>
    <input type="submit" value="Ingresar">
</form>

<?php
if (!empty($error)) {
    echo "<p style='color:red;'>$error</p>";
}
?>
