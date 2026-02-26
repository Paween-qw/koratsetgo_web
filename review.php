<!DOCTYPE html>
<html lang="en">

<?php
session_start();
include("includes/connect.php");

$role = "guest";
if(isset($_SESSION['role'])){
    $role = $_SESSION['role'];
}
?>

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>WoOx Travel - Special Deals</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Additional CSS Files -->
<link rel="stylesheet" href="assets/css/fontawesome.css">
<link rel="stylesheet" href="assets/css/templatemo-woox-travel.css">
<link rel="stylesheet" href="assets/css/owl.css">
<link rel="stylesheet" href="assets/css/animate.css">
<link rel="stylesheet" href="assets/css/navbar-custom.css">

<!--

TemplateMo 580 Woox Travel

https://templatemo.com/tm-580-woox-travel

-->
  </head>

<style>
/* ===============================
   DISCOVER SEARCH
   =============================== */
.discover-search{
  margin-top:20px;
  display:flex;
  justify-content:center;
}

.discover-search form{
  display:flex;
  width:420px;
  background:#fff;
  border-radius:50px;
  overflow:hidden;
  box-shadow:0 10px 30px rgba(0,0,0,.2);
}

.discover-search input{
  flex:1;
  border:none;
  padding:15px 20px;
  font-size:16px;
  outline:none;
}

.discover-search button{
  background:#00e5ff;
  border:none;
  padding:0 25px;
  font-size:18px;
  cursor:pointer;
  color:#000;
}

/* ===============================
   MEDIA (BLOG / VLOG)
   =============================== */
.media-box{
  position:relative;
  width:100%;
  height:220px;
  border-radius:15px;
  overflow:hidden;
  box-shadow:0 10px 25px rgba(0,0,0,.35);
  cursor:pointer;
}

.media-poster,
.media-video{
  width:100%;
  height:100%;
  object-fit:cover;
  position:absolute;
  top:0;
  left:0;
}

/* ===============================
   CONTENT TEXT
   =============================== */
.content p,
.content h4,
.content .info{
  word-wrap: break-word;
  overflow-wrap: break-word;
  word-break: break-word;
  white-space: normal;
}

/* ===============================
   COMMENT STYLE
   =============================== */
.comment-list{
  color:#333;
}

.comment-item{
  color:#333;
  background:#f8f9fa;
  padding:8px 10px;
  border-radius:6px;
  margin-bottom:6px;
  font-size:14px;
}

.comment-item b{
  color:#000;
}

.comment-item button{
  padding:0;
  margin-left:6px;
}

/* ===============================
   TRIP SEARCH CARD
   =============================== */
.trip-search-card{
  background: rgba(255,255,255,0.12);
  backdrop-filter: blur(14px);
  border-radius: 18px;
  padding: 25px 30px;
  box-shadow: 0 20px 40px rgba(0,0,0,.35);
}

.trip-title{
  color:#fff;
  font-weight:600;
  margin-bottom:0;
}

.trip-label{
  font-size:13px;
  color:#cfd8dc;
  margin-bottom:6px;
  display:block;
}

.trip-select{
  width:100%;
  padding:12px 14px;
  border-radius:12px;
  border:none;
  background:#fff;
  font-size:14px;
  box-shadow:0 5px 15px rgba(0,0,0,.15);
  transition:.25s;
}

.trip-select:focus{
  outline:none;
  box-shadow:0 0 0 3px rgba(0,229,255,.45);
}

