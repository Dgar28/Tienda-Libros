<?php
session_start();
require "Administrador/funciones/conecta.php";
$con = conecta();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_cliente'])) {
    header('Location: index.php'); // Redirige al usuario si no está autenticado
    exit();
}

$id_cliente = $_SESSION['id_cliente'];
?>
<?php
$total_cant = $_POST['total_cant'];
$total_costo = $_POST['total_costo'];
$id_cliente = $_SESSION['id_cliente'];

// Primero, verificamos si hay un pedido abierto con status 0 para el cliente
$sql_check_pedido = "SELECT id FROM pedidos WHERE cliente = '$id_cliente' AND status = 0";
$result = $con->query($sql_check_pedido);

if ($result->num_rows > 0) {
    // Si existe un pedido abierto, obtenemos su ID
    $row = $result->fetch_assoc();
    $id_pedido = $row['id'];

    // Actualizamos el pedido existente
    $sql_update_pedido = "UPDATE pedidos SET total_cant = '$total_cant', costo_total = '$total_costo', fecha = NOW(), status = 1 WHERE id = '$id_pedido'";
    if ($con->query($sql_update_pedido) === true) {
        echo "<script>
                alert('Pedido actualizado y aceptado exitosamente!');
                window.location.href = 'carrito.php'; // Redirigir a carrito.php
              </script>";
    } else {
        echo "<script>alert('Error al actualizar el pedido: " . $con->error . "');</script>";
    }
} else {
    // Si no existe, insertamos un nuevo pedido
    $sql_insert_pedido = "INSERT INTO pedidos (cliente, total_cant, costo_total, fecha, status)
                          VALUES ('$id_cliente', '$total_cant', '$total_costo', NOW(), 1)";
    if ($con->query($sql_insert_pedido) === true) {
        echo "<script>
                alert('Pedido aceptado exitosamente!');
                window.location.href = 'carrito.php'; // Redirigir a carrito.php
              </script>";
    } else {
        echo "<script>alert('Error al aceptar el pedido: " . $con->error . "');</script>";
    }
}
