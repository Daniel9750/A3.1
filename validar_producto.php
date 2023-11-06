<?php
function validarProducto($nombre, $precio) {
    $errores = [];


    if (empty($nombre)) {
        $errores[] = "El nombre es obligatorio.";
    }


    if (empty($precio) || !is_numeric($precio)) {
        $errores[] = "El precio debe ser un número válido.";
    }


    return $errores;
}
?>
