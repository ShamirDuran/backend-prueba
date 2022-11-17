<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
include_once("../database/connection.php");

$response = array();

try {
    $conn = getConnection();

    $stmt = $conn->prepare("SELECT * FROM clientes");
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $response['error'] = false;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $response['data'][] = $row;
        }
    } else {
        $response['error'] = true;
        $response['message'] = "No hay clientes registrados";
    }

    $conn = null;

} catch (PDOException $e) {
    $response['error'] = true;
    $response['message'] = "Error al obtener clientes: " . $sql . "<br>" . $e->getMessage();
}

echo json_encode($response);