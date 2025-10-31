<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . "/../../classes/Database.php");
require_once(__DIR__ . "/../../classes/admin.php");


$database = new Database();
$db = $database->getConnection();

$admin = new Admin($db);
$_SESSION=[];
session_destroy();

header("Location: ../login.php?message=" . urlencode("You have been logged out successfully."));
exit;

?>