<?php
session_start();
include("includes/connect.php");
header('Content-Type: application/json; charset=utf-8');

if(!isset($_SESSION['user_id'])){
  echo json_encode(['status'=>'login']);
  exit;
}

$user_id = $_SESSION['user_id'];
$type = $_POST['type'] ?? '';
$id   = (int)($_POST['id'] ?? 0);
$text = trim($_POST['comment'] ?? '');

if(!$type || !$id || $text===''){
  echo json_encode(['status'=>'error']);
  exit;
}

/* COOLDOWN 10 วินาที */
$_SESSION['last_comment'] ??= 0;
if(time() - $_SESSION['last_comment'] < 10){
  echo json_encode(['status'=>'cooldown']);
  exit;
}

/* INSERT COMMENT */
if($type === 'blog'){
  $stmt = sqlsrv_query(
    $conn,
    "INSERT INTO BlogComment (Blog_ID,User_ID,Comment_Text,Created_At)
     OUTPUT INSERTED.Comment_ID
     VALUES (?,?,?,GETDATE())",
    [$id,$user_id,$text]
  );
} else {
  $stmt = sqlsrv_query(
    $conn,
    "INSERT INTO VlogComment (Vlog_ID,User_ID,Comment_Text,Created_At)
     OUTPUT INSERTED.Comment_ID
     VALUES (?,?,?,GETDATE())",
    [$id,$user_id,$text]
  );
}

if(!$stmt){
  echo json_encode(['status'=>'error']);
  exit;
}

/* ดึง comment_id ที่เพิ่ง insert */
$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
$comment_id = (int)$row['Comment_ID'];

$_SESSION['last_comment'] = time();

/* 🔴 สำคัญ: ใช้ table + field ให้ตรงกับหน้าเว็บ */
$u = sqlsrv_query(
  $conn,
  "SELECT Full_Name FROM [User] WHERE User_ID=?",
  [$user_id]
);
$user = sqlsrv_fetch_array($u, SQLSRV_FETCH_ASSOC);

echo json_encode([
  'status'     => 'ok',
  'comment_id' => $comment_id,
  'name'       => htmlspecialchars($user['Full_Name'], ENT_QUOTES, 'UTF-8'),
  'text'       => htmlspecialchars($text, ENT_QUOTES, 'UTF-8')
]);
