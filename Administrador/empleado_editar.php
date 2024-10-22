<?php
session_start();

    require "funciones/conecta.php";
    $con = conecta();
    if (isset($_SESSION['id_empleado'])) {
        $id_empleado = $_SESSION['id_empleado'];
        $query = "SELECT * FROM empleados WHERE id = $id_empleado";
        $sql = $con->query($query);

        if (mysqli_num_rows($sql) > 0) {
            $row_empleado = mysqli_fetch_assoc($sql); // Datos del usuario logueado
        }
        } else {
        header('Location: index.php'); // Redirige al usuario si no está autenticado
        exit();
    }
    $id = $_REQUEST['id'];

    $query = "SELECT * FROM empleados
              WHERE id = $id";

    $sql = $con->query($query);

    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_assoc($sql);
    }
?>
<html>
<head>
    <title>Edición de empleados</title>
    <script src="js/jquery-3.3.1.min.js"></script>
    <style>
        body{
        background-color: #AFEEEE;
        font-family: Arial, sans-serif;
    }
        .encabezado {
            width: 100%;
            height: 50px;
            background-color: #87CEEB;
            display: flex;
            align-items: center; /* Centra verticalmente */
            justify-content: space-between; /* Espacio entre elementos */
             /* Añade un poco de espacio alrededor del contenido */
        }
        .linea_encabezado {
            width: 100%;
            height: 10px;
            background-color:#4682B4;

        }
        .centrar {
             margin: 0 auto; 
             width: 960px; 
            }
        .diseño input, .diseño2 input { 
            width: 500px; 
            background-color: aquamarine; 
            height: 35px; 
        }
        .diseño2 input { 
            background-color: beige; 
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
        }
        h1 {
        background-color: #4682B4; /* Color de fondo */
        color: #FFFFFF; /* Color del texto */
        text-align: center; /* Centra el texto */
        padding: 10px 0; /* Espacio por encima y por debajo del texto */
        border-radius: 8px; /* Bordes redondeados */
        box-shadow: 0 4px 8px rgba(0,0,0,0.1); /* Sombra sutil */
        margin-top: 20px; /* Margen superior */
        font-size: 24px; /* Tamaño de la fuente más grande */
        }
    </style>
    <script>
        
    function validar() {
    var correo = $("#correo").val();
    var nombre = $("#nombre").val();
    var apellidos = $("#apellidos").val();
    var rol = $("#rol").val();
    var pass = $("#pass").val();
    var archivo = $("#archivo").val();


    if (nombre === "" || apellidos === "" || correo === "" || rol === "0" || pass === "" ) {
        $('#mensaje').show().html('Faltan campos por llenar');
            setTimeout(function() {
                $('#mensaje').html('').hide();
            }, 5000);
    }
    else{
        document.alta.method = 'post';
        document.alta.action = 'actualizar_datos.php';
        document.alta.submit();
    }
}
        function validarCorreo(correo, id) {
            if (!correo) {
                $("#mensaje").html("El campo de correo no puede estar vacío").show();
                return;
            }

            $.ajax({
                url: "validar_correo_editar.php",
                method: "POST",
                data: { correo: correo, id:<?php echo $id; ?>},
                success: function(respuesta) {
                    if (respuesta !== "disponible") {
                        $("#guardar").prop("disabled", true);
                        $("#mensaje").html(respuesta).show();
                    } else {
                        $("#guardar").prop("disabled", false);
                        $("#mensaje").html("Correo disponible").show();
                        setTimeout(function() {
                            $('#mensaje').html('').hide();
                        }, 5000);
                    }
                },
                error: function() {
                    $("#mensaje").html("Error al validar el correo").show();
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
        <h1> BIENVENID@ <?php echo $row_empleado['nombre']; ?> </h1>
        <a href="bienvenido.php" style="color:black;">Inicio</a>
        <a href="empleados_lista.php" style="color:black;">Empleados</a> 
        <a href="productos_lista.php" style="color:black;">Productos</a> 
        <a href="promociones_lista.php" style="color:black;">Promociones</a> 
        <a href="pedidos.php" style="color:black;">Pedidos</a> 
        <a href="cerrar_sesion.php" style="color:black;">Cerrar sesion</a>
    </div>
    <div class="linea_encabezado"></div>
    <h1>Edición del empleado</h1>
    <a href="empleados_lista.php"><button>Volver</button></a>
    <br>
    <form name="alta" enctype="multipart/form-data" method="post">
        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
        <div class="diseño2">
            <input id="nombre" type="text" name="nombre" placeholder="Nombre" value="<?php echo $row['nombre']; ?>" required>
        </div>
        <div class="diseño">
            <input id="apellidos" type="text" name="apellidos" placeholder="Apellidos" value="<?php echo $row['apellidos']; ?>" required>
        </div>    
        <div class="diseño2">
            <input id="correo" type="email" name="correo" placeholder="Correo" onblur="validarCorreo(this.value)" value="<?php echo $row['correo']; ?>" required>
        </div>
        <div class="diseño">
            <input id="pass" type="password" name="pass" placeholder="Password" value="<?php echo $row['pass']; ?>" required><br>
        </div>     
        <div class="diseño2">
            <label>Rol</label>
            <select name="rol" id="rol">
                <option value="0" <?php echo $row['rol'] == 0 ? 'selected' : ''; ?>>Selecciona</option>
                <option value="1" <?php echo $row['rol'] == 1 ? 'selected' : ''; ?>>Gerente</option>
                <option value="2" <?php echo $row['rol'] == 2 ? 'selected' : ''; ?>>Ejecutivo</option>
            </select>
        </div>
        <div class="diseño2">
    <?php if (!empty($row['archivo'])): ?>
        <div>
            <label>Imagen Actual</label>
            <img src="archivos/<?php echo htmlspecialchars($row['archivo']); ?>" style="width: 150px; height: 140px;">
        </div>
    <?php endif; ?>
    <label for="archivo">Cambiar foto</label>
    <input type="file" id="archivo" name="archivo"><br><br>
</div>

        <input id="guardar" name="guardar" type="submit" value="Guardar"onclick="validar(); return false;"><br><br>
        <div id="mensaje"></div>
    </form>  
</body>
</html>
