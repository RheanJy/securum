<?php
$servername = "localhost";  
$username = "root"; 
$password = "1234";
$dbname = "usc_bookingvisitors"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?>