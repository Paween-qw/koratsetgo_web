<?php
session_start();
include("../includes/connect.php");
$userId = $_SESSION['user_id'];

$sql = "
SELECT V.Vlog_ID,V.Title,V.Create_At,
       COUNT(VL.Like_ID) likes
FROM Vlog V
LEFT JOIN VlogLike VL ON V.Vlog_ID=VL.Vlog_ID
WHERE V.User_ID=?
GROUP BY V.Vlog_ID,V.Title,V.Create_At
ORDER BY V.Create_At DESC
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
<h3>My Vlogs</h3>

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
