<?php
require_once(__DIR__ . "/../coneccion/conector.php");

$obj = new Conectar();
$sql = "
    SELECT v.IdVenta, v.IdPedido, v.FechaVenta, v.IGV, v.Total, v.Descuento, tp.Tipo
    FROM venta v
    LEFT JOIN tipopago tp ON v.IdTipoPago = tp.IdTipoPago
";
$rsVentas = mysqli_query($obj->getConexion(), $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Gestión de Ventas - SPORTFLEXX</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../estilos/stylesAdmin.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<?php
include_once "navbar_admin.php";
?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Ventas</h1>
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalVenta" onclick="clearForm()">Nueva Venta</button>

                    <div class="modal fade" id="modalVenta" tabindex="-1" aria-labelledby="modalVentaLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalVentaLabel">Venta</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="Venta-form" method="post" action="RegistrarVenta.php">
                                        <input type="hidden" id="IdVenta" name="IdVenta" value="0">
                                        <div class="mb-3">
                                            <label for="venta-IdPedido">ID Pedido</label>
                                            <select id="venta-IdPedido" name="IdPedido" class="form-control" required onchange="fetchPedidoDetails(this.value)">
                                                <option value="" disabled selected>Selecciona un pedido</option>
                                                <?php
                                                $sqlPedidos = "SELECT IdPedido, NumeroPedido FROM pedido";
                                                $rsPedidos = mysqli_query($obj->getConexion(), $sqlPedidos);
                                                while ($pedido = mysqli_fetch_array($rsPedidos)) {
                                                    echo "<option value='" . $pedido['IdPedido'] . "'>" . $pedido['NumeroPedido'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                            <div class="invalid-feedback" id="pedido-error"></div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="venta-FechaVenta">Fecha de Venta</label>
                                            <input type="date" id="venta-FechaVenta" name="FechaVenta" class="form-control" required>
                                            <div class="invalid-feedback" id="fecha-error"></div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="venta-IGV">IGV (%)</label>
                                            <input type="number" id="venta-IGV" name="IGV" class="form-control" required value="18">
                                            <div class="invalid-feedback" id="igv-error"></div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="venta-Descuento">Descuento (S/)</label>
                                            <input type="number" id="venta-Descuento" name="Descuento" class="form-control" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="venta-Total">Total (S/)</label>
                                            <input type="number" id="venta-Total" name="Total" class="form-control" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="venta-IdTipoPago">Tipo de Pago</label>
                                            <select id="venta-IdTipoPago" name="IdTipoPago" class="form-control" required>
                                                <option value="" disabled selected>Selecciona un tipo de pago</option>
                                                <?php
                                                $sqlTiposPago = "SELECT IdTipoPago, Tipo FROM tipopago";
                                                $rsTiposPago = mysqli_query($obj->getConexion(), $sqlTiposPago);
                                                while ($tipoPago = mysqli_fetch_array($rsTiposPago)) {
                                                    echo "<option value='" . $tipoPago['IdTipoPago'] . "'>" . $tipoPago['Tipo'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                            <div class="invalid-feedback" id="tipoPago-error"></div>
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-3">Guardar Venta</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Ventas
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>IdVenta</th>
                                        <th>IdPedido</th>
                                        <th>Fecha de Venta</th>
                                        <th>IGV</th>
                                        <th>Descuento</th>
                                        <th>Total</th>
                                        <th>Tipo de Pago</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($registro = mysqli_fetch_array($rsVentas)) {
                                        echo "<tr>";
                                        echo "<td>" . $registro['IdVenta'] . "</td>";
                                        echo "<td>" . $registro['IdPedido'] . "</td>";
                                        echo "<td>" . $registro['FechaVenta'] . "</td>";
                                        echo "<td>" . $registro['IGV'] . "</td>";
                                        echo "<td>" . $registro['Descuento'] . "</td>";
                                        echo "<td>" . $registro['Total'] . "</td>";
                                        echo "<td>" . $registro['Tipo'] . "</td>";
                                        echo "<td>
                                                <button class='btn btn-primary btn-sm edit-btn' data-bs-toggle='modal' data-bs-target='#modalVenta' onclick='loadVentaData(this)'>Editar</button>
                                                <form method='post' action='EliminarVenta.php' class='d-inline delete-form'>
                                                    <input type='hidden' name='Venta-Id' value='" . $registro['IdVenta'] . "'>
                                                    <button type='submit' class='btn btn-danger btn-sm'>Eliminar</button>
                                                </form>
                                            </td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
<?php
include_once "footer_Admin.php";
?>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"
        crossorigin="anonymous"></script>
    <script src="../assets/demo/chart-area-demo.js"></script>
    <script src="../assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="../js/datatables-simple-demo.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const editButtons = document.querySelectorAll(".edit-btn");
            editButtons.forEach(button => {
                button.addEventListener("click", (event) => {
                    const venta = JSON.parse(event.currentTarget.getAttribute("data-venta"));
                    loadVentaData(venta);
                });
            });

            const deleteForms = document.querySelectorAll(".delete-form");
            deleteForms.forEach(form => {
                form.addEventListener("submit", (event) => {
                    event.preventDefault();
                    const confirmation = confirm("¿Está seguro de que desea eliminar esta Venta?");
                    if (confirmation) {
                        form.submit();
                    }
                });
            });

            document.getElementById("Venta-form").addEventListener("submit", function(event) {
                event.preventDefault();
                if (validateForm()) {
                    this.submit();
                }
            });

            function validateForm() {
                let valid = true;

                const idPedido = document.getElementById("venta-IdPedido");
                const fechaVenta = document.getElementById("venta-FechaVenta");
                const igv = document.getElementById("venta-IGV");
                const tipoPago = document.getElementById("venta-IdTipoPago");

                if (idPedido.value === "") {
                    idPedido.classList.add("is-invalid");
                    document.getElementById("pedido-error").textContent = "Selecciona un pedido.";
                    valid = false;
                } else {
                    idPedido.classList.remove("is-invalid");
                    document.getElementById("pedido-error").textContent = "";
                }

                if (fechaVenta.value === "") {
                    fechaVenta.classList.add("is-invalid");
                    document.getElementById("fecha-error").textContent = "Selecciona una fecha de venta.";
                    valid = false;
                } else {
                    fechaVenta.classList.remove("is-invalid");
                    document.getElementById("fecha-error").textContent = "";
                }

                if (igv.value === "") {
                    igv.classList.add("is-invalid");
                    document.getElementById("igv-error").textContent = "El IGV es obligatorio.";
                    valid = false;
                } else {
                    igv.classList.remove("is-invalid");
                    document.getElementById("igv-error").textContent = "";
                }

                if (tipoPago.value === "") {
                    tipoPago.classList.add("is-invalid");
                    document.getElementById("tipoPago-error").textContent = "Selecciona un tipo de pago.";
                    valid = false;
                } else {
                    tipoPago.classList.remove("is-invalid");
                    document.getElementById("tipoPago-error").textContent = "";
                }

                return valid;
            }
        });

        function loadVentaData(venta) {
            document.getElementById("IdVenta").value = venta.IdVenta;
            document.getElementById("venta-IdPedido").value = venta.IdPedido;
            document.getElementById("venta-FechaVenta").value = venta.FechaVenta;
            document.getElementById("venta-IGV").value = venta.IGV;
            document.getElementById("venta-Descuento").value = venta.Descuento;
            document.getElementById("venta-Total").value = venta.Total;
            document.getElementById("venta-IdTipoPago").value = venta.IdTipoPago;
        }

        function fetchPedidoDetails(idPedido) {
            fetch('ObtenerDetallesPedido.php?idPedido=' + idPedido)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById("venta-Descuento").value = data.descuento;
                        document.getElementById("venta-Total").value = data.total;
                    } else {
                        alert('ID de Pedido no encontrado.');
                    }
                });
        }

        function clearForm() {
            document.getElementById("IdVenta").value = 0;
            document.getElementById("venta-IdPedido").value = '';
            document.getElementById("venta-FechaVenta").value = '';
            document.getElementById("venta-IGV").value = '';
            document.getElementById("venta-Descuento").value = '';
            document.getElementById("venta-Total").value = '';
            document.getElementById("venta-IdTipoPago").value = '';

            document.getElementById("pedido-error").textContent = "";
            document.getElementById("fecha-error").textContent = "";
            document.getElementById("igv-error").textContent = "";
            document.getElementById("tipoPago-error").textContent = "";

            const formControls = document.querySelectorAll('.form-control');
            formControls.forEach(control => control.classList.remove('is-invalid'));
        }
    </script>
</body>
</html>
