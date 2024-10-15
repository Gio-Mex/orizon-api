<?php
// Centralized functions
function cleanInput($data) {
    return htmlspecialchars(strip_tags($data));
}

function executeQuery($conn, $query, $params) {
    $stmt = $conn->prepare($query);
    $stmt->execute($params);
    return $stmt;
}

function jsonResponse($data, $httpCode) {
    http_response_code($httpCode);
    echo json_encode($data);
}

function getRow($conn, $column, $table, $param) {
    $param = cleanInput($param);
    $query = "SELECT $column FROM $table WHERE UPPER($column) = UPPER(:param)";
    $stmt = executeQuery($conn, $query, [":param" => $param]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
