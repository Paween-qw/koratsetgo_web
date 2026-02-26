<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>KoratSetGo - Register</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
/* ===== ROOT COLOR ===== */
:root{
  --sea-dark:#0b3c5d;
  --sea:#0f5c8e;
  --sea-light:#00b4ff;
}

/* ===== BODY ===== */
body{
  min-height:100vh;
  display:flex;
  justify-content:center;
  align-items:center;
  font-family:'Segoe UI', sans-serif;
  background: linear-gradient(180deg, #06293f, #0b3c5d);
  padding:20px;
}

/* ===== REGISTER CARD ===== */
.register-box{
  background:#ffffff;
  width:100%;
  max-width:560px;
  padding:40px;
  border-radius:24px;
  box-shadow:0 25px 60px rgba(0,0,0,.35);
  animation:fadeUp .6s ease;
}

/* ===== LOGO ===== */
.logo{
  text-align:center;
  margin-bottom:10px;
}
.logo img{
  height:120px;
}
.subtitle{
  text-align:center;
  color:#555;
  margin-bottom:30px;
}

/* ===== FORM ===== */
.form-label{
  font-size:14px;
  font-weight:600;
  color:#333;
}

.form-control,
.form-select{
  border-radius:12px;
  padding:12px 14px;
  font-size:14px;
}

.form-control:focus,
.form-select:focus{
  border-color:var(--sea-light);
  box-shadow:0 0 0 3px rgba(0,180,255,.25);
}

/* ===== BUTTON ===== */
.btn-register{
  background:linear-gradient(135deg, var(--sea-light), #0077ff);
  border:none;
  color:#fff;
  font-weight:600;
  padding:14px;
  border-radius:14px;
  transition:.3s;
}

.btn-register:hover{
  transform:translateY(-2px);
  box-shadow:0 12px 30px rgba(0,180,255,.45);
}

/* ===== BACK BUTTON ===== */
.back-btn{
  position:fixed;
  top:20px;
  left:20px;
  color:#fff;
  border:1px solid rgba(255,255,255,.4);
  padding:8px 14px;
  border-radius:999px;
  text-decoration:none;
  backdrop-filter:blur(6px);
}

/* ===== ANIMATION ===== */
@keyframes fadeUp{
  from{opacity:0; transform:translateY(20px);}
  to{opacity:1; transform:none;}
}

/* ===== DARK MODE AUTO ===== */
@media (prefers-color-scheme: dark){
  .register-box{
    background:#ffffff;
  }
}

/* ===== MOBILE ===== */
@media(max-width:576px){
  .register-box{
    padding:30px 22px;
  }
  .logo img{
    height:50px;
  }
}
</style>
</head>

<body>

<!-- Back -->
<a href="signin.php" class="back-btn">← Back</a>

<div class="register-box">

  <!-- LOGO -->
  <div class="logo">
    <!-- เปลี่ยนเป็นโลโก้จริงของคุณ -->
    <img src="assets/images/koratsetgolg1.png" alt="KoratSetGo">
  </div>
  <div class="subtitle">Create your KoratSetGo account</div>

  <form action="register_save.php" method="post" enctype="multipart/form-data">

    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Username</label>
        <input type="text" name="user_id" class="form-control" required>
      </div>

      <div class="col-md-6">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
    </div>

    <div class="mt-3">
      <label class="form-label">Full Name</label>
      <input type="text" name="full_name" class="form-control" required>
    </div>

    <div class="mt-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control">
    </div>

    <div class="mt-3">
      <label class="form-label">Phone</label>
      <input type="text" name="phone" class="form-control">
    </div>

    <div class="row g-3 mt-1">
      <div class="col-md-6">
        <label class="form-label">Date of Birth</label>
        <input type="date" name="dob" class="form-control">
      </div>

      <div class="col-md-6">
        <label class="form-label">Gender</label>
        <select name="gender" class="form-select">
          <option value="">Select</option>
          <option>Male</option>
          <option>Female</option>
          <option>Other</option>
        </select>
      </div>
    </div>

    <div class="mt-3">
      <label class="form-label">Profile Picture</label>
      <input type="file" name="profile" class="form-control">
    </div>

    <button type="submit" class="btn btn-register w-100 mt-4">
      Create Account
    </button>

  </form>
</div>

</body>
</html>