.trip-btn{
  width:100%;
  margin-top:10px;
  padding:14px;
  border:none;
  border-radius:14px;
  font-size:16px;
  font-weight:600;
  background: linear-gradient(135deg,#00e5ff,#4facfe);
  color:#000;
  cursor:pointer;
  transition:.3s;
}

.trip-btn:hover{
  transform: translateY(-2px);
  box-shadow:0 12px 30px rgba(0,229,255,.45);
}

/* ===============================
   TRIP SEARCH INPUT (REPLACE SELECT)
   =============================== */
.trip-input{
  width:100%;
  padding:12px 14px;
  border-radius:12px;
  border:none;
  background:#fff;
  font-size:14px;
  box-shadow:0 5px 15px rgba(0,0,0,.15);
  transition:.25s;
}

.trip-input::placeholder{
  color:#9e9e9e;
}

.trip-input:focus{
  outline:none;
  box-shadow:0 0 0 3px rgba(0,229,255,.45);
}

.like-count {
  color: #d32f2f !important;       /* แดง like */
  background: rgba(211,47,47,0.1);
  font-weight: 600;
  padding: 4px 10px;
  border-radius: 999px;
  font-size: 13px;
}
/* LIKE COUNT BASE */
.like-count {
  color: #333;
  background: #f1f3f5;
  font-weight: 600;
  padding: 4px 10px;
  border-radius: 999px;
  font-size: 13px;
  transition: .25s;
}

/* WHEN LIKED */
.like-count.liked {
  color: #fff !important;
  background: #d32f2f;
}

/* HEART CLICK ANIMATION */
.btn-like {
  transition: transform .15s ease;
}

.btn-like.liked-anim {
  animation: heart-pop .4s ease;
}

@keyframes heart-pop {
  0%   { transform: scale(1); }
  40%  { transform: scale(1.35); }
  70%  { transform: scale(0.95); }
  100% { transform: scale(1); }
}

.heart-float {
  position: absolute;
  font-size: 20px;
  animation: float-up .8s ease forwards;
  pointer-events: none;
}

@keyframes float-up {
  0% {
    transform: translateY(0) scale(1);
    opacity: 1;
  }
  100% {
    transform: translateY(-30px) scale(1.6);
    opacity: 0;
  }
}
/* ===============================
   COMMENT LIST
   =============================== */
.comment-list{
  margin-top:10px;
}

.comment-item{
  background:#f8f9fa;
  border-radius:10px;
  padding:8px 12px;
  font-size:14px;
  margin-bottom:6px;
}

.comment-item b{
  color:#000;
}

/* ===============================
   FACEBOOK STYLE COMMENT BOX
   =============================== */
.fb-comment-box{
  position:relative;
  display:flex;
  align-items:center;
  margin-top:10px;
}

/* TEXTAREA */
.fb-comment-text{
  flex:1;
  border:1px solid #ddd;
  border-radius:20px;
  padding:10px 48px 10px 14px;
  font-size:14px;
  resize:none;
  outline:none;
  background:#fff;
  transition:.2s;
}

.fb-comment-text:focus{
  border-color:#1877f2;
  box-shadow:0 0 0 2px rgba(24,119,242,.15);
}

/* SEND BUTTON */
.fb-send-btn{
  position:absolute;
  right:8px;
  bottom:6px;
  width:34px;
  height:34px;
  border-radius:50%;
  background:#fff;                 /* พื้นขาว */
  color:#1877f2;                    /* ไอคอนฟ้า */
  border:1px solid #e4e6eb;

  display:flex;
  align-items:center;
  justify-content:center;

  font-size:14px;
  cursor:pointer;
  box-shadow:0 4px 12px rgba(0,0,0,.15);
  transition:.2s ease;

  opacity:.4;
  pointer-events:none;
}

/* ACTIVE (พิมพ์แล้ว) */
.fb-send-btn.active{
  opacity:1;
  pointer-events:auto;
}

/* HOVER */
.fb-send-btn:hover{
  background:#f0f2f5;
  transform:scale(1.1);
}

.fb-send-btn:active{
  transform:scale(.95);
}
.section-heading h2{
  color:#ffffff;
  font-weight:800;
  text-shadow: 0 4px 15px rgba(0,0,0,.45);
}

html{
  scroll-behavior: smooth;
}
</style>


<body>
<?php include("includes/header.php"); ?>
  <!-- ***** Preloader Start ***** -->
  <div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
      <span class="dot"></span>
      <div class="dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div>
  <!-- ***** Preloader End ***** -->

  <!-- ***** Header Area Start ***** -->

  <!-- ***** Header Area End ***** -->

  <div class="page-heading">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h4>Discover Our Korat</h4>
          <h2>All Reviews Blog &amp; Vlog</h2>

          <div class="discover-search">
            <form method="GET" action="review.php#all-reviews">
              <input type="text" name="q"
                    value="<?= htmlspecialchars($_GET['q'] ?? '') ?>"
                    placeholder="Discover places in Korat...">
              <button type="submit">🔍</button>
            </form>
          </div>

        </div>
      </div>
    </div>
  </div>

  <div class="search-form">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">

          <form method="GET" action="review.php#all-reviews" class="trip-search-card">
  <div class="row align-items-end g-3">

    <div class="col-lg-2">
      <h4 class="trip-title">Find your trip</h4>
    </div>

    <div class="col-lg-4">
      <label class="trip-label">⭐ Sort</label>
      <select name="sort" class="trip-select">
        <option value="">Sort by</option>
        <option value="like">Most Likes</option>
        <option value="cost">Lowest Cost</option>
        <option value="days">Fewest Days</option>
      </select>
    </div>

      <div class="col-lg-4">
        <label class="trip-label">🚗 Car Type</label>
        <input 
          type="text" 
          name="car_type" 
          class="trip-input"
          placeholder="e.g. Personal car, Van, Bus">
      </div>

      <div class="col-lg-4">
        <label class="trip-label">💰 Budget</label>
        <input 
          type="number" 
          name="budget" 
          class="trip-input"
          placeholder="e.g. 1500">
      </div>

      <div class="col-lg-3">
        <label class="trip-label">📅 Days</label>
        <input 
          type="number" 
          name="days" 
          class="trip-input"
          placeholder="e.g. 2">
      </div>

      <div class="col-lg-3">
        <label class="trip-label">👥 People</label>
        <input 
          type="number" 
          name="people" 
          class="trip-input"
          placeholder="e.g. 4">
      </div>

    <div class="col-lg-12">
      <button type="submit" class="trip-btn">
        🔍 Search Results
      </button>
    </div>

  </div>
</form>
        </div>
      </div>
    </div>
  </div>

  
<?php
$limit = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

$q        = trim($_GET['q'] ?? '');
$carType  = trim($_GET['car_type'] ?? '');
$budget   = is_numeric($_GET['budget'] ?? '') ? (int)$_GET['budget'] : '';
$days     = is_numeric($_GET['days'] ?? '') ? (int)$_GET['days'] : '';
$people   = is_numeric($_GET['people'] ?? '') ? (int)$_GET['people'] : '';

$allowedSort = ['like','cost','days'];
$sort = in_array($_GET['sort'] ?? '', $allowedSort)
        ? $_GET['sort']
        : '';

$where = [];
$params = [];

if($q !== ''){
  $like = "%$q%";

  $where[] = "(
    Title LIKE ?
    OR Content LIKE ?
    OR Tag LIKE ?
    OR Type_Car LIKE ?
    OR CAST(Total_Cost AS NVARCHAR) LIKE ?
    OR CAST(Trip_Days AS NVARCHAR) LIKE ?
    OR CAST(Traveler_Count AS NVARCHAR) LIKE ?
  )";

  array_push(
    $params,
    $like, // Title
    $like, // Content
    $like, // Tag
    $like, // Type_Car
    $like, // Total_Cost
    $like, // Trip_Days
    $like  // Traveler_Count
  );
}


