<?php
session_start();
include("../includes/connect.php");

if(!isset($_SESSION['user_id'])){
  header("Location: ../signin.php");
  exit;
}

$userId = $_SESSION['user_id'];

/* ================= USER ================= */
$uQ = sqlsrv_query($conn,"
  SELECT Full_Name, Profile_Pic
  FROM [User]
  WHERE User_ID=?
",[$userId]);
$user = sqlsrv_fetch_array($uQ,SQLSRV_FETCH_ASSOC);

/* ================= COUNTS ================= */
function getCount($conn,$sql,$p){
  $q = sqlsrv_query($conn,$sql,$p);
  return (int)sqlsrv_fetch_array($q,SQLSRV_FETCH_ASSOC)['c'];
}

$blogCount = getCount($conn,"SELECT COUNT(*) c FROM Blog WHERE User_ID=?",[$userId]);
$vlogCount = getCount($conn,"SELECT COUNT(*) c FROM Vlog WHERE User_ID=?",[$userId]);

/* ================= TOTAL LIKES ================= */
$qLike = sqlsrv_query($conn,"
SELECT SUM(cnt) total FROM (
  SELECT COUNT(*) cnt FROM BlogLike BL
  JOIN Blog B ON BL.Blog_ID=B.Blog_ID
  WHERE B.User_ID=?
  UNION ALL
  SELECT COUNT(*) FROM VlogLike VL
  JOIN Vlog V ON VL.Vlog_ID=V.Vlog_ID
  WHERE V.User_ID=?
) x
",[$userId,$userId]);

$totalLikes = (int)sqlsrv_fetch_array($qLike,SQLSRV_FETCH_ASSOC)['total'];

/* ================= BLOG ================= */
$blogQ = sqlsrv_query($conn,"
  SELECT Blog_ID id, Image media
  FROM Blog
  WHERE User_ID=?
  ORDER BY Create_At DESC
",[$userId]);

/* ================= VLOG ================= */
$vlogQ = sqlsrv_query($conn,"
  SELECT Vlog_ID id, Thumbnail media
  FROM Vlog
  WHERE User_ID=?
  ORDER BY Create_At DESC
",[$userId]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>User Dashboard</title>
<link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">

<style>
/* ===== BASE ===== */
html,body{margin:0;height:100%}
body{
  background:radial-gradient(circle at top,#0f5c82,#083a56,#062c42);
  font-family:"Segoe UI",sans-serif;
}

/* ===== BACK HOME ===== */
.back-home{
  position:fixed;
  top:20px;
  left:20px;
  z-index:9;
}
.back-home a{
  color:#fff;
  border:1px solid rgba(255,255,255,.4);
  padding:8px 14px;
  border-radius:10px;
  text-decoration:none;
}
.back-home a:hover{
  background:rgba(255,255,255,.15);
}

/* ===== LAYOUT ===== */
.dashboard-wrap{
  max-width:1200px;
  padding-top:90px;
}

/* ===== PROFILE CARD ===== */
.profile-card{
  background:#fff;
  border-radius:18px;
  padding:36px;
  box-shadow:0 30px 80px rgba(0,0,0,.25);
}

/* ===== AVATAR ===== */
.avatar{
  width:150px;
  height:150px;
  border-radius:50%;
  overflow:hidden;
  background:#e5eef5;
  display:flex;
  align-items:center;
  justify-content:center;
}
.avatar img{width:100%;height:100%;object-fit:cover}
.avatar-text{
  font-size:48px;
  font-weight:700;
  color:#0c4f73;
}

/* ===== STATS ===== */
.stat-box b{font-size:18px;font-weight:700}

/* ===== SECTION TITLE ===== */
.section-title{
  color:#fff;
  font-weight:600;
  margin:40px 0 12px;
  display:flex;
  align-items:center;
  gap:10px;
}
.section-title::after{
  content:"";
  flex:1;
  height:1px;
  background:rgba(255,255,255,.3);
}

/* ===== SLIDER WRAP ===== */
.slider-wrap{
  position:relative;
}

/* ===== SLIDER ===== */
.slider{
  display:flex;
  gap:14px;
  overflow-x:auto;
  padding:10px 0 14px;
  scroll-behavior:smooth;
}
.slider::-webkit-scrollbar{display:none}

/* ===== POST CARD ===== */
.post-card{
  width:220px;
  height:220px;
  border-radius:16px;
  overflow:hidden;
  background:#000;
  position:relative;
  flex-shrink:0;
}
.post-card img{
  width:100%;
  height:100%;
  object-fit:cover;
}

/* ===== BADGE ===== */
.badge-type{
  position:absolute;
  top:8px;
  right:8px;
  background:rgba(0,0,0,.6);
  color:#fff;
  font-size:12px;
  padding:4px 10px;
  border-radius:999px;
}

/* ===== SLIDE BUTTON (BALANCED) ===== */
.slide-btn{
  position:absolute;
  top:50%;
  transform:translateY(-50%);
  
  width:48px;          /* 🔧 ขนาดพอดี */
  height:48px;
  border-radius:50%;

  border:1px solid rgba(0,229,255,.45);   /* บางลง */
  background:rgba(0,0,0,.35);             /* เบาลง */

  color:#00e5ff;
  font-size:22px;      /* 🔧 ลูกศรไม่ล้น */
  font-weight:600;

  cursor:pointer;
  z-index:5;

  display:flex;
  align-items:center;
  justify-content:center;

  backdrop-filter:blur(6px);
  transition:.25s;
}

.slide-btn:hover{
  transform:translateY(-50%) scale(1.08);
  background:rgba(0,0,0,.55);
}

/* POSITION */
.slide-btn.left{ left:-54px; }
.slide-btn.right{ right:-54px; }


/* ===== RESPONSIVE ===== */
@media(max-width:768px){
  .slide-btn{display:none}
  .post-card{width:170px;height:170px}
  .avatar{width:120px;height:120px}
}

/* ===== AVATAR CLICK ===== */
.avatar-click{
  position:relative;
  cursor:pointer;
}

.avatar-overlay{
  position:absolute;
  inset:0;
  background:rgba(0,0,0,.45);
  color:#fff;
  font-size:14px;
  font-weight:600;
  display:flex;
  align-items:center;
  justify-content:center;
  opacity:0;
  transition:.25s;
}

.avatar-click:hover .avatar-overlay{
  opacity:1;
}

</style>
</head>

<?php if(isset($_GET['updated']) && $_GET['updated'] == 1): ?>
<script>
  alert("✅ Profile updated successfully!");
</script>
<?php endif; ?>

<body>

<div class="back-home">
  <a href="../index.php">← Back to Home</a>
</div>

<div class="container-fluid">
<div class="mx-auto dashboard-wrap">

  <!-- PROFILE -->
  <div class="profile-card mb-4">
    <div class="row align-items-center">
      <div class="col-md-3 text-center mb-3 mb-md-0">
<div class="avatar mx-auto avatar-click"
     onclick="document.getElementById('avatarInput').click()">

  <?php if(!empty($user['Profile_Pic'])): ?>
    <img src="../uploads/profile/<?= htmlspecialchars($user['Profile_Pic']) ?>"
         id="avatarPreview">
  <?php else: ?>
    <div class="avatar-text" id="avatarPreview">
      <?= strtoupper($user['Full_Name'][0]) ?>
    </div>
  <?php endif; ?>

  <div class="avatar-overlay">Change</div>
</div>

<form id="avatarForm"
      action="upload_avatar.php"
      method="post"
      enctype="multipart/form-data">
  <input type="file"
         name="avatar"
         id="avatarInput"
         accept="image/*"
         hidden>
</form>
      </div>

      <div class="col-md-9">
        <h3 class="fw-bold"><?= htmlspecialchars($user['Full_Name']) ?></h3>

        <div class="d-flex gap-4 mb-3">
          <div class="stat-box"><b><?= $blogCount ?></b> blogs</div>
          <div class="stat-box"><b><?= $vlogCount ?></b> vlogs</div>
          <div class="stat-box"><b><?= $totalLikes ?></b> likes</div>
        </div>

        <p class="text-muted mb-3">
          I will share travel stories for you to enjoy 🌍
        </p>

        <a href="../blog.php" class="btn btn-primary me-2">Create Content</a>
        <a href="edit_profile.php" class="btn btn-outline-secondary">Edit Profile</a>
      </div>
    </div>
  </div>

  <!-- BLOG -->
  <div class="section-title">📝 My Blogs</div>
  <div class="slider-wrap">
    <button class="slide-btn left" onclick="slide(this,-240)">←</button>
    <div class="slider">
      <?php while($b = sqlsrv_fetch_array($blogQ,SQLSRV_FETCH_ASSOC)): ?>
        <a href="../review_detail.php?type=blog&id=<?= $b['id'] ?>" class="post-card">
          <img src="../uploads/blogs/<?= htmlspecialchars($b['media']) ?>">
          <span class="badge-type">Blog</span>
        </a>
      <?php endwhile; ?>
    </div>
    <button class="slide-btn right" onclick="slide(this,240)">→</button>
  </div>

  <!-- VLOG -->
  <div class="section-title">🎬 My Vlogs</div>
  <div class="slider-wrap">
    <button class="slide-btn left" onclick="slide(this,-240)">←</button>
    <div class="slider">
      <?php while($v = sqlsrv_fetch_array($vlogQ,SQLSRV_FETCH_ASSOC)): ?>
        <a href="../review_detail.php?type=vlog&id=<?= $v['id'] ?>" class="post-card">
          <img src="../uploads/vlogs/<?= htmlspecialchars($v['media']) ?>">
          <span class="badge-type">Vlog</span>
        </a>
      <?php endwhile; ?>
    </div>
    <button class="slide-btn right" onclick="slide(this,240)">→</button>
  </div>

</div>
</div>

<script>
function slide(btn,amount){
  btn.parentElement.querySelector('.slider')
     .scrollBy({left:amount,behavior:'smooth'});
}

document.getElementById('avatarInput').addEventListener('change',function(){
  if(!this.files.length) return;

  const file = this.files[0];

  // preview ทันที
  const reader = new FileReader();
  reader.onload = e=>{
    let img = document.getElementById('avatarPreview');

    if(img.tagName !== 'IMG'){
      img = document.createElement('img');
      img.id = 'avatarPreview';
      document.querySelector('.avatar-click').innerHTML = '';
      document.querySelector('.avatar-click').appendChild(img);
    }

    img.src = e.target.result;
  };
  reader.readAsDataURL(file);

  // ส่งฟอร์ม
  document.getElementById('avatarForm').submit();
});
</script>

</body>
</html>
