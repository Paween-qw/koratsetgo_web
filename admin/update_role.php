<?php
session_start();
include("../includes/connect.php");

if($_SESSION['role'] != 'admin'){
    header("Location: ../signin.php");
    exit();
}

$user_id = $_POST['user_id'];
$role = $_POST['role'];

$sql = "UPDATE [User] SET Role=? WHERE User_ID=?";
$params = [$role, $user_id];

sqlsrv_query($conn, $sql, $params);

header("Location: users.php");
exit();
