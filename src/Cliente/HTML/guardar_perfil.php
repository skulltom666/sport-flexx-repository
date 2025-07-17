<?php
require_once(__DIR__ . "/../../Admin/PHP/coneccion/conector.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $IdUsuario = $_SESSION['IdUsuario'];
    
    $NombreUsuario = $_POST['NombreUsuario'];
    $CorreoElectronico = $_POST['CorreoElectronico'];
    $Contrasena = $_POST['Contrasena'];
    $Nombre = $_POST['Nombre'];
    $Apellido = $_POST['Apellido'];
    $Sexo = $_POST['Sexo'];
    $FechaNacimiento = $_POST['FechaNacimiento'];
    $Telefono = $_POST['Telefono'];
    $Dni = $_POST['Dni'];
    $Direccion = $_POST['Direccion'];

    $obj = new Conectar();
    $conexion = $obj->getConexion();

    $sqlUsuario = "UPDATE usuario SET NombreUsuario = ?, CorreoElectronico = ?, Contrasena = ? WHERE IdUsuario = ?";
    $stmtUsuario = mysqli_prepare($conexion, $sqlUsuario);
    mysqli_stmt_bind_param($stmtUsuario, "sssi", $NombreUsuario, $CorreoElectronico, $Contrasena, $IdUsuario);
    mysqli_stmt_execute($stmtUsuario);

    $sqlCliente = "UPDATE cliente SET Nombre = ?, Apellido = ?, Sexo = ?, FechaNacimiento = ?, Telefono = ?, Dni = ? WHERE IdUsuario = ?";
    $stmtCliente = mysqli_prepare($conexion, $sqlCliente);
    mysqli_stmt_bind_param($stmtCliente, "ssssssi", $Nombre, $Apellido, $Sexo, $FechaNacimiento, $Telefono, $Dni, $IdUsuario);
    mysqli_stmt_execute($stmtCliente);

    $sqlDireccion = "UPDATE direccion SET Direccion = ? WHERE IdCliente = (SELECT IdCliente FROM cliente WHERE IdUsuario = ?)";
    $stmtDireccion = mysqli_prepare($conexion, $sqlDireccion);
    mysqli_stmt_bind_param($stmtDireccion, "si", $Direccion, $IdUsuario);
    mysqli_stmt_execute($stmtDireccion);

    mysqli_stmt_close($stmtUsuario);
    mysqli_stmt_close($stmtCliente);
    mysqli_stmt_close($stmtDireccion);
    mysqli_close($conexion);

    header("Location: MiPerfil.php");
    exit();
}
?>