if($carType !== ''){
  $where[] = "Type_Car LIKE ?";
  $params[] = "%$carType%";
}

if($budget !== ''){
  $where[] = "Total_Cost <= ?";
  $params[] = $budget;
}

if($days !== ''){
  $where[] = "Trip_Days = ?";
  $params[] = $days;
}

if($people !== ''){
  $where[] = "Traveler_Count = ?";
  $params[] = $people;
}


$whereSQL = $where ? 'WHERE '.implode(' AND ',$where) : '';


/* COUNT */
$countSql = "
SELECT COUNT(DISTINCT id) AS total FROM (
  SELECT 
    B.Blog_ID AS id,
    B.Title,
    B.Content,
    BT.Tag,
    E.Type_Car,
    E.Total_Cost,
    E.Trip_Days,
    E.Traveler_Count,
    B.Create_At
  FROM Blog B
  LEFT JOIN Travel_Expense E ON B.Blog_ID = E.Blog_ID
  LEFT JOIN BlogTag BT ON B.Blog_ID = BT.Blog_ID

  UNION ALL

  SELECT
    V.Vlog_ID AS id,
    V.Title,
    V.Content,
    VT.Tag,
    E.Type_Car,
    E.Total_Cost,
    E.Trip_Days,
    E.Traveler_Count,
    V.Create_At
  FROM Vlog V
  LEFT JOIN Travel_Expense E ON V.Vlog_ID = E.Vlog_ID
  LEFT JOIN VlogTag VT ON V.Vlog_ID = VT.Vlog_ID
) all_data
$whereSQL
";

