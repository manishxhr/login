<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . "/../classes/Database.php");
require_once(__DIR__ . "/../classes/Admin.php");

$database= new Database();
$db= $database->getConnection();

$user= new User($db);

if(isset($_GET['id'])){
    $id=$_GET['id'];
    $currentuser= $user->getById($id);

    if(!$currentuser){
        echo "no user found";
    }
}
else{
    echo "no id found";
}

// handle form request
if($_SERVER['REQUEST_METHOD']=='POST'){
    $name= filter_var($_POST['name']);
    $email= filter_var($_POST['email']);
    $password= filter_var($_POST['password']);
    $role= filter_var($_POST['role']);
    $status= filter_var($_POST['status']);

    if($user->updateProfile($id,$name,$email,$password,$role,$status)){
         $message="user updated succesful";
         header("location:userdashboard.php?message=".urlencode($message));
         exit;
    }
    else{
         echo "failed to update<br>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>update user data</title>
</head>
<body>
    <h1>update your profile</h1>

    <form action="" method="post">
        <input type="text" name="name" value=<?= $currentuser['name'] ?> >
        <input type="text" name="email"value=<?= $currentuser['email'] ?>>
        <input type="text" name="password"value=<?= $currentuser['password'] ?>>
        <input type="text" name="role"value=<?= $currentuser['role'] ?>>
        <input type="text" name="status"value=<?= $currentuser['status'] ?>>
        <button>submit</button>
    </form>
    
</body>
</html>