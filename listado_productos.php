<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de productos</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .action-icons img {
            width: 20px;
            height: 20px;
            cursor: pointer;
            margin-right: 5px;
        }
        img {
            width: 60px;
            height: 60px;
        }
    </style>
</head>
<body>

<?php

require 'config.php';



try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT id, Nombre, Precio, Imagen, Categoría FROM Productos");
    $stmt->execute();

    echo "<table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Imagen</th>
                <th>Categoría</th>
                <th>Editar</th>
            </tr>";
        

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['Nombre']}</td>
                <td>{$row['Precio']}</td>
                <td><img src='img/{$row['Imagen']}'></td>
                <td>{$row['Categoría']}</td>
                <td class='action-icons'>

                    <a href='eliminar_producto.php?id={$row['id']}'>
                    <img src='icon/eliminar.png' alt='Eliminar'>
                    </a>
                    
                    <a href='modificar_producto.php?id={$row['id']}'>
                    <img src='icon/editar.png' alt='Modificar'>
                    </a>
                </td>
              </tr>";
    }

    echo "</table>";
} 
   

 catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$pdo = null;
?>

</body>
</html>