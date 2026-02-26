<?php
session_start();
include("../includes/connect.php");

/* อนุญาตเฉพาะ admin */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../signin.php");
    exit();
}

/* ดึง blog + owner */
$sql = "
SELECT 
  B.Blog_ID AS id,
  B.Title,
  B.Create_At,
  U.Full_Name,
  'blog' AS type
FROM Blog B
JOIN [User] U ON B.User_ID = U.User_ID

UNION ALL

SELECT
  V.Vlog_ID AS id,
  V.Title,
  V.Create_At,
  U.Full_Name,
  'vlog' AS type
FROM Vlog V
JOIN [User] U ON V.User_ID = U.User_ID

ORDER BY Create_At DESC
";

$stmt = sqlsrv_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
<title>Post Management</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
  
<?php if(isset($_GET['deleted'])): ?>
  <div class="alert alert-success alert-dismissible fade show">
    🗑️ ลบโพสต์เรียบร้อยแล้ว
    <button class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endif; ?>

<?php if(isset($_GET['updated'])): ?>
  <div class="alert alert-primary alert-dismissible fade show">
    ✏️ แก้ไขโพสต์เรียบร้อยแล้ว
    <button class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endif; ?>


  <h2>📝 Post Management</h2>
  <a href="dashboard.php" class="btn btn-secondary mb-3">← Back</a>

  <table class="table table-bordered table-striped bg-white">
    <thead class="table-dark">
      <tr>
        <th>Type</th>
        <th>Title</th>
        <th>Owner</th>
        <th>Created</th>
        <th width="160">Action</th>
      </tr>
    </thead>
    <tbody>

    <?php while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) { ?>
      <tr>
        <td><?= strtoupper($row['type']) ?></td>
        <td><?= htmlspecialchars($row['Title']) ?></td>
        <td><?= htmlspecialchars($row['Full_Name']) ?></td>
        <td><?= $row['Create_At']->format('Y-m-d') ?></td>
        <td>
          <a href="edit_post.php?type=<?= $row['type'] ?>&id=<?= $row['id'] ?>"
             class="btn btn-warning btn-sm">✏️ Edit</a>

          <a href="delete_post.php?type=<?= $row['type'] ?>&id=<?= $row['id'] ?>"
             class="btn btn-danger btn-sm"
             onclick="return confirm('Delete this post?')">🗑 Delete</a>
        </td>
      </tr>
    <?php } ?>

    </tbody>
  </table>
</div>

</body>
</html>
