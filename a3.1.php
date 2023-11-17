<!DOCTYPE html>
<html>
<head>
    <title>mitiendaonline</title>
    <style>
    button {
        color: white;
        background-color: rgb(133, 7, 7);
        width:300;
        height:50;
    }
    </style>
</head>
<body>
<h1>mitiendaonline</h1>


<?php

session_start();

require("comprueba_login.php");

echo "<br>Usuario logueado: ".$_SESSION["corrreo_electronico"]."<br>";

if (isset($_POST['crear'])) {
    header("Location: crear_producto.php");
} elseif (isset($_POST['list'])) {
    header("Location: listado_productos.php");
} elseif (isset($_POST['mod'])) {
    header("Location: modificar_producto.php");
} elseif (isset($_POST['elimina'])) {
    header("Location: eliminar_producto.php");
} elseif (isset($_POST['salir'])) {
    header("Location: logout.php");
}
?>


<form method="post">
    <button id="crear" name="crear">Crear un producto</button>
    <br><br><br>
    <button id="list" name="list">Consultar Listado de productos</button>
    <br><br><br>
    <button id="mod" name="mod">Modificar producto</button>
    <br><br><br>
    <button id="elimina" name="elimina">Eliminar producto</button>
    <br><br><br>
    <button id="salir" name="salir">Salir</button>
</form>


</body>
</html>
