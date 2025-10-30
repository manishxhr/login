<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . "/../classes/Database.php");
require_once(__DIR__ . "/../classes/Admin.php");

$database = new Database();
$db = $database->getConnection();

$admin = new Admin($db);

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit;
}

$id = $_SESSION['id'];
$user = $admin->getById($id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <div class="container mt-5">
    <div class="card shadow-sm mx-auto" style="max-width: 500px;">
      <div class="card-body text-center">
        <h4 class="card-title mb-3 text-primary">Welcome, <?= htmlspecialchars($_SESSION['name']) ?></h4>
        <hr>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        <p><strong>Role:</strong> <?= htmlspecialchars($user['role']) ?></p>
        <p><strong>Status:</strong> 
          <span class="badge <?= $user['status'] === 'active' ? 'bg-success' : 'bg-danger' ?>">
            <?= ucfirst($user['status']) ?>
          </span>
        </p>
        <p><strong>Joined:</strong> <?= htmlspecialchars($user['created_at']) ?></p>
        <a href="updateuser.php?id=<?= $user['id']?>" class="btn btn-warning mt-3">update</a>
        <a href="logout.php" class="btn btn-danger mt-3">Logout</a>
      </div>
    </div>
  </div>

</body>
</html>
