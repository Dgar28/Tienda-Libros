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

    $query = "SELECT * FROM promociones
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
            margin-left: 30px;

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
    var nombre = $("#nombre").val();
    var archivo_n = $("#archivo").val();


    if (nombre === "" ) {
        $('#mensaje').show().html('Faltan campos por llenar');
            setTimeout(function() {
                $('#mensaje').html('').hide();
            }, 5000);
    }
    else{
        document.alta.method = 'post';
        document.alta.action = 'promocion_actualizar.php';
        document.alta.submit();
    }
}
        
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
    <h1>Edición de la promocion</h1>
    <div class="boton-mover">
    <a href="promociones_lista.php"><button>Volver</button></a>
    </div>
    <div class="centrar">
    <br>
    <form name="alta" enctype="multipart/form-data" method="post">
        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
        <div class="diseño2">
            <input id="nombre" type="text" name="nombre" placeholder="Nombre" value="<?php echo $row['nombre']; ?>" required>
        </div>
        <div style= background-color:#AFEEEE>
        <?php if (!empty($row['archivo'])): ?>
        <div>
            <label>Imagen Actual:</label>
            <img src="banner/<?php echo htmlspecialchars($row['archivo']); ?>" style="width: 150px; height: 140px;">
        </div>
    <?php endif; ?>
    <label for="archivo">Cambiar foto</label>
    <input type="file" id="archivo" name="archivo"><br><br>
        <div class="boton-centrado">
        <input id="guardar" name="guardar" type="submit" value="Guardar"onclick="validar(); return false;"><br><br>
        </div>
        <div id="mensaje"></div>
    </form>  
    </div>
    </div>
</body>
</html>
