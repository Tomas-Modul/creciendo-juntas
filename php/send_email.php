<?php
// Configuración para evitar errores de CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Verificar que sea una petición POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $mensaje = $_POST['mensaje'];
    
    // Configurar el correo
    $to = "creciendojuntasneuquen@gmail.com";
    $subject = "Nuevo mensaje desde la web de Creciendo Juntas";
    
    // Crear el cuerpo del mensaje en formato HTML
    $message = "
    <html>
    <head>
        <title>Nuevo mensaje desde la web</title>
        <style>
            body { font-family: Arial, sans-serif; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background-color: #8B5FBF; color: white; padding: 20px; text-align: center; }
            .content { padding: 20px; background-color: #f9f9f9; }
            .footer { text-align: center; padding: 10px; font-size: 12px; color: #666; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>Nuevo mensaje desde la web de Creciendo Juntas</h2>
            </div>
            <div class='content'>
                <p><strong>Nombre:</strong> " . htmlspecialchars($nombre) . "</p>
                <p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>
                <p><strong>Mensaje:</strong></p>
                <p>" . nl2br(htmlspecialchars($mensaje)) . "</p>
            </div>
            <div class='footer'>
                <p>Este mensaje fue enviado desde el formulario de contacto de la web de Creciendo Juntas</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    // Configurar los headers para correo HTML
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: Creciendo Juntas Web <noreply@creciendojuntas.com>\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    
    // Intentar enviar el correo
    if (mail($to, $subject, $message, $headers)) {
        $response = array(
            'status' => 'success',
            'message' => '¡Mensaje enviado con éxito!'
        );
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Hubo un error al enviar el mensaje. Por favor, intenta nuevamente.'
        );
    }
    
    // Devolver la respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Si no es POST, devolver error
    header('HTTP/1.1 405 Method Not Allowed');
    echo 'Método no permitido';
}
?> 