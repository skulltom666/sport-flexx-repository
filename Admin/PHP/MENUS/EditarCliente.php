<?php
require_once(__DIR__ . "/../coneccion/conector.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validar y limpiar los datos de entrada aquí

    // ID del cliente
    $idCliente = intval($_POST['IdCliente'] ?? 0);
    $idUsuario = intval($_POST['IdUsuario'] ?? 0);

    // Datos del usuario
    $nombreUsuario = $_POST['NombreUsuario'] ?? '';
    $correoElectronico = $_POST['CorreoElectronico'] ?? '';
    $contrasena = $_POST['Contrasena'] ?? ''; // Puede estar vacío si no se cambia
    $idRol = intval($_POST['IdRol'] ?? 0);

    // Datos del cliente
    $nombre = $_POST['Nombre'] ?? '';
    $apellido = $_POST['Apellido'] ?? '';
    $sexo = $_POST['Sexo'] ?? '';
    $fechaNacimiento = $_POST['FechaNacimiento'] ?? '';
    $telefono = $_POST['Telefono'] ?? '';
    $dni = intval($_POST['Dni'] ?? 1);

    // Datos de la dirección
    $direccion = $_POST['Direccion'] ?? '';

    $obj = new Conectar();
    $conexion = $obj->getConexion();

    try {
        // Iniciar una transacción
        $conexion->begin_transaction();

        // Actualizar los datos del usuario
        if (!empty($contrasena)) {
            // Si se proporciona una nueva contraseña, se hashea y se actualiza
            $hashedPassword = password_hash($contrasena, PASSWORD_DEFAULT);
            $sqlUsuario = "UPDATE usuario SET NombreUsuario = ?, CorreoElectronico = ?, Contrasena = ?, IdRol = ? WHERE IdUsuario = ?";
            $stmtUsuario = $conexion->prepare($sqlUsuario);
            $stmtUsuario->bind_param("sssii", $nombreUsuario, $correoElectronico, $hashedPassword, $idRol, $idUsuario);
        } else {
            // Si no se proporciona una nueva contraseña, no actualizarla
            $sqlUsuario = "UPDATE usuario SET NombreUsuario = ?, CorreoElectronico = ?, IdRol = ? WHERE IdUsuario = ?";
            $stmtUsuario = $conexion->prepare($sqlUsuario);
            $stmtUsuario->bind_param("ssii", $nombreUsuario, $correoElectronico, $idRol, $idUsuario);
        }
        $stmtUsuario->execute();
        $stmtUsuario->close();

        // Actualizar los datos del cliente
        $sqlCliente = "UPDATE cliente SET Nombre = ?, Apellido = ?, Sexo = ?, FechaNacimiento = ?, Telefono = ?, Dni = ? WHERE IdCliente = ?";
        $stmtCliente = $conexion->prepare($sqlCliente);
        $stmtCliente->bind_param("ssssssi", $nombre, $apellido, $sexo, $fechaNacimiento, $telefono, $dni, $idCliente);
        $stmtCliente->execute();
        $stmtCliente->close();

        // Actualizar los datos de la dirección
        $sqlDireccion = "UPDATE direccion SET Direccion = ? WHERE IdCliente = ?";
        $stmtDireccion = $conexion->prepare($sqlDireccion);
        $stmtDireccion->bind_param("si", $direccion, $idCliente);
        $stmtDireccion->execute();
        $stmtDireccion->close();

        // Confirmar la transacción
        $conexion->commit();
        $obj->closeConexion();
        header("Location: clientes.php");
        exit();
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conexion->rollback();
        echo "Error en la base de datos: " . $e->getMessage();
    }

    $obj->closeConexion();
} else {
    echo "Solicitud no válida.";
}
?>