$countParams = $params;
$countStmt = sqlsrv_query($conn, $countSql, $countParams);
$countRow  = sqlsrv_fetch_array($countStmt, SQLSRV_FETCH_ASSOC);
$totalItems = (int)$countRow['total'];
$totalPages = ceil($totalItems / $limit);

$orderSQL = "ORDER BY Create_At DESC";

if($sort === 'like'){
  $orderSQL = "ORDER BY ISNULL(like_count,0) DESC, Create_At DESC";
}
elseif($sort === 'cost'){
  $orderSQL = "ORDER BY ISNULL(Total_Cost,999999999) ASC, Create_At DESC";
}
elseif($sort === 'days'){
  $orderSQL = "ORDER BY ISNULL(Trip_Days,999999) ASC, Create_At DESC";
}


/* DATA */
$sql = "
SELECT * FROM (
  SELECT 
    'blog' AS type,
    B.Blog_ID AS id,
    B.Title,
    B.Content,
    B.Image AS poster,
    NULL AS video,
    E.Type_Car,
    E.Total_Cost,
    E.Trip_Days,
    E.Traveler_Count,
    B.Create_At,
    BL.cnt AS like_count,
    BT.Tag
  FROM Blog B
  LEFT JOIN Travel_Expense E ON B.Blog_ID = E.Blog_ID
  LEFT JOIN BlogTag BT ON B.Blog_ID = BT.Blog_ID
  LEFT JOIN (
    SELECT Blog_ID, COUNT(*) cnt FROM BlogLike GROUP BY Blog_ID
  ) BL ON B.Blog_ID = BL.Blog_ID

  UNION ALL

  SELECT
    'vlog' AS type,
    V.Vlog_ID AS id,
    V.Title,
    V.Content,
    V.Thumbnail AS poster,
    V.Video_Path AS video,
    E.Type_Car,
    E.Total_Cost,
    E.Trip_Days,
    E.Traveler_Count,
    V.Create_At,
    VL.cnt AS like_count,
    VT.Tag
  FROM Vlog V
  LEFT JOIN Travel_Expense E ON V.Vlog_ID = E.Vlog_ID
  LEFT JOIN VlogTag VT ON V.Vlog_ID = VT.Vlog_ID
  LEFT JOIN (
    SELECT Vlog_ID, COUNT(*) cnt FROM VlogLike GROUP BY Vlog_ID
  ) VL ON V.Vlog_ID = VL.Vlog_ID
) all_data
$whereSQL
$orderSQL
OFFSET ? ROWS FETCH NEXT ? ROWS ONLY
";

