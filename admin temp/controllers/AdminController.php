<?php
// admin/controllers/AdminController.php
namespace Admin;

include_once __DIR__ . "/../../config/database.php";
include_once __DIR__ . "/../models/AdminModel.php";

class AdminController
{
    private $db;
    private $adminModel;

    public function __construct()
    {
        $database = new \Database(); // Use global Database class
        $this->db = $database->getConnection();
        $this->adminModel = new \AdminModel($this->db); // Use global AdminModel class
    }

    public function getAdminData()
    {
        return $this->adminModel->getAllData();
    }
}
