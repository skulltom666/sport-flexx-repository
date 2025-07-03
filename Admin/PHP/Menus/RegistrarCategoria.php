<?php
require_once(__DIR__ . "/../coneccion/conector.php");

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$nombre = $data['Nombre'];
$descripcion = $data['Descripcion'];
$idCategoria = $data['IdCategoria'];

$obj = new Conectar();
$conexion = $obj->getConexion();

if ($idCategoria == 0) {
    $sql = "INSERT INTO categoria (Nombre, Descripcion) VALUES (?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $nombre, $descripcion);
} else {
    $sql = "UPDATE categoria SET Nombre = ?, Descripcion = ? WHERE IdCategoria = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssi", $nombre, $descripcion, $idCategoria);
}

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}

$stmt->close();
$conexion->close();
?>
