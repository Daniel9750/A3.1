<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar producto</title>
</head>
<body>

<?php
require 'validar_producto.php';

try {
    $pdo = new PDO('mysql:host=localhost;dbname=mitiendaonline', 'mitiendaonline', 'mitiendaonline');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Error en la conexión a la base de datos: ' . $e->getMessage();
    die();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $img = basename($_FILES["imagen"]["name"]);
    $categoria = $_POST['categoria'];


    $errores = validarProducto($nombre, $precio);

    if (empty($errores)) {
        $sql = "UPDATE Productos SET Nombre = :nombre, Precio = :precio, Imagen = :imagen, Categoría = :categoria WHERE Id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':imagen', $img);
        $stmt->bindParam(':categoria', $categoria);

        if($_FILES["imagen"]["type"] != "image/jpg" && $_FILES["imagen"]["type"] != "image/jpeg" 
        && $_FILES["imagen"]["type"] != "image/png" && $_FILES["imagen"]["type"] != null) {        
            $errores[] =  "La imagen debe ser un .jpg, .jpeg o un .png";
          } else {
            $target_dir = 'img\\';                                     
        $target_file = $target_dir . basename($_FILES["imagen"]["name"]);     

        $counter = 0;                                                       

        while (file_exists($target_file)) 
        {
            $counter++;                                                     

            $pathinfo = pathinfo($target_file);                             

            $name = $pathinfo["filename"];                                  
            $extension = $pathinfo["extension"];                            
    
            $target_file =  $target_dir                                     
                            . 
                            $name                                          
                            . 
                            "_"                                             
                            . 
                            $counter                                        
                            .
                            "."
                            .
                            $extension;                                     
        }

        move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file); 
          }

        if ($stmt->execute()) {
            echo "Se ha actualizado el producto.";
            echo '<br><a href="a3.1.php">Volver al menú principal</a>';
        } else {
            echo "Error al actualizar el producto.";
        }
    } else {
        echo "Se encontraron los siguientes errores:";
        echo '<ul>';
        foreach ($errores as $error) {
            echo "<li>$error</li>";
        }
        echo '</ul>';
    }
} else {

    if (!isset($_GET['id'])) {
        echo "<h1>Seleccionar Producto</h1>";
        echo '<form method="GET" action="modificar_producto.php">';
        echo '<label for="id">Seleccionar Producto:</label>';
        echo '<select name="id" id="id">';
        
        $query = "SELECT Id, Nombre FROM Productos";
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
        $query = "SELECT Id, Nombre, Precio, Imagen, Categoría FROM Productos WHERE Id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);

        echo "<h1>Modificar Producto</h1>";
        echo '<form method="POST" action="modificar_producto.php" enctype="multipart/form-data">';
        echo '<input type="hidden" name="id" value="' . $producto['Id'] . '">';
        echo '<label for="nombre">Nombre:</label>';
        echo '<input type="text" name="nombre" id="nombre" value="' . $producto['Nombre'] . '" required><br>';
        echo '<label for="precio">Precio:</label>';
        echo '<input type="number" name="precio" id="precio" value="' . $producto['Precio'] . '" step="0.01" required><br>';

        echo '<label for="imagen">Imagen:</label>';
        echo '<input type="file" name="imagen" id="imagen" value="' . $producto['Imagen'] . '"><br>';

        echo '<label for="categoria">Categoría:</label>';
        echo '<select name="categoria" id="categoria">';
        
        $query = "SELECT Id, Nombre FROM Categorías";
        $categorias = $pdo->query($query);
        
        foreach ($categorias as $categoria) {
            $selected = ($producto['Categoría'] == $categoria['Id']) ? 'selected' : '';
            echo "<option value='" . $categoria['Id'] . "' $selected>" . $categoria['Nombre'] . "</option>";
        }
        
        echo '</select><br>';
        echo '<input type="submit" value="Actualizar Producto">';
        echo '</form>';
    }
}
?>

</body>
</html>