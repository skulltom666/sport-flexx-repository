<?php
require_once(__DIR__ . "/../coneccion/conector.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idDireccion = $_POST["Direccion-Id"];

    $obj = new Conectar();
    $conn = $obj->getConexion();

    $sql = "DELETE FROM direccion WHERE IdDireccion = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idDireccion);

    if ($stmt->execute()) {
        header("Location: Direccion.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>