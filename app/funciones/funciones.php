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

    function enviarCorreo($destinatario, $asunto, $mensaje){

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer\PHPMailer\PHPMailer();

        try {
            //Server settings
            $mail->SMTPDebug = 0;                                       //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'primerospasosbeltran@gmail.com';       //SMTP username
            $mail->Password   = '';                                     //SMTP password
            $mail->SMTPSecure = 'TLS';                                  //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('primerospasosbeltran@gmail.com', 'Primeros Pasos');
            $mail->addAddress($destinatario);                           //Add a recipient

            //Content
            $mail->isHTML(true);                                        //Set email format to HTML
            $mail->Subject = $asunto;
            $mail->Body    = $mensaje;

            $mail->send();
            return '¡El mensaje se envió correctamente!';
        } catch (Exception $e) {
            return "Error al enviar mensaje: {$mail->ErrorInfo}";
        }
    }

?>