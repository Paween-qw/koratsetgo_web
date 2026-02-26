<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$role = $_SESSION['role'] ?? 'guest';
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!-- ***** Header Area Start ***** -->
<header class="header-area header-sticky">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <nav class="main-nav">

          <!-- LOGO -->
          <a href="index.php" class="logo korat-logo">
            <img src="assets/images/koratsetgolg1.png"
                 alt="KoratSetGo"
                 class="logo-img">
          </a>

          <!-- NAV MENU -->
          <ul class="nav">
            <li>
              <a href="index.php"
                 class="<?= $currentPage=='index.php'?'active':'' ?>">
                 Home
              </a>
            </li>

            <?php if($role !== "guest"){ ?>
              <li>
                <a href="place.php"
                   class="<?= $currentPage=='place.php'?'active':'' ?>">
                   Place
                </a>
              </li>

              <li>
                <a href="review.php"
                   class="<?= $currentPage=='review.php'?'active':'' ?>">
                   Blog&Vlog Reviews
                </a>
              </li>

              <li>
                <a href="blogandvlog.php"
                   class="<?= $currentPage=='blogandvlog.php'?'active':'' ?>">
                   Make Your Blog&Vlog
                </a>
              </li>
            <?php } ?>

            <!-- USER DASHBOARD -->
            <?php if($role !== "guest" && $role !== "admin"){ ?>
              <li>
                <a href="user/dashboard.php"
                   class="<?= str_starts_with($currentPage,'dashboard')?'active':'' ?>">
                   My Profile
                </a>
              </li>
            <?php } ?>

            <!-- ADMIN -->
            <?php if($role === "admin"){ ?>
              <li>
                <a href="admin/dashboard.php"
                   class="<?= str_starts_with($currentPage,'dashboard')?'active':'' ?>"
                   style="color:#00bcd4;font-weight:600;">
                   Admin
                </a>
              </li>
            <?php } ?>

            <!-- AUTH -->
            <?php if($role === "guest"){ ?>
              <li>
                <a href="signin.php"
                   class="<?= $currentPage=='signin.php'?'active':'' ?>">
                   Sign in
                </a>
              </li>
            <?php } else { ?>
              <li>
                <a href="logout.php">
                  Logout (<?= htmlspecialchars($_SESSION['name']) ?>)
                </a>
              </li>
            <?php } ?>
          </ul>

          <!-- MOBILE MENU -->
          <a class="menu-trigger">
            <span>Menu</span>
          </a>

        </nav>
      </div>
    </div>
  </div>
</header>
<!-- ***** Header Area End ***** -->
