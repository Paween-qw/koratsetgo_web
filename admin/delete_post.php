<?php
session_start();
include("../includes/connect.php");

/* admin only */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../signin.php");
    exit;
}

$type = $_GET['type'] ?? '';
$id   = (int)($_GET['id'] ?? 0);

if(!$id || !in_array($type,['blog','vlog'])){
    die("Invalid request");
}

/* ===== BLOG ===== */
if($type === 'blog'){

    sqlsrv_query($conn,"DELETE FROM BlogLike WHERE Blog_ID=?",[$id]);
    sqlsrv_query($conn,"DELETE FROM BlogTag WHERE Blog_ID=?",[$id]);
    sqlsrv_query($conn,"DELETE FROM Travel_Expense WHERE Blog_ID=?",[$id]);
    sqlsrv_query($conn,"DELETE FROM BlogImage WHERE Blog_ID=?",[$id]);

    $stmt = sqlsrv_query($conn,"DELETE FROM Blog WHERE Blog_ID=?",[$id]);
}

/* ===== VLOG ===== */
if($type === 'vlog'){

    sqlsrv_query($conn,"DELETE FROM VlogLike WHERE Vlog_ID=?",[$id]);
    sqlsrv_query($conn,"DELETE FROM VlogTag WHERE Vlog_ID=?",[$id]);

    /* 🔥 ตัวนี้แหละที่ขาด */
    sqlsrv_query($conn,"DELETE FROM Travel_Expense WHERE Vlog_ID=?",[$id]);

    $stmt = sqlsrv_query($conn,"DELETE FROM Vlog WHERE Vlog_ID=?",[$id]);
}

if($stmt === false){
    die(print_r(sqlsrv_errors(),true));
}

header("Location: admin_posts.php?deleted=1");
exit;
