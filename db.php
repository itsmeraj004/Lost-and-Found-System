<?php
$conn = new mysqli("localhost", "root", "", "lost_found_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>