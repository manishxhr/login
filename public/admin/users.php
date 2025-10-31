<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . "/../../classes/Database.php");
require_once(__DIR__ . "/../../classes/Admin.php");

$database = new Database();
$db = $database->getConnection();
$admin = new Admin($db);

$message = $_GET['message'] ?? '';
$search = $_GET['searchcontent'] ?? '';

$users = !empty($search) ? $admin->searchUser($search) : $admin->getAllUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>All Users | Admin Panel</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body { background-color: #f4f6f8; font-family: 'Segoe UI', sans-serif; }
    .navbar { background-color: #0d6efd; }
    .navbar-brand, .nav-link { color: #fff !important; }
    .container-card { background: #fff; border-radius: 12px; padding: 30px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); }
    .table th, .table td { vertical-align: middle; }
    .btn-rounded { border-radius: 20px; padding: 6px 16px; }
    .search-bar input { border-radius: 20px; padding: 0.5rem 1rem; width: 250px; }
    .badge-role { font-size: 0.85rem; padding: 0.4em 0.6em; }
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-semibold" href="#">Admin Dashboard</a>
        <div class="d-flex ms-auto gap-2">
            <a href="create.php" class="btn btn-light btn-sm btn-rounded">+ Add User</a>
            <a href="logout.php" class="btn btn-dark btn-sm btn-rounded">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="container-card">

        <?php if ($message): ?>
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                <?= htmlspecialchars($message) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-semibold mb-0"><?= empty($search) ? "All Users" : "Search Results" ?></h3>
            <form class="d-flex search-bar" method="get">
                <input type="text" name="searchcontent" class="form-control me-2" placeholder="Search name/email" value="<?= htmlspecialchars($search) ?>">
                <button type="submit" class="btn btn-primary btn-rounded">Search</button>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Created On</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($users): ?>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id']) ?></td>
                            <td><?= htmlspecialchars($user['name']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td>
                                <span class="badge bg-<?= $user['role']==='admin' ? 'primary' : 'secondary' ?> badge-role">
                                    <?= ucfirst($user['role']) ?>
                                </span>
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox"
                                        <?= $user['status']==='active' ? 'checked' : '' ?>
                                        onchange="window.location.href='updatestatus.php?id=<?= $user['id'] ?>&status=' + (this.checked ? 'active' : 'inactive')">
                                </div>
                            </td>
                            <td><?= htmlspecialchars($user['created_at']) ?></td>
                            <td class="text-center">
                                <a href="update.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-warning btn-rounded">Edit</a>
                                <a href="delete.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-danger btn-rounded" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No users found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Auto dismiss alerts after 4 seconds
const alerts = document.querySelectorAll('.alert');
alerts.forEach(alert => {
    setTimeout(() => {
        alert.classList.remove('show');
        alert.classList.add('hide');
        alert.style.display = 'none';
    }, 4000);
});
</script>
</body>
</html>
