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
?>
<html>
<head>
    <title>Registro de empleados</title>
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
            margin: 0 auto; /* Margen automático en los lados izquierdo y derecho */
            width: 960px; /* Ancho deseado de la tabla */
        }
        .diseño input{
            width: 500px;
            background-color: aquamarine;
            height: 35px;
        }
        .diseño2 input{
            width: 500px;
            background-color: beige;
            height: 35px;
        }
        #mensaje, #mensajeValidacion {
            display: none;
            background-color: #f2f2f2;
            color: #333; 
            border: 1px solid #ccc; 
            padding: 10px; /* Espacio interior para hacerlo más grande */
            margin-top: 10px; /* Espacio superior */
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
            var correo = document.alta.correo.value;
            var nombre = document.alta.nombre.value;
            var apellidos = document.alta.apellidos.value;
            var rol = document.alta.rol.options[document.alta.rol.selectedIndex].text;
            var pass = document.alta.pass.value;
            var archivo = document.alta.archivo.value;

            if (nombre === "" || apellidos === "" || correo === "" || rol === "Selecciona" || pass === "" || archivo === "") {
                $('#mensaje').show().html('Faltan campos por llenar');
                    setTimeout(function() {
                    $('#mensaje').html('').hide();
                    }, 5000);
            } else {
                        document.alta.method = 'post';
                        document.alta.action = 'empleados_alta.php';
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
                    $("#mensajeValidacion").html("<p style='color: black; font-size: 22px;'>" + respuesta + "</p>").show();
                
                    setTimeout(function() {
                        $("#mensajeValidacion").html("").hide();
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
        <h1> BIENVENID@ <?php echo $row_empleado['nombre']; ?> </h1>
        <a href="bienvenido.php" style="color:black;">Inicio</a>
        <a href="empleados_lista.php" style="color:black;">Empleados</a> 
        <a href="productos_lista.php" style="color:black;">Productos</a> 
        <a href="promociones_lista.php" style="color:black;">Promociones</a> 
        <a href="pedidos.php" style="color:black;">Pedidos</a> 
        <a href="cerrar_sesion.php" style="color:black;">Cerrar sesion</a>
    </div>
    <div class="linea_encabezado"></div>
    <h1>Registro de empleado</h1>
    <a href="empleados_lista.php"><button>Volver</button></a>
    <br>
    <form name="alta" enctype="multipart/form-data" action="empleados_alta.php" method="post">
			<div class="diseño2">
                <input id="nombre" type="text" name="nombre" placeholder="Nombre" required>
            </div>
            <div class="diseño">
                <input id="apellidos" type="text" name="apellidos" placeholder="Apellidos" required>
            </div>    
		    <div class="diseño2">
                <input id="correo" type="email" name="correo" placeholder="Correo" onblur="validarCorreo(this.value)">
            </div>
            <div class="diseño">
                <input type="text" name="pass" id="pass" placeholder="Password" /><br>
            </div>     
		    <div class="diseño2">
                <label>Rol</label>
                <select name="rol" id="rol">
                    <option value="0">Selecciona</option>
                    <option value="1">Gerente</option>
                    <option value="2">Ejecutivo</option>
                </select>
            </div>
                <label for="archivo">Agregar foto</label>
                <input type="file" id="archivo" name="archivo"><br><br>

            <input id="guardar" name="guardar" type="submit" value="Guardar" onclick="validar(); return false;" /><br><br>
            <div id="mensaje"></div>
            <div id="mensajeValidacion"></div>
    </form>  

</body>
</html>
