<?php 

class Dbh {

    private $servername = "localhost";
    private $username = "root";
    private $password = null;
    private $database = "bees";

    protected function connect() {
        $dsn = 'mysql:host=' . $this->servername . ';dbname=' . $this->database;
        $pdo = new PDO($dsn, $this->username, $this->password);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    }
    
}
?>