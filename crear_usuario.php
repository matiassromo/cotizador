<?php
require_once 'php/conexion.php';
$conexion = conexion();

// Cargar PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Requerir PHPMailer si no usas Composer
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

// Función para generar una contraseña aleatoria
function generarPasswordAleatoria($longitud = 10) {
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $longitudCaracteres = strlen($caracteres);
    $password = '';
    for ($i = 0; $i < $longitud; $i++) {
        $password .= $caracteres[rand(0, $longitudCaracteres - 1)];
    }
    return $password;
}

// Si se recibe el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_usuario = $_POST['nombre_usuario'];
    $email = $_POST['email'];  // Correo ingresado en el formulario
    $password_aleatoria = generarPasswordAleatoria();

    // Cifrar la contraseña aleatoria
    $password_cifrada = password_hash($password_aleatoria, PASSWORD_BCRYPT);

    // Insertar el nuevo usuario en la base de datos
    $sql = "INSERT INTO usuarios (nombre_usuario, email, password) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sss", $nombre_usuario, $email, $password_cifrada);

    if ($stmt->execute()) {
        // Si se creó el usuario, procedemos a enviar el correo con PHPMailer
        $mail = new PHPMailer(true);
        
        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.office365.com';  // Servidor SMTP de Gmail
            $mail->SMTPAuth = true;
            $mail->Username = 'impresora@heka.com.ec';  // Tu correo de Gmail
            $mail->Password = '4kV46P_8]U~pm54';  // Tu contraseña de Gmail o contraseña de aplicación
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Configuración de la codificación a UTF-8
            $mail->CharSet = 'UTF-8';

            // Configuración del correo
            $mail->setFrom('tu_correo@gmail.com', 'Soporte HEKA');
            $mail->addAddress($email);  // Correo del destinatario (el que ingresó en el formulario)

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Contraseña generada cotizador';
            $mail->Body    = 'Hola ' . $nombre_usuario . ',<br><br>Tu cuenta ha sido creada exitosamente. Tu contraseña temporal es: <strong>' . $password_aleatoria . '</strong><br>Por favor, cambia esta contraseña después de iniciar sesión.';

            $mail->send();
            echo 'Usuario creado exitosamente y correo enviado.';
        } catch (Exception $e) {
            echo "Usuario creado, pero hubo un problema enviando el correo: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error al crear el usuario: " . $conexion->error;
    }

    $conexion->close();
}
?>
