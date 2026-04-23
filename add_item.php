<?php
include "db.php";
include 'includes/header.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(isset($_POST['add'])){
    $name = $_POST['name'];
    $desc = $_POST['desc'];
    $location = $_POST['location'];
    $status = $_POST['status'];
    $date = $_POST['date'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO items (user_id, item_name, description, location, status, item_date) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $user_id, $name, $desc, $location, $status, $date);

    if($stmt->execute()){
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<p style='text-align:center; color:red; margin-top:20px;'>Error: " . $conn->error . "</p>";
    }
    $stmt->close();
}
?>

<form method="POST" name="itemForm" onsubmit="return validateForm()">
    <h2 style="text-align:center;">Add Item</h2>
    <input type="text" name="name" placeholder="Item Name" required>
    <textarea name="desc" placeholder="Description" rows="4" required></textarea>
    <input type="text" name="location" placeholder="Location">
    
    <select name="status">
        <option value="lost">Lost</option>
        <option value="found">Found</option>
    </select>

    <input type="date" name="date">
    <button type="submit" name="add">Add Item</button>
</form>

<?php include 'includes/footer.php'; ?>