<?php
require_once("src/page/RegisterPage.php");

$page = new RegisterPage();

if (isset($_POST["reg-username"]) && isset($_POST["reg-password"])) {
    $page->register($_POST["reg-username"], $_POST["reg-password"]);
}

$page->render();
?>