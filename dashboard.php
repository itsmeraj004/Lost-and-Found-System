<?php
include "db.php";
include 'includes/header.php';

// Fetch all items regardless of login status
$sql = "SELECT * FROM items ORDER BY id DESC";
$result = $conn->query($sql);
?>

<div class="dashboard-header">
    <h2>Lost & Found Database</h2>
    <p>Browse recently reported items across the campus.</p>
    
    <?php if(!isset($_SESSION['user_id'])): ?>
        <p style="color: #dc2626; font-size: 14px; margin-top: 10px;">
            <a href="login.php" style="color: #0066cc; text-decoration: none; font-weight: bold;">Log in</a> to report a new item or manage your listings.
        </p>
    <?php endif; ?>
</div>

<div class="container">
    <?php 
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) { 
            $badgeClass = (strtolower($row['status']) == 'lost') ? 'badge-lost' : 'badge-found';
            
            // Check if the logged-in user owns this specific item
            $is_owner = isset($_SESSION['user_id']) && $_SESSION['user_id'] == $row['user_id'];
    ?>
        <div class="card" <?= $is_owner ? 'style="border: 2px solid #20c997;"' : '' ?>>
            <div class="card-header">
                <h3>
                    <?= htmlspecialchars($row['item_name']) ?>
                    <?php if($is_owner): ?>
                        <span style="font-size: 12px; color: #20c997; display: block; margin-top: 4px;">(Your Item)</span>
                    <?php endif; ?>
                </h3>
                <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($row['status']) ?></span>
            </div>

            <div class="card-desc">
                <?= nl2br(htmlspecialchars($row['description'])) ?>
            </div>
            
            <div class="card-meta">
                <span>📍</span>
                <div>
                    <strong>Location:</strong> <br>
                    <?= htmlspecialchars($row['location']) ?>
                </div>
            </div>

            <?php if(!empty($row['item_date']) && $row['item_date'] != '0000-00-00'): ?>
            <div class="card-meta">
                <span>📅</span>
                <div>
                    <strong>Date:</strong> <?= htmlspecialchars($row['item_date']) ?>
                </div>
            </div>
            <?php endif; ?>

            <?php if($is_owner): ?>
            <div class="card-actions">
                <a href="edit_item.php?id=<?= $row['id'] ?>" class="btn-action btn-edit">✏️ Edit</a>
                <a href="delete_item.php?id=<?= $row['id'] ?>" class="btn-action btn-delete" onclick="return confirm('Are you sure you want to delete your item?');">🗑️ Delete</a>
            </div>
            <?php endif; ?>
        </div>
    <?php 
        } 
    } else {
        echo "<div style='text-align: center; width: 100%; margin-top: 50px; color: #6b7280;'>";
        echo "<h3>No items reported yet.</h3>";
        echo "</div>";
    }
    ?>
</div>

<?php include 'includes/footer.php'; ?>