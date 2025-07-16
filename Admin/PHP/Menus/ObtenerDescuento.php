<?php
require_once(__DIR__ . "/../coneccion/conector.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idCuponDescuento = $_POST["IdCuponDescuento"];

    $obj = new Conectar();
    $conn = $obj->getConexion();

    $sql = "SELECT DescuentoPorcentaje FROM cupondescuento WHERE IdCuponDescuento = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idCuponDescuento);

    if ($stmt->execute()) {
        $stmt->bind_result($descuentoPorcentaje);
        $stmt->fetch();
        echo json_encode(["DescuentoPorcentaje" => $descuentoPorcentaje]);
    } else {
        echo json_encode(["DescuentoPorcentaje" => 0]);
    }
}
?>
