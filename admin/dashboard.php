<?php
session_start();
include("../includes/connect.php");

// Protect admin page
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    die("403 Forbidden - Admin only");
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard - KoratSetGo</title>
<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <h2>Admin Dashboard</h2>
    <p>Welcome, <b><?= htmlspecialchars($_SESSION['name']) ?></b></p>

    <div class="card mt-4">
        <div class="card-body">
            <h5>System Menu</h5>
            <ul>
            <ul>
                <li><a href="users.php">👥 Manage Users</a></li>
                <li><a href="admin_posts.php">📝 Manage Posts</a></li>
                <li><a href="../index.php">🏠 Back to Website</a></li>
                <li><a href="../logout.php">🚪 Logout</a></li>
            </ul>
            </ul>
        </div>
    </div>

</div>

</body>
</html>
