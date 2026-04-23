<?php
include "db.php";
include 'includes/header.php';

// Must be logged in
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(!isset($_GET['id'])){
    die("<h2 style='text-align:center; margin-top:40px;'>Invalid request: No ID provided</h2>");
}

$id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// SECURITY: Only fetch the item if it belongs to the logged-in user
$stmt = $conn->prepare("SELECT * FROM items WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 0){
    die("<h2 style='text-align:center; margin-top:40px; color: red;'>Access Denied: You do not own this item.</h2>");
}

$data = $result->fetch_assoc();
$stmt->close();

if(isset($_POST['update'])){
    $name = $_POST['name'];
    $desc = $_POST['desc'];
    $location = $_POST['location'];
    $status = $_POST['status'];
    $date = $_POST['date'];

    // SECURITY: Update applies only to the owner
    $update_stmt = $conn->prepare("UPDATE items SET item_name=?, description=?, location=?, status=?, item_date=? WHERE id=? AND user_id=?");
    $update_stmt->bind_param("sssssii", $name, $desc, $location, $status, $date, $id, $user_id);

    if($update_stmt->execute()){
        header("Location: dashboard.php");
        exit();
    }
    $update_stmt->close();
}
?>

<form method="POST" name="itemForm" onsubmit="return validateForm()">
    <h2 style="text-align:center;">Edit Your Item</h2>
    <input type="text" name="name" value="<?= htmlspecialchars($data['item_name']) ?>" required>
    <textarea name="desc" rows="4" required><?= htmlspecialchars($data['description']) ?></textarea>
    <input type="text" name="location" value="<?= htmlspecialchars($data['location']) ?>">

    <select name="status">
        <option value="lost" <?= $data['status']=="lost"?"selected":"" ?>>Lost</option>
        <option value="found" <?= $data['status']=="found"?"selected":"" ?>>Found</option>
    </select>

    <input type="date" name="date" value="<?= htmlspecialchars($data['item_date']) ?>">
    <button type="submit" name="update">Update Item</button>
</form>

<?php include 'includes/footer.php'; ?>