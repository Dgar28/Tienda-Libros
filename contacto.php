<?php    
session_start();
    require "Administrador/funciones/conecta.php";
    $con = conecta();
    if (isset($_SESSION['id_cliente'])) {
        $id_cliente = $_SESSION['id_cliente'];
        $query = "SELECT * FROM clientes WHERE id = $id_cliente";
        $sql = $con->query($query);

        if (mysqli_num_rows($sql) > 0) {
            $row_cliente = mysqli_fetch_assoc($sql); // Datos del usuario logueado
        }
        } else {
        header('Location: index.php'); // Redirige al usuario si no está autenticado
        exit();
    }
?>
<html>
<head>
    <title>Contacto</title>
    <script src="js/jquery-3.3.1.min.js"></script>
    <style>  

        body{
        background-color:cadetblue;
        }
        .encabezado {
            width: 100%;
            height: 60px;
            background-color: #87CEEB;
            display: flex;
            align-items: center; /* Centra verticalmente */
            justify-content: space-between; /* Espacio entre elementos */
            padding-right: 10px;
        }
        .linea_encabezado {
            width: 100%;
            height: 10px;
            background-color:#4682B4;

        }
        .encabezado a {
            color: black;
            padding: 10px;
            text-decoration: none;
        }
        .encabezado a:hover, .encabezado a.active {
            background-color:white;
            border-radius: 5px;
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
        .imagen{
            width: 600px;
            height: 200px;
            padding-left: 380px;
        }
        footer {
            background-color: black;
            color: white;
            text-align: center;
            padding: 20px 0;
            width: 100%;

        }

        footer a {
            color: white;
            margin: 0 10px;
            text-decoration: none;
        }

        footer a {
            text-decoration: underline;
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
            margin-right: 45px;
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
        .boton-centrado {
            padding-left: 125px;
        }
        .boton-mover {
            padding-left: 400px;
        }
        
    </style>
    <script>
        function validar() {
            
            var nombre = document.alta.nombre.value;
            var descripcion = document.alta.descripcion.value;
            var correo = document.alta.correo.value;
           

            if (nombre === "" || correo === "" || descripcion === "" ) {
                $('#mensaje').show().html('Faltan campos por llenar');
                    setTimeout(function() {
                    $('#mensaje').html('').hide();
                    }, 5000);
            } else {
                        document.alta.method = 'post';
                        document.alta.action = 'enviar_correo.php';
                        document.alta.submit();
            }
        }
        

    </script>
</head>
<body>
    <?php
$query_carrito_count = "SELECT COUNT(*) as num_productos FROM pedidos_productos pp JOIN pedidos ped ON pp.id_pedido = ped.id WHERE ped.status = 0";
$result_carrito_count = $con->query($query_carrito_count);
$row_carrito_count = $result_carrito_count->fetch_assoc();
$num_filas = $row_carrito_count['num_productos'];
?>
<div class="encabezado">
    <img src="RABE.jpeg" style=" height:60px; width: 90px;">
    <a href="home.php" style="color:black;">Home</a>
    <a href="productos_lista.php" style="color:black;" >Productos</a>
    <a href="contacto.php" style="color:black;"class="active">Contacto</a> 
    <a href="carrito.php" style="color:black;" >Carrito <?php echo $num_filas; ?></a>
    <a href="cerrar_sesion.php" style="color:black;" >Cerrar sesion</a>
</div>
    <div class="linea_encabezado"></div>
    <div class="fondo">
    <h1>Contacto</h1>
    <div class="centrar">
    <br>
    <form name="alta"  method="post">
        <div class="diseño2">
            <input id="nombre" type="text" name="nombre" placeholder="Nombre" required>
        </div>
        <br>
        <div class="diseño">
            <input id="correo" type="email" name="correo" placeholder="Correo" required>
        </div>
        <br>
        <div class="diseño2">
            <input type="text" name="descripcion" id="descripcion" placeholder="Descripcion">
        </div>
        <br>
            <div class="boton-centrado">    
                <input id="enviar" name="enviar" type="submit" value="Enviar" onclick="validar(); return false;" ><br><br>
            </div>    
                <div id="mensaje"></div>
    </form>  
    </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <footer>
        <p>&copy; 2024 Derechos Reservados</p>
        <a href="terminos.php">Términos y Condiciones</a>
        <a href="https://facebook.com" target="_blank">Facebook</a>
        <a href="https://twitter.com" target="_blank">Twitter</a>
        <a href="https://instagram.com" target="_blank">Instagram</a>
    </footer>
</body>
</html>