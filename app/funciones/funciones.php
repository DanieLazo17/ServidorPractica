<?php

    function mostrarValor($parametro="Prueba"){
        echo "<br>";
        echo $parametro;
        return 1;
    }

    function generarContrasenaAleatoria(){
        $caracteresAlfanumericos = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $caracteresNumericos = "1234567890";
        $contrasenaAleatoria = null;

        for($i=0; $i<2; $i++) {
            $contrasenaAleatoria .= substr($caracteresAlfanumericos, rand(0,61), 1);
        }
        for($i=0; $i<2; $i++) {
            $contrasenaAleatoria .= substr($caracteresNumericos, rand(0,9), 1);
        }
        for($i=0; $i<3; $i++) {
            $contrasenaAleatoria .= substr($caracteresAlfanumericos, rand(0,61), 1);
        }
        for($i=0; $i<1; $i++) {
            $contrasenaAleatoria .= substr($caracteresNumericos, rand(0,9), 1);
        }
        return $contrasenaAleatoria;
    }

    function leerArchivoCorreo(){   
        $archivo = fopen('correo.php',"r");
        $info = fread($archivo,filesize('correo.php'));
        fclose($archivo);

        return $info;
    }

    function enviarCorreo($destinatario, $asunto, $mensaje){

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        require 'correo.php';

        try {
            //Server settings
            $mail->SMTPDebug = 0;                                       //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $correo;                                //SMTP username
            $mail->Password   = $contrasena;                            //SMTP password
            $mail->SMTPSecure = 'TLS';                                  //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom($correo, $nombre);
            $mail->addAddress($destinatario);                           //Add a recipient

            //Content
            $mail->isHTML(true);                                        //Set email format to HTML
            $mail->Subject = $asunto;
            $mail->Body    = $mensaje;

            $mail->send();
            return '¡El mensaje se envió correctamente, revise su correo!';
        } catch (Exception $e) {
            return "Error al enviar mensaje: {$mail->ErrorInfo}";
        }
    }

?>