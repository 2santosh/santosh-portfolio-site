<?php
// client/controllers/ClientController.php
include_once "../../config/database.php";
include_once "../models/ClientModel.php";

class ClientController
{
    private $db;
    private $clientModel;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->clientModel = new ClientModel($this->db);
    }

    public function getClients()
    {
        return $this->clientModel->getAllClients();
    }
}
