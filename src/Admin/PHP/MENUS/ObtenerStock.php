<?php
require_once(__DIR__ . "/../coneccion/conector.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $idProducto = $_POST['IdProducto'];
    $talla = $_POST['Talla'];

    $conexion = new mysqli('localhost', 'root', '', 'sportflexx');

    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    $sql = "SELECT Stock FROM producto_variantes WHERE IdProducto = ? AND Talla = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('is', $idProducto, $talla);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        echo $row['Stock'];
    } else {
        echo "No disponible";
    }
}
?>
