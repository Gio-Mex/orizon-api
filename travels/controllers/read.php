<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$parentDir = dirname(__DIR__, 2);
require_once $parentDir . '/config/Database.php';
require_once $parentDir . '/models/Travel.php';
require_once $parentDir . '/functions/globalHelpers.php';

$database = new Database();
$db = $database->connect();

$travel = new Travel($db);

// Get params
$departure = !empty($_GET['departure']) ? $_GET['departure'] : null;
$destination = !empty($_GET['destination']) ? $_GET['destination'] : null;
$sort = !empty($_GET['sort']) ? $_GET['sort'] : null;

function getData($result) {
  $travel_arr['data'] = array();
  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $travel_item = array(
      'travel_id' => $row['travel_id'],
      'departure' => ucfirst($row['departure_country']),
      'destination' => ucfirst($row['destination_country']),
      'available_places' => $row['available_places']
      );
    array_push($travel_arr['data'], $travel_item);
  }
  return $travel_arr;
}

// Read travels
if ($departure && $destination) {
  // Get travels by params
  $result = $travel->getTravelByRoute($departure, $destination, $sort);
  if ($result->rowCount() > 0) {
    // Set response code - 200 ok
    jsonResponse(getData($result), 200);
  } else {
    // Set response code - 404 not found
    jsonResponse(array('message' => 'No travel found'), 404);
  }
} else {
  // Read all travels
  $result = $travel->read($sort);
  if ($result->rowCount() > 0) {
    // Set response code - 200 ok
    jsonResponse(getData($result), 200);
  } else {
    // Set response code - 404 not found
    jsonResponse(array('message' => 'No travel found'), 404);
  }
}
?>