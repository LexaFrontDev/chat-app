<?php


class GetData {
    private $db;

    public function __construct(DatabaseConnect $db) {
        $this->db = $db->getConnection();
    }

    public function fetchData($table) {
        $stmt = $this->db->query("SELECT * FROM $table");
        return $stmt->fetchAll();
    }
}
?>
