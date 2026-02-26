<?php
session_start();
include("../includes/connect.php");

if(!isset($_SESSION['user_id'])){
  header("Location: ../signin.php");
  exit;
}

if(empty($_FILES['avatar']['name'])){
  header("Location: dashboard.php");
  exit;
}

$userId = $_SESSION['user_id'];

$folder = "../uploads/profile/";
if(!is_dir($folder)){
  mkdir($folder,0777,true);
}

$ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
$filename = time().'_'.$userId.'.'.$ext;

move_uploaded_file(
  $_FILES['avatar']['tmp_name'],
  $folder.$filename
);

sqlsrv_query($conn,
  "UPDATE [User] SET Profile_Pic=? WHERE User_ID=?",
  [$filename,$userId]
);

header("Location: dashboard.php");
exit;
