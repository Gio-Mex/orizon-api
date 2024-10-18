<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: PUT');
header(('Access-Control-Max-Age: 3600'));
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

$parentDir = dirname(__DIR__, 2);
require_once $parentDir . '/config/Database.php';
require_once $parentDir . '/models/Travel.php';
require_once $parentDir . '/functions/globalHelpers.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate travel object
$travel = new Travel($db);

// Get ID from params
$id = $_GET['id'] ?? null;

if (isset($_GET['id'])) {
  // Set ID to delete
  $travel->travel_id = $id;
  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Set travel property values
  if (!empty($data->departure) && !empty($data->destination) && !empty($data->available_places)) {
    $travel->departure_id = $data->departure;
    $travel->destination_id = $data->destination;
    $travel->available_places = $data->available_places;

    // Update travel
    if ($travel->update($data->departure, $data->destination)) {
      // Set response code - 200 ok
      jsonResponse(array('message' => 'Travel updated'), 200);
    } else {
      // Set response code - 503 service unavailable
      jsonResponse(array('message' => 'Service unavailable or data does not exist on the database.'), 503);
    }
  } else {
    // Set response code - 400 bad request
    jsonResponse(array('message' => 'Unable to update travel. Data is incomplete.'), 400);
  }
} else {
    // Set response code - 400 bad request
    jsonResponse(array('message' => 'Unable to update travel. Specify travel id.'), 400);
}
?>
