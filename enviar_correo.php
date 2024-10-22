<?php
// Comprueba si el servidor ha recibido datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    // Asigna las variables con los datos recibidos del formulario
    $nombre = $_POST['nombre']; 
    $correo = $_POST['correo'];
    $descripcion = $_POST['descripcion'];

    // Aquí puedes limpiar los datos de entrada por seguridad
    $nombre = strip_tags(trim($nombre));
    $correo = filter_var(trim($correo), FILTER_SANITIZE_EMAIL);
    $descripcion = htmlspecialchars(trim($descripcion));

    // Especifica a dónde quieres enviar el correo
    $destinatario = "alexiscampos1406@gmail.com";
    $asunto = "Nuevo mensaje de contacto";

    // Arma el cuerpo del mensaje
    $contenido = "Has recibido un nuevo mensaje de contacto.\n\n";
    $contenido .= "Nombre: $nombre\n";
    $contenido .= "Correo: $correo\n";
    $contenido .= "Descripción: $descripcion\n";

    // Establece las cabeceras para enviar el correo
    $cabeceras = "From: $nombre <$correo>\r\n";
    $cabeceras .= "Reply-To: $correo\r\n";
    $cabeceras .= "X-Mailer: PHP/".phpversion();

    // Envía el correo
    if (!mail($destinatario, $asunto, $contenido, $cabeceras)) { 
        error_log("Mail failed to send to $destinatario", 0);
        echo "<script>alert('Error al enviar el mensaje.'); window.location.href='contacto.php';</script>";
    } else {
        echo "<script>alert('Mensaje enviado exitosamente.'); window.location.href='home.php';</script>";
    }
} else {
    // No se accedió al archivo desde un método POST
    echo "No se ha enviado el formulario.";
}
?>

