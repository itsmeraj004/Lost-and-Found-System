<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lost & Found System</title>
    <link rel="stylesheet" href="assets/style.css?v=<?= time(); ?>">
</head>
<body>

<div class="navbar">
    <div class="logo">Lost & Found</div>
    <div class="menu">
        <a href="index.php">Home</a>
        
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="dashboard.php">Dashboard</a>
            <a href="add_item.php">Add Item</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </div>
</div>