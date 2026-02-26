<?php
session_start();
include("includes/connect.php");

if(!isset($_SESSION['user_id'])){
    echo json_encode(['status'=>'error']);
    exit();
}

$user_id = $_SESSION['user_id'];
$type = $_POST['type'] ?? '';
$id   = (int)($_POST['id'] ?? 0);

if(!$type || !$id){
    echo json_encode(['status'=>'error']);
    exit();
}

if($type === 'blog'){
    $checkSql = "SELECT Like_ID FROM BlogLike WHERE Blog_ID=? AND User_ID=?";
    $table    = "BlogLike";
    $col      = "Blog_ID";
} else {
    $checkSql = "SELECT Like_ID FROM VlogLike WHERE Vlog_ID=? AND User_ID=?";
    $table    = "VlogLike";
    $col      = "Vlog_ID";
}

$checkStmt = sqlsrv_query($conn, $checkSql, [$id, $user_id]);
$exists = sqlsrv_fetch_array($checkStmt, SQLSRV_FETCH_ASSOC);

if($exists){
    // UNLIKE
    sqlsrv_query(
        $conn,
        "DELETE FROM $table WHERE $col=? AND User_ID=?",
        [$id, $user_id]
    );
    $status = 'unliked';
} else {
    // LIKE
    sqlsrv_query(
        $conn,
        "INSERT INTO $table ($col, User_ID, Created_At)
         VALUES (?, ?, GETDATE())",
        [$id, $user_id]
    );
    $status = 'liked';
}

// นับจำนวนใหม่
$countStmt = sqlsrv_query(
    $conn,
    "SELECT COUNT(*) AS c FROM $table WHERE $col=?",
    [$id]
);
$countRow = sqlsrv_fetch_array($countStmt, SQLSRV_FETCH_ASSOC);

echo json_encode([
    'status' => $status,
    'count'  => (int)$countRow['c']
]);
