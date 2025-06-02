<?php
// client/models/clientModel.php

class clientModel
{
    private $conn;
    private $table = "clients";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllClients()
    {
        $query = "SELECT * FROM" . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