$params[] = $offset;
$params[] = $limit;

$stmt = sqlsrv_query($conn,$sql,$params);
?>

<div class="amazing-deals">
  <div class="container">
    <div class="row">

      <div class="col-lg-6 offset-lg-3">
        <div class="section-heading text-center" id="all-reviews">
          <h2>All Reviews</h2>
        </div>
      </div>

<?php while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)): ?>

<?php
// ================= LIKE STATUS =================
$userId = $_SESSION['user_id'] ?? 0;

if($row['type'] === 'blog'){
    $checkLike = sqlsrv_query(
        $conn,
        "SELECT 1 FROM BlogLike WHERE Blog_ID=? AND User_ID=?",
        [$row['id'], $userId]
    );
    $countQ = sqlsrv_query(
        $conn,
        "SELECT COUNT(*) c FROM BlogLike WHERE Blog_ID=?",
        [$row['id']]
    );
} else {
    $checkLike = sqlsrv_query(
        $conn,
        "SELECT 1 FROM VlogLike WHERE Vlog_ID=? AND User_ID=?",
        [$row['id'], $userId]
    );
    $countQ = sqlsrv_query(
        $conn,
        "SELECT COUNT(*) c FROM VlogLike WHERE Vlog_ID=?",
        [$row['id']]
    );
}

$isLiked   = ($userId && sqlsrv_has_rows($checkLike));
$likeRow   = sqlsrv_fetch_array($countQ, SQLSRV_FETCH_ASSOC);
$likeCount = (int)$likeRow['c'];
?>

