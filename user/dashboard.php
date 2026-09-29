<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
?>

?>
<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .dashboard-box { width: 300px; margin: 20px auto; padding: 20px; border:1px solid #ddd; border-radius:8px; background:#f9f9f9; text-align:center;}
        a.button { display:block; padding:10px; margin:10px 0; background:#007bff; color:white; text-decoration:none; border-radius:5px;}
    </style>
</head>
<body>
<div class="form-box">
    <h2>Welcome, <?= htmlspecialchars($_SESSION['name']) ?></h2>

    <div class="dashboard-links">
        <a href="view_jobs.php">View Jobs</a>
        <a href="view_applications.php">View Applications</a>
        <a href="review.php">Submit Review</a>
        <a href="../logout.php">Logout</a>
    </div>
</div>
</body>
</html>
