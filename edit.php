<?php
if (!(isset($_GET["boss"]) && isset($_GET["difficulty"]) && isset($_GET["role"]))) {
	header("Location: .");
	die();
}

require_once("src/EditionPage.php");

$bossKey = $_GET["boss"];
$difficultyKey = $_GET["difficulty"];
$roleKey = $_GET["role"];

$page = new EditionPage($bossKey, $difficultyKey, $roleKey);
$page->render();
?>