<?php
require_once(dirname(__FILE__) . "/../src/service/CardService.php");

$data = file_get_contents('php://input');

$service = new CardService();
$service->saveCard($data);
$service->printResponse();
?>