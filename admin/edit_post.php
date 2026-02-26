<?php
session_start();
include("../includes/connect.php");

/* ===== allow only admin ===== */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../signin.php");
    exit();
}

$type = $_GET['type'] ?? '';
$id   = (int)($_GET['id'] ?? 0);

if(!$id || !in_array($type,['blog','vlog'])){
    die("Invalid request");
}

/* ===== LOAD POST ===== */
if($type === 'blog'){
    $sql = "
      SELECT Blog_ID AS id, Title, Content, Image
      FROM Blog WHERE Blog_ID=?
    ";
}else{
    $sql = "
      SELECT Vlog_ID AS id, Title, Content, Thumbnail AS Image, Video_Path
      FROM Vlog WHERE Vlog_ID=?
    ";
}

$stmt = sqlsrv_query($conn,$sql,[$id]);
$post = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC);

if(!$post){
    die("Post not found");
}

/* ===== UPDATE ===== */
if($_SERVER['REQUEST_METHOD']==='POST'){
    $title   = trim($_POST['title']);
    $content = trim($_POST['content']);

    if($type === 'blog'){
        sqlsrv_query($conn,"
          UPDATE Blog
          SET Title=?, Content=?
          WHERE Blog_ID=?
        ",[$title,$content,$id]);
    }else{
        sqlsrv_query($conn,"
          UPDATE Vlog
          SET Title=?, Content=?
          WHERE Vlog_ID=?
        ",[$title,$content,$id]);
    }

    header("Location: admin_posts.php?updated=1");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Edit Post</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
  <h3>✏️ Edit <?= strtoupper($type) ?></h3>
  <a href="admin_posts.php" class="btn btn-secondary mb-3">← Back</a>

  <form method="post">

    <div class="mb-3">
      <label>Title</label>
      <input class="form-control" name="title"
             value="<?= htmlspecialchars($post['Title']) ?>" required>
    </div>

    <div class="mb-3">
      <label>Content</label>
      <textarea class="form-control" rows="8"
                name="content"
                required><?= htmlspecialchars($post['Content']) ?></textarea>
    </div>

    <?php if(!empty($post['Image'])): ?>
      <img src="../uploads/<?= $type==='blog'?'blogs':'vlogs' ?>/<?= htmlspecialchars($post['Image']) ?>"
           style="max-height:200px"
           class="rounded mb-3">
    <?php endif; ?>

    <button class="btn btn-success">💾 Save</button>

  </form>
</div>

</body>
</html>
