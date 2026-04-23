<?php include 'includes/header.php'; ?>

<div class="hero">
    <h1>Find Your Lost Items Easily</h1>
    <p>A smart campus solution for lost & found management system</p>
    
    <div style="width: 250px; display: flex; flex-direction: column; gap: 15px;">
        <a href="dashboard.php" class="btn" style="background: #1f2d3d;">Browse Items</a>
        
        <?php if(!isset($_SESSION['user_id'])): ?>
            <a href="login.php" class="btn">Login to Report</a>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>