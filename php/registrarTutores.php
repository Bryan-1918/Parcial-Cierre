<?php
session_start();
include "conexion.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $passUser = $_POST['passUser'];
    $rol = 'Tutor'; // Rol fijo para tutores

    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($result) == 1) {
        $error = "El correo ya está registrado.";
        echo "<p style='color:red;'>$error</p>";
    } else {
        // Insertar nuevo tutor
        $sql = "INSERT INTO usuarios (name, email, passUser, rol) VALUES ('$name', '$email', '$passUser', '$rol')";
        if (mysqli_query($conexion, $sql)) {
            echo "<p style='color:green;'>Tutor registrado exitosamente.</p>";
        } else {
            $error = "Error al registrar el tutor: " . mysqli_error($conexion);
            echo "<p style='color:red;'>$error</p>";
        }
    }
}
?>

<!-- Formulario HTML simple -->
<h2>Registar Tutor</h2>

<form method="POST" action="">
    Nombre:<br>
    <input type="text" name="name" required><br>
    Correo:<br>
    <input type="email" name="email" required><br>
    Contraseña:<br>
    <input type="password" name="passUser" required><br><br>
    <input type="submit" value="Registrar Tutor">
</form>

