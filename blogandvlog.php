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

    <title>WoOx Travel Reservation Page</title>

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
   INFO LINK / CARD
   =============================== */
.info-link{
  text-decoration:none;
  color:inherit;
}

.info-link .info-item{
  transition:all .3s ease;
  cursor:pointer;
}

.info-link:hover .info-item{
  transform:translateY(-8px);
  box-shadow:0 20px 40px rgba(0,0,0,.2);
  background:#00e5ff;
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
   SUCCESS FLOAT ALERT
   =============================== */
.success-float{
  position: fixed;
  top: 90px;              /* ต่ำกว่า navbar */
  left: 50%;
  transform: translateX(-50%);
  z-index: 9999;
  min-width: 320px;
  padding: 12px 24px;
  border-radius: 8px;
  box-shadow: 0 10px 30px rgba(0,0,0,.25);
  animation: slideDown .4s ease;
}

@keyframes slideDown{
  from{
    opacity: 0;
    transform: translate(-50%, -20px);
  }
  to{
    opacity: 1;
    transform: translate(-50%, 0);
  }
}
.section-heading h2{
  color: rgba(255,255,255,0.95) !important;
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

  <?php if(isset($_GET['success'])): ?>
    <div id="success-alert" class="alert alert-success text-center success-float">
      ✅ Upload สำเร็จแล้ว
    </div>
  <?php endif; ?>


  <div class="second-page-heading">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h4>Create Your Content</h4>
          <h2>Make Your Blog &amp; Vlog</h2>
          <p>Share your travel experience in Korat. Write a blog or upload a vlog to inspire other travelers.</p>
          <div class="main-button"><a href="review.php">See All Reviews</a></div>
        </div>
      </div>
    </div>
  </div>


<div class="more-info reservation-info">
  <div class="container">
    <div class="row">

      <!-- BLOG -->
      <div class="col-lg-6 col-sm-6">
        <a href="blog.php" class="info-link">
          <div class="info-item">
            <i class="fa fa-pencil-alt"></i>
            <h4>Write Your Blog</h4>
            <p>Share your story, tips, and experiences.</p>
          </div>
        </a>
      </div>

      <!-- VLOG -->
      <div class="col-lg-6 col-sm-6">
        <a href="vlog.php" class="info-link">
          <div class="info-item">
            <i class="fa fa-video"></i>
            <h4>Upload Your Vlog</h4>
            <p>Add your travel video to inspire other visitors.</p>
          </div>
        </a>
      </div>

    </div>
  </div>
</div>

  <?php
  $limit = 6; // จำนวนต่อหน้า

  $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  if ($page < 1) $page = 1;

  $offset = ($page - 1) * $limit;

    $countSql = "
  SELECT COUNT(*) AS total FROM (
      SELECT Blog_ID AS id, Create_At FROM Blog
      UNION ALL
      SELECT Vlog_ID AS id, Create_At FROM Vlog
  ) x
  ";

  $countStmt = sqlsrv_query($conn, $countSql);
  $countRow  = sqlsrv_fetch_array($countStmt, SQLSRV_FETCH_ASSOC);

  $totalItems = $countRow['total'];
  $totalPages = ceil($totalItems / $limit);


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
    E.Trip_Days,
    E.Traveler_Count,
    E.Total_Cost,
    B.Create_At
  FROM Blog B
  LEFT JOIN Travel_Expense E ON B.Blog_ID = E.Blog_ID

  UNION ALL

  SELECT
    'vlog' AS type,
    V.Vlog_ID AS id,
    V.Title,
    V.Content,
    V.Thumbnail AS poster,
    V.Video_Path AS video,
    NULL AS Type_Car,
    NULL AS Trip_Days,
    NULL AS Traveler_Count,
    E.Total_Cost,
    V.Create_At
  FROM Vlog V
  LEFT JOIN Travel_Expense E ON V.Vlog_ID = E.Vlog_ID
) all_data
ORDER BY Create_At DESC
OFFSET ? ROWS FETCH NEXT ? ROWS ONLY
  ";

  $stmt = sqlsrv_query($conn, $sql, [$offset, $limit]);
  ?>

  <div class="amazing-deals">
    <div class="container">
      <div class="row">

        <div class="col-lg-6 offset-lg-3">
          <div class="section-heading text-center">
            <h2 class="up-to-date-title">Up To Date</h2>
          </div>
        </div>

  <?php while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)): ?>

        <div class="col-lg-6 col-sm-6">
          <div class="item">
            <div class="row">

              <!-- MEDIA -->
              <div class="col-lg-6">
                <div class="image media-box">

                  <?php if($row['type'] === 'vlog'): ?>
                    <img src="uploads/vlogs/<?= htmlspecialchars($row['poster']) ?>"
                        class="media-poster">

                    <video class="media-video" controls>
                      <source src="uploads/vlogs/<?= htmlspecialchars($row['video']) ?>" type="video/mp4">
                    </video>

                    <div class="play-overlay">▶</div>

                  <?php else: ?>
                    <img src="uploads/blogs/<?= htmlspecialchars($row['poster']) ?>"
                        class="media-poster">
                  <?php endif; ?>

                </div>
              </div>

              <!-- CONTENT -->
              <div class="col-lg-6 align-self-center">
                <div class="content">

                  <!-- TAG -->
                  <span class="info">
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

                  <div class="col-12 d-flex justify-content-between align-items-center text-muted">
                    <div>
                      <i class="fa fa-video"></i>
                      <span class="list">Vlog</span>
                    </div>

                    <?php if(!empty($row['Total_Cost'])): ?>
                      <div>
                        <i class="fa fa-coins"></i>
                        <span class="list">
                          ฿<?= number_format((int)$row['Total_Cost']) ?>
                        </span>
                      </div>
                    <?php endif; ?>
                  </div>

                <?php endif; ?>

                </div>

                  <p><?= mb_strimwidth(strip_tags($row['Content']),0,280,'...','UTF-8'); ?></p>

                </div>
              </div>
            </div>
          </div>
        </div>

  <?php endwhile; ?>

 <div class="col-lg-12">
  <?php if($totalPages > 1): ?>
  <div class="col-lg-12">
    <ul class="page-numbers">

      <!-- Prev -->
      <li>
        <a href="?page=<?= max(1, $page-1) ?>">
          <i class="fa fa-arrow-left"></i>
        </a>
      </li>

      <!-- Numbers -->
      <?php for($i=1; $i<=$totalPages; $i++): ?>
        <li class="<?= $i == $page ? 'active' : '' ?>">
          <a href="?page=<?= $i ?>"><?= $i ?></a>
        </li>
      <?php endfor; ?>

      <!-- Next -->
      <li>
        <a href="?page=<?= min($totalPages, $page+1) ?>">
          <i class="fa fa-arrow-right"></i>
        </a>
      </li>

    </ul>
  </div>
  <?php endif; ?>
        </div>
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
    $(".option").click(function(){
      $(".option").removeClass("active");
      $(this).addClass("active"); 
    });

      setTimeout(() => {
    const alertBox = document.getElementById('success-alert');
    if(alertBox){
      alertBox.style.transition = "opacity .5s ease";
      alertBox.style.opacity = "0";
      setTimeout(() => alertBox.remove(), 500);
    }
  }, 3000);
  </script>

  </body>

</html>
