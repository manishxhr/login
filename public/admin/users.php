<?php
// session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . "/../../classes/Database.php");
require_once(__DIR__ . "/../../classes/Admin.php");

$database = new Database();
$db = $database->getConnection();

$admin = new Admin($db);
$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : '';
$users = $admin->getAllUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Users</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
   
                    <?php if(isset($message)): ?>
                        <div class="alert alert-info text-center"><?= $message ?></div>
                    <?php endif; ?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">All Users</h2>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <!-- <th>Password</th> -->
                    <th>Role</th>
                    <th>Status</th>
                    <th>Created On</th>
                    <th colspan="2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id']) ?></td>
                    <td><?= htmlspecialchars($user['name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['role']) ?></td>
<td>
<div class="form-check form-switch">
  <input class="form-check-input" type="checkbox" 
         <?= $user['status'] === 'active' ? 'checked' : '' ?> 
         onchange="window.location.href='updatestatus.php?id=<?= $user['id'] ?>&status=' + (this.checked ? 'active' : 'inactive')">
</div>
</td>


                    
                    <td><?= htmlspecialchars($user['created_at']) ?></td>
                    <td><a href="update.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="delete.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-danger" 
                        onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                                </td>

                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
