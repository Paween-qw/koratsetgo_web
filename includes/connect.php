<?php
$serverName = "DESKTOP-ND02RTC\\SQLEXPRESS"; 
$database   = "KoratSetGo_DB";
$username   = "qawsallapw";
$password   = "gufiwinwza007";

$connectionOptions = array(
    "Database" => $database,
    "Uid" => $username,
    "PWD" => $password,
    "CharacterSet" => "UTF-8"
);

$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>
