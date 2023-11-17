<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar producto</title>
    <style>
        img {
            width: 60px;
            height: 60px;
        }
    </style>
</head>
<body>

<?php
require 'config.php';

session_start();

require("comprueba_login.php");

echo "<br>Usuario logueado: ".$_SESSION["corrreo_electronico"]."<br>";


try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Error en la conexión a la base de datos: ' . $e->getMessage();
    die();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['confirmar'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM Productos WHERE Id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            echo "Se ha eliminado el producto.";
            echo '<br><a href="a3.1.php">Volver al menú principal</a>';
        } else {
            echo "No se ha podido eliminar el producto.";
        }
    } else {
        echo "No se ha eliminado el producto.";
        echo '<br><a href="a3.1.php">Volver al menú principal</a>';
    }
} else {
    if (!isset($_GET['id'])) {
        echo "<h1>Elige un producto</h1>";
        echo '<form method="GET" action="eliminar_producto.php">';
        echo '<label for="id">Seleccionar Producto:</label>';
        echo '<select name="id" id="id">';
       
        $query = "SELECT Id, Nombre, Imagen FROM Productos";
        $productos = $pdo->query($query);
       
        foreach ($productos as $producto) {
            echo "<option value='" . $producto['Id'] . "'>" . $producto['Nombre'] . "</option>";
        }
       
        echo '</select>';
        echo '<br>';
        echo '<input type="submit" value="Seleccionar">';
        echo '</form>';
    } else {
        $id = $_GET['id'];
        $query = "SELECT Id, Nombre, Precio, Categoría, Imagen FROM Productos WHERE Id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);

        echo "<h1>Eliminar Producto</h1>";
        echo '<form method="POST" action="eliminar_producto.php">';
        echo '<input type="hidden" name="id" value="' . $producto['Id'] . '">';
        echo '<p>¿Quieres eliminar el siguiente producto?</p>';
        echo '<p>Nombre: ' . $producto['Nombre'] . '</p>';
        echo '<p>Precio: ' . $producto['Precio'] . '</p>';
        echo '<p>Categoría: ' . $producto['Categoría'] . '</p>';
        echo '<p>Imagen: </p><img src="img/' . $producto['Imagen'] . '"><br>';
        echo '<input type="submit" name="confirmar" value="Eliminar Producto">';
        echo '<a href="eliminar_producto.php">Cancelar</a>';
        echo '</form>';
    }
}
?>

</body>
</html>