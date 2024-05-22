<?php
$servername = "bfiehqs1aihym0r07gsk-mysql.services.clever-cloud.com";
$database = "bfiehqs1aihym0r07gsk";
$username = "udmjfy09zp9qiswj";
$password = "passwCgP5nagvTeoZ4oPbSbanord";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
mysqli_close($conn);
?>