<div class="col-lg-6 col-sm-6">

  <!-- ================= CARD ================= -->
  <div class="item">
    <div class="row">

      <!-- MEDIA -->
      <div class="col-lg-6">
        <div class="image media-box">
          <?php if($row['type'] === 'vlog'): ?>
            <img src="uploads/vlogs/<?= htmlspecialchars($row['poster']) ?>" class="media-poster">
            <video class="media-video" controls>
              <source src="uploads/vlogs/<?= htmlspecialchars($row['video']) ?>" type="video/mp4">
            </video>
        <?php else: ?>
          <img src="uploads/blogs/<?= htmlspecialchars($row['poster']) ?>"
              class="media-poster open-gallery"
              data-id="<?= $row['id'] ?>"
              style="cursor:pointer;">
        <?php endif; ?>
        </div>
      </div>

      <!-- CONTENT -->
      <div class="col-lg-6 align-self-center">
        <div class="content">
          <!-- TAG -->
          <span class="info">
          <?php
          if($row['type'] === 'blog'){
              $tagQ = sqlsrv_query(
                  $conn,
                  "SELECT Tag FROM BlogTag WHERE Blog_ID=?",
                  [$row['id']]
              );
          }else{
              $tagQ = sqlsrv_query(
                  $conn,
                  "SELECT Tag FROM VlogTag WHERE Vlog_ID=?",
                  [$row['id']]
              );
          }

          while($t = sqlsrv_fetch_array($tagQ, SQLSRV_FETCH_ASSOC)){
              echo '<a href="review.php?q='.urlencode($t['Tag']).'" 
                      class="tag-link">'.htmlspecialchars($t['Tag']).'</a> ';
          }
          ?>
          </span>

           <h4><?= htmlspecialchars($row['Title']) ?></h4>

            <div class="row mb-2">

            <?php if($row['type'] === 'blog'): ?>

              <div class="col-6">
                <i class="fa fa-clock"></i>
                <span class="list"><?= (int)$row['Trip_Days'] ?> Days</span>
              </div>

              <div class="col-6">
                <i class="fa fa-users"></i>
                <span class="list"><?= (int)$row['Traveler_Count'] ?> People</span>
              </div>

              <div class="col-6 mt-1">
                <i class="fa fa-car"></i>
                <span class="list"><?= htmlspecialchars($row['Type_Car']) ?></span>
              </div>

              <?php if(!empty($row['Total_Cost'])): ?>
                <div class="col-6 mt-1 text-muted">
                  <i class="fa fa-coins"></i>
                  <span class="list">
                    ฿<?= number_format((int)$row['Total_Cost']) ?>
                  </span>
                </div>
              <?php endif; ?>

            <?php else: ?>

              <div class="col-12 d-flex justify-content-between align-items-center">

                <div class="text-muted">
                  <i class="fa fa-video"></i>
                  <span class="list">Vlog</span>
                </div>

                <?php if(!empty($row['Total_Cost'])): ?>
                  <div class="text-muted">
                    <i class="fa fa-coins"></i>
                    <span class="list">
                      ฿<?= number_format((int)$row['Total_Cost']) ?>
                    </span>
                  </div>
                <?php endif; ?>

              </div>

            <?php endif; ?>

            </div>

            <p>
              <?= mb_strimwidth(
                    strip_tags($row['Content']),
                    0,
                    280,
                    '...',
                    'UTF-8'
                  ); ?>
            </p>

            <?php if (mb_strlen(strip_tags($row['Content']), 'UTF-8') > 280): ?>
              <a href="review_detail.php?type=<?= $row['type'] ?>&id=<?= $row['id'] ?>"
                class="btn btn-sm btn-link p-0">
                Read more →
              </a>
            <?php endif; ?>


          <!-- LIKE -->
          <div style="margin:10px 0;">
            <button type="button"
              class="btn btn-sm btn-like <?= $isLiked?'btn-danger':'btn-outline-danger' ?>"
              data-type="<?= $row['type'] ?>"
              data-id="<?= $row['id'] ?>">
              <?= $isLiked?'❤️ Liked':'🤍 Like' ?>
            </button>

            <span class="like-count <?= $isLiked ? 'liked' : '' ?>" data-id="<?= $row['id'] ?>">
              <?= $likeCount ?> Likes
            </span>
          </div>

  <!-- COMMENT BOX -->
   <div class="fb-comment-box"
     data-type="<?= $row['type'] ?>"
     data-id="<?= $row['id'] ?>">

  <textarea
    class="fb-comment-text comment-text"
    rows="1"
    placeholder="Write a comment..."></textarea>

<button type="button"
        class="btn-send-comment fb-send-btn"
        aria-label="Send">
  <i class="fa fa-paper-plane"></i>
</button>
</div>
             
  <!-- COMMENT LIST -->
  <div class="comment-list" style="margin-top:10px;">
    <?php
    $sqlComment = ($row['type']==='blog')
      ? "SELECT C.Comment_ID,C.Comment_Text,C.User_ID,U.Full_Name
          FROM BlogComment C JOIN [User] U ON C.User_ID=U.User_ID
          WHERE C.Blog_ID=? ORDER BY C.Created_At DESC"
      : "SELECT C.Comment_ID,C.Comment_Text,C.User_ID,U.Full_Name
          FROM VlogComment C JOIN [User] U ON C.User_ID=U.User_ID
          WHERE C.Vlog_ID=? ORDER BY C.Created_At DESC";

    $cQ = sqlsrv_query($conn,$sqlComment,[$row['id']]);
    $hasComment = false;

    while($c = sqlsrv_fetch_array($cQ,SQLSRV_FETCH_ASSOC)){
      $hasComment = true;
    ?>
      <div class="comment-item" data-cid="<?= (int)$c['Comment_ID'] ?>">
        <b><?= htmlspecialchars($c['Full_Name']) ?>:</b>
        <?= nl2br(htmlspecialchars($c['Comment_Text'])) ?>

        <?php if(($_SESSION['user_id'] ?? 0) == $c['User_ID']): ?>
          <button type="button"
                  class="btn btn-sm btn-link text-danger btn-del-comment"
                  data-type="<?= $row['type'] ?>"
                  data-id="<?= (int)$c['Comment_ID'] ?>">
            🗑
          </button>
        <?php endif; ?>
      </div>
    <?php } ?>

    <?php if(!$hasComment): ?>
      <div class="text-muted small">ยังไม่มีความคิดเห็น</div>
    <?php endif; ?>
  </div>


        </div>
      </div>

    </div>
  </div>
  <!-- ================= END CARD ================= -->

  <!-- LINK (อยู่นอก item เท่านั้น) -->
  <div class="main-button text-center mt-3">
    <a href="review.php?type=<?= $row['type'] ?>&id=<?= $row['id'] ?>">
      See All Reviews This Place
    </a>
  </div>

