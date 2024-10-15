<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header(('Access-Control-Max-Age: 3600'));
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Authorization, X-Requested-With');

include_once './../config/Database.php';
include_once './../models/Travel.php';
include_once './../functions/globalHelpers.php';

$database = new Database();
$db = $database->connect();

$travel = new Travel($db);

// Get ID from params
$id = $_GET['id'] ?? null;

if ($id) {
  // Set ID to delete
  $travel->travel_id = $id;
  // Delete travel
  if ($travel->delete()) {
    // Set response code - 200 ok
    jsonResponse(array('message' => 'Travel deleted'), 200);
  } else {
    // Set response code - 503 service unavailable
    jsonResponse(array('message' => 'Service unavailable or travel does not exist on the database.'), 503);
  }
} else {
  // Set response code - 400 bad request
  jsonResponse(array('message' => 'Unable to delete travel. Specify travel id.'), 400);
}
?>