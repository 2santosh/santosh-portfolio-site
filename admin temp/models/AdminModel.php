<?php
class AdminModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllData()
    {
        if ($this->db) {  // Check if connection is successful
            $stmt = $this->db->prepare("SELECT * FROM your_table"); // Replace with your actual query
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            throw new Exception("Database connection is not established.");
        }
    }
}
