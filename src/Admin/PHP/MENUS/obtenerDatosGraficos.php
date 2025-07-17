<?php
require_once(__DIR__ . "/../coneccion/conector.php");

$obj = new Conectar();
$conn = $obj->getConexion();

$response = [
    'ventas' => [],
    'categorias' => [],
    'clientes' => []
];

// Obtener ventas por fecha
$sqlVentas = "SELECT FechaVenta as Fecha, SUM(Total) as Total FROM venta GROUP BY FechaVenta";
$resultVentas = $conn->query($sqlVentas);
while ($row = $resultVentas->fetch_assoc()) {
    $response['ventas'][] = $row;
}

// Obtener productos por categoría
$sqlCategorias = "SELECT c.Nombre as Categoria, COUNT(p.IdProducto) as Total FROM categoria c LEFT JOIN producto p ON c.IdCategoria = p.IdCategoria GROUP BY c.Nombre";
$resultCategorias = $conn->query($sqlCategorias);
while ($row = $resultCategorias->fetch_assoc()) {
    $response['categorias'][] = $row;
}

// Obtener clientes por sexo
$sqlClientes = "SELECT Sexo, COUNT(IdCliente) as Total FROM cliente GROUP BY Sexo";
$resultClientes = $conn->query($sqlClientes);
while ($row = $resultClientes->fetch_assoc()) {
    $response['clientes'][] = $row;
}

header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>