</div>


<?php endwhile; ?>
        <?php if($totalPages > 1): ?>
              <div class="col-lg-12">
                <ul class="page-numbers">
                  <li><a href="?page=<?= max(1,$page-1) ?>"><i class="fa fa-arrow-left"></i></a></li>
        <?php for($i=1;$i<=$totalPages;$i++): ?>
                  <li class="<?= $i==$page?'active':'' ?>"><a href="?page=<?= $i ?>"><?= $i ?></a></li>
        <?php endfor; ?>
                  <li><a href="?page=<?= min($totalPages,$page+1) ?>"><i class="fa fa-arrow-right"></i></a></li>
                </ul>
              </div>
        <?php endif; ?>

    </div>
  </div>
</div>


  <footer>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <p>Copyright © 2026 <a href="#">KoratSetGo</a> Company. All rights reserved. </p></p>
        </div>
      </div>
    </div>
  </footer>

<!-- ================= IMAGE GALLERY MODAL ================= -->
<div class="modal fade" id="galleryModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">📸 Gallery</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3" id="galleryContent">
          <!-- รูปจะถูกใส่ด้วย JS -->
        </div>
      </div>
    </div>
  </div>
</div>


  <!-- Scripts -->
  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/js/isotope.min.js"></script>
  <script src="assets/js/owl-carousel.js"></script>
  <script src="assets/js/wow.js"></script>
  <script src="assets/js/tabs.js"></script>
  <script src="assets/js/popup.js"></script>
  <script src="assets/js/custom.js"></script>

<script>
/* ================= OPTION CLICK ================= */
$(".option").click(function(e){
  e.preventDefault();
  e.stopPropagation();
  $(".option").removeClass("active");
  $(this).addClass("active"); 
});

