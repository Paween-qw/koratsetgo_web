<?php
session_start();
include("../includes/connect.php");
$userId = $_SESSION['user_id'];

$sql = "
SELECT B.Blog_ID,B.Title,B.Create_At,
       COUNT(BL.Like_ID) likes
FROM Blog B
LEFT JOIN BlogLike BL ON B.Blog_ID=BL.Blog_ID
WHERE B.User_ID=?
GROUP BY B.Blog_ID,B.Title,B.Create_At
ORDER BY B.Create_At DESC
";
$q = sqlsrv_query($conn,$sql,[$userId]);
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
<h3>My Blogs</h3>

<table class="table">
<tr>
  <th>Title</th>
  <th>Likes</th>
  <th>Date</th>
</tr>
<?php while($r=sqlsrv_fetch_array($q,SQLSRV_FETCH_ASSOC)): ?>
<tr>
  <td><?= htmlspecialchars($r['Title']) ?></td>
  <td><?= $r['likes'] ?></td>
  <td><?= $r['Create_At']->format('Y-m-d') ?></td>
</tr>
<?php endwhile; ?>
</table>
</div>
</body>
</html>
