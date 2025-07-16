<?php
require_once(__DIR__ . "/../coneccion/conector.php");

if (isset($_GET['id'])) {
    $idCliente = $_GET['id'];

    $obj = new Conectar();
    $conexion = $obj->getConexion();

    if (!$conexion) {
        die("Error en la conexión: " . mysqli_connect_error());
    }

    $sqlEliminar = "DELETE FROM cliente WHERE IdCliente = ?";
    $stmtEliminar = $conexion->prepare($sqlEliminar);
    $stmtEliminar->bind_param("i", $idCliente);

    if ($stmtEliminar->execute()) {
        $stmtEliminar->close();
        $conexion->close();
        header("Location: clientes.php");
        exit();
    } else {
        echo "Error al eliminar el cliente: " . $conexion->error;
    }
} else {
    echo "ID de cliente no especificado.";
}
?>