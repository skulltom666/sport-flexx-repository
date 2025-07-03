<?php
require_once(__DIR__ . "/../coneccion/conector.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idDireccion = isset($_POST["IdDireccion"]) ? $_POST["IdDireccion"] : 0;
    $idCliente = $_POST["IdCliente"];
    $departamento = $_POST["Departamento"];
    $provincia = $_POST["Provincia"];
    $distrito = $_POST["Distrito"];
    $direccion = $_POST["Direccion"];

    $obj = new Conectar();
    $conn = $obj->getConexion();

    if ($idDireccion > 0) {
        $sql = "UPDATE direccion SET IdCliente = ?, Departamento = ?, Provincia = ?, Distrito = ?, Direccion = ? WHERE IdDireccion = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssi", $idCliente, $departamento, $provincia, $distrito, $direccion, $idDireccion);
    } else {
        $sql = "INSERT INTO direccion (IdCliente, Departamento, Provincia, Distrito, Direccion) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issss", $idCliente, $departamento, $provincia, $distrito, $direccion);
    }

    if ($stmt->execute()) {
        header("Location: Direccion.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

