<?php
require_once(__DIR__ . "/../coneccion/conector.php");

header('Content-Type: application/json');

// Leer y decodificar la solicitud JSON
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['Categoria-Id'])) {
    $idCategoria = $data['Categoria-Id'];

    $obj = new Conectar();
    $conexion = $obj->getConexion();

    $sql = "DELETE FROM categoria WHERE IdCategoria = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $idCategoria);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }

    $stmt->close();
    $conexion->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
}
?>
