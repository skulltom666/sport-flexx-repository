<?php
require_once(__DIR__ . "/../../Admin/PHP/coneccion/conector.php");
session_start();
if (!isset($_SESSION['IdUsuario'])) {
    header("Location: ../PHP/login2.php");
    exit();
}

$IdUsuario = $_SESSION['IdUsuario'];

$obj = new Conectar();
$conexion = $obj->getConexion();

$sql = "SELECT cliente.*, usuario.NombreUsuario, usuario.CorreoElectronico, usuario.Contrasena, direccion.Direccion 
        FROM cliente 
        INNER JOIN usuario ON cliente.IdUsuario = usuario.IdUsuario 
        LEFT JOIN direccion ON cliente.IdCliente = direccion.IdCliente
        WHERE cliente.IdUsuario = ?";

$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "i", $IdUsuario);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($resultado);

mysqli_stmt_close($stmt);
mysqli_close($conexion);
?>  

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../EstilosMenus/EstilosMenu.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/js/bootstrap.min.js" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
    .navbar-custom{
        background: #DCC6E0;
    }
    body{
        background: #F5EEFC;
    }
    footer{
        background: #C8A2C8;
    }
</style>
<body>
<?php include_once "navbar.php"; ?>
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center" style="padding: 20px">
                        <h3 class="text-themecolor">Mi Perfil</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-xlg-3">
                        <div class="card">
                            <div class="card-body">
                                <center class="m-t-30">
                                    <img src="../ImagenQuienesSomos/imagen3.jpg" class="img-circle profile-img"
                                        width="130" />
                                    <h4 class="card-subtitle mt-2">Cliente</h4>
                                </center>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-xlg-9">
                        <div class="card">
                            <div class="card-body">
                                <?php if ($row) { ?>
                                <form class="form-horizontal form-material mx-2" id="profileForm" action="guardar_perfil.php" method="POST">
                                    <div class="row mb-3">
                                        <label for="editNombreUsuario" class="col-md-3 col-form-label">Nombre
                                            Usuario:</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="editNombreUsuario"
                                                name="NombreUsuario" value="<?php echo $row['NombreUsuario']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="editCorreoElectronico" class="col-md-3 col-form-label">Correo
                                            Electrónico:</label>
                                        <div class="col-md-9">
                                            <input type="email" class="form-control" id="editCorreoElectronico"
                                                name="CorreoElectronico"
                                                value="<?php echo $row['CorreoElectronico']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="editContrasena" class="col-md-3 col-form-label">Contraseña:</label>
                                        <div class="col-md-9">
                                            <input type="password" class="form-control" id="editContrasena"
                                                name="Contrasena" value="<?php echo $row['Contrasena']; ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="editNombre" class="col-md-3 col-form-label">Nombre:</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="editNombre" name="Nombre"
                                                value="<?php echo $row['Nombre']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="editApellido" class="col-md-3 col-form-label">Apellido:</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="editApellido" name="Apellido"
                                                value="<?php echo $row['Apellido']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="editSexo" class="col-md-3 col-form-label">Sexo:</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="editSexo" name="Sexo"
                                                value="<?php echo $row['Sexo']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="editFechaNacimiento" class="col-md-3 col-form-label">Fecha de
                                            Nacimiento:</label>
                                        <div class="col-md-9">
                                            <input type="date" class="form-control" id="editFechaNacimiento"
                                                name="FechaNacimiento" value="<?php echo $row['FechaNacimiento']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="editTelefono" class="col-md-3 col-form-label">Teléfono:</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="editTelefono" name="Telefono"
                                                value="<?php echo $row['Telefono']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="editDni" class="col-md-3 col-form-label">DNI:</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="editDni" name="Dni"
                                                value="<?php echo $row['Dni']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="editDireccion" class="col-md-3 col-form-label">Dirección:</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="editDireccion" name="Direccion"
                                                value="<?php echo isset($row['Direccion']) ? $row['Direccion'] : ''; ?>" readonly>
                                        </div>
                                    </div>
                                    <button type="button" id="editButton">Editar Datos</button>
                                </form>
                                <?php } else { ?>
                                <div class="alert alert-danger" role="alert">
                                    No se encontraron datos del usuario.
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <BR></BR>
<?php include_once "footer.php"; ?>

<script>
document.getElementById('editButton').addEventListener('click', function () {
    let inputs = document.querySelectorAll('#profileForm input');
    let isEditable = inputs[0].readOnly;

    inputs.forEach(input => {
        input.readOnly = !input.readOnly;
    });

    this.textContent = isEditable ? 'Guardar Cambios' : 'Editar Datos';

    if (!isEditable) {
        document.getElementById('profileForm').submit();
    }
});
</script>


</body>
</html>
