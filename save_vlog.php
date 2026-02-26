<?php
session_start();
include("includes/connect.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* ================= รับค่า ================= */
$title      = trim($_POST['title'] ?? '');
$content    = trim($_POST['content'] ?? '');
$hashtags   = trim($_POST['hashtags'] ?? '');
$total_cost = (int)($_POST['total_cost'] ?? 0);

/* ================= Validate ================= */
if ($title === '' || $content === '' || $hashtags === '') {
    die("Required fields missing");
}

/* ================= Upload Video ================= */
$video_path = null;

if (!empty($_FILES['video']['name'])) {
    $folder = "uploads/vlogs/";
    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    $video_path = time() . '_' . basename($_FILES['video']['name']);

    if (!move_uploaded_file($_FILES['video']['tmp_name'], $folder . $video_path)) {
        die("Upload video failed");
    }
}

/* ================= Begin Transaction ================= */
sqlsrv_begin_transaction($conn);

try {

    /* ================= Insert Vlog ================= */
    $sqlVlog = "
        INSERT INTO Vlog (User_ID, Title, Content, Video_Path, Create_At)
        OUTPUT INSERTED.Vlog_ID
        VALUES (?, ?, ?, ?, GETDATE())
    ";

    $stmtVlog = sqlsrv_query($conn, $sqlVlog, [
        $user_id,
        $title,
        $content,
        $video_path
    ]);

    if (!$stmtVlog) {
        throw new Exception("Insert Vlog failed");
    }

    $row = sqlsrv_fetch_array($stmtVlog, SQLSRV_FETCH_ASSOC);
    $vlog_id = (int)$row['Vlog_ID'];

    /* ================= Insert Travel Expense (Total Cost) ================= */
    if ($total_cost > 0) {
        $sqlExpense = "
            INSERT INTO Travel_Expense
            (Vlog_ID, Total_Cost, Create_At)
            VALUES (?, ?, GETDATE())
        ";

        $stmtExpense = sqlsrv_query($conn, $sqlExpense, [
            $vlog_id,
            $total_cost
        ]);

        if (!$stmtExpense) {
            throw new Exception("Insert Travel_Expense failed");
        }
    }

    /* ================= Insert Hashtags ================= */
    $tags = preg_split('/\s+/', $hashtags);
    $sqlTag = "INSERT INTO VlogTag (Vlog_ID, Tag) VALUES (?, ?)";

    foreach ($tags as $tag) {
        $tag = trim($tag);
        if ($tag !== '') {
            if (!sqlsrv_query($conn, $sqlTag, [$vlog_id, $tag])) {
                throw new Exception("Insert VlogTag failed");
            }
        }
    }

    /* ================= Commit ================= */
    sqlsrv_commit($conn);

    header("Location: blogandvlog.php?success=1");
    exit();

} catch (Exception $e) {

    /* ================= Rollback ================= */
    sqlsrv_rollback($conn);

    die("Save vlog failed: " . $e->getMessage());
}
