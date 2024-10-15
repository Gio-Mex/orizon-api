<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header(('Access-Control-Max-Age: 3600'));
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Authorization, X-Requested-With');

$parentDir = dirname(__DIR__, 2);
require_once $parentDir . '/config/Database.php';
require_once $parentDir . '/models/Country.php';
require_once $parentDir . '/functions/globalHelpers.php';

$database = new Database();
$db = $database->connect();

$country = new Country($db);

// Get ID from params
$id = $_GET['id'] ?? null;

if ($id) {
  // Set ID to delete
  $country->id = $id;

  // Delete country
  if ($country->delete()) {
    // Set response code - 200 ok
    jsonResponse(array('message' => 'Country deleted'), 200);
  } else {
    // Set response code - 503 service unavailable
    jsonResponse(array('message' => 'Service unavailable or country does not exist on the database.'), 503);
  }
} else {
  // Set response code - 400 bad request
  jsonResponse(array('message' => 'Unable to delete country. Specify country id.'), 400);
}
?>