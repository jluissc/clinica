<?php


session_start();
var_dump($_SESSION);




if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        setcookie($name, '', time()-1000);
        setcookie($name, '', time()-1000, '/');
    }
    echo "<script>
    function actualizar(){
        location.reload(true);
    }
    //Función para actualizar cada 4 segundos(4000 milisegundos)
      setInterval('actualizar()',100);
    </script>";
    
}

header("Location:/Pepestore");

