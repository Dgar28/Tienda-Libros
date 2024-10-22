<?php
session_start();
require "Administrador/funciones/conecta.php";
$con = conecta();

$id_cliente = $_SESSION['id_cliente']; // Obtener la ID del cliente de la sesión

$id_producto = $_POST['id_producto'];
$costo_unitario = $_POST['costo']; // Supongo que este es el costo unitario del producto
$cantidad = $_POST['cantidad'];

// Intentamos encontrar un pedido activo (status != 1) asociado al cliente
$sql_get_pedido = "SELECT id FROM pedidos WHERE cliente = '$id_cliente' AND status = 0 ORDER BY id DESC LIMIT 1";
$result_pedido = $con->query($sql_get_pedido);

if ($result_pedido->num_rows > 0) {
    $row_pedido = $result_pedido->fetch_assoc();
    $id_pedido = $row_pedido['id'];
} else {
    // Si no hay pedidos activos, crear un nuevo pedido asociado al cliente
    $sql_create_pedido = "INSERT INTO pedidos (cliente, total_cant, costo_total, fecha, status) VALUES 
                                                ('$id_cliente', 0, 0, NOW(), 0)";
    if ($con->query($sql_create_pedido)) {
        $id_pedido = $con->insert_id;
    } else {
        echo "Error al crear nuevo pedido: " . $con->error;
        exit;
    }
}

// Verificar si el producto ya está en el carrito para este pedido específico
$sql_check = "SELECT cant, costo FROM pedidos_productos 
              WHERE id_producto = '$id_producto' AND id_pedido = '$id_pedido'";
$result_check = $con->query($sql_check);

if ($result_check->num_rows > 0) {
    // Si el producto ya está en el carrito, actualizar la cantidad y el costo
    $row = $result_check->fetch_assoc();
    $nueva_cantidad = $row['cant'] + $cantidad;
    $nuevo_costo = $row['costo'] + ($costo_unitario * $cantidad);
    
    $sql_update_pedido = "UPDATE pedidos_productos 
                          SET cant = $nueva_cantidad, costo = $nuevo_costo 
                          WHERE id_producto = '$id_producto' AND id_pedido = '$id_pedido'";
    $con->query($sql_update_pedido);
} else {
    // Si el producto no está en el carrito, insertar un nuevo registro
    $costo_total = $costo_unitario * $cantidad; // Cálculo del costo total
    $sql_insert = "INSERT INTO pedidos_productos (id_producto, costo, cant, id_pedido) 
                   VALUES ('$id_producto', $costo_total, $cantidad, '$id_pedido')";
    $con->query($sql_insert);
}

// Actualizar el stock en la tabla productos
$sql_update_stock = "UPDATE productos SET stock = stock - $cantidad WHERE id = '$id_producto'";
$con->query($sql_update_stock);

header('Location: productos_lista.php');

