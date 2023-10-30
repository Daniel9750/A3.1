<!DOCTYPE html>
<html>
<head>
    <title>mitiendaonline</title>
</head>
<body>
<h1>mitiendaonline</h1>


<?php
/* De momento, estarán todas comentadas porque no se han creado los archivos correspondientes.
if (isset($_POST['crear'])) {
    header("Location: crear_producto.php");
} elseif (isset($_POST['list'])) {
    header("Location: listado_productos.php");
} elseif (isset($_POST['mod'])) {
    header("Location: modifica_producto.php");
} elseif (isset($_POST['elimina'])) {
    header("Location: elimina_producto.php");
}
*/
?>


<form method="post">
    <button id="crear" style="color: white; background-color: rgb(133, 7, 7); width:300; height:50" name="crear">Crear un producto</button>
    <br><br><br>
    <button id="list" style="color: white; background-color: rgb(133, 7, 7); width:300; height:50" name="list">Consultar Listado de Productos</button>
    <br><br><br>
    <button id="mod" style="color: white; background-color: rgb(133, 7, 7); width:300; height:50" name="mod">Modificar Producto</button>
    <br><br><br>
    <button id="elimina" style="color: white; background-color: rgb(133, 7, 7); width:300; height:50" name="elimina">Eliminar Producto</button>
</form>


</body>
</html>
