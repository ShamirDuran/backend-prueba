<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
include_once("../database/connection.php");

$response = array();

try {
    $conn = getConnection();

    $stmt = $conn->prepare("SELECT * FROM condiciones_pago");
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $response['error'] = false;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $response['data'][] = $row;
        }
    } else {
        $response['error'] = true;
        $response['message'] = "No hay condiciones de pago registradas";
    }

    $conn = null;

} catch (PDOException $e) {
    $response['error'] = true;
    $response['message'] = "Error al obtener condiciones pago " . $sql . "<br>" . $e->getMessage();
}

echo json_encode($response);