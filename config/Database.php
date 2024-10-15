<?php
class Database
{
  // Dtabase config
  private $host = '127.0.0.1';
  private $db_name = 'orizon_offers';
  private $user = 'root';
  private $password = '';
  public $conn;


  // Database connection
  public function connect()
  {
    $this->conn = null;
    try {
      $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' .
        $this->db_name, $this->user, $this->password);
      $this->conn->exec("set names utf8");
    } catch (PDOException $e) {
      echo 'Connection Error: ' . $e->getMessage();
    }
    return $this->conn;
  }
}
?>