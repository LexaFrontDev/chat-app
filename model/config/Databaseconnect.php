<?php


class DatabaseConnect {
    private $localhost = 'localhost';
    private $loginUser = 'root';
    private $nameBd = 'chat_app';
    private $password = '';
    private $conn;

    public function __construct() {
        try {
            $dsn = "mysql:host=$this->localhost;dbname=$this->nameBd";
            $this->conn = new PDO($dsn, $this->loginUser, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $message =  "Подключение успешно!";
        } catch (PDOException $e) {
            echo "Ошибка подключения: " . $e->getMessage();
        }
    }




    public function getConnection() {
        return $this->conn;
    }

    public function insert($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $this->conn->lastInsertId();
    }


    public function searchUsersByName($table, $column, $value) {
        $sql = 'SELECT * FROM ' . $table . ' WHERE ' . $column . ' LIKE :search';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['search' => '%' . $value . '%']);
        return $stmt->fetchAll();
    }


}

