<?php
$parentDir = dirname(__DIR__, 1);
require_once $parentDir . '/functions/globalHelpers.php';

class Travel
{
  private $conn;
  private $table = 'travels';

  public $travel_id;
  public $departure_id;
  public $destination_id;
  public $available_places;

  public function __construct($db) {
    $this->conn = $db;
  }
  // Travel centralized methods
  private function getCountryIdByName($countryName) {
    $query = 'SELECT country_id FROM countries WHERE UPPER(name) = UPPER(:name)';
    $stmt = executeQuery($this->conn, $query, [':name' => cleanInput($countryName)]);
    $result = $stmt->fetch();
    return $result['country_id'] ?? null;
    }

  private function sortTravels($sort) {
    switch ($sort) {
      case 'departure-asc':
        return 'ORDER BY c1.name ASC';
        break;
      case 'departure-desc':
        return 'ORDER BY c1.name DESC';
        break;
      case 'destination-asc':
        return 'ORDER BY c2.name ASC';
        break;
      case 'destination-desc':
        return 'ORDER BY c2.name DESC';
        break;
      case 'available-asc':
        return 'ORDER BY ' . $this->table . '.available_places ASC';
        break;
      case 'available-desc':
        return 'ORDER BY ' . $this->table . '.available_places DESC';
        break;
      }
    }

  // Read travels
  public function read($sort) {
    $order = $this->sortTravels($sort);
    $query = 'SELECT ' . $this->table . '.travel_id, 
      c1.name AS departure_country, 
      c2.name AS destination_country, 
      ' . $this->table . '.available_places 
      FROM ' . $this->table . '
      LEFT JOIN countries c1 ON ' . $this->table . '.departure_id = c1.country_id
      LEFT JOIN countries c2 ON ' . $this->table . '.destination_id = c2.country_id ' . $order;
        
      return executeQuery($this->conn, $query, []);
      }

  // Get travel by route
  public function getTravelByRoute($departure, $destination, $sort) {
    $order = $this->sortTravels($sort);
    $query = 'SELECT ' . $this->table . '.travel_id, 
      c1.name AS departure_country, 
      c2.name AS destination_country, 
      ' . $this->table . '.available_places 
      FROM ' . $this->table . '
      LEFT JOIN countries c1 ON ' . $this->table . '.departure_id = c1.country_id
      LEFT JOIN countries c2 ON ' . $this->table . '.destination_id = c2.country_id
      WHERE UPPER(c1.name) = UPPER(:departure) AND UPPER(c2.name) = UPPER(:destination) ' . $order;
      return executeQuery($this->conn, $query, [
        ':departure' => cleanInput($departure),
        ':destination' => cleanInput($destination)
        ]);
    }

  // Create travel
  public function create($departure, $destination, $available_places) {
    $departureId = $this->getCountryIdByName($departure);
    $destinationId = $this->getCountryIdByName($destination);

      if ($departureId === null || $destinationId === null) {
          return false;
      }

        $query = 'INSERT INTO ' . $this->table . '
          SET departure_id = :departure_id,
              destination_id = :destination_id,
              available_places = :available_places';

          return executeQuery($this->conn, $query, [
          ':departure_id' => $departureId,
          ':destination_id' => $destinationId,
          ':available_places' => cleanInput($available_places)
      ]);
    }

  // Update travel
  public function update($departure, $destination) {
    if (!getRow($this->conn, 'travel_id', $this->table, $this->travel_id)) {
          return false;
    }
      $departureId = $this->getCountryIdByName($departure);
      $destinationId = $this->getCountryIdByName($destination);

    if ($departureId === null || $destinationId === null) {
          return false;
    }

    $query = 'UPDATE ' . $this->table . '
      SET departure_id = :departure_id,
          destination_id = :destination_id,
          available_places = :available_places
      WHERE travel_id = :travel_id';

      return executeQuery($this->conn, $query, [
          ':travel_id' => cleanInput($this->travel_id),
          ':departure_id' => $departureId,
          ':destination_id' => $destinationId,
          ':available_places' => cleanInput($this->available_places)
      ]);
  }

  // Delete travel
  public function delete() {
    if (!getRow($this->conn, 'travel_id', $this->table, $this->travel_id)) {
        return false;
    }
    $query = 'DELETE FROM ' . $this->table . ' WHERE travel_id = :travel_id';
    return executeQuery($this->conn, $query, [':travel_id' => cleanInput($this->travel_id)]);
  }
}
?>