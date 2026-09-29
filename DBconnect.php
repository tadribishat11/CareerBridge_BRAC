<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "CareerBridge_brac";

$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Connection Failed: ". $conn->connect_error);
}else{
    // echo "Connection Established";
    mysqli_select_db($conn, $dbname);
}
?>