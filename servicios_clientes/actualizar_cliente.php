<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
include_once("../database/connection.php");

$response = array();

try {

    if (
        isset($_POST['id']) &&
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
    ) { // todos los parametros se encuentran en la request

        $id = $_POST['id'];
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


        $conn = getConnection();

        // verificacion existencia cliente
        $stmt = $conn->prepare("SELECT * FROM clientes WHERE documento=$documento");
        $stmt->execute();

        if ($stmt->rowCount() < 1) {
            $response['error'] = true;
            $response['message'] = "El cliente con documento $documento no se encuentra registado.";
            echo json_encode($response);
            return;
        }

        $stmt = $conn->prepare("UPDATE clientes SET `documento`=:documento, `nombre`=:nombre, `apellido1`=:apellido1, `apellido2`=:apellido2,
                `direccion`=:direccion, `telefono`=:telefono, `correo_electronico`=:correo_electronico, `ciudad`=:ciudad, `valor_cupo`=:valor_cupo,
                `estado`=:estado, `condicion_pago_id`=:condicion_pago_id, `medio_pago_id`=:medio_pago_id
                 WHERE `id`=:id
             ");

        $stmt->bindParam(":id", $id);
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
        $response['message'] = "Cliente con documento $documento actualizado correctamente";
    }

} catch (PDOException $e) {
    $response['error'] = true;
    $response['message'] = "Error al tratar de actualizar al cliente: " . $sql . "<br>" . $e->getMessage();
}

echo json_encode($response);