<?php
include("includes/connect.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: register.php");
    exit();
}

$user_id   = $_POST['user_id'];
$password  = $_POST['password'];
$full_name = $_POST['full_name'];
$email     = $_POST['email'];
$phone     = $_POST['phone'];
$dob       = $_POST['dob'];
$gender    = $_POST['gender'];


// =========================
// HASH PASSWORD
// =========================
$hash = password_hash($password, PASSWORD_DEFAULT);


// =========================
// UPLOAD PROFILE PIC
// =========================
$profile_pic = null;
if (!empty($_FILES['profile']['name'])) {
    $folder = "uploads/";

    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    $ext = pathinfo($_FILES['profile']['name'], PATHINFO_EXTENSION);
    $fileName = uniqid() . "." . $ext;

    move_uploaded_file($_FILES['profile']['tmp_name'], $folder . $fileName);
    $profile_pic = $fileName;
}


// =========================
// CHECK DUPLICATE
// =========================
$check = sqlsrv_query(
    $conn,
    "SELECT User_ID FROM [User] WHERE User_ID = ? OR Email = ?",
    [$user_id, $email]
);

if (sqlsrv_has_rows($check)) {
    header("Location: register.php?error=duplicate");
    exit();
}


// =========================
// INSERT USER (Role_ID = 2 = user)
// =========================
$sql = "INSERT INTO [User]
(User_ID, Password, Full_Name, Email, Phone_No, Date_of_Birth, Gender, Profile_Pic, Role_ID, Created_At)
VALUES (?,?,?,?,?,?,?,?,2,GETDATE())";

$params = [
    $user_id,
    $hash,
    $full_name,
    $email,
    $phone,
    $dob,
    $gender,
    $profile_pic
];

$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt) {
    header("Location: signin.php?success=1");
    exit();
} else {
    echo "Register Failed<br>";
    print_r(sqlsrv_errors());
}
?>
