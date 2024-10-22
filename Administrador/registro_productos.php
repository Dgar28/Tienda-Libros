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
    <title>Registro de productos</title>
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
        body{
        background-color: #AFEEEE;
        }
        .centrar {
            display: flex; /* Usa flexbox para el alineamiento */
            justify-content: center; /* Centra horizontalmente el contenido dentro del div */
            align-items: center; /* Centra verticalmente el contenido dentro del div */
            width: 100%; /* Asegura que el div tome todo el ancho disponible */
            padding-left: 30px;
        }
        .diseño input{
            width: 320px;
            background-color: aquamarine;
            height: 35px;
        }
        .diseño2 input{
            width: 320px;
            background-color: beige;
            height: 35px;
        }
        #mensaje {
            display: none;
            background-color: #CCCCCC;
            color: #333; 
            border: 1px solid #ccc; 
            padding: 10px; /* Espacio interior para hacerlo más grande */
            margin-top: 10px; /* Espacio superior */
            text-align: center;
            font-weight: bold; 
            width: 250px;
            margin-left: 20px;

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
        .boton-centrado {
            padding-left: 125px;
        }
        .boton-mover {
            padding-left: 400px;
        }
        
    </style>
    <script>
        function validar() {
            var codigo = document.alta.codigo.value;
            var nombre = document.alta.nombre.value;
            var descripcion = document.alta.descripcion.value;
            var costo = document.alta.costo.value;
            var stock = document.alta.stock.value;
            var archivo = document.alta.archivo.value;

            if (nombre === "" || codigo === "" || descripcion === "" || costo === "" || stock === "" || archivo === "") {
                $('#mensaje').show().html('Faltan campos por llenar');
                    setTimeout(function() {
                    $('#mensaje').html('').hide();
                    }, 5000);
            } else {
                        document.alta.method = 'post';
                        document.alta.action = 'productos_alta.php';
                        document.alta.submit();
            }
        }
        function validarCodigo(codigo) {
        $.ajax({
            url: "validar_codigo.php", 
            method: "POST",
            data: { codigo: codigo },
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
    $("#codigo").on("blur", function() {
        validarCodigo($(this).val());
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
    <div class="fondo">
    <h1>Registro de productos</h1>
    <div class="boton-mover">
    <a href="productos_lista.php"><button>Volver</button></a>
    </div>
    <div class="centrar">
    <br>
    <form name="alta" enctype="multipart/form-data" action="productos_alta.php" method="post">
			<div class="diseño2">
                <input id="nombre" type="text" name="nombre" placeholder="Nombre" required>
            </div>
            <br>
            <div class="diseño">
                <input id="codigo" type="number" name="codigo" placeholder="Codigo" onblur="validarCodigo(this.value)" required>
            </div>
            <br>    
		    <div class="diseño2">
                <input id="costo" type="number" name="costo" placeholder="Precio" required>
            </div>
            <br>
            <div class="diseño">
                <input type="number" name="stock" id="stock" placeholder="Cantidad" /><br>
            </div>
            <br>     
		    <div class="diseño2">
                <input type="text" name="descripcion" id="descripcion" placeholder="Descripcion" /><br>
            </div>
                <label for="archivo">Agregar foto</label>
                <input type="file" id="archivo" name="archivo" required>
                <br>
                <br>
            <div class="boton-centrado">    
                <input id="guardar" name="guardar" type="submit" value="Guardar" onclick="validar(); return false;" /><br><br>
            </div>    
                <div id="mensaje"></div>
    </form>  
    </div>
    </div>
</body>
</html>
