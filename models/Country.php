<?php
$parentDir = dirname(__DIR__, 1);
require_once $parentDir . '/functions/globalHelpers.php';

class Country
{
  private $conn;
  private $table = 'countries';

  public $id;
  public $name;

  public function __construct($db) {
    $this->conn = $db;
  }

  // Read Countries
  public function read() {
    $query = 'SELECT * FROM ' . $this->table;
    return executeQuery($this->conn, $query, []);
  }

  // Create country
  public function create() {
    // Check if country already exists
    if (!empty(getRow($this->conn, 'name', $this->table, $this->name))) {
      return false;
    }
    // Create query
    $query = 'INSERT INTO ' . $this->table . ' SET name = CONCAT(UPPER(SUBSTRING(:name, 1, 1)), LOWER(SUBSTRING(:name, 2)))';
    return executeQuery($this->conn, $query, [':name' => cleanInput($this->name)]);
  }

  // Update country
  public function update() {
    // Check if country already exists
    if (empty(getRow($this->conn, 'country_id', $this->table, $this->id))) {
      return false;
  }  
  // Create query
  $query = 'UPDATE ' . $this->table . ' SET name = CONCAT(UPPER(SUBSTRING(:name, 1, 1)), LOWER(SUBSTRING(:name, 2))) WHERE country_id = :country_id';
  return executeQuery($this->conn, $query, [
    ':country_id' => cleanInput($this->id),
    ':name' => cleanInput($this->name)
    ]);
  }

  // Delete country
  public function delete() {
    // Check if country exists
    if (!getRow($this->conn, 'country_id', $this->table, $this->id)) {
      return false;
    }
    // Create query
    $query = 'DELETE FROM ' . $this->table . ' WHERE country_id = :country_id';
    return executeQuery($this->conn, $query, [':country_id' => cleanInput($this->id)]);
  }
}
?>