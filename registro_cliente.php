<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de clientes</title>
    <script src="Administrador/js/jquery-3.3.1.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #E0F7FA;
            margin: 0;
            padding: 0;
        }

        .encabezado {
            width: 100%;
            height: 60px;
            background-color: #00838F;
            color: #FFFFFF;
            display: flex;
            align-items: center; 
            justify-content: center; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .linea_encabezado {
            width: 100%;
            height: 5px;
            background-color: #006064;
        }

        .container {
            max-width: 500px;
            margin: 30px auto;
            background-color: #FFFFFF;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .container h1 {
            background-color: #00838F;
            color: #FFFFFF;
            text-align: center;
            padding: 15px 0;
            border-radius: 8px;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #CCCCCC;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }

        .form-group input:focus {
            border-color: #00838F;
            outline: none;
        }

        .btn {
            width: 100%;
            padding: 10px;
            background-color: #00838F;
            color: #FFFFFF;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #006064;
        }

        #mensaje {
            display: none;
            background-color: #f2f2f2;
            color: #333; 
            border: 1px solid #ccc; 
            padding: 10px;
            margin-top: 10px;
            text-align: center; 
            border-radius: 4px;
        }

        .volver {
            text-align: center;
            margin-top: 20px;
        }

        .volver a {
            color: #00838F;
            text-decoration: none;
            font-size: 16px;
        }

        .volver a:hover {
            text-decoration: underline;
        }
    </style>
    <script>
        function validar() {
            var correo = document.alta.correo.value;
            var nombre = document.alta.nombre.value;
            var apellidos = document.alta.apellidos.value;
            var pass = document.alta.pass.value;
            var pregunta = document.alta.pregunta.value;

            if (nombre === "" || apellidos === "" || correo === "" || pass === "" || pregunta === "") {
                $('#mensaje').show().html('Faltan campos por llenar');
                setTimeout(function() {
                    $('#mensaje').html('').hide();
                }, 5000);
            } else {
                document.alta.method = 'post';
                document.alta.action = 'clientes_alta.php';
                document.alta.submit();
            }
        }

        function validarCorreo(correo) {
            $.ajax({
                url: "validar_correo.php",
                method: "POST",
                data: { correo: correo },
                success: function(respuesta) {
                    if (respuesta !== "disponible") {
                        $("#guardar").prop("disabled", true);
                        $("#mensaje").html("<p style='color: black; font-size: 22px;'>" + respuesta + "</p>").show();
                        setTimeout(function() {
                            $("#mensaje").html("").hide();
                        }, 5000);
                    } else {
                        $("#guardar").prop("disabled", false);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert("Error: " + textStatus + " - " + errorThrown);
                }
            });
        }

        $(document).ready(function() {
            $("#correo").on("blur", function() {
                validarCorreo($(this).val());
            });
        });
    </script>
</head>
<body>
    <div class="encabezado">
        <h1>Registro de clientes</h1>
    </div>
    <div class="linea_encabezado"></div>
    <div class="container">
        <h1>Registro</h1>
        <form name="alta" action="clientes_alta.php" method="post">
            <div class="form-group">
                <input id="nombre" type="text" name="nombre" placeholder="Nombre" required>
            </div>
            <div class="form-group">
                <input id="apellidos" type="text" name="apellidos" placeholder="Apellidos" required>
            </div>
            <div class="form-group">
                <input id="correo" type="email" name="correo" placeholder="Correo" required>
            </div>
            <div class="form-group">
                <input type="password" name="pass" id="pass" placeholder="Password" required>
            </div>
            <div class="form-group">
                <input type="text" name="pregunta" id="pregunta" placeholder="¿Cual es tu animal favorito?" required>
            </div>
            <div class="form-group">
                <input id="guardar" name="guardar" type="submit" value="Guardar" class="btn" onclick="validar(); return false;">
            </div>
            <div id="mensaje"></div>
        </form>
        <div class="volver">
            <a href="index.php">Volver</a>
        </div>
    </div>
</body>
</html>