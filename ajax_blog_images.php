<?php
include("includes/connect.php");
header('Content-Type: application/json; charset=utf-8');

$id = (int)($_GET['id'] ?? 0);
$out = [];

if($id > 0){
    $q = sqlsrv_query(
        $conn,
        "SELECT Image_Path FROM BlogImage
         WHERE Blog_ID=?
         ORDER BY Image_ID ASC",
        [$id]
    );

    while($r = sqlsrv_fetch_array($q, SQLSRV_FETCH_ASSOC)){
        $out[] = $r['Image_Path'];
    }
}

echo json_encode($out);
