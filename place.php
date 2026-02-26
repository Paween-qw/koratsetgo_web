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

    <title>WoOx Travel - About Us</title>

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
   OWL CITIES (ของเดิม ไม่แตะ)
   =============================== */
.owl-cites-town .thumb{
  width:100%;
  height:220px;
  overflow:hidden;
  border-radius:15px;
  position:relative;
}

.owl-cites-town .thumb img{
  width:100%;
  height:100%;
  object-fit:cover;
  display:block;
}

.owl-cites-town .thumb h4{
  position:absolute;
  bottom:0;
  left:0;
  right:0;
  background:rgba(0,0,0,0.55);
  color:#fff;
  padding:10px;
  margin:0;
  font-size:16px;
  text-align:center;
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

  <!-- ***** Main Banner Area Start ***** -->
  <div class="about-main-content">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="content">
            <div class="blur-bg"></div>
            <h4>EXPLORE OUR KORAT</h4>
            <div class="line-dec"></div>
            <h2>Welcome To KORAT</h2>
            <div class="main-button">
              <a href="review.php">Discover More</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
    <?php
  /* ================= ALL PLACE IN KORAT ================= */
  $placeSql = "
    SELECT TOP 12
      Blog_ID,
      Title,
      Image
    FROM Blog
    ORDER BY Create_At DESC
  ";
  $placeQ = sqlsrv_query($conn, $placeSql);
  ?>

  <!-- ***** Main Banner Area End ***** -->
<div class="cities-town">
  <div class="container">
    <div class="row">
      <div class="slider-content">
        <div class="row">
          <div class="col-lg-12">
            <h2>All Place in <em>Korat Cities</em></h2>
          </div>
          <div class="col-lg-12">
            <div class="owl-cites-town owl-carousel">

              <?php while($p = sqlsrv_fetch_array($placeQ, SQLSRV_FETCH_ASSOC)): ?>
                <div class="item">
                  <div class="thumb">
                    <img src="uploads/blogs/<?= htmlspecialchars($p['Image']) ?>" alt="">
                    <h4><?= htmlspecialchars($p['Title']) ?></h4>
                  </div>
                </div>
              <?php endwhile; ?>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

  <div class="call-to-action">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <h2>Are You Looking To Travel ?</h2>
          <h4>Make A Easy By Clicking The Button</h4>
        </div>
        <div class="col-lg-4">
          <div class="border-button">
            <a href="review.php">Explore reviews more</a>
          </div>
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
  </script>

  </body>

</html>
