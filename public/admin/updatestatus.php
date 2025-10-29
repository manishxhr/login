<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . "/../../classes/Database.php");
require_once(__DIR__ . "/../../classes/Admin.php");

$database = new Database();
$db = $database->getConnection();

$admin = new Admin($db);

if(isset($_GET['id'])){
    $id=filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
    $user= $admin->getById($id);
    $status=$user['status'];
    if($admin->updatestatus($id,$status)){
        $message="user status updated";
        header("location:users.php?message=".urlencode($message));
        exit;
    }
    else{
        echo "failed to update status";
    }
}

?>