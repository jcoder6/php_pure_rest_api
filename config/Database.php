<?php

class Database {
    // DB Params
    private $host = 'localhost';
    private $username = 'root';
    private $db_pass = '';
    private $db_name = 'myblog';
    private $conn;

    //DB Connect
    public function connect() {
        $this->conn = null;
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db_name;

        try {
            $this->conn = new PDO($dsn, $this->username, $this->db_pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }

        return $this->conn;
    }
}