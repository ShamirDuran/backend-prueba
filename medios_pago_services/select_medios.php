<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
include_once("../database/connection.php");

$response = array();

try {
    $conn = getConnection();

    $stmt = $conn->prepare("SELECT * FROM medios_pago");
    $stmt->execute();


    if ($stmt->rowCount() > 0) {
        $response['error'] = false;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $response['data'][] = $row;
        }
    } else {
        $response['error'] = true;
        $response['message'] = "No hay medios de pago registrados";
    }

} catch (PDOException $e) {
    $response['error'] = true;
    $response['message'] = "Error al obtener medios de pago" . $sql . "<br>" . $e->getMessage();
}

echo json_encode($response);