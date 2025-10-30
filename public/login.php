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

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);

    if ($user = $admin->login($email, $password)) {
        $message = "Login successful!";
        // You can redirect or start session here
        $_SESSION['name']=$user['name'];
        $_SESSION['role']=$user['role'];
        $_SESSION['id']=$user['id'];
        if($user['role']==='user'){
            $message = "Login successful!";
            header('location:userdashboard.php?message='.urlencode($message));
            exit;
        }
        else{
            $message = "Login successful!";
            header('location:admin/users.php?message='.urlencode($message));
            exit;

        }

    } else {
        $message = "Login failed! Check email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php
if(isset($_SESSION['name'])){
    echo $_SESSION['name']."<br>";
    echo $_SESSION['role'];
}
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Login</h3>

                    <?php if($message): ?>
                        <div class="alert alert-info text-center"><?= $message ?></div>
                    <?php endif; ?>

                    <form action="" method="post">
                        <div class="mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>

                    <p class="text-center mt-3">
                        <a href="register.php">Don't have an account? Register</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
