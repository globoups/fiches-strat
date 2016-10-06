<?php
if(!(isset($_GET["boss"]) && isset($_GET["difficulty"]) && isset($_GET["role"]))) {
	header("Location: .");
	die();
}

require_once("src/CardPage.php");

$bossKey = $_GET["boss"];
$difficultyKey = $_GET["difficulty"];
$roleKey = $_GET["role"];

$page = new CardPage($bossKey, $difficultyKey, $roleKey);
$page->render();
?>