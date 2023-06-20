<?php

class Database
{
    private $host;
    private $username;
    private $password;
    private $database;
    private $conn;

    public function __construct($host, $username, $password, $database)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }

    public function connect()
    {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->conn->connect_error) {
            die("Eita, tivemos um erro na conexão :(" . $this->conn->connect_error);
        }
    }

    public function close()
    {
        $this->conn->close();
    }

    public function executeQuery($query)
    {
        $result = $this->conn->query($query);

        if (!$result) {
            die("Opa! Não achamos essa conta " . $this->conn->error);
        }

        return $result;
    }
}


$host = "localhost";
$username = "root";
$password = "";
$database = "adormeser";

$databaseObj = new Database($host, $username, $password, $database);
$databaseObj->connect();