<?php
require_once(__DIR__ . "/../coneccion/conector.php");
$obj = new Conectar();
$conexion = $obj->getConexion();

if (!$conexion) {
    die("Error en la conexión: " . mysqli_connect_error());
}
$sqlClientes = "SELECT cliente.*, usuario.IdUsuario, usuario.NombreUsuario, usuario.CorreoElectronico, usuario.Contrasena, usuario.IdRol, 
                (SELECT direccion.Direccion FROM direccion WHERE direccion.IdCliente = cliente.IdCliente LIMIT 1) as Direccion 
                FROM cliente 
                JOIN usuario ON cliente.IdUsuario = usuario.IdUsuario";
$rsClientes = mysqli_query($conexion, $sqlClientes);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Gestión de Clientes - SPORTFLEXX</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../estilos/stylesAdmin.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
<?php
include_once "navbar_admin.php";
?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Clientes</h1>
                    <button class="btn btn-success mb-3" id="addClientBtn" data-bs-toggle="modal" data-bs-target="#modalCliente" onclick="clearForm()">Nuevo Cliente</button>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Lista de Clientes
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatablesSimple" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID Usuario</th>
                                            <th>Nombre Usuario</th>
                                            <th>Correo Electrónico</th>
                                            <th>Contraseña</th>
                                            <th>ID Rol</th>
                                            <th>ID Cliente</th>
                                            <th>Nombre</th>
                                            <th>Apellido</th>
                                            <th>Sexo</th>
                                            <th>Fecha de Nacimiento</th>
                                            <th>Teléfono</th>
                                            <th>DNI</th>
                                            <th>Dirección</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($cliente = mysqli_fetch_assoc($rsClientes)) : ?>
                                        <tr>
                                            <td><?php echo $cliente['IdUsuario']; ?></td>
                                            <td><?php echo $cliente['NombreUsuario']; ?></td>
                                            <td><?php echo $cliente['CorreoElectronico']; ?></td>
                                            <td><?php echo $cliente['Contrasena']; ?></td>
                                            <td><?php echo $cliente['IdRol']; ?></td>
                                            <td><?php echo $cliente['IdCliente']; ?></td>
                                            <td><?php echo $cliente['Nombre']; ?></td>
                                            <td><?php echo $cliente['Apellido']; ?></td>
                                            <td><?php echo $cliente['Sexo']; ?></td>
                                            <td><?php echo $cliente['FechaNacimiento']; ?></td>
                                            <td><?php echo $cliente['Telefono']; ?></td>
                                            <td><?php echo $cliente['Dni']; ?></td>
                                            <td><?php echo $cliente['Direccion']; ?></td>
                                            <td>
                                                <button class="btn btn-warning edit-btn" data-bs-toggle="modal" data-bs-target="#modalCliente" data-cliente='<?php echo json_encode($cliente); ?>'>Editar</button>
                                                <button class="btn btn-danger delete-btn" data-id="<?php echo $cliente['IdCliente']; ?>">Eliminar</button>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php
            include_once "footer_Admin.php";
            ?>
        </div>
    </div>

    <!-- Modal for Add/Edit Form -->
    <div class="modal fade" id="modalCliente" tabindex="-1" aria-labelledby="modalClienteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalClienteLabel">Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="cliente-form" method="post" action="RegistrarCliente.php">
                        <input type="hidden" id="IdCliente" name="IdCliente" value="0">
                        <div class="mb-3">
                            <label for="cliente-IdUsuario">ID Usuario:</label>
                            <input type="number" id="cliente-IdUsuario" name="IdUsuario" class="form-control" required>
                            <span id="errorcliente-IdUsuario" class="text-danger"></span>
                        </div>
                        <div class="mb-3">
                            <label for="cliente-NombreUsuario">Nombre Usuario:</label>
                            <input type="text" id="cliente-NombreUsuario" name="NombreUsuario" class="form-control"
                                required>
                            <span id="errorcliente-NombreUsuario" class="text-danger"></span>
                        </div>
                        <div class="mb-3">
                            <label for="cliente-CorreoElectronico">Correo Electrónico:</label>
                            <input type="email" id="cliente-CorreoElectronico" name="CorreoElectronico"
                                class="form-control" required>
                            <span id="errorcliente-CorreoElectronico" class="text-danger"></span>
                        </div>
                        <div class="mb-3">
                            <label for="cliente-Contrasena">Contraseña:</label>
                            <input type="text" id="cliente-Contrasena" name="Contrasena" class="form-control" required>
                            <span id="errorcliente-Contrasena" class="text-danger"></span>
                        </div>
                        <div class="mb-3">
                            <label for="cliente-IdRol">ID Rol:</label>
                            <input type="number" id="cliente-IdRol" name="IdRol" class="form-control" required>
                            <span id="errorcliente-IdRol" class="text-danger"></span>
                        </div>
                        <div class="mb-3">
                            <label for="cliente-Nombre">Nombre:</label>
                            <input type="text" id="cliente-Nombre" name="Nombre" class="form-control" required>
                            <span id="errorcliente-Nombre" class="text-danger"></span>
                        </div>
                        <div class="mb-3">
                            <label for="cliente-Apellido">Apellido:</label>
                            <input type="text" id="cliente-Apellido" name="Apellido" class="form-control" required>
                            <span id="errorcliente-Apellido" class="text-danger"></span>
                        </div>
                        <div class="mb-3">
                            <label for="cliente-Sexo">Sexo:</label>
                            <select id="cliente-Sexo" name="Sexo" class="form-control" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="male">Masculino</option>
                                <option value="female">Femenino</option>
                            </select>
                            <span id="errorcliente-Sexo" class="text-danger"></span>
                        </div>
                        <div class="mb-3">
                            <label for="cliente-FechaNacimiento">Fecha de Nacimiento:</label>
                            <input type="date" id="cliente-FechaNacimiento" name="FechaNacimiento" class="form-control"
                                required>
                            <span id="errorcliente-FechaNacimiento" class="text-danger"></span>
                        </div>
                        <div class="mb-3">
                            <label for="cliente-Telefono">Teléfono:</label>
                            <input type="text" id="cliente-Telefono" name="Telefono" class="form-control" required>
                            <span id="errorcliente-Telefono" class="text-danger"></span>
                        </div>
                        <div class="mb-3">
                            <label for="cliente-Dni">DNI:</label>
                            <input type="text" id="cliente-Dni" name="Dni" class="form-control" required>
                            <span id="errorcliente-Dni" class="text-danger"></span>
                        </div>
                        <div class="mb-3">
                            <label for="cliente-Direccion">Dirección:</label>
                            <input type="text" id="cliente-Direccion" name="Direccion" class="form-control" required>
                            <span id="errorcliente-Direccion" class="text-danger"></span>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Guardar Cliente</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="../assets/demo/chart-area-demo.js"></script>
    <script src="../assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="../js/datatables-simple-demo.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Mostrar datos en el formulario al hacer clic en Editar
            const editButtons = document.querySelectorAll(".edit-btn");
            editButtons.forEach(button => {
                button.addEventListener("click", function () {
                    const cliente = JSON.parse(this.getAttribute("data-cliente"));
                    document.getElementById("IdCliente").value = cliente.IdCliente;
                    document.getElementById("cliente-IdUsuario").value = cliente.IdUsuario;
                    document.getElementById("cliente-NombreUsuario").value = cliente.NombreUsuario;
                    document.getElementById("cliente-CorreoElectronico").value = cliente.CorreoElectronico;
                    document.getElementById("cliente-Contrasena").value = cliente.Contrasena;
                    document.getElementById("cliente-IdRol").value = cliente.IdRol;
                    document.getElementById("cliente-Nombre").value = cliente.Nombre;
                    document.getElementById("cliente-Apellido").value = cliente.Apellido;
                    document.getElementById("cliente-Sexo").value = cliente.Sexo;
                    document.getElementById("cliente-FechaNacimiento").value = cliente.FechaNacimiento;
                    document.getElementById("cliente-Telefono").value = cliente.Telefono;
                    document.getElementById("cliente-Dni").value = cliente.Dni;
                    document.getElementById("cliente-Direccion").value = cliente.Direccion;
                    document.getElementById("cliente-form").action = "EditarCliente.php";
                });
            });

            const deleteButtons = document.querySelectorAll(".delete-btn");
            deleteButtons.forEach(button => {
                button.addEventListener("click", function () {
                    const idCliente = this.getAttribute("data-id");
                    if (confirm("¿Estás seguro de que deseas eliminar este cliente?")) {
                        window.location.href = "EliminarCliente.php?id=" + idCliente;
                    }
                });
            });

            document.getElementById("addClientBtn").addEventListener("click", function () {
                clearForm();
                document.getElementById("cliente-form").action = "RegistrarCliente.php";
            });

            function clearForm() {
                document.getElementById("IdCliente").value = "0";
                document.getElementById("cliente-IdUsuario").value = "";
                document.getElementById("cliente-NombreUsuario").value = "";
                document.getElementById("cliente-CorreoElectronico").value = "";
                document.getElementById("cliente-Contrasena").value = "";
                document.getElementById("cliente-IdRol").value = "";
                document.getElementById("cliente-Nombre").value = "";
                document.getElementById("cliente-Apellido").value = "";
                document.getElementById("cliente-Sexo").value = "";
                document.getElementById("cliente-FechaNacimiento").value = "";
                document.getElementById("cliente-Telefono").value = "";
                document.getElementById("cliente-Dni").value = "";
                document.getElementById("cliente-Direccion").value = "";
            }

            function validateInput(input, regex, errorMsg) {
                const value = input.value;
                const errorSpan = document.getElementById(`error${input.id}`);
                if (!regex.test(value)) {
                    errorSpan.textContent = errorMsg;
                    input.classList.add('is-invalid');
                } else {
                    errorSpan.textContent = '';
                    input.classList.remove('is-invalid');
                }
            }

            const validations = [{
                id: "cliente-IdUsuario",
                regex: /^\d+$/,
                errorMsg: "ID Usuario inválido (solo números)"
            },
            {
                id: "cliente-NombreUsuario",
                regex: /^[a-zA-Z0-9]+$/,
                errorMsg: "Nombre de usuario inválido"
            },
            {
                id: "cliente-CorreoElectronico",
                regex: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                errorMsg: "Correo electrónico inválido"
            },
            {
                id: "cliente-Contrasena",
                regex: /^.{6,}$/,
                errorMsg: "Contraseña inválida (mínimo 6 caracteres)"
            },
            {
                id: "cliente-IdRol",
                regex: /^\d+$/,
                errorMsg: "ID Rol inválido (solo números)"
            },
            {
                id: "cliente-Nombre",
                regex: /^[a-zA-Z\s]+$/,
                errorMsg: "Nombre inválido (solo letras y espacios)"
            },
            {
                id: "cliente-Apellido",
                regex: /^[a-zA-Z\s]+$/,
                errorMsg: "Apellido inválido (solo letras y espacios)"
            },
            {
                id: "cliente-Sexo",
                regex: /^(male|female)$/,
                errorMsg: "Sexo inválido (solo 'male' o 'female')"
            },
            {
                id: "cliente-Telefono",
                regex: /^\d+$/,
                errorMsg: "Teléfono inválido (solo números)"
            },
            {
                id: "cliente-Dni",
                regex: /^\d+$/,
                errorMsg: "DNI inválido (solo números)"
            },
            {
                id: "cliente-Direccion",
                regex: /^[a-zA-Z0-9\s]+$/,
                errorMsg: "Dirección inválida (letras, números y espacios)"
            }
            ];

            validations.forEach(validation => {
                const inputElement = document.getElementById(validation.id);
                if (inputElement) {
                    inputElement.addEventListener("input", function () {
                        validateInput(this, validation.regex, validation.errorMsg);
                    });
                }
            });
        });
    </script>
</body>

</html>
