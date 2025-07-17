<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Estado de Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Reporte de Estado de Pedidos</h1>
        <form method="POST" action="estadoPedido.php">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="estado" class="form-label">Estado del Pedido:</label>
                    <select class="form-control" id="estado" name="estado" required>
                        <option value="" disabled selected>Seleccione un estado</option>
                        <option value="Enviado">Enviado</option>
                        <option value="Pendiente">Pendiente</option>
                        <option value="Cancelado">Cancelado</option>
                    </select>
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Consulta</button>
                </div>
            </div>
        </form>
        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
            <?php
            require_once(__DIR__ . "/../coneccion/conector.php");

            $estado = $_POST['estado'];

            $obj = new Conectar();
            $sql = "SELECT p.IdPedido, p.NumeroPedido, c.Nombre AS Cliente, u.NombreUsuario AS Empleado, p.FechaPedido, p.FechaEntrega, p.Estado
                    FROM pedido p
                    JOIN cliente c ON p.IdCliente = c.IdCliente
                    JOIN usuario u ON c.IdUsuario = u.IdUsuario
                    WHERE p.Estado = ?";
            $stmt = $obj->getConexion()->prepare($sql);
            $stmt->bind_param("s", $estado);
            $stmt->execute();
            $result = $stmt->get_result();
            ?>
            <div class="mt-4">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Pedido</th>
                            <th>Número Pedido</th>
                            <th>Cliente</th>
                            <th>Empleado</th>
                            <th>Fecha Pedido</th>
                            <th>Fecha Entrega</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['IdPedido']; ?></td>
                                <td><?php echo $row['NumeroPedido']; ?></td>
                                <td><?php echo $row['Cliente']; ?></td>
                                <td><?php echo $row['Empleado']; ?></td>
                                <td><?php echo $row['FechaPedido']; ?></td>
                                <td><?php echo $row['FechaEntrega']; ?></td>
                                <td><?php echo $row['Estado']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
