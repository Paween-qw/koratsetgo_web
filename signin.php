<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>KoratSetGo - Sign In</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
/* =======================
   THEME VARIABLE
   ======================= */
:root{
  --ocean:#0b3c5d;
  --ocean-soft:#145c85;
  --card-bg:rgba(255,255,255,0.15);
  --text:#0b3c5d;
}

/* AUTO DARK MODE */
@media (prefers-color-scheme: dark){
  :root{
    --card-bg:rgba(20,30,40,0.55);
    --text:#ffffff;
  }
}

/* =======================
   BACKGROUND WAVE
   ======================= */
body{
  height:100vh;
  margin:0;
  display:flex;
  justify-content:center;
  align-items:center;
  font-family:'Segoe UI',sans-serif;
  background:linear-gradient(-45deg,#0b3c5d,#08304a,#0e5f8a,#08304a);
  background-size:400% 400%;
  animation:waveBG 18s ease infinite;
}

@keyframes waveBG{
  0%{background-position:0% 50%}
  50%{background-position:100% 50%}
  100%{background-position:0% 50%}
}

/* =======================
   BACK BUTTON
   ======================= */
.back-btn{
  position:fixed;
  top:20px;
  left:20px;
  z-index:10;
  color:#fff;
  border:1px solid rgba(255,255,255,.6);
}
.back-btn:hover{
  background:#fff;
  color:#0b3c5d;
}

/* =======================
   GLASS LOGIN CARD
   ======================= */
.login-box{
  background:#ffffff;          /* ✅ พื้นขาว */
  color:#0b3c5d;               /* ตัวหนังสือเข้ม */
  border-radius:20px;
  padding:40px 35px;
  width:380px;
  box-shadow:0 25px 60px rgba(0,0,0,.25);
}


/* =======================
   LOGO
   ======================= */
.logo{
  text-align:center;
  margin-bottom:10px;
}
.logo img{
  width:180px;
  transition:.3s;
}

/* RESPONSIVE LOGO */
@media(max-width:480px){
  .login-box{width:92%;}
  .logo img{width:70px;}
}

/* =======================
   TEXT
   ======================= */
.subtitle{
  text-align:center;
  color:#ddd;
  margin-bottom:25px;
}

/* =======================
   BUTTONS
   ======================= */
.btn-ocean{
  background:linear-gradient(135deg,#00c6ff,#0072ff);
  color:#fff;
  border:none;
  font-weight:600;
}

.btn-ocean:hover{
  opacity:.9;
}

.btn-outline-ocean{
  border:2px solid #00c6ff;
  color:#00c6ff;
}
.btn-outline-ocean:hover{
  background:#00c6ff;
  color:#000;
}
.subtitle{
  color:#555;
}
.form-label{
  color:#0b3c5d;
  font-weight:500;
}
</style>
</head>

<body>

<a href="index.php" class="btn back-btn">← Back to Home</a>

<div class="login-box">

  <!-- LOGO -->
  <div class="logo">
    <img src="assets/images/koratsetgolg1.png" alt="KoratSetGo">
  </div>

  <div class="subtitle">Sign in to your account</div>

  <?php if(isset($_GET['success'])){ ?>
    <div class="alert alert-success text-center">
      ✅ Register successful! Please sign in.
    </div>
  <?php } ?>

  <?php if(isset($_GET['error'])){ ?>
    <div class="alert alert-danger text-center">
      ❌ Username or Password incorrect
    </div>
  <?php } ?>

  <form action="check_login.php" method="post">
    <div class="mb-3">
      <label class="form-label">Username</label>
      <input type="text" name="username" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>

    <button class="btn btn-ocean w-100 mt-2">Sign In</button>
  </form>

  <div class="text-center mt-4">
    <small>Don't have an account?</small><br>
    <a href="register.php" class="btn btn-outline-ocean w-100 mt-2">
      Create Account
    </a>
  </div>

</div>

</body>
</html>
