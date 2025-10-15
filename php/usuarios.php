<?php
session_start();
include "php/conexion.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        // Comparación directa sin encriptación
        if ($password == $user['passUser']) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['rol'] = $user['rol'];
            $_SESSION['nombre'] = $user['name'];

            if ($user['rol'] == 'Coordinador') {
                header("Location: php/usuarios.php");
            } elseif ($user['rol'] == 'Tutor') {
                header("Location: tutor_panel.php");
            } else {
                header("Location: estudiante_panel.php");
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
