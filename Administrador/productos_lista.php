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
        .encabezado a {
            color: black;
            padding: 10px;
            text-decoration: none;
        }
        .encabezado a:hover, .encabezado a.active {
            background-color: white;
            border-radius: 5px;
        }
        .linea_encabezado {
            width: 100%;
            height: 10px;
            background-color:#4682B4;

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
        .orden {
        width: 400px; /* Ancho reducido para cada producto */
        height: auto; /* Altura automática para acomodar contenido variable */
        display: flex; /* Mantiene el uso de flexbox */
        flex-direction: column; /* Cambio de orientación a vertical */
        align-items: center; /* Centra los elementos horizontalmente */
        margin: 20px; /* Espacio alrededor para evitar que los productos se toquen */
        background-color: #fff; /* Fondo blanco para resaltar el producto */
        padding: 10px; /* Espacio interno */
        border-radius: 8px; /* Bordes redondeados */
        box-shadow: 0 4px 8px rgba(0,0,0,0.3); /* Sombra para mejor visualización */
        }

        .orden img {
        max-width: 320px; /* Asegura que la imagen no sobrepase el contenedor */
        height: auto; /* Mantiene la proporción */
        }

        .orden .info {
        text-align: center; /* Centra el texto debajo de la imagen */
        width: 100%; /* Utiliza el ancho completo del contenedor */
        padding-top: 10px; /* Espacio entre la imagen y el texto */
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

        footer a:hover {
            text-decoration: underline;
        }
    </style>

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
    <a href="productos_lista.php" style="color:black;"class="active" >Productos</a>
    <a href="contacto.php" style="color:black;">Contacto</a> 
    <a href="carrito.php" style="color:black;" >Carrito <?php echo $num_filas; ?></a>
    <a href="cerrar_sesion.php" style="color:black;" >Cerrar sesion</a>
</div>
    <div class="linea_encabezado"></div>
    <h1>Productos</h1>
    <div style="display: flex; flex-wrap: wrap; justify-content: center;"> 
    <?php
    $query = "SELECT * FROM productos 
              WHERE status = 1 AND eliminado = 0 ";
    $sql = $con->query($query);
    //$num = $sql->num_rows;
    //echo "Lista de empleados <br><br>";
    while ($row = $sql->fetch_array()) {
        $id = $row["id"];
        $nombre = $row["nombre"];
        $codigo = $row["codigo"];
        $descripcion = $row["descripcion"];
        $costo = $row["costo"];
        $stock = $row["stock"];
        $archivo_n = $row['archivo_n'];
        //echo "<a href=\"empleados_eliminar.php?id=$id\">Eliminar</a> <br>";
        
        echo "<div class='orden'>";
        echo "<a href='producto_detalle.php?id=$id'>";
        echo "<img src='Administrador/productos/" . htmlspecialchars($row['archivo_n']) . "'>"; 
        echo "</a>"; 
        echo "<div class='info'>";  
        echo "<p>" . htmlspecialchars($row['nombre']) . "</p>";
        echo "<p>Precio: $" . htmlspecialchars($row['costo']) . "</p>";
        echo "<p>Existentes: ". htmlspecialchars($row['stock']) . "</p>";
        echo "<form action='agregar_pedido.php' method='post'>"; //formulario de pedido
            echo "<input type='hidden' name='id_producto' value='" . $row['id'] . "'>";
            echo "<input type='hidden' name='nombre' value='" . $row['nombre'] . "'>";
            echo "<input type='hidden' name='costo' value='" . $row['costo'] . "'>";
            echo "<label for='cantidad'> Agregar al carrito:</label>";
            echo "<input type='number' id='cantidad' name='cantidad' min='1' max='" . $row['stock'] . "' required>";
            echo "<button type='submit'>Aceptar</button>";
        echo "</form>";
        echo "</div>";
        echo "</div>";
    }
?>
    </div>
    <footer>
        <p>&copy; 2024 Derechos Reservados</p>
        <a href="terminos.php">Términos y Condiciones</a>
        <a href="https://facebook.com" target="_blank">Facebook</a>
        <a href="https://twitter.com" target="_blank">Twitter</a>
        <a href="https://instagram.com" target="_blank">Instagram</a>
    </footer>


</body>
</html>