<?php
if (!defined('DB_SERVER')) {
    require_once("../initialize.php");
}

class DBConnection {
    
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'scbc_db'; // Database name should be in quotes
    
    public $conn;
    
    public function __construct() {
        if (!isset($this->conn)) {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
            
            // Check for connection error
            if ($this->conn->connect_error) {
                die('Connection failed: ' . $this->conn->connect_error);
            }
        }
    }

    public function getConnection() {
        return $this->conn; // Return the connection object
    }

    public function __destruct() {
        if ($this->conn) {
            $this->conn->close(); // Ensure connection is only closed if it exists
        }
    }
}
?>
