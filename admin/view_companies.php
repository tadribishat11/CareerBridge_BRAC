<?php
session_start();
require '../DBconnect.php';
if (!isset($_SESSION['admin_id'])) { header("Location: ../login.php"); exit(); }

$company_result = $conn->query("SELECT company_id, company_name, username, location, industry FROM company ORDER BY company_id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Companies</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body { font-family: Arial; }
        .container { width:95%; max-width:1200px; margin:30px auto; padding:20px; background:#fff; border-radius:8px; box-shadow:0 0 10px rgba(0,0,0,0.1); }
        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid #ddd; padding:10px; text-align:center; }
        th { background:#007bff; color:white; }
        a.back-link { display:inline-block; margin-bottom:15px; color:#007bff; text-decoration:none; }
        a.button { padding:5px 10px; background:#007bff; color:#fff; border-radius:4px; text-decoration:none; margin:2px; }
        a.button:hover { background:#0056b3; }
        a.delete-button { background:#dc3545; }
        a.delete-button:hover { background:#a71d2a; }
    </style>
</head>
<body>
<div class="container">
    <h2>All Companies</h2>
    <a class="back-link" href="dashboard.php">Back to Dashboard</a>

    <?php if($company_result->num_rows==0): ?>
        <p>No companies found.</p>
    <?php else: ?>
    <table>
        <tr>
            <th>ID</th><th>Company Name</th><th>Username</th><th>Location</th><th>Industry</th><th>Actions</th>
        </tr>
        <?php while($row=$company_result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['company_id'] ?></td>
            <td><?= htmlspecialchars($row['company_name']) ?></td>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><?= htmlspecialchars($row['location']) ?></td>
            <td><?= htmlspecialchars($row['industry']) ?></td>
            <td>
                <a class="button" href="edit_company.php?id=<?= $row['company_id'] ?>">Edit</a>
                <a class="button delete-button" href="delete_company.php?id=<?= $row['company_id'] ?>" onclick="return confirm('Are you sure you want to delete this company?');">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php endif; ?>
</div>
</body>
</html>
