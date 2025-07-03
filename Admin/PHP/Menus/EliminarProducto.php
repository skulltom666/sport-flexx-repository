<?php
require_once(__DIR__ . "/../coneccion/conector.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["product-id"]; // Asegúrate de que el nombre del campo coincide

    $obj = new Conectar();
    $sql = "DELETE FROM producto WHERE IdProducto = ?";
    $stmt = $obj->getConexion()->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: Productos.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
