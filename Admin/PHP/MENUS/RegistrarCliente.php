<?php
require_once(__DIR__ . "/../coneccion/conector.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validar y limpiar los datos de entrada
    $nombreUsuario = trim($_POST['NombreUsuario'] ?? '');
    $correoElectronico = filter_var($_POST['CorreoElectronico'] ?? '', FILTER_SANITIZE_EMAIL);
    $contrasena = trim($_POST['Contrasena'] ?? ''); 
    $idRol = intval($_POST['IdRol'] ?? 0);

    $nombre = trim($_POST['Nombre'] ?? '');
    $apellido = trim($_POST['Apellido'] ?? '');
    $sexo = trim($_POST['Sexo'] ?? '');
    $fechaNacimiento = trim($_POST['FechaNacimiento'] ?? '');
    $telefono = trim($_POST['Telefono'] ?? '');
    $dni = !empty($_POST['Dni']) ? intval($_POST['Dni']) : null;

    $direccion = trim($_POST['Direccion'] ?? '');

    // Validaciones básicas
    if (empty($nombreUsuario) || empty($correoElectronico) || empty($contrasena) || empty($nombre) || empty($direccion)) {
        echo "Por favor, completa todos los campos requeridos.";
        exit();
    }

    if (!filter_var($correoElectronico, FILTER_VALIDATE_EMAIL)) {
        echo "Correo electrónico no válido.";
        exit();
    }

    $obj = new Conectar();
    $conexion = $obj->getConexion();

    try {
        // Iniciar la transacción
        $conexion->begin_transaction();

        // Codificación de la contraseña
        $contrasenaCodificada = password_hash($contrasena, PASSWORD_DEFAULT);

        // Insertar nuevo usuario
        $sqlUsuario = "INSERT INTO usuario (NombreUsuario, CorreoElectronico, Contrasena, IdRol) VALUES (?, ?, ?, ?)";
        $stmtUsuario = $conexion->prepare($sqlUsuario);
        $stmtUsuario->bind_param("sssi", $nombreUsuario, $correoElectronico, $contrasenaCodificada, $idRol);
        $stmtUsuario->execute();
        $idUsuario = $conexion->insert_id;  // Obtenemos el IdUsuario autoincremental generado
        $stmtUsuario->close();

        // Insertar nuevo cliente
        $sqlCliente = "INSERT INTO cliente (IdUsuario, Nombre, Apellido, Sexo, FechaNacimiento, Telefono, Dni) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmtCliente = $conexion->prepare($sqlCliente);
        $stmtCliente->bind_param("isssssi", $idUsuario, $nombre, $apellido, $sexo, $fechaNacimiento, $telefono, $dni);
        $stmtCliente->execute();
        $idCliente = $conexion->insert_id;
        $stmtCliente->close();

        // Insertar nueva dirección
        $sqlDireccion = "INSERT INTO direccion (IdCliente, Direccion) VALUES (?, ?)";
        $stmtDireccion = $conexion->prepare($sqlDireccion);
        $stmtDireccion->bind_param("is", $idCliente, $direccion);
        $stmtDireccion->execute();
        $stmtDireccion->close();

        // Confirmar la transacción
        $conexion->commit();
        $obj->closeConexion();

        // Redirigir a la página de clientes después de un registro exitoso
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