<?php

session_start();

echo "<br>Saliendo...";

session_unset();

session_destroy();

?>

<nav class="menu">
    <ul>
        <li><a href="a3.1.php">Inicio</a></li>
    </ul>
</nav>