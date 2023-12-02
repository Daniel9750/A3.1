<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
</head>

<body>
    <h2>Iniciar sesión</h2>

    <?php

    ?>



    <form action="form_login.php" method="post">
        <label for="correo_electronico">Correo electrónico: </label>
        <input type="email" id="correo_electronico" name="correo_electronico" required>

        <br>

        <label for="contrasena">Contraseña: </label>
        <input type="password" id="contrasena" name="contrasena" required>

        <br>

        <input type="submit" style="color: white;
        background-color: rgb(133, 7, 7);
        width:300; height:50;" value="Iniciar Sesión">
    </form>
</body>

</html>