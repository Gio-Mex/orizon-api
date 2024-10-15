<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header("Access-Control-Allow-Methods: POST");
header(('Access-Control-Max-Age: 3600'));
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');

$parentDir = dirname(__DIR__, 2);
require_once $parentDir . '/config/Database.php';
require_once $parentDir . '/models/Travel.php';
require_once $parentDir . '/functions/globalHelpers.php';

$database = new Database();
$db = $database->connect();

$travel = new Travel($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Set travel property values
if (!empty($data->departure) && !empty($data->destination)
  && !empty($data->available_places)) {
  $travel->departure_id = $data->departure;
  $travel->destination_id = $data->destination;
  $travel->available_places = $data->available_places;

  // Create travel
  if ($travel->create($travel->departure_id, $travel->destination_id,
   $travel->available_places)) {
    // Set response code - 201 created
    jsonResponse(array('message' => 'Travel created'), 201);
  } else {
    // Set response code - 503 service unavailable
    jsonResponse(array('message' => 
    'Service unavailable or countries do not exist on the database.'), 503);
  }
} else {
  // Set response code - 400 bad request
  jsonResponse(array('message' => 
  'Unable to create travel. Data is incomplete.'), 400);
}
?>