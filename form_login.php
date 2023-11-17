<?php

session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo_form = $_POST["correo_electronico"];
    $contrasena_form = $_POST["contrasena"];

    try {
        $dsn = "mysql:host=localhost;dbname=mitiendaonline";
        $usuario = "mitiendaonline";
        $contrasena = "mitiendaonline";

        $conexion = new PDO($dsn, $usuario, $contrasena);

        $consulta = "SELECT contrasena_hash FROM usuarios WHERE correo_electronico = '$correo_form'";
        $resultado = $conexion->query($consulta);

        $fila = $resultado->fetch(PDO::FETCH_ASSOC);
        $contrasena_hash_db = $fila['contrasena_hash'];

        if (password_verify($contrasena_form, $contrasena_hash_db)) {
            echo "Inicio de sesión exitoso. Bienvenido, $correo_form";

            $_SESSION['correo_electronico'] = $correo_form;

            header("Location: a3.1.php");
            exit();
        } else {
            echo "Contraseña incorecta. Por favor, inténtelo de nuevo";
        }
    } catch (PDOException $e) {
        echo "Error al conectar con la base de datos: " . $e->getMessage();
    } finally {
        $conexion = null;
    }
}
?>