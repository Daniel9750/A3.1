<!DOCTYPE html>
<html>
<head>
    <title>Crear Producto</title>
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


    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $img = basename($_FILES["imagen"]["name"]);
    $categoria = $_POST['categoria'];


    $errores = validarProducto($nombre, $precio);

    

    if (empty($errores)) {


        $sql = "INSERT INTO Productos (Nombre, Precio, Imagen, Categoría) VALUES (:nombre, :precio, :imagen, :categoria)";
        $stmt = $pdo->prepare($sql);
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
            
            echo "Se ha añadido el producto.";
            echo '<br><a href="a3.1.php">Volver al menú principal</a>';
        } else {
            echo "Error al insertar el producto.";
        }
    } else {


        echo "Se encontraron los siguientes errores:";
        echo '<ul>';
        foreach ($errores as $error) {
            echo "<li>$error</li>";
        }
        echo '</ul>';
    } 
}
?>


<h1>Crear Producto</h1>
<form method="POST" action="crear_producto.php" enctype="multipart/form-data">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre" required><br>


    <label for="precio">Precio:</label>
    <input type="number" name="precio" id="precio" step="0.01" required><br>


    <label for="imagen">Imagen del Producto:</label>
    <input type="file" name="imagen" id="imagen">
    <br><br>


    <label for="categoria">Categoría:</label>
    <select name="categoria" id="categoria">
        <?php
        $query = "SELECT Id, Nombre FROM Categorías";
        $categorias = $pdo->query($query);
        foreach ($categorias as $categoria) {
            echo "<option value='" . $categoria['Id'] . "'>" . $categoria['Nombre'] . "</option>";
        }
        ?>
    </select><br>


    <input type="submit" value="Crear Producto">
</form>


</body>
</html>
