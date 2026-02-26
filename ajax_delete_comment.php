<?php
session_start();
include("includes/connect.php");
header('Content-Type: application/json');

if(!isset($_SESSION['user_id'])){
  echo json_encode(['status'=>'login']); exit;
}

$user_id = $_SESSION['user_id'];
$type = $_POST['type'] ?? '';
$cid  = (int)($_POST['id'] ?? 0);

if(!$type || !$cid){
  echo json_encode(['status'=>'error']); exit;
}

if($type === 'blog'){
  $stmt = sqlsrv_query($conn,
    "DELETE FROM BlogComment WHERE Comment_ID=? AND User_ID=?",
    [$cid,$user_id]
  );
}else{
  $stmt = sqlsrv_query($conn,
    "DELETE FROM VlogComment WHERE Comment_ID=? AND User_ID=?",
    [$cid,$user_id]
  );
}

if($stmt === false){
  echo json_encode(['status'=>'error']); exit;
}

echo json_encode(['status'=>'ok']);

