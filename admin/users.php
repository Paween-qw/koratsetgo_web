<?php
session_start();
include("../includes/connect.php");

/* อนุญาตเฉพาะ admin */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../signin.php");
    exit();
}

/* ดึง user + role name */
$sql = "
SELECT 
    u.User_ID,
    u.Full_Name,
    u.Email,
    u.Created_At,
    r.Role_Name
FROM [User] u
JOIN Role r ON u.Role_ID = r.Role_ID
ORDER BY u.Created_At DESC
";

$stmt = sqlsrv_query($conn, $sql);

if($stmt === false){
    die(print_r(sqlsrv_errors(), true));
}
?>
<!DOCTYPE html>
<html>
<head>
<title>User Management</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
    <h2>👥 User Management</h2>
    <a href="dashboard.php" class="btn btn-secondary mb-3">← Back</a>

    <table class="table table-bordered table-striped bg-white">
        <thead class="table-dark">
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Registered</th>
                <th>Change Role</th>
            </tr>
        </thead>
        <tbody>

        <?php while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) { ?>
        <tr>
            <td><?= htmlspecialchars($row['User_ID']) ?></td>
            <td><?= htmlspecialchars($row['Full_Name']) ?></td>
            <td><?= htmlspecialchars($row['Email']) ?></td>

            <td>
                <?php
                    if ($row['Role_Name'] == 'admin') echo "🛡 Admin";
                    elseif ($row['Role_Name'] == 'user') echo "👤 User";
                    else echo "👀 Guest";
                ?>
            </td>

            <td><?= $row['Created_At']->format('Y-m-d') ?></td>

            <td>
                <form method="post" action="update_role.php" class="d-flex">
                    <input type="hidden" name="user_id" value="<?= $row['User_ID'] ?>">

                    <select name="role_id" class="form-select form-select-sm">
                        <option value="1" <?= $row['Role_Name']=='guest'?'selected':'' ?>>Guest</option>
                        <option value="2" <?= $row['Role_Name']=='user'?'selected':'' ?>>User</option>
                        <option value="3" <?= $row['Role_Name']=='admin'?'selected':'' ?>>Admin</option>
                    </select>

                    <button class="btn btn-success btn-sm ms-2">Save</button>
                </form>
            </td>
        </tr>
        <?php } ?>

        </tbody>
    </table>
</div>

</body>
</html>
