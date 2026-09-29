<?php
session_start();
if (!isset($_SESSION['company_id'])) {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Company Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="form-box">
    <h2>Welcome, <?= htmlspecialchars($_SESSION['company_name']) ?></h2>

    <div class="dashboard-links">
        <a href="post_job.php">Post Job</a>
        <a href="view_applicants.php">View Applicants</a>
        <a href="../logout.php">Logout</a>
    </div>
</div>
</body>
</html>
