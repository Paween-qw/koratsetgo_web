<?php
session_start();
include("../includes/connect.php");
$userId = $_SESSION['user_id'];

$msg = '';

if($_POST){
  if($_POST['new'] === $_POST['confirm']){
    sqlsrv_query($conn,
      "UPDATE [User] SET Password=? WHERE User_ID=?",
      [password_hash($_POST['new'],PASSWORD_DEFAULT),$userId]
    );
    $msg = "Password updated";
  }else{
    $msg = "Password not match";
  }
}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
<h3>Change Password</h3>

<?php if($msg): ?>
<div class="alert alert-info"><?= $msg ?></div>
<?php endif; ?>

<form method="POST">
  <input class="form-control mb-2" type="password" name="new" placeholder="New password">
  <input class="form-control mb-2" type="password" name="confirm" placeholder="Confirm password">
  <button class="btn btn-danger">Change</button>
</form>
</div>
</body>
</html>
