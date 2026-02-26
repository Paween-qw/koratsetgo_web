<?php
session_start();
include("../includes/connect.php");

/* ===== CHECK LOGIN ===== */
if(!isset($_SESSION['user_id'])){
  header("Location: ../signin.php");
  exit;
}

$userId = $_SESSION['user_id'];

/* ===== RECEIVE DATA ===== */
$fullName = trim($_POST['full_name'] ?? '');
$email    = trim($_POST['email'] ?? '');
$phone    = trim($_POST['phone'] ?? '');
$gender   = trim($_POST['gender'] ?? '');
$dob      = $_POST['dob'] ?? null;

/* ===== BASIC VALIDATION ===== */
if($fullName === '' || $email === ''){
  header("Location: edit_profile.php?error=required");
  exit;
}

/* ===== UPDATE USER (NO USER_ID FROM FORM) ===== */
$sql = "
UPDATE [User]
SET
  Full_Name      = ?,
  Email          = ?,
  Phone_No       = ?,
  Gender         = ?,
  Date_of_Birth  = ?
WHERE User_ID = ?
";

$params = [
  $fullName,
  $email,
  $phone !== '' ? $phone : null,
  $gender !== '' ? $gender : null,
  $dob !== '' ? $dob : null,
  $userId
];

$stmt = sqlsrv_query($conn, $sql, $params);

if($stmt === false){
  die(print_r(sqlsrv_errors(), true));
}

/* ===== SUCCESS ===== */
header("Location: dashboard.php?updated=1");
exit;
