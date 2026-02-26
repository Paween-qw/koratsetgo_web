<?php
session_start();
include("includes/connect.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* ================= รับค่า ================= */
$title          = trim($_POST['title'] ?? '');
$content        = trim($_POST['content'] ?? '');
$type_car       = trim($_POST['type_car'] ?? '');
$total_cost     = (int)($_POST['total_cost'] ?? 0);
$trip_days      = (int)($_POST['trip_days'] ?? 0);
$traveler_count = (int)($_POST['traveler_count'] ?? 0);
$hashtags       = trim($_POST['hashtags'] ?? '');

/* ================= Validate ================= */
if ($title === '' || $content === '' || $hashtags === '') {
    die("Required fields missing");
}

if (empty($_FILES['images']['name'][0])) {
    die("Please upload at least one image");
}

/* ================= Upload Dir ================= */
$uploadDir = "uploads/blogs/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

/* ================= Begin Transaction ================= */
sqlsrv_begin_transaction($conn);

try {

    /* ================= Insert Blog (ยังไม่ใส่ cover) ================= */
    $sqlBlog = "
        INSERT INTO Blog (User_ID, Title, Content, Image, Create_At)
        OUTPUT INSERTED.Blog_ID
        VALUES (?, ?, ?, NULL, GETDATE())
    ";

    $stmtBlog = sqlsrv_query($conn, $sqlBlog, [
        $user_id,
        $title,
        $content
    ]);

    if (!$stmtBlog) {
        throw new Exception("Insert Blog failed");
    }

    $row = sqlsrv_fetch_array($stmtBlog, SQLSRV_FETCH_ASSOC);
    $blog_id = (int)$row['Blog_ID'];

    /* ================= Upload Images ================= */
    $cover_image = null;

    foreach ($_FILES['images']['tmp_name'] as $i => $tmp) {

        if ($tmp == '') continue;

        $filename = time().'_'.$i.'_'.basename($_FILES['images']['name'][$i]);

        if (!move_uploaded_file($tmp, $uploadDir.$filename)) {
            throw new Exception("Upload image failed");
        }

        // รูปแรก = cover
        if ($cover_image === null) {
            $cover_image = $filename;
        }

        $imgStmt = sqlsrv_query(
            $conn,
            "INSERT INTO BlogImage (Blog_ID, Image_Path, Create_At)
             VALUES (?, ?, GETDATE())",
            [$blog_id, $filename]
        );

        if (!$imgStmt) {
            throw new Exception("Insert BlogImage failed");
        }
    }

    /* ================= Update Cover Image ================= */
    sqlsrv_query(
        $conn,
        "UPDATE Blog SET Image=? WHERE Blog_ID=?",
        [$cover_image, $blog_id]
    );

    /* ================= Insert Travel Info ================= */
    $sqlExpense = "
        INSERT INTO Travel_Expense
        (Blog_ID, Type_Car, Total_Cost, Trip_Days, Traveler_Count, Create_At)
        VALUES (?, ?, ?, ?, ?, GETDATE())
    ";

    $stmtExpense = sqlsrv_query($conn, $sqlExpense, [
        $blog_id,
        $type_car,
        $total_cost,
        $trip_days,
        $traveler_count
    ]);

    if (!$stmtExpense) {
        throw new Exception("Insert Travel_Expense failed");
    }

    /* ================= Insert Hashtags ================= */
    $tags = preg_split('/\s+/', $hashtags);
    $sqlTag = "INSERT INTO BlogTag (Blog_ID, Tag) VALUES (?, ?)";

    foreach ($tags as $tag) {
        $tag = trim($tag);
        if ($tag !== '') {
            if (!sqlsrv_query($conn, $sqlTag, [$blog_id, $tag])) {
                throw new Exception("Insert BlogTag failed");
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

    die("Save blog failed: " . $e->getMessage());
}