/* ================= CLICK EVENTS ================= */
document.addEventListener('click', function(e){

  /* ================= LIKE ================= */
  if(e.target.classList.contains('btn-like')){
    e.preventDefault();
    e.stopPropagation();

    const btn  = e.target;
    const type = btn.dataset.type;
    const id   = btn.dataset.id;

    fetch('ajax_like.php',{
      method:'POST',
      headers:{'Content-Type':'application/x-www-form-urlencoded'},
      body:`type=${type}&id=${id}`
    })
    .then(r => r.json())
    .then(d => {
      if(!d.status) return;

      btn.innerText = d.status === 'liked' ? '❤️ Liked' : '🤍 Like';

      const countEl = btn.nextElementSibling;
      countEl.innerText = d.count + ' Likes';
      countEl.classList.toggle('liked', d.status === 'liked');

      btn.classList.remove('liked-anim');
      void btn.offsetWidth;
      btn.classList.add('liked-anim');

      if(d.status === 'liked'){
        const heart = document.createElement('span');
        heart.className = 'heart-float';
        heart.innerText = '❤️';
        btn.style.position = 'relative';
        btn.appendChild(heart);
        setTimeout(() => heart.remove(), 800);
      }
    });
  }

  /* ================= ADD COMMENT (NO DELAY) ================= */
  if(e.target.classList.contains('btn-send-comment')){
    e.preventDefault();
    e.stopPropagation();

    const box = e.target.closest('.fb-comment-box');
    if(!box) return;

    const type   = box.dataset.type;
    const id     = box.dataset.id;
    const textEl = box.querySelector('.fb-comment-text');
    const btn    = box.querySelector('.fb-send-btn');
    const text   = textEl.value.trim();

    if(!text) return;

    const list = box.nextElementSibling;
    if(!list || !list.classList.contains('comment-list')) return;

    /* ✅ OPTIMISTIC UI (ขึ้นทันที) */
    const tempId = 'temp-' + Date.now();
    list.insertAdjacentHTML('afterbegin', `
      <div class="comment-item temp" data-cid="${tempId}">
        <b>You:</b> ${text}
      </div>
    `);

    textEl.value = '';
    btn.classList.remove('active');

    /* ส่งจริงไป server */
    fetch('ajax_comment.php',{
      method:'POST',
      headers:{'Content-Type':'application/x-www-form-urlencoded'},
      body:`type=${type}&id=${id}&comment=${encodeURIComponent(text)}`
    })
    .then(r => r.json())
    .then(d => {
      if(d.status === 'ok'){
        const temp = list.querySelector(`[data-cid="${tempId}"]`);
        if(temp){
          temp.outerHTML = `
            <div class="comment-item" data-cid="${d.comment_id}">
              <b>${d.name}:</b> ${d.text}
              <button type="button"
                      class="btn btn-sm btn-link text-danger btn-del-comment"
                      data-type="${type}"
                      data-id="${d.comment_id}">
                🗑
              </button>
            </div>
          `;
        }
      }
    });
  }

  /* ================= DELETE COMMENT ================= */
  if(e.target.classList.contains('btn-del-comment')){
    e.preventDefault();
    e.stopPropagation();

    const cid  = e.target.dataset.id;
    const type = e.target.dataset.type;
    const item = e.target.closest('.comment-item');

    fetch('ajax_delete_comment.php',{
      method:'POST',
      headers:{'Content-Type':'application/x-www-form-urlencoded'},
      body:`type=${type}&id=${cid}`
    })
    .then(r => r.json())
    .then(d => {
      if(d.status === 'ok'){
        item.remove();
      }
    });
  }

});

/* ================= INPUT (ENABLE SEND BUTTON) ================= */
document.addEventListener('input', function(e){
  if(e.target.classList.contains('fb-comment-text')){
    const box = e.target.closest('.fb-comment-box');
    if(!box) return;

    const btn = box.querySelector('.fb-send-btn');

    if(e.target.value.trim().length > 0){
      btn.classList.add('active');
    }else{
      btn.classList.remove('active');
    }
  }
});

document.addEventListener('click', function(e){

  const img = e.target.closest('.open-gallery');
  if(!img) return;

  const blogId = img.dataset.id;
  const box = document.getElementById('galleryContent');

  box.innerHTML = '<div class="text-center text-muted">Loading...</div>';

  fetch('ajax_blog_images.php?id=' + blogId)
    .then(r => r.json())
    .then(images => {

      box.innerHTML = '';

      if(images.length === 0){
        box.innerHTML = '<div class="text-muted">No images</div>';
        return;
      }

      images.forEach(src => {
        box.insertAdjacentHTML('beforeend', `
          <div class="col-md-4">
            <img src="uploads/blogs/${src}"
                 class="img-fluid rounded shadow-sm">
          </div>
        `);
      });

      const modal = new bootstrap.Modal(
        document.getElementById('galleryModal')
      );
      modal.show();
    });

});
</script>

<script>
document.addEventListener('DOMContentLoaded', function(){
  const params = new URLSearchParams(window.location.search);
  if(params.has('q') && params.get('q').trim() !== ''){
    const target = document.getElementById('all-reviews');
    if(target){
      target.scrollIntoView({ behavior: 'smooth' });
    }
  }
});
</script>



  </body>
</html>
