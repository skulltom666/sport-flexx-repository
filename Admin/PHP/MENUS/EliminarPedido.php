<?php
require_once(__DIR__ . "/../coneccion/conector.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idPedido = $_POST["Pedido-Id"];

    $obj = new Conectar();
    $conn = $obj->getConexion();

    $sql = "DELETE FROM pedido WHERE IdPedido = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idPedido);

    if ($stmt->execute()) {
        header("Location: Pedido.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
