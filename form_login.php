<?php

session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo_form = $_POST["correo_electronico"];
    $contrasena_form = $_POST["contrasena"];

    try {
        $dsn = "mysql:host=localhost;dbname=mitiendaonline";
        $usuario = "mitiendaonline";
        $contrasena = "mitiendaonline";

        $conexion = new PDO($dsn, $usuario, $contrasena);

        $consulta = "SELECT contrasena_hash FROM usuarios2 WHERE correo_electronico = '$correo_form'";
        $resultado = $conexion->query($consulta);

        $fila = $resultado->fetch(PDO::FETCH_ASSOC);
        $contrasena_hash_db = $fila['contrasena_hash'];

        if (password_verify($contrasena_form, $contrasena_hash_db)) {
            echo "Inicio de sesión exitoso. Bienvenido, $correo_form";
            echo "<style>body { background-color: $color_fondo_cookie; }</style>"; 

            $_SESSION['correo_electronico'] = $correo_form;

            $consulta_color = "SELECT color_fondo FROM usuarios2 WHERE correo_electronico = '$correo_form'";

            $resultado_color = $conexion->query($consulta_color);

            $fila_color = $resultado_color->fetch(PDO::FETCH_ASSOC);

            $color_fondo_db = $fila_color['color_fondo'];
            
            $color_fondo_cookie = empty($color_fondo_db) ? '#CCCCCC' : $color_fondo_db;
            
            setcookie('color_fondo', $color_fondo_cookie, time() + 86400, '/');

            $color_fondo_cookie = isset($_COOKIE['color_fondo']) ? $_COOKIE['color_fondo'] : '#CCCCCC';

            header("Location: a3.1.php");
            exit();
        } else {
            echo "Contraseña incorecta. Inténtelo de nuevo.";

            
            $limite_intentos = 5;
            $tiempo_bloqueo = 180; 
            
        
            $errores_login = isset($_COOKIE['errores_login']) ? (int)$_COOKIE['errores_login'] : 0;
            $ultimo_bloqueo = isset($_COOKIE['ultimo_bloqueo']) ? (int)$_COOKIE['ultimo_bloqueo'] : 0;
            
            if ($errores_login >= $limite_intentos && time() - $ultimo_bloqueo < $tiempo_bloqueo) {
                echo "Has alcanzado el límite de intentos. Debes esperar 3 minutos antes de intentar de nuevo.";
            } else {
           
                if (password_verify($contrasena_form, $contrasena_hash_db)) {
                  
                    setcookie('errores_login', 0, time() - 3600, '/');
            
               
                } else {
            
                    $errores_login++;
            
                    setcookie('errores_login', $errores_login, time() + (365 * 24 * 60 * 60), '/');
                    setcookie('ultimo_bloqueo', time(), time() + (365 * 24 * 60 * 60), '/');
            
                }
            }

        }


    } catch (PDOException $e) {
        echo "Error al conectar con la base de datos: " . $e->getMessage();
    } finally {
        $conexion = null;
    }
}
?>