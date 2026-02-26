<?php
session_start();
include("../includes/connect.php");

if(!isset($_SESSION['user_id'])){
  header("Location: ../signin.php");
  exit;
}

$userId = $_SESSION['user_id'];

$q = sqlsrv_query($conn,"
  SELECT Full_Name, Email, Phone_No, Gender, Date_of_Birth
  FROM [User]
  WHERE User_ID=?
",[$userId]);

$user = sqlsrv_fetch_array($q,SQLSRV_FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Edit Profile</title>
<link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container mt-5">
  <div class="card p-4 shadow-sm">
    <h4 class="mb-4">✏️ Edit Profile</h4>

    <form action="update_profile.php" method="post">

      <div class="mb-3">
        <label>Full Name</label>
        <input type="text"
               name="full_name"
               class="form-control"
               value="<?= htmlspecialchars($user['Full_Name']) ?>"
               required>
      </div>

      <div class="mb-3">
        <label>Email</label>
        <input type="email"
               name="email"
               class="form-control"
               value="<?= htmlspecialchars($user['Email']) ?>"
               required>
      </div>

      <div class="mb-3">
        <label>Phone</label>
        <input type="text"
               name="phone"
               class="form-control"
               value="<?= htmlspecialchars($user['Phone_No']) ?>">
      </div>

      <div class="mb-3">
        <label>Gender</label>
        <select name="gender" class="form-control">
          <option value="Male"   <?= $user['Gender']=='Male'?'selected':'' ?>>Male</option>
          <option value="Female" <?= $user['Gender']=='Female'?'selected':'' ?>>Female</option>
          <option value="Other"  <?= $user['Gender']=='Other'?'selected':'' ?>>Other</option>
        </select>
      </div>

      <div class="mb-4">
        <label>Date of Birth</label>
        <input type="date"
               name="dob"
               class="form-control"
               value="<?= $user['Date_of_Birth']? $user['Date_of_Birth']->format('Y-m-d'):'' ?>">
      </div>

      <button class="btn btn-primary">Save Changes</button>
      <a href="dashboard.php" class="btn btn-secondary">Cancel</a>

    </form>
  </div>
</div>

</body>
</html>
