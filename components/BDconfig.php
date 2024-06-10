<?php
$servername = "bfiehqs1aihym0r07gsk-mysql.services.clever-cloud.com";
$database = "bfiehqs1aihym0r07gsk";
$username = "udmjfy09zp9qiswj";
$password = "CgP5nagvTeoZ4oPbSban";
// crear connection
$conn = mysqli_connect($servername, $username, $password, $database);
// comprobar connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "<script>console.log('Connected successfully');</script>";
