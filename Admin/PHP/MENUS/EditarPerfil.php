<?php
require_once(__DIR__ . "/../coneccion/conector.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $idCliente = isset($_POST['IdCliente']) ? intval($_POST['IdCliente']) : 0;
    $idUsuario = isset($_POST['IdUsuario']) ? intval($_POST['IdUsuario']) : 0;
    $idDireccion = isset($_POST['IdDireccion']) ? intval($_POST['IdDireccion']) : 0;
    $nombreUsuario = isset($_POST['NombreUsuarioModal']) ? $_POST['NombreUsuarioModal'] : '';
    $correoElectronico = isset($_POST['CorreoElectronicoModal']) ? $_POST['CorreoElectronicoModal'] : '';
    $contrasena = isset($_POST['ContrasenaModal']) ? $_POST['ContrasenaModal'] : '';
    $nombre = isset($_POST['NombreModal']) ? $_POST['NombreModal'] : '';
    $apellido = isset($_POST['ApellidoModal']) ? $_POST['ApellidoModal'] : '';
    $sexo = isset($_POST['SexoModal']) ? $_POST['SexoModal'] : '';
    $fechaNacimiento = isset($_POST['FechaNacimientoModal']) ? $_POST['FechaNacimientoModal'] : '';
    $telefono = isset($_POST['TelefonoModal']) ? $_POST['TelefonoModal'] : '';
    $dni = isset($_POST['DniModal']) ? intval($_POST['DniModal']) : 0;
    $departamento = isset($_POST['DepartamentoModal']) ? $_POST['DepartamentoModal'] : '';
    $provincia = isset($_POST['ProvinciaModal']) ? $_POST['ProvinciaModal'] : '';
    $distrito = isset($_POST['DistritoModal']) ? $_POST['DistritoModal'] : '';
    $direccion = isset($_POST['DireccionModal']) ? $_POST['DireccionModal'] : '';

    $obj = new Conectar();
    $conexion = $obj->getConexion();

    try {
        $conexion->begin_transaction();
        
        $sqlUsuario = "UPDATE usuario SET NombreUsuario = ?, CorreoElectronico = ?, Contrasena = ? WHERE IdUsuario = ?";
        $stmtUsuario = $conexion->prepare($sqlUsuario);
        if (!$stmtUsuario) {
            throw new Exception("Error en la preparación de la consulta del usuario: " . $conexion->error);
        }
        $stmtUsuario->bind_param("sssi", $nombreUsuario, $correoElectronico, $contrasena, $idUsuario);

        $sqlCliente = "UPDATE cliente SET Nombre = ?, Apellido = ?, Sexo = ?, FechaNacimiento = ?, Telefono = ?, Dni = ? WHERE IdUsuario = ?";
        $stmtCliente = $conexion->prepare($sqlCliente);
        if (!$stmtCliente) {
            throw new Exception("Error en la preparación de la consulta del cliente: " . $conexion->error);
        }
        $stmtCliente->bind_param("sssssii", $nombre, $apellido, $sexo, $fechaNacimiento, $telefono, $dni, $idUsuario);

        $sqlDireccion = "UPDATE direccion SET Departamento = ?, Provincia = ?, Distrito = ?, Direccion = ? WHERE IdDireccion = ?";
        $stmtDireccion = $conexion->prepare($sqlDireccion);
        if (!$stmtDireccion) {
            throw new Exception("Error en la preparación de la consulta de la dirección: " . $conexion->error);
        }
        $stmtDireccion->bind_param("ssssi", $departamento, $provincia, $distrito, $direccion, $idDireccion);

        if ($stmtUsuario->execute() && $stmtCliente->execute() && $stmtDireccion->execute()) {
            $conexion->commit();
            echo json_encode(["status" => "success"]);
        } else {
            $conexion->rollback();
            throw new Exception("Error al ejecutar la consulta: " . $stmtUsuario->error . ", " . $stmtCliente->error . " y " . $stmtDireccion->error);
        }
        $stmtUsuario->close();
        $stmtCliente->close();
        $stmtDireccion->close();
    } catch (Exception $e) {
        $conexion->rollback();
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }

    $obj->closeConexion();
} else {
    echo json_encode(["status" => "error", "message" => "Solicitud no válida."]);
}
?>
