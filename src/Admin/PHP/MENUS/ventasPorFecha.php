<?php
session_start();
if (!isset($_SESSION['idRol']) || $_SESSION['idRol'] != 1) {
    header("Location: ../../../Cliente/PHP/login2.php");
    exit();
}

require_once(__DIR__ . "/../coneccion/conector.php");

$fechaInicio = '';
$fechaFinal = '';
$result = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFinal = $_POST['fechaFinal'];

    $obj = new Conectar();
    $sql = "SELECT v.IdVenta, c.Nombre AS Cliente, u.NombreUsuario AS Empleado, v.FechaVenta, v.Total
            FROM venta v
            JOIN pedido p ON v.IdPedido = p.IdPedido
            JOIN cliente c ON p.IdCliente = c.IdCliente
            JOIN usuario u ON c.IdUsuario = u.IdUsuario
            WHERE v.FechaVenta BETWEEN ? AND ?";
    $stmt = $obj->getConexion()->prepare($sql);
    $stmt->bind_param("ss", $fechaInicio, $fechaFinal);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ventas por Fecha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../estilos/stylesAdmin.css" rel="stylesheet">
    <link href="../estilos/styles.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<?php
include_once "navbar_admin.php";
?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Reporte de Ventas por Fecha</h1>
                    <form method="POST" action="ventasPorFecha.php">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="fechaInicio" class="form-label">Fecha Inicial:</label>
                                <input type="date" class="form-control" id="fechaInicio" name="fechaInicio" required>
                            </div>
                            <div class="col-md-4">
                                <label for="fechaFinal" class="form-label">Fecha Final:</label>
                                <input type="date" class="form-control" id="fechaFinal" name="fechaFinal" required>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary">Consulta</button>
                                <button type="button" class="btn btn-secondary" onclick="generatePDF()">Generar PDF</button>
                            </div>
                        </div>
                    </form>
                    <?php if ($result): ?>
                        <div class="mt-4">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Num. Boleta</th>
                                        <th>Cliente</th>
                                        <th>Empleado</th>
                                        <th>Fecha</th>
                                        <th>Monto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $row['IdVenta']; ?></td>
                                            <td><?php echo $row['Cliente']; ?></td>
                                            <td><?php echo $row['Empleado']; ?></td>
                                            <td><?php echo $row['FechaVenta']; ?></td>
                                            <td><?php echo $row['Total']; ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </main>
<?php
include_once "footer_Admin.php";
?>
        </div>
    </div>
    <script>
        function generatePDF() {
            var form = document.createElement("form");
            form.method = "POST";
            form.action = "generarPDF.php";
            
            var fechaInicio = document.getElementById("fechaInicio").value;
            var fechaFinal = document.getElementById("fechaFinal").value;

            var inputInicio = document.createElement("input");
            inputInicio.type = "hidden";
            inputInicio.name = "fechaInicio";
            inputInicio.value = fechaInicio;

            var inputFinal = document.createElement("input");
            inputFinal.type = "hidden";
            inputFinal.name = "fechaFinal";
            inputFinal.value = fechaFinal;

            form.appendChild(inputInicio);
            form.appendChild(inputFinal);
            
            document.body.appendChild(form);
            form.submit();
        }
    </script>
    <script src="../../JavaScript/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>