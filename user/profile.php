<?php
session_start();
include("../includes/connect.php");

if(!isset($_SESSION['user_id'])){
  header("Location: ../signin.php");
  exit;
}

$userId = $_SESSION['user_id'];

if($_POST){
  sqlsrv_query($conn,
    "UPDATE [User] SET Full_Name=?, Email=? WHERE User_ID=?",
    [$_POST['name'],$_POST['email'],$userId]
  );
}

$q = sqlsrv_query($conn,
  "SELECT Full_Name,Email FROM [User] WHERE User_ID=?",
  [$userId]
);
$user = sqlsrv_fetch_array($q,SQLSRV_FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
  <h3>Edit Profile</h3>

  <form method="POST">
    <div class="mb-3">
      <label>Full Name</label>
      <input class="form-control" name="name"
        value="<?= htmlspecialchars($user['Full_Name']) ?>">
    </div>

    <div class="mb-3">
      <label>Email</label>
      <input class="form-control" name="email"
        value="<?= htmlspecialchars($user['Email']) ?>">
    </div>

    <button class="btn btn-primary">Save</button>
  </form>
</div>
</body>
</html>
