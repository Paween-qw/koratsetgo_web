<?php
session_start();
include("includes/connect.php");

if(!isset($_SESSION['user_id'])){
    header("Location: signin.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$type = $_POST['type'] ?? '';
$id   = (int)($_POST['id'] ?? 0);

if(!$type || !$id){
    die("Invalid request");
}

if($type === 'blog'){

    // เช็คว่ากดไลค์ไปแล้วยัง
    $check = sqlsrv_query(
        $conn,
        "SELECT 1 FROM BlogLike WHERE Blog_ID=? AND User_ID=?",
        [$id, $user_id]
    );

    if(sqlsrv_fetch_array($check) === null){
        sqlsrv_query(
            $conn,
            "INSERT INTO BlogLike (Blog_ID, User_ID, Created_At)
             VALUES (?, ?, GETDATE())",
            [$id, $user_id]
        );
    }

} elseif($type === 'vlog'){

    $check = sqlsrv_query(
        $conn,
        "SELECT 1 FROM VlogLike WHERE Vlog_ID=? AND User_ID=?",
        [$id, $user_id]
    );

    if(sqlsrv_fetch_array($check) === null){
        sqlsrv_query(
            $conn,
            "INSERT INTO VlogLike (Vlog_ID, User_ID, Created_At)
             VALUES (?, ?, GETDATE())",
            [$id, $user_id]
        );
    }

}

header("Location: ".$_SERVER['HTTP_REFERER']);
exit();
