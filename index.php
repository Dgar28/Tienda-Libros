<?php
session_start();

// Verificar si la sesión está iniciada
if(isset($_SESSION['id_cliente'])) {
    // Si el usuario ya inició sesión, redirigir a bienvenido.php
    header("Location: home.php");
    exit; // Asegurarse de que el script se detenga después de redirigir
}

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
// Si el usuario no ha iniciado sesión, muestra el formulario de inicio de sesión normalmente
?>

<html>
<head>
    <title>Iniciar sesion</title>
    <script src="Administrador/js/jquery-3.3.1.min.js"></script>
    <style>
        
        h1 {
            font-size: 40px; /* Tamaño grande */
            margin-bottom: 20px; /* Espacio entre el título y el formulario */
            position: relative; /* Posición relativa para el texto */
            display: inline-block; /* Muestra como bloque en línea */
            text-align: center;
        }
        body {
            background-color:cornflowerblue; /* Color de fondo gris */
            display: flex;
            justify-content: center; /* Centra horizontalmente */
            align-items: center; /* Centra verticalmente */
            height: 100vh; /* Establece el alto de la vista al 100% */
            margin: 0; /* Elimina el margen predeterminado */
        }

        form {
            text-align: center; /* Centra el contenido del formulario */
        }

        .diseño input {
            width: 250px;
            background-color: aquamarine;
            height: 35px;
            margin-bottom: 10px; /* Espacio entre campos */
        }

        .diseño2 input {
            width: 250px;
            background-color: beige;
            height: 35px;
            margin-bottom: 10px; /* Espacio entre campos */
        }

        #mensaje {
            display: none;
            background-color: #f2f2f2;
            color: #333;
            border: 1px solid #ccc;
            padding: 10px;
            margin-top: 10px;
            text-align: center;
            width: 200px;
            margin-left: auto; /* Centra el mensaje de error */
            margin-right: auto; /* Centra el mensaje de error */
        }
        .container {
            background-color: #ddd; /* Color de fondo gris claro */
            padding: 40px;
            border-radius: 10px; /* Borde redondeado */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra */
        }
    </style>
    <script>
function validar(event) {
        event.preventDefault(); // Previene el envío estándar del formulario
        var correo = $("#correo").val();
        var pass = $("#pass").val();
        var pregunta = $("#pregunta").val();
        
        if (correo === "" || pass === "" || pregunta==="") {
            $('#mensaje').show().html('Faltan campos por llenar');
            setTimeout(function() {
                $('#mensaje').html('').hide();
            }, 5000);
        } else {
            $.ajax({
                url: "validar_cliente.php",
                method: "POST",
                data: { correo: correo, pass: pass, pregunta: pregunta},
                success: function(respuesta) {
                    if (respuesta.trim() === "Usuario encontrado") {
                        window.location.href = 'home.php';
                    } else {
                        $("#mensaje").html(respuesta).show();
                        setTimeout(function() {
                            $('#mensaje').html('').hide();
                        }, 5000);
                    }
                },
                error: function() {
                    $("#mensaje").html("Error al procesar la solicitud").show();
                }
            });
        }
    }
    </script>
</head>
<body>
<div class="fondo">    
    <a href="registro_cliente.php">Registrarse</a>
<div class="container">
    <form name="alta" method="post">  
        <h1>Iniciar sesion</h1> 
        <div class="diseño2">
            <input id="correo" type="email" name="correo" placeholder="Correo" >
        </div>
        <div class="diseño">
            <input type="password" name="pass" id="pass" placeholder="Password" /><br>
        </div>  
        <div class="diseño2">
            <input type="text" name="pregunta" id="pregunta" placeholder="Animal favorito" /><br>
        </div>  
        <input id="iniciar" type="button" value="Iniciar" onclick="validator(event);"><br><br>
        <div id="mensaje"></div>  
    </form>
</div>
</div>
</body>