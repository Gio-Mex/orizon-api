<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header("Access-Control-Allow-Methods: POST");
header(('Access-Control-Max-Age: 3600'));
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');

$parentDir = dirname(__DIR__, 2);
require_once $parentDir . '/config/Database.php';
require_once $parentDir . '/models/Country.php';
require_once $parentDir . '/functions/globalHelpers.php';

$database = new Database();
$db = $database->connect();

$country = new Country($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Set country property values
if (!empty($data->name)) {
  $country->name = $data->name;

  // Create country
  if ($country->create()) {
    // Set response code - 201 created
    jsonResponse(array('message' => 'Country created'), 201);
  } else {
    // Set response code - 503 service unavailable
    jsonResponse(array('message' => 'Service unavailable or country already exists on the database.'), 503);
  }
} else {
  // Set response code - 400 bad request
  jsonResponse(array('message' => 'Unable to create country. Data is incomplete.'), 400);
}
?>
