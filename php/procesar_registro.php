<?php
require_once 'conexion.php';
$conexion = conexion();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../librerias/PHPMailer-master/src/Exception.php';
require '../librerias/PHPMailer-master/src/PHPMailer.php';
require '../librerias/PHPMailer-master/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $email = $_POST['email'];

    // Verificar que el email tenga el dominio correcto (@heka.com.ec)
    if (!preg_match('/@heka\.com\.ec$/', $email)) {
        echo "Solo se permiten correos corporativos de @heka.com.ec";
        exit();
    }

    // Generar una contraseña temporal aleatoria
    $passwordTemporal = bin2hex(random_bytes(4)); // Genera una contraseña aleatoria de 8 caracteres
    $passwordHash = password_hash($passwordTemporal, PASSWORD_BCRYPT); // Encripta la contraseña temporal

    // Insertar el nuevo usuario en la base de datos
    $sql = "INSERT INTO usuarios (nombre_usuario, apellido_usuario, email, password, id_tipo_usuario, estado) 
            VALUES (?, ?, ?, ?, 3, 'I')"; 
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssss", $nombres, $apellidos, $email, $passwordHash);

    if ($stmt->execute()) {
        // Si el registro fue exitoso, enviar el correo con la contraseña temporal
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.office365.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'impresora@heka.com.ec';
            $mail->Password = '4kV46P_8]U~pm54'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Configuración del correo
            $mail->setFrom('impresora@heka.com.ec', 'Heka Sistema');
            $mail->addAddress($email); 

            // Asegurarse de que el correo use UTF-8
            $mail->CharSet = 'UTF-8';

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Contraseña temporal';
            $mail->Body = "<p>Hola $nombres,</p><p>Tu contraseña temporal es: <strong>$passwordTemporal</strong></p><p>Por favor, inicia sesión y cámbiala lo antes posible.</p>";

            // Enviar el correo
            $mail->send();

            // Responder a la solicitud con un código de éxito
            echo 1;
        } catch (Exception $e) {
            echo "Error al enviar el correo: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error al registrar el usuario: " . $conexion->error;
    }
}

