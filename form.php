<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
</head>
<body>
    <h2>Iniciar Sesión</h2>

    <?php

    ?>

    <form action="form_login.php" method="post">
        <label for="correo_electronico">Correo Electrónico: </label>
        <input type="email" id="correo_electronico" name="correo_electronico" required>

        <br>

        <label for="contrasena">Contraseña: </label>
        <input type="password" id="contrasena" name="contrasena" required>

        <br>

        <input type="submit" value="Iniciar Sesión">
    </form>
</body>
</html>