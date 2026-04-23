<?php
include "db.php";
include 'includes/header.php';

if(isset($_POST['register'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if($stmt->execute()){
        header("Location: login.php");
        exit();
    } else {
        echo "<p style='text-align:center; color:red; margin-top:20px;'>Error: " . $conn->error . "</p>";
    }
    $stmt->close();
}
?>

<form method="POST">
    <h2 style="text-align:center;">Register</h2>
    <input type="text" name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="register">Register</button>
</form>

<?php include 'includes/footer.php'; ?>