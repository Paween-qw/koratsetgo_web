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

    <title>WoOx Travel Bootstrap 5 Theme</title>

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
.banner {
  position: relative;
}

.banner::before {
  content: "";
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, 0.45);
  z-index: 1;
}

.banner-inner-wrapper {
  position: relative;
  z-index: 2;
}

.banner-inner-wrapper h1,
.banner-inner-wrapper h2 {
  color: #ffffff;
  text-shadow: 0 4px 16px rgba(0,0,0,0.65);
}

/* ===== WEEKLY TITLE STRONGER ===== */
.weekly-offers .section-heading h2 {
  color: #ffffff;              /* สีขาวชัด */
  font-weight: 700;            /* ตัวหนา */
  text-shadow: 0 6px 20px rgba(0,0,0,0.75);
  opacity: 1;                  /* กันโดนทำให้จาง */
}

/* ================= WEEKLY CARD ================= */

.weekly-card {
  border-radius: 22px;
  overflow: hidden;
  background: transparent;
  box-shadow: 0 20px 40px rgba(0,0,0,.25);
  transition: transform .3s ease, box-shadow .3s ease;
}

.weekly-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 30px 60px rgba(0,0,0,.35);
}

/* IMAGE */
.weekly-img img {
  width: 100%;
  height: 230px;
  object-fit: cover;
  display: block;
}

/* TEXT BOX */
.weekly-text {
  background: #ffffff;
  padding: 22px;
}

.weekly-title {
  font-size: 20px;
  font-weight: 700;
  margin-bottom: 6px;
}

.weekly-visitor {
  font-size: 14px;
  color: #666;
  margin-bottom: 12px;
}

.weekly-visitor i {
  margin-right: 6px;
}

.weekly-info {
  list-style: none;
  padding: 0;
  margin: 0 0 18px 0;
}

.weekly-info li {
  font-size: 14px;
  margin-bottom: 6px;
  color: #444;
}

.weekly-info i {
  width: 20px;
  margin-right: 6px;
  color: #00bcd4;
}

/* BUTTON */
.weekly-btn a {
  display: inline-block;
  background: #00bcd4;
  color: #fff;
  padding: 10px 22px;
  border-radius: 999px;
  font-size: 14px;
  font-weight: 600;
  transition: .3s;
}

.weekly-btn a:hover {
  background: #0097a7;
}

/* ===== TOP WEEKLY BADGE ===== */
.weekly-card {
  position: relative;
}

