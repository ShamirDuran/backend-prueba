<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
include_once("../database/connection.php");

$response = array();

try {
    if (
        isset($_POST['documento']) &&
        isset($_POST['nombre']) &&
        isset($_POST['apellido1']) &&
        isset($_POST['apellido2']) &&
        isset($_POST['direccion']) &&
        isset($_POST['telefono']) &&
        isset($_POST['correo_electronico']) &&
        isset($_POST['ciudad']) &&
        isset($_POST['valor_cupo']) &&
        isset($_POST['estado']) &&
        isset($_POST['condicion_pago_id']) &&
        isset($_POST['medio_pago_id'])
    ) { // all parameters are in the request

        $documento = $_POST['documento'];
        $nombre = $_POST['nombre'];
        $apellido1 = $_POST['apellido1'];
        $apellido2 = $_POST['apellido2'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];
        $correo_electronico = $_POST['correo_electronico'];
        $ciudad = $_POST['ciudad'];
        $valor_cupo = $_POST['valor_cupo'];
        $estado = $_POST['estado'];
        $condicion_pago_id = $_POST['condicion_pago_id'];
        $medio_pago_id = $_POST['medio_pago_id'];

        // abrir conexion a la db
        $conn = getConnection();

        // verificacion cliente unico
        $stmt = $conn->prepare("SELECT * FROM clientes WHERE documento=$documento");
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $response['error'] = true;
            $response['message'] = "El cliente con documento $documento ya se encuentra registrado.";
            echo json_encode($response);
            return;
        }

        $stmt = $conn->prepare("INSERT INTO clientes (documento, nombre, apellido1, apellido2, direccion, telefono, correo_electronico, ciudad, valor_cupo, estado, condicion_pago_id, medio_pago_id) 
                                         VALUES (:documento, :nombre, :apellido1, :apellido2, :direccion, :telefono, :correo_electronico, :ciudad, :valor_cupo, :estado, :condicion_pago_id, :medio_pago_id)");

        $stmt->bindParam(":documento", $documento);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":apellido1", $apellido1);
        $stmt->bindParam(":apellido2", $apellido2);
        $stmt->bindParam(":direccion", $direccion);
        $stmt->bindParam(":telefono", $telefono);
        $stmt->bindParam(":correo_electronico", $correo_electronico);
        $stmt->bindParam(":ciudad", $ciudad);
        $stmt->bindParam(":valor_cupo", $valor_cupo);
        $stmt->bindParam(":estado", $estado);
        $stmt->bindParam(":condicion_pago_id", $condicion_pago_id);
        $stmt->bindParam(":medio_pago_id", $medio_pago_id);
        $stmt->execute();

        $conn = null;

        $response['error'] = false;
        $response['message'] = "Usuario registrado correctamente";

    } else { // FALTAN PARAMETROS
        $response['error'] = true;
        $response['message'] = "Algunos parametros requeridos no se encuentran en la peticion";
    }

} catch (PDOException $e) {
    $response['error'] = true;
    $response['message'] = "Error al tratar de crear un nuevo usuario: " . $sql . "<br>" . $e->getMessage();
}

echo json_encode($response);