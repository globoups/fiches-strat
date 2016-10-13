<?php
require_once("src/page/AuthenticatePage.php");

$page = new AuthenticatePage();

if (isset($_POST["auth-username"]) && isset($_POST["auth-password"])) {
    $page->authenticate($_POST["auth-username"], $_POST["auth-password"]);
}

$page->render();
?>