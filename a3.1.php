<!DOCTYPE html>
<html>
<head>
    <title>mitiendaonline</title>
</head>
<body>
<h1>mitiendaonline</h1>


<?php

if (isset($_POST['crear'])) {
    header("Location: crear_producto.php");
} elseif (isset($_POST['list'])) {
    header("Location: listado_productos.php");
} elseif (isset($_POST['mod'])) {
    header("Location: modificar_producto.php");
} 
/* De momento, estará comentado porque no se han creado el archivo correspondiente.
elseif (isset($_POST['elimina'])) {
    header("Location: eliminar_producto.php");
}
*/
?>


<form method="post">
    <button id="crear" style="color: white; background-color: rgb(133, 7, 7); width:300; height:50" name="crear">Crear un producto</button>
    <br><br><br>
    <button id="list" style="color: white; background-color: rgb(133, 7, 7); width:300; height:50" name="list">Consultar Listado de productos</button>
    <br><br><br>
    <button id="mod" style="color: white; background-color: rgb(133, 7, 7); width:300; height:50" name="mod">Modificar producto</button>
    <br><br><br>
    <button id="elimina" style="color: white; background-color: rgb(133, 7, 7); width:300; height:50" name="elimina">Eliminar producto</button>
</form>


</body>
</html>
