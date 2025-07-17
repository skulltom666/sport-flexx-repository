<?php
require_once(__DIR__ . "/../coneccion/conector.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $obj = new Conectar();
    $IdVariante = $_POST["variant-id"];

    $sqlDelete = "DELETE FROM producto_variantes WHERE IdVariante = ?";
    $stmtDelete = $obj->getConexion()->prepare($sqlDelete);
    $stmtDelete->bind_param("i", $IdVariante);
    $stmtDelete->execute();

    header("Location: Productos_variantes.php");
    exit();
}
?>
