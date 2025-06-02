<?php
// client/index.php
include 'controllers/ClientController.php';
$controller = new ClientController();
$clients = $controller->getClients();

include 'views/header.php';
include 'views/home.php';
include 'views/footer.php';
