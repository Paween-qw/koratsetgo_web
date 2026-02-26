<?php
session_start();
include("includes/connect.php");

$type = $_GET['type'] ?? '';
$id   = (int)($_GET['id'] ?? 0);

if (!$id || !in_array($type, ['blog','vlog'])) {
    header("Location: review.php");
    exit;
}

/* ================= LOAD MAIN DATA ================= */
if ($type === 'blog') {
    $stmt = sqlsrv_query(
        $conn,
        "SELECT B.*, U.Full_Name
         FROM Blog B
         JOIN [User] U ON B.User_ID = U.User_ID
         WHERE B.Blog_ID=?",
        [$id]
    );
} else {
    $stmt = sqlsrv_query(
        $conn,
        "SELECT V.*, U.Full_Name
         FROM Vlog V
         JOIN [User] U ON V.User_ID = U.User_ID
         WHERE V.Vlog_ID=?",
        [$id]
    );
}

$data = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
if (!$data) {
    header("Location: review.php");
    exit;
}

/* ================= LOAD BLOG IMAGES ================= */
$imgQ = null;
if ($type === 'blog') {
    $imgQ = sqlsrv_query(
        $conn,
        "SELECT Image_Path FROM BlogImage
         WHERE Blog_ID=?
         ORDER BY Image_ID ASC",
        [$id]
    );
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($data['Title']) ?> | KoratSetGo</title>

<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/fontawesome.css">

<style>
.detail-cover{
    width:100%;
    max-height:420px;
    object-fit:cover;
    border-radius:18px;
    box-shadow:0 15px 35px rgba(0,0,0,.35);
}
.gallery img{
    border-radius:12px;
    box-shadow:0 6px 18px rgba(0,0,0,.25);
}
</style>
</head>

<body class="bg-light">


<div class="container my-5">

    <!-- TITLE -->
    <h2 class="fw-bold mb-2">
        <?= htmlspecialchars($data['Title']) ?>
    </h2>

    <div class="text-muted mb-4">
        ✍️ <?= htmlspecialchars($data['Full_Name']) ?>
        · <?= date('d M Y', strtotime($data['Create_At']->format('Y-m-d'))) ?>
    </div>

    <!-- COVER IMAGE -->
    <?php if (!empty($data['Image'])): ?>
        <img src="uploads/blogs/<?= htmlspecialchars($data['Image']) ?>"
             class="detail-cover mb-4">
    <?php endif; ?>

    <!-- VLOG VIDEO -->
    <?php if ($type === 'vlog' && !empty($data['Video_Path'])): ?>
        <div class="ratio ratio-16x9 mb-4">
            <video controls>
                <source src="uploads/vlogs/<?= htmlspecialchars($data['Video_Path']) ?>"
                        type="video/mp4">
            </video>
        </div>
    <?php endif; ?>

    <!-- BLOG GALLERY -->
    <?php if ($type === 'blog' && $imgQ): ?>
        <div class="row g-3 gallery mb-4">
        <?php while($img = sqlsrv_fetch_array($imgQ, SQLSRV_FETCH_ASSOC)): ?>
            <div class="col-md-4">
                <img src="uploads/blogs/<?= htmlspecialchars($img['Image_Path']) ?>"
                     class="img-fluid">
            </div>
        <?php endwhile; ?>
        </div>
    <?php endif; ?>

    <!-- CONTENT -->
    <div class="bg-white p-4 rounded shadow-sm mb-4">
        <?= nl2br(htmlspecialchars($data['Content'])) ?>
    </div>

    <!-- BACK -->
    <a href="review.php" class="btn btn-outline-secondary">
        ← Back to Reviews
    </a>

</div>

<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
