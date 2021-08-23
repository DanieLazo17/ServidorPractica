<?php

    function mostrarValor($parametro="Prueba"){
        echo "<br>";
        echo $parametro;
        return 1;
    }

    function generarContrasenaAleatoria(){
        $caracteresAlfanumericos = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $contrasenaAleatoria = null;
        
        for($i=0; $i<8; $i++) {
            $contrasenaAleatoria .= substr($caracteresAlfanumericos, rand(0,61), 1);
        }

        return $contrasenaAleatoria;
    }

?>