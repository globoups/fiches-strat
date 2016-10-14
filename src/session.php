<?php
require_once("config.php");
session_start();
$now = time();

if (isset($_SESSION["expirationTime"]) && $now > $_SESSION["expirationTime"]) {
    session_unset();
    session_destroy();
    session_start();
}

$_SESSION["expirationTime"] = $now + $GLOBALS["sessionDuration"];
?>