<?php
$database = "exam";
$port = 3307;
$hostname = "root";
$host = "localhost";
$password = "";

$conn = new mysqli($host, $hostname, $password, $database, $port);

if($conn->connect_error){
    die("connection failed" . $conn->error);
}



?>