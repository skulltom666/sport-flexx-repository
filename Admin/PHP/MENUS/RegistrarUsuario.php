<?php
session_start();
require_once(__DIR__ . "/../coneccion/conector.php");

if (isset($_POST['btnRegistrar'])) {
    $requiredFields = [
        'NombreUsuario', 'CorreoElectronico', 'Contrasena', 'ConfirmarContrasena',
        'Nombre', 'Apellido', 'Sexo', 'FechaNacimiento', 'Telefono', 'Dni', 'Direccion'
    ];

    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $_SESSION['mensaje'] = "Por favor, complete todos los campos.";
            header("Location: ../../Cliente/PHP/login2.php"); 
            exit();
        }
    }

    // Asignación de variables
    $nombreUsuario = $_POST['NombreUsuario'];
    $correoElectronico = $_POST['CorreoElectronico'];
    $contrasena = $_POST['Contrasena'];
    $confirmarContrasena = $_POST['ConfirmarContrasena'];
    $nombre = $_POST['Nombre'];
    $apellido = $_POST['Apellido'];
    $sexo = $_POST['Sexo'];
    $fechaNacimiento = $_POST['FechaNacimiento'];
    $telefono = $_POST['Telefono'];
    $dni = $_POST['Dni'];
    $direccion = $_POST['Direccion'];

    // Verificar si las contraseñas coinciden
    if ($contrasena !== $confirmarContrasena) {
        $_SESSION['mensaje'] = "Las contraseñas no coinciden.";
        header("Location: ../../Cliente/PHP/login2.php");
        exit();
    }

    // Cifrar la contraseña
    $contrasenaHasheada = password_hash($contrasena, PASSWORD_DEFAULT);

    // Conexión a la base de datos
    $obj = new Conectar();
    $conexion = $obj->getConexion();

    $conexion->begin_transaction();

    try {
        // Insertar en la tabla usuario
        $stmtUsuario = $conexion->prepare(
            "INSERT INTO usuario (NombreUsuario, CorreoElectronico, Contrasena, IdRol) VALUES (?, ?, ?, 2)"
        );
        $stmtUsuario->bind_param("sss", $nombreUsuario, $correoElectronico, $contrasenaHasheada);

        if (!$stmtUsuario->execute()) {
            throw new Exception("Error al insertar en la tabla usuario: " . $stmtUsuario->error);
        }

        $idUsuario = $conexion->insert_id;
        $stmtUsuario->close();

        // Insertar en la tabla cliente
        $stmtCliente = $conexion->prepare(
            "INSERT INTO cliente (IdUsuario, Nombre, Apellido, Sexo, FechaNacimiento, Telefono, Dni) 
            VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $stmtCliente->bind_param(
            "issssss",
            $idUsuario, $nombre, $apellido, $sexo, $fechaNacimiento, $telefono, $dni
        );

        if (!$stmtCliente->execute()) {
            throw new Exception("Error al insertar en la tabla cliente: " . $stmtCliente->error);
        }

        $idCliente = $conexion->insert_id;
        $stmtCliente->close();

        $stmtDireccion = $conexion->prepare(
            "INSERT INTO direccion (IdCliente, Direccion) VALUES (?, ?)"
        );
        $stmtDireccion->bind_param("is", $idCliente, $direccion);

        if (!$stmtDireccion->execute()) {
            throw new Exception("Error al insertar en la tabla direccion: " . $stmtDireccion->error);
        }
        $stmtDireccion->close();

        $conexion->commit();

        $_SESSION['mensaje'] = "Registro exitoso. Inicie sesión.";
        header("Location: ../../Cliente/PHP/login2.php");
        exit();
    } catch (Exception $e) {
        $conexion->rollback();
        $_SESSION['mensaje'] = "Error: " . $e->getMessage();
        header("Location: ../../Cliente/PHP/login2.php");
        exit();
    }

    $conexion->close();
}
?>