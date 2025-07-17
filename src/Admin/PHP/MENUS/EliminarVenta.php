<?php
require_once(__DIR__ . "/../coneccion/conector.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idVenta = $_POST["Venta-Id"];

    $obj = new Conectar();
    $conn = $obj->getConexion();

    $sql = "DELETE FROM venta WHERE IdVenta = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idVenta);

    if ($stmt->execute()) {
        header("Location: Ventas.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
