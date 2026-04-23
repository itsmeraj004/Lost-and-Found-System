<?php
include "db.php";
session_start();

// Must be logged in to delete anything
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $user_id = $_SESSION['user_id'];
    
    // SECURITY: Only delete if the item ID matches AND the user ID matches the creator
    $stmt = $conn->prepare("DELETE FROM items WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $id, $user_id);
    $stmt->execute();
    $stmt->close();
}

header("Location: dashboard.php");
exit();
?>