<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .dashboard-box { width: 300px; margin: 20px auto; padding: 20px; border:1px solid #ddd; border-radius:8px; background:#f9f9f9; text-align:center;}
        a.button { display:block; padding:10px; margin:10px 0; background:#007bff; color:white; text-decoration:none; border-radius:5px;}
    </style>
</head>
<body>
<div class="dashboard-box">
    <h2>Welcome, <?= $_SESSION['admin_name'] ?></h2>

    <a class="button" href="view_users.php">View Users</a>
    <a class="button" href="view_companies.php">View Companies</a>
    <a class="button" href="view_opportunities.php">View Opportunities</a>
    <br>
    <a class="button" href="create_probability_analysis.php"> Sync Probability Analysis </a>

    <a class="button" href="probability_analysis.php">Set Probability Scores</a>

    <a href="../logout.php">Logout</a>
</div>
</body>
</html>
