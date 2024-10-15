<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$parentDir = dirname(__DIR__, 2);
require_once $parentDir . '/config/Database.php';
require_once $parentDir . '/models/Country.php';
require_once $parentDir . '/functions/globalHelpers.php';

$database = new Database();
$db = $database->connect();

$country = new Country($db);

// Read countries
$result = $country->read();
$num = $result->rowCount();

if ($num > 0) {
  // Country array
  $country_arr['data'] = array();

  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $country_arr['data'][] = array(
      'country_id' => $row['country_id'],
      'name' => $row['name']
      );
    }
    // Set response code - 200 ok
    jsonResponse($country_arr, 200);
} else {
    // Set response code - 404 not found
    jsonResponse(array('message' => 'No country found'), 404);
}
?>
