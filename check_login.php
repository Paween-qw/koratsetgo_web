<?php
session_start();
include("includes/connect.php");

$user = $_POST['username'];
$pass = $_POST['password'];

$sql = "
SELECT U.User_ID, U.Password, U.Full_Name, R.Role_Name
FROM [User] U
JOIN Role R ON U.Role_ID = R.Role_ID
WHERE U.User_ID = ? OR U.Email = ?
";

$stmt = sqlsrv_query($conn, $sql, [$user, $user]);
$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

if ($row) {

    if (password_verify($pass, $row['Password'])) {

        $_SESSION['user_id'] = $row['User_ID'];
        $_SESSION['name']    = $row['Full_Name'];
        $_SESSION['role']    = $row['Role_Name'];

        // Redirect by role
        if ($row['Role_Name'] === 'admin') {
            header("Location: admin/dashboard.php");
        } else {
            header("Location: index.php");
        }
        exit();

    } else {
        header("Location: signin.php?error=1");
        exit();
    }

} else {
    header("Location: signin.php?error=1");
    exit();
}
?>