.weekly-badge {
  position: absolute;
  top: 14px;
  left: 14px;
  z-index: 5;

  background: linear-gradient(135deg, #ff9800, #ff5722);
  color: #fff;
  font-size: 12px;
  font-weight: 700;
  padding: 6px 12px;
  border-radius: 999px;

  box-shadow: 0 8px 20px rgba(0,0,0,.35);
  letter-spacing: .4px;
}
/* ===== OWL SLIDE ANIMATION (BASIC) ===== */
.owl-weekly-offers .owl-item {
  opacity: 0.3;
  transform: scale(0.92);
  transition: all .4s ease;
}

.owl-weekly-offers .owl-item.active {
  opacity: 1;
  transform: scale(1);
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
    <?php
  $topBlogSql = "
  SELECT TOP 4
    B.Blog_ID,
    B.Title,
    B.Image,
    ISNULL(E.Total_Cost,0) AS Total_Cost,
    ISNULL(E.Trip_Days,1) AS Trip_Days,
    COUNT(DISTINCT BL.Like_ID) AS like_count
  FROM Blog B
  LEFT JOIN Travel_Expense E ON B.Blog_ID = E.Blog_ID
  LEFT JOIN BlogLike BL ON B.Blog_ID = BL.Blog_ID
  GROUP BY 
    B.Blog_ID,B.Title,B.Image,E.Total_Cost,E.Trip_Days
  ORDER BY like_count DESC
  ";

  $topBlogs = sqlsrv_query($conn,$topBlogSql);
  $blogs = [];
  while($b = sqlsrv_fetch_array($topBlogs,SQLSRV_FETCH_ASSOC)){
    $blogs[] = $b;
  }

/* ================= BEST WEEKLY VISITOR ================= */
$weeklySql = "
SELECT TOP 6
  B.Blog_ID,
  B.Title,
  B.Image,

  -- จาก Travel_Expense
  ISNULL(E.Type_Car, '-') AS Type_Car,
  ISNULL(E.Traveler_Count, 1) AS Traveler_Count,
  ISNULL(E.Trip_Days, 1) AS Trip_Days,
  ISNULL(E.Total_Cost, 0) AS Total_Cost,

  -- นับ visitor จาก like
  COUNT(L.Blog_ID) AS Visitor

FROM Blog B
LEFT JOIN BlogLike L 
  ON B.Blog_ID = L.Blog_ID
LEFT JOIN Travel_Expense E 
  ON B.Blog_ID = E.Blog_ID

GROUP BY 
  B.Blog_ID,
  B.Title,
  B.Image,
  E.Type_Car,
  E.Traveler_Count,
  E.Trip_Days,
  E.Total_Cost

ORDER BY Visitor DESC
";

$weeklyQ = sqlsrv_query($conn, $weeklySql);
  ?>

  <!-- ***** Main Banner Area Start ***** -->
<section id="section-1">
  <div class="content-slider">

    <?php foreach($blogs as $i=>$b): ?>
      <input type="radio"
             id="banner<?= $i+1 ?>"
             class="sec-1-input"
             name="banner"
             <?= $i===0?'checked':'' ?>>
    <?php endforeach; ?>

    <div class="slider">

    <?php foreach($blogs as $i=>$b): ?>
      <div id="top-banner-<?= $i+1 ?>"
           class="banner"
           style="background-image:url('uploads/blogs/<?= htmlspecialchars($b['Image']) ?>')">

        <div class="banner-inner-wrapper header-text">
          <div class="main-caption">
            <h2>Recommended tourist attractions in Korat:</h2>
            <h1><?= htmlspecialchars($b['Title']) ?></h1>
            <div class="border-button">
              <a href="review.php?type=blog&id=<?= $b['Blog_ID'] ?>">
                Go There
              </a>
            </div>
          </div>

          <div class="container">
            <div class="row">
              <div class="col-lg-12">
                <div class="more-info">
                  <div class="row justify-content-center">

                    <div class="col-lg-3 col-sm-6 col-6 text-center">
                      <i class="fa fa-user"></i>
                      <h4>
                        <span>Monthly Visitors:</span><br>
                        ~<?= number_format($b['like_count']) ?>
                      </h4>
                    </div>

                    <div class="col-lg-3 col-sm-6 col-6 text-center">
                      <i class="fa fa-home"></i>
                      <h4>
                        <span>AVG Price:</span><br>
                        ฿<?= number_format($b['Total_Cost']) ?>
                      </h4>
                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    <?php endforeach; ?>
    </div>

<nav>
  <div class="controls">
    <?php foreach($blogs as $i=>$b): ?>
      <label for="banner<?= $i+1 ?>">
        <span class="progressbar">
          <span class="progressbar-fill"></span>
        </span>
        <span class="text"><?= $i + 1 ?></span>
      </label>
    <?php endforeach; ?>
  </div>
</nav>
</section>

<div class="weekly-offers">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 offset-lg-3">
        <div class="section-heading text-center">
          <h2>Best Weekly Visitor In Korat</h2>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="owl-weekly-offers owl-carousel">

          <?php while($w = sqlsrv_fetch_array($weeklyQ, SQLSRV_FETCH_ASSOC)): ?>
              <div class="item">
                <div class="weekly-card">

                  <!-- 🔥 BADGE -->
                  <div class="weekly-badge">🔥 TOP WEEKLY</div>

                  <!-- IMAGE -->
                  <div class="weekly-img">
                    <img src="uploads/blogs/<?= htmlspecialchars($w['Image']) ?>" alt="">
                  </div>

                  <!-- TEXT -->
                  <div class="weekly-text">

                    <h4 class="weekly-title">
                      <?= htmlspecialchars($w['Title']) ?>
                    </h4>

                    <div class="weekly-visitor">
                      <i class="fa fa-users"></i>
                      <?= (int)$w['Visitor'] ?> visitors / weekly
                    </div>

                    <ul class="weekly-info">
                      <li>
                        <i class="fa fa-calendar"></i>
                        <?= (int)$w['Trip_Days'] ?> Days Trip
                      </li>

                      <li>
                        <i class="fa fa-users"></i>
                        <?= (int)$w['Traveler_Count'] ?> People
                      </li>

                      <li>
                        <i class="fa fa-car"></i>
                        <?= htmlspecialchars($w['Type_Car']) ?>
                      </li>

                      <li>
                        <i class="fa fa-coins"></i>
                        ฿<?= number_format((int)$w['Total_Cost']) ?>
                      </li>
                    </ul>

                    <div class="weekly-btn">
                      <a href="review_detail.php?type=blog&id=<?= $w['Blog_ID'] ?>">
                        See All Reviews
                      </a>
                    </div>

                  </div>
                </div>
              </div>

          <?php endwhile; ?>

        </div>
      </div>
    </div>
  </div>
</div>

  <!-- ***** Main Banner Area End ***** -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <p>Copyright © 2026 <a href="#">KoratSetGo</a> Company. All rights reserved. </p>
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
    function bannerSwitcher() {
      next = $('.sec-1-input').filter(':checked').next('.sec-1-input');
      if (next.length) next.prop('checked', true);
      else $('.sec-1-input').first().prop('checked', true);
    }

    var bannerTimer = setInterval(bannerSwitcher, 5000);

    $('nav .controls label').click(function() {
      clearInterval(bannerTimer);
      bannerTimer = setInterval(bannerSwitcher, 5000)
    });
  </script>

  </body>

</html>
